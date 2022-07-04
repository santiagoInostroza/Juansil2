<x-admin-layout>
    @section('title', ' - Mostrar Compra')
    <div class='flex flex-wrap justify-between items-center gap-x-4 p-4'>
        <h1 class='text-xl'> {{$purchase->name}}</h1>
        <a href="{{ route('admin.purchases.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    <div class='p-4'>
        <livewire:admin.purchases.show :purchase='$purchase'/>
    </div>
</x-admin-layout>