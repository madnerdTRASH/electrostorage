<?php
/*
 @nom: index
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
 		asort($db['components']['location']);
 		break;

 		case 'bytype':
 		asort($db['components']['type']);
 		break;
 	}
 }

 else
 {
 	asort($db['components']);
 }
 $tpl->assign('storages', $db['storages']);
 $tpl->assign('components', $db['components']);
 $tpl->assign('componentsType', $db['componentsType']);
 $tpl->assign('noimages', $_['noimages']);

 $storages = (isset($db['storages'])?$db['storages']:array());
 asort($storages);


 $view = 'index';
 require_once('footer.php'); 


 ?>