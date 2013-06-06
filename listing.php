<?php
/*
 @nom: listing
 @auteur: Sarrailh Rémi (maditnerd@gmail.com)
 @description:  Page d'accueil et de lecture des flux
*/

 require_once('header.php'); 
 $db = (file_exists(PATH_BDD)?Functions::unstore():array());




 if (isset($_['sorting']))
 {
 	switch ($_['sorting'])

 	{
 		case 'bylocation':
 		//echo "bylocation";
 		//asort($db['components']['location']);
 		break;

 		case 'bytype':
 		//echo "bytype";
 		//asort($db['components']['componentType'], SORT_STRING );
 		//print_r($db['components']);
 		break;
 	}
 }

 else
 {
 	//echo "byname";
 	//asort($db['components']);
 	//array_multisort($db['components']['name']);
 }
 $tpl->assign('storages', $db['storages']);
 $tpl->assign('components', $db['components']);
 $tpl->assign('componentsType', $db['componentsType']);
 $tpl->assign('noimages', $_['noimages']);

 $storages = (isset($db['storages'])?$db['storages']:array());
// asort($storages);


 $view = 'listing';
 require_once('footer.php'); 


 ?>