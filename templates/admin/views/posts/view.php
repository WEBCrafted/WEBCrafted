<?php
if(!isset($params[1])) {
	$params[1] = "home";
}
switch ($params[1]) {
	case "home":
		set(array("page" => array("title" => "Actualités", "description" => "Gérer les actualités")));
		break;
	case "create":
		set(array("page" => array("title" => "Actualités", "description" => "Rédiger une actualité")));
		break;
	case "edit":
		set(array("page" => array("title" => "Actualités", "description" => "Éditer un article")));
		break;
	default: 
		break;
}
if(file_exists(TROOT . "views/posts/subviews/{$params[1]}/subview.php")) {
	if(file_exists(TROOT . "views/posts/subviews/{$params[1]}/loader.php")) {
		include_once(TROOT . "views/posts/subviews/{$params[1]}/loader.php");
	}
	include_once(TROOT . "views/posts/subviews/{$params[1]}/subview.php");
} else {
	include_once(TROOT . "views/404/view.php");
}
