<?php
if(
	!isset($params[2]) OR
	empty($params[2])) {
	setFlash("L'id du widget n'est pas spécifié !", "error");
}
else {
	$widget = $_widgets->getWidget($params[2]);
	if(empty($widget)) {
		setFlash("Le widget n'existe pas !", "error");
	}
	else {
		set(array(
			"widget" => $widget,
		));
		return;
	}
}
redirect("widgets");
