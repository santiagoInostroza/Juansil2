<div class="text-gray-500 m-2 md:m-0">
  
    <div class="grid grid-cols-1 md:grid-cols-12">
        <div class="col-span-4 md:col-span-3 lg:col-span-2">
            <div class="p-4">
                {{ ($category) ? $category->name : 'Todo' ;}}
            </div>
        </div>
        <div class="col-span-8 md:col-span-9 lg:col-span-10">
            @if ($products && $products->count() > 0)
                <ul class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 md:gap-6 m-2 md:m-4 mx-auto max-w-7xl">
                    @foreach ($products as $product)
                        <li class="p-6 border rounded-xl shadow-md grid">   
                            <div>
                            <figure >
                                <img class="drop-shadow-md w-full object-cover h-24 md:h-64" src="{{ Storage::url($product->image->url)}}" alt="{{$product->name}}">
                            </figure>
                            </div>    
                            <div class="flex flex-col gap-4 justify-between">
                            
                                <div class="py-4 text-lg">
                                    <div class="font-bold">
                                        {{$product->brand->name}}
                                    </div>
                                    <div>
                                        {{$product->name}}
                                    </div>
                                </div>
                                <div class="flex gap-4 items-center justify-between flex-wrap">
                                    <div class="text-3xl text-gray-600 font-bold drop-shadow-md">
                                        ${{ number_format($product->price,0,',','.') }}
                                    </div>
                                    <div class="font-light">
                                        {{$product->format->name}} 
                                        {{$product->quantity_per_format}} un
                                    </div>
                                </div>
                                <div class="flex justify-center mt-6">
                                    
                                    @if( session()->has('cart.ws.items') && session('cart.ws.items.' . $product->id ))
                                        <div id="quantity_{{$product->id}}" 
                                            x-on:set-quantity-{{ $product->id }}.window="quantity = $event.detail.quantity"
                                            x-data="{ 
                                            quantity:{{ session('cart.ws.items.' . $product->id )['quantity'] }} , 
                                            setQuantity:function(){
                                                $wire.setItemFromCart({{ $product->id }},this.quantity);
                                                this.cartSetQuantity();
                                            },
                                            add:function(){
                                                this.quantity++;
                                                $wire.setItemFromCart({{ $product->id }},this.quantity);
                                                this.cartSetQuantity();
                                            },
                                            cartSetQuantity:function(){
                                                $dispatch('cart-set-quantity-{{ $product->id }}',{quantity:this.quantity});
                                            },
                                            discount:function(){
                                                if(this.quantity > 1){
                                                    this.quantity--;
                                                    $wire.setItemFromCart({{ $product->id }},this.quantity);
                                                    this.cartSetQuantity();
                                                    
                                                }else{
                                                $wire.removeItemFromCart({{ $product->id }});
                                                }
                                            } }">
        
                                        
        
                                            <div class="flex gap-4 items-center justify-between">
                                                <span class="text-gray-500 text-sm font-bold">
                                                <input type="number" name="" id="" x-model="quantity" class="w-16" x-on:change.debounce.800ms="setQuantity()" {{--  x-on:keyup.debounce.800ms="setQuantity()" --}}> {{ $product->format->name }}
                                                </span>
                                            
                                                <div class="flex items-center gap-2">
                                                    <div x-on:click="discount" class="border border-gray-500 rounded-lg p-1 px-2 text-gray-500 hover:bg-gray-100 hover:text-white cursor-pointer">
                                                        <i class="fas fa-minus"></i>
                                                    </div>
                                                    <div x-on:click="add" class="border border-gray-500 rounded-lg p-1 px-2 bg-gray-500 hover:bg-gray-600 cursor-pointer">
                                                        <i class="fas fa-plus text-white "></i>
                                                    </div>
                                                </div>
        
                                            </div>
                                        </div>
                                    @else
                                        <div wire:click="addItemToCart({{ $product->id }})" class="w-max m-auto p-2 px-2 md:px-6 bg-red-600 text-white  rounded-xl shadow-md text-center cursor-pointer select-none drop-shadow-md uppercase tracking-widest border-2 border-transparent hover:border-red-900 hover:bg-red-700">
                                            Agregar 
                                        </div>    
                                    @endif
        
                                        
                        
        
                                
                                            {{-- @if ( )
                                                <div class="flex items-center gap-2">
                                                    <div class="border border-red-500 rounded p-1 px-2 text-red-500 hover:bg-red-600 hover:text-white">
                                                        <i class="fas fa-minus "></i>
                                                    </div>
                                                    <div class="border border-red-500 rounded p-1 px-2 bg-red-500 hover:bg-red-600 cursor-pointer">
                                                        <i class="fas fa-plus text-white "></i>
                                                    </div>
                                                </div>
                                            @else
                                            
                                            @endif --}}
                                    
                                
                                
                                    
                            
                            
                                </div>                    
                            </div>         
                        </li>
                    @endforeach
                </ul> 
            @else
                @if ($category)
                    <div class="text-center text-gray-500 m-2 md:m-0">
                        No hay productos en esta categoría
                    </div>
                @else
                    <div class="text-center">
                        No hay productos disponibles
                    </div>
                @endif    
            @endif
        </div>
    </div>

</div>
   

   
   
