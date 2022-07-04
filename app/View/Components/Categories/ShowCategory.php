<?php

namespace App\View\Components\Categories;

use Illuminate\View\Component;

class ShowCategory extends Component{
    public $category;
    public $pl;
    public $liclass;
    public $event;
    public function __construct( $category, $pl = 0, $liclass = '', $event = '' ){
        $this->category = $category;
        $this->pl = $pl + 24;
        $this->liclass = $liclass;
        $this->event = $event;
    }

    public function render(){
        return view('components.categories.show-category');
    }
}
