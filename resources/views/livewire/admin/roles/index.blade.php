<div class="p-4">
    <div class="flex justify-between pb-4">
        <h1 class="text-2xl">Roles</h1>
        <div class="flex">
            <a href="{{ route('admin.roles.create') }}" >
                <x-jet-button>
                    Crear Rol
                </x-jet-button>
            </a>
        </div>
    </div>
    <x-tables.table>
        <x-slot name="thead">
            <x-tables.tr>
                <x-tables.th  class="text-left">Permisos</x-tables.th>
                @foreach ($roles as $role)
                    <x-tables.th>
                        <div class="flex items-center gap-x-2">
                           {{$role->name}} 
                            @if ($role->name !== 'SuperAdmin' && $role->name !== 'Admin' && $role->name !== 'Vendedor' &&  $role->name !== 'Cliente' && $role->name !== "Chofer" ) 
                                <div id='dropdown_{{$role->name}}' x-data='{dropdown:false}' >
                                    <div x-on:click='dropdown=true'>
                                       <i class="fas fa-trash text-red-500 cursor-pointer px-2"></i>
                                    </div>
                                    <div x-show='dropdown' x-cloak >
                                        <x-modals.alert>
                                            <x-slot name='header'>
                                                Eliminar rol {{$role->name}}
                                            </x-slot>
                                            <x-slot name='body'>
                                                Seguro deseas eliminar {{$role->name}}? <br>
                                            <div class="font-thin text-sm pt-4">
                                                Esta accion eliminara el rol permanentemente
                                            </div>
                                            </x-slot>
                                            <x-slot name='footer'>
                                                <x-jet-danger-button wire:click="delete({{$role->id}})">
                                                    Eliminar 
                                                </x-jet-danger-button>
                                                <x-jet-button x-on:click='dropdown=false'>
                                                    Cancelar
                                                </x-jet-button>
                                            </x-slot>
                                        </x-modals.alert>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </x-tables.th>
                @endforeach
            </x-tables.tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach ($permissions as $permission)
                <x-tables.tr>
                    <x-tables.th class="text-left">
                        <div class="flex flex-wrap gap-x-2">
                            <div class="text-gray-500 font-light">
                                {{$permission->description}}
                            </div>
                            <div class="text-gray-400 font-light">
                                {{$permission->name}}
                            </div>
                        </div>
                    </x-tables.th>
                    @foreach ($roles as $role)
                        @if ($role->name == "SuperAdmin")
                            <x-tables.th>  <i class="fas fa-check text-green-500"></i> </x-tables.th>
                        @else
                            <x-tables.th> 
                                <input type="checkbox" wire:click.debounce="changeRole( {{ $role->id }} , {{ $permission->id }} )" @if ($role->hasPermissionTo($permission->name)) checked  @endif  > 
                            </x-tables.th>
                        @endif
                    @endforeach
                </x-tables.tr>
            @endforeach
        </x-slot>
    </x-tables.table>

    
    
</div>