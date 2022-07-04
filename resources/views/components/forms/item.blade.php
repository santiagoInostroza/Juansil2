<div class="px-4">
    <label {{ $attributes->merge(['class' => 'grid grid-cols-1 md:grid-cols-9 px-4']) }}>
        @isset($label) 
            <div class='col-span-1 md:col-span-2 font-bold'>{{$label}}</div>
        @endisset
        @isset($slot)
            <div class='col-span-1 md:col-span-7'>
                {{$slot}}
            </div>
        @endisset
    </label>
</div>   