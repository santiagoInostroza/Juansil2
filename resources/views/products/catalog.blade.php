<x-home-layout>
    @section('title', ' - Catalogo')

   <div class="relative w-screen">
     <img class="h-128 w-full object-cover" src="{{asset('images/banners/glass.jpg')}}" alt="" srcset="{{asset('images/banners/glass.jpg')}}">
       <div class="absolute inset-0 bg-gradient-to-r from-transparent via-gray-800 to-gray-800 opacity-90"></div>
       <div class="absolute inset-0 flex justify-end items-center mr-8 md:mr-12 lg:mr-16 xl:mr-24  ">
            <div class="flex flex-col gap-8">
                <div class="text-3xl md:text-5xl lg:6xl xl:text-7xl font-bold text-white w-64 md:w-96 lg:w-128 xl:w-192">
                    LECHES COLACIONES <br>
                    Y MÁS...
                </div>
                <div class="text-gray-400 text-lg md:text-xl lg:text-3xl xl:text-4xl w-64 md:w-96 lg:w-128 xl:w-192">
                    Despacho a domicilio de lunes a viernes solo sector sur oriente de la capital
                </div>
            </div>
       </div>
    </div>

    <livewire:products.wholesale.index />




</x-home-layout>