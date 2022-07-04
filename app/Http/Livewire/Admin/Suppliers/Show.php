<?php

namespace App\Http\Livewire\Admin\Suppliers;

use Livewire\Component;

class Show extends Component{
    public $supplier;
    
    public function mount($supplier){
        $this->supplier = $supplier;
    }
    public function render(){
        return view('livewire.admin.suppliers.show');
    }
}
