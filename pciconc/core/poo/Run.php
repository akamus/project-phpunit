<?php
include_once './CarroPasseio.php';

$passeio = new CarroPasseio();
$passeio->ligar();     
$passeio->show($passeio);


