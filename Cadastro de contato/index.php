<?php 
	session_start();
	include("banco.php");	
?>
<!doctype html>
<html lang="pt">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<title>Sistema de Contatos</title>
	<style>
	* {
		margin: 0px;
		padding: 0px;
	}
	.teste {
		border: 1px solid;		
	}
	.msg {
		border: 1px solid;		
		border-radius: 10px;
		padding: 10px;
		margin: 20px 0 0 0;
	}
	</style>
</head>
<body>
	<?php 
		if(isset($_SESSION['msg'])){
	?>
		<div class="container">	
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6 msg"><?php echo $_SESSION['msg']; unset($_SESSION['msg']);?></div>
				<div class="col-md-3"></div>
			</div>
		</div>
	<?php		
		}
	?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<br /><br />
				<div class="row">	
					<?php 
						if(isset($_POST['cadastro'])){
							
							if($_POST['senha'] == $_POST['conf-senha'])
							{
								$sql = 'select * from usuario where email = "'.$_POST['email'].'"';
								$consulta = $con -> prepare ($sql);
									if ($consulta -> execute ()){
										$total = $consulta->rowCount();
										if($total > 0){
											$_SESSION['msg'] = "E-mail já cadastrado";
											header("location: index.php");
										}
										else{
									
										}
									}
									else {
										echo 'Ocorreu os seguinte erro:'.$consulta -> errorInfo()[2];
									}
								$_SESSION['email'] = $_POST['email'];
								$_SESSION['senha'] = $_POST['senha'];								
								?>
								<!--Colocar aqui segunda parte do cadastro-->
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-5">
											<form method="post" action="index.php">
												<input type="hidden" name="cadastrando">
												<input type="hidden" name="email" <?php echo "value='".$_POST['email']."'";?>>
												<input type="hidden" name="senha" <?php echo "value='".$_POST['senha']."'";?>>
												<div class="form-group">
													<label> Nome: <input class="form-control" type="text" name="nome" required></label>		
												</div>
												<div class="form-group">
													<label> SobreNome: <input class="form-control" type="text" name="sobrenome" required></label>
												</div>
												<div class="form-group">
													<label> Data Nascimento: <input class="form-control" type="date" name="nascimento" required></label>
												</div>
												<div class="form-group">
													<label> CEP: <input class="form-control" type="number" name="CEP" required></label>
												</div>	
												<div class="form-group">
													<label> CPF: <input class="form-control" type="number" name="CPF" required></label>
												</div>
												<div class="form-group">
													<input  class="btn btn-lg btn-primary" type="submit" value="Enviar">
												</div>											
											</form>	
										</div>
									</div>
								</div>
								<?php
							}
							else
								{
								echo '<script> alert("senha diferentes");';
								echo 'javascript:window.location="index.php"</script>';
							}
						}else{
					?>				
					<div class="col-md-1"></div>
					<div class="col-md-4 teste text-center">
						<h2> Login </h2>
						<form action="login.php" method="post">
							<div class="form-group">
								<label> E-mail: <input  class="form-control" type="text" name="email"></label>
							</div>
							<div class="form-group">
								<label> Senha: <input  class="form-control" type="password" name="senha"></label>
							</div>
							<div class="form-group">
								<input  class="btn btn-lg btn-primary" type="submit" value="Enviar">
							</div>
						</form>
						<p><a href="trocasenha.php">Esqueci minha senha</a></p>
					</div>
					<div class="col-md-1"></div>
					<div class="col-md-4 text-center teste">
						<h2>Novo Cadastro</h2>
						<form action="index.php" method="post">
							<input type="hidden" name="cadastro">
							<div class="form-group">
								<label> E-mail: <input  class="form-control" type="email" name="email" required></label>
							</div>
							<div class="form-group">
								<label> Senha: <input  class="form-control" type="password" name="senha" required></label>
							</div>
							<div class="form-group">
								<label> Confirma Senha: <input  class="form-control" type="password" name="conf-senha" required></label>
							</div>
							<div class="form-group">
								<input  class="btn btn-lg btn-primary" type="submit" value="Enviar">
							</div>
						</form>
					</div>
					<div class="col-md-1"></div>
				<?php }?>
				
				<?php 
					if(isset($_POST['cadastrando'])){
						$senha = sha1($_POST['senha']);
									$nome = $_POST['nome']." ".$_POST['sobrenome'];
									try{
										$senha = sha1($_POST['senha']);
										$sql = 'insert into usuario (nome, email, senha, nascimento, cep, cpf, ativo) values (?,?,?,?,?,?,1)';
										$comando = $con->prepare($sql);
										$comando->bindParam(1, $nome);
										$comando->bindParam(2, $_POST['email']);
										$comando->bindParam(3, $senha);
										$comando->bindParam(4, $_POST['nascimento']);
										$comando->bindParam(5, $_POST['CEP']);
										$comando->bindParam(6, $_POST['CPF']);
									
											if ($comando-> execute()){
												$_SESSION['msg'] = "E-mail ".$_POST['email']." com sucesso!";
												header("location: index.php");
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
				</div>
			</div>
		</div>	
	</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>