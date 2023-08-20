<?php


class Crm{
    public $crm = "";
    public $pathV = "";
    public $pathErrorLog = [];
    public $pathTheme;
    public $version = "";
    public $datosConexBD = [];
    public $errorLogRaiz = [];
    public $arrayPluginsThemeFailed = [];
    public $pluginsThemeFail = [];
    public $pluginsFail = [];
    public $themeFail = [];
    public $valorTheme;
    public $palabrasAbuscarError = [];
    public $pluginsWp = "";
    public $extra = [];

    private $conex;



    public function __construct() {
    }

    public function setCRM($crm){
        $this->crm = $crm;
    }

    public function setPath($pathV){
        $this->pathV = $pathV;
    }

    public function setErrorLog($pathErrorLog){
        $this->pathErrorLog = $pathErrorLog;
    }

    public function setPluginsWp($pluginsWp){
        $this->pluginsWp = $pluginsWp;
    }

    public function setExtra($extra){
        $this->extra = $extra;
    }

    public function getPathErrorLog(){
        return $this->pathErrorLog;
    }

    public function setPathTheme($pathTheme){
        $this->pathTheme = $pathTheme;
    }

    public function setConex($conex){
        $this->conex = $conex;
    }


    //Obtener Versión
    public function getVersion(){
        if($this->crm == "wp"){
            $palabraBuscada = '$wp_version = ';
           
        }else if($this->crm == "pr"){
            $palabraBuscada = 'const VERSION = ';

        }

         // Abre el archivo en modo lectura
         $archivoPuntero = fopen($this->pathV, 'r');

         if ($archivoPuntero) {
             // Recorre el archivo línea por línea
             while (($linea = fgets($archivoPuntero)) !== false) {
                 // Verifica si la línea contiene la palabra buscada
                 if (strpos($linea, $palabraBuscada) !== false) {
                     // Imprime la línea completa
                     //Obtener versión y Quitar comillas, punto y coma, sustituirlo por espacio en blanco
                     $this->version=str_replace(array('"', ";", "'"), "", explode("=",$linea)[1]);
                 }
             }
             // Cierra el archivo
             fclose($archivoPuntero);
         } else {
             echo "<p>No se pudo abrir el archivo ".$this->pathV." para obtener la versión de WP</p>.";
         }

        return $this->version; 
        
    }

    //Obtener los ErrorLogs de la web
    public function getErrorLog(){
        echo "<p>Opción marcada: $this->pluginsWp</p>";
        if(empty($this->errorLogRaiz)){
            $today = date("d-M-Y");
            //Obtener las últimas líneas del fichero del día de hoy
            exec("tail -25 ".$this->pathErrorLog[0]." | grep '$today'", $errorToday);

            //Si no hay Errores en el fichero del raiz del wordpress
            if(empty($errorToday)){
                array_push($this->errorLogRaiz,"<p>No se encontraron errores en el errorLog --> ".$this->pathErrorLog[0] ." - Buscando errores en ". $this->pathErrorLog[1]."</p>");

                //Buscar si hay errores de hoy en el fichero del wp-admin
                exec("tail -25 ".$this->pathErrorLog[1]." | grep '$today'", $errorToday);

                    //Si no hay Errores en el fichero del wp-admin, coger los últimos errores encontrados de cualquier fecha
                    if(empty($errorToday) && $this->pluginsWp != "offErrorPlugins"){
                        array_push($this->errorLogRaiz,"<p>No se encontraron errores en el errorLog --> ". $this->pathErrorLog[1] ." - Buscando errores recientes en". $this->pathErrorLog[0] ." </p>");
                        exec("tail -25 ".$this->pathErrorLog[1]."", $lastErrors);

                        //Si no hay errores en ningún fichero, indicarlo y
                        if(empty($lastErrors)){
                            array_push($this->errorLogRaiz,"<p>No se encontraron errores en ningún errorLog </p>");
                        }else{
                            array_push($this->errorLogRaiz, $lastErrors);
                        }

                    }elseif($this->pluginsWp == "offErrorPlugins"){
                        echo "<p>No se encontraron errores en el día de hoy y no se han desactivado ningún plugin</p>";
                    }else{
                        array_push($this->errorLogRaiz, $errorToday);
                    }
            
            }else{
                array_push($this->errorLogRaiz,$errorToday);
            }
            return $this->errorLogRaiz;
        }
        
    }

    //Encontrar dentro del Fichero error log, los Fatal Errors
    public function getErrorsFatal(){
        $palabra = 'Fatal error';
        $encontrado = false;
        array_walk_recursive($this->errorLogRaiz, function ($value, $key) use ($palabra, &$encontrado) {
            if (strpos($value, $palabra) !== false) {
                $encontrado = true;
                array_push($this->arrayPluginsThemeFailed, $value);
            }
        });
        return $encontrado;
    }

