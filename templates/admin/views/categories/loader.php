<?php
if(!$_users->hasPermission("webcrafted.admin.*") AND !$_users->hasPermission("webcrafted.admin.categories")) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}

$_categories = loadBundle("fr.solicium.categories");
