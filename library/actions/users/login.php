<?php
if(
	!isset(
		$_POST["token"],
		$_POST["username"],
		$_POST["password"]
	)) {
	setFlash("Un champ est manquant", "error");
}
else {
	$success = $_users->userExists($_POST["username"]);

	if(!$success) {
		setFlash("Le compte n'existe pas", "error");
	}
	else {
		$success = $_users->login($_POST["username"], $_users->hashPassword($_POST["password"]));

		if(!$success) {
			setFlash("Identifiants incorrects", "error");
		}
		else {
			setFlash("Vous êtes connecté sous {$_POST["username"]}", "success");

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
				AND !$_users->hasPermission("webcrafted.admin.options"))
				redirect("home");
			else
				redirect("admin", false);
		}
	}
}

redirect("login");
