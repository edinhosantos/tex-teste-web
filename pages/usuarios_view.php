<?php
	require_once '../classes/Usuarios.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Teste-tex">
    <meta name="author" content="Edson de Melo">
    <title>Usuários</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/responsive.css" rel="stylesheet">

    <link rel="shortcut icon" href="../images/favicon.ico">
</head><!--/head-->

  <body>
	<nav class="navbar navbar-inverse">
	<!-- <nav class="nav navbar-nav"> -->
	<div class="container">
	  <div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		  <span class="sr-only">Toggle navigation</span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="#"></a>
	  </div>
	  <div id="navbar" class="navbar-collapse collapse">
		<ul class="nav navbar-nav">
		  <li class="active"><a href="editar.php?acao=cadastrar">Cadastrar</a></li>
		  <li><a href="../index.html">Login</a></li>
		</ul>
	  </div><!--/.nav-collapse -->
	</div><!--/.container-fluid -->
	</nav>
	<div class="container">
        <div>
			<div class="shipping text-center"><!--shipping-->
				<h2>Teste Tex</h2>
			</div><!--/shipping-->	             
		</div>	  
    </div> <!-- /container -->

	
	<div class="container">

		<?php
			$usuario = new Usuarios();
			$usuario->create_table();
			$usuario_permissao = new Usuarios_Permissao();							
			$usuario_permissao->create_table();		

			if(isset($_POST['cadastrar'])):
			
				$nome = $_POST['nome'];
				$email = $_POST['email'];
				$login = $_POST['login'];
				$senha = $_POST['senha'];
				$dicasenha = $_POST['dicasenha'];
				$sobrenome = $_POST['sobrenome'];			
				$telefone = $_POST['telefone'];
				$endereco = $_POST['endereco'];
				$site = $_POST['site'];
				$status = $_POST['status'];
				$permissao = $_POST['permissao'];
				
				$usuario->setNome($nome);
				$usuario->setEmail($email);
				$usuario->setLogin($login);
				$usuario->setSenha($senha);
				$usuario->setDicaSenha($dicasenha);
				$usuario->setSobrenome($sobrenome);
				$usuario->setTelefone($telefone);
				$usuario->setEndereco($endereco);			
				$usuario->setSite($site);
				$usuario->SetStatus_Usuario($status);			
				$usuario->SetPermissao_Usuario($permissao);							

				# Insert
				if($usuario->insert()){				
					echo "<script>alert('Registro inserido com sucesso!');</script>";
				}

			endif;

			if(isset($_POST['atualizar'])):

				$id = $_POST['id'];
				$nome = $_POST['nome'];
				$email = $_POST['email'];
				$login = $_POST['login'];
				$senha = $_POST['senha'];
				$dicasenha = $_POST['dicasenha'];
				$sobrenome = $_POST['sobrenome'];			
				$telefone = $_POST['telefone'];
				$endereco = $_POST['endereco'];
				$site = $_POST['site'];
				$status = $_POST['status'];
				$permissao = $_POST['permissao'];
				
				$usuario->setNome($nome);
				$usuario->setEmail($email);
				$usuario->setLogin($login);
				$usuario->setSenha($senha);
				$usuario->setDicaSenha($dicasenha);
				$usuario->setSobrenome($sobrenome);
				$usuario->setTelefone($telefone);
				$usuario->setEndereco($endereco);			
				$usuario->setSite($site);			
				$usuario->SetStatus_Usuario($status);			
				$usuario->SetPermissao_Usuario($permissao);			
				
				if($usuario->update($id)){
					echo "<script>alert('Registro atualizado com sucesso!');</script>";
				}

			endif;
		?>		
		
		<?php
			if(isset($_GET['acao']) && $_GET['acao'] == 'deletar'):
				
				$id = (int)$_GET['id'];
				if($usuario->delete($id)){
					echo "<script>alert('Registro deletado com sucesso!');</script>";
				}

			endif;
		?>		
		<div class="table-responsive">
			<table class="col-sm-12 table-bordered table-striped table-condensed cf">			
				<thead>
					<tr>
						<th style="width: 50px;">Nome</th>
						<th style="width: 50px;">Sobrenome</th>
						<th style="width: 50px;">Endereço</th>
						<th style="width: 50px;">Contato</th>
						<th style="width: 50px;">E-mail:</th>
						<th style="width: 5px;">Editar</th>
						<th style="width: 5px;">Deletar</th>
					</tr>
				</thead>
							
				<?php 
					$limite= 5;
					$numero_paginas = ceil(count($usuario->findAll()) / $limite);				
					$pg = (isset($_GET["pg"])) ? (int) $_GET["pg"] : 1;
					$inicio = ($pg - 1) * $limite;
					
					foreach($usuario->findLimit($inicio, $limite) as $key => $value): ?>
				<tbody>
					<tr>
						<td style="width: 50px;"><?php echo $value->nome; ?></td>
						<td style="width: 50px;"><?php echo $value->sobrenome; ?></td>
						<td style="width: 50px;"><?php echo $value->endereco; ?></td>
						<td style="width: 50px;"><?php echo $value->telefone; ?></td>
						<td style="width: 50px;"><?php echo $value->email; ?></td>
						<td style="width: 5px;">
							<?php echo "<a href='editar.php?acao=editar&id=" . $value->id . "' class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-pencil\"></span></a>"; ?>							
						</td>
						<td style="width: 5px;">
							<?php echo "<a href='usuarios_view.php?acao=deletar&id=" . $value->id . 
							           "' class=\"btn btn-danger\" onclick='return confirm(\"Deseja realmente deletar?\")'><span class=\"glyphicon glyphicon-trash\"></span></a>";?>
						</td>					
					</tr>
				</tbody>

				<?php endforeach; ?>
			</table>			
		</div>
		<div class="container">
			<section id="paginacao">
				<div>
					<ul class="pagination pagination-right">
					<?php					
						if (($numero_paginas> 1)&& ($pg <= $numero_paginas)):
							for($i=1;$i<=$numero_paginas; $i++): 
							  echo "<li><a href= '?pg=$i'>$i </a></li>";
							endfor;						
						endif;
						if ($numero_paginas> 1):
							echo "<li><a href='?pg=$numero_paginas'>&raquo;</a></li>";
						endif;					
						?>					
					</ul>		
				</div>
			</section>
		</div>
	</div>	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
