<?php
if(!isset($_SESSION["install"]["database"]) OR !$_SESSION["install"]["database"]) {
	redirect("install/database", false);
}

set(array(
	"page" => array(
		"title" => "Configuration",
		"description" => "Mise en place du site",
	),
));
?>