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
	<title>Sistema de Login</title>
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
		margin: 25px 0 0 0;
	}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
		<?php 
			if(isset($_POST['cpf'])){
				$email = $_POST['email'];
				$cpf = $_POST['cpf'];
				
		?>
		<!--Ultima parte para troca senha aqui-->
		<div class="col-md-3"></div>
			<div class="col-md-6 msg">
				<form method="post" action="redefinir_senha.php">
					<div class="form-group">
						<input type="hidden" name="cpf" value="<?php echo $cpf;?>"/>
						<input type="hidden" name="email" value="<?php echo $email;?>"/>
						
						<label> Nova Senha:<input class="form-control" type="password" name="senha" /></label></br>
						<label> Confirma Nova Senha:<input class="form-control" type="password" name="conf_senha" /></label>
					</div>
					<div class="form-group">
						<input class="btn btn-primary" type="submit" value="Enviar"/>
					</div>
				</form>
			</div>
			<div class="col-md-3"></div>
		<?php
			}else{
		?>
		
		<?php 
			if(isset($_POST['trocandosenha'])){
				$sql = 'select * from usuario where email = "'.$_POST['email'].'"';
				$consulta = $con -> prepare ($sql);
					if ($consulta -> execute ()){
						$total = $consulta->rowCount();
						if($total > 0){
						
		?>
			<div class="col-md-12 text-center">
			<h1>Redefinir senha</h1>
			</div>
			
			<div class="col-md-3"></div>
			<div class="col-md-6 teste"><br />
				<form method="post" action="trocasenha.php">
					<div class="form-group">
						<input type="hidden" name="cpf"/>
						<input type="hidden" name="email" value="<?php echo $_POST['email'];?>"/>
						<label> CPF: <input class="form-control" type="number" name="cpf" /></label>
					</div>
					<div class="form-group">
						<input class="btn btn-primary" type="submit" value="Enviar" />
					</div>
				</form>
			</div>
			<div class="col-md-3"></div>
		<?php
						}
						else{
							$_SESSION['msg'] = 'email errado';
							header("location: trocasenha.php");
						}
					}
					else{
						echo 'Ocorreu os seguinte erro:'.$consulta -> errorInfo()[2];
					}
						
								
			}else{				
		?>
			<div class="col-md-12 text-center">
				<?php 
					if(isset($_SESSION['msg'])){
						echo $_SESSION['msg'];
						unset($_SESSION['msg']);
					}			
				?>
				<h1>Redefinir senha</h1>
			</div>
			
			<div class="col-md-3"></div>
			<div class="col-md-6 teste"><br />
				<form method="post" action="trocasenha.php">
					<div class="form-group">
						<input type="hidden" name="trocandosenha"/>
						<label> E-mail: <input class="form-control" type="email" name="email" /></label>
					</div>
					<div class="form-group">
						<input class="btn btn-primary" type="submit" value="Enviar" />
					</div>
				</form>
			</div>
			<div class="col-md-3"></div>
		<?php 
			}}
		?>
		</div>	
	</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>