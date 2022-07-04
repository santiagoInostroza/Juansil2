<?php

namespace App\Http\Livewire\Header;

use Livewire\Component;

class HomeSearcher extends Component{
    public $search;

    public function render(){
        return view('livewire.header.home-searcher');
    }
}
