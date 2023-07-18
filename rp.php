<?php
    require("clases/Server.php");
    require("clases/WordPress.php");
    require("clases/Fichero.php");

    require("clases/CapturaPantalla.php");
    require("pdfcrowd/pdfcrowd.php");
    require("htmltojpeg/HtmlToJpeg.php");


    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- JQUERY -->
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js?ver=1.4'></script>

</head>
<body>
    <?php
    //var_dump($_POST);
    if( isset($_POST['crmOpcion']) &&  isset($_POST['url']) ){
    
        $crmOpcion = $_POST['crmOpcion'];
        $url = $_POST['url'];

        $valoresExtra = array();

        funcionesServer(getUser());

        if(isset($_POST['pluginsWp']) ){
            $pluginsWp = $_POST['pluginsWp'];
        }else if(isset($_POST['modulosPr'])){
            $modulosPr = $_POST['modulosPr'];
        }


        if(isset($_POST['extra'])){
            foreach ($_POST['extra'] as $extra) {
                array_push($valoresExtra, $extra);
            }
        }else{
            echo "<p>No hay ningún extra seleccionados</p>";
        }


        if( $crmOpcion === "prestashop" && isset($_POST['modulosPr'])){

        }else if($crmOpcion === "wordpress" && isset($_POST['pluginsWp']) ){

            funcionesWordPress(getRutaInstalacion(), $pluginsWp, $valoresExtra, $url);

        }else{
            echo "<p>No se ha seleccionado una opción dentro del CRM escogido</p>";
        }

    }else{
        echo "<p>No se han recibido parámetros. Elige el CRM y alguna de las opciones sobre plugins o módulos</p>";
    }
     

    function getRuta(){
        return explode("/", dirname(__FILE__));
    }

    function getUser(){
        return getRuta()[2];
    }

    function getRutaInstalacion(){
        return "/home/".getUser(). "/".getRuta()[3];
    }

    function funcionesServer($usuario){
        $server = new Server();

        if($server->versionPhp<7.4){
            $extensionesRm = "extensionesRm56";
        }else if($server->versionPhp >= 7.4){
            $extensionesRm = "extensionesRm74";
        }
        
        //echo $server->__toString();
    
        //print_r($server->getConsumoCPU());
        //echo "<br>";
        //print_r($server->getConsumoRAM());
        echo  $server->__toString() ."<br>";
        print_r($server->getMemoryLimit());
        echo "<br>";
        print_r($server->getConsumoCPU($usuario));
        echo "<br>";
        print_r($server->getExtensionesRecomendables($extensionesRm));
    }
  
    function funcionesWordPress($rutaInstalación, $pluginsWp, $extra, $url){
        $wp = new WordPress($rutaInstalación, $pluginsWp, $extra);
        echo "<br>". $wp->version . "<br>";

        //var_dump($wp->getPluginsThemeFailed());
    
        //$fichero = new CapturaPantalla($url);

        $fichero = new Fichero("../wp-content/plugins/", $url);
        //$pluginsWp --> onALLpluigns, offALLplugins, offErrorPlugins
        $fichero->obtenerCarpetasDirectorio($pluginsWp, $wp->getPluginsThemeFailed());

        aplicarExtras($wp,$extra);
        $fichero->ficheros_vacios();

        /*
        var_dump($wp->getErrorLog());
        var_dump($wp->getErrorsFatal());
        */
        /*
        var_dump($wp->getPluginsThemeFailed());
        echo "<br>-------";
        var_dump($wp->getFails("themeFail"));
    $url="https";
        $fichero = new Fichero("../wp-content/plugins/", $url);
    
    
        print_r($fichero->ficheros_vacios("../"));
    */
    
    }

    function aplicarExtras($crm, $extra){
        if(array_search("mostrarErrorLog", $extra)){
            echo var_export($crm->errorLogRaiz,true);
        }
    }

   


/*
    echo "<p>Versión de PHP: " .  phpversion() . "</p>";
    echo "<p>Dominio: " .  $_SERVER['SERVER_NAME'] ."</p>";

    echo "<p>Ruta: " .  $_SERVER['SERVER_NAME'] .  $_SERVER['REQUEST_URI'] ."</p>";
    echo "<p>Revisar error contenido mixto</p>";

    $accion = "activar";
    $url = "http://vaguineitor.thechechubark.online/";

    //$fichero = new CapturaPantalla($url);

    $fichero = new Fichero("../wp-content/plugins/", $url);
    $fichero->obtenerCarpetasDirectorio($accion);
*/

    /***********************************/
    
    
    /*
    $html2Jpeg = new HtmlToJpeg();
    $html2Jpeg->renderHtml();//You can write html
    $html2Jpeg->renderView("pruebas.html");

    //$html2Jpeg->renderView("test.html");//you can add html or php files as a page
    echo $html2Jpeg->output();
    $html2Jpeg->download();//starting download
    */


    /**********************************/


?>
<!--
<embed src="pruebas.html"width="100%" height="600px" onerror="alert('URL invalid !!');" />
-->

</body>
</html>
