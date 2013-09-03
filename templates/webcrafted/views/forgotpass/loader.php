<?php
if(!isset($params["id"], $params["secretkey"])) {
	setFlash("Un champ est manquant", "error");
	redirect("login", false);
}

$userdata = $_users->getUser($params["id"]);

if(!$userdata) {
	setFlash("Lien de réinitialisation incorrect", "error");
}
else {
	if(substr(sha1(md5($userdata["email"]) . Configure::read("users_secret_key")), 13, 20) != $params["secretkey"]) {
		setFlash("Erreur de sécurité, réessayez", "error");
	}
	else {
		set(array(
			"page" => array(
				"title" => "Réinitialisation du mot de passe",
			),
			"user" => $userdata,
			"secretkey" => $params["secretkey"],
		));
		return;
	}
}
redirect("login", false);
