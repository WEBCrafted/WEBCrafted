<?php
if(!isset($params[2])) {
	$params[2] = 1;
}
$pages = $_pages->getPages(false, 10, $params[2]);
$count_pages = ((int)$_pages->countAll() / 10) + 1;
