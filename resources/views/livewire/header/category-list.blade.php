

<ul class="bg-gradient-to-r from-gray-800 via-black to-gray-900 w-full text-white flex flex-wrap justify-center text-sm md:text-base">
    <li x-on:mouseover.away="isOpenInfoCategory = false"
        class="border-b-4 border-transparent"
        :class="{'hover:border-red-600 cursor-pointer': isOpenInfoCategory}"
        x-on:mouseover="isOpenInfoCategory = true"
        x-data="{
            isOpenInfoCategory : false,
        }">
        <div wire:click="setCategory()"  class=" p-1 px-2 md:px-4 lg:px-8 xl:px-12" >
            <span> Todo </span>
        </div>
        {{-- <div x-cloak x-show="isOpenInfoCategory" x-transition.opacity class="bg-white text-gray-800 shadow-xl mt-1 absolute z-10">  
            <ul class="flex gap-4 w-max">  
                @foreach ($categories as $child)
                    <x-categories.show-category :category="$child" :event="'setCategory'" />
                @endforeach
            </ul>
        </div> --}}
    </li>
    @foreach ($categories as $category)
        <li x-on:mouseover.away="isOpenInfoCategory = false"
            class="border-b-4 border-transparent"
            :class="{'hover:border-red-600 cursor-pointer': isOpenInfoCategory}"
            x-on:mouseover="isOpenInfoCategory = true"
            x-data="{
                isOpenInfoCategory : false,
            }">
            <div wire:click="setCategory({{ $category->id }})"  class=" p-1 px-2 md:px-4 lg:px-8 xl:px-12" >
                <span> {{$category->name}} </span>
            </div>
            <div x-cloak x-show="isOpenInfoCategory" x-transition.opacity class="text-gray-800 bg-white shadow-xl mt-1  absolute z-10">    
                <ul class="flex gap-2 flex-col w-max">  
                    @foreach ($category->children as $child)
                        <x-categories.show-category :category="$child" :event="'setCategory'"/>
                    @endforeach
                </ul>
            </div>
        </li>
    @endforeach
</ul>
