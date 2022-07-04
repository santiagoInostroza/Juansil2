<div class="grid gap-8">
    <x-forms.form class="">
        <x-slot name="header">
            Datos
        </x-slot>
        <x-slot name="footer"><x-jet-button wire:click='update'>Realizar cambios</x-jet-button></x-slot>
        

        <x-forms.item>
            <x-slot name="label">Nombre</x-slot>
            <x-jet-input class='w-full p-2 border' placeholder='Ingresa el nombre' wire:model.defer='name'></x-jet-input>
            @error('name')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
        </x-forms.item>
        <x-forms.item>
            <x-slot name="label">Email</x-slot>
            <x-jet-input class='w-full p-2 border' placeholder='Ingresa el email' wire:model.defer='email'></x-jet-input>
            @error('email')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
        </x-forms.item>
        <x-forms.item>
            <x-slot name="label">Celular</x-slot>
            <x-jet-input class='w-full p-2 border' placeholder='Ingresa celular' wire:model.defer='celphone'></x-jet-input>
            @error('celphone')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
        </x-forms.item>

    </x-forms.form>

    <x-forms.form>
        <x-slot name="header">
            Direcciones
        </x-slot>
        <div class="p-4">
            <livewire:admin.customers.addresses.edit :customer="$customer" :redirect="false" />        
        </div>
    </x-forms.form>
    
   

 

 </div>