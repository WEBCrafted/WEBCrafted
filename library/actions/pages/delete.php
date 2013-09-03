<?php
if(
	!isset(
		$params["token"],
		$params[3]
	)) {
	setFlash("Un paramètre est manquant !", "error");
}
else {
	$success = $_pages->deletePage($params[3]);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("La page N°{$params[3]} a été supprimée !", "success");
}

redirect("admin/pages", false);
