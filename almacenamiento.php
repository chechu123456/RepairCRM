<?php
function getRuta(){
	return explode("/", dirname(__FILE__));
}

function getRutaInstalacion(){
	$ruta = getRuta();
	array_pop($ruta);
	$ruta = implode("/",$ruta);
	return $ruta;
}

function getUser(){
	return getRuta()[2];
}
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
							<div class="row">
								<div class="col-xl-6 col-md-6">
									<div class="card table-card">
										<div class="card-header">
											<h5>Espacio ocupado en /home/<?=getUser()?></h5>
										</div>
										<div class="card-body px-0 py-0">
											<div class="table-responsive">
												<div class="session-scroll" style="height:750px;position:relative;">
													<table class="table table-hover m-b-0">

													<?php 
													exec("du -h --max-depth=1 /home/".getUser()." | sort -hr", $diskRaiz);
													
														//var_dump($diskRaiz);

														foreach($diskRaiz as $key) { 
															
															$key = preg_split("/(?<=[GMKB\s])(?!0[A-Za-z])/", $key,2);
														

															if(!empty($key)){
													?>
																<tbody>
																	<tr>
																		<td class="errorLogFilaTabla">
																			<span class="diskIzq"><?=$key[0]?></span>
																			<span class="diskDer"><?=$key[1];?></span>
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
								<div class="col-xl-6 col-md-6">
									<div class="card table-card">
										<div class="card-header">
											<h5>Espacio ocupado en <?=getRutaInstalacion()?></h5>
										</div>
										<div class="card-body px-0 py-0">
											<div class="table-responsive">
												<div class="session-scroll" style="height:auto;position:relative;">
													<table class="table table-hover m-b-0">

													<?php 
													exec("du -h --max-depth=1 ".getRutaInstalacion()." | sort -hr", $diskPathCMS);

														foreach($diskPathCMS as $key) { 
															$key = preg_split("/(?<=[GMKB\s])(?!0[A-Za-z])/", $key,2);

															if(!empty($key)){
													?>
																<tbody>
																	<tr>
																		<td class="errorLogFilaTabla">
																			<span class="diskIzq"><?=$key[0];?></span>
																			<span class="diskDer"><?=$key[1];?></span>
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
							</div>
							<!-- [ Main Content ] end -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ Main Content ] end -->
<?php	
	
	if(file_exists(getRutaInstalacion()."/wp-content/")){
			
?>

	<div class="pcoded-main-container">
		<div class="pcoded-wrapper">
			<div class="pcoded-content">
				<div class="pcoded-inner-content">
					<div class="main-body">
						<div class="page-wrapper">
							<div class="row">
								<div class="col-xl-6 col-md-6">
									<div class="card table-card">
										<?php	
											if(file_exists(getRutaInstalacion()."/wp-content/")){
												
										?>
												<div class="card-header">
													<h5>Espacio ocupado en <?=getRutaInstalacion()."/wp-content/";?></h5>
												</div>
										<?php
											}
										?>
										<div class="card-body px-0 py-0">
											<div class="table-responsive">
												<div class="session-scroll" style="height:650px;position:relative;">
													<table class="table table-hover m-b-0">

													<?php 
													
													exec("du -h --max-depth=1 ".getRutaInstalacion()."/wp-content/ | sort -hr", $diskWpContent);
													
														//var_dump($diskRaiz);

														foreach($diskWpContent as $key) { 
															
															$key = preg_split("/(?<=[GMKB\s])(?!0[A-Za-z])/", $key,2);
														

															if(!empty($key)){
													?>
																<tbody>
																	<tr>
																		<td class="errorLogFilaTabla">
																			<span class="diskIzq"><?=$key[0]?></span>
																			<span class="diskDer"><?=$key[1];?></span>
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
								<div class="col-xl-6 col-md-6">
								<div class="card table-card">
										<?php	
											if(file_exists(getRutaInstalacion()."/wp-content/uploads/")){
												
										?>
												<div class="card-header">
													<h5>Espacio ocupado en <?=getRutaInstalacion()."/wp-content/uploads/";?></h5>
												</div>
										<?php
											}
										?>
										<div class="card-body px-0 py-0">
											<div class="table-responsive">
												<div class="session-scroll" style="height:650px;position:relative;">
													<table class="table table-hover m-b-0">

													<?php 
													
													exec("du -h --max-depth=1 ".getRutaInstalacion()."/wp-content/uploads/ | sort -hr", $diskWpUploads);
													
														//var_dump($diskRaiz);

														foreach($diskWpUploads as $key) { 
															
															$key = preg_split("/(?<=[GMKB\s])(?!0[A-Za-z])/", $key,2);
														

															if(!empty($key)){
													?>
																<tbody>
																	<tr>
																		<td class="errorLogFilaTabla">
																			<span class="diskIzq"><?=$key[0]?></span>
																			<span class="diskDer"><?=$key[1];?></span>
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
							</div>
							<!-- [ Main Content ] end -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php	
	}else if(file_exists(getRutaInstalacion()."/img/")){
			
		?>
		
			<div class="pcoded-main-container">
				<div class="pcoded-wrapper">
					<div class="pcoded-content">
						<div class="pcoded-inner-content">
							<div class="main-body">
								<div class="page-wrapper">
									<div class="row">
										<div class="col-xl-6 col-md-6">
											<div class="card table-card">
												<?php	
													if(file_exists(getRutaInstalacion()."/img/")){
														
												?>
														<div class="card-header">
															<h5>Espacio ocupado en <?=getRutaInstalacion()."/img/";?></h5>
														</div>
												<?php
													}
												?>
												<div class="card-body px-0 py-0">
													<div class="table-responsive">
														<div class="session-scroll" style="height:650px;position:relative;">
															<table class="table table-hover m-b-0">
		
															<?php 
															
															exec("du -h --max-depth=1 ".getRutaInstalacion()."/img/ | sort -hr", $diskWpContent);
															
																//var_dump($diskRaiz);
		
																foreach($diskWpContent as $key) { 
																	
																	$key = preg_split("/(?<=[GMKB\s])(?!0[A-Za-z])/", $key,2);
																
		
																	if(!empty($key)){
															?>
																		<tbody>
																			<tr>
																				<td class="errorLogFilaTabla">
																					<span class="diskIzq"><?=$key[0]?></span>
																					<span class="diskDer"><?=$key[1];?></span>
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
										<div class="col-xl-6 col-md-6">
										<div class="card table-card">
												<?php	
													if(file_exists(getRutaInstalacion()."/modules/")){
														
												?>
														<div class="card-header">
															<h5>Espacio ocupado en <?=getRutaInstalacion()."/modules/";?></h5>
														</div>
												<?php
													}
												?>
												<div class="card-body px-0 py-0">
													<div class="table-responsive">
														<div class="session-scroll" style="height:650px;position:relative;">
															<table class="table table-hover m-b-0">
		
															<?php 
															
															exec("du -h --max-depth=1 ".getRutaInstalacion()."/modules/ | sort -hr", $diskWpUploads);
															
																//var_dump($diskRaiz);
		
																foreach($diskWpUploads as $key) { 
																	
																	$key = preg_split("/(?<=[GMKB\s])(?!0[A-Za-z])/", $key,2);
																
		
																	if(!empty($key)){
															?>
																		<tbody>
																			<tr>
																				<td class="errorLogFilaTabla">
																					<span class="diskIzq"><?=$key[0]?></span>
																					<span class="diskDer"><?=$key[1];?></span>
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
									</div>
									<!-- [ Main Content ] end -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<?php
	}	
?>

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