<?php
    class CapturaPantalla extends Fichero{
        public $url;
        public $nombFicheros = array();

        function __construct($url){
            $this->url = $url;
        }   


        function capturar(){


            //Declaramos la Url enviada desde un formulario
            $URLpagina = "".$this->url."";

            
            //Llamamos a Google PageSpeed Insights API
            $PagespeedDataGoogle = file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$URLpagina&screenshot=true");
            //Para móviles
            $PagespeedDataGoogle = file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$URLpagina&screenshot=true&strategy=mobile");

            //Decodificar datos con JSON
            $PagespeedDataGoogle = json_decode($PagespeedDataGoogle, true);
            echo $PagespeedDataGoogle['lighthouseResult']['audits']['full-page-screenshot']['details']['screenshot']['data'];
            
            //La imagen de la captura de pantall
            
            $captura = $PagespeedDataGoogle['lighthouseResult']['audits']['full-page-screenshot']['details']['screenshot']['data'];

            $captura = str_replace(array('_','-'),array('/','+'),$captura); 
            
            //Mostramos en el navegador la captura de pantalla
            echo "<center><img width='50%' height='50%' src='$captura' /></center>";

            
        }
/*
        function base64_to_jpeg( $base64_string, $output_file ) {
            $ifp = fopen( $output_file, "wb" ); 
            fwrite( $ifp, base64_decode( $base64_string) ); 
            fclose( $ifp ); 
            return( $output_file ); 
        }
        */

        function capturarPDFcrowdHTML($url){
            
        
            try{
                // create the API client instance
                $client = new \Pdfcrowd\HtmlToImageClient("demo", "ce544b6ea52a5621fb9d55f8b542d14d");

                // configure the conversion
                $client->setOutputFormat("jpg");
                $client->setCustomJavascript("libPdfcrowd.removeZIndexHigherThan({zlimit: 90});");

                // run the conversion and write the result to a file
                $client->convertUrlToFile($url, "result2.jpg");
            }
            catch(\Pdfcrowd\Error $why)
            {
                // report the error
                error_log("Pdfcrowd Error: {$why}\n");

                // rethrow or handle the exception
                throw $why;
            }

        }

        

    }
?>