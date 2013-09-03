<?php
if(
	!isset(
		$params["token"],
		$params[3]
	)) {
	setFlash("Un paramètre est manquant !", "error");
}
else {
	$success = $_widgets->deleteWidget($params[3]);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("Le widget N°{$params[3]} a été supprimé !", "success");
}

redirect("admin/widgets", false);
