<?php
$host = "localhost"; 
$banco = "login";
$usuario = "root"; 
$senha = "usbw";

try {
	$con = new PDO('mysql:host='.$host.';port=3306;dbname='.$banco,$usuario,$senha);
}	
	catch (PDOException $ex) {
		echo 'Erro de conexão: '. $ex->getMessage();
	}


?>

