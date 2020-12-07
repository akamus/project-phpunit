<?php
namespace Src;

//set_time_limit(0);
ini_set('max_execution_time', 700); //300 seconds = 5 minutes

define('URL_PROVA', 'https://www.qconcursos.com/questoes-de-concursos/provas');
define('URL_ZIP_FILE', 'https://www.pciconcursos.com.br/provas/download/');
define('URL_DOWNLOAD', 'https://arquivo.pciconcursos.com.br/provas/');
define('REGEX_URL', '/https:\/\/www.pciconcursos.com.br\/provas\/download\/[a-z0-9_-][a-z0-9_-][a-z0-9_-][a-z0-9_-]*/');
define('REGEX_LINK_ZIP', '/https:\/\/arquivo\.pciconcursos\.com\.br\/provas\/[0-9a-z]+\/[0-9a-z]+\/[a-zA-Z0-9_]+\.zip/');

define('REGEX_LINK_PROVA_PDF', '/https:\/\/arquivo\.pciconcursos\.com\.br\/provas\/*[0-9a-z]*\/[0-9a-z]*\/*[(|gabarito|gabaritos)]*[a-z0-9_]*\.pdf/');
define('REGEX_LINK_GABARITO_PDF', '/https:\/\/arquivo\.pciconcursos\.com\.br\/provas\/[0-9a-z]+\/[0-9a-z]+\/[a-zA-Z0-9_]+\.pdf/');



define('REGEX_NUM_PAGE', '/Mostrando página [0-9]+ de [0-9]+/');
define('REGEX_URL_FILTROS', "/https:\/\/www.pciconcursos.com.br\/provas\/download\/[a-z0-9_-][a-z0-9_-][a-z0-9_-][a-z0-9_-]+");

//ALIMENTAR FORM SELECT

define('REGEX_PROVA_CARGO', "/<a href=\"(https:\/\/www.pciconcursos.com.br\/provas\/[a-z\-]*\") title=\"([0-9a-zA-Z\-\s\ç\ã\ó\á\ú\õ\í\ê\é\ª\º\â]*)\">([0-9a-zA-Z\-\s\ç\ã\ó\á\ú\õ\í\ê\é\ª\º\â]*)<\/a>/");
define('REGEX_PROVA_TRIBUNAL', "/<a href=\"(https:\/\/www\.pciconcursos\.com\.br\/provas\/[a-z\-]{2,})\">([a-zA-Z\s\ç\á\é\-]{2,})<\/a>/");
define('REGEX_PROVA_ORGANIZADORA', "/<a href=\"(https:\/\/www\.pciconcursos\.com\.br\/provas\/[cesp|esaf|fcc|vunesp]{2,})\">([a-zA-Z\-\s\ç\ã\á]*)<\/a>/");
define('REGEX_PROVA_ANO', "/<a href=\"(https:\/\/www.pciconcursos.com.br\/provas\/[0-9]{4})\">([0-9]{4})<\/a>/");

class QconcModel {

    public $_modeloUrlParaPaginar;
    public $_quantidadeDePaginasEncontradas;
    public $_conteudoHtmlDaPaginaEncontrada;
    public $_modeloUrlComFiltro;
    public $_conteudoDaPaginaComZip;
    public $_linksEncontradosNaPagina;
    public $_listaDeUrlsDeArquivoZip;
    //FILTROS
    public $_cargo;
    public $_banca;
    public $_ano;

    function __construct() {
        
    }

    function setUrlParaBuscarComFiltro($filtro) {
        
        return URL_PROVA . $this->formatarFiltros($filtro);
    }

    function getUrlComFiltro() {

        return $this->_modeloUrlComFiltro;
    }

    function getHtmlDaPagina($url = URL_PROVA) {
        $content = file_get_contents($url);
        
        return $content;
    }

    function getLinksDownloadDoHtmlDaPagina($content) {

        preg_match_all(REGEX_URL, $content, $linksPage);
        return $linksPage;
    }

