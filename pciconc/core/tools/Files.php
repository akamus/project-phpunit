<?php

namespace Package\Tools;

class Files
{

    public function scanDir($directory = '') 
    {
       $array = scandir($directory);
        var_dump($array);
        return $array;
    }

    public function searchByYear($array = []) 
    {
        $arrayResult = preg_grep("/[A-Za-z_]*2007+[0-9_]*/", $array);
    
        var_dump($arrayResult);
        
    }
    
    public function createYearFolder($year) 
    {
        $pathNewDir = "C:\Users\aureo.ramos.IPREM\Google Drive\PROVAS\analistaDeSistemas";
        $newDir = $pathNewDir."\".$year; 
        mkdir($newDir, 0777, true);
        chmod($newDir, 0777);
    }
    

}

$d = "C:\Users\aureo.ramos.IPREM\Google Drive\PROVAS\analistaDeSistemas\antes";
$f = new Files();
//$f->scanDir($d);
$f->searchByYear( $f->scanDir($d) );


