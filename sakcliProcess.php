<?php
    require("clases/Crm.php");
    require("clases/WordPress.php");

if(isset($_POST["crmOpcion"]) && $_POST["crmOpcion"] == "wordpress"){

    $ruta = explode("/", dirname(__FILE__));
    array_pop($ruta);
    $ruta = implode("/",$ruta);

    $wp = new WordPress($ruta, "", "", "");
    $version = trim($wp->getVersion());

    

    // Download the specified WordPress core version files.
    $url = "https://wordpress.org/wordpress-$version.zip";
    $file = "descargas/wordpress-$version.zip";

    if (file_exists($file)) {
        unlink($file);
    }

    $download = file_put_contents($file, file_get_contents($url));

    if ($download === false) {
        echo "Failed to download WordPress core files.";
    //die('Failed to download WordPress core files.');
    }

    // Unzip the WordPress core files.
    $zip = new ZipArchive();
    $res = $zip->open($file);

    if ($res === false) {
        echo "Failed to unzip WordPress core files.";

    //die('Failed to unzip WordPress core files.');
    }

    $zip->extractTo('descargas/');
    $zip->close();

    // Delete the downloaded WordPress core files.
    unlink($file);
/*
    // Rename the WordPress directory.
    rename('/path/to/wordpress', '/path/to/wordpress-old');

    // Create a new WordPress directory.
    mkdir('/path/to/wordpress');
*/
/*
    // Copy the specified WordPress core files to the new directory.
    copy('descargas/wordpress/wp-admin/', '../');
    copy('descargas/wordpress/wp-includes/', '../');
    copy('descargas/wordpress/wp-content/', '../');
*/
    
    $origen = "$ruta/rp/descargas/wordpress/*";
    $destino =  $ruta;

    //exec("xcopy $origen $destino /E /I");
    //exec("mv -f $origen $destino");
    exec("cp -R $origen $destino");

    echo "OK";

    exec("rm -R 'descargas'/*");


}else if(isset($_POST["crmOpcion"]) && $_POST["crmOpcion"] == "prestashop"){

    $ruta = explode("/", dirname(__FILE__));
    array_pop($ruta);
    $ruta = implode("/",$ruta);

    $pr = new PrestaShop($ruta, "", "", "");
    $version = trim($pr->getVersion());

    

    // Download the specified WordPress core version files.
    //https://github.com/PrestaShop/PrestaShop/releases/download/8.1.0/prestashop_8.1.0.zip
    //$url = "https://github.com/PrestaShop/prestashop/releases/download/";
    $url = "https://github.com/PrestaShop/PrestaShop/releases/download/$version/prestashop_$version.zip";
    $file = "descargas/prestashop-$version.zip";

    if (file_exists($file)) {
        unlink($file);
    }

    $download = file_put_contents($file, file_get_contents($url));

    if ($download === false) {
        echo "Failed to download WordPress core files.";
    //die('Failed to download WordPress core files.');
    }

    // Unzip the WordPress core files.
    $zip = new ZipArchive();
    $res = $zip->open($file);

    if ($res === false) {
        echo "Failed to unzip WordPress core files.";

    //die('Failed to unzip WordPress core files.');
    }

    $zip->extractTo('descargas/');
    $zip->close();

    // Delete the downloaded WordPress core files.
    unlink($file);
/*
    // Rename the WordPress directory.
    rename('/path/to/wordpress', '/path/to/wordpress-old');

    // Create a new WordPress directory.
    mkdir('/path/to/wordpress');
*/
/*
    // Copy the specified WordPress core files to the new directory.
    copy('descargas/wordpress/wp-admin/', '../');
    copy('descargas/wordpress/wp-includes/', '../');
    copy('descargas/wordpress/wp-content/', '../');
*/
    
    $origen = "$ruta/rp/descargas/wordpress/*";
    $destino =  $ruta;

    //exec("xcopy $origen $destino /E /I");
    //exec("mv -f $origen $destino");
    exec("cp -R $origen $destino");

    echo "OK";

    exec("rm -R 'descargas'/*");
}



?>