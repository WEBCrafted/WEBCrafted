<?php
if(!$_users->isLogged()) {
	setFlash("Vous n'avez pas les droits nécessaires pour accèder à cette page", "error");
	redirect("login", false);
}

if(!isset($params[0]) OR $params[0] != "options") {
	set(array(
		"options" => array(
			"jsonapi_use" => Configure::read("jsonapi_use"),
			"shop_use" => Configure::read("shop_use"),
		),
	));
}
