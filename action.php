<?php
require_once('header.php');


switch($_['action']){

	/*

	Gestion des composants

	*/

	//
	//Ajouter d'un composant
	//
	case 'ADD_COMPONENT':
	$db = (file_exists(PATH_BDD)?Functions::unstore():array());

		//Copie de l'image sur le serveur
	$fichier = basename($_FILES['picture']['name']);
	move_uploaded_file($_FILES['picture']['tmp_name'], PICTURE_FOLDER .'/'. $fichier);

		//Copie des donnees
	$newComponent['picture'] = PICTURE_FOLDER .'/'.$fichier;
	$newComponent['name'] = $_['componentName'];
	$newComponent['quantity'] = $_['componentQuantity'];
	$newComponent['componentType'] = $_['idComponentType'];
	$newComponent['location'] = $_['location'];
	$newComponent['Storage'] = $_['idStorage'];

		//Si Aucune cle n'existe alors cree la cle 1 sinon creer la cle suivante
	$db['keys']['components']=(isset($db['keys']['components'])?$db['keys']['components']+1:1);
	$db['components']['id-'.$db['keys']['components']] =  $newComponent;

		//Enregistrement dans la base JSON
	Functions::store($db);
	header('location: settings.php');
	break;

	//
	//Modifier un composant
	//
	case 'MODIFY_COMPONENT':
	$db = (file_exists(PATH_BDD)?Functions::unstore():array());

	//Verifie si la commande n'a pas ete lance a la main
	if (!empty($_POST))
	{	
		//Si une image est defini alors la sauvegarder
		if ($_FILES['picture']['error'] == 0)
		{
			$fichier = basename($_FILES['picture']['name']);
			move_uploaded_file($_FILES['picture']['tmp_name'], PICTURE_FOLDER .'/'. $fichier);
			$db['components'][$_['idcomponent']]['picture'] = PICTURE_FOLDER .'/'.$fichier;
		}
		
		$db['components'][$_['idcomponent']]['name'] = $_['componentName'];
		$db['components'][$_['idcomponent']]['quantity'] = $_['componentQuantity'];
		$db['components'][$_['idcomponent']]['componentType'] = $_['idComponentType'];
		$db['components'][$_['idcomponent']]['location'] = $_['location'];

		
		//Si une piece est defini alors la sauvegarder
		if (!empty($_['idStorage']))
		{
			$db['components'][$_['idcomponent']]['Storage'] = $_['idStorage'];
		}

		//Enregistrement dans la base JSON
		Functions::store($db);
		
		//Retour a la configuration de la prise
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		
	}
	else
	{
		header('location: index.php');
	}
	break;

	case 'SHOW_COMPONENT':
	$db = (file_exists(PATH_BDD)?Functions::unstore():array());
	break;

	//
	//Effacer un composant
	//
	case 'DELETE_COMPONENT':
	$db = (file_exists(PATH_BDD)?Functions::unstore():array());
	unset($db['components'][$_['component']]);
	Functions::store($db);
	header('location: settings.php');
	break;

	/*

	Gestion des types de composants

	*/

	//
	//Ajouter un type de composants
	//
	case 'ADD_COMPONENTTYPE':
	$db = (file_exists(PATH_BDD)?Functions::unstore():array());
	$newComponentType['name'] = $_['component_type'];
	$db['keys']['componentsType']=(isset($db['keys']['componentsType'])?$db['keys']['componentsType']+1:1);
	$db['componentsType']['id-'.$db['keys']['componentsType']] =  $newComponentType;
	Functions::store($db);
	header('location: settings.php?menu=1');
	break;

	//
	//Effacer un type de composants
	//
	case 'DELETE_COMPONENTTYPE':
	$db = (file_exists(PATH_BDD)?Functions::unstore():array());
	unset($db['componentsType'][$_['componentType']]);
	Functions::store($db);
	header('location: settings.php?menu=1');
	break;


	case 'MODIFY_COMPONENTTYPE':
	$db = (file_exists(PATH_BDD)?Functions::unstore():array());


	//Verifie si la commande n'a pas ete lance a la main
	if (!empty($_POST))
	{	
		
		
		$db['componentsType'][$_['idcomponenttype']]['name'] = $_['component_type'];
		//Enregistrement dans la base JSON
		Functions::store($db);
		
		//Retour a la configuration de la prise
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		
	}
	else
	{
		header('location: index.php');
	}
	break;

	/*

	Gestion des rangements

	*/

	//
	//Ajouter un rangment
	//
	case 'ADD_STORAGE':
	$db = (file_exists(PATH_BDD)?Functions::unstore():array());
	$newStorage['name'] = $_['storage'];
	$newStorage['details'] = $_['details'];
	$db['keys']['storages']=(isset($db['keys']['storages'])?$db['keys']['storages']+1:1);
	$db['storages']['id-'.$db['keys']['storages']] =  $newStorage;
	Functions::store($db);
	header('location: settings.php?menu=2');
	break;

	//
	//Effacer un rangement
	//
	case 'DELETE_STORAGE':
	$db = (file_exists(PATH_BDD)?Functions::unstore():array());
	unset($db['storages'][$_['storage']]);
	Functions::store($db);
	header('location: settings.php?menu=2');
	break;


	case 'MODIFY_STORAGE':
	$db = (file_exists(PATH_BDD)?Functions::unstore():array());

	//Verifie si la commande n'a pas ete lance a la main
	if (!empty($_POST))
	{	
		
		
		$db['storages'][$_['idstorage']]['name'] = $_['storage'];
		$db['storages'][$_['idstorage']]['details'] = $_['details'];
		//Enregistrement dans la base JSON
		Functions::store($db);
		
		//Retour a la configuration de la prise
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		
	}
	break;

	/*
	Manipulation Base de données JSON
	*/

	case 'BACKUP_DATABASE':
	if (isset($_['newdatabase']))
	{
	copy(PATH_BDD,$_['newdatabase'] . ".json");
	}
	header('location: settings.php?menu=3');
	break;

	case 'DELETE_DATABASE':
	if (isset($_['database']))
	{

		unlink($_['database']. ".json");
	}
	header('location: settings.php?menu=3');
	break;

	case 'UPLOAD_DATABASE':
		if ($_FILES['inputDB']['error'] == 0)
		{
			echo $_FILES['inputDB']['name'];
			$fichier = basename($_FILES['inputDB']['name']);
			move_uploaded_file($_FILES['inputDB']['tmp_name'], PATH_BDD);

		}
	header('location: settings.php?menu=3');
	break;

	case 'COPY_DATABASE':
	copy($_['database'] . ".json",PATH_BDD);
	header('location: settings.php?menu=3');
	break;

	
}






?>
