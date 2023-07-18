<?php

    class Server{
        public $versionPhp;
        public $extensiones;
        public $extensionesRm74 = ["OPcache ", "mbstring", "memcached", "mysqli", "nd_mysqli", "json", "zip", "pdo", "pdo_mysql"];//Extensiones recomendadas > 7.4PHP 
        public $extensionesRm56 = ["apcu ", "mbstring", "memcached", "mysql", "mysqlnd", "json", "zip", "pdo", "pdo_mysql"]; //Extensiones recomendadas < 7.2PHP
        public $extensionesCoincidentes;
        public $extensionesDiferentes;
        public $memoryLimit;

        function __construct()
        {
            $this->versionPhp = phpversion();
            $this->extensiones = get_loaded_extensions();
            $this->memoryLimit = ini_get('memory_limit');
        }
        
        function extensionesCoincidentes($extensionesRmV)
        {
            $this->extensionesCoincidentes = array_intersect($this->$extensionesRmV,  $this->extensiones);
        /*
            foreach ($coincidencias as $value) {
                $value .= $value;
            }
        */
        }

        
        function extensionesDiferentes($extensionesRmV)
        {
            $this->extensionesDiferentes = array_diff($this->$extensionesRmV,  $this->extensiones);
        /*
            foreach ($coincidencias as $value) {
                $value .= $value;
            }
        */
        }

        function getExtensionesRecomendables($extensionesRmV){
            $this->extensionesCoincidentes($extensionesRmV);
            $this->extensionesDiferentes($extensionesRmV);

            if(array_search("mysqli",$this->extensionesCoincidentes) && array_search("nd_mysqli",$this->extensionesDiferentes)){
                $this->extensionesDiferentes = array_diff($this->extensionesDiferentes, array('nd_mysqli'));
            }

            if(array_search("nd_mysqli",$this->extensionesCoincidentes) && array_search("mysqli",$this->extensionesDiferentes)){
                $this->extensionesDiferentes = array_diff($this->extensionesDiferentes, array('mysqli'));
            }

            if(array_search("mysql",$this->extensionesCoincidentes) && array_search("mysqlnd",$this->extensionesDiferentes)){
                $this->extensionesDiferentes = array_diff($this->extensionesDiferentes, array('mysqlnd'));
            }

            if(array_search("mysqlnd",$this->extensionesCoincidentes) && array_search("mysql",$this->extensionesDiferentes)){
                $this->extensionesDiferentes = array_diff($this->extensionesDiferentes, array('mysql'));
            }   
            
            return $this->extensionesDiferentes;

        }

        function getConsumoCPU($usuario){
            //exec("top -b -n 1 -u $usuario | awk 'NR>7 { sum += $9; } END { print sum; }'", $output);
            //top -b -n 1 -u q264351 | awk 'NR>1 {print $9}'
            exec("top -b -n 1 -u $usuario | awk 'NR>1 {print $9}'", $output);
            $consumoCPU = [];
            $media =0;
            $numero = 90;

            for($i=5; $i<count($output);$i++){
                if (isset($output[$i])) {
                    $consumoCPU[] = (int)$output[$i];
                    $media += (int)$output[$i];
                }
            }

            $resultado = array_filter($consumoCPU, function ($valor) use ($numero) {
                if($valor > $numero){
                    usleep(250); //milisegundos
                    return  $valor > $numero;
                }
            });
            return $resultado;
            $media = $media/count($consumoCPU);
/*
            print_r($consumoCPU);
            echo "<br>";
            print_r($media);
*/
            //return $output;
            /*
                $pid = getmypid();
                exec("ps -o rss -p $pid", $output);
                return $output[1] * 1024 . "|". $pid;
                //return posix_times();
            */

            //Otra forma
                //return getrusage();

            //Otra forma
            /*
            $loads = sys_getloadavg();
            $core_nums = trim(shell_exec("grep -P '^processor' /proc/cpuinfo|wc -l"));
            $load = round($loads[0]/($core_nums + 1)*100, 2);
            return print_r($load). " -->". $core_nums;

*/
/*
            $load=array();
            if (stristr(PHP_OS, 'win')) 
            {
                $wmi = new COM("Winmgmts://");
                $server = $wmi->execquery("SELECT LoadPercentage FROM Win32_Processor");  
                $cpu_num = 0;
                $load_total = 0;
                foreach($server as $cpu)
                {
                    $cpu_num++;
                    $load_total += $cpu->loadpercentage;
                }
        
                $load[]= round($load_total/$cpu_num);
        
            } 
            else
            {
                $load = sys_getloadavg();
            }
            return $load;
*/
//Terminal 
//top -b -n 1 -u q264351 | awk 'NR>7 { sum += $9; } END { print sum; }'
        }

        function getConsumoRAM(){

            //return  'Memoria usada: ' . round(memory_get_usage() / 1024,1) . ' KB';
            //Pasar bytes a Mb
            $megabytes = memory_get_usage() / 1048576;
            exec("free -mtl", $output);
            print_r($output);

            return $megabytes;
            
            //return memory_get_peak_usage();
        }

        function getMemoryLimit(){

            return $this->memoryLimit;
            
        }



        function __toString()
        {
            return "Versión: $this->versionPhp ";
        }
    }


?>
