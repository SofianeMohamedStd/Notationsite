<?php
namespace App\Controllers;

use App\Models\Users;
use App\Models\Comments;
use App\Models\Prestations;
use App\Controllers\Controller;

class PrestationsController extends Controller
{
    
   
    public function __construct()
    {
       
        parent::__construct();
        $this->model = new Prestations();
    }
 
    public function showAllPrestations()
    {
        $pageTwig = 'Prestations/showAllPrestations.html.twig';
        $template = $this->twig->load($pageTwig);
        $prestations   = $this->model->getAllPrestations();
        echo $template->render([
          'prestations' => $prestations,
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
 
        $pageTwig = 'Prestations/showAllPrestations.html.twig';
        $template = $this->twig->load($pageTwig);
        $prestations   = $this->model->getAllPrestations();
        echo $template->render([
          'slug' => $slug,
          'prestations' => $prestations,
          'style' => $style,
          'notFound' => $notFound,
          'alertMessage' => $_SESSION['receiveMessage']
        ]);
    }
 
    
    public function showPrestation($id_prestation, $displayAlert = null, $anchor = null)
    {
 
    
        $instanceComments = new Comments();
        $comments = $instanceComments->commentByPrestation($id_prestation);
 
 
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
       
        $prestation = $this->model->getPrestation($id_prestation);
 
        $pageTwig = 'Prestations/showPrestation.html.twig';
        $template = $this->twig->load($pageTwig);
 
       
        if (isset($_SESSION['tmpComment'])) {
            echo $template->render([
             "prestation"   => $prestation,
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
             "prestation"        => $prestation,
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
