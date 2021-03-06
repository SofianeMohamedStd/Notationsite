<?php
namespace App\Controllers;

use App\Models\Users;
use App\Models\Comments;
use App\Controllers\Controller;
use App\Controllers\HomeController;
use App\Controllers\ObjetsController;
use App\Controllers\OeuvresController;
use App\Controllers\PrestationsController;

class CommentsController extends Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->model = new Comments();
    }
 
    /**
     *  render index
     */
    public function index()
    {
        $pageTwig = 'Comments/index.html.twig';
        $template = $this->twig->load($pageTwig);
        echo $template->render(['alertMessage' => $_SESSION['receiveMessage']]);
    }
   
    public function commentairetemporaire($id_oeuvre, $displayAlert)
    {
 
        $_SESSION['tabSession'] = [];
 
        $instanceHome = new HomeController();
       
        $instanceHome->__set('tmpTitle', $instanceHome->__getPOST('title'));
        $_SESSION['tabSession'][] = 'tmpTitle';
        $instanceHome->__set('tmpComment', $instanceHome->__getPOST('controlText'));
        $_SESSION['tabSession'][] = 'tmpComment';
        $instanceHome->__set('tmpNote', $instanceHome->__getPOST('note'));
        $_SESSION['tabSession'][] = 'tmpNote';
        $instanceHome->__set('location', "$this->baseUrl/Oeuvres/Oeuvre_$id_oeuvre");
        $_SESSION['tabSession'][] = 'location';
 
 
        $instanceOeuvres = new OeuvresController();
        $instanceOeuvres->showOeuvre($id_oeuvre, $displayAlert);
    }

    public function commentairetemporaireObject($id_objet, $displayAlert)
    {
 
        $_SESSION['tabSession'] = [];
 
        $instanceHome = new HomeController();
       
        $instanceHome->__set('tmpTitle', $instanceHome->__getPOST('title'));
        $_SESSION['tabSession'][] = 'tmpTitle';
        $instanceHome->__set('tmpComment', $instanceHome->__getPOST('controlText'));
        $_SESSION['tabSession'][] = 'tmpComment';
        $instanceHome->__set('tmpNote', $instanceHome->__getPOST('note'));
        $_SESSION['tabSession'][] = 'tmpNote';
        $instanceHome->__set('location', "$this->baseUrl/Objets/Objet_$id_objet");
        $_SESSION['tabSession'][] = 'location';
 
 
        $instanceObjets = new ObjetsController();
        $instanceObjets->showObjet($id_objet, $displayAlert);
    }

    public function commentairetemporairePrestation($id_prestation, $displayAlert)
    {
 
        $_SESSION['tabSession'] = [];
 
        $instanceHome = new HomeController();
       
        $instanceHome->__set('tmpTitle', $instanceHome->__getPOST('title'));
        $_SESSION['tabSession'][] = 'tmpTitle';
        $instanceHome->__set('tmpComment', $instanceHome->__getPOST('controlText'));
        $_SESSION['tabSession'][] = 'tmpComment';
        $instanceHome->__set('tmpNote', $instanceHome->__getPOST('note'));
        $_SESSION['tabSession'][] = 'tmpNote';
        $instanceHome->__set('location', "$this->baseUrl/Prestations/Prestation_$id_prestation");
        $_SESSION['tabSession'][] = 'location';
 
 
        $instancePrestations = new PrestationsController();
        $instancePrestations->showPrestation($id_prestation, $displayAlert);
    }
 
    public function addComment($id_oeuvre)
    {
 
        $instanceHome = new HomeController();
        $instanceHome->__set('id_oeuvre', $id_oeuvre);
 
        if ($instanceHome->__get('status') === 2) {
            $instanceUsers = new Users();
            $user = $instanceUsers->getOneUser($instanceHome->__get('utilisateur'));
            $id_user = $user['id_user'];
 
          
            if (isset($_POST) && !empty($instanceHome->__getPOST('title')) && !empty($instanceHome->__getPOST('controlText'))) {
                $title = $instanceHome->__getPOST('title');
                $content = $instanceHome->__getPOST('controlText');
                $note = $instanceHome->__getPOST('note');
 
             
                $idComment = $this->model->addComment($id_user, $title, $content, $note);
             
                $this->model->addUsersComments($id_user, $idComment);
             
                $this->model->addOeuvreComments($id_oeuvre, $idComment);
 
                header("Location: $this->baseUrl/Oeuvres/Oeuvre_$id_oeuvre");
            } else {
                $displayAlert = '<div class=" text-center" id="alerte" data-location="$this->baseUrl/Oeuvres/Oeuvre_' . $_SESSION['id_oeuvre'] .'" ><strong>Erreur...</strong> Votre commentaire n\'a pas été publié car il est incomplet!</div>';
 
                $this->commentairetemporaire($id_oeuvre, $displayAlert);
            }
        } else {
            $displayAlert = '<div class="text-center" id="alerte" data-location="$this->baseUrl/Oeuvres/Oeuvre_' . $_SESSION['id_oeuvre'] .'" ><strong>Erreur...</strong> Vous devez vous identifier vous publier!</div>';
 
          
            $this->commentairetemporaire($id_oeuvre, $displayAlert);
        }
    }



    public function addCommentObjet($id_objet)
    {
 
        $instanceHome = new HomeController();
        $instanceHome->__set('id_objet', $id_objet);
 
        if ($instanceHome->__get('status') === 2) {
            $instanceUsers = new Users();
            $user = $instanceUsers->getOneUser($instanceHome->__get('utilisateur'));
            $id_user = $user['id_user'];
 
          
            if (isset($_POST) && !empty($instanceHome->__getPOST('title')) && !empty($instanceHome->__getPOST('controlText'))) {
                $title = $instanceHome->__getPOST('title');
                $content = $instanceHome->__getPOST('controlText');
                $note = $instanceHome->__getPOST('note');
 
             
                $idComment = $this->model->addComment($id_user, $title, $content, $note);
             
                $this->model->addUsersComments($id_user, $idComment);
             
                $this->model->addObjetComments($id_objet, $idComment);
 
                header("Location: $this->baseUrl/Objets/Objet_$id_objet");
            } else {
                $displayAlert = '<div class=" text-center" id="alerte" data-location="$this->baseUrl/Objets/Objet_' . $_SESSION['id_objet'] .'" ><strong>Erreur...</strong> Votre commentaire n\'a pas été publié car il est incomplet!</div>';
 
                $this->commentairetemporaireObject($id_objet, $displayAlert);
            }
        } else {
            $displayAlert = '<div class="text-center" id="alerte" data-location="$this->baseUrl/Objets/Objet_' . $_SESSION['id_objet'] .'" ><strong>Erreur...</strong> Vous devez vous identifier vous publier!</div>';
 
          
            $this->commentairetemporaireObject($id_objet, $displayAlert);
        }
    }


    public function addCommentPrestation($id_prestation)
    {
 
        $instanceHome = new HomeController();
        $instanceHome->__set('id_prestation', $id_prestation);
 
        if ($instanceHome->__get('status') === 2) {
            $instanceUsers = new Users();
            $user = $instanceUsers->getOneUser($instanceHome->__get('utilisateur'));
            $id_user = $user['id_user'];
 
          
            if (isset($_POST) && !empty($instanceHome->__getPOST('title')) && !empty($instanceHome->__getPOST('controlText'))) {
                $title = $instanceHome->__getPOST('title');
                $content = $instanceHome->__getPOST('controlText');
                $note = $instanceHome->__getPOST('note');
 
             
                $idComment = $this->model->addComment($id_user, $title, $content, $note);
             
                $this->model->addUsersComments($id_user, $idComment);
             
                $this->model->addPrestationComments($id_prestation, $idComment);
 
                header("Location: $this->baseUrl/Prestations/Prestation_$id_prestation");
            } else {
                $displayAlert = '<div class=" text-center" id="alerte" data-location="$this->baseUrl/Prestations/Prestation_' . $_SESSION['id_prestation'] .'" ><strong>Erreur...</strong> Votre commentaire n\'a pas été publié car il est incomplet!</div>';
 
                $this->commentairetemporairePrestation($id_prestation, $displayAlert);
            }
        } else {
            $displayAlert = '<div class="text-center" id="alerte" data-location="$this->baseUrl/Prestations/Prestation_' . $_SESSION['id_prestation'] .'" ><strong>Erreur...</strong> Vous devez vous identifier vous publier!</div>';
 
          
            $this->commentairetemporairePrestation($id_prestation, $displayAlert);
        }
    }

 
    
     
    public function postAfterLogin()
    {
 
        $instanceHome = new HomeController();
      
 
        if (empty($_SESSION['tmpTitle']) || empty($_SESSION['tmpComment'])) {
            $location = $instanceHome->__get('location');
            header("Location: $location");
        } else {
            $instanceUsers = new Users();
         
            $user = $instanceUsers->getOneUser($instanceHome->__get('utilisateur'));
          
            $id_user = $user['id_user'];
 
          
            $idComment = $this->model->addComment($id_user, $instanceHome->__get('tmpTitle'), $instanceHome->__get('tmpComment'), $instanceHome->__get('tmpNote'));
          
            $result = $this->model->addUsersComments($id_user, $idComment);
            if ($result === true) {
                $result = $this->model->addOeuvreComments($instanceHome->__get('id_oeuvre'), $idComment);
                if ($result === true) {
                    $location = $instanceHome->__get('location');
                    $instanceHome->__unsetTab();
                }
            }
            if ($result === false) {
                $location = $instanceHome->__get('location');
            }
        }
    }

    public function postAfterLoginObjet()
    {
 
        $instanceHome = new HomeController();
      
 
        if (empty($_SESSION['tmpTitle']) || empty($_SESSION['tmpComment'])) {
            $location = $instanceHome->__get('location');
            header("Location: $location");
        } else {
            $instanceUsers = new Users();
         
            $user = $instanceUsers->getOneUser($instanceHome->__get('utilisateur'));
          
            $id_user = $user['id_user'];
 
          
            $idComment = $this->model->addComment($id_user, $instanceHome->__get('tmpTitle'), $instanceHome->__get('tmpComment'), $instanceHome->__get('tmpNote'));
          
            $result = $this->model->addUsersComments($id_user, $idComment);
            if ($result === true) {
                $result = $this->model->addObjetComments($instanceHome->__get('id_objet'), $idComment);
                if ($result === true) {
                    $displayAlert = '<div class=" text-center" id="alerte" data-location="$this->baseUrl/Objets/Objet_' . $_SESSION['id_objet'] .'" ><strong>Succès...</strong> Votre commentaire a bien été publié. Merci.</div>';
                
                    $location = $instanceHome->__get('location');
                    $instanceHome->__unsetTab();
                }
            }
            if ($result === false) {
                $displayAlert = '<div class=" text-center" id="alerte" data-location="$this->baseUrl/Objets/Objet_' . $_SESSION['id_objet'] .'" ><strong>Erreur...</strong>Un erreur est survenu lors de la connexion a la base de données.Veuillez recommencer</div>';

                $location = $instanceHome->__get('location');
            }
        }
    }

    public function postAfterLoginPrestation()
    {
 
        $instanceHome = new HomeController();
      
 
        if (empty($_SESSION['tmpTitle']) || empty($_SESSION['tmpComment'])) {
            $location = $instanceHome->__get('location');
            header("Location: $location");
        } else {
            $instanceUsers = new Users();
         
            $user = $instanceUsers->getOneUser($instanceHome->__get('utilisateur'));
          
            $id_user = $user['id_user'];
 
          
            $idComment = $this->model->addComment($id_user, $instanceHome->__get('tmpTitle'), $instanceHome->__get('tmpComment'), $instanceHome->__get('tmpNote'));
          
            $result = $this->model->addUsersComments($id_user, $idComment);
            if ($result === true) {
                $result = $this->model->addPrestationComments($instanceHome->__get('id_prestation'), $idComment);
                if ($result === true) {
                    $displayAlert = '<div class=" text-center" id="alerte" data-location="$this->baseUrl/Prestations/Prestation_' . $_SESSION['id_prestation'] .'" ><strong>Succès...</strong> Votre commentaire a bien été publié. Merci.</div>';
                
                    $location = $instanceHome->__get('location');
                    $instanceHome->__unsetTab();
                }
            }
            if ($result === false) {
                $displayAlert = '<div class=" text-center" id="alerte" data-location="$this->baseUrl/Prestations/Prestation_' . $_SESSION['id_prestation'] .'" ><strong>Erreur...</strong>Un erreur est survenu lors de la connexion a la base de données.Veuillez recommencer</div>';

                $location = $instanceHome->__get('location');
            }
        }
    }
}
