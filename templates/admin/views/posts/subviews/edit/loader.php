<?php
if(
	!isset($params[2]) OR
	empty($params[2])) {
	setFlash("L'id de l'article n'est pas spécifié !", "error");
}
else {
	$post = $_posts->getArticle($params[2]);
	if(empty($post)) {
		setFlash("L'article n'existe pas !", "error");
	}
	else {
		$categories = $_categories->getCategories();

		set(array(
			"post" => $post,
			"categories" => $categories,
		));
		return;
	}
}
redirect("posts");
