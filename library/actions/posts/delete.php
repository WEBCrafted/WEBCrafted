<?php
if(
	!isset(
		$params["token"],
		$params[3]
	)) {
	setFlash("Un paramètre est manquant !", "error");
}
else {
	$_comments = loadBundle("fr.solicium.comments");
	$comments = $_comments->findComments($params[3]);

	foreach($comments as $v)
		$_comments->deleteComment($v["id"]);

	$success = $_posts->deleteArticle($params[3]);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("L'actualité N°{$params[3]} a été supprimée !", "success");
}

redirect("admin/posts", false);
