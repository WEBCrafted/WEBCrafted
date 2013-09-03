<?php
if(
	!isset($params[2]) OR
	empty($params[2])) {
	setFlash("L'id de l'utilisateur n'est pas spécifié !", "error");
}
else {
	$user = $_users->getUser($params[2]);
	if(empty($user)) {
		setFlash("L'utilisateur n'existe pas !", "error");
	}
	else {
		$groups = $_groups->getGroups();

		set(array(
			"user" => $user,
			"groups" => $groups,
		));
		return;
	}
}
redirect("users");
