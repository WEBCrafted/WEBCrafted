<?php
if(!$_users->hasPermission("webcrafted.admin.*") AND !$_users->hasPermission("webcrafted.admin.widgets")) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}

$_widgets = loadBundle("fr.solicium.widgets");
