<?php
if(!isset($params[1])) {
	$params[1] = "home";
}
switch ($params[1]) {
	case "home":
		set(array("page" => array("title" => "Catégories", "description" => "Gérer les catégories")));
		break;
	case "create":
		set(array("page" => array("title" => "Catégories", "description" => "Ajouter une catégorie")));
		break;
	case "edit":
		set(array("page" => array("title" => "Catégories", "description" => "Éditer une catégorie")));
		break;
		break;
	default: 
		break;
}
if(file_exists(TROOT . "views/categories/subviews/{$params[1]}/subview.php")) {
	if(file_exists(TROOT . "views/categories/subviews/{$params[1]}/loader.php")) {
		include_once(TROOT . "views/categories/subviews/{$params[1]}/loader.php");
	}
	include_once(TROOT . "views/categories/subviews/{$params[1]}/subview.php");
} else {
	include_once(TROOT . "views/404/view.php");
}
