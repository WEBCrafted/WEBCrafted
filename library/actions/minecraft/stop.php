<?php
if(
	!isset(
		$params["token"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$success = $_minecraft->stopServer();

	if(!$success)
		setFlash("Impossible de stopper le serveur, utilisez-vous Remote Toolkit ?", "error");
	else
		setFlash("Le serveur est stoppé", "success");
}

redirect("admin", false);
