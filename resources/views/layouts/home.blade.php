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
            @import url('https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Source+Sans+Pro:wght@300;400;600;700&display=swap');
      
     
           
            .font-l-guy {
                font-family: 'Luckiest Guy', cursive;
            }
            .font-sans-pro {
                font-family: 'Source Sans Pro', sans-serif;
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
    <body class="antialiased font-sans-pro">

        <div class="min-h-screen bg-gray-100">

            <div>  

                {{-- ALERTS --}}
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
                    <div class="fixed z-10 w-full ">
                        <livewire:header.home-header />
                        <livewire:header.category-list>
                    </div>
                    <div class="w-full h-24"></div>

                    @if (isset($header))
                        {{ $header }}
                    @endif
                    
                    @hasSection('header')
                        @yield('header')
                    @endif
                </header>
            

                @if (isset($title))
                    <header class="p-2 mx-auto max-w-10xl md:px-6 xl:px-8">
                            {{ $title }}
                    </header>
                @endif
                @hasSection('title2')
                    <header class="p-2 mx-auto max-w-10xl md:px-6 xl:px-8">
                        @yield('title2')
                    </header>
                @endif



                {{-- CONTENIDO --}}
                <div class="w-full">
                    @isset($slot)
                        {{ $slot }}
                    @endisset
                    <div class="px-2 mx-auto max-w-10xl md:px-6 xl:px-8">
                        @yield('content')
                    
                    </div>
                </div>

            </div>
           
         
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
