<?php
	//require ("c0nexioN.php"); //uso obligatorio para el funcionamiento
	
	class orden extends conection{
		private $ordenes;
		private $rows;	
		private $conexion;
		
		public function __construct(){
			$this->conexion = parent::conectar(); //creo una variable con la conexión
			return $this->conexion;				  //retorna la variable de conexión					
		}
		
		//********* metodo para obtener las unidades de medida para articulos de peticiones ***********
		public function obtenerUnidades(){
			$statement = $this->conexion -> prepare("CALL obtener_unidades()");
			$statement -> execute();
			return $statement->fetchAll(PDO::FETCH_NUM);
		}
		
		//********* metodo para obtener el identificador de la unidad solicitada ***********
		public function obtenerTipoUnidad($unidad){
			$statement = $this->conexion -> prepare("CALL obtener_tipo_unidad('$unidad')");
			$statement -> execute();
			return $statement->fetch(PDO::FETCH_NUM);
		}
		
		//********* metodo para obtener el estado de la orden ***********
		public function obtenerEstadoOrden($idOrden){
			$statement = $this->conexion -> prepare("CALL obtener_estado_orden($idOrden)");
			$statement -> execute();
			return $statement->fetch(PDO::FETCH_NUM);
		}
		
		//********* metodo para dar de alta la orden **********
		public function altaOrden($descripcion,$idUsuario){
			$conex = $this->conexion;
			$statement = $conex->prepare("CALL alta_orden('$descripcion','$idUsuario')");
			$statement->execute();
			$var = $statement->fetch(PDO::FETCH_NUM);
			return $var[0];
		}
		
		//********* alta de articulo **********
		public function altaArticulo($cantidad,$idUnidad,$descripcion,$idOrden,$lugar){
			$statement = $this->conexion->prepare("CALL alta_articulo('$cantidad','$idUnidad','$descripcion','$idOrden','$lugar')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//********* metodo para obtener todas las ordenes de un cierto usuario **********
		public function obtenerMisOrdenes($idUsuario){
			$statement = $this->conexion -> prepare("CALL obtener_mis_ordenes('$idUsuario')");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetchAll(PDO::FETCH_NUM);
		}
		
		//********* metodo para obtener todas las ordenes de capturista, que serán aprobadas por 
		//********* el jefe de departamento
		public function obtenerOrdenesDepartamento($depto){
			$statement = $this->conexion -> prepare("CALL obtener_ordenes_departamento('$depto')");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetchAll(PDO::FETCH_NUM);
		}
		
		//********* metodo para obtener la orden solicitada de departamento
		public function obtenerOrdenDepto($idDepto,$idOrden,$fechaHora){
			$statement = $this->conexion -> prepare("CALL obtener_orden_departamento('$idDepto','$idOrden','$fechaHora')");
			$statement -> execute();
			return $statement->fetch(PDO::FETCH_NUM);
		}
		
		//********* metodo para obtener la orden solicitada
		public function obtenerMiOrden($idOrden,$fechaHora,$idUsuario){
			$statement = $this->conexion -> prepare("CALL obtener_mi_orden('$idOrden','$fechaHora','$idUsuario')");
			$statement -> execute();
			return $statement->fetch(PDO::FETCH_NUM);
		}
		
		//********* metodo para obtener los articulos de una orden determinada ******
		public function obtenerArticulos($idOrden){
			$statement = $this->conexion -> prepare("CALL obtener_articulos_orden('$idOrden')");
			$statement -> execute();
			return $statement->fetchAll(PDO::FETCH_NUM);
		}
				
		//******** metodo para obtener el departamento dado su id *******
		public function obtenerDepartamento($idDepto){
			$statement = $this->conexion -> prepare("CALL obtener_departamento('$idDepto')");
			$statement -> execute();
			return $statement->fetch(PDO::FETCH_NUM);
		}
		
		//******* metodo para obtener el correo del gerente de departamento ******
		public function obtenerCorreoGerenteDepto($idDepto){
			$statement = $this->conexion -> prepare("CALL obtener_correo_gerente_depto('$idDepto')");
			$statement -> execute();
			return $statement->fetch(PDO::FETCH_NUM);
		}
		
		//****** metodo para agregar observacion *******
		public function agregarObservacion($idOrden,$observacion,$nombreUsuario){
			$observacion = "".$nombreUsuario.": ".$observacion.".";
			$statement = $this->conexion->prepare("CALL cambiar_orden_observacion('$idOrden','$observacion')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//****** metodo para aprobar orden Gerente departamento*******
		public function aprobarOrdenG($idOrden,$usuario){
			if($_SESSION['t1poU']==4)
				$observacion = "Ha aprobado la orden :".$usuario.".";
			else
				$observacion = "Ha aprobado la orden :".$usuario.".";
				
			$statement = $this->conexion->prepare("CALL aprobar_orden_gerente('$idOrden','$observacion')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//****** metodo para rechazar orden Gerente departamento*******
		public function rechazarOrdenG($idOrden,$usuario){
			if($_SESSION['t1poU']==4)
				$observacion = "Ha rechazado la orden :".$usuario.".";
			else
				$observacion = "Ha rechazado la orden :".$usuario.".";
			$statement = $this->conexion->prepare("CALL rechazar_orden_gerente('$idOrden','$observacion')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//****** actualizar articulo *******
		public function actualizarArticulo($idArticulo,$cantidad,$descripcion,$lugar,$idOrden){
			$statement = $this->conexion->prepare("CALL cambiar_articulo('$idArticulo','$cantidad','$descripcion','$lugar','$idOrden')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//********* metodo para obtener todas las ordenes de los departamentos, que serán aprobadas por 
		//********* el supervisor de compras
		public function obtenerOrdenesSupervisorCompras(){
			$statement = $this->conexion -> prepare("CALL obtener_ordenes_sup_compras()");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetchAll(PDO::FETCH_NUM);
		}
		
		//********* metodo para obtener la orden solicitada para el supervisor de compras
		public function obtenerOrdenSupervisorCompras($idOrden,$fechaHora){
			$statement = $this->conexion -> prepare("CALL obtener_orden_sup_compras('$idOrden','$fechaHora')");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetch(PDO::FETCH_NUM);
		}
		
		//********* metodo para obtener los articulos de una orden determinada para supervisor de compras ******
		public function obtenerArticulosSupervisorCompras($idOrden){
			$statement = $this->conexion -> prepare("CALL obtener_articulos_orden_sup_compras('$idOrden')");
			$statement -> execute();
			return $statement->fetchAll(PDO::FETCH_NUM);
		}
		
		//****** actualizar articulo para supervisor de compras *******
		public function actualizarArticuloSupCompras($idArticulo,$cantidad,$descripcion,$lugar,$precioU,$cuenta,$proveedor){
			$statement = $this->conexion->prepare("CALL cambiar_articulo_sup_compras('$idArticulo','$cantidad','$descripcion',
													'$lugar','$precioU','$cuenta','$proveedor')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//****** metodo para aprobar orden Supervisor de compras *******
		public function aprobarOrdenS($idOrden,$nombreSupervisor){
			if($_SESSION['t1poU']==4)
				$observacion = "Ha aprobado la orden ".$nombreSupervisor.".";
			else
				$observacion = "Ha aprobado la orden ".$nombreSupervisor.".";
			$statement = $this->conexion->prepare("CALL aprobar_orden_sup_compras('$idOrden','$observacion')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//****** metodo para rechazar orden supervisor de compras *******
		public function rechazarOrdenS($idOrden,$usuario){
			if($_SESSION['t1poU']==4)
				$observacion = "Ha rechazado la orden ".$usuario.".";
			else
				$observacion = "Ha rechazado la orden ".$usuario.".";
			$statement = $this->conexion->prepare("CALL rechazar_orden_sup_compras('$idOrden','$observacion')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//****** metodo para aprobar orden Supervisor de compras *******
		public function aprobarOrdenSA($idOrden){
			if($_SESSION['t1poU']==4)
				$observacion = " La orden se encuentra en proceso de compra. Aprobada por Administrador del sistema.";
			else
				$observacion = " La orden se encuentra en proceso de compra.";
			$statement = $this->conexion->prepare("CALL aprobar_orden('$idOrden','$observacion')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//****** metodo para rechazar orden supervisor de compras *******
		public function rechazarOrdenSA($idOrden){
			if($_SESSION['t1poU']==4)
				$observacion = " La orden fue rechazada y no procedera. Rechazada por Administrador del sistema.";
			else
				$observacion = " La orden fue rechazada y no procedera.";
			$statement = $this->conexion->prepare("CALL rechazar_orden('$idOrden','$observacion')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//********* metodo para obtener todas las ordenes de los departamentos, aprobadas previamente por
		//********* el supervisor de compras
		public function obtenerOrdenesGerenteAdministrativo(){
			$statement = $this->conexion -> prepare("CALL obtener_ordenes_gerente_adm()");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetchAll(PDO::FETCH_NUM);
		}
		
		//********* metodo para obtener la orden solicitada para el gerente administrativo
		public function obtenerOrdenGerenteAdministrativo($idOrden,$fechaHora){
			$statement = $this->conexion -> prepare("CALL obtener_orden_gerente_adm('$idOrden','$fechaHora')");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetch(PDO::FETCH_NUM);
		}
		
		//********* metodo para obtener los articulos de una orden determinada para supervisor de compras ******
		public function obtenerArticulosGerenteAdministrativo($idOrden){
			$statement = $this->conexion -> prepare("CALL obtener_articulos_orden_sup_compras('$idOrden')");
			$statement -> execute();
			return $statement->fetchAll(PDO::FETCH_NUM);
		}
		
		//****** metodo para aprobar orden Supervisor de compras *******
		public function aprobarOrdenGerenteAdministrativo($idOrden,$nombreSupervisor){
			if($_SESSION['t1poU']==4)
				$observacion = "Ha aprobado la orden".$nombreSupervisor.".";
			else
				$observacion = "Ha aprobado la orden".$nombreSupervisor.".";
			$statement = $this->conexion->prepare("CALL aprobar_orden_gerente_adm('$idOrden','$observacion')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//****** metodo para rechazar orden supervisor de compras *******
		public function rechazarOrdenGerenteAdministrativo($idOrden,$usuario){
			if($_SESSION['t1poU']==4)
				$observacion = "Ha rechazado la orden ".$usuario.".";
			else
				$observacion = "Ha rechazado la orden".$usuario.".";
			$statement = $this->conexion->prepare("CALL rechazar_orden_gerente_adm('$idOrden','$observacion')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//********* metodo para obtener todas las ordenes de los departamentos, aprobadas por 
		//********* el gerente administrativo
		public function obtenerOrdenesAprobadas(){
			$statement = $this->conexion -> prepare("CALL obtener_ordenes_aprobadas()");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetchAll(PDO::FETCH_NUM);
		}
		
		//********* metodo para obtener la orden solicitada para el supervisor de compras aprobada por
		// ******** gerente administrativo
		public function obtenerOrdenAprobada($idOrden,$fechaHora){
			$statement = $this->conexion -> prepare("CALL obtener_orden_aprobada('$idOrden','$fechaHora')");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetch(PDO::FETCH_NUM);
		}
		
		
		/****** Métodos de administrador *********/
		//********* metodo para obtener todas las ordenes ********
		public function obtenerTOrdenes(){
			$statement = $this->conexion -> prepare("CALL obtener_todas_ordenes()");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetchAll(PDO::FETCH_NUM);
		}
		
		//********** método para obtener la informacion de la orden seleccionada ******
		public function obtenerOrdenAdministrador($idOrden,$fechaHora){
			$statement = $this->conexion -> prepare("CALL obtener_orden_administrador('$idOrden','$fechaHora')");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetch(PDO::FETCH_NUM);
		}
		
	}	
?>