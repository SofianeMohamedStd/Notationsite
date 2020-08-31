<?php
namespace App\Models;

use PDO;

abstract class Model {
	

	private const OPTIONS = [
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	];

	protected static $_pdo = null; 

	protected static function getPdo() {
		if (is_null(self::$_pdo)) {
			try{
				self::$_pdo  = new PDO('mysql:host=localhost;dbname=notation;','root','');
			 }catch(PDOException $e){
				die('Erreur : '.$e->getMessage());
			 }
		}
		return self::$_pdo;
	}
}