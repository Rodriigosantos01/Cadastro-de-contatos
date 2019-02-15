<?php
	session_start();
	if(isset($_POST['cpf'])){
		$cpf = $_POST['cpf']; 
		$email = $_POST['email']; 
		$senha = $_POST['senha'];
		$confsenha = $_POST['conf_senha'];
			if($senha == $confsenha){
				echo "CPF: ".$cpf;
				echo "<br>Email: ".$email;
				echo "<br>Senha: ".$senha;
				echo "<br>Conf senha: ".$confsenha;
				
				include('banco.php');				
					try {
						$senha = sha1($_POST['senha']);
						$sql = "UPDATE usuario SET senha=? where email='".$email."'";	
						$query = $con->prepare($sql);										
						$query->bindParam(1, $senha);
										
						if ($query-> execute()){
							$_SESSION['msg'] = 'Alterado Com Sucesso!';
							header("location: index.php");													
						}
						else {
							$_SESSION['msg'] = 'erro:'.$query->errorInfo()[2];
							header("location: index.php");													
						}
					}
					catch(PDOException $sex){
						$_SESSION['msg'] ='erro:'.$ex-> getMessage();
						header ('location: index.php');
					}
														
				
				
				
				
				
				
			}else{
				echo '<script>
						alert("Senhas Diferentes");
						window.location.replace("trocasenha.php");
					</script>';				
			}
		}else {
		header("location: index.php");
		}
	
	



?>