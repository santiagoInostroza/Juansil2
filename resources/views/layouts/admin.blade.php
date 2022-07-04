<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Juansil') }} @yield('title')</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{asset('css/myCss.css') }}">
        

        {{-- FONT AWESOME 5 --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

        {{-- SWEET ALERT --}}
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- font google --}}
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@1,900&family=Luckiest+Guy&display=swap');
     
            .font-exo-2 {
                font-family: 'Exo 2', sans-serif;
            }
            .font-l-guy {
                font-family: 'Luckiest Guy', cursive;
            }

            [x-cloak] { display: none; }
            @media screen and (max-width: 768px) {
                [x-cloak="mobile"] { display: none; }
            }
            .scroll-hidden::-webkit-scrollbar {
            display: none;
            }
           
        </style>


        @livewireStyles

        <!-- Scripts -->
        <script src="{{asset('js/myJs.js') }}"></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        {{-- <x-jet-banner /> --}}

        <div class="min-h-screen ">
            {{-- @livewire('navigation-menu') --}}

            <main>
                <div x-on:resize.window="resize()" x-data="main()" class="h-screen w-full text-gray-500">
                    {{-- BARRA LATERAL--}}
                    <div x-on:click="isOpenAside = false"  class="bg-gray-500 opacity-50 fixed inset-0" :class="(isMobile && isOpenAside) ? '' : 'hidden'"></div>
                    <div x-cloak x-show="isOpenAside" class="w-64 h-full shadow fixed bg-gray-800 text-gray-400"
                        x-transition.duration.ms.scale.5.origin.left.top
                        >
                        {{-- <template  x-if="isMobile">
                            <div x-on:click="isOpenAside = !isOpenAside" class="p-2 cursor-pointer hover:font-bold hover:text-gray-400 ">
                                <i class="fas fa-arrow-left"></i>
                            </div>
                        </template> --}}
                        <div class="h-full overflow-auto scroll-hidden">
                            <livewire:aside.index>
                        </div>
                    </div>

                    <div class="w-full h-full" :class="isMobile ? 'pl-0' :  isOpenAside  ? 'pl-64':'pl-0'">

                        {{-- alerts --}}
                        @if (session()->has('message'))
                            <x-alerts.success>
                                {{ session('message') }}
                            </x-alerts.success>   
                        @endif
                        @if (session()->has('success'))
                            <x-alerts.success>
                                {{ session('success') }}
                            </x-alerts.success>   
                        @endif


                        <header class="">
                            
                            @if (isset($header))
                                {{ $header }}
                            @endif
                            
                            @hasSection('header')
                                    @yield('header')
                            @endif
                        </header>



                        {{-- HEADER --}}
                        <div class="w-full h-16 flex items-center shadow bg-white">
                            <div x-on:click="isOpenAside = !isOpenAside" class="p-4 cursor-pointer hover:font-bold hover:text-gray-400 "><i class="fas fa-bars"></i></div>
                            <div class="flex-1">
                                <livewire:header.index /> 
                            </div>                              
                        </div>

                      


                        {{-- CONTENIDO --}}
                        <div class="w-full">
                            @isset($slot)
                                {{ $slot }}
                            @endisset
                            <div class="max-w-10xl mx-auto px-2 md:px-6 xl:px-8">
                                @yield('content')
                            
                            </div>
                        </div>
                    </div>
                    
                </div>
            </main>
        </div>

        <script>
            function main(){
                return{
                    isOpenAside : (window.innerWidth < 1916) ? false : true,
                    isMobile : (window.innerWidth < 768) ? true : false,
                    resize:function(){
                        this.isOpenAside =  (window.innerWidth < 1916) ? false : true; 
                        this.isMobile = (window.innerWidth < 768) ? false : false;
                    },
                }
            }
        </script>

        @stack('modals')
        
        @stack('scripts')

        @livewireScripts
    </body>
</html>