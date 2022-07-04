<?php

namespace App\View\Components\Selects;

use Illuminate\View\Component;

class Select extends Component{

    public $collection;
    public $placeholder;
    public $event;
    public $noClose;
    public $isOpen;
    public $search;
    public $height;
    


    public function __construct($collection, $placeholder = 'Seleccione una opción', $event = "", $noClose = false, $isOpen = false, $search = '', $height = '240px'){
        $this->collection = $collection;
        $this->placeholder = $placeholder;
        $this->event = $event;
        $this->noClose = $noClose;
        $this->isOpen = $isOpen;
        $this->search = $search;
        $this->height = $height;
    }

   

    public function render(){
        return view('components.selects.select');
    }
}
