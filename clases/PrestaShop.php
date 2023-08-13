<?php

    class PrestaShop extends Crm{
        public $crm = "pr";

        public function __construct($rutaInstalación, $modulosPr, $extra, $extensiones) {
            parent::setCRM($this->crm);
            parent::setPath("$rutaInstalación/app/AppKernel.php");
            parent::setErrorLog(["$rutaInstalación/error_log"]);
            parent::setPluginsWp($modulosPr);
            parent::setExtra($extra);
            parent::setPathTheme("$rutaInstalación/themes/");
            parent::getVersion();
            //parent::conexBD($extensiones);
        }

        public function setConexBD($conex){
            parent::setConex($conex);
        }


    }


?> 