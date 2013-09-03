<?php
if(
	!isset(
		$_POST["token"],
		$_POST["post_id"],
		$_POST["message"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$id = DataBase::read(PREFIX . "comments", array("fields" => array("id"), "limit" => 1, "order" => array("method" => "DESC")));

	if(empty($id))
		$id = 1;
	else
		$id = current($id) + 1;

	$post = $_posts->getArticle($_POST["post_id"]);

	if(empty($post)) {
		setFlash("L'article n'existe pas !", "error");
	}
	else {
		if(!$post["comments"]) {
			setFlash("Les commentaires sont désactivés sur cette actualité", "error");
		}
		else {
			$success = $_comments->addComment(
				$id,
				$_POST["post_id"],
				$_POST["message"]
			);

			if(!$success)
				setFlash("Une erreur s'est produite !", "error");
			else
				setFlash("Votre commentaire a été posté !", "success");
		}
	}
}

redirect("post/{$_POST["post_id"]}", false);
