<?php
if(
	!isset(
		$params["token"],
		$params[3]
	)) {
	setFlash("Un paramètre est manquant !", "error");
}
else {
	$success = $_shop->deleteItem($params[3]);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("L'offre N°{$params[3]} a été supprimée !", "success");
}

redirect("admin/shop", false);
