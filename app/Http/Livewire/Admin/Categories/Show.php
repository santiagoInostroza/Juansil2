<?php

namespace App\Http\Livewire\Admin\Categories;

use Livewire\Component;

class Show extends Component{
    public $category;
    
    public function mount($category){
        $this->category = $category;
    }

    public function render(){
        return view('livewire.admin.categories.show');
    }
}
