<?php
if(!isset($params[2])) {
	$params[2] = 1;
}
$items = $_shop->getItems(10, $params[2]);
$count_pages = ((int)$_shop->countAll() / 10) + 1;
