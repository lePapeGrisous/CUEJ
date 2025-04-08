<?php

use phpDocumentor\Reflection\DocBlock\Tags\Var_;

require_once('fonctions.php');

class Element
{
	public $id;
	public $ordre;
	public $type;
	public $contenu;
	public $image;
	public $son;
	public $video;
	public $alt;
	public $legende;
	public $id_article;


	// Le constructeur corrige les données récupérées de la BDD
	// Ici convertie les clés et l'ordre (pour le tri) en entier
	function __construct()
	{
		$this->id = intval($this->id);
		$this->ordre = intval($this->ordre);
		$this->id_article = intval($this->id_article);
		$this->contenu = filterText($this->contenu);
	}

	static function readOne($id)
	{
		$sql = 'SELECT * FROM element WHERE id = :id';
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute();
		return $query->fetchObject('Element');
	}

	// Récupère les elements d'un thème
	static function readAllByArticle($id)
	{
		$sql = 'SELECT * FROM element WHERE id_article = :id ORDER BY ordre';
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_CLASS, 'Element');
	}

	// Récupère l'ordre maximal des elements d'un thème
	static function readOrderMax($id)
	{
		$sql = 'SELECT max(ordre) AS maximum FROM element WHERE id_article = :id';
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->bindValue(':id', $id, PDO::PARAM_INT);
		$query->execute();
		$objet = $query->fetchObject();
		return intval($objet->maximum);
	}

	// Echange l'ordre de deux elements
	function exchangeOrder()
	{
		// Recherche l'element précédent (dans le même thème)
		// C'est l'element le plus grand, parmi les elements d'ordre inférieur

		// étape 1 : cherche les elements du même thème ayant un ordre inférieur
		$sql = 'SELECT * FROM element
				WHERE id_article = :id_article AND ordre < :ordre ORDER BY ordre DESC';
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->bindValue(':id_article', $this->id_article, PDO::PARAM_INT);
		$query->bindValue(':ordre', $this->ordre, PDO::PARAM_INT);
		$query->execute();

		// étape 2 : les elements sont triés par ordre décroissant
		// donc le premier element est le plus grand des plus petits, donc le précédent
		$before = $query->fetchObject('Element');

		// Si le précédent existe (l'element courant n'est pas le premier)
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
		// Récupère l'ordre maximum pour créer l'element en dernière position
		$maximum = self::readOrderMax($this->id_article);
		$this->ordre = $maximum + 1;

		$sql = "INSERT INTO element (ordre, type, contenu, image, alt, legende, id_article, son, video)
				VALUES (:ordre, :type, :contenu, :image, :alt, :legende, :id_article, :son, :video)";
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->bindValue(':ordre', $this->ordre, PDO::PARAM_INT);
		$query->bindValue(':type', $this->type, PDO::PARAM_STR);
		$query->bindValue(':contenu', $this->contenu, PDO::PARAM_STR);
		$query->bindValue(':image', $this->image, PDO::PARAM_STR);
		$query->bindValue(':alt', $this->alt, PDO::PARAM_STR);
		$query->bindValue(':legende', $this->legende, PDO::PARAM_STR);
		$query->bindValue(':id_article', $this->id_article, PDO::PARAM_INT);
		$query->bindValue(':son', $this->son, PDO::PARAM_STR);
		$query->bindValue(':video', $this->video, PDO::PARAM_STR);
		$query->execute();
		$this->id = $pdo->lastInsertId();
	}

	function update()
	{
		$sql = "UPDATE element
				SET ordre=:ordre, type=:type, contenu=:contenu, image=:image, alt=:alt, legende=:legende, son=:son, video=:video
				WHERE id=:id";
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->bindValue(':id', $this->id, PDO::PARAM_INT);
		$query->bindValue(':ordre', $this->ordre, PDO::PARAM_INT);
		$query->bindValue(':type', $this->type, PDO::PARAM_STR);
		$query->bindValue(':contenu', $this->contenu, PDO::PARAM_STR);
		$query->bindValue(':image', $this->image, PDO::PARAM_STR);
		$query->bindValue(':alt', $this->alt, PDO::PARAM_STR);
		$query->bindValue(':legende', $this->legende, PDO::PARAM_STR);
		$query->bindValue(':son', $this->son, PDO::PARAM_STR);
		$query->bindValue(':video', $this->video, PDO::PARAM_STR);
		$query->execute();
	}

	function delete()
	{
		// Suppression du fichier lié
		if (!empty($image)) {
            if (is_file('upload/' . $this->image)) {
                unlink('upload/' . $this->image);
            }
            $this->image = $image;
        }

		$sql = "DELETE FROM element WHERE id=:id";
		$pdo = connexion();
		$query = $pdo->prepare($sql);
		$query->bindValue(':id', $this->id, PDO::PARAM_INT);
		$query->execute();
	}

	function chargePOST()
	{
		$this->id = postInt('id');
		$this->ordre = postInt('ordre');
		$this->type = postString('type');
		$this->contenu = postString('contenu');
		$this->image = postString('old-image');
		$this->son = postString('old-son');
		$this->video = postString('old-video');
		$this->alt = postString('alt');
		$this->legende = postString('legende');
		$this->id_article = postInt('id_article');


		// Récupère les informations sur le fichier uploadés si il existe
		$image = chargeFILE();
		$son = chargeFILE();
		$video = chargeFILE();

		if (!empty($image)) {
            if (is_file('upload/' . $this->image)) {
                unlink('upload/' . $this->image);
            }
            $this->image = $image;
        }
		if (!empty($son)) {
            if (is_file('upload/' . $this->son)) {
                unlink('upload/' . $this->son);
            }
            $this->son = $son;
        }	
		if (!empty($video)) {
            if (is_file('upload/' . $this->video)) {
                unlink('upload/' . $this->video);
            }
            $this->video = $video;
        }
	}


	static function controleur($action, $id, &$view, &$data)
	{
		switch ($action) {
			case 'read':
				// Liste des elements d'un article ($id)
				if ($id > 0) {
					$view = 'visitor_view/visit_element.twig';
					$article = Article::readOne($id);
					$data = [
						'element' => Element::readAllByArticle($id),
						'article' => $article,
						'theme' => Theme::readOne($article->id_theme),
						'articles' => Article::readAllByTheme($article->id_theme)
					];
				} else {
					// Pas de thème sélectionné => retour à l'accueil
					header('Location: visitor.php?page=theme');
				}
				break;
			default:
				$view = 'visitor_view/visit_element.twig';
				$data = [
					'element' => Element::readOne($id)
				];
				break;
		}
	}

	static function controleurAdmin($action, $id, &$view, &$data)
	{
		switch ($action) {
			case 'read':
				// Pas d'affichage d'un élément seul => retour à l'article
				header('Location: admin.php?page=article&id=' . $id);
				break;
			case 'new':
				$view = "element/form_element.twig";
				$data = ['id_article' => $id];
				break;
			case 'create':
				$element = new Element();
				$element->chargePOST();
				$element->create();
				header('Location: admin.php?page=article&id=' . $element->id_article);
				break;
			case 'edit':
				$view = "element/edit_element.twig";
				$data = ['element' => Element::readOne($id)];
				break;
			case 'update':
				$element = new Element();
				$element->chargePOST();
				$element->update();
				header('Location: admin.php?page=article&id=' . $element->id_article);
				break;
			case 'delete':
				$element = Element::readOne($id);
				$element->delete();
				header('Location: admin.php?page=article&id=' . $element->id_article);
				break;
			case 'exchange':
				$element = Element::readOne($id);
				$element->exchangeOrder();
				header('Location: admin.php?page=article&id=' . $element->id_article);
				break;
			default:
				// Pas d'action connue => retour à la page article
				header('Location: admin.php?page=article&id=' . $id);
		}
	}

	// Création de la table themes
	static function init()
	{
		// connexion
		$pdo = connexion();

		// suppression des données existantes le cas échéant
		$sql = 'drop table if exists element';
		$query = $pdo->prepare($sql);
		$query->execute();

		// création de la table 'theme'
		$sql = 'create table element (
				id serial primary key,
				ordre int,
				type varchar(128),
				contenu text,
				image varchar(512),
				son varchar(550),
				video varchar(550),
				alt varchar(100),
				legende varchar(1000),
				id_article bigint unsigned,
    			foreign key (id_article) references article(id))';
		$query = $pdo->prepare($sql);
		$query->execute();
	}
}
