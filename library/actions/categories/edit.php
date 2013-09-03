<?php
if(
	!isset(
		$_POST["token"],
		$_POST["id"],
		$_POST["name"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$success = $_categories->editCategory(
		$_POST["id"],
		$_POST["name"]
	);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("La catégorie a été éditée !", "success");
}

redirect("admin/categories", false);
