<?php

require_once './vendor/autoload.php';

use Src\Rgx;
use Src\ProvaModel;

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

//header('Content-Type: text/html; charset=utf-8');

$dump = false;

/**
 * Runner 
 */
$pathProvas = './storage/provas';
$provas = scandir($pathProvas);

//var_dump($provas);


foreach ($provas as $prova) {

    if (strlen($prova) <= 2) {
        
    } else {
        $rg = new Rgx($pathProvas . '/' . $prova);
        $model = new ProvaModel();
        $rg->run();

        $iD = 0;
        $iA = 0;

        $disciplina = '';
        $totalQuestoesDisciplina = 0;
        $assunto = '';
        $provaToDB = utf8_decode($rg->prova());
        $dadosProva = [
            'nome' => $provaToDB,
            'data' => $rg->dataAplicacao(),
            'quantidade' => $rg->filtrarQuantidadeQuestao($rg->totalQuestoesProva()),
            'url' => $rg->urlResolverOnline()
        ];


        $dump ? var_dump($dadosProva) : '';

        if ($model->getProva($dadosProva)) {
            echo $provaToDB . ' exist!<br/>';
        } else {
            $model->insertProva($dadosProva);
            echo 'Sucesso Prova ' . $provaToDB . '!<br/>';

//$prova_id = $model->getProva($rg->prova(), $rg->dataAplicacao())->id;

            $dump ? var_dump($prova_id) : '';
            $rg->filtrarQuantidadeQuestaoProva($rg->totalQuestoesProva());

            do {
                $iD++;
                //buscar disciplina
                $disciplina = $rg->disciplina($iD);
                $totalQuestoesDisciplina = $rg->questoesPorDisciplina($iD);

                if (!empty($disciplina)) {
                    $disciplinaToDB = utf8_decode($rg->filtrarDisciplina($disciplina));

                    $dadosDisciplina = [
                        'prova' => $provaToDB,
                        'disciplina' => $disciplinaToDB,
                        'assunto' => '',
                        'quantidade' => $rg->filtrarQuantidadeQuestao($totalQuestoesDisciplina),
                        'url' => $rg->urlQuestoesDisciplina($iD),
                    ];
                    $dump ? var_dump($dadosDisciplina) : '';

                    $model->insertRegistro($dadosDisciplina);

                 //   echo 'Sucesso Disciplina ' . $disciplinaToDB . '<br/>';

                    echo $dump ? $disciplina . '-' . $totalQuestoesDisciplina . '-' . $rg->urlQuestoesDisciplina($iD) . "<br/>" : '';
                } else {
                    echo $dump ? "----fim d:" . $iD . "------<br/>" : '';
                }

                $iA = 0;
                do {
                    $iA++;
                    $assunto = $rg->assunto($iD, $iA);
                    $questoesPorAssunto = $rg->questoesPorAssunto($iD, $iA);

                    if (empty($assunto)) {
                        echo $dump ? "---fim assunto:" . $iA . " D" . $iD . "------<br/>" : '';
                    } else {
                        $assuntoToDB = utf8_decode($rg->filtrarDisciplina($assunto));
                    
                        $dadosAssunto = [
                            'prova' => $provaToDB,
                            'disciplina' => $disciplinaToDB,
                            'assunto' => $assuntoToDB,
                            'quantidade' => $rg->filtrarQuantidadeQuestao($questoesPorAssunto),
                            'url' => $rg->urlQuestoesAssunto($iD, $iA),
                        ];

                        $dump ? var_dump($dadosAssunto) : '';

                        $model->insertRegistro($dadosAssunto);

                        $urlQuestoesAssunto = $rg->urlQuestoesAssunto($iD, $iA);

                        echo $dump ? $assunto . '-' . $questoesPorAssunto . '-' . $urlQuestoesAssunto . "<br/>" : '';
                    }
                } while (!empty($assunto)); //fim assunto
            } while (!empty($disciplina)); //fim disciplina
        } //
    } //else
}