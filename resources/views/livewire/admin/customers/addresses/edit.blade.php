<div class=" grid gap-4">
    <div>
        
        <div>Direccion predeterminada</div>
        <div class="p-4 bg-white  rounded-md  my-2 border border-gray-200 ">
            {{ (isset($addresses) && $addresses->count() > 0) ? $addresses->where('default', 1)->first()->name : 'No tiene direccion predeterminada' }}
        
        </div>
    </div>
    <div>
        @if (isset($addresses) && $addresses->count() > 0)
            <x-tables.table>
                <x-slot name='thead'>
                    <x-tables.tr>
                        {{-- <x-tables.th class='text-left'>Id</x-tables.th> --}}
                        <x-tables.th class='text-left'></x-tables.th>
                        <x-tables.th class='text-left'>alias</x-tables.th>
                        <x-tables.th class='text-left'>dirección</x-tables.th>
                        <x-tables.th></x-tables.th>
                    </x-tables.tr>
                </x-slot>
                <x-slot name='tbody'>
                    @foreach ($addresses as $address)
                        <x-tables.tr>
                            {{-- <x-tables.td>{{$address->id}}</x-tables.td> --}}
                            <x-tables.td>
                                @if ($address->default)
                                    <div class="text-center bg-green-100 border-green-500 rounded-md p-1">
                                        Seleccionado <i class="fas fa-check text-green-500 "></i>
                                    </div>
                                @else
                                    <div  id="address_{{$address->id}}" wire:click="makeDefault({{$address->id}})" class="p-1 border-gray-400 border-2 bg-white rounded-md shadow-md inline-block cursor-pointer uppercase tracking-widest"> Seleccionar</div>
                                @endif
                                
                            </x-tables.td>
                            
                            <x-tables.td>{{$address->alias}}</x-tables.td>
                            <x-tables.td>{{$address->name}}</x-tables.td>
                            
                            <x-tables.td>
                                <div class='flex flex-wrap gap-x-2 justify-end' >
                                    @if (!$address->default)
                                        @can('admin.addresses.edit')
                                            <a href="{{ route('admin.addresses.edit', $address) }}" >
                                                <i class='fas fa-pen cursor-pointer px-2'></i>
                                            </a>
                                    
                                        @endcan

                                        @can('admin.addresses.destroy')
                                            <div id='dropdown_delete_{{$address->id}}' x-data='{dropdown:false}' >
                                                <div x-on:click='dropdown=true'>
                                                    <i class='fas fa-trash cursor-pointer px-2'></i>
                                                </div>
                                                <div x-show='dropdown' x-cloak >
                                                    <x-modals.alert>
                                                        <x-slot name='header'>
                                                            Eliminar dirección
                                                        </x-slot>
                                                        <x-slot name='body'>
                                                            Seguro deseas eliminar {{$address->alias}}?
                                                        </x-slot>
                                                        <x-slot name='footer'>
                                                            <x-jet-danger-button x-on:click='$wire.delete({{$address->id}}).then(()=>{dropdown=false})'>
                                                                Eliminar
                                                            </x-jet-danger-button>
                                                            <x-jet-button  x-on:click='dropdown=false'>
                                                                Cancelar
                                                            </x-jet-button>
                                                        </x-slot>
                                                    </x-modals.alert>
                                                </div>
                                            </div>
                                        
                                        @endcan
                                    @endif
                                </div>
                            </x-tables.td>
                        </x-tables.tr>
                    @endforeach
                </x-slot>
            </x-tables.table>
        @else
            <div class="text-red-500 font-bold py-4">
                No hay direcciones relacionadas a este cliente
            </div>
        @endif
    </div>
    <div class="flex justify-end" wire:ignore>
        <div id='dropdown_address_modal' x-data="{dropdown:@entangle('addressModal')}" >
            @if ($customer)
                <div x-on:click='dropdown=true' class="py-4">
                    <x-jet-button class=""> Agregar dirección </x-jet-button>
                </div>
            @endif
            <div x-show='dropdown' >
                <div class='bg-white rounded shadow p-4 absolute'>
                    <x-modals.basic>
                        <x-slot name='header'>
                            <div class="flex justify-between gap-4 p-4 items-center bg-gray-100">
                                <h2 class=""> Agregar dirección</h2>
                                <i x-on:click="dropdown = false" class="fas fa-times cursor-pointer p-2"></i>
                                
                            </div>
                        </x-slot>
                        <x-slot name='body'>
                            <div >
                                <livewire:admin.addresses.create :customer="$customer" :redirect="false" :wire:key="rand()" />
                            </div>
                        </x-slot>
                    </x-modals.basic>
        
                </div>
            </div>
        </div>
    </div>       
   
</div>
