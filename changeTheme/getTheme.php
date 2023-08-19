<?php
    if( isset($_POST['crmOpcion'])){
    
        $crmOpcion = $_POST['crmOpcion'];
        //echo $crmOpcion;
        if($crmOpcion == "wordpress"){
            $pathTheme = getRutaInstalacion()."/wp-content/themes/";
            echo mostraDirectoriosTemas($pathTheme);
        }else if($crmOpcion == "prestashop"){
            $pathTheme = getRutaInstalacion()."/themes/";
        }
    }

    
    function getRutaInstalacion(){
        $ruta = explode("/", dirname(__FILE__));
        array_pop($ruta);
        array_pop($ruta);
        return $ruta = implode("/",$ruta);
    }

    function mostraDirectoriosTemas($pathTheme){
        $temas= [];
        $carpetas = scandir($pathTheme);

        unset($carpetas[0], $carpetas[1]);

        foreach ($carpetas as $folder) {
            if (is_dir($pathTheme . DIRECTORY_SEPARATOR . $folder)) {
                $temas[] = $folder;
            }
        }

        return convertTable($temas);
    }

    function convertTable($temas){
        $filas = recorrerArray($temas);
        $table = "
            <table border='1' color='black'>
                <thead>
                    <th>Nombre del tema</th>
                    <th>Acción</th>
                </thead>
                <tbody>
                    ".$filas."
                </tbody>
            </table>
        ";
        return $table;
    }

    function recorrerArray($temas){
        $filas = "";
        for($i=0; $i < count($temas); $i++){
            $filas .= "<tr><td>".$temas[$i]."</td><td><button id='".$temas[$i]."'>Cambiar</button></td></tr>";
        }
        return $filas;
    }
    
?>