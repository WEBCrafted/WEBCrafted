<?php
if(
	!isset(
		$_POST["token"],
		$_POST["name"],
		$_POST["site"],
		$_FILES["image"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$image = $_FILES["image"];
	$type = explode("/", $image["type"]);
	$ext = strtolower($type[1]);
	$name = str_replace(".$ext", "", $image["name"]);
	$allows_ext = array("jpeg", "png", "gif");

	if(!in_array($ext, $allows_ext)) {
		setFlash("L'extension de l'image doit être png, jpg ou gif", "error");
	}
	else {
		$id = DataBase::read(PREFIX . "partners", array("fields" => array("id"), "limit" => 1, "order" => array("method" => "DESC")));

		if(empty($id))
			$id = 1;
		else
			$id = current($id) + 1;

		if(!@move_uploaded_file($image["tmp_name"], ROOT . "templates/commons/uploads/partners/$id.$ext")) {
			setFlash("Impossible de déplacer l'image dans le dossier uploads", "error");
		}
		else {
			$success = $_partners->addPartner(
				$id,
				$_POST["name"],
				$_POST["site"],
				array("name" => $name, "ext" => $ext)
			);

			if(!$success)
				setFlash("Une erreur s'est produite !", "error");
			else
				setFlash("Le partenaire a été ajouté !", "success");
		}
	}
}

redirect("admin/partners", false);
