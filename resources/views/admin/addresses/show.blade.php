<x-admin-layout>
    @section('title', ' - Mostrar dirección')
    <div class='flex flex-wrap justify-between items-center gap-x-4 p-4'>
        <h1 class='text-xl'> {{$address->name}}</h1>
        <a href="{{ route('admin.addresses.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    <div class='p-4'>
        <livewire:admin.addresses.show :address='$address'/>
    </div>
</x-admin-layout>