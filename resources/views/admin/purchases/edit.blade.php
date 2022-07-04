<x-admin-layout>
    @section('title', ' - Editar compra')
    <div class='flex flex-wrap justify-between items-center gap-x-4 p-4'>
        <h1 class='titlePage'>Editar Compra</h1>
        <a href="{{ route('admin.purchases.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    <div class='p-4'>
        <livewire:admin.purchases.edit :purchase='$purchase' :redirect="false" />
    </div>
</x-admin-layout>