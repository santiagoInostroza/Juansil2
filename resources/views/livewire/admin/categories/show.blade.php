<div class='p-4'>
    <div class='flex flex-wrap justify-between items-center gap-x-4 mb-2'>
        <h1 class='text-xl'>Permiso {{$category->name}}</h1>
        <a href="{{ route('admin.categories.index') }}" >
            <x-jet-button>
                Ir a la lista
            </x-jet-button>
        </a>
    </div>
    
    <div class='p-4 bg-white rounded shadow'>
        <div class='grid grid-cols-2 flex-wrap items-center mb-4 gap-4'>
            @foreach ($category->getAttributes() as $key => $item)
                <div class='w-full'>
                    <label class='block text-gray-700 text-sm font-bold mb-2' for='name'>
                        {{$key}} 
                    </label>
                    <input class='shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline' id='name' type='text' value='{{$item}}' readonly>
                </div>
            @endforeach
            
        </div>
    </div>
</div>
