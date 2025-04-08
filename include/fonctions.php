<?php

// Récupère une chaine de caractères dans $_POST en la filtrant
function postString($name)
{
	$text = '';
	if (isset($_POST[$name])) {
		$text = htmlspecialchars($_POST[$name], ENT_NOQUOTES, 'UTF-8');
		
	}
	return $text;
}

// Récupère un entier dans $_POST en assurant sa conversion
function postInt($name)
{
	$int = 0;
	if (isset($_POST[$name])) {
		$int = intval($_POST[$name]);
	}
	return $int;
}

function filterText($text)
{
	// Remplace les ^ par des espaces insécables
	$text = str_replace('^', '&nbsp;', $text);
	// remplace $ par <br>
	$text = str_replace('$', '<br>', $text);
	


	// Remplace //texte// par <spam>texte</spam>
	$text = preg_replace('/\/\/(.*?)\/\//', '<span class="italique_text">$1</span>', $text);
	// remplace 
	$text = preg_replace('/\*\*(.*?)\*\*/', '<span class="gras_text">\1</span>', $text);

	// Remplace ((url|serveur.com)) par <a href="url">serveur.com</a>
	$text = preg_replace('/\(\(([^\s\|]*)\|(.*)\)\)/', '<a class="hyperlien-style" href="\1">\2</a>', $text);
	return $text;
}

function chargeFILE()
{	
	if (isset($_FILES['video']) && !empty($_FILES['video']['name'])) {
		$fileName = $_FILES['video']['name'];
		$fileTmpName = $_FILES['video']['tmp_name'];
		$fileSize = $_FILES['video']['size'];
		$fileError = $_FILES['video']['error'];
		$fileType = $_FILES['video']['type'];

		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));

		$allowed = ['jpg', 'jpeg', 'jfif', 'png', 'mp3', 'wav', 'flac', 'gif','mp4'];

		if (in_array($fileActualExt, $allowed)) {
			if ($fileError === 0) {
				if ($fileSize < 512000000) {
					$fileNameNew = uniqid('', true) . "." . $fileActualExt;
					$fileDestination = 'upload/' . $fileNameNew;
					move_uploaded_file($fileTmpName, $fileDestination);
					return $fileNameNew;
				} else {
					echo 'Votre fichier est trop volumineux';
				}
			} else {
				echo 'Une erreur est survenue lors du téléchargement du fichier';
			}
		} else {
			echo 'Ce type de fichier (' . $fileType . ') ou d\'extension (' . $fileActualExt . ') n\'est pas supporté';
		}
		return '';
	}
	if (isset($_FILES['son']) && !empty($_FILES['son']['name'])) {
		$fileName = $_FILES['son']['name'];
		$fileTmpName = $_FILES['son']['tmp_name'];
		$fileSize = $_FILES['son']['size'];
		$fileError = $_FILES['son']['error'];
		$fileType = $_FILES['son']['type'];

		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));

		$allowed = ['jpg', 'jpeg', 'jfif', 'png', 'mp3', 'wav', 'flac', 'gif','mp4'];

		if (in_array($fileActualExt, $allowed)) {
			if ($fileError === 0) {
				if ($fileSize < 80000000) {
					$fileNameNew = uniqid('', true) . "." . $fileActualExt;
					$fileDestination = 'upload/' . $fileNameNew;
					move_uploaded_file($fileTmpName, $fileDestination);
					return $fileNameNew;
				} else {
					echo 'Votre fichier est trop volumineux';
				}
			} else {
				echo 'Une erreur est survenue lors du téléchargement du fichier';
			}
		} else {
			echo 'Ce type de fichier (' . $fileType . ') ou d\'extension (' . $fileActualExt . ') n\'est pas supporté';
		}
		return '';
	}


    // fonction pour une seule image 
	if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
		$fileName = $_FILES['image']['name'];
		$fileTmpName = $_FILES['image']['tmp_name'];
		$fileSize = $_FILES['image']['size'];
		$fileError = $_FILES['image']['error'];
		$fileType = $_FILES['image']['type'];

		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));

		$allowed = ['jpg', 'jpeg', 'jfif', 'png', 'mp3', 'wav', 'flac', 'gif','mp4'];

		if (in_array($fileActualExt, $allowed)) {
			if ($fileError === 0) {
				if ($fileSize < 80000000) {
					$fileNameNew = uniqid('', true) . "." . $fileActualExt;
					$fileDestination = 'upload/' . $fileNameNew;
					move_uploaded_file($fileTmpName, $fileDestination);
					return $fileNameNew;
				} else {
					echo 'Votre fichier est trop volumineux';
				}
			} else {
				echo 'Une erreur est survenue lors du téléchargement du fichier';
			}
		} else {
			echo 'Ce type de fichier (' . $fileType . ') ou d\'extension (' . $fileActualExt . ') n\'est pas supporté';
		}
		return '';
	}

	if (isset($_FILES['image2']) && !empty($_FILES['image2']['name'])) {
		$fileName = $_FILES['image2']['name'];
		$fileTmpName = $_FILES['image2']['tmp_name'];
		$fileSize = $_FILES['image2']['size'];
		$fileError = $_FILES['image2']['error'];
		$fileType = $_FILES['image2']['type'];

		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));

		$allowed = ['jpg', 'jpeg', 'jfif', 'png', 'mp3', 'wav', 'flac', 'gif','mp4'];

		if (in_array($fileActualExt, $allowed)) {
			if ($fileError === 0) {
				if ($fileSize < 80000000) {
					$fileNameNew = uniqid('', true) . "." . $fileActualExt;
					$fileDestination = 'upload/' . $fileNameNew;
					move_uploaded_file($fileTmpName, $fileDestination);
					return $fileNameNew;
				} else {
					echo 'Votre fichier est trop volumineux';
				}
			} else {
				echo 'Une erreur est survenue lors du téléchargement du fichier';
			}
		} else {
			echo 'Ce type de fichier (' . $fileType . ') ou d\'extension (' . $fileActualExt . ') n\'est pas supporté';
		}
		return '';
	}



	
}
