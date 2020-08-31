<?php
namespace App\Models;

use App\Models\Model;

class Comments extends Model
{
   public function __construct()
   {
      $this->pdo = parent::getPdo();
   }

   /**
   *  recherche tous les commentaires de la BDD
   */
   public function getAllComments()
   {
      $req = $this->pdo->prepare('SELECT * FROM comments ORDER BY `date` DESC');
      $req->execute();

      return $req->fetchAll();
   }

   public function addComment($id_user, $title, $content, $note)
   {
      $req = $this->pdo->prepare('INSERT INTO comments (id_user, title, content, note)
      VALUE (?, ?, ?, ?)');
      $req->execute([$id_user, $title, $content, $note]);
      //Récupère l'id de l'insertion dans la table
      return $this->pdo->lastInsertId();
   }

   public function addUsersComments($id_user, $id_comment)
   {
      $req = $this->pdo->prepare('INSERT INTO users_comments (id_user, id_comment)
      VALUE (?, ?)');
      return $req->execute([$id_user, $id_comment]);
   }

   public function addOeuvreComments($id_oeuvre, $id_comment)
   {
      $req = $this->pdo->prepare('INSERT INTO oeuvre_comments (id_oeuvre, id_comment)
      VALUE (?, ?)');
      return $req->execute([$id_oeuvre, $id_comment]);
   }
   
   public function linkCommentByOeuvre($id)
   {

      $req = $this->pdo->prepare(
         'SELECT comments.*
         FROM oeuvres, oeuvre_comments, comments
         WHERE oeuvres.id_oeuvre = ?
         AND oeuvres.id_oeuvre = oeuvre_comments.id_oeuvre
         AND comments.id_comment = oeuvre_comments.id_comment
         ORDER BY `date` DESC');
      $req->execute([$id]);

      return $req->fetchAll();
   }
}
