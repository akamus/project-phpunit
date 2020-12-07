<?php

$dir = 'C:\Users\aureo.ramos.IPREM\Google Drive\PROVAS\analista de tecnologia da informacao';


$dir_new = '/c/Users/aureo.ramos.IPREM/Google\ Drive/PROVAS/analista\ de\ tecnologia\ da\ informacao/';

$files = scandir($dir);

//var_dump($files);

$contar = 0;
$outros = 0;

$fcopy = [];
for ($i = 0; $i < count($files); $i++) {
	
$pos = strpos( $files[$i], '2010' );

if ($pos === false) {
   
} else {

   array_push($fcopy,$files[$i]);
//echo $files[$i].'<br/>';
}

}



foreach ($fcopy as $file) {
	$origem = $file;
//echo $origem.'<br/>';
$destino = $dir_new.'2010';
copy($origem, $destino);
//unlink($origem);

}

//echo 'arquivos: '.$contar.'  '.'outros: '.$outros;

//$origem = $dir.'/'.$file;
//echo $origem.'<br/>';
//$destino = $dir.'/2010';
//copy($origem, $destino);
//unlink($origem);

//var_dump($fcopy);