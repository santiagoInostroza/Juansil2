<div class='grid grid-cols-1 gap-4 md:grid-cols-8 '>
    <section class="col-span-1 md:col-span-6">
        <div class="grid gap-4 ">
        {{-- BUSCADOR DE PRODUTOS --}}
            <article>
                <div class="flex items-center gap-4">
                    <div class="flex-1">
                        <x-selects.select :collection="$products" :placeholder="'Buscar un producto'" wire:model="product_id" :event="'addProductToSession'"></x-selects-select>
                    </div>
                    <div id='dropdown_product' x-data="{dropdown:@entangle('productModal')}" >
                        <div x-on:click='dropdown=true'>
                            <i class="p-4 cursor-pointer fas fa-plus"></i>
                        </div>
                        <div x-show='dropdown' x-cloak >
                            <div class='absolute p-4 bg-white rounded shadow'>
                                <x-modals.screen>
                                    <x-slot name="header">
                                        <div class="flex items-center justify-between gap-4 p-4">
                                            <h2> Crear producto nuevo</h2>
                                            <i class="p-4 font-thin cursor-pointer fas fa-times hover:font-bold" x-on:click="dropdown = false"></i>
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
                @if (session()->has('purchase.items') && count(session('purchase.items')) >0)
                    <x-tables.table>
                        <x-slot name='thead'>
                            <x-tables.tr class="bg-indigo-200 shadow hover:bg-indigo-200">
                                <x-tables.th class="px-1 py-2">Item</x-table.th>
                                <x-tables.th class="text-left px-1 py-2">Nombre</x-tables.th>
                                <x-tables.th class="text-right px-1 py-2">Stock</x-tables.th>
                                <x-tables.th class="text-left px-1 py-2">Cantidad</x-tables.th>
                                <x-tables.th class="text-left px-1 py-2">Cant x caja</x-tables.th>
                                <x-tables.th class="text-left px-1 py-2">Total</x-tables.th>
                                <x-tables.th class="text-left px-1 py-2">Precio</x-tables.th>
                                <x-tables.th class="text-left px-1 py-2">Precio x caja</x-tables.th>
                                <x-tables.th class="text-left px-1 py-2">Total</x-tables.th>
                               
                                <x-tables.th></x-table.th>
                            </x-tables.tr>
                        </x-slot>
                        <x-slot name='tbody'>
                                {{-- {{var_dump(session('purchase.items'))}} --}}
                                @foreach (session('purchase.items') as  $key =>  $item)
                               {{-- {{var_dump($item)}}  --}}
                                    <x-tables.tr class="shadow hover:bg-indigo-50"  
                                        x-data="{ 
                                            quantity:'{{ $item['quantity'] }}', 
                                            quantity_box:'{{ $item['quantity_box'] }}', 
                                            total_quantity:'{{ $item['total_quantity'] }}', 
                                            price:'{{ $item['price'] }}', 
                                            price_box:'{{ $item['price_box'] }}', 
                                            total_price:'{{ $item['total_price'] }}',
                                            expired_date:'{{ $item['expired_date'] }}',
                                            {{-- loading:false, --}}
                                            getTotal: function(){
                                                {{-- this.loading=true; --}}
                                               
                                                this.total_quantity =  this.quantity * this.quantity_box;
                                                this.total_price = this.total_quantity * this.price;
                                                this.price_box = this.price * this.quantity_box;
                                                this.$wire.setPurchase('{{$key}}',this.quantity, this.quantity_box, this.total_quantity, this.price, this.price_box, this.total_price, this.expired_date)
                                                .then(()=>{
                                                    {{-- this.loading=false; --}}
                                                });
                                               
                                            },
                                            getTotal2: function(){
                                                {{-- this.loading=true; --}}
                                                this.total_quantity =  this.quantity * this.quantity_box;
                                                if(this.quantity_box != 0){
                                                    this.price = this.price_box / this.quantity_box;
                                                }
                                                this.total_price = this.total_quantity * this.price;
                                                this.$wire.setPurchase('{{$key}}',this.quantity, this.quantity_box, this.total_quantity, this.price, this.price_box, this.total_price, this.expired_date).then(()=>{
                                                    {{-- this.loading=false; --}}
                                                });
                                               
                                            },
                                        }"
                                        x-init=""
                                    >
                                        <x-tables.td class="p-0"> {{$loop->iteration}} </x-tables.td>
                                        <x-tables.td class="p-0">
                                            <div class="flex items-center gap-1" title="id {{ $item['product_id'] }}">
                                                <figure class="w-12">
                                                    <img src="{{ Storage::url( $item['image_url']) }}" alt="{{ $item['name'] }}" class="object-cover w-12 h-12 mr-2 duration-1000 rounded-full hover:scale-150">
                                                </figure>
                                                {{$item['name']}}
                                            </div>
                                        </x-tables.td>
                                        <x-tables.td class="text-right p-1">{{$item['stock']}}</x-tables.td>
                                        <x-tables.td class=" p-0"> 
                                            
                                            <x-jet-input type="number" x-on:keyup.debounce.600ms="getTotal()" min="0"  class="w-20 h-6 text-sm" x-model="quantity"></x-jet-input>
                                        </x-tables.td>
                                        <x-tables.td class="p-0"> 
                                            <x-jet-input type="number" x-on:keyup.debounce.600ms="getTotal()" min="0"  class="w-20 h-6 text-sm" x-model="quantity_box"></x-jet-input>
                                        </x-tables.td>
                                        <x-tables.td> <span x-text="number_format(total_quantity)"></span></x-tables.td>
                                        <x-tables.td class="p-0"> 
                                            <x-jet-input type="number" x-on:keyup.debounce.600ms="getTotal()" min="0"  class="w-24 h-6 text-sm" x-model="price"></x-jet-input>
                                        </x-tables.td>
                                        <x-tables.td class="p-0"> 
                                            <x-jet-input type="number" x-on:keyup.debounce.600ms="getTotal2()"  min="0"  class="w-24 h-6 text-sm" x-model="price_box"></x-jet-input>
                                        </x-tables.td>
                                        <x-tables.td class="p-0"> $ <span x-text="number_format(total_price)"></span></x-tables.td>

                                                                      

                                        <x-tables.td>                                                 
                                                <div id="{{$item['name']}}" x-data="{show:false,loading2:false}">
                                                    <span x-on:click="show= !show" class="p-1 font-bold cursor-pointer  hover:text-green-400"> ⁞ </span>
                                                    <div x-cloak x-show="show" x-transition x-on:click.away="show=false">
                                                        <div class="absolute flex items-start gap-8 p-2 px-4 -translate-x-full -translate-y-3/4  bg-white rounded-md shadow-md " >
                                                            
                                                            <div class="flex flex-col ">
                                                                <span >Fecha de vencimiento</span>
                                                                <x-jet-input class="p-1" type="date" x-model="expired_date" x-on:change="getTotal()"></x-jet-input>  
                                                            </div>

                                                            <div class="text-red-500  flex flex-col relative p-2 pt-0" >
                                                                <span class="mb-2">Quitar producto</span>
                                                                <div x-on:click="loading2=true;$wire.removeFromPurchase('{{ $item['name'] }}').then( ()=>{loading2=false})"  class="w-4 cursor-pointer">
                                                                    <svg  fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                    </svg>  
                                                                </div>
                                                                <div x-cloak x-show="loading2" >
                                                                    <div class='absolute inset-0 z-10 bg-gray-200 opacity-50' ></div>
                                                                    <div class='absolute inset-0 z-10 flex items-center justify-center'>
                                                                        <div class='text-gray-800'>
                                                                            <i class='text-4xl fas fa-spinner animate-spin'></i>
                                                                        </div>
                                                                    </div>
                                                                </div>                         
                                                            </div>
                                                            <div x-on:click="show = false" class="cursor-pointer p-1 pt-0">
                                                                <i class="fas fa-times"></i>
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
    <section class="col-span-1 bg-white md:col-span-2">
        
        <div class="grid gap-4 p-4 bg-white rounded shadow-md">
            {{-- PROVEEDOR --}}
            <div>
                <div class="flex items-center justify-between gap-x-2">
                    <div class="flex-1">
                        <x-selects.select :placeholder="'Selecciona un proveedor'" :collection='$suppliers' wire:model='supplier_id'/>
                    </div>
                    <div id='dropdown_supplier' x-data="{dropdown:@entangle('supplierModal')}" >
                        <div x-on:click='dropdown=true'>
                            <i class="p-4 cursor-pointer fas fa-plus"></i>
                        </div>
                        <div x-show='dropdown' x-cloak >
                            <div class='absolute p-4 bg-white rounded shadow'>
                                <x-modals.screen>
                                    <x-slot name="body">
                                        <div class="flex items-center justify-between gap-4 p-4">
                                            <h2> Crear proveedor nuevo</h2>
                                            <i class="p-4 font-thin cursor-pointer fas fa-times hover:font-bold" x-on:click="dropdown = false"></i>
                                        </div>
                                        <livewire:admin.suppliers.create :redirect="false" />
                                    </x-slot>
                                </x-modals.screen>

                                
                            </div>
                        </div>
                    </div>
                </div>
                @error('supplier_id')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
            </div>    

            {{-- FECHA DE COMPRA --}}
            <div>
                <label>
                    <x-jet-input type="datetime-local" class='w-full p-2 border-gray-200 border sm:rounded-lg' wire:model='date'></x-jet-input>
                    @error('date')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
                </label>
            </div>

            {{-- COMENTARIO --}}
            <textarea class="border-gray-200 rounded border sm:rounded-lg" placeholder="Comentario" wire:model.lazy="comment"></textarea>
            
            <div class="w-full border-b-2 border-gray-600">
            </div>

            <div class="flex justify-between font-bold text-gray-600 gap-x-4">
                <label>Total </label>
                <span>$ {{number_format((session()->has('purchase.total'))? session('purchase.total'): 0 ,0,',','.')}}</span>
                
            </div>
            
            <x-jet-button wire:loading.attr="disabled" wire:click="save">Crear</x-jet-button>                        
            
        
        </div>

    </section>     
</div>
