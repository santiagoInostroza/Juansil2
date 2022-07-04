<x-admin-layout>
    @section('title', ' - Crear proveedor')
    <div class='flex flex-wrap justify-between items-center gap-x-4 p-4'>
        <h1 class='text-xl'>Crear Proveedor</h1>
        <a href="{{ route('admin.suppliers.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    <livewire:admin.suppliers.create/>
</x-admin-layout>