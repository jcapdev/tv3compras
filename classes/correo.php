<?php
	class correo {
		private $desde;
		
		function __construct(){
			$this->desde = "From: compras_televisa"."\n"."Bcc: aesco404@gmail.com"."\n".'MIME-Version: 1.0' . "\r\n".'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		}
		
		///***** ENVIOS DE CORREOS DEL CAPTURISTA******///
		
		//****** método para enviar correo al capturista, una vez que ha enviado su orden ******/
		public function enviarCorreoCapturista($correoCapturista, $mensaje, $folio){						
			$msj = "<table><tr><td>Usted ha enviado una nueva petici&oacute;n para ser procesada. El estado de la orden podr&aacute; ser visualizado a trav&eacute;s del men&uacute;: Gesti&oacute;n de &oacute;rdenes/Consultar mis &oacute;rdenes</td></tr> 
			<tr><td>El folio es: <strong>".$folio."</strong></td></tr><tr><td>Los art&iacute;culos son: </td></tr></table>";			
			$msj = $msj.$mensaje."</table>";	
			$asunto = "Nueva orden solicitada con folio ".$folio;		
			mail($correoCapturista, $asunto, $msj, $this->desde);
		}
		
		//***** método para enviar correo al gerente, una vez que el capturista ha realizado su orden *****/
		public function enviarCorreoGerenteDeCapturista($correoGerente, $nombreCapturista, $mensaje, $folio){			
			$msj = "<table><tr><td>Se ha registrado una nueva petici&oacute;n para que usted la atienda.</td></tr> 
			<tr><td>El folio es: <strong>".$folio."</strong></td></tr><tr><td>Los art&iacute;culos son: </td></tr></table>";			
			$msj = $msj.$mensaje."</table>";
			$asunto = "Nueva orden de: ".$nombreCapturista;				
			mail($correoGerente, $asunto, $msj, $this->desde);
		}
		
		
		//******* ENVÍO DE CORREOS DEL GERENTE DE DEPARTAMENTO ******//
		
		//***** método para enviar correo a supervisor de compras por parte del gerente ****/
		public function enviarCorreoSupervisorComprasDeGerente($correoSupervisor, $nombreCapturista, $departamento, $folio){
			$msj = "<table><tr><td>Se ha aprobado una nueva petici&oacute;n para que usted la atienda, del departamento: ".$departamento.".</td></tr> 
			<tr><td>El capturista es: <strong>".$nombreCapturista."</strong></td></tr>
			<tr><td>El folio es: <strong>".$folio."</strong></td></tr></table>";
			$asunto = "Nueva orden para revisar, de: ".$nombreCapturista;				
			mail($correoSupervisor, $asunto, $msj, $this->desde);
		}
		
		//***** método para enviar correo al capturista de que fue rechazada su orden por parte del gerente ****/
		public function enviarCorreoCapturistaRechazadoDeGerente($correoCapturista,$folio){						
			$msj = "<table><tr><td>El gerente de departamento ha rechazado su orden con Folio: ".$folio.". El estado de la orden se visualiza a trav&eacute;s del men&uacute;: Gesti&oacute;n de &oacute;rdenes/Consultar mis &oacute;rdenes</td></tr></table>";			
			$asunto = "Orden ".$folio." rechazada";		
			mail($correoCapturista, $asunto, $msj, $this->desde);
		}
		
		
		//******* ENVÍO DE CORREOS DEL SUPERVISOR DE COMPRAS ******//
		
		//***** método para enviar correo a gerente administrativo por parte del supervisor de compras ****/
		public function enviarCorreoGerenteAdmDeSupervisor($correoGerenteAdm, $nombreCapturista, $departamento, $folio){
			$msj = "<table><tr><td>Se ha aprobado una nueva petici&oacute;n para que usted la atienda, del departamento: ".$departamento.".</td></tr> 
			<tr><td>El capturista es: <strong>".$nombreCapturista."</strong></td></tr>
			<tr><td>El folio es: <strong>".$folio."</strong></td></tr></table>";
			$asunto = "Nueva orden para revisar, de: ".$nombreCapturista;				
			mail($correoGerenteAdm, $asunto, $msj, $this->desde);
		}
		
		//***** método para enviar correo al capturista que fue rechazada su orden por parte del gerente ****/
		public function enviarCorreoCapturistaRechazadoDeSupervisor($correoCapturista,$folio){						
			$msj = "<table><tr><td>El supervisor de compras ha rechazado su orden con Folio: ".$folio.". El estado de la orden se visualiza a trav&eacute;s del men&uacute;: Gesti&oacute;n de &oacute;rdenes/Consultar mis &oacute;rdenes</td></tr></table>";			
			$asunto = "Orden ".$folio." rechazada";		
			mail($correoCapturista, $asunto, $msj, $this->desde);
		}
		
		//***** método para enviar correo al capturista que su compra no procederá ****/
		public function enviarCorreoCapturistaNoCompraDeSupervisor($correoCapturista,$folio){						
			$msj = "<table><tr><td>El supervisor de compras ha rechazado su orden con Folio: ".$folio.", la compra no proceder&aacute;. El estado de la orden se visualiza a trav&eacute;s del men&uacute;: Gesti&oacute;n de &oacute;rdenes/Consultar mis &oacute;rdenes</td></tr></table>";			
			$asunto = "Orden ".$folio." rechazada";		
			mail($correoCapturista, $asunto, $msj, $this->desde);
		}
		
		//***** método para enviar correo al capturista que su orden se encuentra en proceso de compra****/
		public function enviarCorreoCapturistaCompraDeSupervisor($correoCapturista,$folio){						
			$msj = "<table><tr><td>El supervisor de compras ha aprobado su orden con Folio: ".$folio.", la compra est&aacute; en proceso. El estado de la orden se visualiza a trav&eacute;s del men&uacute;: Gesti&oacute;n de &oacute;rdenes/Consultar mis &oacute;rdenes</td></tr></table>";			
			$asunto = "Orden ".$folio." aprobada y en proceso de compra";		
			mail($correoCapturista, $asunto, $msj, $this->desde);
		}
		
		
		//******* ENVÍO DE CORREOS DEL GERENTE ADMINISTRATIVO ******//
		
		//***** método para enviar correo a supervisor de compras por parte del gerente ****/
		public function enviarCorreoSupervisorComprasDeGerenteAdm($correoSupervisor, $nombreCapturista, $departamento, $folio){
			$msj = "<table><tr><td>Se ha aprobado una nueva petici&oacute;n para que usted la atienda, del departamento: ".$departamento.".</td></tr> 
			<tr><td>El capturista es: <strong>".$nombreCapturista."</strong></td></tr>
			<tr><td>El folio es: <strong>".$folio."</strong></td></tr></table>";			
			$asunto = "Nueva orden para revisar, de: ".$nombreCapturista;				
			mail($correoSupervisor, $asunto, $msj, $this->desde);
		}
		
		//***** método para enviar correo al capturista de que fue rechazada su orden por parte del gerente ****/
		public function enviarCorreoCapturistaRechazadoDeGerenteAdm($correoCapturista,$folio){						
			$msj = "<table><tr><td>El gerente administrativo ha rechazado su orden con Folio: ".$folio.". El estado de la orden se visualiza a trav&eacute;s del men&uacute;: Gesti&oacute;n de &oacute;rdenes/Consultar mis &oacute;rdenes</td></tr></table>";			
			$asunto = "Orden ".$folio." rechazada";		
			mail($correoCapturista, $asunto, $msj, $this->desde);
		}				
	}
?>