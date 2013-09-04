<?php
if(!$_users->hasPermission("webcrafted.admin.*") AND !$_users->hasPermission("webcrafted.admin.options")) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}

$themes = array();
if($folder = opendir(ROOT . "templates")) {
	$blacklist = array(".", "..", ".DS_Store", "loader.php", "admin", "commons", "install");
	while(($file = readdir($folder)) !== false) {
		if(!in_array($file, $blacklist)) {
			$themes[$file] = ucfirst($file);
		}
	}
	closedir($folder);
}
$options = Configure::getAll();

set(array(
	"page" => array(
		"title" => "Réglages",
		"description" => "Modifier les paramètres du site",
	),
	"options" => $options,
	"themes" => $themes,
));
