<?php

namespace App\Http\Livewire\Admin\Purchases;

use App\Models\Product;
use Livewire\Component;
use App\Models\Purchase;
use App\Models\Supplier;
use PhpParser\JsonDecoder;
use App\Http\Controllers\Admin\PurchaseController;
use App\Models\MovementProduct;

class Create extends Component{

    public $name;
    public $redirect;

    public $products;
    public $suppliers;

    public $productModal;
    public $supplierModal;

    public $product_id;
    public $supplier_id;
    public $date;
    public $comment;




    public $listeners=[
        'closeProductModal',
        'addProductToSession',
        'closeSupplierModal',
    ];

    public function mount($redirect = true){
        $this->redirect = $redirect;
        $this->productModal = false;
        $this->supplierModal = false;
        $this->date = date('Y-m-d') . 'T' . date('H:i');
       
        $this->supplier_id = session('purchase.supplier_id')  ?? '';
        $this->date = session('purchase.date')  ?? date('Y-m-d') . 'T' . date('H:i');
        $this->comment = session('purchase.comment')  ?? '';
    }

    public function addProductToSession($product){
        $purchaseController = new PurchaseController();   
        $product = $purchaseController->addProductToSession($product['id']);

        if ($product) {
            $icon = "success";
            $title = $product->name . ' agregado a la lista';
        }else{
            $icon = "warning";
            $title = 'Ya está en lista';   
        }

        $this->dispatchBrowserEvent('salert',[
            'title' =>  $title,
            'icon' => $icon,
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
        ]);

        

    }

    public function removeFromPurchase($product_name){
        $purchaseController = new PurchaseController();   
        $purchaseController->removeFromSession($product_name);
        

        $this->dispatchBrowserEvent('salert',[
            'title' =>  $product_name . ' eliminado de la lista',
            'type' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
            ]);
    }

    public function setPurchase($key,$quantity,$quantity_box,$total_quantity,$price,$price_box,$total_price,$expired_date){
      
        $purchaseController = new PurchaseController();   
        $purchase_item = $purchaseController->setPurchase($key,$quantity,$quantity_box,$total_quantity,$price,$price_box,$total_price,$expired_date);
     
    }

    public function closeProductModal(Product $product){
        $this->productModal = false;
        $this->product_id = $product->id;
        $product= Product::with('image')->find($product->id);
        $this->addProductToSession($product);
    }

    public function closeSupplierModal(Supplier $supplier){
        $this->supplierModal = false;
        $this->supplier_id = $supplier->id;
        // $product= Product::with('image')->find($product->id);
        // $this->addProductToSession($product);

        $this->dispatchBrowserEvent('salert',[
            'title' =>  'Proveedor ' .  $supplier->name . ' agregado',
            'type' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
        ]);
    }

    public function updatedSupplierId(){
        session()->put('purchase.supplier_id',$this->supplier_id);
    }

    public function updatedDate(){
        session()->put('purchase.date',$this->date);
    }

    public function updatedComment(){
        session()->put('purchase.comment',$this->comment);
    }
    
  

    public function validateItems(){
       
        if (session()->has('purchase.items') && count(session('purchase.items')) >0) {        
            foreach (session('purchase.items') as $key => $item) {
                if ($item['quantity'] == '' || $item['quantity_box'] == '' || $item['price'] == '' || $item['price_box'] == '' || 
                $item['quantity'] <=0 || $item['quantity_box'] <=0 || $item['price'] <=0 || $item['price_box'] <=0 ) {
                    
                    $this->dispatchBrowserEvent('salert',[
                        'title' =>  'completa campos vacios',
                        'icon' => 'warning',
                        'position' => 'top',
                        'toast' => true,
                        'timer' => 2400,
                    ]);
                    return false;
                } 
            }
        }else{
            $this->dispatchBrowserEvent('salert',[
                'title' =>  'No hay productos en la lista',
                'icon' => 'warning',
                'position' => 'top',
                'toast' => true,
                'timer' => 2400,
            ]);
            return false;
        }
        return true;
    }
    
    public function save(){
        $this->validate([
            'supplier_id' => 'required',
            'date' => 'required',
            'comment' => 'nullable',
        ]);
        if (!$this->validateItems()) {
            return false;
        }
       
    
        $purchase = Purchase::create([
            'supplier_id' => $this->supplier_id,
            'total' => session('purchase.total'),
            'date' => date('Y-m-d H:i:'.date('s'),strtotime($this->date)) ,
            'comment' => $this->comment,
            'user_id_created' => auth()->user()->id,
           
        ]);
        foreach (session('purchase.items') as $key => $item) {

            $expiration_notice_days = Product::where('id',$item['product_id'])->first()->expiration_notice_days;
            
            if ( $item['expired_date'] != "" ) {
                $expiration_notice_date = date('Y-m-d', strtotime( $item['expired_date'] . ' -' . $expiration_notice_days .' days')) ;
                $expired_date = $item['expired_date'];

            }else{
                $expiration_notice_date = null;
                $expired_date = null;
            }
            
         
            $purchase_item =  $purchase->purchaseItems()->create(
                [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'quantity_box' => $item['quantity_box'],
                    'total_quantity' => $item['total_quantity'],
                    'price' => $item['price'],
                    'price_box' => $item['price_box'],
                    'total_price' => $item['total_price'],
                    'stock' => $item['total_quantity'],
                    'expired_date' => $expired_date,
                    'expiration_notice_date' => $expiration_notice_date,
                ]
            );

            // ACTUALIZAR STOCK
            $product = Product::find($item['product_id']);
            $product->stock = $product->stock + $item['total_quantity'];
            $product->save();

            // INGRESAR MOVIMIENTO PENDIENTE
            $movementProduct = MovementProduct::create([
                'product_id' => $product->id,
                'purchase_item_id' => $purchase_item->id,
                'purchase_id' => $purchase->id,
                'type' => 1, //entrada
                'name_type' => 1, //purchase
                'date' => $this->date,
                'user_id_created' => auth()->user()->id,
                // 'stock' => $product->stock,
            ]);
        }
       

        session()->forget('purchase');
    

        if($this->redirect){
            redirect()->route('admin.purchases.index')->with('success',  $purchase->name . ' creado correctamente');        
        }else {
            $this->emit('closePurchaseModal', $purchase->id);
            $this->dispatchBrowserEvent('salert',[
                'title' =>  'El permiso '. $purchase->name . ' ha sido creado correctamente',
                'type' => 'success',
                'position' => 'top',
                'toast' => true,
                'timer' => 2400,
            ]);
        }
    }


    public function render(){
        // session()->forget('purchase');
        $this->products = Product::with('image')->get();
        $this->suppliers = Supplier::all();
        return view('livewire.admin.purchases.create');
    }


}
