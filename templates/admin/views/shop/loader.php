<?php
if(!$_users->hasPermission("webcrafted.admin.*") AND !$_users->hasPermission("webcrafted.admin.shop")) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}

if(!$options["shop_use"]) {
	set(array(
		"page" => array(
			"title" => "Boutique",
			"description" => "Gérer votre boutique WEBCrafted"
		),
	));
}
else {
	$_shop = loadBundle("fr.solicium.shop");
}
