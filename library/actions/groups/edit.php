<?php
if(
	!isset(
		$_POST["token"],
		$_POST["id"],
		$_POST["name"],
		$_POST["permissions"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$success = $_groups->editGroup(
		$_POST["id"],
		$_POST["name"],
		array_keys($_POST["permissions"]),
		isset($_POST["signup"]) ? true : false
	);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("Le groupe de permissions a été édité !", "success");
}

redirect("admin/groups", false);
