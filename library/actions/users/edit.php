<?php
if(
	!$_users->isLogged() OR
	(!$_users->hasPermission("webcrafted.admin.*") AND
	!$_users->hasPermission("webcrafted.admin.users")) OR
	!isset($params[2])) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}
elseif(
	!isset(
		$_POST["token"],
		$_POST["id"],
		$_POST["username"],
		$_POST["money"],
		$_POST["email"],
		$_POST["group_id"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$success = $_users->editUser(
		$_POST["id"],
		$_POST["username"],
		$_POST["money"],
		$_POST["email"],
		$_POST["group_id"]
	);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("L'utilisateur a été édité !", "success");
}

redirect("admin/users", false);
