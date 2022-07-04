<div class="shadow border bg-gray-800 text-gray-400 p-4 h-full">
    @php
        $vistas =[
            [
                'name' => 'Admin',
                'type' => 'title',               
                
            ],
            [
                'name' => 'Panel',
                'icon' => 'fas fa-tachometer-alt',
                'route' => 'admin.index',
                'can' => 'admin.index'
            ],
            // [
            //     'name' => 'Mi Info',
            //     'icon' => 'fas fa-tachometer-alt',
            //     'route' => 'admin',
            //     'can' => 'admin'
            // ],
            // [
            //     'name' => 'USUARIOS',
            //     'icon' => 'fas fa-users',
            //     'route' => 'admin2.users.index',
            //     'can' => 'admin.users.index'
               
            // ],
           



            [
                'name' => 'roles y permisos',
                'icon' => 'fas fa-users-cog',
                 'route' => 'admin.roles.*',
                'can' => 'admin.roles.index',
                'child' =>
                    [
                        [
                            'name' => 'ROLES',
                            'icon' => 'fas fa-users-cog',
                            'route' => 'admin.roles.index',
                            'can' => 'admin.roles.index'
                        ],

                        [
                            'name' => 'Permisos',
                            'icon' => 'fas fa-users-cog',
                            'route' => 'admin.permissions.index',
                            'can' => 'admin.roles.index'
                        ],
                    ],
            ],
            
           

         /*   [
                'name' => 'Ventas old',
                'icon' => 'fab fa-wpforms',
                'route' => 'admin.sales.index2',
                'can' => 'admin.sales.index'
               
            ],*/

           
        
         

           /* [
                'name' => 'Deliveries',
                'icon' => 'fas fa-truck',
                'route' => 'admin.deliveries.index',
                'can' => 'admin.deliveries.index'
               
            ],*/
           



        
            
           
           
            [
                'name' => 'Proveedores',
                'icon' => 'fas fa-truck-moving',
                'route' => 'admin.suppliers.index',
                'can' => 'admin.suppliers.index'
            ],
          
            [
                'name' => 'Clientes',
                'icon' => 'fas fa-user',
                'route' => 'admin.customers.index',
                'can' => 'admin.customers.index',
                'child' =>
                    [
                        [
                            'name' => 'Lista de clientes',
                            'icon' => 'fas fa-map',
                        
                            'route' => 'admin.customers.index',
                            'can' => 'admin.customers.index',
                        
                        ],
                        [
                            'name' => 'Direcciones',
                            'icon' => 'fas fa-map',
                        
                            'route' => 'admin.addresses.index',
                            'can' => 'admin.addresses.index',
                        
                        ],
                    ],
            ],

            [

                'name' => 'Compras y ventas',
                'type' => 'title',
            ],

            [
                'name' => 'Productos',
                'icon' => 'fas fa-tag',
                'route' => 'admin.products.index',
                'can' => 'admin.products.index',
                'child' =>
                    [
                        [
                            'name' => 'Lista de productos',
                            // 'icon' => 'fas fa-cash-register',
                            'route' => 'admin.products.index',
                            'can' => 'admin.products.index',
                            
                        ],
                        [
                            'name' => 'Detalle de productos',
                            // 'icon' => 'fas fa-cash-register',
                            'route' => 'admin.products.details',
                            'can' => 'admin.products.details',
                            
                        ],
                        [
                            'name' => 'Movimiento productos',
                            // 'icon' => 'fas fa-cash-register',
                            'route' => 'admin.products.movements',
                            'can' => 'admin.products.movements',
                            
                        ],
                        [
                            'name' => 'Lista de categorías',
                            // 'icon' => 'fas fa-cash-register',
                            'route' => 'admin.categories.index',
                            'can' => 'admin.categories.index',
                            
                        ],
                
                        [
                            'name' => 'Lista de marcas',
                            // 'icon' => 'fas fa-copyright',
                            'route' => 'admin.brands.index',
                            'can' => 'admin.brands.index'
                        ],
                    ],
            ],

            [
                'name' => 'COMPRAS',
                'icon' => 'fas fa-file-invoice',
                'route' => 'admin.purchases.*',
                'can' => 'admin.purchases.index',
                'child' => [
                    [
                        'name' => 'LISTA DE COMPRAS',
                        'route' => 'admin.purchases.index',
                        'can' => 'admin.purchases.index',
                    ],
                    [
                        'name' => 'Detalle de compras',
                        
                        'route' => 'admin.purchases.details',
                        'can' => 'admin.purchases.details',
                    ],
                
                    [
                        'name' => 'CREAR COMPRA',
                        
                        'route' => 'admin.purchases.create',
                        'can' => 'admin.purchases.create'
                    ],
                ],
            ],

            [
                'name' => 'Pedidos',
                'icon' => 'fas fa-cash-register',
                'route' => 'admin.orders.*',
                'can' => 'admin.orders.index',
                'child' =>  
                    [
                        [
                            'name' => 'Lista de pedidos',
                            // 'icon' => 'fas fa-cash-register',
                            'route' => 'admin.orders.index',
                            'can' => 'admin.orders.index'
                        ],
                        [
                            'name' => 'Crear pedido',
                            // 'icon' => 'fas fa-cash-register',
                            'route' => 'admin.orders.create',
                            'can' => 'admin.orders.create'
                        ],
                    ],
            ],
        
        ];
    @endphp

    <div class="flex gap-2 items-center justify-between">
        <div class="p-2">
            {{auth()->user()->name}}
            <div class="text-xs text-gray-500">
                {{auth()->user()->roles()->first()->name}}
            </div>
        </div>
        <template  x-if="true">
            <div x-on:click="isOpenAside = !isOpenAside" class="px-2 cursor-pointer hover:font-bold hover:text-gray-400 ">
                <i class="fas fa-arrow-left"></i>
            </div>
        </template>
    </div>

    <div class="border-t my-4"></div>
    
    @foreach ($vistas as $vista)

        @if (isset($vista['type']) && $vista['type'] == 'title')
        <div class="border-b-2 uppercase border-gray-700 mt-4">
            {{$vista['name']}}
        </div>
        @continue;
        @endif


        @can($vista['can'])
            @if (isset($vista['child']))
                
                <div x-data="{isOpen:false}" >
                    <div x-on:click="isOpen = !isOpen" x-on:click.away="isOpen = false" class=" flex justify-between items-center gap-2 p-2 hover:text-white   w-full cursor-pointer @if(request()->routeIs($vista['route'])) bg-gray-900 text-white @endif" :class=" isOpen ? 'font-bold bg-gray-800':'' "  >
                        <div class="flex items-center gap-2">
                            <div class="text-gray-300">
                                <i class="{{$vista['icon']}}"></i>
                            </div>
                            <h3>{{ Str::ucfirst(Str::lower($vista['name']))  }}</h3>    
                        </div>
                        <div>
                            <i x-cloak x-show="isOpen" class="fas fa-chevron-up" ></i>
                            <i x-cloak x-show="!isOpen" class="fas fa-chevron-down" ></i>
                        </div>
                    </div>
                    <div x-cloak x-show="isOpen" class=" w-full" x-transition>
                        
                        @foreach ( $vista['child'] as $key => $v )
                    
                            @if ( isset($v['can']) && $v['can'] != "")
                                @can($v['can'])
                                    <a href="{{ route($v['route']) }}" class="bg-gray-800 flex items-center pl-8 gap-2 p-2 hover:text-white w-full cursor-pointer @if(request()->routeIs($v['route'])) bg-gray-800 text-red-500 font-bold hover:text-red-700 @endif">
                                        <h3 class="">{{ Str::ucfirst(Str::lower($v['name'])) }}</h3>
                                    
                                    </a>
                                @endcan
                            @else
                                <a href="{{ route($v['route']) }}" class="bg-gray-800 flex items-center  pl-8 gap-2 p-4 hover:text-white w-full cursor-pointer @if(request()->routeIs($v['route'])) bg-gray-800 text-red-500 font-bold hover:text-red-700 @endif">
                                    <h3 class="pl-6">{{ Str::ucfirst(Str::lower($v['name']))  }}</h3>
                                </a>
                            @endif
                        
                        
                        @endforeach   

                    </div>
                    
                </div>
            @else
                @if (isset($vista['can']) && $vista['can'] != "")
                    @can($vista['can'])
                    <a href="{{ route($vista['route']) }}" class="flex items-center gap-2 p-2 hover:text-white  w-full cursor-pointer @if(request()->routeIs($vista['route'])) bg-gray-900 text-white @endif">
                        <div class="text-gray-400">
                            <i class="{{$vista['icon']}}"></i>
                        </div>
                        <h3>{{  Str::ucfirst(Str::lower($vista['name']))   }}</h3>
                    
                    </a>
                    @endcan
                @else
                    <a href="{{ route($vista['route']) }}" class="flex items-center gap-2 p-2 hover:text-white w-full cursor-pointer @if(request()->routeIs($vista['route'])) bg-gray-900 text-white @endif">
                        <div class="text-gray-400">
                            <i class="{{$vista['icon']}}"></i>
                        </div>
                        <h3>{{ Str::ucfirst(Str::lower($vista['name']))   }}</h3>
                    </a>
                @endif
            @endif
            
        @endcan
    @endforeach  
</div>
