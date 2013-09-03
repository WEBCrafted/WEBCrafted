<?php
if(
	!isset(
		$_POST["token"],
		$_POST["id"],
		$_POST["name"],
		$_POST["site"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	if(isset($_FILES["image"]) AND !empty($_FILES["image"]["name"])) {
		$image = $_FILES["image"];
		$type = explode("/", $image["type"]);
		$ext = strtolower($type[1]);
		$name = str_replace(".$ext", "", $image["name"]);
		$allows_ext = array("jpeg", "png", "gif");

		if(!in_array($ext, $allows_ext)) {
			setFlash("L'extension de l'image doit être png, jpg ou gif", "error");
		}
		else {
			if(!@move_uploaded_file($image["tmp_name"], ROOT . "templates/uploads/partners/$name.$ext"))
				setFlash("Impossible de déplacer l'image dans le dossier uploads", "error");
			else
				$_POST["image"] = array("name" => $name, "ext" => $ext);
		}
	}

	$success = $_partners->editPartner(
		$_POST["id"],
		$_POST["name"],
		$_POST["site"],
		isset($_POST["image"]) ? $_POST["image"] : null
	);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("Le partenaire a été édité !", "success");
}

redirect("admin/partners", false);
