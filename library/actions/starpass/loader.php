<?php
if(
	!$_users->isLogged() OR
	!Configure::read("shop_use")) {
	setFlash("Action non autorisée !", "error");
	redirect("home");
}

$idd = Configure::read("shop_starpass_idd");
$idp = Configure::read("shop_starpass_idp");
$_starpass = loadBundle("fr.solicium.starpass", $idd, $idp);

switch($params[2]) {
	case "add": {
		include(ROOT . "library/actions/starpass/add.php");
		break;
	}
}
