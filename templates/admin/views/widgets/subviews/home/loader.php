<?php
if(!isset($params[2])) {
	$params[2] = 1;
}
$widgets = $_widgets->getWidgets(true, 10, $params[2]);
$count_pages = ((int)$_widgets->countAll() / 10) + 1;
