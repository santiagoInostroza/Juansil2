<?php

namespace App\Http\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\PurchaseItem;
use Livewire\Component;

class ShowExpiredProducts extends Component{

    public function render(){
        // date more 10 days
        $products = PurchaseItem::where('expiration_notice_date', '<=', date('Y-m-d'))->orderBy('expired_date', 'asc')->get();
       
        return view('livewire.admin.products.show-expired-products',[
            'products' => $products,
        ]);
    }
}
