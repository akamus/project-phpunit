<?php
/*
 * comportamento padrao que deve ser
 * apresentado por todas as classes
 * que a implementa.
 * É um recurso de "herança múltipla"
 * Classes podem implementar mais de uma interface
 */

interface IAutomovel { 
 /*
  * atributos public,static,final
  * apenas metodos public ou default, não implementados 
  * use implements
  * não pode ser instanciada
  * pode ter metodos abstratos / ~ abstratos
  */
    
    function ligar();    
    function desligar();    
    function frear();
    function acelerar();

    
}
