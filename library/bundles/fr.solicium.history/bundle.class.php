<?php
/**
 * Classe des historiques. Permet de sauvegarder des données dans les tables avec le préfixe "history"
 * @package fr.solicium.database
 * @author Solicium Team
 * @version 2.0
 * @since 1.0
 */
class History extends Core {
	/**
	 * Le constructeur du bundle History
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Enregistre un historique de payement
	 * @param $tableHistory Le nom de la table de l'historique de paiement
	 * @param $tableItems Le nom de la table contenant les articles
	 */
	public function checkout($tableHistory = "shop_history", $tableItems = "shop_items") {
		if(!DataBase::tableExists(PREFIX . $tableHistory))
			$this->errorTableDontExist(PREFIX . $tableItems);

		if(!DataBase::tableExists(PREFIX . $tableItems))
			$this->errorTableDontExist(PREFIX . $tableItems);

		DataBase::insert($tableHistory, array(
			"fields" => array(
				"content" => json_encode($_SESSION["basket"]),
				"user_id" => $_SESSION["username"]["id"],
				"date" => "NOW()",
			),
		));
	}

	/**
	 * Récupère les derniers paiements
	 * @param string $table Le nom de la table
	 * @param int $limit Le nombre de paiements à récupèrer
	 * @param int $page La page actuelle
	 * @return mixed[] Un tableau contenant l'historique
	 */
	public function getHistory($table = "shop_history", $limit = 5, $page = 1) {
		if(!DataBase::tableExists(PREFIX . $table))
			$this->errorTableDontExist(PREFIX . $table);

		$result = DataBase::read($table, array(
			"order" => "time DESC",
			"limit" => $limit,
			"offset" => $limit * ($page - 1)
		));

		if (isset($result["id"]))
			$result = array($result);

		for($i = 0; $i < count($result); $i++)
			$result = array_merge($result, unserialize($result["content"]));

		return current($result);
	}
}
