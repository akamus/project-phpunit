<?php

namespace Src;

use Opis\Database\Database;
use Opis\Database\Connection;

class ProvaModel {

    public $db;

    function __construct() {

        $connection = new Connection(
             //   'sqlite:/storage/provas.db'
                'mysql:host=localhost;dbname=provas', 'root', ''
        );

        $this->db = new Database($connection);
        
        if ($this->db->getConnection()) {
         

    }else{
        echo "Connected error!";
    }
    }
    
    function insertProva($data){
        
        if($this->getProva($data)){
            return false;
        }
        https://www.qconcursos.com/questoes-de-concursos/provas/cespe-2018-bnb-especialista-tecnico-analista-de-sistema/questoes
        $result = $this->db->insert([
                
                'nome' => $data['nome'],
                'data' => $data['data'],
                 'quantidade' => $data['quantidade'],
                'url' => 'https://www.qconcursos.com'.$data['url']
            ])
            ->into('prova');
    }
    
     function getProva($prova){
         
         //var_dump($prova);
         
        return $this->db->from('prova')
             ->where('nome')->is($prova['nome'])
               ->andWhere('data')->is($prova['data'])  //Alternatively: ->where('age')->eq(18)
             ->select()
             ->first();
        
    }
     function getAssunto($assunto){
         
        return $this->db->from('prova')
             ->where('prova_id')->is($assunto['prova_id'])
               ->andWhere('disciplina')->is($assunto['disciplina'])  //Alternatively: ->where('age')->eq(18)
                ->andWhere('assunto')->is($assunto['assunto'])  //Alternatively: ->where('age')->eq(18)

                ->select()
             ->first();
        
    }
     function getAllRegistro(){
        $result = $this->db->from('registro')
          //   ->where('id')->is($id) //Alternatively: ->where('age')->eq(18)
             ->select()
             ->all();
        
    }
    
    function insertRegistro($registro){

//        if($this->getAssunto($data)){
//            $this->updateAssunto($adata);
//        }else{

        $result = $this->db->insert([
                'prova' => $registro['prova'],
                'disciplina' => $registro['disciplina'],
                 'assunto' => $registro['assunto'],
               'quantidade' => $registro['quantidade'],
                'url' => 'https://www.qconcursos.com'.$registro['url']

            ])
            ->into('registro');
       // }
    }
    
    function updateAssunto($data){
        $result = $db->update('registro')
           ->where('prova_id')->is($data['prova_id'])
               ->andWhere('disciplina')->is($data['prova_id'])

                ->set(array(
                'prova_id' => $data['prova_id'],
                'disciplina' => $data['disciplina'],
                 'assunto' => $data['assunto'],
               'quantidade' => $data['quantidade'],
                'url' => $data['url']
             ));
    }
    
    
    
    
}
