<?php
//********* control para el manejo del login de usuario ************
	session_start();	
	include("../classes/usuario.php");
	
	if(empty($_SESSION['c0rr3ito'])) {				//verifica si hay sesión iniciada 
		if($_SERVER["REQUEST_METHOD"]=="GET"){		//verifica si se ha hecho un GET
			$checando = @$_GET["operacion"]; 		//veritica si se ha hecho un GET["operacion"]
			if(!empty($checando)){
				if(verificarEmail($_GET['email'])){
					switch ($_GET["operacion"]){
						case "accesar":					//opcion para login
							if(!empty($_GET['email']) && !empty($_GET['password'])) {
								//se crea un nuevo objeto de usuario
								$user = new usuario();
								//Se elimina el posible SQLInjection del usuario
								$usuario = mysql_escape_string($_GET['email']);  	
								//sacamos el hash del password para que se compare ya encriptado
								$password = md5(mysql_escape_string($_GET['password']));	 
								//se obtiene la contraseña
								$nusuario = $user->obtenerPass($usuario);
								if($nusuario>0){
									if($nusuario[0]==$password){
										try {
											$var = $user->obtenerLogin($usuario,$password);
											if($var>0){
												//generamos un token aleatorio para el usuario
												$_SESSION['token'] = md5(rand().$usuario);										
												if($user->cambiarToken($usuario, $_SESSION['token'])>0){
													$_SESSION['c0rr3ito'] = $usuario;
													$_SESSION['nombr3']=$var[0];
													$_SESSION['id3ntificador']=$var[1];
													$_SESSION['t1poU']=$var[2];
													$_SESSION['d3p4rtament0']=$var[3];
													$user ->reiniciarIntentos($usuario);
													echo "";
												}
												else{
													echo "Hubo un error en el servidor";
												}
											}
											else{
												echo "Los datos están equivocados-";
											}
										} 
										catch (PDOException $e) {
											die();
											echo "Hubo un error en el servidor";
										}
									}
									else{
										$var = $user ->aumentarIntentos($usuario);
										if($var>0){
											if($var[0]>=3)
												echo "Usuario bloqueado, contacte al administrador del sistema";									
											else
												echo "Contraseña incorrecta, vuelva a intentarlo";
										}
										else
											echo "Usuario bloqueado, contacte al administrador del sistema";
									}
								}
								else{
									echo "Error en autenticación";
								}
							}	//end empty
						break;
					} // end SWITCH
				}
			}
			else{
				header("Location: ../index.php");
				exit;
			}
		}	// end request method
	}
	else{
		header("Location: ../principal.php");
		exit;
	}
	
	// funcion para comprobar correo
	function verificarEmail($email){ 
	if (!ereg("^([a-zA-Z0-9._]+)@([a-zA-Z0-9.-]+).([a-zA-Z]{2,4})$",$email))
		return FALSE; 
	else
		return TRUE; 
	}
?>