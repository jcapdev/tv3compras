<?php
//********************* control para manipular todo lo del menú ****************
	session_start();
	include("../classes/usuario.php");
	include("../classes/orden.php");
	
	if(!empty($_SESSION['c0rr3ito']) && $_SERVER["REQUEST_METHOD"]=="GET") {	
		if($_SESSION['t1poU']==3){
			$checando = @$_GET["operacion"]; 
			if(!empty($checando)){
				switch ($_GET["operacion"]){
					case "consultarOrdenesDeptos":
						$orden = new orden();
						$ordenes = $orden->obtenerOrdenesGerenteAdministrativo();
						if($ordenes!=null){
							$hcont = "<h2>Consulta de órdenes de departamentos para aprobar</h2>
								<br />
								<div id='idOrdenes'>
								<table id='hTblOrdenesAprobar' class='zebra'>
									<thead><tr><th style='width:20px;'>Folio</th><th>Nombre Trabajador</th><th>Departamento</th><th>Fecha y hora</th><th></th></tr></thead>";
									foreach ($ordenes as $row){
										$hcont =$hcont."<tr>
										<td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]
										."</td><td>".$row[3]."</td><td style='width:10px'><button class='btnInfoOrden' id=btnInfoOrden id='btnInfoOrden' value=".$row[0]." style='cursor:pointer'><img src='images/mas.png' title='Información de orden'></td></tr>";
									}
								$hcont=$hcont."</table></div><br />";
							echo $hcont;
						}
						else{
							$hcont = "<h2>Consulta de órdenes de departamentos para aprobar</h2>
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