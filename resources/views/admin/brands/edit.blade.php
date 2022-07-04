<x-admin-layout>
    @section('title', ' - Editar Marca')
    <div class='flex flex-wrap justify-between items-center gap-x-4 mb-2'>
        <h1 class='text-xl'>Editar Marca</h1>
        <a href="{{ route('admin.brands.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    <div class='p-4'>
        <livewire:admin.brands.edit :brand='$brand'/>
    </div>
</x-admin-layout>