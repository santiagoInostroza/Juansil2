<x-admin-layout>
    @section('title', ' - Crear producto')
    
    <div class="max-w-6xl p-4 m-auto">
        <div class='flex flex-wrap items-center justify-between my-12 gap-x-4'>
            <h1 class='titlePage'>Crear Producto</h1>
            <a href="{{ route('admin.products.index') }}" >
                <x-jet-button>
                    Ir a la lista
                </x-jet-button>
            </a>
        </div>
        <div>
            <livewire:admin.products.create/>
        </div>
    
    </div>
</x-admin-layout>