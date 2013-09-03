<?php
if(!isset($_POST["code1"])) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$success = $_starpass->checkCodes($_POST["code1"]);
	
	if(!$success || ($_POST["code1"] == Configure::read("shop_starpass_code") && !Configure::read("shop_starpass_usecode"))) {
		setFlash("Le code que vous avez entré n'est pas valide", "error");
	}
	else {
		$success = $_users->addMoney(Configure::read("shop_starpass_credit"));
		
		if(!$success)
			setFlash("Impossible d'ajouter vos émeraudes, contactez un administrateur", "error");
		else
			setFlash("Vos émeraudes ont été ajoutées", "success");
	}
}

redirect("shop");
