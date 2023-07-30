<?php
    if( isset($_POST['crmOpcion'])){
    
        $crmOpcion = $_POST['crmOpcion'];
    }

    
    function getRutaInstalacion(){
        $ruta = getRuta();
        array_pop($ruta);
        $ruta = implode("/",$ruta);
        return $ruta;
    }
    
?>