<?php

namespace App\Http\Livewire\Admin\Orders;

use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use Livewire\Component;
use App\Models\Customer;
use App\Models\PurchaseItem;
use App\Models\MovementProduct;
use App\Models\OrderPurchaseItems;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Session\Session;
use App\Http\Controllers\Admin\OrderController;

class Create extends Component{
    
   
    public $redirect;
    
    public $products;
    public $customers;
    public $addresses;
    public $openComment;
    
    public $productModal;
    public $customerModal;
    public $addressModal;
    public $showPaymentAccount;
    
    public $product_id;
    public $address_id;
    public $defaultAddress;
    
    public $customer;
    
    public $customer_id;
    public $date;
    public $subtotal;

    public $status;
    public $sale_type;


    // PAGO
    public $payment_amount;
    public $payment_status;
    public $payment_account;
    public $payment_account_comment;



    // DELIVERY
    public $delivery;
    public $delivery_value;
    public $delivery_date;
    public $delivery_stage;

    public $comment;


    protected $listeners = [
        'closeProductModal',
        'addItemToOrder',
        'closeCustomerModal',
        'closeAddressModal',
    ];

    public function rules(){

        $ruleValidators = [];

        
        $ruleValidators['customer_id'] = 'required';
        $ruleValidators['date'] = 'required';

        // $ruleValidators['subtotal'] = 'required';
        // $ruleValidators['cost'] = 'required';
        // $ruleValidators['total'] = 'required';
        // $ruleValidators['difference'] = 'required';
        // $ruleValidators['status'] = 'required';
        // $ruleValidators['sale_type'] = 'required';

        $ruleValidators['payment_status'] = 'required';
        $ruleValidators['payment_account_comment'] = 'nullable';

        if ($this->payment_status != 0) { 

            $ruleValidators['payment_account'] = 'required';
            // $ruleValidators['payment_date'] = 'required';
            // $ruleValidators['user_id_paid'] = 'required';

            if ($this->payment_status == 1) {
                $ruleValidators['payment_amount'] = 'required';
            }
            // $ruleValidators['pending_amount'] = 'required';
           
        }       
        
        // $ruleValidators['delivery'] = 'required';

        if ($this->delivery) {

            $ruleValidators['delivery_value'] = 'required';
            $ruleValidators['delivery_date'] = 'required';
            // $ruleValidators['delivery_stage'] = 'required';
            // $ruleValidators['date_delivered'] = 'required';
            // $ruleValidators['user_id_delivered'] = 'required';
             $ruleValidators['address_id'] = 'required';
          
        }

       

        // $ruleValidators['is_invoice_delivered'] = 'required';
        // $ruleValidators['invoice_delivered_date'] = 'required';
        // $ruleValidators['user_id_invoice_delivered'] = 'required';

        $ruleValidators['comment'] = 'nullable';

        return $ruleValidators;


    }

    public function mount($redirect = true){
        // session()->forget('order.items');
        $this->redirect = $redirect;
        $this->productModal = false;
        $this->customerModal = false;
        $this->addressModal = false;
        $this->openComment = (session()->has('order.openComment')) ? session()->get('order.openComment') : false;
        $this->showPaymentAccount = (session()->has('order.showPaymentAccount')) ? session()->get('order.showPaymentAccount') : false;
        
        $this->customer_id = (session('order.customer_id')) ? session('order.customer_id') : null;
        $this->customer = ($this->customer_id)  ? Customer::find($this->customer_id) : null;
       
        
        $this->defaultAddress = ( $this->customer && $this->customer->addresses->count()>0) ? $this->customer->addresses->where('default', 1 )->first()->id : null;
        $this->address_id = ($this->defaultAddress ) ? 
        ( (session('order.address_id')) ? session('order.address_id') : $this->defaultAddress ) 
        : null;
        $this->date = date('Y-m-d') . 'T' . date('H:i');

        $this->subtotal = 0;

        $this->status = 0;
        $this->sale_type = 0;

        $this->payment_status = (session('order.payment_status')) ? session('order.payment_status') : 0;
        $this->payment_amount = (session('order.payment_amount')) ? session('order.payment_amount') : 0;
        $this->payment_account = (session('order.payment_account')) ? session('order.payment_account') : 0;
        $this->payment_account_comment = (session('order.payment_account_comment')) ? session('order.payment_account_comment') : null;

        $this->delivery = (session('order.delivery') && $this->customer_id) ? session('order.delivery') : false;
        $this->delivery_value = ( session('order.delivery_value') ) ? session('order.delivery_value') : 0;
        $this->delivery_date = (session('order.delivery_date')) ? session('order.delivery_date') : date('Y-m-d');
        $this->delivery_stage = (session('order.delivery_stage')) ? session('order.delivery_stage') : false;


        $this->comment = (session('order.comment')) ? session('order.comment') : null;

        $this->user_id_created = auth()->user()->id;
        $this->user_id_modified = null;

    }

