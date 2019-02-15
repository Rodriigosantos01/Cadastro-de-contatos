<?php 
	session_start();
	include("acesso.php");
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
?>
<p><a href="logout.php">sair<a></p>