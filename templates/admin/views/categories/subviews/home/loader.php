<?php
if(!isset($params[2])) {
	$params[2] = 1;
}
$categories = $_categories->getCategories(10, $params[2]);
array_shift($categories);
$count_pages = ((int)$_categories->countAll() / 10) + 1;
