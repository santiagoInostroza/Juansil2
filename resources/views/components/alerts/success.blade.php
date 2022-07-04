<div x-data="{isOpenAlert:true}" class=" shadow">
    <div  x-show="isOpenAlert" class="animate-pulse flex justify-between items-center  w-full p-4 bg-green-500 text-white font-bold">
        <div class="animate-bounce w-full">
            {{$slot}}
        </div>
        <div class="p-2 cursor-pointer text-white" x-on:click="isOpenAlert=false">
            <i class="fas fa-times"></i>
        </div>
    </div>  
</div>