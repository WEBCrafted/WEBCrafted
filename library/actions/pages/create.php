<?php
if(
	!isset(
		$_POST["token"],
		$_POST["title"],
		$_POST["content"],
		$_POST["tags"],
		$_POST["submit"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$id = DataBase::read(PREFIX . "posts", array("fields" => array("id"), "limit" => 1, "order" => array("method" => "DESC")));

	if(empty($id))
		$id = 1;
	else
		$id = current($id) + 1;

	$success = $_pages->createPage(
		$id,
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
		setFlash("La page a été créée !", "success");
}

redirect("admin/pages", false);
