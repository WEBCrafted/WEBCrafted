<?php
if(
	!isset(
		$params["token"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$success = $_minecraft->startServer();

	if(!$success)
		setFlash("Impossible de démarrer le serveur, utilisez-vous Remote Toolkit ?", "error");
	else
		setFlash("Le serveur est lancé", "success");
}

redirect("admin", false);
