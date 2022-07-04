<div class='p-4'>
    <div class='flex flex-wrap justify-between items-center gap-x-4 mb-2'>
        <h1 class='text-xl'>Crear Permiso</h1>
        <a href="{{ route('admin.permissions.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    <form wire:submit.prevent='save' class='grid gap-4 bg-white shadow p-4 rounded'>
        <div>
            <label>
                <div class='py-1'>Nombre del permiso</div>
                <x-jet-input class='w-full p-2 border' placeholder='Ingresa el nombre' wire:model.defer='name'></x-jet-input>
                @error('name')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
            </label>
        </div>
        
       
        <div>
            <label>
                <div class='py-1'>Descripcion</div>
                <x-jet-input class='w-full p-2 border' placeholder='Ingresa descripcion' wire:model.defer='description'></x-jet-input>
                @error('description')<span class='text-red-500 text-sm p-1'>{{ message }}</span>@enderror
            </label>
        </div>

        <hr>

        <div>
            <x-jet-button>Guardar</x-jet-button>
        </div>
    </form>
</div>
