<?php
namespace App\Models;

use App\Models\Model;

class Users extends Model
{
    public function __construct()
    {
        $this->pdo = parent::getPdo();
    }

    public function checkLogin($pseudo)
    {
        $req = $this->pdo->prepare('SELECT pseudo, mdp, admin FROM users WHERE pseudo = :pseudo');
        $req->bindValue(':pseudo', $pseudo);
        $req->execute();
        $data = $req->fetch();
        return $data;
    }

    public function insertUser($pseudo, $mdp, $mail)
    {
        $req = $this->pdo->prepare("INSERT INTO users(pseudo, mdp, mail) VALUES (:pseudo, :mdp, :mail)");
        return $req->execute(array(
         'pseudo' => $pseudo,
         'mdp' => $mdp,
         'mail' => $mail,
        ));
    }

    public function pseudoExist($pseudo)
    {
        $req = $this->pdo->prepare("SELECT pseudo FROM users WHERE pseudo = :pseudo");
        $req->bindValue(':pseudo', $pseudo);
        $req->execute();
        return $req->fetch();
    }

    public function mailExist($mail)
    {
        $req = $this->pdo->prepare("SELECT mail FROM users WHERE mail = :mail");
        $req->bindValue(':mail', $mail);
        $req->execute();
        return $req->fetch();
    }

    public function getOneUser($pseudo)
    {
        $req = $this->pdo->prepare('SELECT * FROM users WHERE pseudo= ?');
        $req->execute([$pseudo]);
        return $req->fetch();
    }

    public function getOnePseudo($id_user)
    {
        $req = $this->pdo->prepare('SELECT pseudo FROM users WHERE id_user= ?');
        $req->execute([$id_user]);
        return $req->fetch();
    }
   
    public function getMailById($id_user)
    {
        $req = $this->pdo->prepare('SELECT `mail` FROM users WHERE id_user= ?');
        $req->execute([$id_user]);
        return $req->fetch();
    }

    public function setUpdateLogTime($pseudo)
    {
        $req = $this->pdo->prepare("UPDATE users SET time_log = NOW() WHERE pseudo= ?");
        $req->execute([$pseudo]);
    }
}
