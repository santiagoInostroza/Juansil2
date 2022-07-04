<div>

    {{-- HEADER --}}
    <div class='flex flex-wrap justify-between gap-4 pb-4'>
        <h1 class='text-2xl'>Direcciones <i wire:loading class='text-2xl fas fa-spinner animate-spin'></i> </h1>
       {{-- @can('admin.addresses.create')    
            <a href="{{ route('admin.addresses.create') }}" >
                <x-jet-button>
                    Crear Direccion
                </x-jet-button>
            </a>
       @endcan --}}
    </div> 
    {{--FILTROS  --}}
    <div class='flex flex-wrap items-center justify-between pb-4 gap-x-4'>
        {{-- BUSCADOR --}}
        <label class='flex items-center justify-between flex-1 gap-x-4 md:mr-4'>
            <x-jet-input wire:model.debounce.1s='search' class='w-full p-2 border' placeholder='Que deseas buscar?'></x-jet-input>
            <i wire:loading class='fas fa-spinner animate-spin'></i>
            <i wire:loading.remove class='fas fa-search'></i>
        </label>

        {{-- COLUMNAS --}}
        <div>
            <div id='dropdown_num_col' x-data='{dropdown:false}' >
                <div x-on:click='dropdown=true'>
                    <div class='p-2 bg-white border rounded shadow cursor-pointer select-none'>
                        columnas
                    </div>
                </div>
                <div x-show='dropdown' x-cloak x-transition x-on:click.away='dropdown=false'>
                    <div class='absolute z-10 bg-white rounded shadow'>
                        <ul class='grid gap-2 py-2'>
                            <li class='grid grid-cols-1 cursor-pointer hover:bg-gray-100 px-4 py-0.5' wire:click="selectColumns('all')">
                                Marcar todas
                            </li>
                            <li class='grid grid-cols-1 cursor-pointer hover:bg-gray-100 px-4 py-0.5' wire:click="selectColumns('none')">
                                Desmarcar todas
                            </li>
                            <li class='grid grid-cols-1 cursor-pointer hover:bg-gray-100 px-4 py-0.5' wire:click="selectColumns('switch')">
                                Alternar
                            </li>
                            <hr>
                            @foreach ($columns as $key => $column)
                                <li class='grid grid-cols-1 hover:bg-gray-100 px-4 py-0.5'>
                                    <label class='flex items-center'>
                                        <input type='checkbox' wire:model="columns.{{$key}}.value"  class='w-4 h-4 text-indigo-600 transition duration-150 ease-in-out form-checkbox'>
                                        <span class='ml-2'>{{$column['name']}}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    
        {{-- FILAS --}}
        <div id='dropdown_num_rows' x-data='{dropdown:false}' >
            <div x-on:click='dropdown=true'>
                <div class='p-2 bg-white border rounded shadow cursor-pointer select-none'>
                    mostrar {{$numRows}} filas
                </div>
            </div>
            <div x-show='dropdown' x-cloak x-transition x-on:click.away='dropdown=false'>
                <div class='absolute z-10 p-4 bg-white rounded shadow'>
                    <div class='flex flex-wrap gap-4'>
                        <div class='w-full'>
                            <label class='flex items-center'>
                                <input type='radio' name='num_rows' value='10' wire:model='numRows' class='w-4 h-4 text-indigo-600 form-radio'/>
                                <span class='ml-2 text-sm'>10</span>
                            </label>
                        </div>
                        <div class='w-full'>
                            <label class='flex items-center'>
                                <input type='radio' name='num_rows' value='25' wire:model='numRows' class='w-4 h-4 text-indigo-600 form-radio'/>
                                <span class='ml-2 text-sm'>25</span>
                            </label>
                        </div>
                        <div class='w-full'>
                            <label class='flex items-center'>
                                <input type='radio' name='num_rows' value='50' wire:model='numRows' class='w-4 h-4 text-indigo-600 form-radio'/>
                                <span class='ml-2 text-sm'>50</span>
                            </label>
                        </div>
                        <div class='w-full'>
                            <label class='flex items-center'>
                                <input type='radio' name='num_rows' value='100' wire:model='numRows' class='w-4 h-4 text-indigo-600 form-radio'/>
                                <span class='ml-2 text-sm'>100</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- LISTA --}}
    <x-tables.table>
        <x-slot name='thead'>
            <x-tables.tr>
                @foreach ($columns as $name_column => $column)
                    @if ($column['value'])
                        @if ($name_column == 'accions')
                            <x-tables.th class='text-right'>
                                {{$column['name']}}
                            </x-tables.th>
                        @else
                            <x-tables.td class='text-left'>
                                @if ( !isset($column['sortable']) || (isset($column['sortable'])  && $column['sortable']  ) )
                                    <div wire:click="sortBy('{{$name_column}}')" class='flex items-center cursor-pointer gap-x-2'>
                                        {{ $column['name'] }} 
                                        @if ($sortField == $name_column)
                                            @if ($sortOrder == 'asc')
                                                <i class='fas fa-sort-up'></i>
                                            @else
                                                <i class='fas fa-sort-down'></i>
                                            @endif
                                        @endif							
                                    </div>
                                @else
                                    <div class='flex items-center gap-x-2'>
                                        {{ $column['name'] }} 
                                    </div>
                                @endif
                            </x-tables.td>
                        @endif
                    @endif
                @endforeach
            </x-tables.tr>
        </x-slot>
    
        <x-slot name='tbody'>
            @foreach ($addresses as $address)
                <x-tables.tr>
                    @foreach ($columns as $name_column => $column)
                        @if ($column['value'])
                                @if ($name_column == 'id')
                                    <x-tables.td class='text-left'>
                                        {{ $address->id }}
                                    </x-tables.td>
                                @elseif ($name_column == 'name')
                                    <x-tables.td class='text-left'>
                                        {{ $address->name }}
                                    </x-tables.td>
                                @elseif ( $name_column == 'accions')
                                    <x-tables.td>
                                        <div class='flex flex-wrap justify-end gap-x-2'>
                                        
                                            @can('admin.addresses.show')
                                                <a href="{{ route('admin.addresses.show', $address->id) }}">
                                                    <i class='px-2 cursor-pointer fas fa-eye'></i>
                                                </a>
                                            @endcan
                                            @can('admin.addresses.edit')
                                                <a href="{{ route('admin.addresses.edit', $address) }}" >
                                                    <i class='px-2 cursor-pointer fas fa-pen'></i>
                                                </a>
                                            @endcan
                                            @can('admin.addresses.destroy')
                                                <div id='dropdown_delete_{{$address}}' x-data='{dropdown:false}' >
                                                    <div x-on:click='dropdown=true'>
                                                        <div>
                                                            <i class='px-2 cursor-pointer fas fa-trash'></i>
                                                        </div>
                                                    </div>
                                                    <div x-show='dropdown' x-cloak >
                                                        <x-modals.alert>
                                                            <x-slot name='header'>
                                                                Eliminar Direccion
                                                            </x-slot>
                                                            <x-slot name='body'>
                                                                Seguro deseas eliminar {{$address->name}}?
                                                            </x-slot>
                                                            <x-slot name='footer'>
                                                                <x-jet-danger-button wire:click='delete({{$address->id}})'>
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
                                        </div>
                                    </x-tables.td>
                                @else
                                    @if (isset($column['type']) && $column['type'] == 'date')
                                        <x-tables.td class='text-left'>
                                            {{ Helper::date($address->$name_column)->format('d-m-Y') }}
                                        </x-tables.td>
                                        
                                    @elseif(isset($column['type']) && $column['type'] == 'money')
                                        <x-tables.td class='text-left'>
                                        $ {{ number_format($address->$name_column,0,',','.') }}
                                        </x-tables.td>
                                    @elseif(isset($column['type']) && $column['type'] == 'image')
                                        <x-tables.td class='text-left'>
                                            {{$address->$name_column }}
                                        </x-tables.td>
                                    @elseif(isset($column['type']) && $column['type'] == 'text')
                                        <x-tables.td class='text-left'>
                                            <div id='tooltip_' x-data='{tooltip:false}' x-on:mouseleave='tooltip=false'>
                                                <div x-on:mouseover='tooltip=true' class="cursor-pointer">
                                                    {{ Str::limit($address->$name_column,10) }}
                                                </div>
                                                <div x-show='tooltip' x-cloak >
                                                    <div class='absolute p-4 bg-white rounded shadow'>
                                                       {{ $address->$name_column }}
                                                    </div>
                                                </div>
                                            </div>
                                        </x-tables.td>
                                    @else
                                        <x-tables.td class='text-left'>
                                            {{ $address->$name_column }}
                                        </x-tables.td>
                                    @endif
                                @endif
                        @endif
                    @endforeach                    
                </x-tables.tr>
            @endforeach
        </x-slot>
    </x-tables.table>

    {{-- PAGINACION --}}
    <div class='py-4'>
        {{ $addresses->links() }}
    </div>
</div>
