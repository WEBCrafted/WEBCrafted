<?php
if(Configure::read("install") OR !isset($params[2])) {
	setFlash("Le CMS est déjà installé !", "error");
	redirect("home");
}

switch($params[2]) {
	case "admin": {
		include(ROOT . "library/actions/install/admin.php");
		break;
	}
	case "database": {
		include(ROOT . "library/actions/install/database.php");
		break;
	}
	case "jsonapi": {
		include(ROOT . "library/actions/install/jsonapi.php");
		break;
	}
	case "options": {
		include(ROOT . "library/actions/install/options.php");
		break;
	}
	case "shop": {
		include(ROOT . "library/actions/install/shop.php");
		break;
	}
}
