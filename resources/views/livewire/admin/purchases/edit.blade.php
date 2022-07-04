<div class='grid grid-cols-1 md:grid-cols-8 gap-4 '>
    <section class="col-span-1 md:col-span-6">
        <div class="grid gap-4 ">
         
        {{-- BUSCADOR DE PRODUTOS --}}
            <article>
                <div class="flex gap-4 items-center">
                    <div class="flex-1">
                        <x-selects.select :collection="$products" :placeholder="'Buscar un producto'" wire:model="product_id" :event="'addProductToSession'"></x-selects-select>
                    </div>
                    <div id='dropdown_product' x-data="{dropdown:@entangle('productModal')}" >
                        <div x-on:click='dropdown=true'>
                            <i class="fas fa-plus p-4 cursor-pointer"></i>
                        </div>
                        <div x-show='dropdown' x-cloak >
                            <div class='bg-white rounded shadow p-4 absolute'>
                                <x-modals.screen>
                                    <x-slot name="header">
                                        <div class="flex justify-between gap-4 items-center p-4">
                                            <h2> Crear producto nuevo</h2>
                                            <i class="fas fa-times p-4 cursor-pointer font-thin hover:font-bold" x-on:click="dropdown = false"></i>
                                        </div>
                                    </x-slot>
                                    <x-slot name="body">
                                        <livewire:admin.products.create :redirect="false" />
                                    </x-slot>
                                    <x-slot name="footer"></x-slot>
                                </x-modals.screen>

                                
                            </div>
                        </div>
                    </div>
                </div>
            </article>
            {{-- NUEVA COMPRA --}}
            <article class="overflow-auto">
                @if (count($items) >0)
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
                                
                                @foreach ($items as  $key =>  $item)
                                    <x-tables.tr class="shadow hover:bg-indigo-50" 
                                        id="item_{{$key}}"
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
                                                this.$wire.setPurchase('{{$key}}',this.quantity, this.quantity_box, this.total_quantity, this.price, this.price_box, this.total_price).then(()=>{
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
                                                this.$wire.setPurchase('{{$key}}',this.quantity, this.quantity_box, this.total_quantity, this.price, this.price_box, this.total_price).then(()=>{
                                                    this.loading=false;
                                                });
                                            },
                                        }"
                                        {{-- x-init="console.log('init')" --}}
                                    >
                                    <x-tables.td> {{$loop->iteration}} </x-tables.td>
                                    <x-tables.td>
                                        <div class="flex gap-1 items-center" title="id {{ $item['product']['id'] }}">
                                            <figure class="w-12">
                                                <img src="{{ Storage::url( $item['product']['image']['url']) }}" alt="{{ $item['product']['name'] }}" class="w-12 h-12 rounded-full mr-2 object-cover hover:scale-150 duration-1000">
                                            </figure>
                                            {{$item['product']['name'] }}
                                        </div>
                                    </x-tables.td>
                                    <x-tables.td class="text-right">{{$item['product']['stock']}}</x-tables.td>
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
                                            <svg wire:click="removeFromPurchase( '{{ $key }}','{{$item['product']['name']}}' )" class="w-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
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
            </article>
        
        </div>

    </section>


    {{-- DATOS DE LA COMPRA --}}
    <section class="bg-white col-span-1 md:col-span-2">
        
        <div class="bg-white shadow-md rounded p-4 grid gap-4">
            <div>
                <div class="flex justify-between gap-x-2 items-center">
                    <div class="flex-1">
                        <x-selects.select :placeholder="'Selecciona un proveedor'" :collection='$suppliers' wire:model='purchase.supplier_id'/>
                    </div>
                    <div id='dropdown_supplier' x-data="{dropdown:@entangle('supplierModal')}" >
                        <div x-on:click='dropdown=true'>
                            <i class="fas fa-plus p-4 cursor-pointer"></i>
                        </div>
                        <div x-show='dropdown' x-cloak >
                            <div class='bg-white rounded shadow p-4 absolute'>
                                <x-modals.screen>
                                    <x-slot name="body">
                                        <div class="flex justify-between gap-4 items-center p-4">
                                            <h2> Crear proveedor nuevo</h2>
                                            <i class="fas fa-times p-4 cursor-pointer font-thin hover:font-bold" x-on:click="dropdown = false"></i>
                                        </div>
                                        <livewire:admin.suppliers.create :redirect="false" />
                                    </x-slot>
                                </x-modals.screen>

                                
                            </div>
                        </div>
                    </div>
                </div>
                @error('supplier_id')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
            </div>    

            <div>
                <label>
                   
                    <x-jet-input type="datetime-local" class='w-full p-2 border-gray-100 shadow-md sm:rounded-lg' wire:model='purchase.date'></x-jet-input>
                    @error('date')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
                </label>
            </div>

            <textarea class="rounded border-gray-100 shadow-md sm:rounded-lg" placeholder="Comentario" wire:model.defer="purchase.comment"></textarea>
            
            <div class="w-full border-b-2 border-gray-600">
            </div>

            <div class="flex justify-between gap-x-4 font-bold text-gray-600">
                <label>Total </label>
                <span>$ {{ number_format($total,0,',','.') }}</span>
                
            </div>
            
            <x-jet-button wire:click="update">Actualizar</x-jet-button>                        
            
        
        </div>

    </section>     
</div>
