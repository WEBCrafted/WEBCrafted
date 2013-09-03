<?php
if(!isset($params[1])) {
	$params[1] = "home";
}
switch ($params[1]) {
	case "home":
		set(array("page" => array("title" => "Pages", "description" => "Gérer les pages")));
		break;
	case "create":
		set(array("page" => array("title" => "Pages", "description" => "Rédiger une page")));
		break;
	case "edit":
		set(array("page" => array("title" => "Pages", "description" => "Éditer une page")));
		break;
	default: 
		break;
}
if(file_exists(TROOT . "views/pages/subviews/{$params[1]}/subview.php")) {
	if(file_exists(TROOT . "views/pages/subviews/{$params[1]}/loader.php")) {
		include_once(TROOT . "views/pages/subviews/{$params[1]}/loader.php");
	}
	include_once(TROOT . "views/pages/subviews/{$params[1]}/subview.php");
} else {
	include_once(TROOT . "views/404/view.php");
}
?>