<?php
namespace App\Models;

use App\Models\Model;

class Oeuvres extends Model
{
   public function __construct()
   {
      $this->pdo = parent::getPdo();

   }

   public function getAllOeuvres()
   {
      $req = $this->pdo->prepare('SELECT * FROM oeuvres');
      $req->execute();
      return $req->fetchAll();
   }

   public function getOeuvre($id_oeuvre)
   {
      $req = $this->pdo->prepare(
         'SELECT *
         FROM oeuvres
         WHERE oeuvres.id_oeuvre = ?
         AND oeuvres.id_oeuvre = oeuvres.id_oeuvre');
      $req->execute([$id_oeuvre]);
      return $req->fetch();
   }
  
   public function getByStyle($style)
   {
      $req = $this->pdo->prepare(
        'SELECT *
         FROM oeuvres
         WHERE style
         LIKE "%'.$style.'%"');
      $req->execute();
      return $req->fetchAll();
   }
}

