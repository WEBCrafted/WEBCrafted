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
	public function __construct($table = "shop_history") {
		parent::__construct();

		if(DataBase::tableExists(PREFIX . $table))
			$this->_table = PREFIX . $table;
		else
			$this->errorTableDontExist(PREFIX . $table);
	}

	/**
	 * Enregistre un historique de payement
	 * @param $content Le contenu de l'achat
	 * @param $type Le type de l'achat
	 */
	public function checkout($content, $type) {
		$id = DataBase::read($this->_table, array("fields" => array("id"), "limit" => 1, "order" => array("method" => "DESC")));

		if(empty($id))
			$id = 1;
		else
			$id = current($id) + 1;

		if(is_array($content))
			$content = json_encode($content);

		DataBase::insert($this->_table, array(
			"fields" => array(
				"id" => $id,
				"content" => $content,
				"user_id" => $_SESSION["id"],
				"type" => $type,
				"date" => "NOW()",
			),
		));
	}

	/**
	 * Récupère les derniers paiements
	 * @param int $limit Le nombre de paiements à récupèrer
	 * @param int $page La page actuelle
	 * @return mixed[] Un tableau contenant l'historique
	 */
	public function getHistory($limit = 10, $page = 1) {
		$result = DataBase::read($this->_table, array(
			"order" => array("column" => "date"),
			"limit" => $limit,
			"offset" => $limit * ($page - 1),
		));

		if (isset($result["id"]))
			$result = array($result);

		foreach($result as $k => $v)
			if(preg_match('/^[\[\{]\"/', $v["content"]))
				$result[$k]["content"] = json_decode(TextUtils::fixJson($v["content"]), true);

		return $result;
	}
}
