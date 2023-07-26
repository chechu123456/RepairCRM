<?php
    require "Crm.php";

    class WordPress extends Crm{
        public $crm = "wp";

        public function __construct($rutaInstalación, $pluginsWp, $extra, $extensiones) {
            parent::setCRM($this->crm);
            parent::setPath("$rutaInstalación/wp-includes/version.php");
            parent::setPathConexBD("$rutaInstalación/wp-config.php");
            parent::setErrorLog(["$rutaInstalación/error_log", "$rutaInstalación/wp-admin/error_log"]);
            parent::setPluginsWp($pluginsWp);
            parent::setExtra($extra);
            parent::setPathTheme("$rutaInstalación/wp-content/themes/");
            parent::getVersion();
            parent::conexBD($extensiones);
        }


    }


?> 