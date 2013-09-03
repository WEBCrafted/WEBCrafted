<?php
if(
	!$_users->isLogged() OR
	!isset($params[2])) {
	setFlash("Action non autorisée !", "error");
	redirect("home");
}

$_posts = loadBundle("fr.solicium.posts");
$_comments = loadBundle("fr.solicium.comments");

switch($params[2]) {
	case "add": {
		include(ROOT . "library/actions/comments/add.php");
		break;
	}
}
