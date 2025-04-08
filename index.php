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
$data = [];

switch ($page) {
	case 'theme':
		Theme::controleur($action, $id, $view, $data);
		break;
	case 'article':
		switch ($action) {
			case 'read':
				$view = 'details_article.twig';
				$article = Article::readOne($id);
				$elements = Element::readByArticle($id);
				$data = [
					'article' => $article,
					'elements' => $elements
				];
				break;
			case 'create':
				$article = new Article();
				$messages = [];
				// Si le formulaire article a été rempli
				if (isset($_POST['form_article'])) {
					$ok = $article->lirePost($messages);
					if ($ok) {
						$article->create();
						header('Location: ?page=article&id=' . $article->id);
					}
				}
				// Sinon affiche le formulaire article
				$view = 'form_article.twig';
				$theme = Theme::readOne($id);
				$data = [
					'theme' => $theme,
					'article' => $article,
					'elements' => [],
					'messages' => $messages
				];
				break;

			case 'update':
				$article = Article::readOne($id);
				$messages = [];
				// Si le formulaire article a été rempli
				if (isset($_POST['form_article'])) {
					$ok = $article->lirePost($messages);
					if ($ok) {
						$article->update();
						header('Location: ?page=article&id=' . $article->id);
					}
				}
				// Sinon affiche le formulaire article
				$elements = Element::readByArticle($id);
				$view = 'form_article.twig';
				$data = [
					'article' => $article,
					'elements' => $elements,
					'messages' => $messages
				];
				break;

			case 'confirm_delete':
				$article = Article::readOne($id);
				$elements = Element::readByArticle($id);
				$nb_elements = count($elements);
				$view = 'delete_article.twig';
				$data = [
					'article' => $article,
					'nb_elements' => $nb_elements
				];
				break;

			case 'delete':
				$article = Article::readOne($id);
				$id_theme = $article->id_theme;
				$article->delete();
				header('Location: ?page=theme&id=' . $id_theme);
				break;

			case 'exchange':
				$article = Article::readOne($id);
				$id_theme = $article->id_theme;
				$article->exchangeOrder();
				header('Location: ?page=theme&id=' . $id_theme);
				break;
		}
		break;

	case 'element':
		switch ($action) {
			case 'create':
				$element = new Element();
				$messages = [];
				// Si le formulaire élément a été rempli
				if (isset($_POST['form_element'])) {
					$ok = $element->chargePOST($messages);
					// Si le formulaire est bien rempli
					if ($ok) {
						$element->create();
						header('Location: ?page=article&action=update&id=' . $id);
					}
				}
				// Sinon affiche le formulaire
				$view = 'ajouter_elements.twig';
				$article = Article::readOne($id);
				$videos = listVideo();
				$data = [
					'article' => $article,
					'element' => $element,
					'videos' => $videos,
					'messages' => $messages
				];
				break;

			case 'update':
				$element = Element::readOne($id);
				$messages = [];
				// Si le formulaire article a été rempli
				if (isset($_POST['form_element'])) {
					$ok = $element->chargePOST($messages);
					if ($ok) {
						$element->update();
						header('Location: ?page=article&action=update&id=' . $element->id_article);
					}
				}
				// Sinon affiche le formulaire article
				$view = 'ajouter_elements.twig';
				$article = Article::readOne($element->id_article);
				$videos = listVideo();
				$data = [
					'article' => $article,
					'element' => $element,
					'videos' => $videos,
					'messages' => $messages
				];
				break;

			case 'delete':
				$element = Element::readOne($id);
				$id_article = $element->id_article;
				$element->delete();
				header('Location: ?page=article&action=update&id=' . $id_article);
				break;

			case 'exchange':
				$element = Element::readOne($id);
				$id_article = $element->id_article;
				$element->exchangeOrder();
				header('Location: ?page=article&action=update&id=' . $id_article);
				break;
		}
		break;

	case 'login':
		$view = 'login.twig';
		break;
	case 'valid_login':
		// Teste si le formulaire login a été rempli
		if (isset($_POST['login'])) {
			$login = postString('login');
			// Si le mot de passe est correct
			if ($login == "mmi2024!") {
				// Enregistre le login dans la session et charge le controleur admin
				$_SESSION['login'] = $login;
				header('Location: admin.php');
			} else {
				// Mot de passe incorrect : retour à la page login
				unset($_SESSION['login']);
				header('Location: index.php?login');
			}
			//header('Location: index.php?login');
		} else {
			// Accès hors formulaire : retour à la page d'accueil
			header('Location: index.php');
		}
		break;
	default:
		Theme::controleur($action, $id, $view, $data);
}

// Ajoute les informations de login
echo $twig->render($view, $data);
