<x-admin-layout>
    @section('title', ' - Crear pedido')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC30rciXdqyWlqQXQJYrwE3Qs220le3PvY&libraries=places"></script>
    <script  src="{{asset('js/apiMaps.js') }}"></script>

    
    <div class='flex flex-wrap justify-between items-center gap-x-4 p-4'>
        <h1 class='text-xl'>Crear pedido</h1>
        <a href="{{ route('admin.orders.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    <div class='p-4'>
        <livewire:admin.orders.create/>
    </div>


</x-admin-layout>