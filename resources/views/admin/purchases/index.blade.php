<x-admin-layout>
    @section('title', ' - Compras')

    <div class='p-4'>
         {{-- HEADER --}}
        <div class='flex flex-wrap items-center justify-between gap-4 pb-4'>
            <h1 class='titlePage'>Compras <i wire:loading class='fas fa-spinner animate-spin text-2xl'></i> </h1>
            @can('admin.purchases.create')    
                <a href="{{ route('admin.purchases.create') }}" >
                    <x-jet-button>
                        Crear Compra
                    </x-jet-button>
                </a>
            @endcan
        </div> 
        <livewire:admin.purchases.index />
    </div>

</x-admin-layout>