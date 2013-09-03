<?php
class TextUtils {
	/**
	 * Vérifie si le texte est valide
	 * @param string $inputText Le texte à vérifier
	 * @param mixed[] $optionalChars Des caractères optionels acceptés
	 * @return boolean Si la chaîne est valide
	 */
	public static function isValidText($inputText, $optionalChars = null) {
		$specialsChars = array("à", "é", "è", "ê", "î", "ô", "ù", "û", "À", "É", "È", "Ê", "Î", "Ô", "Ù", "Û");

		if(isset($optionalChars))
			$specialsChars = array_merge($specialsChars, $optionalChars);

		for($i = 0; $i < strlen($inputText); $i++)
			if(!ctype_alpha($inputText{$i}) OR !in_array($inputText{$i}, $specialsChars))
				return false;

		return true;
	}

	/**
	 * Retourne si la chaine en paramètre 0 commence par la chaine en paramètre 1.
	 * @param string $text Le texte à étudier
	 * @param string $prefix Le préfixe à chercher.
	 */
	private function startsWith($text, $prefix) {
		return !strncmp($text, $prefix, strlen($prefix));
	}

	/**
	 * Formatte un texte
	 * @param string $inputText Le texte à formatter
	 * @return string Le texte formatté
	 * @static
	 */
	public static function generateRawText($inputText) {
		return strtr(str_replace(array(" ", "'"), array("_", ""), strtolower($inputText)), "àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ", "aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY");
	}

	/**
	 * Formatte le titre d'une actualité
	 * @param string $title Le titre de l'article
	 * @return string Le titre formaté
	 * @static
	 */
	public static function slug($title) {
		return strtr(str_replace(array(" ", "'"), array("-", ""), strtolower($title)), "àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ", "aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY");
	}

	/**
	 * Génère un extrait à partir d'un texte.
	 * @param string $inputText Le texte de départ
	 * @param int $length A combien de caractères couper le texte
	 * @param bool $html true si prendre en compte le HTML
	 * @return string L'extrait du texte
	 * @static
	 */
	public static function extract($inputText, $length = 50, $html = false) {
		$inputText = strip_tags($inputText);

		if(strlen($inputText) > $length) {
			$extract = substr($inputText, 0, $length);
			$space = strrpos($extract, " ");
			return substr($extract, 0, $space) . "...";
		}

		return $inputText;
	}

	/**
	 * Permet de d'ajouter les accents dans un string JSON
	 * @param string $inputText Le texte à formatter
	 * @return string Le texte formatté
	 * @static
	 */
	public static function fixJson($inputText) {
		$inputText = str_replace("u00c0", "À", $inputText);
		$inputText = str_replace("u00c1", "Á", $inputText);
		$inputText = str_replace("u00c2", "Â", $inputText);
		$inputText = str_replace("u00c3", "Ã", $inputText);
		$inputText = str_replace("u00c4", "Ä", $inputText);
		$inputText = str_replace("u00c5", "Å", $inputText);
		$inputText = str_replace("u00c6", "Æ", $inputText);
		$inputText = str_replace("u00c7", "Ç", $inputText);
		$inputText = str_replace("u00c8", "È", $inputText);
		$inputText = str_replace("u00c9", "É", $inputText);
		$inputText = str_replace("u00ca", "Ê", $inputText);
		$inputText = str_replace("u00cb", "Ë", $inputText);
		$inputText = str_replace("u00cc", "Ì", $inputText);
		$inputText = str_replace("u00cd", "Í", $inputText);
		$inputText = str_replace("u00ce", "Î", $inputText);
		$inputText = str_replace("u00cf", "Ï", $inputText);
		$inputText = str_replace("u00d1", "Ñ", $inputText);
		$inputText = str_replace("u00d2", "Ò", $inputText);
		$inputText = str_replace("u00d3", "Ó", $inputText);
		$inputText = str_replace("u00d4", "Ô", $inputText);
		$inputText = str_replace("u00d5", "Õ", $inputText);
		$inputText = str_replace("u00d6", "Ö", $inputText);
		$inputText = str_replace("u00d8", "Ø", $inputText);
		$inputText = str_replace("u00d9", "Ù", $inputText);
		$inputText = str_replace("u00da", "Ú", $inputText);
		$inputText = str_replace("u00db", "Û", $inputText);
		$inputText = str_replace("u00dc", "Ü", $inputText);
		$inputText = str_replace("u00dd", "Ý", $inputText);
		$inputText = str_replace("u00df", "ß", $inputText);
		$inputText = str_replace("u00e0", "à", $inputText);
		$inputText = str_replace("u00e1", "á", $inputText);
		$inputText = str_replace("u00e2", "â", $inputText);
		$inputText = str_replace("u00e3", "ã", $inputText);
		$inputText = str_replace("u00e4", "ä", $inputText);
		$inputText = str_replace("u00e5", "å", $inputText);
		$inputText = str_replace("u00e6", "æ", $inputText);
		$inputText = str_replace("u00e7", "ç", $inputText);
		$inputText = str_replace("u00e8", "è", $inputText);
		$inputText = str_replace("u00e9", "é", $inputText);
		$inputText = str_replace("u00ea", "ê", $inputText);
		$inputText = str_replace("u00eb", "ë", $inputText);
		$inputText = str_replace("u00ec", "ì", $inputText);
		$inputText = str_replace("u00ed", "í", $inputText);
		$inputText = str_replace("u00ee", "î", $inputText);
		$inputText = str_replace("u00ef", "ï", $inputText);
		$inputText = str_replace("u00f0", "ð", $inputText);
		$inputText = str_replace("u00f1", "ñ", $inputText);
		$inputText = str_replace("u00f2", "ò", $inputText);
		$inputText = str_replace("u00f3", "ó", $inputText);
		$inputText = str_replace("u00f4", "ô", $inputText);
		$inputText = str_replace("u00f5", "õ", $inputText);
		$inputText = str_replace("u00f6", "ö", $inputText);
		$inputText = str_replace("u00f8", "ø", $inputText);
		$inputText = str_replace("u00f9", "ù", $inputText);
		$inputText = str_replace("u00fa", "ú", $inputText);
		$inputText = str_replace("u00fb", "û", $inputText);
		$inputText = str_replace("u00fc", "ü", $inputText);
		$inputText = str_replace("u00fd", "ý", $inputText);
		$inputText = str_replace("u00ff", "ÿ", $inputText);
		return $inputText;
	}
}
