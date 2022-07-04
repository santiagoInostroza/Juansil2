<x-admin-layout>
    @section('title', ' - Crear Marca')
    <div class='flex flex-wrap justify-between items-center gap-x-4 p-4'>
        <h1 class='titlePage'>Crear Marca</h1>
        <a href="{{ route('admin.brands.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    <div class='p-4'>
        <livewire:admin.brands.create/>
    </div>
</x-admin-layout>