<?php
namespace App\Controllers;

use App\Entites\User;
use App\Models\Users;
use App\Controllers\Controller;
use App\Controllers\HomeController;
use App\Controllers\CommentsController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class UsersController extends Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->model = new Users();
        $this->control = new User();
        $this->request = Request::createFromGlobals();
        $this->session = new Session();
    }

  
    public function connexion($slug = null)
    {
        $userInfo = null;
        $inputPseudo = "";
        $error = [];
        $userInfo = null;

     
        foreach ($_POST as $value) {
            if (empty($value)) {
                $error[] = " ";
            } else {
                $error[] = "";
                $userInfo = $this->model->checkLogin($this->request->get('pseudo'));

            
                if ($userInfo) {
                    $inputPseudo = $this->request->get('pseudo');
                    if (!empty($this->request->get('mdp'))) {
                        $hashMdp = $userInfo["mdp"];
                  
                        if (password_verify($this->request->get('mdp'), $hashMdp)) {
                            $this->model->setUpdateLogTime($inputPseudo);

                            $instanceHome = new HomeController();
                            $instanceHome->__set('utilisateur',$this->request->get('pseudo'));
                            $_SESSION['status'] = 2;
                            if (isset($_SESSION['location'])) {
                                $instanceComments = new CommentsController();
                          
                                 $instanceComments->postAfterLogin();
                           
                                 $instanceComments->postAfterLoginObjet();

                                 $instanceComments->postAfterLoginPrestation();
                            } else {
                                if (!$instanceHome->__empty('utilisateur')) {
                                    $pageTwig = 'index.html.twig';
                                    $template = $this->twig->load($pageTwig);
                                    echo $template->render(['status' => $_SESSION['status'],
                                     'alertMessage' => $_SESSION['receiveMessage']]);
                                    exit;
                                }
                            }
                        } else {
                            $error[1] = "Mot de passe incorrect";
                        }
                    }
                } else {
                    if ($_POST['pseudo'] == "") {
                        $error[] = "";
                    } else {
                        $error[0] = 'Le pseudo : "' . $_POST['pseudo'] . '" est inconnu de la base de données';
                    }
                }
            }
        }
        

        $title = "Connexion";

        $pageTwig = 'Users/login.html.twig';
        $template = $this->twig->load($pageTwig);
        echo $template->render([
         'slug' => $slug,
         'title' => $title,
         'error' => $error,
         'inputPseudo' => $inputPseudo
        ]);
    }
    public function register($slug = "Inscription")
    {
        $mail = null;
        $pseudo = null;
        $generalError = null;
        $error = [];
        $inputMail = null;
        $inputPseudo = null;

        foreach ($_POST as $value) {
            if (empty($value)) {
                $error[] = " ";
            } else {
                $error[] = "";

                $mail = $this->request->get('mail');
                if ($this->control->verifEmail($mail) === true) {
                    $userMail = $this->model->mailExist($mail);
                    if ($userMail === false) {
                        $inputMail = $mail;
                    } else {
                        $error[0] = 'Le mail : "' . $this->request->get('mail') . '" est existe déja';
                    }
                } else {
                    if ($_POST['mail'] === "") {
                        $error[0] = " ";
                    } else {
                        $error[0] = 'L\'adresse mail : "' . $this->request->get('mail') . '" ne correspond pas aux attentes';
                    }
                }

                $pseudo = $this->request->get('pseudo');
                if ($this->control->verifusername($pseudo) === true) {
                    $userPseudo = $this->model->pseudoExist($pseudo);
                    if ($userPseudo == false) {
                        $inputPseudo = $pseudo;
                    } else {
                        $error[1] = 'Ce pseudo : "' . $pseudo . '" existe déjà';
                    }
                } else {
                    if ($_POST['pseudo'] === "") {
                        $error[1] = " ";
                    } else {
                        $error[1] = "Le champ contient des caractères non valides.";
                    }
                }

                if ($this->control->verifPassword($this->request->get('pseudo')) === true) {
                    if ($inputPseudo && $inputMail) {
                        $hashMdp = password_hash($this->request->get('pseudo'), PASSWORD_DEFAULT);
                    } else {
                        if ($_POST === "") {
                            $error[] = " ";
                        }
                    }
                } else {
                    if ($this->request->get('pseudo') === "") {
                        $error[2] = " ";
                    } else {
                        $error[2] = "Le champ contient des caractères non valides";
                    }
                }
            }
        }
        if (isset($inputPseudo) && isset($hashMdp) && isset($inputMail)) {
            $avatar = "jatilogo.png";
         
            $insert = $this->model->insertUser($inputPseudo, $hashMdp, $inputMail, $avatar);
            if ($insert === true) {
                $instanceHome = new HomeController();
                $instanceHome->__set('utilisateur', $inputPseudo);
            
                if (!$instanceHome->__empty('utilisateur')) {
                    $_SESSION['status'] = 2;
                    $slug = "Bienvenue";
                    $title = "Bienvenue chez Allo Jati";
            
                    $pageTwig = 'Users/login.html.twig';
                    $template = $this->twig->load($pageTwig);
                    echo $template->render([
                    'slug' => "Bienvenue",
                    'title' => $title,
                    'status' => $_SESSION['status'],
                    'user' => $_SESSION['utilisateur'],
                    ]);
                     exit;
                }
            } else {
                $generalError = "Malheureusement nous n'avons pas pu vous créer un compte";
            }
        }

      
        $title = "Inscription";

        $pageTwig = 'Users/login.html.twig';
        $template = $this->twig->load($pageTwig);
        echo $template->render([
         'slug' => $slug,
         'title' => $title,
         'generalError' => $generalError,
         'error' => $error,
         'inputMail' => $inputMail,
         'inputPseudo' => $inputPseudo
        ]);
    }
    public function logout()
    {
        $instanceHome = new HomeController();
        $instanceHome->destroy();
        header("Location: $this->baseUrl");
    }
}
