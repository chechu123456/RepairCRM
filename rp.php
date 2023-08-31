<?php
    require("clases/Server.php");
    require("clases/Crm.php");
    require("clases/WordPress.php");
    require("clases/PrestaShop.php");
    require("clases/Fichero.php");
    require("clases/CapturaPantalla.php");
    require_once("clases/ConexionBd.php");


    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    
	<title>Fix CMS</title>
	<!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 11]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="Flash Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
	<meta name="keywords"
		content="admin templates, bootstrap admin templates, bootstrap 4, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, Flash Able, Flash Able bootstrap admin template">
	<meta name="author" content="Codedthemes" />

	<!-- Favicon icon -->
	<link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
	<!-- fontawesome icon -->
	<script src="https://kit.fontawesome.com/299d0a42cf.js" crossorigin="anonymous"></script>


	<!-- animation css -->
	<link rel="stylesheet" href="assets/plugins/animation/css/animate.min.css">

	<!-- vendor css -->
	<link rel="stylesheet" href="assets/css/style.css">

    <!-- JQUERY -->
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js?ver=1.4'></script>

</head>
<body>
    
<?php
    $errores = array();
    $datos = array();

	if(empty($_POST)){
		header("Location: ./index.php");
	}

    if( isset($_POST['crmOpcion']) &&  isset($_POST['url']) ){
    
        $crmOpcion = $_POST['crmOpcion'];
        $url = $_POST['url'];

        $valoresExtra = array();

        $extensiones = funcionesServer(getUser());
    //echo "<br>". print_r($_POST). " <br>";
        if(isset($_POST['pluginsWp']) ){
            $pluginsWp = $_POST['pluginsWp'];
        }

        if(isset($_POST['modulosPr'])){
            $modulosPr = $_POST['modulosPr'];
        }


        if(isset($_POST['extra'])){
            foreach ($_POST['extra'] as $extra) {
                array_push($valoresExtra, $extra);
            }
        }else{
            $errores["opcExtra"] = "<p>No hay ningún extra seleccionados</p>";
        }



        if( $crmOpcion === "prestashop" && isset($_POST['modulosPr'])){
            funcionesPrestaShop(getRutaInstalacion(), $modulosPr, $valoresExtra, $url, $extensiones);

        }else if($crmOpcion === "wordpress" && isset($_POST['pluginsWp']) ){

            funcionesWordPress(getRutaInstalacion(), $pluginsWp, $valoresExtra, $url, $extensiones);
            

        }else{
            $errores["opcCMS"] = "<p>No se ha seleccionado una opción dentro del CMS escogido</p>";
        }

    }else{
        $errores["getCMS"] = "<p>No se han recibido parámetros. Elige el CMS y alguna de las opciones sobre plugins o módulos</p>";
    }
     

    function getRuta(){
        return explode("/", dirname(__FILE__));
    }

    function getUser(){
        return getRuta()[2];
    }

    function getRutaInstalacion(){
        $ruta = getRuta();
        array_pop($ruta);
        $ruta = implode("/",$ruta);
        return $ruta;
    }

    function funcionesServer($usuario){
        global $datos;

        $server = new Server();

        if($server->versionPhp<7.4){
            $extensionesRm = "extensionesRm56";
        }else if($server->versionPhp >= 7.4){
            $extensionesRm = "extensionesRm74";
        }
        
    //echo $server->__toString();
    
    //print_r($server->getConsumoCPU());
    //echo "<br>";
    //print_r($server->getConsumoRAM());
        $datos["versionPHP"] =  $server->getVersionPHP();
        $datos["memoryLimitPHP"] = $server->getMemoryLimit();
    //print_r($server->getConsumoCPU($usuario));
    //echo "<br> Extensiones faltantes recomendables: ";
        $datos["extensionesPhpRecomendables"] = $server->getExtensionesRecomendables($extensionesRm);

        return $server->extensiones;
    }
  
    function funcionesWordPress($rutaInstalación, $pluginsWp, $extra, $url, $extensiones){
        global $datos;

        //Inicializar objeto WordPress (Realiza operaciones en el padre - Clase CRM)
        $wp = new WordPress($rutaInstalación, $pluginsWp, $extra, $extensiones);

        //Crear la instancia para realizar la conexion a la bd
        $pathConexBD ="$rutaInstalación/wp-config.php";
        $conexionBd = new ConexionBd( $extensiones, $pathConexBD, "wp");

        //Obtener prefijo bd
        $bdPrefix = $conexionBd->getPrefixBD();

		//Obtener datos conexión
		$datos["datosConexion"] = $conexionBd->getDatosConexion();
        
        //Pasar la instancia para poder hacer consultas a la bd
        $wp->setConex($conexionBd);

        
        $wp->checkTheme($bdPrefix);
    //echo "<br>---------------------";
        
        $datos["versionCMS"] = $wp->version;
        //var_dump($wp->getPluginsThemeFailed());
    
        //$fichero = new CapturaPantalla($url);


        $fichero = new Fichero("../wp-content/plugins/", $url);
    //echo "<p>Handlers PHP detectados:</p>";
        $datos["handlersPHP"] = array($fichero->handlerPHP(getRutaInstalacion()));
        //$pluginsWp --> onALLpluigns, offALLplugins, offErrorPlugins
        
        if(array_search("cache", $extra)){
            $fichero->obtenerCarpetasDirectorio($pluginsWp, $datos["pluginsThemeFailed"] = $wp->getPluginsThemeFailed(), $cache = true);
        }else{
            $fichero->obtenerCarpetasDirectorio($pluginsWp,  $datos["pluginsThemeFailed"] = $wp->getPluginsThemeFailed(), $cache = false);
        }

		$datos["estadosWeb"] = $fichero->getResultCrearPag();


		$datos["checkThemeVar"] = $wp->getCheckThemeVar();
		$datos["getErrorLogTable"] = $wp->getErrorLogTable();
        //MostrarErroLog
        aplicarExtrasWP($wp,$extra);
        //Otros extras
        aplicarExtrasFichero($fichero,$extra);
		
    
    }

    function funcionesPrestaShop($rutaInstalación, $modulosPr, $extra, $url, $extensiones){
        global $datos;

        //Inicializar objeto WordPress (Realiza operaciones en el padre - Clase CRM)
        $pr = new PrestaShop($rutaInstalación, $modulosPr, $extra, $extensiones);

        //Crear la instancia para realizar la conexion a la bd
        $pathConexBD =["$rutaInstalación/config/parameters.php", "$rutaInstalación/app/config/parameters.php"];
        $conexionBd = new ConexionBd( $extensiones, $pathConexBD, "pr");

        //Obtener prefijo bd
        $bdPrefix = $conexionBd->getPrefixBD();
        
        //Pasar la instancia para poder hacer consultas a la bd
        $pr->setConex($conexionBd);

        
        $pr->checkTheme($bdPrefix);
    //echo "<br>---------------------";
        $datos["versionCMS"] = $pr->version;
        //var_dump($wp->getPluginsThemeFailed());
    
        //$fichero = new CapturaPantalla($url);


        $fichero = new Fichero("../modules/", $url);
    //echo "<p>Handlers PHP detectados:</p>";
        $datos["handlersPHP"] =$fichero->handlerPHP(getRutaInstalacion());
        //$pluginsWp --> onALLpluigns, offALLplugins, offErrorPlugins
        
        if(array_search("cache", $extra)){
            $fichero->obtenerCarpetasDirectorio($modulosPr, $pr->getPluginsThemeFailed(), $cache = true);
        }else{
            $fichero->obtenerCarpetasDirectorio($modulosPr, $pr->getPluginsThemeFailed(), $cache = false);
        }

		$datos["checkThemeVar"] = $pr->getCheckThemeVar();
		$datos["getErrorLogTable"] = $pr->getErrorLogTable();


        //MostrarErroLog
        aplicarExtrasWP($pr,$extra);
        //Otros extras
        aplicarExtrasFichero($fichero,$extra);
    
    }

    function aplicarExtrasWP($obj, $extra){
        global $datos;


        if(array_search("theme", $extra)){
    //echo "<p>Tema instalado actualmente:</p>";
    //echo var_export($obj->datosConexBD);
            $datos["datosConexBD"] = var_export($obj->datosConexBD); 
        }

         
        if(array_search("mostrarErrorLog", $extra)){
    //echo "<p>Error Log:</p>";
    //echo var_export($obj->errorLogRaiz,true);
            $datos["errorLog"] = var_export($obj->errorLogRaiz,true);
        }
                 
        if(array_search("eliminarErrorLog", $extra)){
            $obj->rmErrorLog();
        }

        if(array_search("renombrarErrorLog", $extra)){
            $obj->renameErrorLog();
        }

    }

    
    function aplicarExtrasFichero($obj, $extra){
        global $datos;

        if(array_search("emptyFiles", $extra) !== false && $extra[0] == "emptyFiles" ){
    //echo "<p>Ficheros vacíos:</p>";
            $datos["ficherosVacios"] = $obj->ficheros_vacios(getRutaInstalacion());
            $datos["numFicherosVacios"] = $obj->num_ficheros_vacios();
        }

       
    }


