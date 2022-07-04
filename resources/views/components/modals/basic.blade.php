<div>
    <style>
        ::-webkit-scrollbar {
            display: none;
        }
    </style>
    <div class="fixed inset-0 bg-gray-600 opacity-90 z-10"></div>
    <div class="fixed inset-0 flex justify-center items-center z-10 " >
        <div class="bg-white shadow rounded relative" style="min-width: 500px" >
            
           
            <div class="text-sm md:text-base overflow-auto  @if (isset($header)) pt-16 @endif " style="max-height: calc(100vh - 80px)">
                @if (isset($body))
                    <div class="">  
                        {{$body}}
                    </div>     
                @endif
                @if (isset($footer))
                    <hr>
                    <div class=""> {{$footer}} </div>
                @endif
            </div>

            @if (isset($header))
                <div class="text-xl absolute top-0 left-0 right-0">
                    {{$header}}
                </div>
                <hr>
            @endif
            
        </div>
    </div>
</div>