    public function updatedPaymentAccount(){
        session()->put('order.payment_account', $this->payment_account);
    }  
    public function updatedPaymentAmount(){
        session()->put('order.payment_amount', $this->payment_amount);
    }  
    public function updatedPaymentStatus(){
        session()->put('order.payment_status', $this->payment_status);
        if($this->payment_status != 0){
            $this->showPaymentAccount = true;
        }else{
            $this->showPaymentAccount = false;
        }
        session()->put('order.showPaymentAccount', $this->showPaymentAccount);
    }  

    public function updatedCustomerId(){
        // save customer id in session
        session()->put('order.customer_id', $this->customer_id);

        if($this->customer_id){
            $this->customer = Customer::find($this->customer_id);
            $defaultAddress = Address::where('customer_id', $this->customer_id)->where('default', 1)->first();
            $this->address_id = ($defaultAddress) ? $defaultAddress->id : null;
        }else{
            $this->customer = null;
            $this->delivery = 0;
        }


        
       
    }

    public function updatedDelivery(){

        session()->put('order.delivery', $this->delivery);

        $this->delivery_value = 1000;
        if(!$this->delivery){
            $this->delivery_value = 0;
        }
        session()->put('order.delivery_value', $this->delivery_value);
       
    }

    public function updatedDeliveryStage(){
        session()->put('order.delivery_stage', $this->delivery_stage);       
    }

    public function updatedDeliveryDate(){
        session()->put('order.delivery_date', $this->delivery_date);
    }

    public function updatedDeliveryValue(){
        session()->put('order.delivery_value', $this->delivery_value);
    }

    public function updatedAddressId(){
        session()->put('order.address_id', $this->address_id);
    }

    public function updatedOpenComment(){
        session()->put('order.openComment', $this->openComment);
    }

    public function updatedComment(){
        session()->put('order.comment', $this->comment);
    }

    public function updatedPaymentAccountComment(){
        session()->put('order.payment_account_comment', $this->payment_account_comment);
    }

 




    public function addItemToOrder(Product $product){
        $orderController = new OrderController();
        $response = $orderController->addItemToOrder($product);
        
        if($response){
            $this->dispatchBrowserEvent('salert',[
                'title' =>  $product->name . ' agregado a la lista',
                'icon' => 'success',
                'position' => 'top',
                'toast' => true,
                'timer' => 3400,
            ]);
        }else{
            $this->dispatchBrowserEvent('salert',[
                'title' =>  $product->name . ' ya está en lista',
                'icon' => 'warning',
                'position' => 'top',
                'toast' => true,
                'timer' => 3400,
            ]);
        }
        
    }

    public function removeItemFromOrder(Product $product){
        $orderController = new OrderController();   
        $orderController->removeItemFromOrder($product);
        

        $this->dispatchBrowserEvent('salert',[
            'title' =>  $product->name . ' eliminado de la lista',
            'type' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
            ]);
    }

    public function setItemFromOrder($product_id,$quantity,$quantity_box,$total_quantity,$price,$price_box,$total_price){
        $orderController = new OrderController();
        $orderController->setItemFromOrder($product_id,$quantity,$quantity_box,$total_quantity,$price,$price_box,$total_price);
    }

