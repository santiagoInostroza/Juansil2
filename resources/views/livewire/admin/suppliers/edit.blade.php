    <div>
        <div  class='grid gap-4 bg-white shadow p-4 rounded'>
            <div>
                <label>
                    <div class='py-1'>Nombre</div>
                    <x-jet-input class='w-full p-2 border' placeholder='Ingresa el nombre' wire:model.defer='supplier.name'></x-jet-input>
                    @error('supplier.name')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
                </label>
            </div>
            
            
            <div>
                <x-jet-button wire:click='update()'>Actualizar</x-jet-button>
            </div>
        </div>
    </div>
    
