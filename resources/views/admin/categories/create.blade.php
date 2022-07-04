<x-admin-layout>
    @section('title', ' - Crear Categoria')
    <div class='flex flex-wrap justify-between items-center gap-x-4 p-4'>
        <h1 class='titlePage'>Crear Categoria</h1>
        <a href="{{ route('admin.categories.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    <livewire:admin.categories.create/>
</x-admin-layout>