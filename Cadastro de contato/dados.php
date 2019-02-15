<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Dados</title>
  </head>
  <body>
  <?php 
	if (isset($_POST['alterar'])){
		if(isset($_POST['email'])){
			$sql = "UPDATE emails SET email=?, tipo=? where id='".$_POST['id']."'";	
			$contato = $_POST['email'];
			$tipo = $_POST['tipo'];
			$msg = "E-mail alterado com sucesso;";		
		}elseif(isset($_POST['telefone'])){
			$sql = "UPDATE telefones SET telefone=?, tipo=? where id='".$_POST['id']."'";	
			$contato = $_POST['telefone'];
			$tipo = $_POST['tipo'];
			$msg = "Telefone alterado com sucesso;";
		}
		
		include('banco.php');				
		try {		
			$query = $con->prepare($sql);										
			$query->bindParam(1, $contato);
			$query->bindParam(2, $tipo);
								
			if ($query-> execute()){
				echo '<div class="alert alert-primary" role="alert"><center>
					 '.$msg.'
					</center></div>';												
			}
			else {
				echo 'erro:'.$query->errorInfo()[2];
														
			}
		}
		catch(PDOException $sex){
			echo 'erro:'.$ex-> getMessage();
			
		}
	}
	if (isset($_POST['deleta'])){
		if(isset($_POST['email'])){
			$sql = "DELETE FROM emails WHERE id = ".$_POST['id'];
			$msg = "E-mail deletado com sucesso.";
		}elseif(isset($_POST['telefone'])){
			$sql = "DELETE FROM telefones WHERE id = ".$_POST['id'];
			$msg = "Telefone deletado com sucesso.";
		}
		
		include('banco.php');				
		try {		
			$query = $con->prepare($sql);										
			
								
			if ($query-> execute()){
				echo '<div class="alert alert-primary" role="alert"><center>
					 '.$msg.'
					</center></div>';												
			}
			else {
				echo 'erro:'.$query->errorInfo()[2];
														
			}
		}
		catch(PDOException $sex){
			echo 'erro:'.$ex-> getMessage();
			
		}
		
		
	}
  
  
  
  
  ?>
  
  
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<a href="acesso.php">Voltar</a>
			</div>
			<div class="col-md-6">
			<h5 class="text-center">E-mails</h5>
			<?php				
				if (($_GET['id']) > 0){
				include ('banco.php');
				$id = $_GET['id'];
				$sql = "SELECT * FROM emails WHERE ID_CONTATO = $id";
				
				$consulta = $con -> prepare ($sql);
				if ($consulta -> execute ()){
					$total = $consulta->rowCount();
					if($total > 0){
						$dados = $consulta -> fetchAll();
							echo "<table  border=1 class='table'>
									<tr>";								
						foreach ($dados as $dado){
							echo "<td>".$dado['email']."</td>";
							echo "<td>".$dado['tipo']."</td>";
							echo "<td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModal".$dado['id']."'>
									Editar
								</button></td>";
							echo "<td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#deleteemail".$dado['id']."'>
									Deleta
								</button></td>";
							echo "</tr><tr>";
							//Modal alterar dados do EMAIL
							echo '<div class="modal fade" id="exampleModal'.$dado['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div  class="modal-dialog" role="document">
										<div style="width: 100%;" class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Alterar E-mail</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-md-12">
													<form method="post" action="">
														<input type="hidden" name="alterar" value="alterar">
														<input type="hidden" name="id" value="'.$dado['id'].'">
														<div class="form-group">
															<label>Email</label>
															<input type="text" name="email" class="form-control" aria-describedby="emailHelp" value="'.$dado['email'].'" required>
														</div>		
														<div class="form-group">
															<label>Tipo</label>
															<select class="form-control" name="tipo">
																<option value="'.$dado['tipo'].'">'.$dado['tipo'].'</option>
																<option value="Pessoal">Pessoal</option>
																<option value="Trabalho">Trabalho</option>														
															</select>
														</div>														
													  <button type="submit" class="btn btn-primary">Enviar</button>
													</form>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
											</div>
										</div>
									</div>
								</div>';
								//modal delete email
								echo '<div class="modal fade" id="deleteemail'.$dado['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div  class="modal-dialog" role="document">
										<div style="width: 100%;" class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Deleta email</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-md-12">
													<center>Deseja mesmo delete esse e-mail?</center>
													<form method="post" action="">
														<input type="hidden" name="deleta" value="deletar">
														<input type="hidden" name="email" value="email">
														<input type="hidden" name="id" value="'.$dado['id'].'">		
														
													  <center><button type="submit" class="btn btn-primary">Sim</button>
													  <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button></center>
													</form>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
											</div>
										</div>
									</div>
								</div>';
								
						}
						echo "</tr></table>";					
					}
					else{
						echo 'Ainda não existem E-mails cadastrados!';
					}
				}
				else {
					echo 'Ocorreu os seguinte erro:'.$consulta -> errorInfo()[2];
				}
				}
			?>
			<h3> Novo Email</h3>
			<form method="post" action="">
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="email" class="form-control" aria-describedby="emailHelp" placeholder="E-mail" required>
					<input type="hidden" value="<?php echo $_GET['id'];?>" name="id">
					<input type="hidden" name="novoemail">
				</div>										
				<div class="form-group" id="addemail">
					<select name="tipo">
						
						<option value="Pessoal">Pessoal</option>
						<option value="Trabalho">Trabalho</option>					
					</select>
				</div>
				<button type="submit" class="btn btn-primary">Enviar</button>
			</form>
			
			<?php 
			if(isset($_POST['novoemail'])){
				try {
					$sql = 'INSERT INTO emails (email, tipo, id_contato) values (?, ?, ?)';

					$query = $con->prepare($sql);
					
					$query->bindParam(1, $_POST["email"]);
					$query->bindParam(2, $_POST["tipo"]);	
					$query->bindParam(3, $_POST['id']);
			
										
					if ($query-> execute()){						
							echo '<div class="alert alert-primary" role="alert"><center>
					 Novo E-mail Cadastrado <a href="dados.php?id='.$_POST['id'].'">Click aqui para atualizar</a>
					</center></div>';
						}
						else {
							echo 'erro :'.$query->errorInfo()[2];
						}
				}
					catch(PDOException $sex){
						echo 'erro  1:'.$ex-> getMessage();
				}
			}
			?>
			
			
			
			</div>
			<div class="col-md-6">
			<h5 class="text-center"> Telefones </h5>
			<?php				
				if (($_GET['id']) > 0){
				include ('banco.php');
				$id = $_GET['id'];
				$sql = "SELECT * FROM telefones WHERE ID_CONTATO = $id";
				
				$consulta = $con -> prepare ($sql);
				if ($consulta -> execute ()){
					$total = $consulta->rowCount();
					if($total > 0){
						$dados = $consulta -> fetchAll();
							echo "<table  border=1 class='table'>
									<tr>";								
						foreach ($dados as $dado){
							echo "<td>".$dado['telefone']."</td>";
							echo "<td>".$dado['tipo']."</td>";
							echo "<td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModal".$dado['id']."'>
									Editar
								</button></td>";
							echo "<td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#deletefone".$dado['id']."'>
									Deleta
								</button></td>";
							echo "</tr><tr>";
							echo '<div class="modal fade" id="exampleModal'.$dado['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div  class="modal-dialog" role="document">
										<div style="width: 100%;" class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Alterar Telefone</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-md-12">
													
													<form method="post" action="">
													<input type="hidden" name="alterar" value="alterar">
													<input type="hidden" name="id" value="'.$dado['id'].'">
														<div class="form-group">
															<label>Telefone</label>
															<input type="text" name="telefone" class="form-control" aria-describedby="emailHelp" value="'.$dado['telefone'].'" required>
														</div>		
														<div class="form-group">
															<label>Tipo</label>
															<select class="form-control" name="tipo">
																<option value="'.$dado['tipo'].'">'.$dado['tipo'].'</option>
																<option value="celular">Celular</option>
																<option value="Trabalho">Trabalho</option>														
																<option value="Residencial">Residencial</option>														
															</select>
														</div>														
													  <button type="submit" class="btn btn-primary">Enviar</button>
													</form>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
											</div>
										</div>
									</div>
								</div>';	

								//modal delete telefone
								echo '<div class="modal fade" id="deletefone'.$dado['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div  class="modal-dialog" role="document">
										<div style="width: 100%;" class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Deleta Telefone</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-md-12">
													<center>Deseja mesmo delete esse Telefone?</center>
													<form method="post" action="">
														<input type="hidden" name="deleta" value="deletar">
														<input type="hidden" name="telefone" value="telefone">
														<input type="hidden" name="id" value="'.$dado['id'].'">		
														
													  <center><button type="submit" class="btn btn-primary">Sim</button>
													  <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button></center>
													</form>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
											</div>
										</div>
									</div>
								</div>';		
						}
						echo "</tr></table>";					
					}
					else{
						echo 'Ainda não existem Telefones cadastrados!';
					}
				}
				else {
					echo 'Ocorreu os seguinte erro:'.$consulta -> errorInfo()[2];
				}
				}
			?>
			
			<h3> Novo Telefone </h3>
			<form method="post" action="">
				<div class="form-group">
					<label>Telefone</label>
					<input type="text" name="email" class="form-control" aria-describedby="emailHelp" placeholder="Telefone" required>
					<input type="hidden" value="<?php echo $_GET['id'];?>" name="id">
					<input type="hidden" name="novotel">
				</div>										
				<div class="form-group" id="addemail">
					<select name="tipo">						
						<option value="Celular">Celular</option>
						<option value="Residencial">Residencial</option>					
						<option value="Comercial">Comercial</option>					
					</select>
				</div>
				<button type="submit" class="btn btn-primary">Enviar</button>
			</form>
			
			<?php 
			if(isset($_POST['novotel'])){
				try {
					$sql = 'INSERT INTO telefones (telefone, tipo, id_contato) values (?, ?, ?)';

					$query = $con->prepare($sql);
					
					$query->bindParam(1, $_POST["email"]);
					$query->bindParam(2, $_POST["tipo"]);	
					$query->bindParam(3, $_POST['id']);
			
										
					if ($query-> execute()){						
							echo '<div class="alert alert-primary" role="alert"><center>
					 Novo Telefone Cadastrado <a href="dados.php?id='.$_POST['id'].'">Click aqui para atualizar</a>
					</center></div>';
						}
						else {
							echo 'erro :'.$query->errorInfo()[2];
						}
				}
					catch(PDOException $sex){
						echo 'erro  1:'.$ex-> getMessage();
				}
			}
			?>
			</div>
		</div>
	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>