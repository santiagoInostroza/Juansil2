<div>
   <div class='grid gap-4 bg-white shadow p-4 rounded'>
        <div>
            <label>
                <div class='py-1'>Nombre</div>
                <x-jet-input class='w-full p-2 border' placeholder='Ingresa nombre' wire:model.defer='name'></x-jet-input>
                @error('name')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
            </label>
        </div>
        <div>
            <label>
                <div class='py-1'>Email</div>
                <x-jet-input class='w-full p-2 border' type="email" placeholder='Ingresa email' wire:model.defer='email'></x-jet-input>
                @error('email')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
            </label>
        </div>

        <div>
            <label>
                <div class='py-1'>Cel</div>
                <x-jet-input class='w-full p-2 border' type="tel" placeholder='Ingresa cel' wire:model.defer='celphone'></x-jet-input>
                @error('celphone')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
            </label>
        </div>
        
      
        
        <div>
            <x-jet-button wire:click='save'>Guardar</x-jet-button>
        </div>
    </div>
</div>
