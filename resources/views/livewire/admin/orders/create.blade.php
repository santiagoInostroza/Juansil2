
<div class="h-full" style="height: calc(100vh - 170px)" >
    <div class="flex flex-col flex-wrap md:grid grid-cols-1 md:grid-cols-12 gap-4 ">
        <section class="md:col-span-8 overflow-auto flex flex-col gap-4" style="max-height: calc(100vh - 170px)">
            <article>
                <div>
                    <x-selects.select :placeholder="'Selecciona producto'" :collection='$products' wire:model='product_id' :event="'addItemToOrder'"/>
                </div>
            </article>
            <article>
                <div>
                    @if (session()->has('order.items') && count(session('order.items')) >0)
                        <x-tables.table>
                            <x-slot name='thead'>
                                <x-tables.tr class="bg-indigo-200 hover:bg-indigo-200 shadow">
                                    <x-tables.th>Item</x-table.th>
                                    <x-tables.th class="text-left">Nombre</x-tables.th>
                                    <x-tables.th class="text-right">Stock</x-tables.th>
                                    <x-tables.th class="text-left">Cantidad</x-tables.th>
                                    <x-tables.th class="text-left">Cant x caja</x-tables.th>
                                    <x-tables.th class="text-left">Cant total</x-tables.th>
                                    <x-tables.th class="text-left">Precio</x-tables.th>
                                    <x-tables.th class="text-left">Precio x caja</x-tables.th>
                                    <x-tables.th class="text-left">Precio total</x-tables.th>
                                    <x-tables.th></x-table.th>
                                </x-tables.tr>
                            </x-slot>
                            <x-slot name='tbody'>
                                @foreach (session('order.items') as $product_id => $item)
                                
                                    <x-tables.tr class="shadow hover:bg-indigo-50"  
                                        id="item_{{$product_id}}"
                                        x-data="{ 
                                            quantity:'{{ $item['quantity'] }}', 
                                            quantity_box:'{{ $item['quantity_box'] }}', 
                                            total_quantity:'{{ $item['total_quantity'] }}', 
                                            price:'{{ $item['price'] }}', 
                                            price_box:'{{ $item['price_box'] }}', 
                                            total_price:'{{ $item['total_price'] }}',
                                            loading:false,
                                            getTotal: function(){
                                                this.loading=true;
                                                this.total_quantity =  this.quantity * this.quantity_box;
                                                this.total_price = this.total_quantity * this.price;
                                                this.price_box = this.price * this.quantity_box;
                                                this.$wire.setItemFromOrder('{{$product_id}}',this.quantity, this.quantity_box, this.total_quantity, this.price, this.price_box, this.total_price).then(()=>{
                                                    this.loading=false;
                                                });
                                            },
                                            getTotal2: function(){
                                                this.loading=true;
                                                this.total_quantity =  this.quantity * this.quantity_box;
                                                if(this.quantity_box != 0){
                                                    this.price = this.price_box / this.quantity_box;
                                                }
                                                this.total_price = this.total_quantity * this.price;
                                                this.$wire.setItemFromOrder('{{$product_id}}',this.quantity, this.quantity_box, this.total_quantity, this.price, this.price_box, this.total_price).then(()=>{
                                                    this.loading=false;
                                                });
                                            },
                                        }"
                                        x-init="console.log('init')"
                                    >
                                        <x-tables.td> {{$loop->iteration}} </x-tables.td>
                                        <x-tables.td>
                                            <div class="flex gap-1 items-center" title="id {{ $item['product_id'] }}">
                                                <figure class="w-12">
                                                    <img src="{{ Storage::url( $item['image_url']) }}" alt="{{ $item['name'] }}" class="w-12 h-12 rounded-full mr-2 object-cover hover:scale-150 duration-1000">
                                                </figure>
                                                {{$item['name']}}
                                            </div>
                                        </x-tables.td>
                                        <x-tables.td class="text-right">{{$item['stock']}}</x-tables.td>
                                        <x-tables.td> 
                                            
                                            <x-jet-input type="number" x-on:keyup.debounce.600ms="getTotal()" min="0"  class="w-20 h-6 text-sm" x-model="quantity"></x-jet-input>
                                        </x-tables.td>
                                        <x-tables.td> 
                                            <x-jet-input type="number" x-on:keyup.debounce.600ms="getTotal()" min="0"  class="w-20 h-6 text-sm" x-model="quantity_box"></x-jet-input>
                                        </x-tables.td>
                                        <x-tables.td> <span x-text="number_format(total_quantity)"></span></x-tables.td>
                                        <x-tables.td> 
                                            <x-jet-input type="number" x-on:keyup.debounce.600ms="getTotal()" min="0"  class="w-20 h-6 text-sm" x-model="price"></x-jet-input>
                                        </x-tables.td>
                                        <x-tables.td> 
                                            <x-jet-input type="number" x-on:keyup.debounce.600ms="getTotal2()"  min="0"  class="w-24 h-6 text-sm" x-model="price_box"></x-jet-input>
                                        </x-tables.td>
                                        <x-tables.td> $ <span x-text="number_format(total_price)"></span></x-tables.td>
                                        <x-tables.td> 
                                            <div class="text-red-500  cursor-pointer" >
                                                <svg wire:click="removeItemFromOrder( '{{ $product_id }}' )" class="w-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>   
                                                <div x-cloak x-cloack x-show="loading" >
                                                    <div class='absolute inset-0 bg-gray-200 z-10 opacity-50' ></div>
                                                    <div class='absolute inset-0 flex justify-center items-center z-10'>
                                                        <div class='text-gray-800'>
                                                            <i class='fas fa-spinner animate-spin text-4xl'></i>
                                                        </div>
                                                    </div>
                                                </div>                         
                                            </div>
                                        </x-tables.td>
                                    </x-tables.tr>
                                @endforeach
                            </x-slot>
                        </x-tables.table>
                    @else
                        <div class="">
                            <p class="text-red-600">Aún no has agregado productos</p>
                        </div>
                    @endif
                </div>
            </article>

        </section>
        <section class="md:col-span-4 w-full  ">
            <div class="rounded-md overflow-auto grid gap-4 relative"  style="max-height: calc(100vh - 300px)">
                
                <div class="bg-white shadow-md rounded p-4 grid gap-4">
                    {{-- FECHA --}}
                    <div>
                        <label>
                            <x-jet-input type="datetime-local" class='w-full p-2 border border-gray-200  sm:rounded-lg' wire:model.defer='date'></x-jet-input>
                            @error('date')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
                        </label>
                    </div>
                    
                    {{-- SELECT CLIENTE --}}
                    <div>
                        <div class="flex justify-between gap-x-2 items-center">
                            <div class="flex-1">
                                <x-selects.select :placeholder="'Selecciona cliente'" :collection='$customers' wire:model='customer_id'/>
                            </div>
                            <div id='dropdown_customer' x-data="{dropdown:@entangle('customerModal')}" >
                                <div x-on:click='dropdown=true'>
                                    <i class="fas fa-plus p-4 cursor-pointer"></i>
                                </div>
                                <div x-show='dropdown' x-cloak >
                                    <div class='bg-white rounded shadow p-4 absolute'>
                                        <x-modals.basic>
                                            <x-slot name="body">
                                                <div class="flex justify-between gap-4 items-center p-4">
                                                    <h2> Crear cliente nuevo</h2>
                                                    <i class="fas fa-times p-4 cursor-pointer font-thin hover:font-bold" x-on:click="dropdown = false"></i>
                                                </div>
                                                <livewire:admin.customers.create :redirect="false" />
                                            </x-slot>
                                        </x-modals.basic>

                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('customer_id')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
                    </div>  
                </div>

                {{-- DELIVERY --}}
                <div class="bg-white shadow-md rounded grid px-4 py-2 gap-4">
                    <div id="rand()" x-data="{ openDelivery:@entangle('delivery')  }">
                        @if ($customer)
                            <label class="flex items-center gap-4 justify-between">
                                <div class='p-1 '>Delivery</div>
                                <div class='switch'>
                                    <input  type='checkbox' wire:model="delivery">
                                    <span class='slider round'></span> 
                                </div>                    
                            </label>
                        @endif
                        
                        <div x-cloak x-show="openDelivery" x-transition class="grid gap-4 ">

                            <div class="border-t mt-2"></div>
                            {{-- ETAPA DELIVERY --}}
                            <label class="flex gap-4 items-center justify-between">
                                @if ($delivery_stage)
                                    <div class='py-1'>Entregado</div>
                                @else
                                    <div class='py-1'>Marcar como entregado</div>
                                @endif
                                
                                <div class='switch'>
                                    <input  type='checkbox' wire:model="delivery_stage">
                                    <span class='slider round'></span> 
                                </div>
                            
                            </label>
                        
                    
                        
                            {{-- FECHA DELIVERY --}}
                            <label>
                                <div class='py-1'>Fecha entrega</div>
                                <x-jet-input class='w-full p-2 border' type="date" wire:model.debounce.800ms='delivery_date'></x-jet-input>
                                @error('delivery_date')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
                            </label>
                        
                        
                            {{-- DIRECCION CLIENTE --}} 
                        
                            <label for=''>
                                <div class='pt-1'>Dirección {{ ($addresses) ? '('. $addresses->count().')' : ''}}</div>
                                <div class="flex items-center  justify-between">
                                    <div class="flex-1">
                                        <x-selects.select :placeholder="'Selecciona dirección'" :collection='$addresses' wire:model='address_id'/>
                                        @error('address_id')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
  
                                    </div>
                                    <div class="flex justify-end">
                                        <div id='dropdown_address_modal' x-data="{dropdown:@entangle('addressModal')}" >
                                        
                                            <div x-on:click='dropdown=true' class="">
                                                <i class="fas fa-plus p-4 cursor-pointer"></i>
                                            </div>
                                        
                                            <div x-show='dropdown' >
                                                <div class='bg-white rounded shadow p-4 absolute'>
                                                    <x-modals.basic>
                                                        <x-slot name='header'>
                                                            <div class="flex justify-between gap-4 p-4 items-center bg-gray-100">
                                                                <h2 class=""> Agregar dirección</h2>
                                                                <i x-on:click="dropdown = false" class="fas fa-times cursor-pointer p-2"></i>
                                                                
                                                            </div>
                                                        </x-slot>
                                                        <x-slot name='body'>
                                                            <div  >
                                                                <livewire:admin.addresses.create :customer="$customer" :redirect="false" :wire:key="rand()" />
                                                            </div>
                                                        </x-slot>
                                                    </x-modals.basic>
                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                            </label>

                             {{-- VALOR DELIVERY --}}
                             <label>
                                <div class='py-1'>Valor entrega</div>
                                <x-jet-input class='w-full p-2 border' type="number" min="0" wire:model.debounce.400ms='delivery_value'></x-jet-input>
                                @error('delivery_value')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
                            </label>

                        </div>
                    </div> 
                </div>
                
                    {{-- COMENTARIO --}}
                <div class="bg-white shadow-md rounded p-4 py-2 grid gap-4">
                    <div>
                        <label class="flex items-center gap-4 justify-between">
                            <div class='p-1'>Comentario</div>
                            <div class='switch'>
                                <input  type='checkbox' wire:model="openComment">
                                <span class='slider round'></span> 
                            </div>                    
                        </label>
                        <div x-data="{openComment:@entangle('openComment')}">
                            <div x-cloak x-show="openComment" x-transition>
                                <textarea class="rounded border border-gray-200  sm:rounded-lg w-full" placeholder="Comentario" wire:model.debounce.800ms="comment"></textarea>
                            </div>                    
                        </div>                
                    </div>
                </div>

                    {{-- PAYMENT --}}
                <div class="bg-white shadow-md rounded p-4 py-2 grid gap-4">
                    <div x-data="{payment_account:@entangle('showPaymentAccount')}" class="grid gap-4">
                        {{-- PAYMENT STATUS --}}
                        <div>
                            <div class='my-2 mb-4'>Pago:</div>
                        
                            <div class="flex items-center gap-4">
                            
                                <label>
                                    <input type="radio" name="payment_status" id="" value="0"  wire:model="payment_status">
                                    Pendiente
                                </label>
                                <label>
                                    <input type="radio" name="payment_status" id="" value="1" wire:model="payment_status">
                                    Abonado
                                </label>
                                <label>
                                    <input type="radio" name="payment_status" id="" value="2"  wire:model="payment_status">
                                    Pagado
                                </label>
                                {{-- <label>
                                    <input type="radio" name="payment_status" id="" value="3"  wire:model="payment_status">
                                    Otro
                                </label> --}}
                                
                            </div>
                        @if ($payment_status==1)
                            <div>
                                <div class='my-4 mb-4'>
                                    Monto abonado
                                </div>
                                <x-jet-input wire:model="payment_amount" class="w-full border border-gray-200 rounded-md" type="number"></x-jet-input>
                                @error('payment_amount')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
                            </div>
                        @endif
                        </div>
                        {{-- PAYMENT ACCOUNT --}}
                        <div>
                            <div x-cloak x-show="payment_account" x-transition>
                                <div class="border-t my-2"></div>
                                
                                <div class='my-4'>Metodo de pago:</div>
                                <div class="">
                                    <div class="flex items-center gap-4">
                                        <label>
                                            <input type="radio" name="payment_account" id="" value="0"  wire:model="payment_account">
                                            Efectivo
                                        </label>
                                        <label>
                                            <input type="radio" name="payment_account" id="" value="1" wire:model="payment_account">
                                            Juansil
                                        </label>
                                        <label>
                                            <input type="radio" name="payment_account" id="" value="2"  wire:model="payment_account">
                                            Ef. y trans.
                                        </label>
                                        <label>
                                            <input type="radio" name="payment_account" id="" value="3"  wire:model="payment_account">
                                            Otro
                                        </label>

                                    </div>

                                    <div class="border-t my-2 mt-4"></div>
                                    <textarea wire:model.debounce.800ms="payment_account_comment" placeholder="Comentario sobre el pago" class="border-gray-200  rounded-md w-full mt-4 bg-white"></textarea>
                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

               

               
            
            </div>
            <div class="h-4 w-full bg-gray-100"></div>
            {{-- TOTAL --}}
            <div class="bg-white shadow-md rounded p-4 py-2 ">
              
                {{-- TOTAL --}}
          
                    <div class="grid grid-cols-2 justify-between gap-x-4  text-gray-600">
                        <label>Subtotal </label>
                        <span class="text-right">$ {{number_format((session()->has('order.total'))? session('order.total'): 0 ,0,',','.')}}</span>
                        <label>Delivery </label>
                        <span class="text-right">$ {{number_format( $delivery_value ,0,',','.') }}</span>
                        <label class="font-bold text-lg">Total </label>
                        <span class="text-right font-bold text-lg">$ {{number_format((session()->has('order.total'))? session('order.total') + $delivery_value  : 0 ,0,',','.')}}</span>
                    </div>
              
                
                {{-- BOTON --}}
                <x-jet-button class="w-full" wire:click="save">Crear</x-jet-button>    
            
            </div>
        </section>
    </div>

   
    
</div>
