<?php
$_posts = loadBundle("fr.solicium.posts");
$posts = $_posts->getArticles(true, 4);

set(array(
	"page" => array(
		"title" => "Accueil",
	),
	"posts" => $posts,
));
