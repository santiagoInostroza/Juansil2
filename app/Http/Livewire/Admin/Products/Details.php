<?php

namespace App\Http\Livewire\Admin\Products;

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
            'date' => ['value' =>true, 'name' =>'Fecha','type' =>'date'],
            'purchase_id' =>['value'=>true, 'name'=>'Compra'],
            'supplier_name' =>['value'=>true, 'name'=>'Proveedor'],

             'name' => ['value' =>true, 'name' =>'Nombre'],
            
            //  'total_quantity' => ['value' =>true, 'name' =>'Cantidad'],
             'price' => ['value' =>true, 'name' =>'Precio','type' =>'money'],
             'stock' => ['value' =>true, 'name' =>'Stock'],
        //     'price' => ['value' =>true, 'name' =>'Precio','type' =>'money'],
        //     'image' => ['value' =>true, 'name' =>'Imagen','type' =>'image'],
        //     'active' => ['value' =>true, 'name' =>'Activo','type' =>'boolean'],
        //    'text' => ['value' =>true, 'name' =>'Texto','type' =>'text'],
            // 'accions' => ['value' =>true, 'name' =>'Acciones'],
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
        $purchase_items = PurchaseItem::rightjoin('products','products.id','=','purchase_items.product_id')
        ->leftjoin('purchases','purchases.id','=','purchase_items.purchase_id')
        ->leftjoin('suppliers','suppliers.id','=','purchases.supplier_id')
         ->where('suppliers.name', 'like', "%{$this->search}%")
         ->orWhere('products.name', 'like', "%{$this->search}%")
        ->select('purchase_items.*' , 'products.name', 'purchases.date', 'suppliers.name as supplier_name','products.stock as global_stock')
        ->orderBy($this->sortField, $this->sortOrder)
        ->paginate($this->numRows);
        return view('livewire.admin.products.details', compact('purchase_items'));
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
