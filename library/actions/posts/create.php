<?php
if(
	!isset(
		$_POST["token"],
		$_POST["title"],
		$_POST["content"],
		$_POST["tags"],
		$_POST["submit"],
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
		$id = DataBase::read(PREFIX . "posts", array("fields" => array("id"), "limit" => 1, "order" => array("method" => "DESC")));

		if(empty($id))
			$id = 1;
		else
			$id = current($id) + 1;

		if(!@move_uploaded_file($image["tmp_name"], ROOT . "templates/commons/uploads/posts/$id.$ext")) {
			setFlash("Impossible de déplacer l'image dans le dossier uploads", "error");
		}
		else {
			$success = $_posts->createArticle(
				$id,
				$_POST["title"],
				$_POST["content"],
				isset($_POST["category_id"]) ? $_POST["category_id"] : 1,
				explode(",", $_POST["tags"]),
				isset($_POST["comments"]) ? 1 : 0,
				array("name" => $name, "ext" => $ext),
				$_POST["submit"] == "Publier" ? 1 : 0
			);

			if(!$success)
				setFlash("Une erreur s'est produite !", "error");
			else
				setFlash("L'actualité a été publiée !", "success");
		}
	}
}

redirect("admin/posts", false);
