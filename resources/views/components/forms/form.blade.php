<div {{ $attributes->merge(['class' => 'grid gap-4 bg-white shadow-md rounded-md ']) }}>
    @isset($header)
        <h2 class="flex p-4 px-8 bg-gray-50 font-bold rounded-t-md">{{$header}}</h2>
    @endisset

    @isset($slot)
  
        {{$slot}}
    @endisset

    
    @isset($footer)
        
        <div class="flex justify-end p-4 px-8 bg-gray-50 rounded-b-md">
            {{$footer}}
        </div>
        
    @endisset
</div>