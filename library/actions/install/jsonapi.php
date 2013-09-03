<?php
if(!isset($_SESSION["install"]["options"]) OR !$_SESSION["install"]["options"]) {
	redirect("install/options", false);
}
elseif(!Configure::read("jsonapi_use")) {
	redirect("install/admin", false);
}

if(
	!isset(
		$_POST["mc_server"],
		$_POST["jsonapi_port"],
		$_POST["jsonapi_username"],
		$_POST["jsonapi_password"],
		$_POST["jsonapi_salt"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	require(VENDORS . "jsonapi.php");

	$mc_server = explode(":", $_POST["mc_server"]);
	$jsonapi = new JSONAPI($mc_server[0], $_POST["jsonapi_port"], $_POST["jsonapi_username"], $_POST["jsonapi_password"], $_POST["jsonapi_salt"]);
	$serverdata = $jsonapi->call("getServer");

	if(!isset($serverdata["success"])) {
		setFlash("Connexion à JSONAPI échouée", "error");
	}
	else {
		$options = array(
			"server_ip" => $mc_server[0],
			"server_port" => isset($mc_server[1]) ? $mc_server[1] : 25565,
			"jsonapi_port" => $_POST["jsonapi_port"],
			"jsonapi_username" => $_POST["jsonapi_username"],
			"jsonapi_password" => $_POST["jsonapi_password"],
			"jsonapi_salt" => $_POST["jsonapi_salt"],
		);

		foreach($options as $k => $v)
			Configure::edit($k, $v);

		$_SESSION["install"]["jsonapi"] = true;
		redirect("install/shop", false);
	}
}

redirect("install/jsonapi", false);
