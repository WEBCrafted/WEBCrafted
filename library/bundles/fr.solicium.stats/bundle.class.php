<?php
class Stats extends Core {
	/**
	 * Le constructeur du bundle Stats
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Génèrete une chaine de caractère qui peut être employée pour créer un graphique avec la Google Chart API.
	 * @param Array $table La ou les tables à utiliser
	 * @param Array $fields Les champs date à utiliser
	 * @param Integer $since L'offset de la date à utiliser (doit être théoriquement négatif)
	 */
	public function generateDataForGoogleChartAPI($tables, $fields, $labels, $since) {
		$data = "[";

		for($i = 0; $i < count($labels); $i++)
			$data .= "{$labels[$i]}, ";

		$data = substr($data, 0, -2);
		$data .= "], ";
		
		for($day = 0; $day > $since; $day--) {
			$data .= "[";

			for($i = 0; $i < count($tables); $i++)
				$data .= DataBase::getRowsFromTableAt($tables[$i], $fields[$i], $day) . ", ";

			$data = substr($data, 0, -2);
			$data .= "], ";
		}

		$data = substr($data, 0, -2);
		return $data;
	}
}
