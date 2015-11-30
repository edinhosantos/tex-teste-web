<?php
	require_once '../classes/Usuarios.php';
	require_once '../classes/Usuarios_Permissao.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/favicon.ico">
    <title>Editar</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/responsive.css" rel="stylesheet">
	
    <script src="../js/ie-emulation-modes-warning.js"></script>	
	
	<script>
    function formatar(mascara, documento){
      var i = documento.value.length;
      var saida = mascara.substring(0,1);
      var texto = mascara.substring(i)
      
      if (texto.substring(0,1) != saida){
                documento.value += texto.substring(0,1);
      }      
    }
	</script>	
  </head>

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
		<div class="col-sm-8">				
			<?php
				$usuario = new Usuarios();
				$usuario->create_table();
				$usuario_permissao = new Usuarios_Permissao();							
				$usuario_permissao->create_table();
				$status=0;
				if(isset($_GET['acao']) && $_GET['acao'] == 'editar'):
					$id = (int)$_GET['id'];					
					$result_usu = $usuario->find($id);
					if ($usuario_permissao->findUsuariofetchAll($id)):
						$result_usu_per = $usuario_permissao->findUsuario($id);
						$status= $result_usu_per->status;
					endif;
			?>			
			<div class="col-sm-9">
				<!--Form editar-->			
				<form class="form-horizontal" name="formeditar" method="post" action="usuarios_view.php">			
					<fieldset>
						<legend class="text-center header">Teste Tex</legend>
						<div>
							<div class="control-group">
								<label for="login" class="control-label">Usuário</label>
								<div class="controls">															
									<input type="text" name="login" value="<?php echo $result_usu->login; ?>" placeholder="Usuário" class="form-control" required/>
								</div>
							</div>						
							<div class="control-group">
								<label for="senha" class="control-label">Senha</label>
								<div class="controls">							
									<input type="password" id="senha" name="senha" class="form-control" value="<?php echo $result_usu->senha; ?>" placeholder="Senha" required>
								</div>
							</div>
							<div class="control-group">													
									<label for="inputConfirmaSenha" class="control-label">Confirmar Senha</label>
								<div class="controls">															
									<input type="password" id="inputConfirmaSenha" class="form-control" value="<?php echo $result_usu->senha; ?>" placeholder="Confirmar Senha" required>						
								</div>
							</div>						
							
							<div class="control-group">													
								<label for="dicasenha" class="control-label">Dica da Senha</label>					
								<div class="controls">																							
									<input type="text" name="dicasenha" value="<?php echo $result_usu->dicasenha; ?>" placeholder="Nome" class="form-control" required/>								
								</div>
							</div>													
								
							<div class="control-group">						
								<label class="control-label">Nome</label>
								<div class="controls">								
									<input type="text" name="nome" value="<?php echo $result_usu->nome; ?>" placeholder="Nome" class="form-control" required/>
								</div>
							</div>						
							
							<div class="control-group">						
								<label for="sobrenome" class="control-label">Sobrenome</label>					
								<div class="controls">																							
									<input type="text" name="sobrenome" value="<?php echo $result_usu->sobrenome; ?>" placeholder="Sobrenome" class="form-control" required/>
								</div>
							</div>	
							
							<div class="control-group">						
								<label for="endereco" class="control-label">Endereço</label>					
								<div class="controls">																							
									<input type="text" name="endereco" value="<?php echo $result_usu->endereco; ?>" placeholder="Endereço" class="form-control" required/>
								</div>
							</div>							
							
							<div class="control-group">						
								<label for="email" class="control-label">Email</label>					
								<div class="controls">																							
									<input type="email" name="email" value="<?php echo $result_usu->email; ?>" placeholder="Endereço de Email" class="form-control" required/>
								</div>
							</div>												
							
							<div class="control-group">						
								<label for="telefone" class="control-label">Telefone</label>
								<div class="controls">															
									<input type="text" id="telefone" name="telefone" maxlength="13" class="form-control" value="<?php echo $result_usu->telefone; ?>" OnKeyPress="formatar('##-#####-####', this)" >
								</div>
							</div>												
							
							<div class="control-group">						
								<label for="site" class="control-label">Website</label>					
								<div class="controls">															
									<input type="text" id="site" name="site" class="form-control" value="<?php echo $result_usu->site; ?>" placeholder="Website">											
								</div>
							</div>												
							<div>
								<input type="hidden" name="id" value="<?php echo $result_usu->id; ?>">
								<br />							
							</div>
						</div>
				
						<div>
							<label class="control-label">Status</label>
							<h4></h4>
						</div>				
						<div>
							<div class="control-group">
								<div class="controls">
									<span>
										<?php 										
											echo (($status == 0) || ($status == 1)) ? 
												 '<label><input type="radio" name="status" value="1" checked> Habilitado</label>': 
												 '<label><input type="radio" name="status" value="1" > Habilitado</label>';
										?>
									</span>
									<span>
										<?php 										
											echo ($status == 2) ? 
												 '<label><input type="radio" name="status" value="2" checked> Expirado</label>': 
												 '<label><input type="radio" name="status" value="2" > Expirado</label>';
										?>
									</span>
									<br>
									<span>
										<?php 										
											echo ($status == 3) ? 
												 '<label><input type="radio" name="status" value="3" checked> Bloqueado</label>': 
												 '<label><input type="radio" name="status" value="3" > Bloqueado</label>';
										?>
									</span>
									<span>
										<?php 										
											echo ($status == 4) ? 
												 '<label><input type="radio" name="status" value="4" checked> Senha Expirada</label>': 
												 '<label><input type="radio" name="status" value="4" > Senha Expirada</label>';
										?>
									</span>
								</div>						
							</div>						
						</div>
						<div>
							<label class="control-label">Permissão</label>
							<h4></h4>
						</div>				
						<div>
							<div class="control-group">
								<div class="controls">
									<select name="permissao" id="permissao" size="3" multiple="multiple">													
										<?php echo (($result_usu_per->permissao == '')||($result_usu_per->permissao == '1')) ? 
												'<option value="1" selected>ROLE_ADMIN</option>': 
												'<option value="1">ROLE_ADMIN</option>';
										    echo ($result_usu_per->permissao == '2') ? 
												'<option value="2" selected>ROLE_USER</option>': 
												'<option value="2">ROLE_USER</option>';?>
									</select>															
								</div>						
							</div>						
						</div>						
						<div class="control-group">
						  <label class="control-label"></label>
						  <div class="controls">
							<button id="atualizar" name="atualizar" type="submit" class="btn btn-primary">Salvar</button>
							<?php echo "<a href='usuarios_view.php?acao=deletar&id=" . $result_usu->id . "' onclick='return confirm(\"Deseja realmente deletar?\")'><span class=\"btn btn-default\">Deletar</span></a>"; ?>
							<button id="Cancelar" name="Cancelar" class="btn btn-default">Cancelar</button>
						  </div>
						</div>					
					</fieldset>
				</form>
			</div>
			<?php else: ?>
			<div class="col-sm-9">
				<!--Form cadastrar-->			
				<form class="form-horizontal" name="formcadastrar" method="post" action="usuarios_view.php">			
					<fieldset>
						<div>
							<div class="control-group">
								<label for="login" class="control-label">Usuário</label>
								<div class="controls">															
									<input type="text" name="login" placeholder="Nome" class="form-control" required/>
								</div>
							</div>						
							<div class="control-group">
								<label for="senha" class="control-label">Senha</label>
								<div class="controls">							
									<input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required>
								</div>
							</div>
							<div class="control-group">													
									<label for="inputConfirmaSenha" class="control-label">Confirmar Senha</label>
								<div class="controls">															
									<input type="password" id="inputConfirmaSenha" class="form-control" placeholder="Confirmar Senha" required>						
								</div>
							</div>						
							
							<div class="control-group">													
								<label for="dicasenha" class="control-label">Dica da Senha</label>					
								<div class="controls">																							
									<input type="text" name="dicasenha" placeholder="Nome" class="form-control" required/>								
								</div>
							</div>													
								
							<div class="control-group">						
								<label class="control-label">Nome</label>
								<div class="controls">								
									<input type="text" name="nome" placeholder="Nome" class="form-control" required/>
								</div>
							</div>						
							
							<div class="control-group">						
								<label for="sobrenome" class="control-label">Sobrenome</label>					
								<div class="controls">																							
									<input type="text" name="sobrenome" placeholder="Sobrenome" class="form-control" required/>
								</div>
							</div>	
							
							<div class="control-group">						
								<label for="endereco" class="control-label">Endereço</label>					
								<div class="controls">																							
									<input type="text" name="endereco" placeholder="Endereço" class="form-control" required/>
								</div>
							</div>							
							
							<div class="control-group">						
								<label for="email" class="control-label">Email</label>					
								<div class="controls">																							
									<input type="email" name="email" placeholder="Endereço de Email" class="form-control" required/>
								</div>
							</div>												
							
							<div class="control-group">						
								<label for="telefone" class="control-label">Telefone</label>
								<div class="controls">															
									<input type="text" id="telefone" name="telefone" maxlength="13" class="form-control" OnKeyPress="formatar('##-#####-####', this)" >
								</div>
							</div>												
							
							<div class="control-group">						
								<label for="site" class="control-label">Website</label>					
								<div class="controls">															
									<input type="text" id="site" name="site" class="form-control" placeholder="Website">											
								</div>
							</div>												
						</div>						
						<div>
							<label class="control-label">Status</label>
							<h4></h4>
						</div>				
						<div>
							<div class="control-group">
								<div class="controls">
									<span>
										<label><input type="radio" name="status" value="1" checked> Habilitado</label>
									</span>
									<span>
										<label><input type="radio" name="status" value="2"> Expirado</label>
									</span>
									<br>
									<span>
										<label><input type="radio" name="status" value="3"> Bloqueado</label>
									</span>
									<span>
										<label><input type="radio" name="status" value="4"> Senha Expirada</label>
									</span>									
								</div>						
							</div>						
						</div>
						<div>
							<label class="control-label">Permissão</label>
							<h4></h4>
						</div>				
						<div>
							<div class="control-group">
								<div class="controls">
									<select name="permissao" id="permissao" size="3" multiple="multiple">													
										<option value="1" selected>ROLE_ADMIN</option>
										<option value="2">ROLE_USER</option>
									</select>															
								</div>						
							</div>						
						</div>						
						<div class="control-group">
						  <label class="control-label"></label>
						  <div class="controls">
							<button id="cadastrar" name="cadastrar" class="btn btn-primary">Salvar</button>
							<button id="Cancelar" name="Cancelar" class="btn btn-default">Cancelar</button>
						  </div>
						</div>					
					</fieldset>
				</form>
			</div>
			<?php
				endif;
			?>
		</div>

    </div> <!-- /container -->

<style>
    .header {
        color: #36A0FF;
        font-size: 27px;
        padding: 10px;
    }

    .bigicon {
        font-size: 35px;
        color: #36A0FF;
    }
</style>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
