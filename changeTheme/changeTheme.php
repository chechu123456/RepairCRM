<?php
    require_once("../clases/ConexionBd.php");
    require("../clases/Server.php");

    var_dump($_POST);

    if(isset($_POST['crmOpcion'])){
        $crmOpcion = $_POST['crmOpcion'];
        $tema = $_POST['tema'];

        if($crmOpcion == "wordpress"){

            //Controlar si es mysqli o mysql
            $server = new Server();
            $extensiones = $server->extensiones;

            $rutaInstalación = getRutaInstalacion();

            $pathConexBD ="$rutaInstalación/wp-config.php";
            $conexionBd = new ConexionBd( $extensiones, $pathConexBD, "wp");
    
            //Obtener prefijo bd
            $bdPrefix = $conexionBd->getPrefixBD();

            //Ejecutar consulta SQL
            $sql = "UPDATE ".$bdPrefix."options SET `option_value` = '".$tema."' WHERE `option_name` LIKE 'template'";
            $consult1 = $conexionBd->query($sql);
            $sql = "UPDATE ".$bdPrefix."options SET `option_value`= '".$tema."' WHERE `option_name` LIKE 'stylesheet'";
            $consult2 =$conexionBd->query($sql);
            $sql = "UPDATE ".$bdPrefix."options SET `option_value`= '".$tema."' WHERE `option_name` LIKE 'current_theme'";
            $consult3 =$conexionBd->query($sql);
            echo $sql;
            if($consult1 && $consult2 && $consult3){
                echo "OK";
            }else{
                echo "Error al realizar la consulta a la base de datos alguna consulta";
            }
        }
        

        
    }






    function getRutaInstalacion(){
        $ruta = explode("/", dirname(__FILE__));
        array_pop($ruta);
        array_pop($ruta);
        $ruta = implode("/",$ruta);
        return $ruta;
    }
?>