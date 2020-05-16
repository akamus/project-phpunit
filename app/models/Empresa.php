<?php

namespace App\Models;

class Empresa{


function __construct(){

}


function somar($a, $b){
    
    $resultado = $a + $b;
    
    if($resultado >= 0){
        return $resultado;
    }else{
        return -1;
    }
}



function subtrair($a, $b){
    
    $resultado = $a - $b;
    
    if($resultado >=  0){
        return $resultado;
    }else{
        return -1;
    }
}
}
