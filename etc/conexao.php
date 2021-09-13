<?php

define('DB_HOST_RS'        , "127.0.0.1:3306");
define('DB_USER_RS'        , "root");
define('DB_PASS_RS'        , "");
define('DB_NAME_RS'        , "reserva_sala");
define('DB_DRIVER_RS'      , "mysql");

function db_connect_rs() {
  
	$pdoConfig  = DB_DRIVER_RS . ":host=" . DB_HOST_RS . ";";
	$pdoConfig .= "dbname=".DB_NAME_RS.";";
	
	try {
		if(!isset($connection)){
			$connection =  new PDO($pdoConfig, DB_USER_RS, DB_PASS_RS);
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		return $connection;
	} catch (PDOException $e) {
	 echo 'ERROR: ' . $e->getMessage();
	}
}




?>