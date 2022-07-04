<x-admin-layout>
    @section('title', ' - Crear cliente')
    <div class='flex flex-wrap justify-between items-center gap-x-4 p-4'>
        <h1 class='titlePage'>Crear Cliente</h1>
        <a href="{{ route('admin.customers.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    <div class='p-4'>
        <livewire:admin.customers.create/>
    </div>
</x-admin-layout>