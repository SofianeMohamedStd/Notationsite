<?php
namespace App\Models;

use App\Models\Model;

class Comments extends Model
{
    public function __construct()
    {
        $this->pdo = parent::getPdo();
    }


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

    public function addObjetComments($id_objet, $id_comment)
    {
        $req = $this->pdo->prepare('INSERT INTO objet_comments (id_objet, id_comment)
      VALUE (?, ?)');
        return $req->execute([$id_objet, $id_comment]);
    }

    public function addPrestationComments($id_prestation, $id_comment)
    {
        $req = $this->pdo->prepare('INSERT INTO prestation_comments (id_prestation, id_comment)
      VALUE (?, ?)');
        return $req->execute([$id_prestation, $id_comment]);
    }
   
   
    public function commentByOeuvre($id)
    {

        $req = $this->pdo->prepare(
            'SELECT comments.*
         FROM oeuvres, oeuvre_comments, comments
         WHERE oeuvres.id_oeuvre = ?
         AND oeuvres.id_oeuvre = oeuvre_comments.id_oeuvre
         AND comments.id_comment = oeuvre_comments.id_comment
         ORDER BY `date` DESC'
        );
        $req->execute([$id]);

        return $req->fetchAll();
    }
    public function commentByObjet($id)
    {

        $req = $this->pdo->prepare(
            'SELECT comments.*
         FROM objets, objet_comments, comments
         WHERE objets.id_objet = ?
         AND objets.id_objet = objet_comments.id_objet
         AND comments.id_comment = objet_comments.id_comment
         ORDER BY `date` DESC'
        );
        $req->execute([$id]);

        return $req->fetchAll();
    }
    public function commentByPrestation($id)
    {

        $req = $this->pdo->prepare(
            'SELECT comments.*
         FROM prestations, prestation_comments, comments
         WHERE prestations.id_prestation = ?
         AND prestation.id_prestation = prestation_comments.id_prestation
         AND comments.id_comment = prestation_comments.id_comment
         ORDER BY `date` DESC'
        );
        $req->execute([$id]);

        return $req->fetchAll();
    }
}
