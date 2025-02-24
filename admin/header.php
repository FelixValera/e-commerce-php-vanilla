<!DOCTYPE html>
<html>
	<head>
		<title>ComercioIT | Tu E-Shop en PHP</title>
		<base href="http://wxylokxy.micerino.urltemporal.com/admin/"/>  <!-- no olvidar colocar la barra (/) al finalizar la ruta si no la etiqueta <base> no funciona !-->
		<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
		<!--theme-style-->
		<link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />	
		<!--//theme-style-->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<!--fonts-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
		<!--//fonts-->
		<script src="../js/jquery.min.js"></script>
		<!--script-->
	</head>

	<body>
		<!--header-->
		<div class="header">

			<div class="bottom-header">
				<div class="container">
					<div class="header-bottom-left">
						<div class="logo"><a href="./?page=panel">PANEL</a></div>
						<?php
						// Notifica todos los errores excepto los errores de noticia 
						error_reporting(E_ALL ^ E_NOTICE);
						session_start();
						if(isset($_SESSION['usuario'])){

							$nombre=$_SESSION['usuario']['nombre'];
							$apellido=$_SESSION['usuario']['apellido'];
							?>
							<br>
							<p class="latest-product" style="color:white;">BIENVENIDO: <?=$nombre." ".$apellido?></p>
							<?php
						}
						?>
						<!--div class="search">
							<input type="text" name="q">
							<input type="submit" value="BUSCAR">
						</div-->
						<div class="clearfix"></div>
					</div>
					<div class="header-bottom-right">					
						<!--div class="account">
							<a href="ingreso.html"><span></span> TU CUENTA</a>
						</div-->
						<ul class="login">
							<li><a href="./?page=formulario&accion=add">NUEVO PRODUCTO</a></li>
							&nbsp;|&nbsp;
							<li><a href="usuario.php?action=logoutUser">SALIR</a></li>
						</ul>
						<!--div class="cart"><a href="#"><span></span>CART</a></div-->
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>

		</div>