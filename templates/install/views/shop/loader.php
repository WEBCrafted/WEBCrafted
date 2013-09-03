<?php
if(!isset($_SESSION["install"]["jsonapi"]) OR !$_SESSION["install"]["jsonapi"]) {
	redirect("install/jsonapi", false);
}
elseif(!Configure::read("shop_use")) {
	redirect("install/admin", false);
}

set(array(
	"page" => array(
		"title" => "Boutique",
		"description" => "Les informations StarPass pour le micro-paiement",
	),
));
?>