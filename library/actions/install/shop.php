<?php
if(!isset($_SESSION["install"]["jsonapi"]) OR !$_SESSION["install"]["jsonapi"]) {
	redirect("install/jsonapi", false);
}
elseif(!Configure::read("shop_use")) {
	redirect("install/admin", false);
}

if(
	!isset(
		$_POST["shop_starpass_idp"],
		$_POST["shop_starpass_idd"],
		$_POST["shop_starpass_code"],
		$_POST["shop_starpass_credit"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$_starpass = loadBundle("fr.solicium.starpass", $_POST["shop_starpass_idd"], $_POST["shop_starpass_idp"]);

	if(!$_starpass->checkCodes($_POST["shop_starpass_code"])) {
		setFlash("Vérification du document échouée, vérifiez les informations entrées", "error");
	}
	else {
		$options = array(
			"shop_starpass_idp" => $_POST["shop_starpass_idp"],
			"shop_starpass_idd" => $_POST["shop_starpass_idd"],
			"shop_starpass_code" => $_POST["shop_starpass_code"],
			"shop_starpass_credit" => $_POST["shop_starpass_credit"],
		);

		foreach ($options as $k => $v)
			Configure::edit($k, $v);

		$_SESSION["install"]["shop"] = true;
		redirect("install/admin", false);
	}
}

redirect("install/shop", false);
