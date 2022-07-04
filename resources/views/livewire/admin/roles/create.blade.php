<div class="p-4">
    <div class="flex flex-wrap justify-between items-center gap-x-4 mb-2">
        <h1 class="text-xl">Crear Rol</h1>
        <a href="{{ route('admin.roles.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    <form wire:submit.prevent="saveRol" class="grid gap-4 bg-white shadow p-4 rounded">
        <div>
            <label>
                <div class="py-1">Nombre del rol</div>
                <x-jet-input class="w-full p-2 border" placeholder="Ingresa el nombre del nuevo rol" wire:model.defer="name"></x-jet-input>
                @error('name')<span class="text-red-500 text-sm p-1">{{ $message }}</span>@enderror
            </label>
        </div>
        
        <div>
            <x-jet-button>Guardar</x-jet-button>
        </div>
    </form>
</div>




