<div class="mt-4 bg-red-200 rounded p-2 text-red-600" id="expired_products" x-data="{'isOpenExpiredProducts': false}">
    {{-- {{$countExpiredProducts}} --}}
    <h2 x-on:click="isOpenExpiredProducts = !isOpenExpiredProducts" class="text-xl font-bold cursor-pointer">Productos por expirar</h2>
    <div x-cloak x-show="isOpenExpiredProducts" x-transition>
        
        <x-tables.table>
            <x-slot name='thead'>
                <x-tables.tr>
                    <x-tables.th class='text-left'>Id</x-tables.th>
                    <x-tables.th class='text-left'>Producto</x-tables.th>
                    <x-tables.th class='text-left'>Cantidad</x-tables.th>
                    <x-tables.th class='text-left'>Fecha vencimiento</x-tables.th>
                    <x-tables.th class='text-left'>Vence</x-tables.th>

                    <x-tables.th></x-tables.th>
                </x-tables.tr>
            </x-slot>
            <x-slot name='tbody'>
                @foreach ($products as $product)
                    <x-tables.tr>
                        <x-tables.td>
                            <a href="{{route('admin.products.edit', $product->product->slug)}}">
                                {{$product->product->id}}
                            </a>
                        </x-tables.td>
                        <x-tables.td>{{$product->product->name}}</x-tables.td>
                        <x-tables.td>{{$product->stock}}</x-tables.td>
                        <x-tables.td>{{Helper::date($product->expired_date)->dayName}} {{Helper::date($product->expired_date)->format('d-m-Y')}}</x-tables.td>
                        <x-tables.td>{{ Helper::date($product->expired_date)->diffForHumans()}}</x-tables.td>
                        <x-tables.td>
                            <div class='flex flex-wrap gap-x-2 justify-end'>
                                {{-- <a href="{{ route('admin.permissions.edit', $Permission) }}" >
                                    <i class='fas fa-pen cursor-pointer px-2'></i>
                                </a> --}}
                                {{-- <div id='dropdown_delete_{{$Permission->id}}' x-data='{dropdown:false}' >
                                    <div x-on:click='dropdown=true'>
                                        <i class='fas fa-trash cursor-pointer px-2'></i>
                                    </div>
                                    <div x-show='dropdown' x-cloak >
                                        <x-modals.alert>
                                            <x-slot name='header'>
                                                Eliminar
                                            </x-slot>
                                            <x-slot name='body'>
                                                Seguro deseas eliminar?
                                            </x-slot>
                                            <x-slot name='footer'>
                                                <x-jet-danger-button wire:click='delete({{$Permission->id}})'>
                                                    Eliminar
                                                </x-jet-danger-button>
                                                <x-jet-button  x-on:click='dropdown=false'>
                                                    Cancelar
                                                </x-jet-button>
                                            </x-slot>
                                        </x-modals.alert>
                                    </div>
                                </div> --}}
                            </div>
                        </x-tables.td>
                    </x-tables.tr>
                @endforeach
            </x-slot>
        </x-tables.table>
        
    </div>
</div>