?>
<!--
<embed src="pruebas.html"width="100%" height="600px" onerror="alert('URL invalid !!');" />
-->



    <!-- [ Pre-loader ] start -->
	<div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
	<!-- [ Pre-loader ] End -->

	<!-- [ navigation menu ] start -->
	<nav class="pcoded-navbar menupos-fixed menu-light brand-blue ">
		<div class="navbar-wrapper ">
			<div class="navbar-brand header-logo">
				<a href="index.php" class="b-brand">
					<img src="assets/images/logo-icon.svg" alt="" class="logo images">
					<h3 class="titleFixCMS logo images">Fix CMS</h3>
				</a>
				<a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
			</div>
			<div class="navbar-content scroll-div">
				<ul class="nav pcoded-inner-navbar">
					<li class="nav-item pcoded-menu-caption">
						<label>Navigation</label>
					</li>
					<li class="nav-item">
						<a href="index.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
					</li>
					<li class="nav-item pcoded-menu-caption">
						<label>Herramientas</label>
					</li>
					<li class="nav-item">
						<a href="wordpress.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">WordPress</span></a>
					</li>
					<li class="nav-item">
						<a href="prestashop.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">PrestaShop</span></a>
					</li>
					<li class="nav-item">
						<a href="cambiarTema.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Cambiar Tema</span></a>
					</li>
					<li class="nav-item pcoded-menu-caption">
						<label>Reinstalar Core</label>
					</li>
					<li class="nav-item">
						<a href="cambiarTema.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Sak-cli Replace</span></a>
					</li>
					<li class="nav-item pcoded-menu-caption">
						<label>Extras</label>
					</li>
					<li class="nav-item">
						<a href="cambiarTema.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Reparar DB WP </span></a>
					</li>
					<li class="nav-item">
						<a href="almacenamiento.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Almacenamiento </span></a>
					</li>
					
				</ul>					
			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->

	<!-- [ Header ] start -->
	<header class="navbar pcoded-header navbar-expand-lg navbar-light headerpos-fixed">
		<div class="m-header">
			<a class="mobile-menu" id="mobile-collapse1" href="#!"><span></span></a>
			<a href="index.html" class="b-brand">
				<img src="assets/images/logo.svg" alt="" class="logo images">
				<img src="assets/images/logo-icon.svg" alt="" class="logo-thumb images">
			</a>
		</div>
		<a class="mobile-menu" id="mobile-header" href="#!">
			<i class="feather icon-more-horizontal"></i>
		</a>
		<div class="collapse navbar-collapse">
			<a href="#!" class="mob-toggler"></a>
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<div class="main-search open">
						<div class="input-group">
							<input type="text" id="m-search" class="form-control" placeholder="Search . . .">
							<a href="#!" class="input-group-append search-close">
								<i class="feather icon-x input-group-text"></i>
							</a>
							<span class="input-group-append search-btn btn btn-primary">
								<i class="feather icon-search input-group-text"></i>
							</span>
						</div>
					</div>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li>
					<div class="dropdown">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon feather icon-bell"></i></a>
						<div class="dropdown-menu dropdown-menu-right notification">
							<div class="noti-head">
								<h6 class="d-inline-block m-b-0">Notifications</h6>
								<div class="float-right">
									<a href="#!" class="m-r-10">mark as read</a>
									<a href="#!">clear all</a>
								</div>
							</div>
							<ul class="noti-body">
								<li class="n-title">
									<p class="m-b-0">NEW</p>
								</li>
								<li class="notification">
									<div class="media">
										<img class="img-radius" src="assets/images/user/avatar-1.jpg" alt="Generic placeholder image">
										<div class="media-body">
											<p><strong>John Doe</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>5 min</span></p>
											<p>New ticket Added</p>
										</div>
									</div>
								</li>
								<li class="n-title">
									<p class="m-b-0">EARLIER</p>
								</li>
								<li class="notification">
									<div class="media">
										<img class="img-radius" src="assets/images/user/avatar-2.jpg" alt="Generic placeholder image">
										<div class="media-body">
											<p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>10 min</span></p>
											<p>Prchace New Theme and make payment</p>
										</div>
									</div>
								</li>
								<li class="notification">
									<div class="media">
										<img class="img-radius" src="assets/images/user/avatar-3.jpg" alt="Generic placeholder image">
										<div class="media-body">
											<p><strong>Sara Soudein</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>12 min</span></p>
											<p>currently login</p>
										</div>
									</div>
								</li>
								<li class="notification">
									<div class="media">
										<img class="img-radius" src="assets/images/user/avatar-1.jpg" alt="Generic placeholder image">
										<div class="media-body">
											<p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>30 min</span></p>
											<p>Prchace New Theme and make payment</p>
										</div>
									</div>
								</li>
								<li class="notification">
									<div class="media">
										<img class="img-radius" src="assets/images/user/avatar-3.jpg" alt="Generic placeholder image">
										<div class="media-body">
											<p><strong>Sara Soudein</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>1 hour</span></p>
											<p>currently login</p>
										</div>
									</div>
								</li>
								<li class="notification">
									<div class="media">
										<img class="img-radius" src="assets/images/user/avatar-1.jpg" alt="Generic placeholder image">
										<div class="media-body">
											<p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>2 hour</span></p>
											<p>Prchace New Theme and make payment</p>
										</div>
									</div>
								</li>
							</ul>
							<div class="noti-footer">
								<a href="#!">show all</a>
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="dropdown drp-user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon feather icon-settings"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right profile-notification">
							<div class="pro-head">
								<img src="assets/images/user/avatar-1.jpg" class="img-radius" alt="User-Profile-Image">
								<span>John Doe</span>
								<a href="auth-signin.html" class="dud-logout" title="Logout">
									<i class="feather icon-log-out"></i>
								</a>
							</div>
							<ul class="pro-body">
								<li><a href="#!" class="dropdown-item"><i class="feather icon-settings"></i> Settings</a></li>
								<li><a href="#!" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>
								<li><a href="message.html" class="dropdown-item"><i class="feather icon-mail"></i> My Messages</a></li>
								<li><a href="auth-signin.html" class="dropdown-item"><i class="feather icon-lock"></i> Lock Screen</a></li>
							</ul>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</header>
	<!-- [ Header ] end -->

	<!-- [ Main Content ] start -->
	<div class="pcoded-main-container">
		<div class="pcoded-wrapper">
			<div class="pcoded-content">
				<div class="pcoded-inner-content">
					<div class="main-body">
						<div class="page-wrapper">
							<!-- [ breadcrumb ] start -->
							<div class="page-header">
								<div class="page-block">
									<div class="row align-items-center">
										<div class="col-md-12">
											<div class="page-header-title titleExtremos">
												<h5>Home</h5>
												<?php
													if(isset($_POST["pluginsWp"])){
														if($_POST["pluginsWp"] == "onAllInfo" || $_POST["pluginsWp"] == "onAllHTTP"){
														?>	
															<button id="btnEstadosMostrar" class="btn btn-info activo">Mostrar Estados</button>
															<button id="btnEstadosOcultar" class="btn btn-info desactivar">Ocultar Estados</button>
														<?php
														}
													}
												?>
											</div>
											<ul class="breadcrumb">
												<li class="breadcrumb-item"><a href="index.php"><i class="feather icon-home"></i></a></li>
												<li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
											</ul>
										
										</div>
									</div>
								</div>
							</div>
							<!-- [ breadcrumb ] end -->
							
							<?php 
								if(!empty($datos["estadosWeb"])){
							?>

								<div id="capturasEstados" class="desactivar">
									<?php 
										echo $datos["estadosWeb"];
									?>

								</div>
							<?php
								}
							?>

							<?php
								if(isset($_POST["pluginsWp"])){
									if($_POST["pluginsWp"] == "onAllInfo" || $_POST["pluginsWp"] == "onAllHTTP"){
							?>	
									<div class="btnOcultar2">
										<button id="btnEstadosOcultar2" class="btn btn-info desactivar">Ocultar Estados</button>
									</div>
							<?php
									}
								}
							?>

							<!-- [ Main Content ] start -->
							<div class="row">

								<!-- product profit start -->
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-red">
										<div class="card-body">
											<div class="row align-items-center m-b-25">												
												<div class="col-auto">
													<i class="fa-brands fa-wordpress text-c-red f-18"></i>
												</div>
												<div class="col">
													<h3 class="m-b-0 text-white alignRight"><?=$datos['versionCMS']?></h3>
												</div>
											</div>
											<p class="m-b-0 text-white text-center"><span class="label label-danger m-r-10">Versión <?=$crmOpcion?></span></p>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-blue">
										<div class="card-body">
											<div class="row align-items-center m-b-25">												
												<div class="col-auto">
													<i class="fa-brands fa-php text-c-blue f-18"></i>
												</div>
												<div class="col">
													<h3 class="m-b-0 text-white alignRight"><?=$datos['versionPHP']?></h3>
												</div>
											</div>
											<p class="m-b-0 text-white text-center"><span class="label label-primary m-r-10">Versión PHP</span></p>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-green">
										<div class="card-body">
											<div class="row align-items-center m-b-25">												
												<div class="col-auto">
													<i class="fa-solid fa-memory text-c-green f-18"></i>
												</div>
												<div class="col">
													<h3 class="m-b-0 text-white alignRight"><?=$datos['memoryLimitPHP']?></h3>
												</div>
											</div>
											<p class="m-b-0 text-white text-center"><span class="label label-success m-r-10">Memory_limit</span></p>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-md-6">
									<div class="card prod-p-card bg-c-yellow">
										<div class="card-body">
											<div class="row align-items-center m-b-25">												
												<div class="col-auto">
													<i class="fa-regular fa-file text-c-yellow f-18"></i>
												</div>
												<div class="col">
													<h3 class="m-b-0 text-white alignRight"><?=$datos['numFicherosVacios']?></h3>
												</div>
											</div>
											<p class="m-b-0 text-white text-center"><span class="label label-warning m-r-10">Ficheros Vacíos</span></p>
										</div>
									</div>
								</div>
								<!-- product profit end -->
							</div>
	
							<div class="row">

								<!-- sessions-section start -->
								<div class="col-xl-8 col-md-6">
									<div class="card table-card">
										<div class="card-header">
											<h5>Error logs</h5>
										</div>
										<div class="card-body px-0 py-0">
											<div class="table-responsive">
												<div class="session-scroll" style="height:478px;position:relative;">
													<table class="table table-hover m-b-0">

														<?php 
														
															foreach($datos["getErrorLogTable"] as $key=>$array) { 
																if(!empty($array)){
														?>
																<thead>
																	<tr>
																		<th><span ><?=$key?></span></th>																
																	</tr>
																</thead>
											
																<tbody>
																	<?php
																	foreach($array as $value){
																	?>
																		<tr>
																			<td class="errorLogFilaTabla">
																				<?if(!empty($value)){echo $value;}?>
																			</td>
																		</tr>																
																</tbody>
														<?php
																	}
																}

															}
															
														?>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- sessions-section end -->
								<div class="col-md-6 col-xl-4">
									<div class="card card-social">
										<div class="card-block border-bottom">
											<div class="row align-items-center justify-content-center">
												<div class="col text-right">
													<h5 class="text-c-red mb-0"> <span class="text-muted"><?=$datos["checkThemeVar"]["tema"];?></span></h5>
													<p class="text-c-red mb-0"> <span class="text-muted"><?=$datos["checkThemeVar"]["respuesta"];?></span></p>
												</div>
											</div>
										</div>
										<div class="card-block">
											<div class="row align-items-center justify-content-center card-active">
												<div class="col-6">
													<h6 class="text-center m-b-10"><span class="text-muted m-r-5"></span>Tema instalado</h6>
												</div>
											</div>
										</div>
									</div>
									<div class="card card-social">
										<div class="card-block border-bottom">
											<div class="row align-items-center justify-content-center">

												<div class="col text-right">
													<?php 
													foreach($datos["handlersPHP"] as $key=>$array) { 
														foreach($array as $value)?>
														<h5 class="text-c-red mb-0"> <span class="text-muted"><?=$value;?></span></h5>
													<?php
														}
													?>
												</div>
											</div>
										</div>
										<div class="card-block">
											<div class="row align-items-center justify-content-center card-active">
												<h6>Handlers encontrados</h6>
											</div>
										</div>
									</div>
									<div class="card card-social">
										<div class="card-block border-bottom">
											<div class="row align-items-center justify-content-center">

												<div class="col text-right">
													<?php 
													foreach($datos["pluginsThemeFailed"] as $key=>$array) { 
													?>
														<h5 class="text-c-red mb-0"> <span class="text-muted"><?=$array . " ";?></span></h5>
													<?php
														}
														
												?>
												</div>
											</div>
										</div>
										<div class="card-block">
											<div class="row align-items-center justify-content-center card-active">
												<h6>Fallos detectados (Plugins o temas)</h6>
											</div>
										</div>
									</div>
								</div>
								
							</div>
							<div class="row">

								<div class="col-xl-8 col-md-6">
									<div class="card table-card">
										<div class="card-header">
											<h5>Ficheros Vacíos PHP</h5>
										</div>
										<div class="card-body px-0 py-0">
											<div class="table-responsive">
												<div class="session-scroll" style="height:478px;position:relative;">
													<table class="table table-hover m-b-0">

													<?php 
														foreach($datos["ficherosVacios"] as $key) { 
															if(!empty($key)){
													?>
																<tbody>
																	<tr>
																		<td class="errorLogFilaTabla">
																			<?=$key;?>
																		</td>
																	</tr>																
																</tbody>
													<?php
															}

														}
														
													?>
													</table>
												</div>
											</div>
										</div>
										
									</div>

								</div>
								<div class="col-md-6 col-xl-4">
									<div class="card card-social">
										<div class="card-block border-bottom">
											<div class="row align-items-center justify-content-center">
												<div class="col text-right">
													<?php 
													foreach($datos["datosConexion"] as $key=>$valor) { 
													?>
														<h5 class="text-muted mb-0"> <?=$key.": "?><span class="mb-0 valorBD"><?=$valor;?></span></h5>
													<?php
														}
													?>
												</div>
											</div>
										</div>
										<div class="card-block">
											<div class="row align-items-center justify-content-center card-active">
												<div class="col-6">
													<h6 class="text-center m-b-10"><span class="text-muted m-r-5"></span>Datos de la base de datos</h6>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- [ Main Content ] end -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ Main Content ] end -->

	<!-- Warning Section start -->
	<!-- Older IE warning message -->
	<!--[if lt IE 11]>
        <div class="ie-warning">
            <h1>Warning!!</h1>
            <p>You are using an outdated version of Internet Explorer, please upgrade
               <br/>to any of the following web browsers to access this website.
            </p>
            <div class="iew-container">
                <ul class="iew-download">
                    <li>
                        <a href="http://www.google.com/chrome/">
                            <img src="assets/images/browser/chrome.png" alt="Chrome">
                            <div>Chrome</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.mozilla.org/en-US/firefox/new/">
                            <img src="assets/images/browser/firefox.png" alt="Firefox">
                            <div>Firefox</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://www.opera.com">
                            <img src="assets/images/browser/opera.png" alt="Opera">
                            <div>Opera</div>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.apple.com/safari/">
                            <img src="assets/images/browser/safari.png" alt="Safari">
                            <div>Safari</div>
                        </a>
                    </li>
                    <li>
                        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                            <img src="assets/images/browser/ie.png" alt="">
                            <div>IE (11 & above)</div>
                        </a>
                    </li>
                </ul>
            </div>
            <p>Sorry for the inconvenience!</p>
        </div>
    <![endif]-->
	<!-- Warning Section Ends -->

	<!-- Required Js -->
	<script src="assets/js/vendor-all.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/pcoded.min.js"></script>
	
	<script>
		$("#btnEstadosMostrar").on("click", function(e){
			$(this).toggleClass('activar').toggleClass('desactivar');
			$("#capturasEstados").toggleClass('activar').toggleClass('desactivar');
			$("#btnEstadosOcultar, #btnEstadosOcultar2").toggleClass('desactivar').toggleClass('activar');
		});

		$("#btnEstadosOcultar").on("click", function(e){
			$(this).toggleClass('desactivar').toggleClass('activar');
			$("#btnEstadosOcultar2").toggleClass('desactivar').toggleClass('activar');

			$("#capturasEstados").toggleClass('desactivar').toggleClass('activar');
			$("#btnEstadosMostrar").toggleClass('activar').toggleClass('desactivar');
		});

		$("#btnEstadosOcultar2").on("click", function(e){
			$(this).toggleClass('desactivar').toggleClass('activar');
			$("#btnEstadosOcultar").toggleClass('desactivar').toggleClass('activar');

			$("#capturasEstados").toggleClass('desactivar').toggleClass('activar');
			$("#btnEstadosMostrar").toggleClass('activar').toggleClass('desactivar');
		});
	</script>

</body>
</html>
