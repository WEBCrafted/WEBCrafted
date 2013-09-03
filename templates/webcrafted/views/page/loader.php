<?php
if(
	!isset($params[1]) OR
	empty($params[1])) {
	setFlash("L'id de la page n'est pas spécifié !", "error");
}
else {
	$page = $_pages->getPage($params[1]);
	if(empty($page)) {
		setFlash("La page n'existe pas !", "error");
	}
	else {
		set(array(
			"page" => array(
				"title" => $page["title"],
			),
			"post" => $page,
		));
		return;
	}
}
redirect("home");
