<?php
if(!isset($params[2])) {
	$params[2] = 1;
}
$posts = $_posts->getArticles(false, 10, $params[2]);
$count_pages = ((int)$_posts->countAll() / 10) + 1;
