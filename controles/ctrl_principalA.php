<?php
//********************* control para manipular todo lo del menú ****************
	session_start();
	include("../classes/usuario.php");
	include("../classes/orden.php");
	
	if(!empty($_SESSION['c0rr3ito']) && $_SERVER["REQUEST_METHOD"]=="GET") {
		if($_SESSION['t1poU']==4){
			$checando = @$_GET["operacion"];
			if(!empty($checando)){
				switch ($_GET["operacion"]){
					case "registrarU":
						if($_SESSION['t1poU']==4){
							$hcontra = "<h2>Registrar Usuario</h2>
							<div id='login'>
								<fieldset>						
									<table width='400' border='0'>
										<tr>
											<td colspan=\"2\">&nbsp;</td>
										</tr>
										<tr>
											<td><p><label>Nombre completo: </label></p></td>
											<td><p><input type='text' id='txtNombre' name='txtNombre' value='Nombre' onBlur=\"if(this.value=='')this.value='Nombre'\" onFocus=\"if(this.value=='Nombre')this.value=''\"></p></td>
										</tr>
										<tr>
											<td><p><label>Número de trabajador: </label></p></td>
											<td><p><input type='number' id='txtNumero' name='txtNumero' value='00000' onBlur=\"if(this.value=='')this.value='00000'\" onFocus=\"if(this.value=='00000')this.value=''\"></p></td>
										</tr>
										<tr>
											<td><p><label>Contraseña: </label></p></td>
											<td><p><input type='password' id='txtPass' name='txtPass' value='22222222' onBlur=\"if(this.value=='')this.value='22222222'\" onFocus=\"if(this.value=='22222222')this.value=''\"></p></td>
										</tr>
										<tr>
											<td><p><label>Correo: </label></p></td>
											<td><p><input type='email' id='txtCorreo' name='txtCorreo' value='mail@address.com' onBlur=\"if(this.value=='')this.value='mail@address.com'\" onFocus=\"if(this.value=='mail@address.com')this.value=''\"></p></td>
										</tr>
										<tr>
											<td><p><label>Tipo de usuario: </label></p></td>
											<td><p><select id='selUsuario'>                               
												<option value='1'>Director</option>
												<option value='2'>Gerente de departamento</option>
												<option value='3'>Gerente administrativo</option>
												<option value='4'>Administrador</option>
												<option value='5'>Capturista</option>
												<option value='6'>Supervisor de compras</option>
											</select></p></td>
										</tr>
										<tr>
											<td><p><label>Departamento: </label></p></td>
											<td><p><select id='selDepartamento'>                               
												<option value='1'>Dirección general</option>
												<option value='2'>Gerencia administrativa</option>
												<option value='3'>Gerencia de operaciones</option>
												<option value='4'>Gerencia técnica</option>
												<option value='5'>Gerencia de producción</option>
												<option value='6'>Gerencia de ventas</option>
												<option value='7'>Gerencia de noticieros</option>
												<option value='8'>Recursos humanos</option>
												<option value='9'>Mercadotecnia</option>
												<option value='10'>Sistemas</option>
												<option value='11'>Servicios generales</option>
												<option value='12'>Por definir 1</option>
												<option value='13'>Por definir 2</option>
											</select></p></td>
										</tr>
										<tr>
											<td><p><label>Activo: </label></p></td>
											<td><p><select id='selActivo'>                               
												<option value='1'>Si</option>
												<option value='2'>No</option>
											</select></p></td>
										</tr>
										<tr>
											<td colspan=\"2\">&nbsp;</td>
										</tr>
										<tr>
											<td colspan=\"2\"><p><input type='submit' name='btnRegistrarUsuario' id='btnRegistrarUsuario' value='Registrar usuario'></p></td>
										</tr>
										<tr>
											<td colspan=\"2\">&nbsp;</td>
										</tr>
									</table>		
								</fieldset>
							</div> 
							";
							echo $hcontra;
						}
						else
							echo "";
					break;
						
					case "consultarU": 
						if($_SESSION['t1poU']==4){
							$user = new usuario();
							$usuarios = $user->obtenerUsuarios();
							$hcont = "<h2>Consulta de usuarios</h2>
								<br />
								<div id='divBusqueda'>
								<br />
									<table width='410' border='0'>
										<tr>
											<td><p><label>Nombre o No. trabajador: </label></p></td>
											<td><p><input type='text' id='txtBusqueda' name='txtBusqueda' value='00000000' onBlur=\"if(this.value=='')this.value='00000000'\" onFocus=\"if(this.value=='00000000')this.value=''\"></p></td>
											<td colspan=\"2\"><p><input type='submit' name='btnBuscarUsuario' id='btnBuscarUsuario' value='Buscar'></p></td>
										</tr>
									</table>
								</div>
								<br />
								<div id='idUsuarios'>
								<table id='hTblUsuarios' class='zebra'>
									<thead><tr><th>Nombre</th><th>No. Trabajador</th><th>Tipo</th><th>Estado</th><th></th></tr></thead>";
									foreach ($usuarios as $row){
										if($row[4]==1)
											$row[4]="Activo";
										else if ($row[4]==2)
											$row[4]="Inactivo";
										$hcont =$hcont."<tr>
										<td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]
										."</td><td><button class='btnInfo' id=btnInfo id='btnInfo' value=".$row[0]." style='cursor:pointer'><img src='images/informacionn.png' title='Información de usuario'></td></tr>";						
									}
									$hcont=$hcont."</table></div><br />";
							echo $hcont;
						}
						else
							echo "";
					break;		
					
					case "informacionU":
						if($_SESSION['t1poU']==4){
							$user = new usuario();
							$usuarios = $user->obtenerUsuario($_GET["id"]);
							$hcontra = "<h2>Información de Usuario</h2>
							<div id='login'>
								<fieldset>						
									<table width='500' border='0'>
										<tr>
											<td colspan=\"2\">&nbsp;</td>
										</tr>
										<tr>
											<td><p><label>Nombre completo: </label></p></td>
											<td><p><input type='text' id='txtNombre' name='txtNombre' value='".$usuarios[0]."' onBlur=\"if(this.value=='')this.value='Nombre'\" onFocus=\"if(this.value=='Nombre')this.value=''\"></p></td>
										</tr>
										<tr>
											<td><p><label>Número de trabajador: </label></p></td>
											<td><p><input type='number' id='txtNumero' name='txtNumero' value='".$usuarios[1]."' onBlur=\"if(this.value=='')this.value='00000'\" onFocus=\"if(this.value=='00000')this.value=''\"></p></td>
										</tr>
										<tr>
											<td><p><label>Contraseña: </label></p></td>
											<td><p><input type='password' id='txtPass' name='txtPass' value='22222222' onBlur=\"if(this.value=='')this.value='22222222'\" onFocus=\"if(this.value=='22222222')this.value=''\"></p></td>
											<td colspan=\"2\"><p><input type='submit' name='btnCambiarC' id='btnCambiarC' value='Cambiar'></p></td>
										</tr>
										<tr>
											<td><p><label>Correo: </label></p></td>
											<td><p><input type='email' id='txtCorreo' name='txtCorreo' value='".$usuarios[2]."' onBlur=\"if(this.value=='')this.value='mail@address.com'\" onFocus=\"if(this.value=='mail@address.com')this.value=''\"></p></td>
										</tr>
										<tr>
											<td><p><label>Tipo de usuario: </label></p></td>
											<td><p><select id='selUsuario'> ";
												$opciones= array(
														'Director',
														'Gerente de departamento',
														'Gerente administrativo',
														'Administrador',
														'Capturista',
														'Supervisor de compras'
												);  
												$var="";
												$opciones_count = count($opciones);                      
												for ($i = 0; $i < $opciones_count; $i++) {
													$var= $var.'<option value="' . ($i+1) . '"';
													if($usuarios[3]==($i+1))
														$var=$var.' selected';
													$var=$var. '>' . $opciones[$i] . '</option>';
												}
												$hcontra = $hcontra.$var;																						
											$hcontra=$hcontra."</select></p></td>
										</tr>
										<tr>
											<td><p><label>Departamento: </label></p></td>
											<td><p><select id='selDepartamento'> ";
												$opciones= array(
														'Dirección general',
														'Gerencia administrativa',
														'Gerencia de operaciones',
														'Gerencia técnica',
														'Gerencia de producción',
														'Gerencia de ventas',
														'Gerencia de noticieros',
														'Recursos humanos',
														'Mercadotecnia',
														'Sistemas',
														'Servicios generales',
														'Por definir 1',
														'Por definir 2'
												);  
												$var="";
												$opciones_count = count($opciones);                      
												for ($i = 0; $i < $opciones_count; $i++) {
													$var= $var.'<option value="' . ($i+1) . '"';
													if($usuarios[4]==($i+1))
														$var=$var.' selected';
													$var=$var. '>' . $opciones[$i] . '</option>';
												}
												$hcontra = $hcontra.$var;																						
											$hcontra=$hcontra."</select></p></td>
										</tr>
										<tr>
											<td><p><label>Activo: </label></p></td>
											<td><p><select id='selActivo'>";
												$var="";
												$opciones= array(
														'Si',
														'No'
												);
												$opciones_count = count($opciones);                      
												for ($i = 0; $i < $opciones_count; $i++) {
													$var= $var.'<option value="' . ($i+1) . '"';
													if($usuarios[5]==($i+1))
														$var=$var.' selected';
													$var=$var. '>' . $opciones[$i] . '</option>';
												}
												$hcontra = $hcontra.$var;
											$hcontra=$hcontra."</select></p></td>
										</tr>
										<tr>
											<td colspan=\"2\">&nbsp;</td>
										</tr>
										<tr>
											<td colspan=\"2\"><p><input type='submit' name='btnActualizarUsuario' id='btnActualizarUsuario' value='Actualizar'></p></td>
										</tr>
										<tr>
											<td colspan=\"2\">&nbsp;</td>
										</tr>
									</table>		
								</fieldset>
							</div> 
							";
							echo $hcontra;
						}
						else
							echo "";
					break;		
					
					case "consultarTOrdenes":
						$orden = new orden();
						$ordenes = $orden->obtenerTOrdenes();
						if($ordenes!=null){
							$hcont = "<h2>Consulta de todas las órdenes en el sistema</h2>
								<br />
								<div id='idOrdenes'>
								<table id='hTblOrdenesAprobar' class='table table-bordered table-striped foot' data-show-toggle='true' data-paging-size='10'  data-paging='true'>
									<thead><tr>
									<th>Folio</th>
									<th>Nombre Trabajador</th>
									<th>Departamento</th>
									<th>Fecha y hora</th>
									<th>Estado</th><th></th></tr></thead>";
									foreach ($ordenes as $row){
										$hcont =$hcont."<tr>
										<td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]
										."</td><td>".$row[3]."</td><td style='width:10px'>";
											switch ($row[4]){
												case 1:
													$row[4]="En espera";
												break;
												case 2:
													$row[4]="Aprobada por Departamento";
												break;
												case 3:
													$row[4]="Rechazada por Departamento";
												break;
												case 4:
													$row[4]="Aprobada por Sup. de Compras";
												break;
												case 5:
													$row[4]="Rechazada por Sup. de Compras";
												break;
												case 6:
													$row[4]="Aprobada por G. administrativo";
												break;
												case 7:
													$row[4]="Rechazada por G. administrativo";
												break;
												case 8:
													$row[4]="Compra en proceso";
												break;
												case 9:
													$row[4]="Orden rechazada";
												break;
											}
										$hcont=$hcont.$row[4]."</td><td class='btnInfoOrden' style='width:10px;' id=".$row[0]." value=".$row[0]." ><button class='btnInfoOrden' id='btnInfoOrden' value=".$row[0]." style='cursor:pointer'><img src='images/mas.png' title='Información de orden'></td></tr>";
									}
								$hcont=$hcont."</table></div><br />
								<script type='text/javascript'>
							            jQuery(function($){
							                $('.foot').footable({
							                'paging': {
							                'size': 10
							                },
							                'filtering': {
							                'enabled': true
							                },
							                'sorting': {
							                'enabled': true
							                }
							              });
							            });
							      </script>";
							echo $hcont;
						}
						else{
							$hcont = "<h2>Consulta de todas las órdenes en el sistema</h2>
								<br />
								<div id='idOrdenes'>
									<table id='hTblOrdenesDepto' class='zebra'>
										<thead><tr><th style='width:20px;'>Folio</th><th>Nombre Trabajador</th><th>Departamento</th><th>Fecha y hora</th><th></th></tr></thead>
									</table>
								</div>
								<br />";
							echo $hcont;
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
?>