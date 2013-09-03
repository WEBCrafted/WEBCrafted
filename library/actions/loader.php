<?php
if(!isset($params[1])) {
	redirect("home");
}

switch($params[1]) {
	case "basket": {
		include(ROOT . "library/actions/basket/loader.php");
		break;
	}
	case "categories": {
		include(ROOT . "library/actions/categories/loader.php");
		break;
	}
	case "comments": {
		include(ROOT . "library/actions/comments/loader.php");
		break;
	}
	case "groups": {
		include(ROOT . "library/actions/groups/loader.php");
		break;
	}
	case "posts": {
		include(ROOT . "library/actions/posts/loader.php");
		break;
	}
	case "install": {
		include(ROOT . "library/actions/install/loader.php");
		break;
	}
	case "minecraft": {
		include(ROOT . "library/actions/minecraft/loader.php");
		break;
	}
	case "options": {
		include(ROOT . "library/actions/options/loader.php");
		break;
	}
	case "pages": {
		include(ROOT . "library/actions/pages/loader.php");
		break;
	}
	case "partners": {
		include(ROOT . "library/actions/partners/loader.php");
		break;
	}
	case "shop": {
		include(ROOT . "library/actions/shop/loader.php");
		break;
	}
	case "starpass": {
		include(ROOT . "library/actions/starpass/loader.php");
		break;
	}
	case "users": {
		include(ROOT . "library/actions/users/loader.php");
		break;
	}
	case "widgets": {
		include(ROOT . "library/actions/widgets/loader.php");
		break;
	}
}
