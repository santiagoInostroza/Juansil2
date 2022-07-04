<x-admin-layout>
    @section('title', ' - Mostrar Cliente')
    <div class='flex flex-wrap justify-between items-center gap-x-4 p-4'>
        <h1 class='titlePage'> {{$customer->name}}</h1>
        <a href="{{ route('admin.customers.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    <div class='p-4'>
        <livewire:admin.customers.show :customer='$customer'/>
    </div>
</x-admin-layout>