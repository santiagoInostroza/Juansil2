<x-admin-layout>
    @section('title', ' - Editar Proveedor')
    <div class='flex flex-wrap justify-between items-center gap-x-4 p-4'>
        <h1 class='titlePage'>Editar Proveedor</h1>
        <a href="{{ route('admin.suppliers.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    <div class='p-4'>
        <livewire:admin.suppliers.edit :supplier='$supplier'/>
    </div>
</x-admin-layout>