<?php
if(
	!isset(
		$_POST["token"],
		$_POST["id"],
		$_POST["title"],
		$_POST["content"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$success = $_widgets->editWidget(
		$_POST["id"],
		$_POST["title"],
		$_POST["content"],
		isset($_POST["hidden"]) ? true : false
	);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("Le widget a été édité !", "success");
}

redirect("admin/widgets", false);
