<?php
namespace App\Models;

use App\Models\Model;

class Objets extends Model
{
    public function __construct()
    {
        $this->pdo = parent::getPdo();
    }

    public function getAllObjets()
    {
        $req = $this->pdo->prepare('SELECT * FROM objets');
        $req->execute();
        return $req->fetchAll();
    }

    public function getObjet($id_objet)
    {
        $req = $this->pdo->prepare(
            'SELECT *
         FROM objets
         WHERE objets.id_objet = ?
         AND objets.id_objet = objets.id_objet'
        );
        $req->execute([$id_objet]);
        return $req->fetch();
    }
   
    public function getByStyle($style)
    {
        $req = $this->pdo->prepare(
            'SELECT *
         FROM objets
         WHERE style
         LIKE "%'.$style.'%"'
        );
        $req->execute();
        return $req->fetchAll();
    }
}
