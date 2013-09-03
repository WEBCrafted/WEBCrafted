<?php
if(
	!isset($params[2]) OR
	empty($params[2])) {
	setFlash("L'id de l'offre n'est pas spécifié !", "error");
}
else {
	$item = $_shop->getItem($params[2]);
	if(empty($item)) {
		setFlash("L'offre n'existe pas !", "error");
	}
	else {
		set(array("item" => $item));
		return;
	}
}
redirect("shop");
