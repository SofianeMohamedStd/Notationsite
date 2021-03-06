<?php

use App\Router\Router;





require_once('vendor/autoload.php');
session_start();

$router = new Router($_GET['url']);

$router->get('/Oeuvres/Oeuvre_:id_oeuvre', 'Oeuvres.showOeuvre');
$router->post('/Oeuvres/Genre', 'Oeuvres.genre');
$router->get('/Oeuvre_:id_oeuvre', 'Oeuvres.showOeuvre');
$router->get('/Oeuvre', 'Oeuvres.showAllOeuvres');

$router->get('/Objets/Objet_:id_objet', 'Objets.showObjet');
$router->post('/Objets/Genre', 'Objets.genre');
$router->get('/Objet_:id_objet', 'Objets.showObjet');
$router->get('/Objet', 'Objets.showAllObjets');

$router->get('/Prestations/Prestation_:id_prestation', 'Prestations.showPrestation');
$router->post('/Prestations/Genre', 'Prestations.genre');
$router->get('/Prestation_:id_prestation', 'Prestations.showPrestation');
$router->get('/Prestation', 'Prestations.showAllPrestations');


$router->get('/Connection', 'Users.connexion');
$router->post('/Connexion/post', 'Users.connexion');

$router->get('/Inscription', 'Users.register');
$router->post('/Inscription/post', 'Users.register');

$router->post('/Bienvenue', 'Users.bienvenue');

$router->post('/Commentaires/Ajouter_:id_oeuvre', 'Comments.addComment');
$router->post('/CommentairesObjet/Ajouter_:id_objet', 'Comments.addCommentObjet');
$router->post('/CommentairesPrestation/Ajouter_:id_prestation', 'Comments.addCommentPrestation');
$router->get('/Commentaires', 'Comments.index');

$router->get('/Deconnection', 'Users.logout');

$router->get('/', 'Home.index');

$router->run();