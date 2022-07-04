<div>

    
   
    <div class="text-4xl font-bold my-4 text-center">
        {{$nameMonth}}
    </div>

  

    <div class="flex flex-wrap gap-4 items-center mt-4">

        <a href="{{route('admin.orders.index')}}">
            <div class="border-rounded bg-white shadow-xl p-4 border-2  border-transparent hover:border-b-indigo-900 cursor-pointer">
                <div class="flex items-center justify-between gap-x-8 ">
                    <div class="grid gap-y-2">
                        <div>
                            {{$cantTotalSalesOfTheMonth}}  Pedidos
                        </div>
                        <div class="font-bold text-gray-500">
                            ${{ number_format($totalSalesOfTheMonth,0,',','.')}}
                        </div>
                        
                    </div>
                    <div class="rounded-full bg-gradient-to-r from-indigo-900 via-indigo-500 to-indigo-900 flex justify-center items-center p-3">
                        <i class="fas fa-cash-register text-white"></i>
                    </div>

                </div>
            </div>
            
        </a>
        <a href="{{route('admin.orders.index')}}">
            <div class="border-rounded bg-white shadow-xl p-4 border-2  border-transparent hover:border-b-indigo-900 cursor-pointer">
                <div class="flex items-center justify-between gap-x-8 ">
                    <div class="grid gap-y-2">
                        <div>
                            {{$cantTotalSalesOfTheMonth}}  Compras
                        </div>
                        <div class="font-bold text-gray-500">
                            ${{ number_format($totalSalesOfTheMonth,0,',','.')}}
                        </div>
                        
                    </div>
                    <div class="rounded-full bg-gradient-to-r from-indigo-900 via-indigo-500 to-indigo-900 flex justify-center items-center p-3">
                        <i class="fas fa-cash-register text-white"></i>
                    </div>

                </div>
            </div>
            
        </a>
        <a href="{{route('admin.orders.index')}}">
            <div class="border-rounded bg-white shadow-xl p-4 border-2  border-transparent hover:border-b-indigo-900 cursor-pointer">
                <div class="flex items-center justify-between gap-x-8 ">
                    <div class="grid gap-y-2">
                        <div>
                            {{$cantTotalSalesOfTheMonth}}  Stock
                        </div>
                        <div class="font-bold text-gray-500">
                            ${{ number_format($totalSalesOfTheMonth,0,',','.')}}
                        </div>
                        
                    </div>
                    <div class="rounded-full bg-gradient-to-r from-indigo-900 via-indigo-500 to-indigo-900 flex justify-center items-center p-3">
                        <i class="fas fa-cash-register text-white"></i>
                    </div>

                </div>
            </div>
            
        </a>

      

    
    </div>


    <livewire:admin.products.show-expired-products />
    
</div>
