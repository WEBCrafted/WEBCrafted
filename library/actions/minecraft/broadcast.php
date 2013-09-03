<?php
if(
	!isset(
		$_POST["token"],
		$_POST["message"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$success = $_minecraft->broadcast($_POST["message"]);

	if(!$success)
		setFlash("L'annonce rapide n'a pas pu être envoyée au serveur", "error");
	else
		setFlash("L'annonce rapide a été envoyée sur le serveur", "success");
}

redirect("admin", false);
