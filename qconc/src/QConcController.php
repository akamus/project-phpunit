<?php
namespace Src;

require_once '../vendor/autoload.php';

class QConcController {

    public $regex = '';
    public $paginar = '';
    
    public function __construct() {

        $this->regex = PciModel();
        $this->paginar = 5; //paginar de até 10
    }
    

}
