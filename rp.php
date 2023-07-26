<?php
    require("clases/Server.php");
    require("clases/WordPress.php");
    require("clases/Fichero.php");
    require("clases/CapturaPantalla.php");
   

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

        $extensiones = funcionesServer(getUser());

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

            funcionesWordPress(getRutaInstalacion(), $pluginsWp, $valoresExtra, $url, $extensiones);

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
        echo  $server->__toString() ."<br> Memory_limit establecido: ";
        print_r($server->getMemoryLimit());
        echo "<br>";
        //print_r($server->getConsumoCPU($usuario));
        echo "<br> Extensiones faltantes recomendables: ";
        print_r($server->getExtensionesRecomendables($extensionesRm));

        return $server->extensiones;
    }
  
    function funcionesWordPress($rutaInstalación, $pluginsWp, $extra, $url, $extensiones){
        $wp = new WordPress($rutaInstalación, $pluginsWp, $extra, $extensiones);
        echo "<br> Versión de WordPress:". $wp->version . "<br>";
        //var_dump($wp->getPluginsThemeFailed());
    
        //$fichero = new CapturaPantalla($url);


        $fichero = new Fichero("../wp-content/plugins/", $url);
        echo "<p>Handlers PHP detectados:</p>";
        print_r($fichero->handlerPHP(getRutaInstalacion(), "/home/".getUser(). "/"));
        //$pluginsWp --> onALLpluigns, offALLplugins, offErrorPlugins
        
        if(array_search("cache", $extra)){
            $fichero->obtenerCarpetasDirectorio($pluginsWp, $wp->getPluginsThemeFailed(), $cache = true);
        }else{
            $fichero->obtenerCarpetasDirectorio($pluginsWp, $wp->getPluginsThemeFailed(), $cache = false);
        }

        //MostrarErroLog
        aplicarExtrasWP($wp,$extra);
        //Otros extras
        aplicarExtrasFichero($fichero,$extra);
    
    }

    function aplicarExtrasWP($obj, $extra){


        if(array_search("theme", $extra)){
            echo "<p>Tema WP instalado actualmente:</p>";
            //echo var_export($obj->datosConexBD);
        }

         
        if(array_search("mostrarErrorLog", $extra)){
            echo "<p>Error Log:</p>";
            echo var_export($obj->errorLogRaiz,true);
        }
                 
        if(array_search("eliminarErrorLog", $extra)){
            $obj->rmErrorLog();
        }

        if(array_search("renombrarErrorLog", $extra)){
            $obj->renameErrorLog();
        }

    }

    
    function aplicarExtrasFichero($obj, $extra){

        if(array_search("emptyFiles", $extra) !== false && $extra[0] == "emptyFiles" ){
            echo "<p>Ficheros vacíos:</p>";
            var_dump($obj->ficheros_vacios(getRutaInstalacion()));
        }
       
    }

?>
<!--
<embed src="pruebas.html"width="100%" height="600px" onerror="alert('URL invalid !!');" />
-->

</body>
</html>
