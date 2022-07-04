<?php

namespace App\Http\Livewire\Admin\Purchases;

use Livewire\Component;
use App\Models\Purchase;
use Livewire\WithPagination;
use App\Http\Controllers\Admin\PurchaseController;

class Index extends Component{

    use WithPagination;
    
    public $search;
    public $numRows;
    public $columns;
    public $sortField;
    public $sortOrder;
    
    public function mount(){
        $this->search = '';
        $this->numRows = (session()->has('purchases.numRows') ) ? session('purchases.numRows') : 10;
        $this->columns = (session()->has('purchases.columns') ) ? session('purchases.columns') : [
            'id' => ['value' =>true, 'name' =>'Id', 'sortable' =>true], 
            'supplier_id' => ['value' =>true, 'name' =>'Proveedor', 'sortable' =>true],
            'total' => ['value' =>true, 'name' =>'Total', 'sortable' =>true],
            'date' => ['value' =>true, 'name' =>'Fecha', 'sortable' =>true],
            'comment' => ['value' =>true, 'name' =>'Comentario', 'sortable' =>true],
            'accions' => ['value' =>true, 'name' =>'Acciones'],
        ];
        $this->sortField = (session()->has('purchases.sortField') ) ? session('purchases.sortField') : 'id';
        $this->sortOrder = (session()->has('purchases.sortOrder') ) ? session('purchases.sortOrder') : 'asc';
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
        session(['purchases.columns' => $this->columns]);
    }
    
    public function updatingSearch(){
        $this->resetPage();
    }
    
    public function updatedNumRows(){
        session([
            'purchases.numRows' => $this->numRows
        ]);
    }
    
    public function updatedColumns(){
        session([
            'purchases.columns' => $this->columns
        ]);
    }
    
    
    
    public function render(){
        $purchases = Purchase::
        // where('name', 'like', "%{$this->search}%")
        // ->orWhere('name', 'like', "%{$this->search}%")
        orderBy($this->sortField, $this->sortOrder)
        ->paginate($this->numRows);
        return view('livewire.admin.purchases.index', compact('purchases'));
    }
    
    public function delete($id){
        $purchaseController = new PurchaseController();
        $purchaseController->delete($id);
        $this->dispatchBrowserEvent('salert',[
            'title' =>  'Compra eliminada correctamente',
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
        'purchases.sortOrder' => $this->sortOrder
    ]);
    session([
        'purchases.sortField' => $this->sortField
    ]);
    }

}
