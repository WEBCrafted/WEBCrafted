<?php
if(Configure::read("shop_use") AND (!isset($_SESSION["install"]["shop"]) OR !$_SESSION["install"]["shop"])) {
	redirect("install/shop", false);
}

if(
	!isset(
		$_POST["username"],
		$_POST["email"],
		$_POST["password"],
		$_POST["password2"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	if($_POST["password"] != $_POST["password2"]) {
		setFlash("Les mots de passe sont différents", "error");
	}
	else {
		$_users->signup(1, $_POST["username"], $_POST["password"], $_POST["email"], 1);
		$_SESSION["id"] = 1;
		$_groups->createGroup(1, "Administrateur", array("webcrafted.admin.*"));
		$_groups->createGroup(2, "Utilisateur", array(""), true);
		$_categories = loadBundle("fr.solicium.categories");
		$_categories->createCategory(1, "Aucune");
		$_widgets = loadBundle("fr.solicium.widgets");
		$_widgets->createWidget(1, "Etat du serveur", '<h2>{serverdata.state}</h2><h3>{serverdata.players}/{serverdata.maxPlayers} joueurs</h3><h3><span class="gray">IP : {serverdata.ip}:{serverdata.port}</span></h3>');
		$_widgets->createWidget(2, "Socialhub", '<a href="{options.facebook}"><img src="' . WEBROOT . 'templates/webcrafted/assets/images/facebook.png" alt="facebook" /></a><a href="{options.youtube}"><img src="' . WEBROOT . 'templates/webcrafted/assets/images/youtube.png" alt="youtube" /></a><a href="https://twitter.com/{options.twitter}"><img src="' . WEBROOT . 'templates/webcrafted/assets/images/twitter.png" alt="twitter" /></a>');
		$_users->login($_POST["username"], $_users->hashPassword($_POST["password"]));
		Configure::edit("install", "true");
		unset($_SESSION["install"]);
		setFlash("L'installation s'est effectuée avec succès !", "success");
		redirect("admin");
	}
}

redirect("install/admin", false);
