<?php
namespace App\Models;

use App\Models\Model;

class Prestations extends Model
{
    public function __construct()
    {
        $this->pdo = parent::getPdo();
    }

    public function getAllPrestations()
    {
        $req = $this->pdo->prepare('SELECT * FROM prestations');
        $req->execute();
        return $req->fetchAll();
    }

    public function getPrestation($id_prestation)
    {
        $req = $this->pdo->prepare(
            'SELECT *
         FROM prestations
         WHERE prestations.id_prestation = ?
         AND prestations.id_prestation = prestations.id_prestation'
        );
        $req->execute([$id_prestation]);
        return $req->fetch();
    }
  
    public function getByStyle($style)
    {
        $req = $this->pdo->prepare(
            'SELECT *
         FROM prestation
         WHERE style
         LIKE "%'.$style.'%"'
        );
        $req->execute();
        return $req->fetchAll();
    }
}
