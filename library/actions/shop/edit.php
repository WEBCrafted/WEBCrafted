<?php
if(
	!isset(
		$_POST["token"],
		$_POST["id"],
		$_POST["name"],
		$_POST["image_url"],
		$_POST["method"],
		$_POST["args"],
		$_POST["category"],
		$_POST["price"],
		$_POST["duration"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$success = $_shop->editItem(
		$_POST["id"],
		$_POST["name"],
		$_POST["image_url"],
		$_POST["method"],
		$_POST["args"],
		$_POST["category"],
		$_POST["price"],
		$_POST["duration"]
	);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("L'offre a été éditée !", "success");
}

redirect("admin/shop", false);
