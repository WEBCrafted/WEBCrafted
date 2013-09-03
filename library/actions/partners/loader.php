<?php
if(
	!$_users->isLogged() OR
	(!$_users->hasPermission("webcrafted.admin.*") AND
	!$_users->hasPermission("webcrafted.admin.partners")) OR
	!isset($params[2])) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}

$_partners = loadBundle("fr.solicium.partners");

switch($params[2]) {
	case "add": {
		include(ROOT . "library/actions/partners/add.php");
		break;
	}
	case "edit": {
		include(ROOT . "library/actions/partners/edit.php");
		break;
	}
	case "delete": {
		include(ROOT . "library/actions/partners/delete.php");
		break;
	}
}
