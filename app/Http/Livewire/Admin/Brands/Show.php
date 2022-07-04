<?php

namespace App\Http\Livewire\Admin\Brands;

use Livewire\Component;

class Show extends Component{
    public $brand;
    
    public function mount($brand){
        $this->brand = $brand;
    }
    public function render(){
        return view('livewire.admin.brands.show');
    }
}
