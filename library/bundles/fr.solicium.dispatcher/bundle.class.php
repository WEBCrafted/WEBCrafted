<?php
class Dispatcher extends Core {
	public $vars = array();

	/**
	 * Le constructeur du bundle Dispatcher
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Lance le processus de WEBCrafted
	 * @param string $view La vue
	 */
	public function dispatch($view) {
		global $_config, $_core, $_page, $_users, $_groups, $params;

		if(Configure::read("install"))
			unset($_core["prefixes"][1]);

		if(in_array($view, $_core["prefixes"])) {
			$theme = array_shift($params);

			if(isset($params[0]) AND !empty($params[0])) {
				$view = $params[0];
			}
			else {
				array_shift($params);
				$view = "home";
			}
		}
		else
			$theme = Configure::read("theme");

		define("THEME", $theme);
		define("TWEB", WEBROOT . "templates/$theme/");
		define("TLINK", in_array($theme, $_core["prefixes"]) ? WEBROOT . "$theme/" : WEBROOT);
		define("THUMBS", "http://{$_SERVER["SERVER_NAME"]}" . ($_SERVER["SERVER_PORT"] != 80 ? ":{$_SERVER["SERVER_PORT"]}" : "") . "{$_SERVER["SCRIPT_NAME"]}?page=assets/thumbs/");
		define("TROOT", ROOT . "templates/$theme/");
		define("ASSETS", str_replace("index.php?page=", "", WEBROOT . "templates/$theme/assets/"));

		// Vérification du jeton de sécurité
		if(!$_users->verifyToken()) {
			setFlash("Vous n'êtes pas autorisé à faire cette action", "error");
			redirect($view);
		}

		if(isset($params[0]) AND $params[0] == "actions") {
			require(ROOT . "library/actions/loader.php");
		}
		elseif(isset($params[0]) AND ($params[0] == "assets" || $params[0] == "templates")) {
			if($params[0] == "assets" AND isset($params[1]) AND $params[1] == "thumbs" AND isset($params[2])) {
				$_cropper = loadBundle("fr.solicium.cropper");
				preg_match("/(.*)_([0-9]+)x([0-9]+).(jpeg|png|gif)/", $params[3], $thumb);
				$_cropper->createThumbnail(ROOT . "templates/commons/uploads/{$params[2]}/", $thumb[1], $thumb[2], $thumb[3], $thumb[4]);
			}
			else if(file_exists(TROOT . implode("/", $params)))
				die(file_get_contents(TROOT . implode("/", $params)));
		}
		else {
			if(!file_exists(TROOT . "views/$view/view.php"))
				$view = "404";

			if(file_exists(ROOT . "templates/loader.php"))
				require(ROOT . "templates/loader.php");

			if(file_exists(TROOT . "loader.php")) {
				extract($this->vars);
				require_once(TROOT . "loader.php");
			}

			if(file_exists(TROOT . "views/$view/loader.php")) {
				extract($this->vars);
				require_once(TROOT . "views/$view/loader.php");
			}

			if(file_exists(TROOT . "views/$view/view.php")) {
				ob_start();
				extract($this->vars);
				require(TROOT . "views/$view/view.php");
				$this->vars["page"]["content"] = $_page->parseHtml(ob_get_clean(), get_defined_vars());
				ob_start();
				extract($this->vars);
				require(TROOT . "layout.php");
				echo $_page->parseHtml(ob_get_clean(), get_defined_vars());
			}
			else
				die("[ERREUR] Bundle PageConstructor : La vue $view n'existe pas.");
		}
	}

	/**
	 * Permet de donner une variable à une vue
	 * @param mixed[] $vars Les variables à donner
	 */
	public function set($vars = array()) {
		$this->vars = array_merge_recursive($this->vars, $vars);
	}
}
