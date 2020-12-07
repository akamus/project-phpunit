<?php
include_once './IAutomovel.php';
class Carro implements IAutomovel  {
    
    protected $statusMotor;
    //distancia percorrida
    protected $statusOdometro;
    protected $statusVelocimetro;
    protected $statusCambio;

    function __construct() {
        $this->statusMotor = 0;
        $this->statusOdometro = 0;
        $this->statusVelocimetro = 0;
        $this->statusCambio = 0;

        
    }
    
    function ligar(){
        if($this->getStatusMotor() == 0)
            $this->setStatusMotor (1);
    }
    function desligar(){
         if($this->getStatusMotor() == 1)
            $this->setStatusMotor (0);
    }
    function frear(){
        
    }
    function acelerar(){
     
            $this->setStatusVelocimetro(rand(0,20));
       
        
    }
    
    function getStatusMotor() {
        return $this->statusMotor;
    }
    function setStatusMotor($statusMotor) {
        $this->statusMotor = $statusMotor;
    }
    function getStatusOdometro() {
        return $this->statusOdometro;
    }

    function getStatusVelocimetro() {
        return $this->statusVelocimetro;
    }

    function setStatusOdometro($statusOdometro) {
        $this->statusOdometro = $statusOdometro;
    }

    function setStatusVelocimetro($statusVelocimetro) {
        $this->statusVelocimetro = $statusVelocimetro;
    }

    function getStatusCambio() {
        return $this->statusCambio;
    }

    function setStatusCambio($statusCambio) {
        $this->statusCambio = $statusCambio;
    }
    
    function show($carro){
        foreach ($carro as $key => $value) {
    echo $key." -> ".$value."<br/>";
}
    }
    
    



    

}
