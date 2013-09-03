<?php
if(
	!$_users->isLogged() OR
	(!$_users->hasPermission("webcrafted.admin.*") AND
	!$_users->hasPermission("webcrafted.admin.shop")) OR
	!isset($params[2])) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}

$_shop = loadBundle("fr.solicium.shop");

switch($params[2]) {
	case "create": {
		include(ROOT . "library/actions/shop/create.php");
		break;
	}
	case "edit": {
		include(ROOT . "library/actions/shop/edit.php");
		break;
	}
	case "delete": {
		include(ROOT . "library/actions/shop/delete.php");
		break;
	}
}
