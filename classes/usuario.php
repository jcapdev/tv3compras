<?php
	require ("c0nexioN.php"); //uso obligatorio para el funcionamiento
	
	class usuario extends conection{
		private $usuarios;
		private $rows;	
		private $conexion;
		
		public function __construct(){
			$this->conexion = parent::conectar(); //creo una variable con la conexión
			return $this->conexion;				  //retorna la variable de conexión					
		}
		
		//********* metodo para obtener el login ***********
		public function obtenerLogin($mail,$pass){
			$statement = $this->conexion -> prepare("CALL obtener_login('$mail','$pass')");
			$statement -> execute();
			$this->rows=$statement->fetch(PDO::FETCH_NUM);
			return $this->rows;
		}
		
		//******** metodo para obtener password********
		public function obtenerPass($mail){
			$statement = $this->conexion -> prepare("CALL obtener_login_pass('$mail')");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetch(PDO::FETCH_NUM);
		}
		
		//********* método para cambiar el token de seguridad ******		
		public function cambiarToken($mail, $token){
			$statement = $this->conexion->prepare("CALL cambiar_token('$mail','$token')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//********* método para aumentar intentos ******** 
		public function aumentarIntentos($mail){
			$statement = $this->conexion->prepare("CALL aumentar_intentos('$mail')");
			$statement -> execute();
			return $statement->fetch(PDO::FETCH_NUM);
		}
		
		//********* reiniciar intentos **********
		public function reiniciarIntentos($mail){
			$statement = $this->conexion->prepare("CALL cambiar_intentos('$mail')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//********* metodo para cambiar contraseña ***********
		public function cambiarContrasenia($mail,$pass){
			$statement = $this->conexion->prepare("CALL cambiar_contrasenia('$mail','".md5($pass)."')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//********** metodo para dar de alta nuevo usuario ************
		public function altaUsuario($nTrabajador, $nombre, $pass, $mail, $tUsuario, $departamento, $estado){
			$statement = $this->conexion->prepare("CALL alta_usuario('$nTrabajador','$nombre','
													$pass','$mail','$tUsuario','$departamento','$estado')");
			$statement->execute();
			return $statement->rowCount();
		}
		
		//********* metodo para obtener todos los usuarios **********
		public function obtenerUsuarios(){
			$statement = $this->conexion -> prepare("CALL obtener_usuarios()");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetchAll(PDO::FETCH_NUM);
		}
		
		//********* metodo para buscar usuario **********
		public function buscarUsuario($busqueda){
			$statement = $this->conexion -> prepare("CALL buscar_usuario('$busqueda')");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetchAll(PDO::FETCH_NUM);
		}
		
		//********* metodo para obtener informacion de usuario **********
		public function obtenerUsuario($id_usuario){
			$statement = $this->conexion -> prepare("CALL obtener_usuario('$id_usuario')");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetch(PDO::FETCH_NUM);
		}
		
		//********* metodo para cambiar usuario ***********
		public function cambiarUsuario($id_usuario, $nTrabajador, $nombre, $mail, $tUsuario, $departamento, $estado){
			$statement = $this->conexion->prepare("CALL cambiar_usuario('$id_usuario','$nTrabajador','$nombre',
													'$mail','$tUsuario','$departamento','$estado')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//********* metodo para cambiar contraseña de usuario ***********
		public function cambiarContraseniaU($id_usuario,$pass){
			$statement = $this->conexion->prepare("CALL cambiar_contrasenia_usuario('$id_usuario','".md5($pass)."')");
			$statement -> execute();
			return $statement->rowCount();
		}
		
		//******** metodo para obtener correo de gerente de departamento ********
		public function obtenerCorreoGerenteDepto($departamento){
			$statement = $this->conexion -> prepare("CALL obtener_correo_gerente_depto('$departamento')");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetch(PDO::FETCH_NUM);
		}
		
		//******** metodo para obtener correo de supervisor de compras ********
		public function obtenerCorreoSupervisorC(){
			$statement = $this->conexion -> prepare("CALL obtener_correo_supervisor_c()");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetch(PDO::FETCH_NUM);
		}
		
		//******** metodo para obtener correo de gerente administrativo ********
		public function obtenerCorreoGerenteAdm(){
			$statement = $this->conexion -> prepare("CALL obtener_correo_gerente_adm()");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetch(PDO::FETCH_NUM);
		}
				
		//********* metodo para obtener informacion de usuario en base a su orden **********
		public function obtenerDatosUsuario($idOrden){
			$statement = $this->conexion -> prepare("CALL obtener_datos_usuario('$idOrden')");
			$statement -> execute();
			// se obtienen todos los datos de la consulta con fetchAll
			return $statement->fetch(PDO::FETCH_NUM);
		}
	}
?>