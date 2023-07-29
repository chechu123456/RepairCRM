<?php

    class Fichero extends WordPress{
        public $directorio;
        public $url;
        public $contenidoDirectorio = array();
        public $ficherosVacios = [];

        function __construct($directorio, $url){
            $this->directorio = $directorio;
            $this->url = $url;
        }

        function crearFichero($nombreFichero, $contenido){
            $file = fopen($nombreFichero, "w");

            fwrite($file, $contenido . PHP_EOL);
            
            
            fclose($file);
        }

     

        function obtenerCarpetasDirectorio($accion, $pluginFail, $cache){
            //Comprobar si existe el directorio "Estados" y borrar todo el contenido
            $this->carpetaEstados();
            if($accion != "nothing"){
                $directorio = opendir($this->directorio);
                // Recorre todos los elementos del directorio
                while (($archivo = readdir($directorio)) !== false)  {
                    // Se muestran todos los archivos y carpetas excepto "." y ".."
                    if ($archivo != "." && $archivo != "..") {
                        // Si es un directorio se recorre recursivamente
                        if (is_dir($this->directorio. $archivo)) {
                            $this->listarContenido($archivo);
                            if($accion == "onALLplugins"){
                                echo ($cache) ? $this->borrarCache(): "<p>Cache NO borrada</p>";
                                $this->comprobarPluginDesactivado($this->directorio.$archivo);
                                echo $this->crearPag($archivo);
                            }elseif($accion == "offALLplugins"){                    
                                $this->comprobarPluginActivado($this->directorio.$archivo); 
                            }elseif($accion == "offErrorPlugins"){
                                if(in_array($archivo,$pluginFail)){
                                    $this->comprobarPluginActivado($this->directorio.$archivo); 
                                }
                            }else{                            
                                echo "Error solicitud al renombrar los ficheros";
                            }
                        } 
                    }
                }
            }else{
                echo "<p>No se han realizado cambios en los ficheros</p>";
            }


        }

 

        function listarContenido($carpetas){
            echo $html= "<li>" . $carpetas . "</li>";
        }

        function desactivarPlugins($plugin){
            rename($plugin, $plugin."_automatic_old");
        }

        function activarPlugins($plugin){
            $fichero = explode("/",str_replace("_automatic_old", "", $plugin));
            $fichero = $fichero[count($fichero)-1];
            rename($plugin, $this->directorio . $fichero);
        }

        function comprobarPluginDesactivado($plugin){
            if( preg_match("/\w*_automatic_old$/",$plugin)){
                $this->activarPlugins($plugin);
                return true;
            }else{
                return false;
            }
        }

        function comprobarPluginActivado($plugin){
            
            if( !preg_match("/\w*_automatic_old$/",$plugin) ){
                $this->desactivarPlugins($plugin);
                return true;
            }else{
                return false;
            }
            
        }       

        function crearPag($plugin){
            $ruta = "estados/".$plugin.".html";
            echo $plugin ."<br>" . $ruta;

            //File_get_contents vs curl
            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL,$this->url);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 3600);
            $html = curl_exec($ch);
            curl_close($ch);

            $this->crearFichero($ruta,  $html, "w");
            //$this->crearFichero($ruta, file_get_contents($this->url), "w");

    /* OTRA ALTERNATIVA A PROBAR
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch,CURLOPT_URL,$this->url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
    */

            return  "<embed src='$ruta' width='100%' height='800px' onerror=\"alert('URL invalid !!');\" />";
            //return "<iframe width='300' height='200'src='$ruta'></iframe>";
        }

        function carpetaEstados(){
             //Comprobar si existe la carpeta Estados
            if(!is_dir("estados")){
                mkdir("estados", 0755);
            }else{
                //Ver si existen ficheros dentro de la carpeta Estados
                $arrFiles = array();
                $handle = opendir('estados');
                if ($handle) {
                    while (($entry = readdir($handle)) !== FALSE) {
                        $arrFiles[] = $entry;
                    }
                }
                closedir($handle);
                //Si hay contenido dentro de la carpeta, borrarlo
                if(!empty($arrFiles)){
                    $files = glob('estados/*'); //obtenemos todos los nombres de los ficheros
                    foreach($files as $file){
                        if(is_file($file))
                        unlink($file); //elimino el fichero
                    }
                }
            }
        }

        function borrarCache(){
            if ($handle = opendir('/home/')) {                
                $file = readdir($handle);
                
                while (false !== ($file = readdir($handle))) {

                    if ($file != "." && $file != "..") {
                        $usuario = $file;

                        if ($handle2 = opendir("/home/$file/")) {                
                            $file = readdir($handle2);

                            while (false !== ($file = readdir($handle2))) {
                                if ($file != "." && $file != "..") {

                                    if($file == "lscache"){
                                        if ($handle3 = opendir("/home/$usuario/lscache/")) {                
                                            $file = readdir($handle3);
                                            $this->rrmdir("/home/$usuario/lscache");
                                            /*
                                            while (false !== ($file = readdir($handle3))) {
                                                if ($file != "." && $file != "..") {
                                                    unlink("/home/$usuario/lscache/$file"); //elimino el fichero
                                                }

                                            }*/
                                            closedir($handle3);
                                        }
                                    }
                                }
                            }
                            
                            closedir($handle2);
                        }
                    }
                }
                
                closedir($handle);
            }
        }

        function rrmdir($dir){
            if (is_dir($dir)){
                $objects = scandir($dir);

            foreach ($objects as $object){

                if ($object != '.' && $object != '..'){
                    if (filetype($dir.'/'.$object) == 'dir') {$this->rrmdir($dir.'/'.$object);}
                    else {unlink($dir.'/'.$object);}
                }
            }

            reset($objects);
            rmdir($dir);
            }
        }



        //Obtener nombre de los ficheros vacios o que tienen 0 bytes
        function ficheros_vacios($rutaInstalacion) {
            $extension = 'php';

            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rutaInstalacion));
            foreach ($iterator as $archivo) {
                if ($archivo->isFile()) {
                    $nombreArchivo = $archivo->getFilename();
                    if (($extension === '' || pathinfo($nombreArchivo, PATHINFO_EXTENSION) === $extension) && $archivo->getSize() == 0) {
                        array_push($this->ficherosVacios,$archivo->getPathname());
                    }
                }
            }

            return $this->ficherosVacios;
        }

        public function handlerPHP($directorio){


            //Nombre del archivo
            $palabraBuscar = "AddHandler";

            $arrayDirectorio = explode("/", $directorio);
            $arrayRutasHandler = [];            
            
            
            //Buscar ./htaccess desde el directorio actual hasta los que hay en subdirectorios padres
            for($i = count($arrayDirectorio); $i >= 3 ; $i--){
                $directorioFinal = implode("/", $arrayDirectorio);
                $ruta = $directorioFinal."/.htaccess";
                if(file_exists($directorioFinal."/.htaccess")){
                    
                    $datos = $this->encontrarDatosArchivo($ruta);
                    $encontrado = $this->encontrarPalabraLinea($datos, $palabraBuscar);
                    if($encontrado){
                        array_push($arrayRutasHandler, $ruta);
                    }

                }
                
                array_pop($arrayDirectorio);
            }

            if(count($arrayRutasHandler) == 0 ){
                array_push($arrayRutasHandler,"<p>No hay handlers en los .htaccess del directorio ni en los directorios padres</p>");
                return $arrayRutasHandler;
            }else{
                return $arrayRutasHandler;
            }


        }

        public function encontrarDatosArchivo($archivo){
            
            //Se abre el archivo
            $file = fopen($archivo, "r") or exit("No se pudo abrir el archivo!"); 
            //Auxiliar para las lineas del archivo
            //Palabra a buscar
         
            $datos =[];
            //Se lee el archivo
            while(!feof($file))
            { 
                /*Comparación del archivo y la palabra a buscar si es verdad 
                se almacena en la variable $linea*/
                array_push( $datos, fgets($file));

            }

            //Se cierra el archivo
            fclose($file);

            return $datos;            
        }

        public function encontrarPalabraLinea($datos, $palabraBuscar){
            $encontrado = false;
            array_walk_recursive($datos, function ($value, $key) use ($palabraBuscar, &$encontrado) {
                if (strpos($value, $palabraBuscar) !== false) {
                    $encontrado = true;
                }
            });

            return $encontrado;
        }
        
    }
?>
