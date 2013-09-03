<?php
if(!isset($_SESSION["install"]["options"]) OR !$_SESSION["install"]["options"]) {
	redirect("install/options", false);
}
elseif(!Configure::read("jsonapi_use")) {
	redirect("install/admin", false);
}

set(array(
	"page" => array(
		"title" => "JSONAPI",
		"description" => "Permet la liaison entre le serveur et WEBCrafted",
	),
));
?>