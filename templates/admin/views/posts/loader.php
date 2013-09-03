<?php
if(!$_users->hasPermission("webcrafted.admin.*") AND !$_users->hasPermission("webcrafted.admin.posts")) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}

$_posts = loadBundle("fr.solicium.posts");
$_categories = loadBundle("fr.solicium.categories");