    //Obtenemos los nombres de los plugins, temas o plugisytemas que fallan y que se muestran en los FatalErrors del error_log
    public function getPluginsThemeFailed(){
        $this->getErrorLog();
        $this->getErrorsFatal();
        $palabras =   $this->palabrasAbuscarError;
        //Borrar - Solo VALIDO PARA WORDPRESS
        if($this->crm == "wp"){
            $palabras =  array('plugins', 'themes');
        }else if($this->crm == "pr"){
            $palabras =  array('modules', 'themes');
        }
        
        array_walk_recursive($this->arrayPluginsThemeFailed, function ($value, $key) use ($palabras) {

            $pluginTema = explode("/", $this->arrayPluginsThemeFailed[$key]);

            array_walk_recursive($pluginTema, function ($value, $key2) use ($palabras, $pluginTema) {
                          
                if (in_array($value, $palabras)) {
                    if("plugins" == $pluginTema[$key2]){

                        array_push( $this->pluginsFail,$pluginTema[$key2+1]);

                    }else if("themes" == $pluginTema[$key2]){

                        array_push($this->themeFail, $pluginTema[$key2+1]);

                    }

                    array_push($this->pluginsThemeFail,$pluginTema[$key2+1]);

                }

            });
            

       });

        array_unique($this->pluginsFail);
        array_unique($this->themeFail);
        

        return array_unique($this->pluginsThemeFail);
       
    }

    //Devuelve los plugins o temas que falla segun se pase en el valor
    //Se puede pasar las variables (pluginsFail, themeFail, u otra)
    public function getFails($valor){
        if(empty($this->$valor)){
            return false;
        }else{
            return array_unique($this->$valor);
        }
    }

    function rmErrorLog(){
        if(file_exists($this->getPathErrorLog()[0])){
            unlink($this->getPathErrorLog()[0]);
        }

        if(file_exists($this->getPathErrorLog()[1])){
            unlink($this->getPathErrorLog()[1]);
        }
        
    }

    function renameErrorLog(){
        if(file_exists($this->getPathErrorLog()[0])){
            rename($this->getPathErrorLog()[0], $this->getPathErrorLog()[0]."_automatic_old");
        }

        if(file_exists($this->getPathErrorLog()[1])){
            rename($this->getPathErrorLog()[1], $this->getPathErrorLog()[1]."_automatic_old");
        }
        
    }

  
    //Verificar Tema 
    public function checkTheme($bdPrefix){
        if($this->crm == "wp"){
            $sql = "SELECT option_name, option_value  FROM ".$bdPrefix."options WHERE `option_name` LIKE 'template' OR `option_name` LIKE 'stylesheet' OR `option_name` LIKE 'current_theme'";
        }else if($this->crm == "pr"){
            $sql = "SELECT theme_name FROM ".$bdPrefix."shop WHERE `active` LIKE '1'";
        }
        $result = $this->conex->query($sql);
        if ($result->num_rows > 0) {
            // Mostrar resultados
            $cont=0;

            if($this->crm == "wp"){
                while($row = $result->fetch_assoc()) {
                    if($row['option_name'] == "stylesheet"|| $row['option_name'] == "template"){
                        $this->valorTheme= $row['option_value'];
                        $cont++;
                    }
                    
                }

                if($cont == 2){
                    echo "<p>Tema actual: $this->valorTheme</p>";
                    $directorio = $this->pathTheme. $this->valorTheme;
                    if (is_dir($directorio)){
                        $archivos = scandir($directorio);
                        if( count($archivos) > 2) {
                            echo "<p>El $directorio EXISTE y contiene archivos</p>";
                        } else {
                            echo "El directorio está vacío";
                        }
                    }else{
                        echo "<p>El $directorio NO existe</p>";
                    }
                }   
            }else if($this->crm == "pr"){

                while($row = $result->fetch_assoc()) {
                        $this->valorTheme= $row['theme_name'];
                }

                echo "<p>Tema actual: $this->valorTheme</p>";
                $directorio = $this->pathTheme. $this->valorTheme;
                echo $directorio;

                if (is_dir($directorio)){
                    $archivos = scandir($directorio);
                    if( count($archivos) > 2) {
                        echo "<p>El $directorio EXISTE y contiene archivos</p>";
                    } else {
                        echo "El directorio está vacío";
                    }
                }else{
                    echo "<p>El $directorio NO existe</p>";
                }
            }

           
        } else {
            echo "0 resultados";
        }

    }


   

}


?>