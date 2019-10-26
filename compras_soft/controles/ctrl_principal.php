<?php
//********************* control para manipular todo lo del menú ****************
	session_start();
	include("../classes/usuario.php");
	include("../classes/orden.php");
	
	if(!empty($_SESSION['c0rr3ito']) && $_SERVER["REQUEST_METHOD"]=="GET") {	
		$checando = @$_GET["operacion"]; 
		if(!empty($checando)){
			switch ($_GET["operacion"]){
				//metodo para mostrar bienvenida
				case "bienvenida":
					if(!empty($_SESSION['t1poU'])){
						switch ($_SESSION['t1poU']){
							case 2: // gerente de departamento
								$hbien = "<div id='content_center'><h2>Bienvenido ".$_SESSION['nombr3']."</h2> <br />
								<p>Podrá realizar alta de órdenes y visualizarlas a través del menú de la 
								izquierda.<br />Además podrá realizar la edición y aprobación de las ordenes de su departamento.</p> <br /><br /><br /><br />";
								echo $hbien;
							break;
							case 3: // gerente de compras - Contadora
								$hbien = "<div id='content_center'><h2>Bienvenido ".$_SESSION['nombr3']."</h2> <br />
								<p>Podrá realizar alta de órdenes y visualizarlas a través del menú de la 
								izquierda.<br />Además podrá realizar la edición y aprobación de las ordenes de los departamentos.</p><br />
								<br /><br /><br />";
								echo $hbien;
							break;
							case 4: // administrador
								$hbienvenida = "<div id='content_center'><h2>Bienvenido ".$_SESSION['nombr3']."</h2></div> <br />
								<p>Toda la administración de usuarios y aprobación de 
								órdenes está disponible a través del menú de la 
								izquierda.</p> <br /><br /><br /><br />";
								echo $hbienvenida;
							break;
							case 5: // capturista
								$hbienvenida = "<div id='content_center'><h2>Bienvenido ".$_SESSION['nombr3']."</h2> <br />
								<p>Podrá realizar alta de órdenes y visualizarlas a través del menú de la 
								izquierda.</p> <br /><br /><br /><br />";
								echo $hbienvenida;
							break;
							case 6: // supervisor de compras - Carlos
								$hbien = "<div id='content_center'><h2>Bienvenido ".$_SESSION['nombr3']."</h2> <br />
								<p>Podrá realizar alta de órdenes y visualizarlas a través del menú de la 
								izquierda.<br />Además podrá realizar la edición y aprobación de las ordenes de los departamentos, así como el envío de las cotizaciones al gerente administrativo.</p><br />
								<br /><br /><br />";
								echo $hbien;
							break;
						}
					}
				break;
				
				case "contrasenia":
					$hcontra = "<h2>Cambiar contraseña</h2>
					<div id='login'>												
							<table width='310' border='0'>
								<tr>
									<td colspan=\"2\">&nbsp;</td>
								</tr>
								<tr>
									<td><p><label>Contraseña actual: </label></p></td>
									<td><p><input type='password' id='txtPass0' name='txtPass0' value='00000000' onBlur=\"if(this.value=='')this.value='00000000'\" onFocus=\"if(this.value=='00000000')this.value=''\"></p></td>
								</tr>
								<tr>
									<td><p><label>Contraseña nueva: </label></p></td>
									<td><p><input type='password' id='txtPass1' name='txtPass1' value='11111111' onBlur=\"if(this.value=='')this.value='11111111'\" onFocus=\"if(this.value=='11111111')this.value=''\"></p></td>
								</tr>
								<tr>
									<td><p>
									<label>Confirmar contraseña: </label></p></td>
									<td><p><input type='password' id='txtPass2' name='txtPass2' value='22222222' onBlur=\"if(this.value=='')this.value='22222222'\" onFocus=\"if(this.value=='22222222')this.value=''\"></p></td>
								</tr>
								<tr>
									<td colspan=\"2\">&nbsp;</td>
								</tr>
								<tr>
									<td colspan=\"2\"><p><input type='submit' name='btnActualizarPass' id='btnActualizarPass' value='Actualizar' class='btnGenerico'></p></td>
								</tr>
								<tr>
									<td colspan=\"2\">&nbsp;</td>
								</tr>
							</table>
					</div> 
					";
					echo $hcontra;
				break;
				
				case "altaOrden":
					$orden = new orden();
					$unidades = $orden->obtenerUnidades();
					$hcontenido="";
					$hcontra = "<h2>Alta de orden</h2>
							<table width='360' border='0'>
								<tr>
									<td colspan='4'>&nbsp;</td>
								</tr>
								<tr>
									<td><p><label>Lugar donde se utilizará: </label></p></td>
									<td><input type='text' id='txtLugar' name='txtLugar' value='Lugar' onBlur=\"if(this.value=='')this.value='Lugar'\" onFocus=\"if(this.value=='Lugar')this.value=''\"></td>
								</tr>
								<tr>
									<td><p><label>Cantidad: </label></p></td>
									<td><input type='number' id='txtCantidad' name='txtCantidad' value='0' onBlur=\"if(this.value=='')this.value='0'\" onFocus=\"if(this.value=='0')this.value=''\"></td>
								</tr>
								<tr>
									<td><p><label>Tipo de unidad: </label></p></td>
									<td><select name='selUnidad' id='selUnidad'>";
									foreach ($unidades as $row){
									  $hcontenido= $hcontenido."<option value='".$row[0]."'>".$row[1]."</option>";
									}
									 $hcontra = $hcontra."".$hcontenido."</select></td>
								</tr>
								<tr>
									<td><p><label>Descripción de material: </label></p></td>
									<td colspan='2'><textarea name='txtDescripcion' cols='16' rows='2' id='txtDescripcion'></textarea></td>
								</tr>
								<tr>
									<td colspan='2'><p>
									  <input type='submit' name='btnAgregarPartida' id='btnAgregarPartida' value='Agregar partida' class='btnGenerico'>
									</p></td>
								</tr>
								<tr>
									<td colspan='2'>&nbsp;</td>
								</tr>
							</table>
					
					<table id='tabla1'>
						<tbody class=fila-base>
							<tr>
								<td style='width:20px;'></td>
								<td style='width:22px;'></td>
								<td></td>
								<td></td>
								<td style='width:10px;' class='btnEliminaF'><button style='cursor:pointer'><img src='images/eliminar.png' title='Eliminar fila'></button></td>
							</tr>
						</tbody>
					</table>
					
					<table id='hTblPartidas' class='zebra' width='600'>
						<thead>
							<tr>
								<th style='width:20px'>Cantidad</th><th>Unidad</th><th>Descripcion</th><th>Lugar</th><th style='width:30px'></th>
							</tr>
						</thead>
						<tbody>							
						</tbody>
					</table>
					
					<table width='600' border='0'>	
						<tr>
							<td colspan='4'>&nbsp;</td>
						</tr>
						<tr>
							<td style='width:100px'><p><strong>Observaciones: </strong></p> </td>
							<td colspan='2'><textarea name='txtDescripcionO' cols='35' rows='2' id='txtDescripcionO'></textarea></td>
							<td style='width:20px'><p><input type='submit' name='btnEnviarOrden' id='btnEnviarOrden' value='Enviar orden' class='btnGenerico'></p></td>
						</tr>
					</table>
					<br />
					";
					echo $hcontra;
				break;
				
				case "consultarMO":
					$orden = new orden();
					$ordenes = $orden->obtenerMisOrdenes($_SESSION['id3ntificador']);
					$hcont = "<h2>Consulta de mis órdenes</h2>
						<br />
						<div id='idUsuarios'>
						<table id='hTblMisOrdenes' class='zebra'>
							<thead><tr><th>Folio</th><th>Nombre Trabajador</th><th>Fecha y hora</th><th>Estado</th><th>PDF</th></tr></thead>";
							foreach ($ordenes as $row){
								switch ($row[2]){
									case 1:
										$row[2]="En espera";
									break;
									case 2:
										$row[2]="Aprobada por Departamento";
									break;
									case 3:
										$row[2]="Rechazada por Departamento";
									break;
									case 4:
										$row[2]="Aprobada por Sup. de Compras";
									break;
									case 5:
										$row[2]="Rechazada por Sup. de Compras";
									break;
									case 6:
										$row[2]="Aprobada por G. administrativo";
									break;
									case 7:
										$row[2]="Rechazada por G. administrativo";
									break;
									case 8:
										$row[2]="Compra en proceso";
									break;
									case 9:
										$row[2]="Orden rechazada";
									break;
								}
								$hcont =$hcont."<tr>
								<td>".$row[0]."</td><td>".$_SESSION['nombr3']."</td><td>".$row[1]."</td><td>".$row[2]
								."</td><td style='width:10px;' class='btnObtenerPDF'><button style='cursor:pointer'><img src='images/pdf.png' title='ObtenerPDF'></button></td></tr>";																		
							}
							$hcont=$hcont."</table></div><br />";
					echo $hcont;
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