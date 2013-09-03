<?php
if(!isset($params[2])) {
	redirect("home");
}

switch($params[2]) {
	case "delete": {
		include(ROOT . "library/actions/users/delete.php");
		break;
	}
	case "edit": {
		include(ROOT . "library/actions/users/edit.php");
		break;
	}
	case "forgotpass": {
		include(ROOT . "library/actions/users/forgotpass.php");
		break;
	}
	case "signup": {
		include(ROOT . "library/actions/users/signup.php");
		break;
	}
	case "login": {
		include(ROOT . "library/actions/users/login.php");
		break;
	}
	case "logout": {
		$_users->logout();
		redirect("home");
		break;
	}
}
