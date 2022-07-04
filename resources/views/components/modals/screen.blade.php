<div class="fixed inset-0 bg-gray-100 z-10 h-screen overflow-auto">
    <div class=" shadow rounded">
        
        <div class=" relative  text-sm md:text-base">
            @if (isset($header))
                <div class="text-xl bg-white">
                    {{$header}}
                </div>
                <hr>
            @endif
            @if (isset($body))
                <div class="bg-white">  
                    {{$body}}
                </div>     
            @endif
            @if (isset($footer))
                <hr>
                <div class="my-4"> {{$footer}} </div>
            @endif
        </div>
        
    </div>
</div>