    function getLinkZip($string) {
   //     var_dump($string);
        preg_match_all(REGEX_LINK_ZIP, $string, $matches, PREG_SET_ORDER, 0);
   //    var_dump($matches);
        return $matches;
    }

    function getLinkPdf($string) {
     //   var_dump($string);
        preg_match_all(REGEX_LINK_PROVA_PDF, $string, $matches, PREG_SET_ORDER, 0);
      // var_dump($matches);
        return $matches;
    }
    
    
    /*
     * busca geral
     */
    function formatarFiltros($filtros){
        $cont = count($filtros);
        $filtro = '';
        if($cont == 2 ){
            $filtro = $filtros[0].'-'.$filtros[1];
        }elseif ($cont == 1) {
            $filtro = $filtros[0];
        }else{
            
        }
        return $filtro;
    }




    function getLinkFiltro($url, $filtros) {
        
        //echo 'url:'.$url;
        
        $reg = "/https:\/\/www.pciconcursos.com.br\/provas\/download\/[a-z0-9_-]*($filtros[0]|$filtros[1])*[a-z0-9_-]*/";
      
        preg_match_all($reg, $url, $matches, PREG_SET_ORDER, 0);

        if (empty($matches)) {
            return false;
        }else{
          //  var_dump($matches);
         return $matches[0][0];
        }
    }

    public function getLinksZipDaPagina($listaUrlsParaBuscarZip = []) {

        $listaUrlZip = [];

        foreach ($listaUrlsParaBuscarZip as $key => $url) {
            foreach ($url as $key => $u) {
                $content = $this->getConteudoHtmlDaPagina($u);
                $array = $this->getLinkZip($content);
                $zip = $array[0][0];
                array_push($listaUrlZip, $zip);
            }
        }
        return $listaUrlZip;
    }

    public function getLinksPdfDaPagina($listaUrlsParaBuscarPdf = []) {

        $listaUrlPdf = [];

        foreach ($listaUrlsParaBuscarPdf as $key => $url) {
            foreach ($url as $key => $u) {
                $content = $this->getConteudoHtmlDaPagina($u);
                $array = $this->getLinkPdf($content);
                $zip = $array[0][0];
                array_push($listaUrlPdf, $zip);
            }
        }
        return $listaUrlPdf;
    }

    function getQuantidadeDePaginasEncontradas($content) {
        if (empty($content)) {
            echo 'sem content';
        }


        preg_match_all(REGEX_NUM_PAGE, $content, $pagina);

        if (empty($pagina[0])) {
            return 0;
        } else {

            return trim(substr($pagina[0][0], 22, 24));
        }
    }

    //##########################################################################   
    //alimentar select form
    function getConteudoDeHtmlDaPaginaInicial() {
        return $this->getHtmlDaPagina(URL_PROVA);
    }

    //alimentar select form
    function getLinksProvaPorCargo() {
        $content = $this->getConteudoDeHtmlDaPaginaInicial();

        //possui 3 grupos : url , title, Texto do link        

        preg_match_all(REGEX_PROVA_CARGO, $content, $listaLinks);

        return $listaLinks;
    }

//alimentar select form
    function getLinksProvaDeTribunais() {
        $content = $this->getConteudoDeHtmlDaPaginaInicial();
        //possui 3 grupos : url , title, Texto do link        

        preg_match_all(REGEX_PROVA_TRIBUNAL, $content, $listaLinks);

        return $listaLinks;
    }

    //alimentar select form
    function getLinksProvaPorOrganizadora() {
        $content = $this->getConteudoDeHtmlDaPaginaInicial();

        //possui 3 grupos : url , title, Texto do link        

        preg_match_all(REGEX_PROVA_ORGANIZADORA, $content, $listaLinks);

        return $listaLinks;
    }

    function getLinksProvaPorAno() {
        $content = $this->getConteudoDeHtmlDaPaginaInicial();
        //possui 3 grupos : url , title, Texto do link        

        preg_match_all(REGEX_PROVA_ANO, $content, $listaLinks);

        return $listaLinks;
    }

    function buscarLinksEmHtml($html) {

        $listaLinks = $this->getLinksDownloadDoHtmlDaPagina($html);

        return $listaLinks[0];
    }

