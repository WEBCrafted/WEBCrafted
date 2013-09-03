<?php
if(!isset($params[1])) {
	$params[1] = "home";
}
switch ($params[1]) {
	case "home":
		set(array("page" => array("title" => "Partenaires", "description" => "Gérer les partenaires")));
		break;
	case "add":
		set(array("page" => array("title" => "Partenaires", "description" => "Ajouter un partenaire")));
		break;
	case "edit":
		set(array("page" => array("title" => "Partenaires", "description" => "Éditer un partenaire")));
		break;
	default: 
		break;
}
if(file_exists(TROOT . "views/partners/subviews/{$params[1]}/subview.php")) {
	if(file_exists(TROOT . "views/partners/subviews/{$params[1]}/loader.php")) {
		include_once(TROOT . "views/partners/subviews/{$params[1]}/loader.php");
	}
	include_once(TROOT . "views/partners/subviews/{$params[1]}/subview.php");
} else {
	if(file_exists(TROOT . "views/404/loader.php")) {
		include_once(TROOT . "views/404/loader.php");
	}
	include_once(TROOT . "views/404/view.php");
}
