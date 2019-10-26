<?php
	session_start();	
	include("../classes/usuario.php");
	include("../classes/orden.php");
	include("../classes/correo.php");
	include_once('../classes/PDF.php');
	
	if(!empty($_SESSION['c0rr3ito']) && $_SERVER["REQUEST_METHOD"]=="GET") {	
		if(!empty($_SESSION['t1poU'])){
			$checando = @$_GET["operacion"]; 
			if(!empty($checando)){
				switch ($_GET["operacion"]){
					//********metodo para registrar orden *******
					case "enviarOrden":
						if(!empty($_GET['tabla'])){
							$data = $_GET['tabla'];
							$datosTabla =  json_decode($data);
							$cont = 0;
							
							$errores = "";
							if ($datosTabla->myrows!=null){
								// ***** revisión de la tabla, que no contenga datos vacios ******
								$mContenido = "<table rules='all' style='border-color: #666;' cellpadding='10'><thead><tr style='background: #eee;'>
													<th style='width:10px'>Partidas</th><th style='width:20px'>Cantidad</th><th style='width:22px'>Unidad</th><th>Descripci&oacute;n</th><td>Lugar</td></tr></thead>";
								foreach ($datosTabla->myrows as $row){
									$vUnidad = verificarUnidad($row->Unidad);									
									if(!verificarNumeros($row->Cantidad) || $vUnidad<=0 || $row->Descripcion=="" || $row->Cantidad<=0 || $row->Lugar==""){
										$errores = "";
										$errores = "Existen errores en los datos de la tabla";
									}
									else
										$cont = $cont+1;
										$mContenido = $mContenido. "<tr><td>".$cont."</td><td>".$row->Cantidad."</td><td>".$row->Unidad."</td><td>".$row->Descripcion
											."</td><td>".$row->Lugar."</td></tr>";
								}
								
								if($errores==""){						
									$orden = new orden();
									$bandera = 0;
									$contador = 0;
									$ultimoID = $orden->altaOrden($_GET['txtDescripcionO'],$_SESSION['id3ntificador']);
									if($ultimoID!=""){
										foreach($datosTabla->myrows as $row){
											$contador = $contador+1;
											if (($orden->altaArticulo($row->Cantidad,
																verificarUnidad($row->Unidad),$row->Descripcion,$row->Lugar,
																$ultimoID))!=1){
												$bandera=1;
												break;
											}
											else
												$bandera=0;
										}		
										if ($bandera==0){
											$usuario = new usuario();
											$correoGerente = $usuario->obtenerCorreoGerenteDepto($_SESSION['d3p4rtament0']);
											$correoGerente = $correoGerente[0];
											$correo = new correo();
											$correo->enviarCorreoCapturista($_SESSION['c0rreoSolic1tant3'],$mContenido,$ultimoID);
											$correo->enviarCorreoGerenteDeCapturista($correoGerente,$_SESSION['nombr3'],$mContenido,$ultimoID);			
											echo "Se ha registrado la orden correctamente, su orden será procesada";
										}
										else
											echo "El producto ".$contador." no se ha podido dar de alta";
									}
									else
										echo "No se ha registrado la orden, intente nuevamente";
								}
								else
									echo $errores;
							}
							else
								echo "No hay artículos en la orden";
						}
						else 
							echo "";
					break;
					
					
					case "informacionOrdenG":
						if($_SESSION['t1poU']==2){
							$orden = new orden();
							$_SESSION['idOrden3legida']= $_GET['id'];
							$_SESSION['FechaH0ra'] = $_GET['fechaHora'];
							$ordenElegida = $orden->obtenerOrdenDepto($_SESSION['idOrden3legida'],$_SESSION['d3p4rtament0'],$_GET['fechaHora']);
							$depto = $orden->obtenerDepartamento($_SESSION['d3p4rtament0']);
							$articulos = $orden->obtenerArticulos($_SESSION['idOrden3legida']);
							$_SESSION['c0rreoSolic1tant3'] = $ordenElegida[3];
							$hcontenido="";
							$hcont = "
									<script>
									$(function(){ 
										$('#hTblArticulos').tableEdit({ 
											columnsTr: '2,4,5', //null = all columns editable 
											enableDblClick: true, //enable edit td with dblclick 
											callback: function(e){ 
												console.log(e.city); 
												console.log(e.age); /* * code for ajax */ 
											}, 
											activeMasks: function(){ 
												console.log('function enable masks'); /* * function for active masks */ 
											} 
										});
									})
									</script>
									<h2>Información de orden</h2>
									<br />
									<div id='idOrden'>
										<table width='600' border='0'>
											<tr>
												<td><p><strong>Departamento solicitante: </strong>".$depto[0]."</p></td>
												<td><p><strong>Folio: </strong>".$_GET['id']."</p></td>
											</tr>
											<tr>
												<td><p><strong>Solicitante: </strong>".$ordenElegida[0]."</p></td>
												<td><p><strong>Fecha y hora: </strong>".$ordenElegida[1]."</p></td>
											</tr>
											<tr>
												<td><p><strong>Correo de solicitante: </strong>".$ordenElegida[3]."</p></td>
												<td></td>
											</tr>
										</table><br />
										
										<table id='hTblArticulos' class='zebra'>
											<thead>
												<tr>
													<th style='display: none;'>N</th><th style='width:10px;'>No.</th><th style='width:10px;'>Cantidad</th><th style='width:20px;'>Unidad</th><th style='width:140px;'>Descripcion</th><th style='width:140px;'>Lugar</th><th style='width:20px;'>Editar</th>
												</tr>											
											</thead>";
										$cont = 0;
										foreach ($articulos as $row){
											$cont = $cont+1;
											$hcont = $hcont."<tr>
											<td style='display: none;'>".$row[0]."</td><td>".$cont."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]
											."</td>
											<td>".$row[4]."</td><td><a href='javascript:;' class='btEdit'>Editar</a></td>
											</tr>";
										}
										
										$hcont=$hcont."</table></div><br />			
										<table width='600' border='0'>	
											<tr>
												<td style='width:100px'><p><strong>Observaciones: </strong></p> </td>
												<td colspan='2'><textarea name='txtObservaciones' cols='35' rows='2' id='txtObservaciones'></textarea></td>
												<td style='width:20px'><p><input type='submit' name='btnAgregarObservacion' id='btnAgregarObservacion' value='Agregar observación' class='btnGenerico'></p></td>
											</tr>
											<tr>
												<td colspan='4'>&nbsp;</td>
											</tr>
											<tr>
												<td colspan='4'><p id='lbObservaciones'><strong>Observaciones previas: </strong>".$ordenElegida[2]."</p></td>
											</tr>
										</table>									
										
										<table width='600' border='0'>
											<tr>
												<td colspan='4'>&nbsp;</td>
											</tr>
											<tr>
												<td><p><input type='submit' name='btnActualizarOrden' id='btnActualizarOrden' value='Actualizar Orden' class='btnGenerico'></p></td>
												<td><p><input type='submit' name='btnGenerarPDF' id='btnGenerarPDF' value='Generar PDF' class='btnGenerarPDF' onclick='generarPDF'></p></td>
												<td><p><input type='submit' name='btnAprobar' id='btnAprobar' value='Aprobar' class='btnAprobar'></p></td>
												<td><p><input type='submit' name='btnRechazar' id='btnRechazar' value='Rechazar' class='btnRechazar'></p></td>
											</tr>
										</table>
									</div>
									<br />
							";
							echo $hcont;
						}
						else
							echo "";
					break;
					
					case "aprobarOrdenG":
						if($_SESSION['t1poU']==2){
							$orden = new orden();
							$aprobado = $orden->aprobarOrdenG($_GET['idOrden'],$_SESSION['nombr3']);
							if($aprobado>0){
								$usuario = new usuario();
								$correoSupervisor = $usuario->obtenerCorreoSupervisorC();
								$capturista = $usuario->obtenerDatosUsuario($_GET['idOrden']);
								$correo = new correo();
								$correo->enviarCorreoSupervisorComprasDeGerente($correoSupervisor[0], $capturista[0], $capturista[1], $_GET['idOrden']);
								echo "Orden aprobada y enviada al encargado de compras";
							}
							else
								echo "No se logró completar la aprobación, intente nuevamente más tarde";
						}
						else
							echo "";
					break;
					
					case "rechazarOrdenG":
						if($_SESSION['t1poU']==2){
							$orden = new orden();
							$correo = new correo();
							$usuario = new usuario();							
							$rechazado = $orden->rechazarOrdenG($_GET['idOrden'],$_SESSION['nombr3']);
							$capturista = $usuario->obtenerDatosUsuario($_GET['idOrden']);
							if($rechazado>0){
								$correo->enviarCorreoCapturistaRechazadoDeGerente($capturista[2],$_GET['idOrden']);
								echo "Orden rechazada y notificada al capturista";
							}
							else
								echo "No se logró completar el rechazo, intente nuevamente más tarde";
						}
						else
							echo "";
					break;
					
					case "agregarObservacionG":
						if($_SESSION['t1poU']==2){
							$orden = new orden();
							$afectada = $orden->agregarObservacion($_GET['idOrden'],$_GET['txtObservacion'],$_SESSION['nombr3']);
							if($afectada>0)
								echo "La observacion se ha registrado";
							else
								echo "";
						}
						else
							echo "";
					break;
					
					case "actualizarOrdenG":
						if($_SESSION['t1poU']==2){
							if(!empty($_GET['tabla'])){
								$data = $_GET['tabla'];
								$datosTabla = json_decode($data);
								$cont = 0;
								$errores = "";
								
								foreach ($datosTabla->myrows as $row){							
									if(!verificarNumeros($row->Cantidad) || $row->Descripcion=="" || $row->Cantidad<=0 || $row->Lugar==""){
										$errores = "";
										$errores = "Existen errores en los datos de la tabla";
									}
								}
								if($errores==""){
									$orden = new orden();
									$bandera = 0;
									
									foreach($datosTabla->myrows as $row){
										$orden->actualizarArticulo($row->N,$row->Cantidad,$row->Descripcion,$row->Lugar,$_SESSION['idOrden3legida']);
									}
									
									echo "Articulos actualizados";
								}	
								else "";																
							}
							else
								echo "No hay artículos en la orden";
						}
						else
							echo "";
					break;
					
					
					case "actualizarOrdenS":
						if($_SESSION['t1poU']==6 || $_SESSION['t1poU']==3){
							if(!empty($_GET['tabla'])){
								$data = $_GET['tabla'];
								$datosTabla = json_decode($data);
								$cont = 0;
								$errores = "";
								
								foreach ($datosTabla->myrows as $row){							
									if(!verificarNumeros($row->Cantidad) || $row->Descripcion=="" || $row->Cantidad<=0 || $row->Lugar==""){
										$errores = "";
										$errores = "Existen errores en los datos de la tabla";
									}
								}
								if($errores==""){
									$orden = new orden();
									$bandera = 0;
									
									foreach($datosTabla->myrows as $row){
										$orden->actualizarArticuloSupCompras(
											$row->N,
											$row->Cantidad,
											$row->Descripcion,
											$row->Lugar,
											$row->PrecioU,
											$row->Cuenta,
											$row->Proveedor
										);
									}
									
									echo "Articulos actualizados";
								}	
								else "";																
							}
							else
								echo "No hay artículos en la orden";
						}
						else
							echo "";
					break;
					
					
					case "informacionOrdenS":
						if($_SESSION['t1poU']==6){
							$orden = new orden();
							$_SESSION['idOrden3legida']= $_GET['id'];
							$_SESSION['FechaH0ra'] = $_GET['fechaHora'];
							$ordenElegida = $orden->obtenerOrdenSupervisorCompras($_SESSION['idOrden3legida'],$_GET['fechaHora']);
							$articulos = $orden->obtenerArticulosSupervisorCompras($_SESSION['idOrden3legida']);
							$_SESSION['c0rreoSolic1tant3'] = $ordenElegida[3];
							$hcontenido="";
							$hcont = "
									<script>
									$(function(){ 
										$('#hTblArticulosS').tableEdit({ 
											columnsTr: '2,6,7,8', //null = all columns editable 
											enableDblClick: true, //enable edit td with dblclick 
											callback: function(e){ 
												console.log(e.city); 
												console.log(e.age); /* * code for ajax */ 
											}, 
											activeMasks: function(){ 
												console.log('function enable masks'); /* * function for active masks */ 
											} 
										});
									})
									</script>
									<h2>Información de orden</h2>
									<br />
									<div id='idOrden'>
										<table width='600' border='0'>
											<tr>
												<td><p><strong>Departamento solicitante: </strong>".$ordenElegida[4]."</p></td>
												<td><p><strong>Folio: </strong>".$_GET['id']."</p></td>
											</tr>
											<tr>
												<td><p><strong>Solicitante: </strong>".$ordenElegida[0]."</p></td>
												<td><p><strong>Fecha y hora: </strong>".$ordenElegida[1]."</p></td>
											</tr>
											<tr>
												<td><p><strong>Correo de solicitante: </strong>".$ordenElegida[3]."</p></td>
												<td></td>
											</tr>
										</table><br />
										
										<table id='hTblArticulosS' class='zebra'>
											<thead>
												<tr>
													<th style='display: none;'>N</th><th style='width:8px;'><p>No.</p></th><th style='width:8px;'><p>Cantidad</p></th><th style='width:20px;'><p>Unidad</p></th><th style='width:80px;'><p>Descripcion</p></th><th style='width:80px;'><p>Lugar</p></th><th style='width:100px;'><p>PrecioU</p></th><th style='width:100px;'><p>Cuenta</p></th><th style='width:100px;'><p>Proveedor</p></th><th style='width:20px;'><p>Editar</p></th>
												</tr>											
											</thead>";
										$cont = 0;
										foreach ($articulos as $row){
											$cont = $cont+1;
											$hcont = $hcont."<tr>
											<td style='display: none;'><p>".$row[0]."</p></td><td><p>".$cont."</p></td><td><p>".$row[1]."</p></td><td><p>".$row[2]."</p></td><td><p>".$row[3]
											."</p></td>
											<td><p>".$row[4]."</p></td><td><p>".$row[5]."</p></td><td><p>".$row[6]."</p></td><td><p>".$row[7]."</p></td><td><p><a href='javascript:;' class='btEdit'>Editar</a></p></td>
											</tr>";
										}
										
										$hcont=$hcont."</table></div><br />			
										<table width='600' border='0'>	
											<tr>
												<td style='width:100px'><p><strong>Observaciones: </strong></p> </td>
												<td colspan='2'><textarea name='txtObservaciones' cols='35' rows='2' id='txtObservaciones'></textarea></td>
												<td style='width:20px'><p><input type='submit' name='btnAgregarObservacion' id='btnAgregarObservacion' value='Agregar observación' class='btnGenerico'></p></td>
											</tr>
											<tr>
												<td colspan='4'>&nbsp;</td>
											</tr>
											<tr>
												<td colspan='4'><p id='lbObservaciones'><strong>Observaciones previas: </strong>".$ordenElegida[2]."</p></td>
											</tr>
										</table>									
										
										<table width='600' border='0'>
											<tr>
												<td colspan='4'>&nbsp;</td>
											</tr>
											<tr>
												<td><p><input type='submit' name='btnActualizarOrden' id='btnActualizarOrden' value='Actualizar Orden' class='btnGenerico'></p></td>
												<td><p><input type='submit' name='btnGenerarPDF' id='btnGenerarPDF' value='Generar PDF' class='btnGenerarPDF' onclick='generarPDF'></p></td>
												<td><p><input type='submit' name='btnAprobar' id='btnAprobar' value='Aprobar' class='btnAprobar'></p></td>
												<td><p><input type='submit' name='btnRechazar' id='btnRechazar' value='Rechazar' class='btnRechazar'></p></td>
											</tr>
										</table>
									</div>
									<br />
							";
							echo $hcont;
						}
						else
							echo "";
					break;
					
					case "agregarObservacionS":
						if($_SESSION['t1poU']==6 || $_SESSION['t1poU']==3){
							$orden = new orden();
							$afectada = $orden->agregarObservacion($_GET['idOrden'],$_GET['txtObservacion'],$_SESSION['nombr3']);
							if($afectada>0)
								echo "La observacion se ha registrado";
							else
								echo "";
						}
						else
							echo "";
					break;
					
					case "aprobarOrdenS":
						if($_SESSION['t1poU']==6){
							$orden = new orden();
							$aprobado = $orden->aprobarOrdenS($_GET['idOrden'],$_SESSION['nombr3']);
							if($aprobado>0){
								$correo = new correo();
								$usuario = new usuario();
								$correoSupervisor = $usuario->obtenerCorreoGerenteAdm();
								$capturista = $usuario->obtenerDatosUsuario($_GET['idOrden']);
								$correo->enviarCorreoGerenteAdmDeSupervisor($correoSupervisor[0],$capturista[0],$capturista[1],$_GET['idOrden']);								
								echo "Orden aprobada y enviada al gerente administrativo";
							}
							else
								echo "No se logró completar la aprobación, intente nuevamente más tarde";
						}
						else
							echo "";
					break;
					
					case "rechazarOrdenS":
						if($_SESSION['t1poU']==6){
							$orden = new orden();
							$rechazado = $orden->rechazarOrdenS($_GET['idOrden'],$_SESSION['nombr3']);
							if($rechazado>0){
								$usuario = new usuario();
								$capturista = $usuario->obtenerDatosUsuario($_GET['idOrden']);
								$correo = new correo();
								$correo->enviarCorreoCapturistaRechazadoDeSupervisor($capturista[2],$_GET['idOrden']);
								echo "Orden rechazada y notificada al capturista";
							}
							else
								echo "No se logró completar el rechazo, intente nuevamente más tarde";
						}
						else
							echo "";
					break;
					
					case "aprobarOrdenSA":
						if($_SESSION['t1poU']==6){
							$orden = new orden();
							$aprobado = $orden->aprobarOrdenSA($_GET['idOrden']);
							if($aprobado>0){
								$usuario = new usuario();
								$correoCapturista = $usuario->obtenerDatosUsuario($_GET['idOrden']);
								$correo = new correo();
								$correo->enviarCorreoCapturistaCompraDeSupervisor($correoCapturista[2],$_GET['idOrden']);
								echo "Orden aprobada y notificada al capturista";
							}
							else
								echo "No se logró completar la aprobación, intente nuevamente más tarde";
						}
						else
							echo "";
					break;
					
					case "rechazarOrdenSA":
						if($_SESSION['t1poU']==6){
							$orden = new orden();
							$rechazado = $orden->rechazarOrdenSA($_GET['idOrden']);
							if($rechazado>0){
								$usuario = new usuario();
								$correoCapturista = $usuario->obtenerDatosUsuario($_GET['idOrden']);
								$correo = new correo();
								$correo->enviarCorreoCapturistaNoCompraDeSupervisor($correoCapturista[2],$_GET['idOrden']);
								echo "Orden rechazada y notificada al capturista";
							}
							else
								echo "No se logró completar el rechazo, intente nuevamente más tarde";
						}
						else
							echo "";
					break;
					
					case "informacionOrdenC":
						if($_SESSION['t1poU']==3){
							$orden = new orden();
							$_SESSION['idOrden3legida']= $_GET['id'];
							$_SESSION['FechaH0ra'] = $_GET['fechaHora'];
							$ordenElegida = $orden->obtenerOrdenGerenteAdministrativo($_SESSION['idOrden3legida'],$_GET['fechaHora']);
							$articulos = $orden->obtenerArticulosGerenteAdministrativo($_SESSION['idOrden3legida']);
							$_SESSION['c0rreoSolic1tant3'] = $ordenElegida[3];
							$hcontenido="";
							$hcont = "
									<script>
									$(function(){ 
										$('#hTblArticulosS').tableEdit({ 
											columnsTr: '2,6,7,8', //null = all columns editable 
											enableDblClick: true, //enable edit td with dblclick 
											callback: function(e){ 
												console.log(e.city); 
												console.log(e.age); /* * code for ajax */ 
											}, 
											activeMasks: function(){ 
												console.log('function enable masks'); /* * function for active masks */ 
											} 
										});
									})
									</script>
									<h2>Información de orden</h2>
									<br />
									<div id='idOrden'>
										<table width='600' border='0'>
											<tr>
												<td><p><strong>Departamento solicitante: </strong>".$ordenElegida[4]."</p></td>
												<td><p><strong>Folio: </strong>".$_GET['id']."</p></td>
											</tr>
											<tr>
												<td><p><strong>Solicitante: </strong>".$ordenElegida[0]."</p></td>
												<td><p><strong>Fecha y hora: </strong>".$ordenElegida[1]."</p></td>
											</tr>
											<tr>
												<td><p><strong>Correo de solicitante: </strong>".$ordenElegida[3]."</p></td>
												<td></td>
											</tr>
										</table><br />
										
										<table id='hTblArticulosS' class='zebra'>
											<thead>
												<tr>
													<th style='display: none;'>N</th><th style='width:8px;'><p>No.</p></th><th style='width:8px;'><p>Cantidad</p></th><th style='width:20px;'><p>Unidad</p></th><th style='width:80px;'><p>Descripcion</p></th><th style='width:80px;'><p>Lugar</p></th><th style='width:100px;'><p>PrecioU</p></th><th style='width:100px;'><p>Cuenta</p></th><th style='width:100px;'><p>Proveedor</p></th><th style='width:20px;'><p>Editar</p></th>
												</tr>											
											</thead>";
										$cont = 0;
										foreach ($articulos as $row){
											$cont = $cont+1;
											$hcont = $hcont."<tr>
											<td style='display: none;'><p>".$row[0]."</p></td><td><p>".$cont."</p></td><td><p>".$row[1]."</p></td><td><p>".$row[2]."</p></td><td><p>".$row[3]
											."</p></td>
											<td><p>".$row[4]."</p></td><td><p>".$row[5]."</p></td><td><p>".$row[6]."</p></td><td><p>".$row[7]."</p></td><td><p><a href='javascript:;' class='btEdit'>Editar</a></p></td>
											</tr>";
										}
										
										$hcont=$hcont."</table></div><br />			
										<table width='600' border='0'>	
											<tr>
												<td style='width:100px'><p><strong>Observaciones: </strong></p> </td>
												<td colspan='2'><textarea name='txtObservaciones' cols='35' rows='2' id='txtObservaciones'></textarea></td>
												<td style='width:20px'><p><input type='submit' name='btnAgregarObservacion' id='btnAgregarObservacion' value='Agregar observación' class='btnGenerico'></p></td>
											</tr>
											<tr>
												<td colspan='4'>&nbsp;</td>
											</tr>
											<tr>
												<td colspan='4'><p id='lbObservaciones'><strong>Observaciones previas: </strong>".$ordenElegida[2]."</p></td>
											</tr>
										</table>									
										
										<table width='600' border='0'>
											<tr>
												<td colspan='4'>&nbsp;</td>
											</tr>
											<tr>
												<td><p><input type='submit' name='btnActualizarOrden' id='btnActualizarOrden' value='Actualizar Orden' class='btnGenerico'></p></td>
												<td><p><input type='submit' name='btnGenerarPDF' id='btnGenerarPDF' value='Generar PDF' class='btnGenerarPDF' onclick='generarPDF'></p></td>
												<td><p><input type='submit' name='btnAprobar' id='btnAprobar' value='Aprobar' class='btnAprobar'></p></td>
												<td><p><input type='submit' name='btnRechazar' id='btnRechazar' value='Rechazar' class='btnRechazar'></p></td>
											</tr>
										</table>
									</div>
									<br />
							";
							echo $hcont;
						}
						else
							echo "";
					break;
					
					case "actualizarOrdenS":
						if($_SESSION['t1poU']==6){
							if(!empty($_GET['tabla'])){
								$data = $_GET['tabla'];
								$datosTabla = json_decode($data);
								$cont = 0;
								$errores = "";
								
								foreach ($datosTabla->myrows as $row){							
									if(!verificarNumeros($row->Cantidad) || $row->Descripcion=="" || $row->Cantidad<=0 || $row->Lugar==""){
										$errores = "";
										$errores = "Existen errores en los datos de la tabla";
									}
								}
								if($errores==""){
									$orden = new orden();
									$bandera = 0;
									
									foreach($datosTabla->myrows as $row){
										$orden->actualizarArticuloSupCompras(
											$row->N,
											$row->Cantidad,
											$row->Descripcion,
											$row->Lugar,
											$row->PrecioU,
											$row->Cuenta,
											$row->Proveedor
										);
									}
									
									echo "Articulos actualizados";
								}	
								else "";																
							}
							else
								echo "No hay artículos en la orden";
						}
						else
							echo "";
					break;
					
					case "aprobarOrdenC":
						if($_SESSION['t1poU']==3){
							$orden = new orden();
							$aprobado = $orden->aprobarOrdenGerenteAdministrativo($_GET['idOrden'],$_SESSION['nombr3'],$_GET['fechaHora']);
							if($aprobado>0){
								$usuario = new usuario();
								$capturista = $usuario->obtenerDatosUsuario($_GET['idOrden']);
								$correoSupervisor = $usuario->obtenerCorreoSupervisorC();
								$correo = new correo();
								$correo->enviarCorreoSupervisorComprasDeGerenteAdm($correoSupervisor[0],$capturista[0],$capturista[1],$_GET['idOrden']);
								echo "Orden aprobada y enviada al supervisor de compras";
							}
							else
								echo "No se logró completar la aprobación, intente nuevamente más tarde";
						}
						else
							echo "";
					break;
					
					case "rechazarOrdenC":
						if($_SESSION['t1poU']==3){
							$orden = new orden();
							$rechazado = $orden->rechazarOrdenGerenteAdministrativo($_GET['idOrden'],$_SESSION['nombr3']);
							if($rechazado>0){
								$usuario = new usuario();
								$capturista = $usuario->obtenerDatosUsuario($_GET['idOrden']);
								$correo = new correo();
								$correo->enviarCorreoCapturistaRechazadoDeGerenteAdm($capturista[2],$_GET['idOrden']);
								
								echo "Orden rechazada y notificada al capturista";
							}
							else
								echo "No se logró completar el rechazo, intente nuevamente más tarde";
						}
						else
							echo "";
					break;
					
					case "informacionOrdenAprobada":
						if($_SESSION['t1poU']==6){
							$orden = new orden();
							$_SESSION['idOrden3legida']= $_GET['id'];
							$_SESSION['FechaH0ra'] = $_GET['fechaHora'];
							$ordenElegida = $orden->obtenerOrdenAprobada($_SESSION['idOrden3legida'],$_GET['fechaHora']);
							$articulos = $orden->obtenerArticulosSupervisorCompras($_SESSION['idOrden3legida']);
							$_SESSION['c0rreoSolic1tant3'] = $ordenElegida[3];
							$hcontenido="";
							$hcont = "
									<h2>Información de orden</h2>
									<br />
									<div id='idOrden'>
										<table width='600' border='0'>
											<tr>
												<td><p><strong>Departamento solicitante: </strong>".$ordenElegida[4]."</p></td>
												<td><p><strong>Folio: </strong>".$_GET['id']."</p></td>
											</tr>
											<tr>
												<td><p><strong>Solicitante: </strong>".$ordenElegida[0]."</p></td>
												<td><p><strong>Fecha y hora: </strong>".$ordenElegida[1]."</p></td>
											</tr>
											<tr>
												<td><p><strong>Correo de solicitante: </strong>".$ordenElegida[3]."</p></td>
												<td></td>
											</tr>
										</table><br />
										
										<table id='hTblArticulosS' class='zebra'>
											<thead>
												<tr>
													<th style='display: none;'>N</th><th style='width:8px;'><p>No.</p></th><th style='width:8px;'><p>Cantidad</p></th><th style='width:20px;'><p>Unidad</p></th><th style='width:80px;'><p>Descripcion</p></th><th style='width:80px;'><p>Lugar</p></th><th style='width:100px;'><p>PrecioU</p></th><th style='width:100px;'><p>Cuenta</p></th><th style='width:100px;'><p>Proveedor</p></th>
												</tr>											
											</thead>";
										$cont = 0;
										foreach ($articulos as $row){
											$cont = $cont+1;
											$hcont = $hcont."<tr>
											<td style='display: none;'><p>".$row[0]."</p></td><td><p>".$cont."</p></td><td><p>".$row[1]."</p></td><td><p>".$row[2]."</p></td><td><p>".$row[3]
											."</p></td>
											<td><p>".$row[4]."</p></td><td><p>".$row[5]."</p></td><td><p>".$row[6]."</p></td><td><p>".$row[7]."</p></td>
											</tr>";
										}
										
										$hcont=$hcont."</table></div><br />			
										<table width='600' border='0'>	
											<tr>
												<td style='width:100px'><p><strong>Observaciones: </strong></p> </td>
												<td colspan='2'><textarea name='txtObservaciones' cols='35' rows='2' id='txtObservaciones'></textarea></td>
												<td style='width:20px'><p><input type='submit' name='btnAgregarObservacion' id='btnAgregarObservacion' value='Agregar observación' class='btnGenerico'></p></td>
											</tr>
											<tr>
												<td colspan='4'>&nbsp;</td>
											</tr>
											<tr>
												<td colspan='4'><p id='lbObservaciones'><strong>Observaciones previas: </strong>".$ordenElegida[2]."</p></td>
											</tr>
										</table>									
										
										<table width='600' border='0'>
											<tr>
												<td colspan='3'>&nbsp;</td>
											</tr>
											<tr>
												<td><p><input type='submit' name='btnGenerarPDF' id='btnGenerarPDF' value='Generar PDF' class='btnGenerarPDF' onclick='generarPDF'></p></td>
												<td><p><input type='submit' name='btnAprobar' id='btnAprobar' value='Aprobar' class='btnAprobar'></p></td>
												<td><p><input type='submit' name='btnRechazar' id='btnRechazar' value='Rechazar' class='btnRechazar'></p></td>
											</tr>
										</table>
									</div>
									<br />
							";
							echo $hcont;
						}
						else
							echo "";
					break;
					
					case "informacionOrdenA":
						if($_SESSION['t1poU']==4){
							$orden = new orden();
							$_SESSION['idOrden3legida']= $_GET['id'];
							$_SESSION['FechaH0ra'] = $_GET['fechaHora'];
							$ordenElegida = $orden->obtenerOrdenAdministrador($_SESSION['idOrden3legida'],$_GET['fechaHora']);
							$articulos = $orden->obtenerArticulosGerenteAdministrativo($_SESSION['idOrden3legida']);
							$_SESSION['c0rreoSolic1tant3'] = $ordenElegida[3];
							$hcontenido="";
							$hcont = "
									<script>
									$(function(){ 
										$('#hTblArticulosS').tableEdit({ 
											columnsTr: '2,4,5,6,7,8', //null = all columns editable 
											enableDblClick: true, //enable edit td with dblclick 
											callback: function(e){ 
												console.log(e.city); 
												console.log(e.age); /* * code for ajax */ 
											}, 
											activeMasks: function(){ 
												console.log('function enable masks'); /* * function for active masks */ 
											} 
										});
									})
									</script>
									<h2>Información de orden</h2>
									<br />
									<div id='idOrden'>
										<table width='600' border='0'>
											<tr>
												<td><p><strong>Departamento solicitante: </strong>".$ordenElegida[4]."</p></td>
												<td><p><strong>Folio: </strong>".$_GET['id']."</p></td>
											</tr>
											<tr>
												<td><p><strong>Solicitante: </strong>".$ordenElegida[0]."</p></td>
												<td><p><strong>Fecha y hora: </strong>".$ordenElegida[1]."</p></td>
											</tr>
											<tr>
												<td><p><strong>Correo de solicitante: </strong>".$ordenElegida[3]."</p></td>
												<td></td>
											</tr>
										</table><br />
										
										<table id='hTblArticulosS' class='zebra'>
											<thead>
												<tr>
													<th style='display: none;'>N</th><th style='width:8px;'><p>No.</p></th><th style='width:8px;'><p>Cantidad</p></th><th style='width:20px;'><p>Unidad</p></th><th style='width:80px;'><p>Descripcion</p></th><th style='width:80px;'><p>Lugar</p></th><th style='width:100px;'><p>PrecioU</p></th><th style='width:100px;'><p>Cuenta</p></th><th style='width:100px;'><p>Proveedor</p></th><th style='width:20px;'><p>Editar</p></th>
												</tr>											
											</thead>";
										$cont = 0;
										foreach ($articulos as $row){
											$cont = $cont+1;
											$hcont = $hcont."<tr>
											<td style='display: none;'><p>".$row[0]."</p></td><td><p>".$cont."</p></td><td><p>".$row[1]."</p></td><td><p>".$row[2]."</p></td><td><p>".$row[3]
											."</p></td>
											<td><p>".$row[4]."</p></td><td><p>".$row[5]."</p></td><td><p>".$row[6]."</p></td><td><p>".$row[7]."</p></td><td><p><a href='javascript:;' class='btEdit'>Editar</a></p></td>
											</tr>";
										}
										
										$hcont=$hcont."</table></div><br />			
										<table width='600' border='0'>	
											<tr>
												<td style='width:100px'><p><strong>Observaciones: </strong></p> </td>
												<td colspan='2'><textarea name='txtObservaciones' cols='35' rows='2' id='txtObservaciones'></textarea></td>
												<td style='width:20px'><p><input type='submit' name='btnAgregarObservacion' id='btnAgregarObservacion' value='Agregar observación' class='btnGenerico'></p></td>
											</tr>
											<tr>
												<td colspan='4'>&nbsp;</td>
											</tr>
											<tr>
												<td colspan='4'><p id='lbObservaciones'><strong>Observaciones previas: </strong>".$ordenElegida[2]."</p></td>
											</tr>
										</table>									
										
										<table width='600' border='0'>
											<tr>
												<td colspan='4'>&nbsp;</td>
											</tr>
											<tr>
												<td><p><input type='submit' name='btnActualizarOrden' id='btnActualizarOrden' value='Actualizar Orden' class='btnGenerico'></p></td>
												<td><p><input type='submit' name='btnGenerarPDF' id='btnGenerarPDF' value='Generar PDF' class='btnGenerarPDF' onclick='generarPDF'></p></td>

												<td><p><input type='submit' name='btnAprobar' id='btnAprobar' value='Aprobar' class='btnAprobar'></p></td>
												<td><p><input type='submit' name='btnRechazar' id='btnRechazar' value='Rechazar' class='btnRechazar'></p></td>
											</tr>
										</table>
									</div>
									<br />
							";
							echo $hcont;
						}
						else
							echo "";
					break;
					
					case "actualizarOrdenA":
						if($_SESSION['t1poU']==4){
							if(!empty($_GET['tabla'])){
								$data = $_GET['tabla'];
								$datosTabla = json_decode($data);
								$cont = 0;
								$errores = "";
								
								foreach ($datosTabla->myrows as $row){							
									if(!verificarNumeros($row->Cantidad) || $row->Descripcion=="" || $row->Cantidad<=0 || $row->Lugar==""){
										$errores = "";
										$errores = "Existen errores en los datos de la tabla";
									}
								}
								
								if($errores==""){
									$orden = new orden();
									$bandera = 0;
									
									foreach($datosTabla->myrows as $row){
										$orden->actualizarArticuloSupCompras(
											$row->N,
											$row->Cantidad,
											$row->Descripcion,
											$row->Lugar,
											$row->PrecioU,
											$row->Cuenta,
											$row->Proveedor
										);
									}
									
									echo "Articulos actualizados";
								}	
								else echo $errores;																
							}
							else
								echo "No hay artículos en la orden";
						}
						else
							echo "";
					break;
					
					case "agregarObservacionA":
						if($_SESSION['t1poU']==4){
							$orden = new orden();
							$afectada = $orden->agregarObservacion($_GET['idOrden'],$_GET['txtObservacion'],$_SESSION['nombr3']);
							if($afectada>0)
								echo "La observacion se ha registrado";
							else
								echo "";
						}
						else
							echo "";
					break;
					
					
					case "aprobarOrdenA":
						if($_SESSION['t1poU']==4){
							$orden = new orden();
							$estadoOrden = $orden->obtenerEstadoOrden($_GET['idOrden']);
							$usuario = new usuario();
							$correo = new correo();			
							$capturista = $usuario->obtenerDatosUsuario($_GET['idOrden']);				
							switch ($estadoOrden[0]){
								case 1:
									$aprobado = $orden->aprobarOrdenG($_GET['idOrden'],$_SESSION['nombr3']);
									if($aprobado>0){
										$correoSupervisor = $usuario->obtenerCorreoSupervisorC();
										$correo->enviarCorreoSupervisorComprasDeGerente($correoSupervisor[0], $capturista[0], $capturista[1], $_GET['idOrden']);
										echo "Orden aprobada y enviada al encargado de compras";
									}
									else
										echo "No se logró completar la aprobación, intente nuevamente más tarde.";
								break;
								case 2:
									$aprobado = $orden->aprobarOrdenS($_GET['idOrden'],$_SESSION['nombr3']);
									if($aprobado>0){
										$correoSupervisor = $usuario->obtenerCorreoGerenteAdm();
										$correo->enviarCorreoGerenteAdmDeSupervisor($correoSupervisor[0],$capturista[0],$capturista[1],$_GET['idOrden']);								
										echo "Orden aprobada y enviada al gerente administrativo";
									}
									else
										echo "No se logró completar la aprobación, intente nuevamente más tarde.";
								break;
								case 4:
									$aprobado = $orden->aprobarOrdenGerenteAdministrativo($_GET['idOrden'],$_SESSION['nombr3']);
									if($aprobado>0){
										$correoSupervisor = $usuario->obtenerCorreoSupervisorC();
										$correo->enviarCorreoSupervisorComprasDeGerenteAdm($correoSupervisor[0],$capturista[0],$capturista[1],$_GET['idOrden']);
										echo "Orden aprobada y enviada al supervisor de compras";
									}
									else
										echo "No se logró completar la aprobación, intente nuevamente más tarde.";
								break;
								case 6:
									$aprobado = $orden->aprobarOrdenSA($_GET['idOrden']);
									if($aprobado>0){
										$correo->enviarCorreoCapturistaCompraDeSupervisor($correoCapturista[2],$_GET['idOrden']);
										echo "Orden aprobada y notificada al capturista";
									}
									else
										echo "No se logró completar la aprobación, intente nuevamente más tarde.";
								break;
							}								
						}
						else
							echo "";
					break;
					
					case "rechazarOrdenA":
						if($_SESSION['t1poU']==4){
							$orden = new orden();
							$usuario = new usuario();
							$correo = new correo();	
							$estadoOrden = $orden->obtenerEstadoOrden($_GET['idOrden']);
							$capturista = $usuario->obtenerDatosUsuario($_GET['idOrden']);				
							switch ($estadoOrden[0]){
								case 1:
									$rechazado = $orden->rechazarOrdenG($_GET['idOrden'],$_SESSION['nombr3']);
									if($rechazado>0){
										$correo->enviarCorreoCapturistaRechazadoDeGerente($capturista[2],$_GET['idOrden']);
										echo "Orden rechazada y notificada al capturista";
									}
									else
										echo "No se logró completar el rechazo, intente nuevamente más tarde.";
								break;
								case 2:
									$rechazado = $orden->rechazarOrdenS($_GET['idOrden'],$_SESSION['nombr3']);
									if($rechazado>0){
										$correo->enviarCorreoCapturistaRechazadoDeSupervisor($capturista[2],$_GET['idOrden']);
										echo "Orden rechazada y notificada al capturista";
									}
									else
										echo "No se logró completar el rechazo, intente nuevamente más tarde.";
								break;
								case 4:
									$rechazado = $orden->rechazarOrdenGerenteAdministrativo($_GET['idOrden'],$_SESSION['nombr3']);
									if($rechazado>0){
										$correo->enviarCorreoCapturistaRechazadoDeGerenteAdm($capturista[2],$_GET['idOrden']);
										echo "Orden rechazada y notificada al capturista";
									}
									else
										echo "No se logró completar el rechazo, intente nuevamente más tarde.";
								break;
								case 6:
									$rechazado = $orden->rechazarOrdenSA($_GET['idOrden']);
									if($rechazado>0){
										$correo->enviarCorreoCapturistaNoCompraDeSupervisor($correoCapturista[2],$_GET['idOrden']);
										echo "Orden rechazada y notificada al capturista";
									}
									else
										echo "No se logró completar el rechazo, intente nuevamente más tarde.";
								break;
							}								
						}
						else
							echo "";
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
		if (!ereg("^[0-9]+.*([0-9]*)$",$numeros))
			return FALSE; 
		else
			return TRUE; 
	}
	
	// verificar unidad de la tabla
	function verificarUnidad($unidad){
		$orden = new orden();
		$idUnidad = $orden->obtenerTipoUnidad($unidad);
		if($idUnidad>0)
			return $idUnidad[0];
		else
			return 0;
	}
?>