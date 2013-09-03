<?php
if(!$options["shop_use"]) {
	$_page->load("404");
	die();
}
$idd = Configure::read("shop_starpass_idd");
$idp = Configure::read("shop_starpass_idp");
$emeralds = Configure::read("shop_starpass_credit");
$_starpass = loadBundle("fr.solicium.starpass", $idd, $idp);

set(array(
	"page" => array(
		"title" => "Acheter des émeraudes",
	),
	"starpass" => array(
		"idd" => $idd,
		"idp" => $idp,
		"js" => $_starpass->getDocumentScript(),
	),
	"emeralds" => $emeralds,
	"plural" => array(
		"emeralds" => $emeralds > 1 ? "s" : "",
	),
));
