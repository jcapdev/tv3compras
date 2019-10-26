<?php
	session_start();	
	include("classes/usuario.php");
	include("classes/orden.php");
	include("classes/correo.php");
	include_once('classes/PDF.php');
	
	$orden = new orden();
		$idUnidad = $orden->obtenerTipoUnidad("Kilos");
		echo $idUnidad[0];
?>