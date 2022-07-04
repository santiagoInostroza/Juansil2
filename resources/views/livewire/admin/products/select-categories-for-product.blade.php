<ul class="grid gap-x-2">
    @foreach ($categories as $category)
        <x-categories.show-category :category="$category"></x-categories.show-category>
    @endforeach

    <div class="mt-4">
        <div id='dropdown_category' x-data="{dropdown:@entangle('categoryModal')}" >
            <div x-on:click='dropdown=true' >
                <x-jet-button>
                   Crear nueva categoría 
                </x-jet-button>
            </div>
            <div x-show='dropdown' x-cloak>
                <x-modals.basic>
                    <x-slot name='header'>
                        <div class="flex justify-between items-center gap-4 p-4">
                            Nueva categoría
                            <div x-on:click='dropdown=false'>
                                <i class="fas fa-times hover:font-bold cursor-pointer px-2"></i>
                            </div>
                        </div>
                    </x-slot>
                    <x-slot name='body'>
                        <livewire:admin.categories.create :redirect="false"  />
                    </x-slot>
                </x-modals.basic>
            </div>
        </div>
    </div>
</ul>

