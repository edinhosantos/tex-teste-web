<?php

require_once 'Crud.php';

class Usuarios_Permissao extends Crud{
	
	protected $table = 'usuario_permissao';
	private $id_usuario;
	private $status;
	private $permissao;

	function SetId_Usuario($value){
		$this -> id_usuario = $value;
	}
	function SetStatus($value){
		$this -> status = $value;
	}	
	function SetPermissao($value){
		$this -> permissao = $value;
	}		
	
	public function create_table(){
		$sql = "CREATE TABLE if not exists $this->table (
				id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
				id_usuario INT NOT NULL, 
				status INT NOT NULL, 
				permissao INT NOT NULL);";
		$conexao_pdo = DB::getInstance();
		$conexao_pdo->exec($sql);		
	}
	
	public function insert(){

		$sql = "INSERT INTO $this->table (  id_usuario, status, permissao) VALUES 
										 (  :id_usuario, :status, :permissao)";

		$stmt = DB::prepare($sql);
		$stmt->bindParam(':id_usuario', $this->id_usuario);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':permissao', $this->permissao);
		return $stmt->execute();	
	}

	public function update($id){
		
		$sql  = "UPDATE $this->table SET status = :status, 
		                                 permissao = :permissao
				 WHERE id_usuario = :id_usuario";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':permissao', $this->permissao);
		$stmt->bindParam(':id_usuario', $id);
		return $stmt->execute();
	}
	
	public function findUsuario($id_usuario){
		$sql  = "SELECT id_usuario, status, permissao FROM $this->table WHERE id_usuario = :id_usuario";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}	
	public function findUsuariofetchAll($id_usuario){
		$sql  = "SELECT id_usuario, status, permissao FROM $this->table WHERE id_usuario = :id_usuario";
		$stmt = DB::prepare($sql);
		$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
		$stmt->execute();
		return count($stmt->fetchAll()) > 0;
	}		
}