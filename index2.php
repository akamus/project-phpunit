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

    function disciplina($iD) {
        return $this->xpath->query("/html/body/div[2]/main/div/div[2]/div/div[2]/div[{$iD}]/div/div[1]/h3")->item(0)->nodeValue;
    }

    function urlQuestoesDisciplina($iD) {
        return $this->xpath->query("/html/body/div[2]/main/div/div[2]/div/div[2]/div[{$iD}]/div/div[1]/a[1]")->item(0)->attributes->item(0)->nodeValue;
    }

    function urlResolverOnline() {
        return $this->xpath->query("/html/body/div[2]/main/div/div[2]/div/div[1]/a")->item(0)->attributes->getNamedItem("href")->nodeValue;
    }

    function questoesPorDisciplina($iD) {
        return $this->xpath->query("/html/body/div[2]/main/div/div[2]/div/div[2]/div[{$iD}]/div/div[1]/a[1]")->item(0)->nodeValue;
    }

    function assunto($iD,$iA) {
        return $this->xpath->query("/html/body/div[2]/main/div/div[2]/div/div[2]/div[{$iD}]/div/div[2]/ul/li[{$iA}]/span")->item(0)->nodeValue;
    }

    function urlQuestoesAssunto($iD, $iA) {
       // return $this->xpath->query("/html/body/div[2]/main/div/div[2]/div/div[2]/div[{$iD}]/div/div[2]/ul/li[{$iA}]/a")->item(0)->attributes->item(0)->nodeValue;
    }

    function questoesPorAssunto($iD, $iA) {
        return $this->xpath->query("/html/body/div[2]/main/div/div[2]/div/div[2]/div[{$iD}]/div/div[2]/ul/li[{$iA}]/a")->item(0)->nodeValue;
    }

    function getHtml() {
        return $this->file;
    }

    function run($novoArquivo = '') {

        echo $this->prova() . "<br/>";
        
        echo $this->dataAplicacao() . "<br/>";
        
        echo $this->totalQuestoesProva() . "<br/>";
        
        echo $this->urlResolverOnline() . "<br/>";
        
// $this->disciplina(0);
    }

    function item($query) {
        return $this->xpath->evaluate($query);
    }

    function percorrerAssunto($iD, $iA) {

        do {
            $iA++;
            $assunto = $rg->assunto($iD, $iA);
            $questoes = $rg->questoesPorAssunto($iD, $iA);

            if (!empty($assunto)) {
                echo $assunto . '-' . $questoes . "<br/>";
            } else {
                echo "----------------------------------<br/>";
            }
        } while (!empty($assunto));
    }

}

/**
 * Runner 
 */
$rg = new Rgx('modeloprf.html');

$rg->run();


$iD = 0;
$iA = 0;

$disciplina = '';
$totalQuestoesDisciplina = 0;
$assunto = '';

do {
    $iD++;
    //buscar disciplina
    $disciplina = $rg->disciplina($iD);
    $totalQuestoesDisciplina = $rg->questoesPorDisciplina($iD);



    if (!empty($disciplina)) {
        echo $disciplina . '-' . $totalQuestoesDisciplina . '-' .$rg->urlQuestoesDisciplina($iD). "<br/>";
        
    } else {
        echo "----fim d:" . $iD . "------<br/>";
    }
    $iA = 0;
    do {
        $iA++;
        $assunto = $rg->assunto($iD, $iA);
        $questoesPorAssunto = $rg->questoesPorAssunto($iD, $iA);
        $urlQuestoesAssunto = $rg->urlQuestoesAssunto($iD, $iA);
        
        if (!empty($assunto)) {
            echo $assunto . '-' . $questoesPorAssunto . '-' . $urlQuestoesAssunto . "<br/>";
        } else {
            echo "---fim assunto:" . $iA . " D" . $iD . "------<br/>";
        }
    } while (!empty($assunto));
} while (!empty($disciplina));
