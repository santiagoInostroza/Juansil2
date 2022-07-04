<div id="cart" x-data="{
  isOpenCart:false,
}">
  <style>
    /*  scroll hide on window */
    ::-webkit-scrollbar {
    display: none;
    }
    

  </style>
  
  <div x-on:click="isOpenCart=true"  class="pl-3 p-2 flex gap-2 items-center  bg-gray-700 rounded shadow cursor-pointer relative">
    <i class="fas fa-cart-arrow-down "></i>
    <span class="text-white ">{{ session()->has('cart.ws.cantTotal') ? session()->get('cart.ws.cantTotal') : '' }}</span>
    {{-- loading --}}
    <div  wire:loading wire:target="setItemFromCart" class="absolute inset-0 bg-gray-700 opacity-80"></div>
    <span wire:loading wire:target="setItemFromCart" class="text-white absolute flex justify-center">
      <i class="fas fa-spinner fa-spin"></i>
    </span>
   
   
  </div>


  <div x-cloak x-show="isOpenCart" class="fixed inset-0 z-10"  x-transition">
    <div class="fixed inset-0 bg-gradient-to-r from-gray-600 via-gray-500 to-gray-700 opacity-70">  </div>
    <div class="fixed top-0 bottom-0 right-0 w-full md:w-2/3 lg:w-1/2 2xl:w-1/3 bg-white shadow-md rounded-md " x-on:click.away="isOpenCart = false">
              
      @if (session()->has('cart.ws.items'))
        <div class="flex justify-between gap-4 items-center p-4 text-gray-800">
                @if (session()->get('cart.ws.cantTotal') == 1)
                  <div class="text-xl font-bold">
                    Tienes  {{ session()->get('cart.ws.cantTotal') }} producto
                  </div>
                @elseif(session()->get('cart.ws.cantTotal') > 1)
                  <div class="text-xl ">
                    Tienes  {{ session()->get('cart.ws.cantTotal') }} productos
                  </div>
                @endif
            
  
            <svg x-on:click="isOpenCart = false"  class="h-6 w-6 hover:text-gray-600 cursor-pointer" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg> 
        </div>

        <hr>

        <div class="p-4 text-gray-800 font-semibold text-sm h-full">
          @if (session()->has('cart.ws.items'))
          <ul class="grid gap-2">
            @foreach (session('cart.ws.items') as $item)
            <li class="grid grid-cols-8 border-b" 
              id="cart_item_{{ $item['product_id'] }}" 
              x-on:cart-set-quantity-{{ $item['product_id'] }}.window="setQuantity($event.detail.quantity)"
              x-data="{ 
                quantity:'' , 
                add:function(){
                    this.quantity++;
                    $wire.setItemFromCart({{ $item['product_id'] }},this.quantity);
                    this.cartSetQuantity();
                },
                setQuantity:function(quantity){
                  this.quantity = quantity;
                  $wire.setItemFromCart({{ $item['product_id'] }},quantity);
                  
                },
                discount:function(){
                    if(this.quantity > 1){
                        this.quantity--;
                        $wire.setItemFromCart({{ $item['product_id'] }},this.quantity);
                        this.cartSetQuantity();
                    }
                },
                cartSetQuantity:function(){
                  $dispatch('set-quantity-{{ $item['product_id'] }}',{quantity:this.quantity});
                },
                init:function(){
                  this.quantity = {{ $item['quantity'] }} ;
                }
              }"
              x-init="init()">
              <div>
                <img  src="{{ Storage::url($item['image']) }}" loading="lazy" alt="{{ $item['name'] }}" class="w-24 h-24 object-cover">
              </div>
              <div class="col-span-6 p-4 py-2">
                <div class="mb-2">
                  {{$item['name']}}
                </div>
                <div class="flex items-center gap-4">
                  <div class="text-gray-500 text-lg">
                    <span x-text="quantity" id="cart_item_quantity_{{ $item['product_id'] }}"></span> <span class="text-base">{{$item['format']}}</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <div x-on:click="discount"  class="border border-gray-500 rounded p-2 px-3 text-gray-500 hover:bg-gray-600 hover:text-white">
                      <i class="fas fa-minus "></i>
                    </div>
                    <div x-on:click="add" class="border border-gray-500 rounded p-2 px-3 bg-gray-500 hover:bg-gray-600 cursor-pointer">
                      <i class="fas fa-plus text-white "></i>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class=" py-2  text-lg">
                <div class="font-bold text-gray-600 mb-2 text-right">
                  ${{ number_format($item['quantity'] * $item['price'],0,',','.') }}
                </div>
                <div class="text-blue-300 text-right">
                  <i wire:click="removeItemFromCart({{ $item['product_id']}})" class="fas fa-trash cursor-pointer"></i>
                </div>
              </div>
            </li>
            @endforeach
          </ul>
          @endif
        </div>

        <div class="absolute bottom-0  w-full p-4 text-gray-800 border-t">
          <div class="flex justify-between items-center gap-4 mb-2 text-lg">
            <span>Subtotal</span>
            <div>
              {{-- loading --}}
              <div class="relative">
                <div  wire:loading wire:target="setItemFromCart" class="absolute inset-0 bg-white opacity-80"></div>
                <span wire:loading wire:target="setItemFromCart" class="text-black flex items-center justify-center text-center">
                  <i class="fas fa-spinner fa-spin"></i>
                </span>
                ${{ number_format(session('cart.ws.total'),0,',','.') }}
              </div>
            </div>
          </div>
          <div class="text-gray-500 font-normal">
            Monto minimo de compra: $10.000
          </div>
          <div>
            <button class="bg-red-600 text-white font-bold py-1.5 px-4 rounded-md w-full">
              Continuar
            </button>
          </div>
        </div>
      @else
        <div class="text-xl font-bold text-gray-800 flex justify-center items-center h-full">
          <div>
            <div class="mb-2">
              No tienes productos en el carrito
            </div>
            <button x-on:click="isOpenCart=false" class="flex items-center gap-2 text-red-500"> &#128072; Quiero agregar productos &#128512; </button>
          </div>
        </div>
      @endif
              
    </div>
  </div>

</div>