    public function closeProductModal(Product $product){
        $this->productModal = false;
        $this->product_id = $product->id;
    }    
    
    public function closeCustomerModal(Customer $customer){
        $this->customerModal = false;
        $this->customer_id = $customer->id;
        $this->customer = Customer::find($this->customer_id);
        $this->updatedCustomerId();
   }    

    public function closeAddressModal(Address $address){
        $this->addressModal = false;
        
        $this->addresses = Address::where('customer_id',$this->customer_id)->get();
        $this->address_id =  $address->id;
    }    

    public function validateItems(){
       
        if (session()->has('order.items') && count(session('order.items')) >0) {        
            foreach (session('order.items') as $key => $item) {
                if ($item['quantity'] == '' || $item['quantity_box'] == '' || $item['price'] == '' || $item['price_box'] == '' || 
                $item['quantity'] <=0 || $item['quantity_box'] <=0 || $item['price'] <=0 || $item['price_box'] <=0) {
                    
                    $this->dispatchBrowserEvent('salert',[
                        'title' =>  'completa campos vacios',
                        'icon' => 'warning',
                        'position' => 'top',
                        'toast' => true,
                        'timer' => 3500,
                    ]);

                    return false;
                } 

            //    VALIDAR STOCK ANTERS DE CONTINUAR
                $product = Product::find($item['product_id']);
                session()->put('order.items.'.$key.'.stock', $product->stock);
                if($product->stock < $item['total_quantity']){
                    $this->dispatchBrowserEvent('salert',[
                        'title' =>  'stock insuficiente de ' . $product->name,
                        'icon' => 'warning',
                        'position' => 'top',
                        'toast' => true,
                        'timer' => 3500,
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
        $this->validate();

        if (!$this->validateItems()) {
            return false;
        }
        $this->status = 0; //REVISAR    

        $orderData=[
            'customer_id' => $this->customer_id,
            'address_id' => $this->address_id,

            'date' => $this->date,

            'subtotal' => session('order.total'),

            'status' => $this->status,
            'sale_type' => 0,

            'payment_amount' => $this->payment_amount,
            'payment_status' => $this->payment_status,
            'payment_account' => $this->payment_account,
            'payment_account_comment' => $this->payment_account_comment,

            'delivery' => $this->delivery,
            'delivery_stage' => $this->delivery_stage,
            'delivery_value' => $this->delivery_value,
            'delivery_date' => $this->delivery_date,

            // 'is_invoice_delivered' => $this->is_invoice_delivered,
            // 'invoice_delivered_date' => $this->invoice_delivered_date,
            // 'user_id_invoice_delivered' => $this->user_id_invoice_delivered,

            'comment' => $this->comment,
        
        ];

        $items = session('order.items');

        $orderController = new OrderController();
        $order = $orderController->save($orderData,$items );

        session()->forget('order');
    

        if($this->redirect){
            redirect()->route('admin.orders.index')->with('success', 'pedido ' .  $order->id . ' generado correctamente!');        
        }else {
            $this->emit('closeOrderModal', $order->id);
            $this->dispatchBrowserEvent('salert',[
                'title' =>  'Pedido '. $order->id . ' generado correctamente!',
                'type' => 'success',
                'position' => 'top',
                'toast' => true,
                'timer' => 2400,
            ]);
        }
    }

    public function render(){
        $this->products = Product::all();
        $this->customers = Customer::leftjoin('addresses','addresses.customer_id','customers.id')
        ->select('customers.*','addresses.id as address_id','addresses.name as address')
        ->orderBy('customers.name','asc')
        ->get()->map(function($customer){
            return [
                'id' => $customer->id,
                'name' => $customer->name . ' - ' . $customer->address . '',
                'address' => $customer->address,
                'address_id' => $customer->address_id,
            ];
        });

        $this->addresses = Address::where('customer_id', $this->customer_id)->get();

   
        return view('livewire.admin.orders.create');
    }
}
