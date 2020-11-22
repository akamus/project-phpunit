<?php

use Doctrine\DBAL\DriverManager;

require_once './vendor/autoload.php';

//use DOMDocument;
//use DOMXPath;


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

    function aplicacao() {
        return $this->xpath->query("//span[@class='q-date']")->item(0)->nodeValue;
    }

    function totalQuestoes() {
        return $this->xpath->query("//div[@class='panel-heading']/h2")->item(0)->nodeValue;
    }

    function disciplinas() {
        return $this->xpath->query("//div[@class='q-discipline-item']/div[@class='q-heading']/h3[@class='q-title']");
    }

    function questoesPorDisciplina() {
        return $this->xpath->query("//div[@class='q-discipline-item']/div[@class='q-heading'/a]");
    }

    function assunto() {
        var_dump($this->xpath->query("//div[@class='q-discipline-item']/div/ul[@class='q-subjects-list']/li/span[@class='q-title']")->item(0)->nodeValue);
    }

    function questoesPorAssunto() {
        var_dump($this->xpath->query("//div[@class='q-discipline-item']/div/ul[@class='q-subjects-list']/li/a")->item(0)->nodeValue);
    }

    function getHtml() {
        return $this->file;
    }

    function listGroup() {
        return $this->xpath->query("//div[@class='list-group']")->item(1);
    }

    function createHtmlFile($novo) {

        $list = $this->listGroup();

        $list->childNodes->item(2)->nodeValue;

        $text = '';

        if (file_exists("provas-" . $novo . ".html")) {
            $text .= "-------------------------------------------------------------------------------<br/>";
        }

        $text .= $this->prova() . "<br/>";
        $text .= $this->aplicacao() . "<br/>";
        $text .= $this->totalQuestoes() . "<br/>";

        echo "<br/>Criando HMTL<br/>";

        foreach ($list->childNodes as $key => $value) {
            $text .= $value->nodeValue . "<br/>";
        }

        $myfile = fopen("provas-" . $novo . ".html", "a");

        fwrite($myfile, $text);
        fclose($myfile);


        echo "Criando HTML com Sucesso!<br/>";
    }

    function createTxtFile($novo) {


        echo "Criando TXT<br/>";
        $myfile = '';
        $list = $this->listGroup();

        $list->childNodes->item(2)->nodeValue;
        $text = '';

        if (file_exists("provas-" . $novo . ".txt")) {
            $text .= "-------------------------------------------------------------------------------\n";
        }

        $text .= $this->prova() . "\n";
        $text .= $this->aplicacao() . "\n";
        $text .= $this->totalQuestoes() . "\n";

        foreach ($list->childNodes as $key => $value) {

            $text .= $value->nodeValue . "\n";
        }
        $myfile = fopen("provas-" . $novo . ".txt", "a");

        fwrite($myfile, $text);
        fclose($myfile);


        echo "Criado TXT com Sucesso!<br/>";
    }

    function run($novoArquivo = '') {


        echo $this->prova();
        echo $this->aplicacao();
        echo $this->totalQuestoes();

        $this->createHtmlFile($novoArquivo);

        $this->createTxtFile($novoArquivo);
    }

}

use Opis\Database\Database;
use Opis\Database\Connection;

$connection = new Connection('sqlite:provas.db');
$db = new Database($connection);

//18-20
$urls = [
    // "https://www.qconcursos.com/questoes-de-concursos/provas/quadrix-2019-crea-to-analista-de-sistemas",
    //   "https://www.qconcursos.com/questoes-de-concursos/provas/quadrix-2019-prefeitura-de-jatai-go-analista-de-tecnologia-da-informacao",
    //   "https://www.qconcursos.com/questoes-de-concursos/provas/quadrix-2019-crn-9-assistente-de-informatica",
    //    "https://www.qconcursos.com/questoes-de-concursos/provas/quadrix-2019-crea-go-analista-t-i",
    //   "https://www.qconcursos.com/questoes-de-concursos/provas/quadrix-2019-fhgv-tecnico-em-informatica",
    //  "https://www.qconcursos.com/questoes-de-concursos/provas/quadrix-2019-cra-pr-analista-sistema-i",
    //    "https://www.qconcursos.com/questoes-de-concursos/provas/quadrix-2018-sesc-df-professor-informatica-educativa",
    "https://www.qconcursos.com/questoes-de-concursos/provas/quadrix-2018-crm-pr-analista-de-tecnologia-da-informacao"
];


foreach ($urls as $url) {
    // echo date('h:i:s') . "<br/>";
    //sleep(20);
    //$rgx = new Rgx($url);
    //$rgx->run("18-20-quadrix");
}

//vscode
//(\s[0-9]{1,3}\s[questão|questões]{1,})
//|| $1\n
//(\s[0-9]{1,3}\.[0-9]{0,3}\s)([0-9a-z-A-Z\sÀ-ü().,|:º–/-].*)[;(|\s)]*([0-9]{1,2}\s[questão|questões]*)

$a = file("provas-18-20-quadrix.txt");

//var_dump($a);


foreach ($a as $value) {
    preg_match_all("/\s[0-9]{1,3}\.[0-9]{0,3}\s/im", $value, $match);
    //var_dump($match[0]);   

    preg_match_all("/(\s[0-9]{1,3}\.[0-9]*)\s([0-9a-z-A-Z\sÀ-ü().,\|:º°–\/-]*)(;;;)*(\s\s[0-9]{1,2}.[questão|questões].*?$)/im", $value, $match);

    if (!empty($match[0][0])) {
        $assunto = $match[2][0];
        $qtdade = $match[4][0];
    }
    
    var_dump($match);
    
    $result = $db->from('prova')
            ->where('assunto')->is($assunto) //Alternatively: ->where('age')->eq(18)
            ->select()
            ->all();
    if (empty($result)) {
        $result = $db->insert(array(
                    'assunto' => $assunto,
                    'qtdade' => $qtdade
                ))
                ->into('prova');
    } else {

        $result = $db->update('prova')
                ->where('assunto')->is($assunto)
                ->set(array(
            'qtdade' => $qtdade+$result->qtdade,
        ));
    }
}



/*
use Opis\Database\Database;
use Opis\Database\Connection;

$connection = new Connection('sqlite:provas.db');
$db = new Database($connection);

//insert
$result = $this->db->insert(array(
            'assunto' => '',
            'questoes' => ''
        ))
        ->into('prova');

//update

$result = $this->db->update('prova')
        ->where('assunto')->is($assunto)
        ->set(array(
    'questoes' => $qtdade,
        ));

*/