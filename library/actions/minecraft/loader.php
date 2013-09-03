<?php
if(
	!$_users->isLogged() OR
	(!$_users->hasPermission("webcrafted.admin.*") AND
	!$_users->hasPermission("webcrafted.admin.categories")) OR
	!isset($params[2])) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}

$_minecraft = loadBundle("fr.solicium.minecraft");

switch($params[2]) {
	case "broadcast": {
		include(ROOT . "library/actions/minecraft/broadcast.php");
		break;
	}
	case "command": {
		include(ROOT . "library/actions/minecraft/command.php");
		break;
	}
	case "reload": {
		include(ROOT . "library/actions/minecraft/reload.php");
		break;
	}
	case "restart": {
		include(ROOT . "library/actions/minecraft/restart.php");
		break;
	}
	case "start": {
		include(ROOT . "library/actions/minecraft/start.php");
		break;
	}
	case "stop": {
		include(ROOT . "library/actions/minecraft/stop.php");
		break;
	}
}
