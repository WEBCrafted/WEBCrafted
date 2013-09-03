<?php
$_posts = loadBundle("fr.solicium.posts");

if(
	!isset($params[1]) OR
	empty($params[1])) {
	setFlash("L'id de l'article n'est pas spécifié !", "error");
}
else {
	$post = $_posts->getArticle($params[1]);
	if(empty($post)) {
		setFlash("L'article n'existe pas !", "error");
	}
	else {
		$comments = $_comments->findComments($params[1]);
		set(array(
			"page" => array(
				"title" => $post["title"],
			),
			"plural" => array(
				"comments" => count($comments) > 1 ? "s" : "",
			),
			"post" => $post,
			"comments" => $comments,
		));
		return;
	}
}
redirect("home");
