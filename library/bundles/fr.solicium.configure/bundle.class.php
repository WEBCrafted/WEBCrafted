<?php
/**
 * Classe du bundle Configure. Permet de lire la configuration dans la base de données.
 * @package fr.solicium.configure
 * @author Solicium Team
 * @version 1.0
 * @since 1.0
 */
class Configure extends Core {
	/**
	 * Récupère toutes les options
	 * @return array Les options
	 */
	public static function getAll() {
		$temp = DataBase::read(PREFIX . "options");
		$options = array();

		foreach($temp as $k => $v) {
			if($v["value"] == "true")
				$v["value"] = true;
			elseif($v["value"] == "false" OR empty($v["value"]))
				$v["value"] = false;
			elseif(preg_match("#^[0-9]+$#", $v["value"]))
				$v["value"] = intval($v["value"]);

			$options[$v["entry"]] = $v["value"];
		}

		return $options;
	}

	/**
	 * Lit une entrée dans la base de données
	 * @param string $entry L'entrée à lire
	 * @return mixed La valeur de l'entrée
	 */
	public static function read($entry) {
		global $_config;

		$value = DataBase::read(PREFIX . "options", array(
			"fields" => array("value"),
			"conditions" => array(
				"entry" => $entry,
			),
		));

		if(is_array($value))
			$value = current($value);

		if($value == null)
			if($entry == "theme")
				return "install";
			else
				return false;

		elseif($value == "true")
			return true;

		elseif($value == "false" OR empty($value))
			return false;

		elseif(ctype_digit($value))
			return (int)$value;

		elseif(preg_match('/^[\[\{]\"/', $value))
			return json_decode(TextUtils::fixJson($value), true);

		else
			return $value;
	}

	/**
	 * Écris une entrée dans la base de données
	 * @param string $entry L'entrée à écrire
	 * @param mixed La valeur de l'entrée
	 */
	public static function edit($entry, $value) {
		global $_config;

		if(is_array($value))
			$value = json_encode($value);

		$success = DataBase::edit(PREFIX . "options", array(
			"fields" => array("value" => $value),
			"conditions" => array("entry" => $entry),
		));

		return $success;
	}

	/**
	 * Écris une entrée dans la base de données
	 * @param string $entry L'entrée à écrire
	 * @param mixed La valeur de l'entrée
	 */
	public static function write($entry, $value) {
		global $_config;

		if(is_array($value))
			$value = json_encode($value);

		$success = DataBase::insert(PREFIX . "options", array(
			"fields" => array(
				"entry" => $entry,
				"value" => $value,
			),
		));

		return $success;
	}
}
