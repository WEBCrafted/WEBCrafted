<?php
if(!$_users->hasPermission("webcrafted.admin.*") AND !$_users->hasPermission("webcrafted.admin.users")) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}
