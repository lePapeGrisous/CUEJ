<?php
session_start();

require_once('include/twig.php');
require_once('include/fonctions.php');
require_once('include/connexion.php');
require_once('include/theme.php');
require_once('include/article.php');
require_once('include/element.php');

// Initialisation de Twig
$twig = init_twig();

// Route (page/action/id) pour le contrôleur
if (isset($_GET['page'])) $page = $_GET['page'];
else $page = '';
if (isset($_GET['action'])) $action = $_GET['action'];
else $action = 'read';
if (isset($_GET['id'])) $id = intval($_GET['id']);
else $id = 0;

// Le tableau de données par défaut
$view = '';
$data = [];

switch ($page) {
	case 'theme':
		Theme::controleur($action, $id, $view, $data);
		break;
	case 'article':
		Article::controleur($action, $id, $view, $data);
		break;
	case 'element':
		Element::controleur($action, $id, $view, $data);
		break;
	default:
		$view = 'visitor_view/visit_themes.twig';
		$data = [];
}


// Ajoute les informations de login
echo $twig->render($view, $data);