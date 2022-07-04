<div>
    <article class="grid grid-cols-12 gap-4 text-gray-900">
        <section class="col-span-12 md:col-span-8 2xl:col-span-9">
            <article class="grid grid-cols-1 gap-4 2xl:grid-cols-2 ">

                {{-- IMAGEN --}}
                <section class="grid gap-4 p-6 bg-white rounded-md shadow-md">
                    <div
                        id='upload_image_'
                        x-data='{ isUploading: false, progress: 0 }'
                        x-on:livewire-upload-start='isUploading = true'
                        x-on:livewire-upload-finish='isUploading = false'
                        x-on:livewire-upload-error='isUploading = false'
                        x-on:livewire-upload-progress='progress = $event.detail.progress'
                        class='w-full'>
                        @if ($image)
                            <label class="cursor-pointer">
                                <div class='py-1'>Cambiar imagen</div>
                                <img class="object-cover w-full h-48 border-2 border-green-400 rounded shadow-lg " src='{{ $image->temporaryUrl() }}'>
                                <x-jet-input wire:model="image" class='hidden' type="file"></x-jet-input>
                            </label>
                        @else
                            <label class='cursor-pointer'>
                                <div class='py-1'>Imagen</div>
                                <img class="object-contain w-full h-48 border-2 border-green-400 rounded shadow-lg " src="{{ asset('images/products/sin_imagen.jpg')}}">
                                <x-jet-input wire:model="image" class='hidden' type="file"></x-jet-input>
                            </label>
                        @endif
                        <!-- Progress Bar -->
                        <div x-cloak x-show='isUploading' class='w-full'>
                            <progress max='200' x-bind:value='progress' class='w-full'></progress>
                        </div>
                        
                        @error('image')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
                    </div>
                        
            
                </section>

                {{-- NOMBRE --}}
                <section class="grid gap-4 | rounded-md shadow-md  p-6 bg-white ">
           
                    <div>
                        <label>
                            <span>Nombre</span>
                            <x-jet-input class='w-full p-2 border border-gray-300' placeholder='Ingresa el nombre' wire:model.defer='name'></x-jet-input>
                        </label>
                        @error('name')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
                    </div>
            
                    <div>
                        <label>
                            <span>Descripción</span>
                            <textarea class='w-full h-24 p-2 border border-gray-300 rounded' placeholder='Descripción opcional' wire:model.defer='description'></textarea>
                        </label>
                        @error('description')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
                    </div>
            
                </section>
                
                {{-- PRECIOS --}}
                <section class="grid gap-4 | rounded-md shadow-md  p-6 bg-white">
                    <div class="grid grid-cols-2 gap-4">
                        {{-- FORMATO --}}
                        <div>
                            <label>
                                <div class='flex items-center gap-2 mb-2'>
                                    <span> Formato de venta</span>
                                    {{-- tooltip product format  --}}
                                    <div id='tooltip_product_format' x-data='{tooltip:false}' x-on:mouseleave='tooltip=false' x-on:mouseover='tooltip=true'>
                                        <div  class="px-2 text-gray-600 bg-gray-200 rounded-full ">
                                            <i class="text-sm fas fa-question"></i>
                                        
                                            <div x-show='tooltip' x-cloak x-transition class="" >
                                                <div class='absolute w-48 p-4 text-sm bg-white rounded shadow -translate-x-1/3'>
                                                    <p class="text-sm text-gray-500">
                                                        Como venderas este producto: por caja, por unidad, pack, etc.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <x-selects.select :placeholder="'Selecciona un formato'" :collection='$formats' wire:model='product_format_id'/>
                            </label>
                            @error('product_format_id')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
                        </div>

                        {{-- CANTIDAD --}}
                        <div>
                            <label>
                                <div class="flex items-center gap-2 mb-2">
                                    <span> {{ ($this->getProductFormatName() == "por Unidad") ? 'Cantidad' : 'Cantidad ' . $this->getProductFormatName() }} </span>
                                    {{-- tooltip product format --}}
                                    <div id='tooltip_product_format' x-data='{tooltip:false}' x-on:mouseleave='tooltip=false' x-on:mouseover='tooltip=true'>
                                        <div  class="px-2 text-gray-600 bg-gray-200 rounded-full ">
                                            <i class="text-sm fas fa-question "></i>
                                        </div>
                                        <div x-show='tooltip' x-cloak x-transition class="" >
                                            <div class='absolute w-48 p-4 text-sm bg-white rounded shadow -translate-x-1/3'>
                                                <p class="text-sm text-gray-500">
                                                    cantidad de unidades que contiene el formato de venta.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <x-jet-input class='w-full p-2 border' placeholder='Ingresa cantidad' wire:model.defer='quantity_per_format'  >  </x-jet-input>
                            </label>
                            @error('quantity_per_format')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
                        </div>


                        {{-- PRECIO --}}
                        <div>
                            <label>
                                <span>Precio de venta {{ $this->getProductFormatName() }}</span>
                                <div class="flex items-center gap-2 mt-2">
                                    <span>$</span>
                                    <x-jet-input type="number" step="100" min="0" class='w-full p-2 border' wire:model.debounce.800ms='price' required></x-jet-input>
                                </div>
                            </label>
                            @error('price')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
                        </div>
                        

                        {{-- Stock min --}}
                        <div>
                            <label>
                                <div class='flex items-center gap-4 mb-2'>
                                    <span>Stock minimo</span>
                                    {{-- tooltip stock min --}}
                                    <div id='tooltip_stock_min' x-data='{tooltip:false}' x-on:mouseleave='tooltip=false' x-on:mouseover='tooltip=true'>
                                        <div  class="px-2 text-gray-600 bg-gray-200 rounded-full ">
                                            <i class="text-sm fas fa-question "></i>
                                        </div>
                                        <div x-show='tooltip' x-cloak x-transition class="" >
                                            <div class='absolute w-48 p-4 text-sm bg-white rounded shadow -translate-x-1/3'>
                                                <p class="text-sm text-gray-500">
                                                    cantidad minima de productos que se deben mantener en bodega, cuando el stock es menor a este valor, se notificara al administrador.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <x-jet-input class='w-full p-2 border' type="number" min="0" wire:model.defer='stock_min'></x-jet-input>
                            </label>
                            @error('stock_min')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
                        </div>
                        
                    </div>

                  
                </section>

                 {{-- ORGANIZACIÓN DE PRODUCTOS --}}
                 <section class="grid gap-4 p-6 bg-white rounded-md shadow-xl ">
                    
                    {{-- CATEGORÍA --}}
                    <label for=''>
                        <div class='flex items-center justify-between gap-4 py-1'>
                            Categorías
                            <div id='dropdown_category' x-data="{dropdown:@entangle('categoryModal')}" >
                                <div x-on:click='dropdown=true' >
                                    <div class="px-2 text-gray-600 bg-gray-200 rounded-full cursor-pointer">
                                        <i class="text-sm fas fa-plus "></i>
                                        Nuevo
                                    </div>
                                </div>
                                <div x-show='dropdown' x-cloak>
                                    <x-modals.basic>
                                        <x-slot name='header'>
                                            <div class="flex items-center justify-between gap-4 p-4">
                                                Nueva categoría
                                                <div x-on:click='dropdown=false'>
                                                    <i class="px-2 cursor-pointer fas fa-times hover:font-bold"></i>
                                                </div>
                                            </div>
                                        </x-slot>
                                        <x-slot name='body'>
                                            <livewire:admin.categories.create :redirect="false"  />
                                        </x-slot>
                                    </x-modals.basic>
                                </div>
                            </div>
                        </div>
                        <ul class="flex flex-wrap items-center gap-2 my-2">
                            @forelse ($categoriesSelected as $categorySelected)
                                <li class="bg-gray-200 border-gray-400 rounded-md shadow-md drop-shadow-md">
                                    <div class="flex items-center gap-2 px-1">
                                        <span class="text-sm">{{ $categorySelected['name'] }}</span>
                                        <div wire:click="removeCategoryFromProduct( '{{ $categorySelected['name'] }}' )" class="cursor-pointer">
                                            <i class="text-gray-500 fas fa-times"></i>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="text-sm text-gray-500">No hay categorías seleccionadas</li>
                            @endforelse
                        </ul>
                        <div>
                            <x-selects.select   :placeholder="'Buscar...'" :noClose="true" :collection='$categories'  :event="'addCategoryToProduct'" :search="$searchCategory" :isOpen="$isOpenCategories" />
                        </div>
                        @error('categoriesSelected')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
                    </label>
                    
                    {{-- MARCA --}}
                    <label for=''>
                        <div class='flex items-center justify-between gap-4 py-1'>
                            Marca 
                            <div id='dropdown_brand' x-data="{dropdown:@entangle('brandModal')}" >
                                <div x-on:click='dropdown=true'>
                                    <div class="px-2 text-gray-600 bg-gray-200 rounded-full cursor-pointer">
                                        <i class="text-sm fas fa-plus "></i>
                                        Nuevo
                                    </div>
                                </div>
                                <div x-show='dropdown' x-cloak>
                                   
                                        <x-modals.basic>
                                            <x-slot name='header'>
                                                <div class="flex items-center justify-between gap-4 p-4">
                                                    Nueva marca
                                                    <div x-on:click='dropdown=false'>
                                                        <i class="px-2 cursor-pointer fas fa-times hover:font-bold"></i>
                                                    </div>
                                                </div>
                                            </x-slot>
                                            <x-slot name='body'>
                                                <livewire:admin.brands.create :redirect="false"  />
                                            </x-slot>
                                            
                                        </x-modals.basic>
                                   
                                </div>
                            </div>
                        </div>
                        <x-selects.select :placeholder="'Selecciona marca'" :collection='$brands' wire:model='brand_id'/>
                        @error('brand_id')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
                    </label>
                </section>

            </article>
        </section>
        <section class="col-span-12 md:col-span-4 2xl:col-span-3">
            <article class="grid gap-4 ">
                {{-- Activar producto --}}
                <section class=" grid gap-x-4 | rounded-md shadow-xl   p-6 bg-white ">
                    <label class="flex justify-between items-center gap-x-2 | cursor-pointer ">
                        <span class="w-max">Activar para venta online</span>
                        <div class='switch'>
                            <input  type='checkbox' wire:model="is_active">
                            <span class='slider round'></span> 
                        </div>
                    </label>
                    <p class="mt-2 text-sm text-gray-400">
                        El producto se ocultara para ventas online si no esta activo.
                    </p>
                </section>

                {{-- Activar venta por mayor --}}
                <section x-data="{isOpenWholeSalePrice:@entangle('is_active_whole_sale_price') }" class=" grid gap-x-4 | rounded-md shadow-xl  p-6 bg-white ">
             
                    <label class="flex justify-between items-center gap-x-2 | cursor-pointer ">
                        <div class='py-1'>Activar para venta por mayor</div>
                        <div class="switch">
                            <input  type="checkbox" wire:model="is_active_whole_sale_price">
                            <span class="slider round"></span> 
                        </div>
                    </label>
                    <p class="mt-2 text-sm text-gray-400">
                        El precio se ocultará para ventas online por mayor si este no esta activo.
                    </p>

            
                    <label x-show="isOpenWholeSalePrice" x-cloak class="mt-4">
                        <h2>Precio de venta por mayor</h2>
                        <div class="flex items-center gap-2">
                           $ <x-jet-input class='w-full p-2 border' type="number" step="10" min="0" wire:model.defer='whole_sale_price'></x-jet-input>
                        </div>
                        @error('whole_sale_price')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
                    </label>
                 
        
                </section>

                {{-- fecha de producto --}}
                <section class=" grid gap-x-4 | rounded-md shadow-xl  p-6 bg-white ">
             
                    <label class="flex items-center justify-between gap-x-2">
                        <div class='py-1'>Días fecha de vencimiento</div>
                    </label>
                    <p class="mt-2 text-sm text-gray-400">
                        Con cuantos días de anticipacion se debe alertar sobre la fecha de vencimiento 
                    </p>
                    <label class="mt-4">
                        <div class="flex items-center gap-2">
                           <x-jet-input class='w-full p-2 border' type="number" step="1" min="0" wire:model.defer='expiration_date'></x-jet-input>
                        </div>
                        @error('expiration_date')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
                    </label>
                    
                </section>

               

                {{-- PRECIO DE OFERTA --}}
                <section x-data="{isOpenOffer:@entangle('has_offer'), isOpenFixedOffer:@entangle('fixed_offer') }"  class="grid gap-4 | rounded-md shadow-md  p-6 bg-white">

                    <label class="flex items-center justify-between">
                        <span>Agregar precio de oferta</span>
                        <div class='switch'>
                            <input  type='checkbox' wire:model="has_offer">
                            <span class='slider round'></span> 
                        </div>
                    </label>

            
                    {{-- Precio oferta --}}
                    <div x-show="isOpenOffer" x-cloak x-transition class="flex flex-col gap-4">
                      
                        {{-- INFO PRECIO NORMAL --}}
                        <div>
                            Precio venta normal:  {!! ( $price > 0) ? '$' .  number_format($price,0,',','.') : "<div class='text-sm text-red-500'>No has ingresado precio de venta normal </div>" !!} 
                            <p class="mt-4 text-sm text-gray-400">
                                Ingresa un valor menor {{ ( $price <= 0 ) ? 'al precio de venta normal' : 'a $ ' .  number_format($price,0,',','.') ;}} para que la oferta sea atractiva
                            </p>
                        </div>

                        {{-- PRECIO DE OFERTA --}}
                        <div>
                            <label> 
                                <span>Precio de oferta</span>
                                <div class="flex items-center gap-2">
                                    <span>$</span>
                                    <x-jet-input class='w-full p-2 border' type="number" min="0" wire:model.debounce.800='offer_price'></x-jet-input>
                                </div>
                            </label>
                            @error('offer_price')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
                        </div>

                        {{-- PORCENTAJE DE DESCUENTO --}}
                        <div>
                            <label> 
                                <span>Descuento</span>
                                <div class="flex items-center gap-2">
                                    <span>%</span>
                                    <x-jet-input class='w-full border' type="number" min="0" step="0.01" wire:model.debounce.800='discount_rate'></x-jet-input>
                                </div>
                            </label>
                            @error('discount_rate')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
                        </div>

                        {{-- INFO OFERTA FIJA --}}
                        <div>
                            <label class="flex items-center justify-between col-span-2 gap-4">
                                <div class='py-1'>Oferta fija</div>
                                <div class='switch'>
                                    <input  type='checkbox' wire:model="fixed_offer">
                                    <span class='slider round'></span> 
                                </div>
                            </label>
                            <p class="mt-1 text-sm text-gray-400">
                                Si la oferta es fija se mostrará siempre, si no, debes ingresar la fecha en la que quieres que se muestre la oferta
                            </p>
                        </div>

                        {{-- FECHA DE OFERTA --}}
                        <div x-cloak x-show="!isOpenFixedOffer">
                            {{-- FECHA COMIENZO DE OFERTA --}}
                            <div>
                                <label class="">
                                    <div class='py-1'>Fecha comienzo oferta</div>
                                    <x-jet-input class='w-full p-2 border' type="date" wire:model.defer='offer_start_date'></x-jet-input>
                                </label>
                                @error('offer_start_date')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
                            </div>

                            {{-- FECHA TERMINO OFERTA --}}
                            <div class="mt-3">
                                <label class="">
                                    <span>Fecha termino oferta</span>
                                    <x-jet-input class='w-full p-2 border' type="date" wire:model.defer='offer_end_date'></x-jet-input>
                                </label>
                                @error('offer_end_date')<span class='p-1 text-sm text-red-500'>{{ $message }}</span>@enderror
                            </div>

                        </div>

                    </div>

                </section>                
                
            </article>
        </section>
    </article>

    <article class="mt-4">
        <x-jet-button wire:click="save">Guardar</x-jet-button>
    </article>
</div>  
