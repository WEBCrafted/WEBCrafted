<?php
if(
	!isset(
		$params["token"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$success = $_minecraft->reloadServer();

	if(!$success)
		setFlash("Impossible de recharger le serveur", "error");
	else
		setFlash("Le serveur se recharge...", "success");
}

redirect("admin", false);
