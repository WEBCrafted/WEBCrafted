<?php
if(!isset($_SESSION["install"]["requirements"]) OR !$_SESSION["install"]["requirements"]) {
	redirect("install/requirements", false);
}

set(array(
	"page" => array(
		"title" => "Base de données",
		"description" => "Connexion à la base de données",
	),
));
?>