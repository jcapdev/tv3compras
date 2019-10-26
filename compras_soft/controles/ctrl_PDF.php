<?php 
	session_start();
	
	if(!empty($_SESSION['c0rr3ito'])) {
		if(!empty($_SESSION['t1poU'])){
			switch ($_SESSION['t1poU']){
				case 2: // gerente de departamento				
					if(!empty($_GET['idOrden']) && !empty($_GET['fechaHora'])){
						if(!empty($_GET['operacion'])){
							if($_GET['operacion']=='generarPDFDepto'){
								$_SESSION['idOrden3legida'] = $_GET['idOrden'];
								$_SESSION['FechaH0ra'] = $_GET['fechaHora'];
								echo "PDFG.php";
							}
						}
						else{
							$_SESSION['idOrden3legida'] = $_GET['idOrden'];
							$_SESSION['FechaH0ra'] = $_GET['fechaHora'];
							$_SESSION['t1poU2'] = 5;
							echo "PDFG.php";
						}
					}					
					else
						echo "PDFG.php";
					
				break;
				case 3: // gerente administrativo - Contadora
					if(!empty($_GET['idOrden']) && !empty($_GET['fechaHora'])){
						if(!empty($_GET['operacion'])){
							if($_GET['operacion']=='generarPDFDeptos'){
								$_SESSION['idOrden3legida'] = $_GET['idOrden'];
								$_SESSION['FechaH0ra'] = $_GET['fechaHora'];
								echo "PDFG.php";
							}
							echo "";
						}
						else{
							$_SESSION['idOrden3legida'] = $_GET['idOrden'];
							$_SESSION['FechaH0ra'] = $_GET['fechaHora'];
							$_SESSION['t1poU2'] = 5;
							echo "PDFG.php";
						}
					}					
					else
						echo "PDFG.php";
				break;
				case 4: // administrador
					if(!empty($_GET['idOrden']) && !empty($_GET['fechaHora'])){
						if(!empty($_GET['operacion'])){
							if($_GET['operacion']=='generarPDF'){
								$_SESSION['idOrden3legida'] = $_GET['idOrden'];
								$_SESSION['FechaH0ra'] = $_GET['fechaHora'];
								echo "PDFG.php";
							}
						}
						else{
							$_SESSION['idOrden3legida'] = $_GET['idOrden'];
							$_SESSION['FechaH0ra'] = $_GET['fechaHora'];
							$_SESSION['t1poU2'] = 5;
							echo "PDFG.php";
						}
					}
					else
						echo "";
				break;
				case 5: // capturista
					if(!empty($_GET['idOrden']) && !empty($_GET['fechaHora'])){
						$_SESSION['idOrden3legida'] = $_GET['idOrden'];
						$_SESSION['FechaH0ra'] = $_GET['fechaHora'];
						echo "PDFG.php";
					}
				break;
				case 6: // supervisor de compras - Carlos
					if(!empty($_GET['idOrden']) && !empty($_GET['fechaHora'])){
						if(!empty($_GET['operacion'])){
							if($_GET['operacion']=='generarPDFDeptos'){
								$_SESSION['idOrden3legida'] = $_GET['idOrden'];
								$_SESSION['FechaH0ra'] = $_GET['fechaHora'];
								echo "PDFG.php";
							}
							
							if($_GET['operacion']=='generarPDFAprobada'){
								$_SESSION['idOrden3legida'] = $_GET['idOrden'];
								$_SESSION['FechaH0ra'] = $_GET['fechaHora'];
								$_SESSION['t1poU2'] = 1;
								echo "PDFG.php";
							}
						}
						else{
							$_SESSION['idOrden3legida'] = $_GET['idOrden'];
							$_SESSION['FechaH0ra'] = $_GET['fechaHora'];
							$_SESSION['t1poU2'] = 5;
							echo "PDFG.php";
						}
					}					
					else
						echo "PDFG.php";
				break;
			}
		}
	}
	else{
		header("Location: index.php");
		exit;
	}
?>