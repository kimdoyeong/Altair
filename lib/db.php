<?php
class db {
	private $pdo;
	function __construct() {
		$this->pdo = new PDO('mysql:host=localhost;dbname=wiki;charset=utf8', "root", "password");
	}
	
	function execute($sql, $data=null) {
		$prepare = $this->pdo->prepare($sql);
		$prepare->execute($data);
		
		return $prepare;
	}
	
	function __destruct() {
		$this->pdo = null;
	}
}
?>