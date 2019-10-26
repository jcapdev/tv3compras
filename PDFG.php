<?php 
	session_start();
	include("classes/usuario.php");
	include("classes/orden.php");
	include_once('classes/PDF.php');
	
	if(!empty($_SESSION['c0rr3ito'])) {
		if(!empty($_SESSION['t1poU'])){
			switch ($_SESSION['t1poU']){
				case 2: // gerente de departamento					
					if(!empty($_SESSION['t1poU2']) && $_SESSION['t1poU2']==5){
						$orden = new orden();
						$depto = $orden->obtenerDepartamento($_SESSION['d3p4rtament0']);
						$datosOrden = $orden->obtenerMiOrden($_SESSION['idOrden3legida'],$_SESSION['FechaH0ra'],$_SESSION['id3ntificador']);
						$articulos = $orden->obtenerArticulos($_SESSION['idOrden3legida']);
						$pdf = new PDF('L','mm','Letter');	
						$pdf->AddPage();
						$pdf->tablaHorizontal($datosOrden,$articulos,$depto);
						unset( $_SESSION['t1poU2'] );
						$pdf->Output(); //Salida al navegador
					}
					else{
						$orden = new orden();
						$depto = $orden->obtenerDepartamento($_SESSION['d3p4rtament0']);
						$datosOrden = $orden->obtenerOrdenDepto($_SESSION['idOrden3legida'],$_SESSION['d3p4rtament0'],$_SESSION['FechaH0ra']);
						$articulos = $orden->obtenerArticulos($_SESSION['idOrden3legida']);
						$pdf = new PDF('L','mm','Letter');	 
						$pdf->AddPage();
						$pdf->tablaHorizontal($datosOrden,$articulos,$depto);
						$pdf->Output(); //Salida al navegador
					}
				break;
				case 3: // gerente de compras - Contadora
					if(!empty($_SESSION['t1poU2']) && $_SESSION['t1poU2']==5){
						$orden = new orden();
						$depto = $orden->obtenerDepartamento($_SESSION['d3p4rtament0']);
						$datosOrden = $orden->obtenerMiOrden($_SESSION['idOrden3legida'],$_SESSION['FechaH0ra'],$_SESSION['id3ntificador']);
						$articulos = $orden->obtenerArticulos($_SESSION['idOrden3legida']);
						$pdf = new PDF('L','mm','Letter');	
						$pdf->AddPage();
						$pdf->tablaHorizontal($datosOrden,$articulos,$depto);
						unset( $_SESSION['t1poU2'] );
						$pdf->Output(); //Salida al navegador
					}
					else{
						$orden = new orden();
						$datosOrden = $orden->obtenerOrdenGerenteAdministrativo($_SESSION['idOrden3legida'],$_SESSION['FechaH0ra']);
						$articulos = $orden->obtenerArticulosGerenteAdministrativo($_SESSION['idOrden3legida']);
						$pdf = new PDF('L','mm','Letter');
						$pdf->AddPage();
						$pdf->tablaHorizontalSupCompras($datosOrden,$articulos);
						$pdf->Output(); //Salida al navegador
					}
				break;
				case 4: // administrador
					if(!empty($_SESSION['t1poU2']) && $_SESSION['t1poU2']==5){
						$orden = new orden();
						$depto = $orden->obtenerDepartamento($_SESSION['d3p4rtament0']);
						$datosOrden = $orden->obtenerMiOrden($_SESSION['idOrden3legida'],$_SESSION['FechaH0ra'],$_SESSION['id3ntificador']);
						$articulos = $orden->obtenerArticulos($_SESSION['idOrden3legida']);
						$pdf = new PDF('L','mm','Letter');	 
						$pdf->AddPage();
						$pdf->tablaHorizontal($datosOrden,$articulos,$depto);
						unset( $_SESSION['t1poU2'] );
						$pdf->Output(); //Salida al navegador
					}
					else{
						$orden = new orden();
						$datosOrden = $orden->obtenerOrdenAdministrador($_SESSION['idOrden3legida'],$_SESSION['FechaH0ra']);
						$articulos = $orden->obtenerArticulosSupervisorCompras($_SESSION['idOrden3legida']);
						$pdf = new PDF('L','mm','Letter');
						$pdf->AddPage();
						$pdf->tablaHorizontalSupCompras($datosOrden,$articulos);
						$pdf->Output(); //Salida al navegador
					}
				break;
				case 5: // capturista
					$orden = new orden();
					$depto = $orden->obtenerDepartamento($_SESSION['d3p4rtament0']);
					$datosOrden = $orden->obtenerMiOrden($_SESSION['idOrden3legida'],$_SESSION['FechaH0ra'],$_SESSION['id3ntificador']);
					$articulos = $orden->obtenerArticulos($_SESSION['idOrden3legida']);
					$pdf = new PDF('L','mm','Letter');	 
					$pdf->AddPage();
					$pdf->tablaHorizontal($datosOrden,$articulos,$depto);
					$pdf->Output(); //Salida al navegador
				break;
				case 6: // supervisor de compras - Carlos
					if(!empty($_SESSION['t1poU2']) && $_SESSION['t1poU2']==5){
						$orden = new orden();
						$depto = $orden->obtenerDepartamento($_SESSION['d3p4rtament0']);
						$datosOrden = $orden->obtenerMiOrden($_SESSION['idOrden3legida'],$_SESSION['FechaH0ra'],$_SESSION['id3ntificador']);
						$articulos = $orden->obtenerArticulos($_SESSION['idOrden3legida']);
						$pdf = new PDF('L','mm','Letter');	
						$pdf->AddPage();
						$pdf->tablaHorizontal($datosOrden,$articulos,$depto);
						unset( $_SESSION['t1poU2'] );
						$pdf->Output(); //Salida al navegador
					}
					else if(!empty($_SESSION['t1poU2']) && $_SESSION['t1poU2']==1){
						$orden = new orden();
						$datosOrden = $orden->obtenerOrdenAprobada($_SESSION['idOrden3legida'],$_SESSION['FechaH0ra']);
						$articulos = $orden->obtenerArticulosSupervisorCompras($_SESSION['idOrden3legida']);
						$pdf = new PDF('L','mm','Letter');
						$pdf->AddPage();
						$pdf->tablaHorizontalSupCompras($datosOrden,$articulos);
						$pdf->Output(); //Salida al navegador
					}
					else{
						$orden = new orden();
						$datosOrden = $orden->obtenerOrdenSupervisorCompras($_SESSION['idOrden3legida'],$_SESSION['FechaH0ra']);
						$articulos = $orden->obtenerArticulosSupervisorCompras($_SESSION['idOrden3legida']);
						$pdf = new PDF('L','mm','Letter');
						$pdf->AddPage();
						$pdf->tablaHorizontalSupCompras($datosOrden,$articulos);
						$pdf->Output(); //Salida al navegador
					}
				break;
			}
		}
	}
	else{
		exit;
	}
?>