<?php
if(!isset($params[2])) {
	setFlash("Action non autorisée !", "error");
	redirect("home");
}

$_basket = loadBundle("fr.solicium.basket");

switch($params[2]) {
	case "add": {
		include(ROOT . "library/actions/basket/add.php");
		break;
	}
	case "checkout": {
		include(ROOT . "library/actions/basket/checkout.php");
		break;
	}
	case "delete": {
		include(ROOT . "library/actions/basket/delete.php");
		break;
	}
}
