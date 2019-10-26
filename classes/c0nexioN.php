<?php
	class conection{
		protected $pdo;
		
		protected function conectar(){
			//return $this->pdo = new PDO('mysql:dbname=compras;host=localhost', 'root', 'root');	
			//return $this->pdo = new PDO('mysql:host=localhost;dbname=tvpuenet_compras', 'tvpuenet_admon', 'CoMpRaS$2014');
			return $this->pdo = new PDO('mysql:host=localhost;dbname=tvpuenet_compras', 'root', '');
		}
	}
?>