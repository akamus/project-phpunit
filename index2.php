<?php

use Doctrine\DBAL\DriverManager;

require_once './vendor/autoload.php';

use DOMDocument;
use DOMXPath;

class Rgx {

    public $dom;
    public $xpath;
    public $file;

    public function __construct($url = '') {
        $options = array(
            'http' => array(
                'method' => "GET",
                'header' => "Accept-language: en\r\n" .
                //"Cookie: foo=bar\r\n" . // check function.stream-context-create on php.net
                "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad 
            )
        );

        $context = stream_context_create($options);


        $this->file = file_get_contents($url, false, $context);




        $this->dom = new DOMDocument();
        $this->dom->loadHTML($this->file);
        $this->xpath = new DOMXPath($this->dom);
    }

    function prova() {
        return $this->dom->getElementsByTagName("h1")->item(0)->nodeValue;
    }

    function dataAplicacao() {
        return $this->xpath->query("//span[@class='q-date']")->item(0)->nodeValue;
    }

    function totalQuestoesProva() {
        return $this->xpath->query("//div[@class='panel-heading']/h2")->item(0)->nodeValue;
    }

    function disciplinas() {
        return $this->xpath->query("//div[@class='q-discipline-item']/div[@class='q-heading']/h3[@class='q-title']");
    }

    function disciplina($i) {

        return $this->xpath->query("/html/body/div[2]/main/div/div[2]/div/div[2]/div[{$i}]/div/div[1]/h3")->item(0)->nodeValue;
    }

    function questoesPorDisciplina($i) {
        return $this->xpath->query("/html/body/div[2]/main/div/div[2]/div/div[2]/div[{$i}]/div/div[1]/a[1]")->item(0)->nodeValue;
        ;
//                                    /html/body/div[2]/main/div/div[2]/div/div[2]/div[2]/div/div[1]/a[1]
    }

    function assunto($i) {
             
        return $this->xpath->query("/html/body/div[2]/main/div/div[2]/div/div[2]/div[1]/div/div[2]/ul/li[{$i}]/span")->item(0)->nodeValue;
    }

    function questoesPorAssunto($i) {
        return $this->xpath->query("/html/body/div[2]/main/div/div[2]/div/div[2]/div[1]/div/div[2]/ul/li[{$i}]/a")->item(0)->nodeValue;
    }

    function getHtml() {
        return $this->file;
    }

    function run($novoArquivo = '') {


      //  echo $this->prova();
       // echo $this->dataAplicacao();
       // echo $this->totalQuestoesProva();

        // $this->disciplina(0);
    }

    function item($query) {
        return $this->xpath->evaluate($query);
    }

}

$rg = new Rgx('modelofcc.html');

$rg->run();


$i = 0;
$j = 0;

$disciplina = '';
$ttQuestoesDisciplina = 0;
$assunto = '';

do {
    $i++;
    $disciplina = $rg->item("/html/body/div[2]/main/div/div[2]/div/div[2]/div[{$i}]/div/div[1]/h3")->item(0)->nodeValue;
    $ttQuestoesDisciplina = $rg->item("/html/body/div[2]/main/div/div[2]/div/div[2]/div[{$i}]/div/div[1]/a[1]")->item(0)->nodeValue;
     if(!empty($disciplina)){
          echo $disciplina .'-' .$ttQuestoesDisciplina."<br/>";
     }else{
         echo "----------------------------------<br/>";
     }
            do {
                $j++;
                $assunto = $rg->item("/html/body/div[2]/main/div/div[2]/div/div[2]/div[1]/div/div[2]/ul/li[{$j}]/span")->item(0)->nodeValue;
               $questoes = $rg->item("/html/body/div[2]/main/div/div[2]/div/div[2]/div[1]/div/div[2]/ul/li[{$j}]/a")->item(0)->nodeValue;
               
               if(!empty($assunto)){
               echo $assunto . '-'.$questoes."<br/>";
               }else{
                    echo "----------------------------------<br/>";
               } 
            } while (!empty($assunto));
            

} while (!empty($disciplina));
