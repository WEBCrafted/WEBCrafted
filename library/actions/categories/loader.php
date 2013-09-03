<?php
if(
	!$_users->isLogged() OR
	(!$_users->hasPermission("webcrafted.admin.*") AND
	!$_users->hasPermission("webcrafted.admin.categories")) OR
	!isset($params[2])) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}

$_categories = loadBundle("fr.solicium.categories");

switch($params[2]) {
	case "create": {
		include(ROOT . "library/actions/categories/create.php");
		break;
	}
	case "edit": {
		include(ROOT . "library/actions/categories/edit.php");
		break;
	}
	case "delete": {
		include(ROOT . "library/actions/categories/delete.php");
		break;
	}
}
