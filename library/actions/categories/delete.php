<?php
if(
	!isset(
		$params["token"],
		$params[3]
	)) {
	setFlash("Un paramètre est manquant !", "error");
}
else {
	$success = $_categories->deleteCategory($params[3]);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("La catégorie N°{$params[3]} a été supprimée !", "success");
}

redirect("admin/categories", false);
