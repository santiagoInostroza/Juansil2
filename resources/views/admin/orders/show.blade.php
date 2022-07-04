<x-admin-layout>
    @section('title', ' - Mostrar pedido')
    <div class='flex flex-wrap justify-between items-center gap-x-4 p-4'>
        <h1 class='titlePage'> {{$order->name}}</h1>
        <a href="{{ route('admin.orders.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    <div class='p-4'>
        <livewire:admin.orders.show :order='$order'/>
    </div>
</x-admin-layout>