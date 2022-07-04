<x-admin-layout>
    @section('title', ' - Crear dirección')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC30rciXdqyWlqQXQJYrwE3Qs220le3PvY&libraries=places"></script>
    <script src="{{asset('js/apiMaps.js') }}"></script>

    <style>
        /* .image-wrapper {
            position: relative;
            padding-bottom: 56.25%;
        }

        .image-wrapper img {
            position: absolute;
            object-fit: contain;
            width: 100%;
            height: 100%;
        } */

        /* #map {
            height: 300px;
        } */

        /* .pac-container {
            z-index: 999999;
        } */

    </style>



    <div class='flex flex-wrap justify-between items-center gap-x-4 p-4'>
        <h1 class='titlePage'>Crear Direccion</h1>
        <a href="{{ route('admin.addresses.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    <div class='p-4'>
        <livewire:admin.addresses.create/>
    </div>
</x-admin-layout>