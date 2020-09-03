<?php
namespace App\Controllers;

use App\Models\Users;
use App\Models\Objets;
use App\Models\Comments;
use App\Controllers\Controller;

class ObjetsController extends Controller
{

    public function __construct()
    {
      
        parent::__construct();
        $this->model = new Objets();
    }

    public function showAllObjets()
    {
        $pageTwig = 'Objets/showAllObjets.html.twig';
        $template = $this->twig->load($pageTwig);
        $objets   = $this->model->getAllObjets();
        echo $template->render([
          'objets' => $objets,
          'status' => $_SESSION['status'],
          'alertMessage' => $_SESSION['receiveMessage']
        ]);
    }

    public function genre($style = null)
    {
        $slug = null;
        $notFound = null;
 
       
        if ($slug = "Genre") {
            if (!empty($_POST['style'])) {
                $style = $_POST['style'];
                $style = $this->model->getByStyle($style);
            } else {
                $notFound = "Nous n'avons pas d objet dans cette catégorie !";
            }
        }
 
        $pageTwig = 'Objets/showAllObjets.html.twig';
        $template = $this->twig->load($pageTwig);
        $objets   = $this->model->getAllObjets();
        echo $template->render([
          'slug' => $slug,
          'objets' => $objets,
          'style' => $style,
          'notFound' => $notFound,
          'alertMessage' => $_SESSION['receiveMessage']
        ]);
    }

    public function showObjet($id_objet, $displayAlert = null, $anchor = null)
    {
 
    
        $instanceComments = new Comments();
        $comments = $instanceComments->CommentByObjet($id_objet);
  
  
        $instanceUser = new Users();
        if (isset($_SESSION['alert'])) {
            echo $_SESSION['alert'];
            unset($_SESSION['alert']);
        }
  
     
        for ($i = 0; $i < count($comments); $i++) {
            $id_user = $comments[$i]['id_user'];
  
           
            $user = $instanceUser->getOnePseudo($id_user);
            $mail = $instanceUser->getMailById($id_user);
        }
        
        date_default_timezone_set('Europe/Paris');
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
  
        $user = null;
        
        if ($_SESSION['status'] === 2) {
            $user = $instanceUser->getOneUser($_SESSION['utilisateur']);
        } else {
            $user = "Vous devez être connecté pour déposer un commentaire";
        }
        
        $objet = $this->model->getObjet($id_objet);
  
        $pageTwig = 'Objets/showObjet.html.twig';
        $template = $this->twig->load($pageTwig);
  
        
        if (isset($_SESSION['tmpComment'])) {
            echo $template->render([
              "objet"        => $objet,
              "comments"     => $comments,
              "user"         => $user,
              "datedujour"   => strftime("%A %d %B %Y"),
              "status"       => $_SESSION['status'],
              "tmpTitle"     => $_SESSION['tmpTitle'],
              "tmpComment"   => $_SESSION['tmpComment'],
              "tmpNote"      => $_SESSION['tmpNote'],
              "status"       => $_SESSION['status'],
              "userLogin"    => $_SESSION['utilisateur'],
              'alertMessage' => $_SESSION['receiveMessage'],
              "alert"        => $displayAlert,
              "anchor"       => 'anchor']);
        } else {
            echo $template->render([
              "objet"        => $objet,
              "comments"     => $comments,
              "user"         => $user,
              "datedujour"   => strftime("%A %d %B %Y"),
              "status"       => $_SESSION['status'],
              "userLogin"    => $_SESSION['utilisateur'],
              "alertMessage" => $_SESSION['receiveMessage'],
              "alert"        => $displayAlert,
              "anchor"       => 'anchor']);
        }
    }
}
