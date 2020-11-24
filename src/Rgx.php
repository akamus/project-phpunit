<?php

namespace Src;

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
        // set error level
        $internalErrors = libxml_use_internal_errors(true);

        $this->dom->loadHTML($this->file);

// Restore error level
        libxml_use_internal_errors($internalErrors);

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

    function assunto($iD, $iA) {
        if(empty($iD)){
            return '';
        }
        return $this->xpath->query("/html/body/div[2]/main/div/div[2]/div/div[2]/div[{$iD}]/div/div[2]/ul/li[{$iA}]/span")->item(0)->nodeValue;
    }

    function urlQuestoesAssunto($iD, $iA) {
      //  echo $iD . '-' . $iA . "<br/>";
        return $this->xpath->query("/html/body/div[2]/main/div/div[2]/div/div[2]/div[{$iD}]/div/div[2]/ul/li[{$iA}]/a")->item(0)->attributes->item(0)->textContent;
        //return $rs;        
    }

    function questoesPorAssunto($iD, $iA) {
        return $this->xpath->query("/html/body/div[2]/main/div/div[2]/div/div[2]/div[{$iD}]/div/div[2]/ul/li[{$iA}]/a")->item(0)->nodeValue;
    }

    function getHtml() {
        return $this->file;
    }

    function filtrarQuantidadeQuestaoProva($text) {
        preg_match("/[0-9]{1,3}/", $text, $matches);
        return $matches[0];
    }
    
     function filtrarQuantidadeQuestao($text) {
        preg_match("/[0-9]{1,3}/", $text, $matches);
        return $matches[0];
    }
     function filtrarDisciplina($text) {
         preg_match_all("/([0-9.]{1,})\s(.*)/", $text, $matches);
         //var_dump( $matches[2][0]);
         return $matches[2][0];
        
    }
    
     function filtrarAssunto($text) {
         preg_match_all("/([0-9.]{1,})\s(.*)/", $text, $matches);
         //var_dump( $matches[2][0]);
         return $matches[2][0];
        
    }
    
    function filtrarQuantidadeQuestaoDisciplina($text) {
        preg_match("/[0-9]{1,3}/", $text, $matches);
        return $matches[0];
    }
    function filtrarQuantidadeQuestaoAssunto($text) {
        preg_match("/[0-9]{1,3}/", $text, $matches);
        return $matches[0];
    }

    function run($novoArquivo = '') {

// $this->disciplina(0);
    }

    function percorrerAssunto($iD, $iA) {
        
    }

}
