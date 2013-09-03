<?php
if(
	!$_users->hasPermission("webcrafted.admin.*")
	AND !$_users->hasPermission("webcrafted.admin.server")
	AND !$_users->hasPermission("webcrafted.admin.console")
	AND !$_users->hasPermission("webcrafted.admin.posts")
	AND !$_users->hasPermission("webcrafted.admin.pages")
	AND !$_users->hasPermission("webcrafted.admin.users")
	AND !$_users->hasPermission("webcrafted.admin.groups")
	AND !$_users->hasPermission("webcrafted.admin.partners")
	AND !$_users->hasPermission("webcrafted.admin.shop")
	AND !$_users->hasPermission("webcrafted.admin.options")) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}

$_minecraft = loadBundle("fr.solicium.minecraft");

if($options["jsonapi_use"]) {
	$serverdata = $_minecraft->getServer();
	if(!empty($serverdata)) {
		$players = $serverdata["players"];
		$maxplayers = $serverdata["maxPlayers"];
		$admin = array();
		foreach($players as $k => $v) {
			if($v["op"]) {
				$admin[] = $v["name"];
			}
		}
		set(array(
			"onlinePlayers" => count($players),
			"maxPlayers" => $maxplayers,
			"adminPlayers" => count($admin),
			"plural" => array(
				"onlinePlayers" => count($players) > 1 ? "s" : "",
				"adminPlayers" => count($admin) > 1 ? "s" : "",
			),
		));
	}
}

set(array(
	"page" => array(
		"title" => "Tableau de bord",
		"description" => "Contrôler de A à Z votre site Minecraft",
	),
));
