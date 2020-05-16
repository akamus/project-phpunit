<?php

namespace App\Models;

use PHPUnit\Framework\TestCase;

class EmpresaTest extends TestCase {

	 /**
     * @dataProvider additionProvider
     */

    function testSomar($x,$y,$z) 
    {
         $observer = new Empresa();

         $this->assertEquals($x, $observer->somar($y,$z) );
         
       
    }

    public function additionProvider()
    {
        return [
            [2, 1, 1],
            [0, -1, 1],
            [-1, -4, 2],
            [-1, -4, -3]
        ];
    }
    
      
  
}
