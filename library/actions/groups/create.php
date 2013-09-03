<?php
if(
	!isset(
		$_POST["token"],
		$_POST["name"],
		$_POST["permissions"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$id = DataBase::read(PREFIX . "groups", array("fields" => array("id"), "limit" => 1, "order" => array("method" => "DESC")));

	if(empty($id))
		$id = 1;
	else
		$id = current($id) + 1;

	$success = $_groups->createGroup(
		$id,
		$_POST["name"],
		array_keys($_POST["permissions"]),
		isset($_POST["signup"]) ? true : false
	);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("Le groupe de permissions a été créé !", "success");
}

redirect("admin/groups", false);
