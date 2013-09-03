<?php
if(
	!$_users->isLogged() OR
	(!$_users->hasPermission("webcrafted.admin.*") AND
	!$_users->hasPermission("webcrafted.admin.widgets")) OR
	!isset($params[2])) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}

$_widgets = loadBundle("fr.solicium.widgets");

switch($params[2]) {
	case "create": {
		include(ROOT . "library/actions/widgets/create.php");
		break;
	}
	case "edit": {
		include(ROOT . "library/actions/widgets/edit.php");
		break;
	}
	case "delete": {
		include(ROOT . "library/actions/widgets/delete.php");
		break;
	}
}
