<?php
if(Configure::read("jsonapi_use") AND (!isset($_SESSION["install"]["jsonapi"]) OR !$_SESSION["install"]["jsonapi"])) {
	redirect("install/jsonapi", false);
}

set(array(
	"page" => array(
		"title" => "Compte administrateur",
		"description" => "Création du compte administrateur du site",
	),
));
