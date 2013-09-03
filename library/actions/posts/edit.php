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
			if(!@move_uploaded_file($image["tmp_name"], ROOT . "templates/" . Configure::read("theme") . "/assets/images/uploads/$name.$ext"))
				setFlash("Impossible de déplacer l'image dans le dossier uploads", "error");
			else 
				$_POST["image"] = array("name" => $name, "ext" => $ext);
		}
	}

	$success = $_posts->editArticle(
		$_POST["id"],
		$_POST["title"],
		$_POST["content"],
		isset($_POST["category_id"]) ? $_POST["category_id"] : 1,
		explode(",", $_POST["tags"]),
		isset($_POST["comments"]) ? 1 : 0,
		isset($_POST["image"]) ? $_POST["image"] : null,
		$_POST["submit"] == "Publier" ? 1 : 0
	);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("L'actualité a été éditée !", "success");
}
redirect("admin/posts", false);
