<?php
if(
	!isset($params[2]) OR
	empty($params[2])) {
	setFlash("L'id du partenaire n'est pas spécifié !", "error");
}
else {
	$partner = $_partners->getPartner($params[2]);
	if(empty($partner)) {
		setFlash("Le partenaire n'existe pas !", "error");
	}
	else {
		set(array(
			"partner" => $partner,
		));
		return;
	}
}
redirect("partners");
