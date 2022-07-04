<div class="">
    @if (isset($title) || isset($subtitlle))
        <header class=" py-4 border-b border-gray-100">
    @endif
    @if (isset($title) )
        <h2 class="uppercase tracking-wide ">{{ $title }}</h2>
    @endif
    @if (isset($subtitle))
        {{$subtitle}}
    @endif
    @if (isset($title) || isset($subtitlle))
        </header>
    @endif
   
    
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400  table-auto  rounded bg-white">
            @if (isset($thead))
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 ">
                    {{ $thead}}
                </thead>
            @endif
            @if (isset($tbody))
                <tbody class="text-xs divide-y divide-gray-100">
                    
                    {{ $tbody}}               
                </tbody>
            @endif
        </table>
    </div>
</div>