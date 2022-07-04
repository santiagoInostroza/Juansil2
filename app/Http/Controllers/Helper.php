<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class Helper extends Controller{
    

    public static function date($fecha,$timezone = true){
        if ($fecha!="") {
           
           $fecha =  Carbon::parse($fecha)->locale('es_ES');
            if ($timezone) {
                $fecha =  $fecha->timezone('America/Santiago');
            }
            return  $fecha;
        }
        return false;
    } 

    public static function getNameMonth($month = null){
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        
        if ($month!=null) {
            return $meses[$month-1];
        }else{
            return $meses[date('n')-1];
        }
    }
}
