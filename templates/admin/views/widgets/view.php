<?php
if(!isset($params[1])) {
	$params[1] = "home";
}
switch ($params[1]) {
	case "home":
		set(array("page" => array("title" => "Widgets", "description" => "Gérer les widgets")));
		break;
	case "create":
		set(array("page" => array("title" => "Widgets", "description" => "Créer un widget")));
		break;
	case "edit":
		set(array("page" => array("title" => "Widgets", "description" => "Éditer un widget")));
		break;
	default: 
		break;
}
if(file_exists(TROOT . "views/widgets/subviews/{$params[1]}/subview.php")) {
	if(file_exists(TROOT . "views/widgets/subviews/{$params[1]}/loader.php")) {
		include_once(TROOT . "views/widgets/subviews/{$params[1]}/loader.php");
	}
	include_once(TROOT . "views/widgets/subviews/{$params[1]}/subview.php");
} else {
	include_once(TROOT . "views/404/view.php");
}
