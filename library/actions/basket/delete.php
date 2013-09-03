<?php
if(
	!isset(
		$params["token"],
		$params[3]
	)) {
	setFlash("Un paramètre est manquant !", "error");
}
else {
	$success = $_basket->deleteProduct($params[3]);

	if(!$success)
		setFlash("L'article n'est pas dans le panier", "error");
	else
		setFlash("L'article a bien été enlevé du panier", "success");
}

redirect("shop");
