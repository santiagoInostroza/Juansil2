<?php

namespace App\Http\Livewire\Admin\Products;

use Livewire\Component;
use App\Models\Category;
use App\Http\Controllers\Admin\CategoryController;

class SelectCategoriesForProduct extends Component{
    public $categories;

    public function render(){
        $this->categories = $this->getCategories();
        return view('livewire.admin.products.select-categories-for-product');
    }

    public function getCategories(){
        $categoryController = new CategoryController();
        // return $categoryController->getCategories();  
        return $categoryController->getCategoriesFresh();  
    }
}
