<?php
class StarPass extends Core {
	private $_idd, $_idp;

	/**
	 * Le constructeur du bundle StarPass
	 * @param int $idd L'id du document Starpass
	 * @param int $idp L'idp du document Starpass
	 */
	public function __construct($idd, $idp) {
		parent::__construct();
		$this->_idd = $idd;
		$this->_idp = $idp;
	}

	/**
	 * Vérifie les codes StarPass envoyés
	 * @param mixed[] $codes Les codes à tester
	 * @return boolean true si les codes sont corrects
	 */
	public function checkCodes($codes = array()) {
		if(is_string($codes))
			$codes = array($codes);

		$codes = implode(";", $codes);
		$response = file_get_contents("http://script.starpass.fr/check_php.php?ident=" . $this->_idp . ";;" . $this->_idd . "&codes=$codes&datas=");
		$tab = explode("|", $response);
		return substr($tab[0], 0, 3) == "OUI";
	}

	/**
	 * Génére le code Javascript nécessaire à Starpass
	 * @return string Le code Javascript
	 */
	public function getDocumentScript() {
		$script = '<script src="http://script.starpass.fr/script.php?idd=' . $this->_idd . '&verif_en_php=1&datas="></script>';
		return $script;
	}
}
