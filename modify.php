<?php 

/*
 @nom: modify
 @auteur: maditnerd
 @description: Page pour modifier des informations
 */
 
 require_once('header.php'); 
 
 $db = (file_exists(PATH_BDD)?Functions::unstore():array());
 $tpl->assign('storages', $db['storages']);
 $tpl->assign('components', $db['components']);
 $tpl->assign('componentsType', $db['componentsType']);

 if (isset($_GET['storage']) || isset($_GET['component']) || isset($_GET['componentType']) )
 {
//Choisis la cle de la prise
 	if (isset($_GET['component']))
 	{

	//Recuperation de la cle de la prise
 		$key = $_GET['component'];

	//Recuperation du nom de la piece
 		$storagekey = $db['components'][$key]['Storage'];
 		$storagename = $db['storages'][$storagekey]['name'];
 		$componentType_id = $db['components'][$key]['componentType'];
 		$componentType_name = $db['componentsType'][$componentType_id]['name'];

	//Recuperation des valeurs
 		$tpl->assign('idcomponent',$key);
 		$tpl->assign('picture',$db['components'][$key]['picture']);
 		$tpl->assign('name',$db['components'][$key]['name']);
 		$tpl->assign('quantity',$db['components'][$key]['quantity']);
 		$tpl->assign('location',$db['components'][$key]['location']);
 		$tpl->assign('storagekey',$storagekey);
 		$tpl->assign('storagename',$storagename);


 		if($componentType_id == "0")
 		{
 			$tpl->assign('componentType_id',$componentType_id);
 			$tpl->assign('componentType_name',"Non défini");

 		}
 		else
 		{
 			$tpl->assign('componentType_id',$componentType_id);
 			$tpl->assign('componentType_name',$componentType_name);
 		}

 	}


//Choisis la cle du type de composant
 	if (isset($_GET['componentType']))
 	{

	//Recuperation de la cle du composant
 		$key = $_GET['componentType'];

	//Recuperation des valeurs
 		$tpl->assign('idcomponentType',$key);
 		$tpl->assign('name',$db['componentsType'][$key]['name']);
 	}



//Choisis la cle du rangement
 	if (isset($_GET['storage']))
 	{

	//Recuperation de la cle du rangement
 		$key = $_GET['storage'];

	//Recuperation des valeurs
 		$tpl->assign('idstorage',$key);
 		$tpl->assign('name',$db['storages'][$key]['name']);
 		$tpl->assign('details',$db['storages'][$key]['details']);
 	}
 }
 else
 {
//Si aucune clé n'est precise revenir sur l'index
 	header('location: index.php');
 }






 
 
 $view = "modify";
 require_once('footer.php'); ?>