

<li id="category_{{$category->id}}" x-data="{ isOpenCategory:false}" >
    @if ($category->children->count() > 0)
        <div class="flex justify-between gap-4 items-center p-2 cursor-pointer   hover:bg-gray-200 font-bold pr-6 {{$liclass}}" style="padding-left: {{$pl}}px" x-on:click="isOpenCategory = !isOpenCategory">
            <span> {{ $category->name }} </span>
            <i x-show="!isOpenCategory" class="fas fa-chevron-down text-gray-600 text-sm"></i>
            <i x-show="isOpenCategory" class="fas fa-chevron-up text-gray-600 text-sm"></i>
        </div>
        <ul x-show="isOpenCategory" x-cloak x-transition> 
            @foreach ($category->children as $category2)
                {{-- <x-categories.show-category :category="$category2" :liclass="$liclass" :pl="$pl" ></x-categories.show-category>  --}}
            @endforeach 
        </ul>
    @else
        <div class="flex justify-between gap-4 items-center p-2 cursor-pointer hover:bg-gray-200  pr-6 {{$liclass}} " style="padding-left: {{$pl}}px" >
            <span> {{ $category->name }} </span>
        </div>
    @endif
</li>
