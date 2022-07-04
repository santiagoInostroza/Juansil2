<div class=""  wire:ignore >
    
    <div class="grid grid-cols-1  gap-8 font-bold">
        
        <x-forms.form class="px-2 md:px-4 lg:px-8 xl:px-12">
            <x-slot name="footer">
                <x-jet-button wire:click='save'>Guardar</x-jet-button>
            </x-slot>

            <div class="w-full h-6"></div>
            
           
            @if ($customer)
                <x-forms.item>
                    <x-slot name="label">Cliente</x-slot>
                    {{$customer->name}}
                </x-forms.item>
            @endif
            <x-forms.item>
                <x-slot name="label">Dirección</x-slot>
                <div>
                    <x-jet-input class='w-full p-2 border border-gray-400  rounded-md shadow-md' placeholder='Ingresa dirección' id="address" wire:model.defer='name'></x-jet-input>
                   k @error('name')<span class='text-red-500 text-sm p-1'>{{ $message }} oo</span>@enderror k
                </div>
            </x-forms.item>
            <x-forms.item>
                <x-slot name="label">Alias (opcional)</x-slot>
                <x-jet-input class='w-full p-2 border border-gray-400  rounded-md shadow-md' placeholder='Ingresa alias' id="alias" wire:model.defer='alias'></x-jet-input>
                @error('alias')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
            </x-forms.item>
            <x-forms.item>
                <x-slot name="label">Torre o block (opcional)</x-slot>
                <x-jet-input class='w-full p-2 border border-gray-400  rounded-md shadow-md' placeholder='Si vives en torre o block ingresa el número' wire:model.debounce.defer='tower'></x-jet-input>
                @error('tower')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
            </x-forms.item>
            <x-forms.item>
                <x-slot name="label">Número departamento (opcional)</x-slot>
                <x-jet-input class='w-full p-2 border border-gray-400  rounded-md shadow-md' placeholder='Si vives en departamento ingresa el número' wire:model.debounce.defer='department'></x-jet-input>
                @error('department')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
            </x-forms.item>
            <x-forms.item>
                <x-slot name="label">Comentario (opcional)</x-slot>
                <textarea class='w-full p-2 border border-gray-400  rounded-md shadow-md' placeholder='Puedes ingresar indicaciones extras, o si el mapa envía hacia otro lado puedes pegar el link de tu ubicación' wire:model.defer='comment'></textarea>
                @error('comment')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
            </x-forms.item>

            <x-forms.item>
                <x-slot name="label">Mapa</x-slot>
                <div wire:ignore>

                    <div class=" bg-white rounded shadow" >
                        <div  id="map" class="h-96 w-full border rounded shadow " ></div>
                    </div>
                    <div id="infowindow-content">
                        <span id="place-name" class="title"></span><br />
                        {{-- <strong>Place ID</strong>: <span id="place-id"></span><br /> --}}
                        <span id="place-address"></span>
                    </div>
                </div>
            </x-forms.item>

            
            
        

            <div class="hidden">

                <div>
                    <label>
                        <div class='py-1'>Calle</div>
                        <x-jet-input class='w-full p-2 border border-gray-400  rounded-md shadow-md' placeholder='' id="street" wire:model.defer='street'></x-jet-input>
                        @error('street')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
                    </label>
                </div>
                <div>
                    <label>
                        <div class='py-1'>Número</div>
                        <x-jet-input class='w-full p-2 border border-gray-400  rounded-md shadow-md' placeholder='' id="number" wire:model.defer='number'></x-jet-input>
                        @error('number')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
                    </label>
                </div>
                <div>
                    <label>
                        <div class='py-1'>Comuna</div>
                        <x-jet-input class='w-full p-2 border border-gray-400  rounded-md shadow-md' placeholder='' id="commune" wire:model.defer='commune'></x-jet-input>
                        @error('commune')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
                    </label>
                </div>
                
                
                <div>
                    <label>
                        <div class='py-1'>place id</div>
                        <x-jet-input class='w-full p-2 border' placeholder='Ingresa el nombre' id="place_id" wire:model.defer='place_id'></x-jet-input>
                        @error('place_id')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
                    </label>
                </div>
                <div>
                    <label>
                        <div class='py-1'>latitude id</div>
                        <x-jet-input class='w-full p-2 border' placeholder='Ingresa el nombre' id="latitude" wire:model.defer='latitude'></x-jet-input>
                        @error('latitude')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
                    </label>
                </div>
                <div>
                    <label>
                        <div class='py-1'>longitude id</div>
                        <x-jet-input class='w-full p-2 border' placeholder='Ingresa el nombre' id="longitude" wire:model.defer='longitude'></x-jet-input>
                        @error('longitude')<span class='text-red-500 text-sm p-1'>{{ $message }}</span>@enderror
                    </label>
                </div>
                
            </div>
      
            
        </x-forms.form>

        
        
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('message.processed', (message, component) => {
                console.log('inicializado9');
                initMap();
               
            })
        });
    </script>

</div>
