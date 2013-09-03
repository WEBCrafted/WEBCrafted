<?php
if(!$_users->hasPermission("webcrafted.admin.*") AND !$_users->hasPermission("webcrafted.admin.pages")) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}

$_pages = loadBundle("fr.solicium.pages");
$_categories = loadBundle("fr.solicium.categories");
