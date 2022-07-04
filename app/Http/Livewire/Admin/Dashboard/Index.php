<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\Order;
use Livewire\Component;
use App\Http\Controllers\Helper;
use App\Http\Controllers\Admin\OrderController;

class Index extends Component{

    public $month;
    public $year;

    public $nameMonth;
    public $totalSalesOfTheMonth;
    public $cantTotalSalesOfTheMonth;

    public function mount(){
        $this->totalSalesOfTheMonth = $this->getTotalSalesOfTheMonth(['operation' => 'sum','month' => $this->month,'year' => $this->year]);
        $this->cantTotalSalesOfTheMonth = $this->getTotalSalesOfTheMonth(['operation' => 'count','month' => $this->month,'year' => $this->year]);
        $this->nameMonth = Helper::getNameMonth($this->month);
    }


    public function render(){
        return view('livewire.admin.dashboard.index');
    }

    public function getTotalSalesOfTheMonth($data=null){
        $orderController = new OrderController();
        return $orderController->getTotalSalesOfTheMonth($data);
       
    }
}
