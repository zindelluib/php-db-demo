<?php
	
	define('CONNECTION_STR', 'mysql:host=localhost;dbname=dbdemo');
	define('USER','root');
	define('PASSWORD','');

	function getConnection(){
		try{
			$con   = new PDO(CONNECTION_STR,USER,PASSWORD);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $con;
		}catch(PDOException $e){
			return null;
		}
	}

?>