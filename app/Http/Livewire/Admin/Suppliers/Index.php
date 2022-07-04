<?php

namespace App\Http\Livewire\Admin\Suppliers;

use Livewire\Component;
use App\Models\Supplier;
use Livewire\WithPagination;

class Index extends Component{
        use WithPagination;
        
        public $search;
        public $numRows;
        public $columns;
        public $sortField;
        public $sortOrder;
        
        public function mount(){
            $this->search = '';
            $this->numRows = (session()->has('suppliers.numRows') ) ? session('suppliers.numRows') : 10;
            $this->columns = (session()->has('suppliers.columns') ) ? session('suppliers.columns') : [
                'id' => ['value' =>true, 'name' =>'Id', 'sortable' =>true], 
                'name' => ['value' =>true, 'name' =>'Nombre'],
                'accions' => ['value' =>true, 'name' =>'Acciones'],
            ];
            $this->sortField = (session()->has('suppliers.sortField') ) ? session('suppliers.sortField') : 'id';
            $this->sortOrder = (session()->has('suppliers.sortOrder') ) ? session('suppliers.sortOrder') : 'asc';
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
            session(['suppliers.columns' => $this->columns]);
        }
        
        public function updatingSearch(){
            $this->resetPage();
        }
        
        public function updatedNumRows(){
            session([
                'suppliers.numRows' => $this->numRows
            ]);
        }
        
        public function updatedColumns(){
            session([
                'suppliers.columns' => $this->columns
            ]);
        }
        
        
        
        public function render(){
            $suppliers = Supplier::
            where('name', 'like', "%{$this->search}%")
            ->orWhere('name', 'like', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortOrder)
            ->paginate($this->numRows);
            return view('livewire.admin.suppliers.index', compact('suppliers'));
        }
        
        public function delete($id){
            $supplier = Supplier::find($id);
            $supplier->delete();
            $this->dispatchBrowserEvent('salert',[
                'title' =>  'El permiso '. $supplier->name . ' ha sido eliminado correctamente',
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
            'suppliers.sortOrder' => $this->sortOrder
        ]);
        session([
            'suppliers.sortField' => $this->sortField
        ]);
        }
    
}
