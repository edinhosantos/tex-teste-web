<?php

require_once 'Crud.php';
require_once 'Usuarios_Permissao.php';

class Usuarios extends Crud{
	
	protected $table = 'usuarios';
//	private $id;
	private $login;
	private $senha;
	private $dicasenha;
	private $nome;
	private $sobrenome;
	private $email;
	private $telefone;
	private $endereco;
	private $site;
	private $status_usuario;
	private $permissao_usuario;
	
//	function SetId($value){
//		$this -> id = $value;
//	}
	function SetLogin($value){
		$this -> login = $value;
	}	
	function SetSenha($value){
		$this -> senha = $value;
	}		
	function SetDicaSenha($value){
		$this -> dicasenha = $value;
	}			
	function SetNome($value){
		$this -> nome = $value;
	}			
	function SetSobrenome($value){
		$this -> sobrenome = $value;
	}			
	function SetEmail($value){
		$this -> email = $value;
	}			
	function SetTelefone($value){
		$this -> telefone = $value;
	}			
	function SetEndereco($value){
		$this -> endereco = $value;
	}				
	function SetSite($value){
		$this -> site = $value;
	}
	function SetStatus_Usuario($value){
		$this -> status_usuario = $value;
	}
	function SetPermissao_Usuario($value){
		$this -> permissao_usuario = $value;
	}	

	public function create_table(){
		$sql = "CREATE TABLE if not exists $this->table (
							 id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
							 login VARCHAR(30) NOT NULL, 
							 senha VARCHAR(30) NOT NULL, 
							 dicasenha VARCHAR(50) NOT NULL, 
							 nome VARCHAR(50) NOT NULL, 
							 sobrenome VARCHAR(50) NOT NULL, 
							 email VARCHAR(50) NOT NULL, 
							 telefone VARCHAR(20) NOT NULL, 
							 endereco VARCHAR(50) NOT NULL, 
							 site VARCHAR(50)
						);";
		$conexao_pdo = DB::getInstance();
		$conexao_pdo->exec($sql);		
	}
	
	
	public function insert(){

		$sql = "INSERT INTO $this->table (  login, senha, dicasenha, 
											nome, sobrenome, email, telefone,
											endereco, site) VALUES 
										 (  :login, :senha, :dicasenha, 
											:nome, :sobrenome, :email, :telefone,
											:endereco, :site)";

		$stmt = DB::prepare($sql);
		$stmt->bindParam(':login', $this->login);
		$stmt->bindParam(':senha', $this->senha);
		$stmt->bindParam(':dicasenha', $this->dicasenha);
		$stmt->bindParam(':nome', $this->nome);
		$stmt->bindParam(':sobrenome', $this->sobrenome);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':telefone', $this->telefone);
		$stmt->bindParam(':endereco', $this->endereco);
		$stmt->bindParam(':site', $this->site);
		$stmt->execute();
		
		$sql="SELECT MAX(id) FROM $this->table";
		$stmt = DB::prepare($sql);
		$stmt->execute();
		$Usuarioid = $stmt->fetchColumn();		
		
		$usuario_permissao = new Usuarios_Permissao();
		$usuario_permissao->SetId_Usuario($Usuarioid);
		$usuario_permissao->SetStatus($this->status_usuario);
		$usuario_permissao->SetPermissao($this->permissao_usuario);
		
		return $usuario_permissao->Insert();
	}

	public function update($id){

		$sql  = "UPDATE $this->table SET login = :login, 
		                                 senha = :senha, 
		                                 dicasenha = :dicasenha, 
		                                 nome = :nome, 
		                                 sobrenome = :sobrenome, 
		                                 telefone = :telefone, 
		                                 endereco = :endereco,
		                                 site = :site,
										 email = :email
				 WHERE id = :id";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(':login', $this->login);
		$stmt->bindParam(':senha', $this->senha);
		$stmt->bindParam(':dicasenha', $this->dicasenha);
		$stmt->bindParam(':nome', $this->nome);
		$stmt->bindParam(':sobrenome', $this->sobrenome);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':telefone', $this->telefone);
		$stmt->bindParam(':endereco', $this->endereco);
		$stmt->bindParam(':site', $this->site);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		
		$usuario_permissao = new Usuarios_Permissao();
		$usuario_permissao->SetId_Usuario($id);
		$usuario_permissao->SetStatus($this->status_usuario);
		$usuario_permissao->SetPermissao($this->permissao_usuario);		

		if(! $usuario_permissao->findUsuariofetchAll($id)):			
			return $usuario_permissao->update($id);		
		else:
			return $usuario_permissao->Insert();		
		endif;	
	}
	public function findLimit($inicio, $fim){
		$sql  = "SELECT * FROM $this->table limit :inicio, :fim";		
		$stmt = DB::prepare($sql);
		$stmt->bindParam(':inicio', $inicio, PDO::PARAM_INT);
		$stmt->bindParam(':fim', $fim, PDO::PARAM_INT);		
		$stmt->execute();
		return $stmt->fetchAll();
	}	
}