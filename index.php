<?php
session_start(); // Démarrage de la session

/*==================================================*/
/*= I. Initialisation =*/
/*==================================================*/
define("ROOT", str_replace("index.php", "", $_SERVER["SCRIPT_FILENAME"]));

if(!file_exists(ROOT . ".htaccess"))
	$mod_rewrite = false;
elseif(function_exists("apache_get_modules")) {
	$modules = apache_get_modules();
	$mod_rewrite = in_array("mod_rewrite", $modules);
}
else
	$mod_rewrite = getenv("HTTP_MOD_REWRITE") == "On";

define("WEBROOT", str_replace("index.php", !$mod_rewrite ? "index.php?page=" : "", $_SERVER["SCRIPT_NAME"]));
define("LIBRARY", ROOT . "library/");
define("VENDORS", LIBRARY . "vendors/");

require_once(ROOT . "config/core.php");
require_once(ROOT . "config/database.php");
define("PREFIX", $_config["database_table_prefix"]);

require_once(ROOT. "library/bundles/fr.solicium.core/bundle.class.php");
require_once(ROOT. "library/bundles/fr.solicium.database/bundle.class.php");
require_once(ROOT. "library/bundles/fr.solicium.configure/bundle.class.php");

require_once(ROOT. "library/bundles/fr.solicium.utils/textutils.php");
require_once(ROOT. "library/bundles/fr.solicium.utils/timeutils.php");

DataBase::init();

$_dispatcher = loadBundle("fr.solicium.dispatcher");
$_page = loadBundle("fr.solicium.pageconstructor");
$_users = loadBundle("fr.solicium.users");
$_groups = loadBundle("fr.solicium.groups");
$_visitors = loadBundle("fr.solicium.visitors");

// Vérification des identifiants
if(isset($_SESSION["username"]) AND isset($_SESSION["password"]))
	$_users->login($_SESSION["username"], $_SESSION["password"]);

// Ajout du visteur dans la BDD
$_visitors->addVisitor();

/*==================================================*/
/*= II. Dispatcher et construction de la page =*/
/*==================================================*/
if(isset($_GET["page"]) AND !empty($_GET["page"])) {
	$params = explode("/", implode("/", explode("/", $_GET["page"]))); // Création de $params
	unset($_GET["page"]);

	if(!$mod_rewrite) {
		foreach($params as $k => $v) {
			$key = explode("=", $v);

			if(isset($key[1])) {
				$params[substr($key[0], 1, strlen($key[0]))] = $key[1];
				unset($params[$k]);
			}
		} 
	}
	else {
		foreach($_GET as $k => $v) {
			$params[$k] = $v;
			unset($_GET[$k]);
		}
	}

	$view = $params[0];
}
else
	$view = 'home';

$_dispatcher->dispatch($view);

/*==================================================*/
/*= Fonctions =*/
/*==================================================*/
/**
 * Charge un bundle avec les paramètres spécifiés
 * @param string $bundleName Le nom du bundle avec les majuscules
 * @param mixed[] $array Les paramètres pour le bundle
 * @return Core Une instance du bundle
 */
function loadBundle($bundleName) {
	$className = array_reverse(explode(".", $bundleName));
	$className = $className[0];
	$file = ROOT . "library/bundles/" . strtolower($bundleName) . "/bundle.class.php";

	if(file_exists($file)) {
		$args = func_get_args();
		unset($args[0]);
		require($file);
		$reflect = new ReflectionClass($className);
		return $reflect->newInstanceArgs($args);
	}
	else
		die("[ERREUR] Le bundle $bundleName n'existe pas. Vérifiez l'existence de '$file'");
}

/**
 * Permet d'importer un bundle pour une utilisation dans un autre
 * @param string $package Le nom de package
 */
function import($package) {
	require_once(ROOT . "library/bundles/" . $package . "/bundle.class.php");
}

/**
 * Redirige l'utilisateur vers une vue
 * @param string $view La vue
 * @param bool $theme true Si on intègre le lien du thème
 */
function redirect($view = "home", $theme = true) {
	header("Location: " . ($theme ? TLINK : WEBROOT) . $view);
	die();
}

/**
 * Créé un message rapide dans la session de l'utilisateur
 * @param string $message Le message à afficher
 * @param string $type Le type du message
 */
function setFlash($message, $type) {
	if(!isset($_SESSION["flash"])) {
		$_SESSION["flash"] = array(
			"message" => $message,
			"type" => $type
		);
	}
}

/**
 * Permet de donner une variable à une vue
 * @param mixed[] $vars Les variables à donner
 */
function set($vars = array()) {
	global $_dispatcher;
	$_dispatcher->set($vars);
}

/**
 * Permet de lire un message rapide depuis la session
 * @return string Le flash parsé
 */
function getFlash() {
	if (isset($_SESSION["flash"])) {
		global $_dispatcher, $_page;
		$flash = $_page->element("flash", $_dispatcher->vars);
		unset($_SESSION["flash"]);
		return $flash;
	}
}

/**
 * Permet de charger un élement
 * @param string $element Le nom de l'élement
 * @return string Le contenu parsé de l'élement
 */
function element($element) {
	global $_dispatcher, $_page;
	return $_page->element($element, $_dispatcher->vars);
}