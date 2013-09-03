<?php
if(!isset($_SESSION["install"]["database"]) OR !$_SESSION["install"]["database"]) {
	redirect("install/database", false);
}

if(
	!isset(
		$_POST["name"],
		$_POST["slogan"],
		$_POST["description"],
		$_POST["keywords"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$jsonapi_use = isset($_POST["jsonapi_use"]) ? true : false;
	$shop_use = isset($_POST["shop_use"]) ? true : false;

	if(($jsonapi_use OR $shop_use) AND !extension_loaded("cURL")) {
		setFlash("L'extension cURL doit être activée pour pouvoir utiliser JSONAPI", "error");
	}
	else {
		$options = array(
			"name" => $_POST["name"],
			"slogan" => $_POST["slogan"],
			"description" => $_POST["description"],
			"keywords" => $_POST["keywords"],
			"jsonapi_use" => $jsonapi_use,
			"shop_use" => $shop_use,
			"users_secret_key" => sha1(time() . md5($_POST["name"] . rand(150, 845))),
		);

		foreach($options as $k => $v)
			Configure::edit($k, $v);

		$_SESSION["install"]["options"] = true;

		if(!$jsonapi_use)
			redirect("install/admin", false);
		else
			redirect("install/jsonapi", false);
	}
}

redirect("install/options", false);
