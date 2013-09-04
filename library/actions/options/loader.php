<?php
if(
	!$_users->isLogged() OR
	(!$_users->hasPermission("webcrafted.admin.*") AND
	!$_users->hasPermission("webcrafted.admin.options"))) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}

if(
	!isset(
		$_POST["token"],
		$_POST["name"],
		$_POST["slogan"],
		$_POST["description"],
		$_POST["keywords"],
		$_POST["theme"],
		$_POST["mc_server"],
		$_POST["jsonapi_username"],
		$_POST["jsonapi_password"],
		$_POST["jsonapi_port"],
		$_POST["jsonapi_salt"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	$jsonapi_use = isset($_POST["jsonapi_use"]) ? true : false;
	$shop_use = isset($_POST["shop_use"]) ? true : false;
	$options = array(
		"name" => $_POST["name"],
		"slogan" => $_POST["slogan"],
		"description" => $_POST["description"],
		"keywords" => $_POST["keywords"],
		"theme" => $_POST["theme"],
		"jsonapi_use" => $jsonapi_use,
		"shop_use" => $shop_use,
	);

	if($jsonapi_use) {
		require(VENDORS . "jsonapi.php");

		$mc_server = explode(":", $_POST["mc_server"]);
		$jsonapi = new JSONAPI($mc_server[0], $_POST["jsonapi_port"], $_POST["jsonapi_username"], $_POST["jsonapi_password"], $_POST["jsonapi_salt"]);
		$serverdata = $jsonapi->call("getServer");

		if(!isset($serverdata["success"])) {
			setFlash("Connexion à JSONAPI échouée", "error");
		}
		else {
			if($shop_use) {
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
						$options = array_merge($options, array(
							"shop_starpass_idd" => $_POST["shop_starpass_idd"],
							"shop_starpass_idp" => $_POST["shop_starpass_idp"],
							"shop_starpass_code" => $_POST["shop_starpass_code"],
							"shop_starpass_credit" => $_POST["shop_starpass_credit"],
							"shop_starpass_usecode" => isset($_POST["shop_starpass_usecode"]) ? true : false,
						));
					}
				}
			}

			$options = array_merge($options, array(
				"server_ip" => $mc_server[0],
				"server_port" => isset($mc_server[1]) ? $mc_server[1] : 25565,
				"jsonapi_username" => $_POST["jsonapi_username"],
				"jsonapi_password" => $_POST["jsonapi_password"],
				"jsonapi_port" => $_POST["jsonapi_port"],
				"jsonapi_salt" => $_POST["jsonapi_salt"],
			));
		}
	}

	foreach($options as $k => $v) {
		$success = Configure::edit($k, $v);

		if(!$success) {
			setFlash("Une erreur s'est produite !", "error");
			break;
		}
	}

	setFlash("La configuration a été éditée !", "success");
}
redirect("admin/options", false);
