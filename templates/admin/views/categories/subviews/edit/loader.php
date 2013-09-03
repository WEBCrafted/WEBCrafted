<?php
if(
	!isset($params[2]) OR
	empty($params[2])) {
	setFlash("L'id de la catégorie n'est pas spécifié !", "error");
}
else {
	$category = $_categories->getCategory($params[2]);
	if(empty($category)) {
		setFlash("La catégorie n'existe pas !", "error");
	}
	else {
		return;
	}
}
redirect("categories");
