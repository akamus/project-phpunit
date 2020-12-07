<?php

// side effect: change ini settings
ini_set('error_reporting', E_ALL);

require_once '../vendor/autoload.php';

use Package\Pci\Controller;
use Package\Pci\Model;

$m = new Model();

$m->print_i('model');

$c = new Controller();

$m = new Model();
$array = [];
//alterar filtros nesta linha
$filtros = ['fcc','sistemas'];

$c->processar2($filtros);