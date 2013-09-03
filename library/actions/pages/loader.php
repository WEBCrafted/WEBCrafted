<?php
if(
	!$_users->isLogged() OR
	(!$_users->hasPermission("webcrafted.admin.*") AND
	!$_users->hasPermission("webcrafted.admin.pages")) OR
	!isset($params[2])) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}

$_pages = loadBundle("fr.solicium.pages");

switch($params[2]) {
	case "create": {
		include(ROOT . "library/actions/pages/create.php");
		break;
	}
	case "edit": {
		include(ROOT . "library/actions/pages/edit.php");
		break;
	}
	case "delete": {
		include(ROOT . "library/actions/pages/delete.php");
		break;
	}
}
