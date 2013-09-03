<?php
if(
	!isset(
		$params["token"],
		$params[3]
	)) {
	setFlash("Un paramètre est manquant !", "error");
}
else {
	if(isset($_SESSION["basket"]) AND count($_SESSION["basket"]) == 4) {
		setFlash("Votre panier est plein", "error");
	}
	else {
		if(
			isset($_SESSION["basket"][$params[3]]) AND
			!empty($_SESSION["basket"][$params[3]])) {
			setFlash("L'article est déjà dans votre panier", "error");
		}
		else {
			$success = $_basket->addProduct($params[3]);

			if(!$success)
				setFlash("L'article n'existe pas", "error");
			else
				setFlash("L'article a bien été ajouté au panier", "success");
		}
	}
}

redirect("shop");
