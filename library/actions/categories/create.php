<?php
if(
	!isset(
		$_POST["token"],
		$_POST["name"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$id = DataBase::read(PREFIX . "categories", array("fields" => array("id"), "limit" => 1, "order" => array("method" => "DESC")));

	if(empty($id))
		$id = 1;
	else
		$id = current($id) + 1;

	$success = $_categories->createCategory($id, $_POST["name"]);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("La catégorie a été créée !", "success");
}

redirect("admin/categories", false);
