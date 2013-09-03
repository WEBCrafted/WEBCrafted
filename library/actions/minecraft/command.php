<?php
if(
	!isset(
		$_POST["token"],
		$_POST["command"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$success = $_minecraft->runConsoleCommand($_POST["command"]);

	if(!$success)
		setFlash("La commande n'a pas pu être envoyée au serveur", "error");
	else
		setFlash("La commande a été executée", "success");
}

redirect("admin/manage", false);
