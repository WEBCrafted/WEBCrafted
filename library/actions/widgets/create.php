<?php
if(
	!isset(
		$_POST["token"],
		$_POST["title"],
		$_POST["content"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$id = DataBase::read(PREFIX . "widgets", array("fields" => array("id"), "limit" => 1, "order" => array("method" => "DESC")));

	if(empty($id))
		$id = 1;
	else
		$id = current($id) + 1;

	$success = $_widgets->createWidget(
		$id,
		$_POST["title"],
		$_POST["content"],
		isset($_POST["hidden"]) ? true : false
	);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("Le widget a été créé !", "success");
}

redirect("admin/widgets", false);
