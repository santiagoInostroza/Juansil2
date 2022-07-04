<div>

    {{-- HEADER --}}
    <div class='flex flex-wrap justify-between gap-4 pb-4'>
        <h1 class='text-2xl'>Clientes <i wire:loading class='fas fa-spinner animate-spin text-2xl'></i> </h1>
       @can('admin.customers.create')    
            <a href="{{ route('admin.customers.create') }}" >
                <x-jet-button>
                    Crear Cliente
                </x-jet-button>
            </a>
       @endcan
    </div> 
    {{--FILTROS  --}}
    <div class='pb-4 flex flex-wrap justify-between gap-x-4 items-center'>
        {{-- BUSCADOR --}}
        <label class='flex-1 flex justify-between gap-x-4 items-center md:mr-4'>
            <x-jet-input wire:model.debounce.1s='search' class='w-full p-2 border' placeholder='Que deseas buscar?'></x-jet-input>
            <i wire:loading class='fas fa-spinner animate-spin'></i>
            <i wire:loading.remove class='fas fa-search'></i>
        </label>

        {{-- COLUMNAS --}}
        <div>
            <div id='dropdown_num_col' x-data='{dropdown:false}' >
                <div x-on:click='dropdown=true'>
                    <div class='bg-white rounded border shadow p-2 cursor-pointer select-none'>
                        columnas
                    </div>
                </div>
                <div x-show='dropdown' x-cloak x-transition x-on:click.away='dropdown=false'>
                    <div class='bg-white rounded shadow absolute z-10'>
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
                                        <input type='checkbox' wire:model="columns.{{$key}}.value"  class='form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out'>
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
                <div class='bg-white rounded border shadow p-2 cursor-pointer select-none'>
                    mostrar {{$numRows}} filas
                </div>
            </div>
            <div x-show='dropdown' x-cloak x-transition x-on:click.away='dropdown=false'>
                <div class='bg-white rounded shadow p-4 absolute z-10'>
                    <div class='flex flex-wrap gap-4'>
                        <div class='w-full'>
                            <label class='flex items-center'>
                                <input type='radio' name='num_rows' value='10' wire:model='numRows' class='form-radio h-4 w-4 text-indigo-600'/>
                                <span class='ml-2 text-sm'>10</span>
                            </label>
                        </div>
                        <div class='w-full'>
                            <label class='flex items-center'>
                                <input type='radio' name='num_rows' value='25' wire:model='numRows' class='form-radio h-4 w-4 text-indigo-600'/>
                                <span class='ml-2 text-sm'>25</span>
                            </label>
                        </div>
                        <div class='w-full'>
                            <label class='flex items-center'>
                                <input type='radio' name='num_rows' value='50' wire:model='numRows' class='form-radio h-4 w-4 text-indigo-600'/>
                                <span class='ml-2 text-sm'>50</span>
                            </label>
                        </div>
                        <div class='w-full'>
                            <label class='flex items-center'>
                                <input type='radio' name='num_rows' value='100' wire:model='numRows' class='form-radio h-4 w-4 text-indigo-600'/>
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
                                <div wire:click="sortBy('{{$name_column}}')" class='cursor-pointer flex items-center gap-x-2'>
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
            @foreach ($customers as $customer)
                <x-tables.tr>
                    @foreach ($columns as $name_column => $column)
                        @if ($column['value'])
                                @if ($name_column == 'id')
                                    <x-tables.td class='text-left'>
                                        {{ $customer->id }}
                                    </x-tables.td>
                                @elseif ($name_column == 'name')
                                    <x-tables.td class='text-left'>
                                        {{ $customer->name }}
                                    </x-tables.td>
                                @elseif ( $name_column == 'accions')
                                    <x-tables.td>
                                        <div class='flex flex-wrap gap-x-2 justify-end'>
                                        
                                            @can('admin.customers.show')
                                                <a href="{{ route('admin.customers.show', $customer) }}">
                                                    <i class='fas fa-eye cursor-pointer px-2'></i>
                                                </a>
                                            @endcan
                                            @can('admin.customers.edit')
                                                <a href="{{ route('admin.customers.edit', $customer) }}" >
                                                    <i class='fas fa-pen cursor-pointer px-2'></i>
                                                </a>
                                            @endcan
                                            @can('admin.customers.destroy')
                                                <div id='dropdown_delete_{{$customer->id}}_{{rand()}}' x-data='{dropdown:false}' >
                                                    <div x-on:click='dropdown=true'>
                                                        <div>
                                                            <i class='fas fa-trash cursor-pointer px-2'></i>
                                                        </div>
                                                    </div>
                                                    <div x-show='dropdown' x-cloak >
                                                        <x-modals.alert>
                                                            <x-slot name='header'>
                                                                Eliminar Cliente
                                                            </x-slot>
                                                            <x-slot name='body'>
                                                                Seguro deseas eliminar {{$customer->name}}?
                                                            </x-slot>
                                                            <x-slot name='footer'>
                                                                <x-jet-danger-button wire:click='delete({{$customer->id}})'>
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
                                            {{ Helper::date($customer->$name_column)->format('d-m-Y') }}
                                        </x-tables.td>
                                        
                                    @elseif(isset($column['type']) && $column['type'] == 'money')
                                        <x-tables.td class='text-left'>
                                        $ {{ number_format($customer->$name_column,0,',','.') }}
                                        </x-tables.td>
                                    @elseif(isset($column['type']) && $column['type'] == 'image')
                                        <x-tables.td class='text-left'>
                                            {{$customer->$name_column }}
                                        </x-tables.td>
                                    @elseif(isset($column['type']) && $column['type'] == 'text')
                                        <x-tables.td class='text-left'>
                                            
                                            <div id='tooltip_{{$customer->$name_column}}' x-data='{tooltip:false}' x-on:mouseleave='tooltip=false'>
                                                <div x-on:mouseover='tooltip=true' class='cursor-pointer'>
                                                    {{ Str::limit($customer->$name_column,10) }}
                                                </div>
                                                <div x-show='tooltip' x-cloak >
                                                    <div class='bg-white rounded shadow p-4 absolute'>
                                                    {{ $customer->$name_column }}
                                                    </div>
                                                </div>
                                            </div>
                                        </x-tables.td>
                                    @else
                                        <x-tables.td class='text-left'>
                                            {{ $customer->$name_column }}
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
        {{ $customers->links() }}
    </div>
</div>
