<?php 
	
	session_start();
	if(isset($_POST['nome'])){
		$nome = $_POST['nome'];
		
		
		include('banco.php');
		try {
				$sql = 'INSERT INTO contatos (nome, id_usuario) values (?, ?)';

				$query = $con->prepare($sql);
				
				$query->bindParam(1, $nome);
				$query->bindParam(2, $_SESSION['id']);
		
									
				if ($query-> execute()){
					$contato = $con->lastInsertId();
					
					}
					else {
						echo 'erro :'.$query->errorInfo()[2];
					}
			}
				catch(PDOException $sex){
					echo 'erro  1:'.$ex-> getMessage();
			}
			
		
		
		
		//Quantidade de email cadastrado
		$qtdemail = $_POST['qtdemail'];
		
		for($contemail=1;$contemail<=$qtdemail;$contemail++){			
			if(($_POST["email".$contemail]) == ""){
					
			}else {
					try {
				$sql = 'INSERT INTO emails (email, tipo, id_contato) values (?, ?, ?)';

				$query = $con->prepare($sql);
				
				$query->bindParam(1, $_POST["email".$contemail]);
				$query->bindParam(2, $_POST["temail".$contemail]);
				$query->bindParam(3, $contato);
		
									
				if ($query-> execute()){
					//$usuario = $con->lastInsertId();
					echo '';
					}
					else {
						echo 'erro :'.$query->errorInfo()[2];
					}
			}
				catch(PDOException $sex){
					echo 'erro  1:'.$ex-> getMessage();
			}
			//echo 'Email '.$contemail.': '.$_POST["email".$contemail].' Tipo de email:'.$_POST["temail".$contemail].'<br>';
			}
		}
		
		//Quantidade de Telefone cadastrado
		$qtdetel = $_POST['qtdetel'];
		
		for($conttel=1;$conttel<=$qtdetel;$conttel++){
			if(($_POST["tel".$conttel]) == ""){
				echo '';
			}else{
				try {
				$sql = 'INSERT INTO telefones (telefone, tipo, id_contato) values (?, ?, ?)';

				$query = $con->prepare($sql);
				
				$query->bindParam(1, $_POST["tel".$conttel]);
				$query->bindParam(2, $_POST["tfone".$conttel]);
				$query->bindParam(3, $contato);
		
									
				if ($query-> execute()){
					//$usuario = $con->lastInsertId();
					echo '';
					}
					else {
						echo 'erro :'.$query->errorInfo()[2];
					}
			}
				catch(PDOException $sex){
					echo 'erro  1:'.$ex-> getMessage();
			}			
				
			}
			
		}$_SESSION['msg'] = "Contatos Cadastrados com sucesso";
				header("location: acesso.php");	
	}else{
	
		header("location: acesso.php");	
	}
?>

