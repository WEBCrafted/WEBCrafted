<?php
if(
	!isset(
		$_POST["token"],
		$_POST["id"],
		$_POST["title"],
		$_POST["content"],
		$_POST["tags"],
		$_POST["submit"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$success = $_pages->editPage(
		$_POST["id"],
		$_POST["title"],
		$_POST["content"],
		isset($_POST["slug"]) ? $_POST["slug"] : null,
		isset($_POST["category_id"]) ? $_POST["category_id"] : 1,
		explode(",", $_POST["tags"]),
		$_POST["submit"] == "Publier" ? 1 : 0
	);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("La page a été éditée !", "success");
}

redirect("admin/pages", false);