    function buscarLinksEmHtmlVariasPaginas($htmlPaginaUm, $url, $quantidadeDePaginas) {
        $listaLinks = [];

        $listaLinks[0] = $this->buscarLinksEmHtml($htmlPaginaUm);

        //buscar links em paginação 


        for ($index = 2; $index <= $quantidadeDePaginas; $index++) {
            //definir paginação 
            $urlPage = $url . '/' . $index;

            //busca a partir da pagina 2
            $html = $this->getHtmlDaPagina($urlPage);

            $linksToZip = $this->buscarLinksEmHtml($html);

            $listaLinks[$index - 1] = $linksToZip;
        }

        return $listaLinks;
    }

       
    
     public function buscarUrlComFiltroAno($listaUrls, $filtro) {


        $_listaUrlsFinalZip = [];
        $_listaNegada = [];

        foreach ($listaUrls as  $urls) {
              
           // var_dump($urls);

                
                foreach ($urls as $key => $url) {
                  
                    $filtrar = $this->getLinkFiltro($url,$filtro);
                  
                    if($filtrar){
                        
                    array_push($_listaUrlsFinalZip, $url);
                    
                     }else{                    
                    array_push($_listaNegada, $url);
     
                    }
                }
              
              
           
        }
   
        return $_listaUrlsFinalZip;
        }
    
        public function buscarUrlComFiltroAnoUmaPagina($listaUrls, $filtros) {
          //  $filtro = $this->formatarFiltros($filtro);

        $_listaUrlsFinalZip = [];
        $_listaNegada = [];

        foreach ($listaUrls as  $url) {
              
          //  var_dump($url);

               
                  
                    $filtrar = $this->getLinkFiltro($url,$filtros);
                  
                    if($filtrar){
                        
                    array_push($_listaUrlsFinalZip, $url);
                    
                     }else{ 
                                        
                    array_push($_listaNegada, $url);
     
                    }
                
              
              
           
        }
   
       // var_dump($_listaNegada);

        return $_listaUrlsFinalZip;
        }
    
    

    function buscarLinkZip($listaUrlParaBuscarZip) {

        $listaZip = [];
       // var_dump($listaUrlParaBuscarZip);
        
        foreach ($listaUrlParaBuscarZip as $key => $url) {
         //   echo $url;
            $content = $this->getHtmlDaPagina($url);
          // var_dump($content);
            $array = $this->getLinkZip($content);
            //$array = $this->getLinkProvaPdf($content);

           // var_dump($array);
            
            $zip = $array[0][0];
           // echo $zip;
            array_push($listaZip, $zip);
        }

        //mostrar zips
        foreach ($listaZip as $value) {
            echo $value . '<br/>';
        }
        
        return $listaZip;
    }

    function buscarLinkPdf($listaUrlParaBuscarPdf) {

        $listaZip = [];
       // var_dump($listaUrlParaBuscarZip);
        
        foreach ($listaUrlParaBuscarPdf as $key => $url) {
         //   echo $url;
            $content = $this->getHtmlDaPagina($url);
          // var_dump($content);
          $linksPdfPorPagina = $this->getLinkPdf($content);
            //$array = $this->getLinkProvaPdf($content);
          
            array_push($listaZip, $linksPdfPorPagina);
        }

        //mostrar zips
        foreach ($listaZip as $value) {
         //   echo $value . '<br/>';
        }
        
        return $listaZip;
    }



    function print_array($array){
       //  var_dump($array);
        foreach ($array as $r) {
            foreach ($r as $s) {
                foreach ($s as $t) {
                    echo $t."<br/>";
                }
            }
        }
    }

    function print_i($valor,$label = ''){
        if(empty($label)){
            $label = 'valor';
        }

        echo "<script>console.info('".$label." => ".$valor."')</script>";
    }

    
    function getDownloadFile($file, $name) { // $file = include path
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
           //download
             header('Content-Disposition: attachment; filename=' . basename($name));
            //inline
            //header('Content-Disposition: inline; filename=' . basename($name));

            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }
    }

}
