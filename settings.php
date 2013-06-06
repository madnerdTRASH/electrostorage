<?php 

/*
 @nom: settings
 @auteur: Sarrailh Rémi (maditnerd@gmail.com)
 @description: Page de gestion des composants
 */

require_once('header.php'); 

$db = (file_exists(PATH_BDD)?Functions::unstore():array());
$tpl->assign('storages', $db['storages']);
$tpl->assign('components', $db['components']);
$tpl->assign('componentsType', $db['componentsType']);

//Récupère la liste des fichiers jsons
$i = 0;
if ($handle = opendir('.')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
        	$filename = explode('.',$entry);
            if ($filename[1] == "json")
            {
            $db_files[$i] = $filename[0];
        	$i++;
        	}
        }

    }
    closedir($handle);
}
if (isset($db_files))
{
$tpl->assign('db_files',$db_files);
}

//Récupère la position dans le menu dans l'url

if (isset($_GET['menu']))
{
$tpl->assign('menu',$_GET['menu']);
}
else
{
$tpl->assign('menu',0);
}

$view = "settings";
require_once('footer.php'); ?>