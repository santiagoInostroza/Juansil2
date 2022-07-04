<?php

namespace App\Http\Livewire\Admin\Products;

use Livewire\Component;
use App\Models\PurchaseItem;
use Livewire\WithPagination;
use App\Models\MovementProduct;
use App\Models\OrderPurchaseItem;

class Movements extends Component{
    use WithPagination;
    
    public $search;
    public $numRows;
    public $columns;
    public $sortField;
    public $sortOrder;

    public $stock = [];
    
    public function mount(){
        $this->search = '';
        $this->numRows = (session()->has('order_purchase_items.numRows') ) ? session('order_purchase_items.numRows') : 10;
        $this->columns = (session()->has('order_purchase_items.columns') ) ? session('order_purchase_items.columns') : [
            'id' => ['value' =>true, 'name' =>'Id', 'sortable' =>false], 
            'purchase_id' => ['value'=>true, 'name'=>'Compra', 'sortable' =>false],
            'supplier_name' =>['value'=>true, 'name'=>'Proveedor', 'sortable' =>false],
            'order_id' => ['value' =>true, 'name' =>'Pedido', 'sortable' =>false],
            'customer_name' =>['value'=>true, 'name'=>'Cliente', 'sortable' =>false],
            'product_name' => ['value' =>true, 'name' =>'Nombre'],
            'date' => ['value' =>true, 'name' =>'Fecha', 'sortable' =>false],
            'type' => ['value' =>true, 'name' =>'Tipo', 'sortable' =>false],
            'purchase_quantity' => ['value' =>false, 'name' =>'Cantidad', 'sortable' =>false],
            'purchase_quantity_box' => ['value' =>false, 'name' =>'Cantidad x caja', 'sortable' =>false],
            'purchase_total_quantity' => ['value' =>true, 'name' =>'Entrada', 'sortable' =>false],
            'order_quantity' => ['value' =>false, 'name' =>'Cantidad', 'sortable' =>false],
            'order_quantity_box' => ['value' =>false, 'name' =>'Cantidad x caja', 'sortable' =>false],
            'order_total_quantity' => ['value' =>true, 'name' =>'Salida', 'sortable' =>false],
            'stock' => ['value' =>true, 'name' =>'Stock', 'sortable' =>false],
            // 'stock2' => ['value' =>true, 'name' =>'Stock2'],

        //     'name' => ['value' =>true, 'name' =>'Nombre'],
        //     'date' => ['value' =>true, 'name' =>'Fecha','type' =>'date'],
        //     'price' => ['value' =>true, 'name' =>'Precio','type' =>'money'],
        //     'image' => ['value' =>true, 'name' =>'Imagen','type' =>'image'],
        //     'active' => ['value' =>true, 'name' =>'Activo','type' =>'boolean'],
        //    'text' => ['value' =>true, 'name' =>'Texto','type' =>'text'],
        //     'accions' => ['value' =>true, 'name' =>'Acciones'],
        ];
        $this->sortField = (session()->has('order_purchase_items.sortField') ) ? session('order_purchase_items.sortField') : 'id';
        $this->sortOrder = (session()->has('order_purchase_items.sortOrder') ) ? session('order_purchase_items.sortOrder') : 'asc';
    }
    
    public function selectColumns($value){
        switch ($value) {
            case 'all':
                foreach ($this->columns as $name_column => $column ) {
                    $this->columns[$name_column]['value'] = true;
                }
                break;
            case 'none':
                foreach ($this->columns as $name_column => $column ) {
                    $this->columns[$name_column]['value'] = false;
                }
                break;
            case 'switch':
                foreach ($this->columns as $name_column => $column ) {
                    $this->columns[$name_column]['value'] = !$this->columns[$name_column]['value'];
                }
                break;
            
            default:
                
                break;
        }
        session(['order_purchase_items.columns' => $this->columns]);
    }
    
    public function updatingSearch(){
        $this->resetPage();
    }
    
    public function updatedNumRows(){
        session([
            'order_purchase_items.numRows' => $this->numRows
        ]);
    }
    
    public function updatedColumns(){
        session([
            'order_purchase_items.columns' => $this->columns
        ]);
    }

    public function getItems(){
        # code...
    }
    
    public function render(){
        $this->stock = [];
        $items = MovementProduct::
        leftjoin('order_items', 'movement_products.order_item_id','=','order_items.id')->leftjoin('orders', 'order_items.order_id','=','orders.id')
        ->leftjoin('purchase_items', 'movement_products.purchase_item_id','=','purchase_items.id')->leftjoin('purchases', 'purchase_items.purchase_id','=','purchases.id')
        
        
        ->leftjoin('products', 'movement_products.product_id','=','products.id')
        ->leftjoin('customers', 'orders.customer_id','=','customers.id')
        ->leftjoin('suppliers', 'purchases.supplier_id','=','suppliers.id')

       
       
        ->select(
            'movement_products.id',
            'movement_products.type',
            'movement_products.date',
            // 'movement_products.stock',
            'purchase_items.quantity as purchase_quantity',
            'purchase_items.quantity_box as purchase_quantity_box',
            'purchase_items.total_quantity as purchase_total_quantity',
            'order_items.quantity as order_quantity',
            'order_items.quantity_box as order_quantity_box',
            'order_items.total_quantity as order_total_quantity',
            'purchases.id as purchase_id',
            'orders.id as order_id',
            'products.name as product_name',
            'suppliers.name as supplier_name',
            'customers.name as customer_name',


          
        )

        ->where('products.name', 'like', "%{$this->search}%")
        ->orWhere('suppliers.name', 'like', "%{$this->search}%")
        ->orWhere('customers.name', 'like', "%{$this->search}%")
        ->orderBy($this->sortField, $this->sortOrder)
        // ->get()
        // ->map(function($item, $key) {
        //     if (!isset($this->stock[$item->product_name])) {
        //         $this->stock[$item->product_name] = 0 ;
        //     }
        //     $this->stock[$item->product_name] +=  $item->purchase_total_quantity - $item->order_total_quantity;
        //     $item->stock2 = $this->stock[$item->product_name];
        //     return $item;
        // });
        ->paginate($this->numRows);



        return view('livewire.admin.products.movements', compact('items'));
    }
    
    public function delete($id){
        $item = OrderPurchaseItem::find($id);
        $item->delete();
        $this->dispatchBrowserEvent('salert',[
            'title' =>  'El permiso '. $item->name . ' ha sido eliminado correctamente',
            'type' => 'success',
            'position' => 'top',
            'toast' => true,
            'timer' => 2400,
        ]);
    }

    public function sortBy($column){
        $this->sortField = $column;
        $this->sortOrder = $this->sortOrder == 'asc' ? 'desc' : 'asc';
        session([
            'order_purchase_items.sortOrder' => $this->sortOrder
        ]);
        session([
            'order_purchase_items.sortField' => $this->sortField
        ]);
    }
}
