<?php

use phpDocumentor\Reflection\DocBlock\Tags\Var_;

require_once('fonctions.php');

class Article
{
	public $id;
	public $ordre;
	public $titre;
	public $redacteur;
	public $accroche;
	public $type;
	public $id_theme;

	// Le constructeur corrige les données récupérées de la BDD
	// Ici convertie les clés et l'ordre (pour le tri) en entier
	function __construct()
	{
		$this->id = intval($this->id);
		$this->ordre = intval($this->ordre);
		$this->id_theme = intval($this->id_theme);
	}

	static function readAll()
	{
		$sql = 'SELECT * FROM article ORDER BY ordre AND SELECT * AS liste_themes FROM theme WHERE id_theme = :id';
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_CLASS, 'Article');
	}

	static function readOne($id)
	{
		$sql = 'SELECT * FROM article WHERE id = :id';
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute();
		return $query->fetchObject('Article');
	}

	// Récupère les articles d'un thème
	static function readAllByTheme($id)
	{
		$sql = 'SELECT * FROM article WHERE id_theme = :id ORDER BY ordre';
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_CLASS, 'Article');
	}

	// Récupère l'ordre maximal des articles d'un thème
	static function readOrderMax($id)
	{
		$sql = 'SELECT max(ordre) AS maximum FROM article WHERE id_theme = :id';
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute();
		$objet = $query->fetchObject();
		return intval($objet->maximum);
	}

	// Echange l'ordre de deux articles
	function exchangeOrder()
	{
		// Recherche l'article précédent (dans le même thème)
		// C'est l'article le plus grand, parmi les articles d'ordre inférieur

		// étape 1 : cherche les articles du même thème ayant un ordre inférieur
		$sql = 'SELECT * FROM article
				WHERE id_theme = :id_theme AND ordre < :ordre ORDER BY ordre DESC';
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->bindValue(':id_theme', $this->id_theme, PDO::PARAM_INT);
		$query->bindValue(':ordre', $this->ordre, PDO::PARAM_INT);
		$query->execute();

		// étape 2 : les articles sont triés par ordre décroissant
		// donc le premier article est le plus grand des plus petits, donc le précédent
		$before = $query->fetchObject('Article');

		// Si le précédent existe (l'article courant n'est pas le premier)
		if ($before) {
			// Échange les valeurs d'ordre et enregistre dans la BDD
			$tmp = $this->ordre;
			$this->ordre = $before->ordre;
			$this->update();
			$before->ordre = $tmp;
			$before->update();
		}
	}

	function create()
	{
		// Récupère l'ordre maximum pour créer l'article en dernière position
		$maximum = self::readOrderMax($this->id_theme);
		$this->ordre = $maximum + 1;

		$sql = "INSERT INTO article (ordre, titre, accroche, redacteur, type, id_theme)
				VALUES (:ordre, :titre, :accroche, :redacteur, :type, :id_theme)";
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->bindValue(':ordre', $this->ordre, PDO::PARAM_INT);
		$query->bindValue(':titre', $this->titre, PDO::PARAM_STR);
		$query->bindValue(':accroche', $this->accroche, PDO::PARAM_STR);
		$query->bindValue(':redacteur', $this->redacteur, PDO::PARAM_STR);
		$query->bindValue(':type', $this->type, PDO::PARAM_STR);
		$query->bindValue(':id_theme', $this->id_theme, PDO::PARAM_INT);
		$query->execute();
		$this->id = $pdo->lastInsertId();
	}

	function update()
	{
		$sql = "UPDATE article
				SET ordre=:ordre, titre=:titre, accroche=:accroche, redacteur=:redacteur, type=:type
				WHERE id=:id";
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->bindValue(':id', $this->id, PDO::PARAM_INT);
		$query->bindValue(':ordre', $this->ordre, PDO::PARAM_INT);
		$query->bindValue(':titre', $this->titre, PDO::PARAM_STR);
		$query->bindValue(':accroche', $this->accroche, PDO::PARAM_STR);
		$query->bindValue(':redacteur', $this->redacteur, PDO::PARAM_STR);
		$query->bindValue(':type', $this->type, PDO::PARAM_STR);
		$query->execute();
	}

	function delete()
	{
		// Suppression du fichier lié
		if (!empty($this->type)) unlink('upload/' . $this->type);

		// Suppression de l'article
		$sql = "DELETE FROM article WHERE id=:id";
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->bindValue(':id', $this->id, PDO::PARAM_INT);
		$query->execute();
	}

	function chargePOST()
	{
		$this->id = postInt('id');
		$this->ordre = postInt('ordre');
		$this->titre = postString('titre');
		$this->redacteur = postString('redacteur');
		$this->accroche = postString('accroche');
		$this->type = postString('type');
		$this->id_theme = postInt('id_theme');
	}

