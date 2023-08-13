<?php

class ConexionBd {
    private $host;
    private $username;
    private $password;
    private $database;
    private $bdPrefix;
    private $conex;

    private $datosConexBD = [];
    private $pathConexBD;
    public $crm;

    public function __construct($extensiones, $pathConexBD, $crm) {
        $this->pathConexBD = $pathConexBD;
        $this->crm = $crm;
        $this->connect($extensiones);
    }

    public function getPrefixBD(){
        return $this->bdPrefix;
    }


    public function getDatosConexBD(){
        if($this->crm == "wp"){
            $palabraBuscada = ["define( 'DB_NAME',", "define( 'DB_USER',", "define( 'DB_PASSWORD',", "define( 'DB_HOST'", '$table_prefix = ' ];
        
            // Abre el archivo en modo lectura
            $archivoPuntero = fopen($this->pathConexBD, 'r');
            if ($archivoPuntero) {
                // Recorre el archivo línea por línea
                while (($linea = fgets($archivoPuntero)) !== false) {
                    // Verifica si la línea contiene la palabra buscada
                    foreach($palabraBuscada as $valor){
                        if (strpos($linea, $valor) !== false) {
                            // Imprime la línea completa
                            //Obtener versión y Quitar comillas, punto y coma, sustituirlo por espacio en blanco
                            if(strpos($linea, "=")){
                                array_push($this->datosConexBD, trim(str_replace(array('"', ";", "'"), "", explode("=",$linea)[1])));
                            }else if(strpos($linea, ",")){
                                array_push($this->datosConexBD, trim(str_replace(array('"', ")", "'", ";"), "", explode(",",$linea)[1])));
                            }
                        }
                    }
                }
                // Cierra el archivo
                fclose($archivoPuntero);
            } else {
                echo "<p>No se pudo abrir el archivo ".$this->pathConexBD." para obtener los datos de conexión a la base de datos</p>.";
            }
            $this->host = $this->datosConexBD[3];
            $this->username = $this->datosConexBD[1];
            $this->password = $this->datosConexBD[2];
            $this->database = $this->datosConexBD[0];
            $this->bdPrefix = $this->datosConexBD[4];

        }else if($this->crm == "pr"){
            $palabraBuscada = ["'database_name' => '", "'database_user' => '", "'database_password' => '","'database_host' => '", '\'database_prefix\' => \'' ];
        
            // Abre el archivo en modo lectura
            for($i=0; $i < count($this->pathConexBD); $i++){
                if(file_exists($this->pathConexBD[$i])){
                    $archivoPuntero = fopen($this->pathConexBD[$i], 'r');
                    if ($archivoPuntero) {
                        // Recorre el archivo línea por línea
                        while (($linea = fgets($archivoPuntero)) !== false) {
                            // Verifica si la línea contiene la palabra buscada
                            foreach($palabraBuscada as $valor){
                                if (strpos($linea, $valor) !== false) {
                                    // Imprime la línea completa
                                    //Obtener versión y Quitar comillas, punto y coma, sustituirlo por espacio en blanco
                                    if(strpos($linea, "=")){
                                        array_push($this->datosConexBD, trim(str_replace(array('"', ",", "'"), "", explode(">",$linea)[1])));
                                    }
                                }
                            }
                        }
                        // Cierra el archivo
                        fclose($archivoPuntero);
                    } else {
                        echo "<p>No se pudo abrir el archivo ".$this->pathConexBD[$i]." para obtener los datos de conexión a la base de datos</p>.";
                    }
                }else{
                    echo "<p>No se encontro el fichero . ".$this->pathConexBD[$i]. "</p>";
                }
            }
            $this->host = $this->datosConexBD[0];
            $this->username = $this->datosConexBD[1];
            $this->password = $this->datosConexBD[3];
            $this->database = $this->datosConexBD[2];
            $this->bdPrefix = $this->datosConexBD[4];
        }

        return $this->datosConexBD; 
    }

    private function connect($extensiones) {
        $this->getDatosConexBD();

        //Para versiones superiores a la 5.6
        if(array_search("nd_mysqli",$extensiones) || array_search("mysqli",$extensiones)){

                echo "<p>Datos conex a BD:</p>";
                echo "Usuario:". $this->username;
                echo "<br>";
                echo "Contraseña: ". $this->password;
                echo "<br>";
                echo "BD: ".$this->database;
                echo "<br>";
                echo "Host: ".$this->host;
                echo "<br>";
                echo "Prefijo: ".$this->bdPrefix;
                echo "<br>";
                $this->conex = mysqli_connect($this->host, $this->username, $this->password, $this->database);

                //$this->conex = mysqli_connect($this->host, $this->username,  $this->password, $this->database);
                //$enlace = mysqli_connect($this->datosConexBD[3], $this->datosConexBD[1], $this->datosConexBD[2], $this->datosConexBD[0]);

                 // Verificar si hubo algún error en la conexión
                if ($this->conex->connect_error) {
                    die("Error en la conexión a la base de datos: " . $this->conex->connect_error);
                }
/*
                if (!$this->conex) {
                    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
                    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
                    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;                    
                }else{
                    echo "<p>Éxito: Se ha conectado a la base de datos</p>";
                  
                }
                
                mysqli_close($conex);
                */
        }else if(array_search("mysql", $extensiones) || array_search("mysqlnd",$extensiones)){

        }
        

    }

    public function getConnection() {
        return $this->conex;
    }

    public function query($sql)
    {
        return $this->conex->query($sql);
    }


}

?>