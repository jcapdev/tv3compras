<?php
//********** Control para manejo de cambio de contraseña del usuario ****************
	session_start();	
	include("../classes/usuario.php");
	
	if(!empty($_SESSION['c0rr3ito']) && $_SERVER["REQUEST_METHOD"]=="GET") {	
		if($_SESSION['t1poU']==4){
			$checando = @$_GET["operacion"]; 
			if(!empty($checando)){
				switch ($_GET["operacion"]){
					//********metodo para registrar usuario******
					case "registrarUsuario":
						if(!empty($_GET['txtNumero'])&&!empty($_GET['txtNombre'])&&!empty($_GET['txtPass'])&& 
							!empty($_GET['txtCorreo'])&&!empty($_GET['selUsuario'])&&!empty($_GET['selDepartamento'])&& 
							!empty($_GET['selActivo'])&& verificarEmail($_GET['txtCorreo'])&&verificarNumeros($_GET['txtNumero'])){
							$user = new usuario();
							try{
								if($user->altaUsuario($_GET['txtNumero'],$_GET['txtNombre'],md5($_GET['txtPass']),$_GET['txtCorreo'],
														$_GET['selUsuario'],$_GET['selDepartamento'],$_GET['selActivo']))
									echo "Usuario registrado satisfactoriamente";
								else
									echo "El usuario ya se encuentra registrado en el sistema";
							}
							catch(PDOException $e){
								echo "Ocurrió un error en el servidor";
							}
						}
						else 
							echo "No se ha registrado el usuario, verifique los datos ingresados";
					break;
					
					case "buscarUsuario":
						if($_SESSION['t1poU']==4){
							if(!empty($_GET['txtBusqueda'])){
								$user = new usuario();
								$usuarios = $user->buscarUsuario($_GET['txtBusqueda']);
								$hcontra = "
										<table id='hTblUsuarios' class='zebra'>
											<thead><tr><th>Nombre</th><th>No. Trabajador</th><th>Tipo</th><th>Estado</th><th></th></tr></thead>";
											foreach ($usuarios as $row){
												if($row[4]==1)
													$row[4]="Activo";
												else if ($row[4]==2)
													$row[4]="Inactivo";
												$hcontra =$hcontra."<tr>
												<td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]
												."</td><td><button class='btnInfo' id=btnInfo id='btnInfo' value=".$row[0]." style='cursor:pointer'><img src='images/informacionn.png' title='Información de usuario'></td></tr>";
											}
									$hcontra=$hcontra."</table>";
								echo $hcontra;
							}
							else
								echo "";
						}
						else
							echo "";
					break;
					
					case "actualizarUsuario":
						if(!empty($_GET['id'])&&!empty($_GET['txtNumero'])&&!empty($_GET['txtNombre'])&&
							!empty($_GET['txtCorreo'])&&!empty($_GET['selUsuario'])&&!empty($_GET['selDepartamento'])&& 
							!empty($_GET['selActivo'])&& verificarEmail($_GET['txtCorreo'])&&verificarNumeros($_GET['txtNumero'])){
							$user = new usuario();
							try{
								if($user->cambiarUsuario($_GET['id'],$_GET['txtNumero'],$_GET['txtNombre'],$_GET['txtCorreo'],
														$_GET['selUsuario'],$_GET['selDepartamento'],$_GET['selActivo']))
									echo "Usuario actualizado satisfactoriamente";
								else
									echo "No se han realizado cambios en el usuario";
							}
							catch(PDOException $e){
								echo "Ocurrió un error en el servidor";
							}
						}
						else 
							echo "No se ha actualizado el usuario, verifique los datos ingresados";
					break;
					
					case "cambiarContraseniaU":
					if(!empty($_GET['txtPass'])&&!empty($_GET['id'])){
						$user = new usuario();
						try{
							if($user->cambiarContraseniaU($_GET['id'],$_GET['txtPass'])==1)
								echo "Contraseña actualizada correctamente";
							else
								echo "No se ha actualizado la contraseña";
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
	}
	else{
		header("Location: ../index.php");
		exit;
	}
	
	// funcion para comprobar correo
	function verificarEmail($email){ 
	if (!ereg("^([a-zA-Z0-9._]+)@([a-zA-Z0-9.-]+).([a-zA-Z]{2,4})$",$email))
		return FALSE; 
	else
		return TRUE; 
	}
	
	// funcion para comprobar numeros
	function verificarNumeros($numeros){ 
	if (!ereg("^[0-9]+$",$numeros))
		return FALSE; 
	else
		return TRUE; 
	}
?>