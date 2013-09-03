<?php
$phpversion = version_compare(phpversion(), "5.3.0", ">=");
if(function_exists("apache_get_modules")) {
	$modules = apache_get_modules();
	$mod_rewrite = in_array("mod_rewrite", $modules);
}
else {
	$mod_rewrite = getenv("HTTP_MOD_REWRITE") == "On";
}
$is_writable = is_writable(ROOT . "config/database.php");
$curl = extension_loaded("cURL");
$install = $phpversion && $is_writable;

if($install) {
	$_SESSION["install"]["requirements"] = true;
}

set(array(
	"page" => array(
		"title" => "Compatibilité",
		"description" => "Vérification des dépendances du CMS",
	),
	"phpversion" => $phpversion,
	"phpversion_error" => "La version de PHP doit être 5.3 ou plus",
	"phpversion_success" => "La version de PHP est correcte",
	"mod_rewrite" => $mod_rewrite,
	"mod_rewrite_error" => "L'extension de réécriture d'URL n'est pas activée",
	"mod_rewrite_success" => "L'extension de réécriture d'URL est activée",
	"is_writable" => $is_writable,
	"is_writable_error" => "Le fichier config/database.php ne peut pas être écrit",
	"is_writable_success" => "Le fichier config/database.php peut être écrit",
	"curl" => $curl,
	"curl_error" => "L'extension cURL n'est pas chargée",
	"curl_success" => "L'extension cURL est chargée",
	"install" => $install,
));
