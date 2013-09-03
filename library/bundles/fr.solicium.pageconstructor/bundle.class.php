<?php
class PageConstructor extends Core {
	/**
	 * Le constructeur du bundle PageConstructor
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Permet de charger un élement
	 * @param string $element Le nom de l'élement
	 * @return string Le contenu parsé de l'élement
	 */
	public function element($element, $vars) {
		ob_start();
		extract($vars);
		include_once(TROOT . "views/elements/$element.php");
		$element = ob_get_clean();
		return $this->parseHtml($element, $vars);
	}

	/**
	 * Permet de parser une vue
	 * @param string $html Le contenu de la page
	 * @return string La page parsée
	 */
	public function parseHtml($html, $vars) {
		preg_match_all("({session.[a-zA-Z0-9\.\_\-]*})", $html, $matches);

		foreach(current($matches) as $v) {
			$new = preg_replace(array("({session.)", "(})"), "", $v);
			$split = explode(".", $new);
			$tmp = $_SESSION;

			foreach($split as $k)
				$tmp = isset($tmp[$k]) ? $tmp[$k] : "session.$k";

			$html = str_replace($v, $tmp, $html);
		}

		preg_match_all("({[a-zA-Z0-9\.\_\-]*})", $html, $matches);

		foreach(current($matches) as $v) {
			$new = preg_replace(array("({)", "(})"), "", $v);
			$split = explode(".", $new);
			$tmp = $vars;

			foreach($split as $k)
				$tmp = isset($tmp[$k]) ? $tmp[$k] : "$k";

			$html = str_replace($v, $tmp, $html);
		}
		return $html;
	}

	/**
	 * Permet de démarrer la lecture du code JS
	 */
	public function script() {
		ob_start();
	}

	/**
	 * Permet d'arrêter la lecture du code JS
	 */
	public function endscript() {
		global $_dispatcher;
		$_dispatcher->set(array("page" => array("js" => ob_get_clean())));
	}
}
?>