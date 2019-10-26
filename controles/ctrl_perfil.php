<?php
//********** Control para manejo de cambio de contraseña del usuario ****************
	session_start();	
	include("../classes/usuario.php");
	
	if(!empty($_SESSION['c0rr3ito']) && $_SERVER["REQUEST_METHOD"]=="GET") {	
		$checando = @$_GET["operacion"]; 
		if(!empty($checando)){
			switch ($_GET["operacion"]){
				//********metodo para mostrar bienvenida******
				case "cambiarContrasenia":
					if(!empty($_GET['txtPass0'])){
						$user = new usuario();
						try{
							$nusuario = $user->obtenerPass($_SESSION['c0rr3ito']);
							if($nusuario>0){
								if($nusuario[0]==md5($_GET['txtPass0'])){
									if(strlen($_GET['txtPass1'])>=8){
										if(!empty($_GET['txtPass1']) && !empty($_GET['txtPass2'])) {
											if($_GET['txtPass1']==$_GET['txtPass2']){
												if($user->cambiarContrasenia($_SESSION['c0rr3ito'],$_GET['txtPass1'])==1)
													echo "Contraseña actualizada correctamente";
												else
													echo "No se ha actualizado la contraseña";
											}
											else
												echo "Las contraseñas no coinciden";
										}
										else
											echo "Existen campos vacios";
									}
									else
										echo "La contraseña debe contener al menos ocho caracteres";
								}
								else
									echo "Contraseña incorrecta, favor de verificarla";
							}
							else
								echo "Ocurrió un error en el sistema";
						}
						catch(PDOException $e){
							echo "Ocurrió un error en el servidor";
						}
					}
				break;
			} // end SWITCH
		}
		else{
			header("Location: ../index.php");
			exit;
		}
	}
	else{
		header("Location: ../index.php");
		exit;
	}
?>