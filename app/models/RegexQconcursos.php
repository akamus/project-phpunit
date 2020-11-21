<?php

namespace App\Models;
use DOMDocument;
use DOMXPath;

class RegexQconcursos{

    public $file;

function __construct($file = ''){
$this->file = $file;

}

function getNomeProva(){
    $pattern = "/<h1 class=\"q-title\">(.*)<\/h1>\s<span class=\"q-date\">(.*)<\/span>/";
   // preg_match($pattern, $this->file, $matches);
    $dom = new DOMDocument();
    $dom->loadHTML($this->file);
    return $dom->getElementsByTagName("h1")->item(0)->nodeValue;
    //return $matches;
}

function getAplicacao(){
    $dom = new DOMDocument();
    $dom->loadHTML($this->file);
    $xpath = new \DOMXPath($dom);
    return $xpath->query("/html/body/div[2]/main/div/header/div/div[1]/span")->item(0)->nodeValue;
    //return $matches;
}

function getQtdQuestoes(){
    $dom = new DOMDocument();
    $dom->loadHTML($this->file);
    $xpath = new \DOMXPath($dom);
    return $xpath->query("/html/body/div[2]/main/div/div[2]/div/div[1]/h2")->item(0)->nodeValue;
    //return $matches;
}

function getDisciplina(){
    $dom = new DOMDocument();
    $dom->loadHTML($this->file);
    $xpath = new \DOMXPath($dom);
    return $xpath->query("/html/body/div[2]/main/div/div[2]/div/div[2]  ")->item(0)->childNodes;
    //return $matches;
}

function getQtdDisciplina(){
    $dom = new DOMDocument();
    $dom->loadHTML($this->file);
    $xpath = new \DOMXPath($dom);
    return $xpath->query("/html/body/div[2]/main/div/div[2]/div/div[2]")->item(0)->childNodes;
    //return $matches;
}

/*
$file = file_get_contents("modelo.html");
//prova 2.0
$prova ="/(<h1\sclass=\"q-title\">)([A-Za-zÀ-ȕ0-9-\s]*)(<\/h1>)/";  
// a2
$disciplina ="/(<h3\sclass=\"q-title\">)([0-9.]*\s[A-Za-zÀ-ȕ0-9-\s]*)(<\/h3>)/";
//questoes por disciplina
$questaoPorDiscipina ="/(<a\shref[A-Za-zÀ-ȕ0-9\-\s\=\"\%\?\/\_]*>)([0-9]*\s[quest(ão|ões)]*\s)(<\/a>)/";
//assunto
$assunto ="/(<li>\s<span\sclass=\"q-title\">)([0-9.]*\s[A-Za-zçãÀ-ȕ0-9\-\s\=\"\%\?\/\_]*)(<\/span>\s<a\shref=\"[.\S]*\" class=\"[.\W\w]*\">)\s([0-9]*)([.\S]*\s<\/a>\s<\/li>)/";
preg_match_all($assuntoff, $file, $matches);
*/




}
