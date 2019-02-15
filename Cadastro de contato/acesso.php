<?php 
	session_start();
if (!$_SESSION['logado']){
	header("location: index.php");
} 

echo $_SESSION['msg'];
	unset($_SESSION['msg']);

?>
<!DOCTYPE>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<title> Cadastros </title>
	<meta charset="utf-8">
	
	<script>
	contemail = 0;
	conttel = 0;
	function mostrarEmail(){
		contemail++
		document.getElementById('addemail').innerHTML += 'E-mail: <input class="form-control" type="text" name="email'+contemail+'" placeholder="email"/><br>Pessoal: <input value="pessoal" type="radio" name="temail'+contemail+'"> Corporativo: <input type="radio" value="Corporativo" name="temail'+contemail+'"><br>';
		document.getElementById('totemail').value = contemail;
	}

	function mostrartel(){
		conttel++
		document.getElementById('addtel').innerHTML += 'Telefone: <input class="form-control" type="text" name="tel'+conttel+'" placeholder="Telefone" /><br>Celular: <input type="radio" value="celular" name="tfone'+conttel+'"> Residencial: <input type="radio" value="residencial" name="tfone'+conttel+'"> Trabalho: <input type="radio" value="trabalho" name="tfone'+conttel+'"><br><br>';
		document.getElementById('tottel').value = conttel;
	}
	</script>
</head>
<body>
	<?php
	if (isset($_POST['deleta'])){
		
		
		include('banco.php');				
		try {	
			$sql = "DELETE FROM contatos WHERE id = ".$_POST['id'];
			$query = $con->prepare($sql);										
			
								
			if ($query-> execute()){
				echo '<div class="alert alert-primary" role="alert"><center>
					 Contato deletado com sucesso!
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
				<p align="right"><a href="logout.php">sair<a></p>	
				<!-- Modal para cadastra novo contato -->
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
					Novo Contato
				</button>
				
				<br /><br /><br />
				<!-- Modal -->
				<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div  class="modal-dialog" role="document">
						<div style="width: 100%;" class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Adicionar Contato</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-12">
									<form method="post" action="novocontato.php">
										<div class="form-group">
											<label>Nome</label>
											<input type="text" name="nome" class="form-control" aria-describedby="emailHelp" placeholder="Nome Completo" required>
											
										</div>										
										<div class="form-group" id="addemail">
											<h1><a class="btn  btn-secondary" onclick="mostrarEmail()">Add E-mail</a></h1><br>
										</div>
										<div class="form-group" id="addtel">
											<a class="btn  btn-secondary" onclick="mostrartel()">Add Tel</a><br>
										</div>
										<input type="hidden" value="" id="totemail" name="qtdemail" />
										<input type="hidden" value="" id="tottel" name="qtdetel" />
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
				</div>
			</div>
			<div class="col-md-12">
			<h4 class="text-center">Meus Contatos</h4>
			<?php
				include ('banco.php');
				$cont1 = 0;
				$sql = 'select * from contatos';
				$consulta = $con -> prepare ($sql);
				if ($consulta -> execute ()){
					$total = $consulta->rowCount();
					if($total > 0){
						$contatos = $consulta -> fetchAll();
						echo "<table class='table'><tr>";
						foreach ($contatos as $contato){
							if (($_SESSION['id']) == ($contato['id_usuario'])){	
								echo "<td>".$contato['nome']."</td>";
								echo "<td><a href='dados.php?id=".$contato['id']."'>Ver contatos</a></td>";
								echo "<td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#deletecontato".$contato['id']."'>
									Deleta
								</button></td>";
								echo "</tr><tr>";
								//modal delete telefone
								echo '<div class="modal fade" id="deletecontato'.$contato['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div  class="modal-dialog" role="document">
										<div style="width: 100%;" class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Deleta contato</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-md-12">
													<center>Deseja mesmo delete esse Contato?</center>
													<form method="post" action="">
														<input type="hidden" name="deleta" value="deletar">
														<input type="hidden" name="contato" value="contato">
														<input type="hidden" name="id" value="'.$contato['id'].'">		
														
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
						}
						echo "</tr></table>";					
					}
					else{
						echo 'Ainda não existem contatos cadastrados!';
					}
				}
				else {
					echo 'Ocorreu os seguinte erro:'.$consulta -> errorInfo()[2];
				}
			?>
			
			</div>
			<div class="col-md-12">
			
			
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