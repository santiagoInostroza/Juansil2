<?php

namespace App\Http\Livewire\Admin\Purchases;

use Livewire\Component;
use App\Models\PurchaseItem;
use Livewire\WithPagination;

class Details extends Component{
    use WithPagination;
    
    public $search;
    public $numRows;
    public $columns;
    public $sortField;
    public $sortOrder;
    
    public function mount(){
        $this->search = '';
        $this->numRows = (session()->has('purchase_items.numRows') ) ? session('purchase_items.numRows') : 10;
        $this->columns = (session()->has('purchase_items.columns') ) ? session('purchase_items.columns') : [
            'id' => ['value' =>true, 'name' =>'Id', 'sortable' =>true], 
            'purchase_id' => ['value' =>true, 'name' =>'Compra'],
            'supplier_name' => ['value' =>true, 'name' =>'Proveedor', 'sortable' =>true],
            'date' => ['value' =>true, 'name' =>'Fecha', 'sortable' =>true, 'type' =>'date'],
            'total_purchase' => ['value' =>true, 'name' =>'Total Compra','type' =>'money'],
            'product_name' => ['value' =>true, 'name' =>'Producto'],
            'stock_total' => ['value' =>true, 'name' =>'Stock Total'],
            'quantity' => ['value' =>true, 'name' =>'Cantidad', 'sortable' =>true],
            'quantity_box' => ['value' =>true, 'name' =>'Cantidad por caja', 'sortable' =>true],
            'total_quantity' => ['value' =>true, 'name' =>'Cantidad total', 'sortable' =>true],


            'price' => ['value' =>true, 'name' =>'Precio', 'sortable' =>true, 'type' =>'money'],
            'price_box' => ['value' =>true, 'name' =>'Precio por caja', 'sortable' =>true, 'type' =>'money'],
            'total_price' => ['value' =>true, 'name' =>'Precio total', 'sortable' =>true, 'type' =>'money'],
            'stock' => ['value' =>true, 'name' =>'Stock', 'sortable' =>true],

            'accions' => ['value' =>true, 'name' =>'Acciones'],
        ];
        $this->sortField = (session()->has('purchase_items.sortField') ) ? session('purchase_items.sortField') : 'purchase_id';
        $this->sortOrder = (session()->has('purchase_items.sortOrder') ) ? session('purchase_items.sortOrder') : 'asc';
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
        session(['purchase_items.columns' => $this->columns]);
    }
    
    public function updatingSearch(){
        $this->resetPage();
    }
    
    public function updatedNumRows(){
        session([
            'purchase_items.numRows' => $this->numRows
        ]);
    }
    
    public function updatedColumns(){
        session([
            'purchase_items.columns' => $this->columns
        ]);
    }
    
    
    
    public function render(){
        $items = PurchaseItem::join('purchases', 'purchase_items.purchase_id', '=', 'purchases.id')
            ->join('products', 'purchase_items.product_id', '=', 'products.id')
            ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
            ->select('purchase_items.*', 'purchases.total as total_purchase', 'purchases.date', 'suppliers.name as supplier_name', 'products.name as product_name', 'suppliers.name as supplier_name', 'products.stock as stock_total')
            // ->select('purchase_items.*', 'purchases.id as purchase_id', 'products.name as product_name','purchases.date as date','purchases.total as total_purchase',)
            ->where('products.name', 'like', '%'.$this->search.'%')
            ->orderBy($this->sortField, $this->sortOrder)
            ->paginate($this->numRows);


        
        return view('livewire.admin.purchases.details', compact('items'));
    }
    
    public function delete($id){
        $item = PurchaseItem::find($id);
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
        'purchase_items.sortOrder' => $this->sortOrder
    ]);
    session([
        'purchase_items.sortField' => $this->sortField
    ]);
    }
  
}
