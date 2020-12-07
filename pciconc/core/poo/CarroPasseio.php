<?php
include_once './Carro.php';

class CarroPasseio extends Carro {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function ligar() {
        parent::ligar();
        $this->setStatusMotor();
    }
   
}
