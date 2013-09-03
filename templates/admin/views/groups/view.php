<?php
if(!isset($params[1])) {
	$params[1] = "home";
}
switch ($params[1]) {
	case "home":
		set(array("page" => array("title" => "Groupes", "description" => "Gérer les groupes")));
		break;
	case "create":
		set(array("page" => array("title" => "Groupes", "description" => "Créer un groupe")));
		break;
	case "edit":
		set(array("page" => array("title" => "Groupes", "description" => "Éditer un groupe")));
		break;
	default: 
		break;
}
if(file_exists(TROOT . "views/groups/subviews/{$params[1]}/subview.php")) {
	if(file_exists(TROOT . "views/groups/subviews/{$params[1]}/loader.php")) {
		include_once(TROOT . "views/groups/subviews/{$params[1]}/loader.php");
	}
	include_once(TROOT . "views/groups/subviews/{$params[1]}/subview.php");
} else {
	if(file_exists(TROOT . "views/404/loader.php")) {
		include_once(TROOT . "views/404/loader.php");
	}
	include_once(TROOT . "views/404/view.php");
}
