<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>OOP in PHP</title>
<?php include("usuario.php"); 
?>
</head>
<body>
<?php
	// Using our PHP objects in our PHP pages.
	$nuevo = new usuario();
	//echo "Datos: " . json_encode($nuevo->obtenerUsuarios());
	//$var = $nuevo->obtenerUsuarios();
	//echo "\nUsuarios: ".$var[0][1];
	//echo "Usuario: " . json_encode($nuevo->obtenerLogin("vcruz@televisa.com","f969c5b9320c33912948824ec4553eea"));
	//$var = $nuevo->obtenerPass("vcruz@televisa.com");
	//echo "\nPass: ".$var[0];;
	$cuenta = $nuevo->cambiarToken("vcruz@televisa.com", "asasdasda");
	echo $cuenta;
?>
</body>
</html>
