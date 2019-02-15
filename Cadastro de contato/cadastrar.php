<?php 
	if (count($_POST)>0){						
		try {
			$senha = sha1($_POST['senha']);
			$sql = 'insert into usuario (nome, email, senha, nascimento, cep, ativo) values (?,?,?,1,?,?)';
			$comando = $con->prepare($sql);
			$comando->bindParam(1, $_POST['login']);
			$comando->bindParam(2, $_POST['nome']);
			$comando->bindParam(3, $senha);
			$comando->bindParam(4, $_POST['telefone']);
			$comando->bindParam(5, $_POST['cpf']);
				if ($comando-> execute()){
					$_SESSION['msg'] = 'contato '.$_POST['nome'].' foi cadastrado com sucesso!';
					echo '<script>window.location.replace("login.php");</script>';
				}
				else {
					echo 'erro:'.$comando->errorInfo()[2];
				}
			}
			catch(PDOException $sex){
				echo 'erro:'.$ex-> getMessage();
			}
		}
?>