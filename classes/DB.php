<?php

require_once 'config.php';

class DB{

	private static $instance;
	
	public static function getConexao(){

		if(!isset(self::$instance)){
			try {
				self::$instance = new PDO('mysql:host=' . DB_HOST . ';', DB_USER, DB_PASS);
				self::$instance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}

		return self::$instance;
	} 	
	
	public static function CriarDatabaase(){	 
		/*CRIA O DATABASE */
		$conexao_pdo = self::getConexao();

		// Nosso novo banco de dados
		$bd = DB_NAME;
		$usuario_bd= DB_USER;
		 
		// Cria o banco de dados e da permissão para nosso usuário no mesmo
		$verifica = $conexao_pdo->exec("CREATE DATABASE $bd;");
			
		// Verificamos se a base de dados foi criada com sucesso
		if ( $verifica ):
			try {
				$conexao_pdo->exec("DROP DATABASE $bd;");
				$conexao_pdo->exec("CREATE DATABASE $bd;");	
			} catch (PDOException $e) {
				//echo $e->getMessage();
				self::CriarDatabaase();
			}			
		endif;			
	}

	public static function getInstance(){

		if(!isset(self::$instance)){
			try {
				self::$instance = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
				self::$instance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			} catch (PDOException $e) {
				//echo $e->getMessage();
				self::CriarDatabaase();
			}
		}

		return self::$instance;
	} 	
	
	public static function prepare($sql){
		return self::getInstance()->prepare($sql);
	}
}