<?php
namespace App\Controllers;

use App\Models\Users;
use App\Models\Oeuvres;
use App\Models\Comments;
use App\Controllers\Controller;

class OeuvresController extends Controller
{
    
   
    public function __construct()
    {
       
        parent::__construct();
        $this->model = new Oeuvres();
    }
 
    public function showAllOeuvres()
    {
        $pageTwig = 'Oeuvres/showAllOeuvres.html.twig';
        $template = $this->twig->load($pageTwig);
        $oeuvres   = $this->model->getAllOeuvres();
        echo $template->render([
          'oeuvres' => $oeuvres,
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
                $notFound = "Nous n'avons pas de oeuvre dans cette catégorie !";
            }
        }
 
        $pageTwig = 'Oeuvres/showAllOeuvres.html.twig';
        $template = $this->twig->load($pageTwig);
        $oeuvres   = $this->model->getAllOeuvres();
        echo $template->render([
          'slug' => $slug,
          'oeuvres' => $oeuvres,
          'style' => $style,
          'notFound' => $notFound,
          'alertMessage' => $_SESSION['receiveMessage']
        ]);
    }
 
    
    public function showOeuvre($id_oeuvre, $displayAlert = null, $anchor = null)
    {
 
    
        $instanceComments = new Comments();
        $comments = $instanceComments->commentByOeuvre($id_oeuvre);
 
 
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
       
        $oeuvre = $this->model->getOeuvre($id_oeuvre);
 
        $pageTwig = 'Oeuvres/showOeuvre.html.twig';
        $template = $this->twig->load($pageTwig);
 
       
        if (isset($_SESSION['tmpComment'])) {
            echo $template->render([
             "oeuvre"        => $oeuvre,
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
             "oeuvre"        => $oeuvre,
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
