<?php
if(
	!isset($params[2]) OR
	empty($params[2])) {
	setFlash("L'id de la page n'est pas spécifié !", "error");
}
else {
	$post = $_pages->getPage($params[2]);
	$categories = $_categories->getCategories();
	if(empty($post)) {
		setFlash("La page n'existe pas !", "error");
	}
	else {
		set(array(
			"post" => $post,
			"categories" => $categories,
		));
		return;
	}
}
redirect("pages");