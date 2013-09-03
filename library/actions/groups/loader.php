<?php
if(
	!$_users->isLogged() OR
	(!$_users->hasPermission("webcrafted.admin.*") AND
	!$_users->hasPermission("webcrafted.admin.groups")) OR
	!isset($params[2])) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}

switch($params[2]) {
	case "create": {
		include(ROOT . "library/actions/groups/create.php");
		break;
	}
	case "edit": {
		include(ROOT . "library/actions/groups/edit.php");
		break;
	}
	case "delete": {
		include(ROOT . "library/actions/groups/delete.php");
		break;
	}
}
