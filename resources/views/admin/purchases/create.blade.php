<x-admin-layout>
    @section('title', ' - Crear compra')
    <div class='flex flex-wrap justify-between items-center gap-x-4 p-4'>
        <h1 class='titlePage'>Crear Compra</h1>
        <a href="{{ route('admin.purchases.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    <div class='px-4'>
        <livewire:admin.purchases.create/>
    </div>
</x-admin-layout>