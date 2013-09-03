<?php
if(!isset($params[1])) {
	$params[1] = "home";
}
switch ($params[1]) {
	case "home":
		set(array("page" => array("title" => "Utilisateurs", "description" => "Gérer les utilisateurs")));
		break;
	case "edit":
		set(array("page" => array("title" => "Utilisateurs", "description" => "Éditer un utilisateur")));
		break;
	default: 
		break;
}
if(file_exists(TROOT . "views/users/subviews/{$params[1]}/subview.php")) {
	if(file_exists(TROOT . "views/users/subviews/{$params[1]}/loader.php")) {
		include_once(TROOT . "views/users/subviews/{$params[1]}/loader.php");
	}
	include_once(TROOT . "views/users/subviews/{$params[1]}/subview.php");
} else {
	include_once(TROOT . "views/404/view.php");
}
