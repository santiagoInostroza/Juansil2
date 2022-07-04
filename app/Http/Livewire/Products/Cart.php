<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;

class Cart extends Component{

    protected $listeners = [
        'productAddedToCart' => 'render',
        'productRemovedFromCart' => 'render',
        'productSetFromCart' => 'render',
    ];


    public function render(){
        return view('livewire.products.cart');
    }

    public function removeItemFromCart($product_id){
        $productController = new \App\Http\Controllers\ProductController();
        $productController->removeItemFromCartWS($product_id);
        $this->emit('productRemovedFromCart');
        $this->dispatchBrowserEvent('salert',[
            'title' =>  'Se ha eliminado el producto del carrito! ',
            'type' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
        ]);

    }

    public function setItemFromCart($product_id, $quantity){
        $productController = new \App\Http\Controllers\ProductController();
        $productController->setItemFromCartWS($product_id, $quantity);
        $this->emit('productSetFromCart');
    }

    

}
