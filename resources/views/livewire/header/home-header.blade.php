<div class="px-6 py-2 bg-gradient-to-r from-gray-600 via-gray-400 to-gray-700 w-full text-white font-bold flex justify-between items-center">
    <div class="flex gap-6 items-center">
        {{-- <i class="fas fa-bars"></i> --}}
       <livewire:header.home-logo>
    </div>
    <div class="w-full mx-6 md:mx-12 xl:mx-24 max-w-4xl">
       <livewire:header.home-searcher />
    </div>
    <div class="flex gap-6 items-center">
        <div>
            <livewire:products.cart>
        </div>

        <div>
            <livewire:header.menu />
        </div>
    </div>
</div>