// 	public function pageAction(): Response
// {
//     // Récupération du chemin actuel
//     $currentPath = $this->get('request_stack')->getCurrentRequest()->getPathInfo();

//     // Associer les chemins aux images
//     $backgroundImages = [
//         '/visitor.php?page=article&action=read&id=7' => 'nouveaufond.jpg',
//         '/visitor.php?page=article&action=read&id=10' => '675af833912a11.92463247.jpg',
//         '/visitor.php?page=article&action=read&id=14' => '6763e0cb7c9809.69351705.jpg',
//     ];

//     // Trouver l'image correspondante ou utiliser un fond par défaut
//     $backgroundImage = $backgroundImages[$currentPath] ?? 'default.jpg';

//     // Passer la variable au template Twig
//     return $this->render('visit_article.twig', [
//         'backgroundImage' => $backgroundImage, // Variable pour Twig
//     ]);
// }


	static function controleur($action, $id, &$view, &$data)
	{
		switch ($action) {
			case 'read':
				// Liste des articles d'un thème ($id)
				if ($id > 0) {
					$view = 'visitor_view/visit_article.twig';
					$data = [
						'article' => Article::readAllByTheme($id),
						'theme' => Theme::readOne($id),
					];
				} else {
					// Pas de thème sélectionné => retour à l'accueil
					header('Location: visitor.php?page=theme');
				}
				break;
			default:
				$view = 'visitor_view/visit_article.twig';
				$data = [
					'article' => Article::readOne($id)
				];
				break;
		}
	}

	static function controleurAdmin($action, $id, &$view, &$data)
	{
		switch ($action) {
			case 'read':
				// Liste des articles d'un thème ($id)
				if ($id > 0) {
					$view = 'article/detail_article.twig';
					$data = [
						'article' => Article::readOne($id),
						'liste_elements' => Element::readAllByArticle($id)
					];
				} else {
					// Pas de thème sélectionné => retour à l'accueil
					header('Location: admin.php?page=theme');
				}
				break;
			case 'new':
				$view = "article/form_article.twig";
				$data = ['id_theme' => $id];
				break;
			case 'create':
				$article = new Article();
				$article->chargePOST();
				$article->create();
				header('Location: admin.php?page=theme&id=' . $article->id_theme);
				break;
			case 'edit':
				$view = "article/edit_article.twig";
				$data = ['article' => Article::readOne($id)];
				break;
			case 'update':
				$article = new Article();
				$article->chargePOST();
				$article->update();
				header('Location: admin.php?page=theme&id=' . $article->id_theme);
				break;
			case 'delete':
				$article = Article::readOne($id);
				$article->delete();
				header('Location: admin.php?page=theme&id=' . $article->id_theme);
				break;
			case 'exchange':
				$article = Article::readOne($id);
				$article->exchangeOrder();
				$view = 'theme/detail_theme.twig';
				header('Location: admin.php?page=theme&id=' . $article->id_theme);
				break;
			default:
				$view = 'theme/liste_themes.twig';
				$data = [
					'liste_themes' => Article::readAll()
				];
				break;
		}
	}

	// Création de la table themes
	static function init()
	{
		// connexion
		$pdo = connexion();

		// suppression des données existantes le cas échéant
		$sql = 'drop table if exists article';
		$query = $pdo->prepare($sql);
		$query->execute();

		// création de la table 'theme'
		$sql = 'create table article (
				id serial primary key,
				ordre int,
				titre varchar(128),
				redacteur varchar(512),
				accroche text,
				type varchar(512),
				id_theme bigint unsigned,
    			foreign key (id_theme) references theme(id))';
		$query = $pdo->prepare($sql);
		$query->execute();
	}
}
