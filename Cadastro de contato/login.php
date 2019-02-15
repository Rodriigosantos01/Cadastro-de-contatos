<?php

	session_start();
	include('banco.php');

	$sql = "select * from usuario where email = ?";
	$query = $con->prepare($sql);
	$query->bindParam(1, $_POST['email']);

		if($query->execute()){
			$num = $query->rowCount();
			if($num > 0){
				$usuario = $query->fetch();
				if ($usuario['ativo'] == 1){
					if ($usuario['senha'] == sha1($_POST['senha'])){
						$_SESSION['logado'] = true;
						$_SESSION['id'] = $usuario['id'];
					}
					else {
						$_SESSION['msg'] = '<span id="warning" class="warning">Senha incorreta.</span>';
					}
				}	
				else {
					$_SESSION['msg'] = '<span id="warning" class="warning">Usuario Inativo fale com o Adm.</span>';
				}
			}
			else {
			$_SESSION['msg'] = '<span id="warner" class="warning"> Usuario Invalido.</span>';
			}
		}
		else {
			$_SESSION['msg'] = '<span id="warning" class="warning"> Falha ao conectar com o BD.</span>';
		}
	if ($_SESSION['logado']){
		$_SESSION['msg'] = "Logado com sucesso!!";
		header("location: acesso.php");
	}
	else {
		header("location: index.php");
	}
?>