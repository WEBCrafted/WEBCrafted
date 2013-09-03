<?php
if(!isset($params[2])) {
	$params[2] = 1;
}
$partners = $_partners->getPartners(10, $params[2]);
$count_pages = ((int)$_partners->countAll() / 10) + 1;
