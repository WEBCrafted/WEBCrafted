<?php
if(
	!isset(
		$params["token"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$success = $_minecraft->restartServer();

	if(!$success)
		setFlash("Impossible de relancer le serveur, utilisez-vous Remote Toolkit ?", "error");
	else
		setFlash("Le serveur redémarre", "success");
}

redirect("admin", false);
