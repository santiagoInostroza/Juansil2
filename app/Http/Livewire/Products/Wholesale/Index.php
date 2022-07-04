<?php

namespace App\Http\Livewire\Products\Wholesale;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class Index extends Component{
    public $products;
    public $category;

    protected $listeners = [
        'productAddedToCart' => 'render',
        'productRemovedFromCart' => 'render',
        'productSetFromCart' => 'render',
        'setCategory' 
    ];

    public function mount(){
        // session()->pull('cart');
        $this->category = (session()->has('home.category')) ? session()->get('home.category') : null;
    }
    
    public function render(){
        
        
        if ( $this->category ){
           
            $this->products = ( count($this->category->products)>0 )  ? $this->category->products : null;


            if ($this->category->children) {
                foreach ($this->category->children as $child) {
                    if ($this->products) {
                        $this->products->concat($child->products);
                    }else{
                        $this->products = $child->products;
                    }
                }
            }
        }else{
            $this->products = Product::with('image')->get();
        }
        
        
        

        return view('livewire.products.wholesale.index');
    }

    public function setCategory($category_id = null){
        if ($category_id) {
            $this->category = Category::find($category_id);
            session()->put('home.category', $this->category);
        }else{
            $this->category = null;
            session()->forget('home.category');
        }
       
    }

    public function addItemToCart($product_id){
        $productController = new \App\Http\Controllers\ProductController();
        $productController->addItemToCartWS($product_id);
        $this->emit('productAddedToCart');
        $this->dispatchBrowserEvent('salert',[
            'title' =>  'Se ha agregado el producto al carrito! ',
            'type' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
        ]);
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
