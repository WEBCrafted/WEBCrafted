<?php
if(
	!isset($params[2]) OR
	empty($params[2])) {
	setFlash("L'id du groupe n'est pas spécifié !", "error");
}
else {
	$group = $_groups->getGroup($params[2]);
	if(empty($group)) {
		setFlash("Le groupe n'existe pas !", "error");
	}
	else {
		set(array(
			"group" => $group,
		));
		return;
	}
}
redirect("groups");
