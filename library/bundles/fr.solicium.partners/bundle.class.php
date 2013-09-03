<?php
/**
 * Classe qui permet de créer simplement des partenaires.
 * @package fr.solicium.partners
 * @author Solicium Team
 * @version 1.0
 * @since 1.0
 */
class Partners extends Core {
	/**
	 * Le constructeur du bundle Partners
	 * @param string $table La table des partenaires
	 */
	public function __construct($table = "partners") {
		parent::__construct();

		if(DataBase::tableExists(PREFIX . $table))
			$this->_table = PREFIX . $table;
		else
			$this->errorTableDontExist(PREFIX . $table);
	}

	/**
	 * Récupère les informations d'un partenaire
	 * @param mixed $id L'id du partenaire
	 */
	public function getPartner($id) {
		$success = DataBase::read($this->_table, array(
			"relations" => array(
				PREFIX . "users" => array(
					array(
						"pk" => "id",
						"fk" => "creator_id",
					),
					array(
						"pk" => "id",
						"fk" => "last_editor_id",
					),
				),
			),
			"conditions" => array(
				"id" => $id,
			),
			"limit" => 1,
		));

		if(!empty($success["image"]))
			$success["image"] = json_decode(TextUtils::fixJson($success["image"]), true);

		return $success;
	}

	/**
	 * Récupère des partenaires
	 * @param int $limit Le nombre de partenaires à charger
	 * @param int $page La page actuelle
	 * @return mixed[] Un tableau contenant les partenaires
	 */
	public function getPartners($limit = false, $page = 1) {
		$success = DataBase::read($this->_table, array(
			"relations" => array(
				PREFIX . "users" => array(
					array(
						"fk" => "creator_id",
						"pk" => "id",
					),
					array(
						"fk" => "last_editor_id",
						"pk" => "id",
					),
				),
			),
			"limit" => $limit,
			"offset" => $limit * ($page - 1),
		));

		if(isset($success["id"]))
			$success = array($success);

		foreach($success as $k => $v)
			if(!empty($v["image"]))
				$success[$k]["image"] = json_decode(TextUtils::fixJson($v["image"]), true);

		return $success;
	}

	/**
	 * Récupère le nombre total de partenaires
	 * @return int Le nombre total de partenaires
	 */
	public function countAll() {
		return DataBase::count($this->_table);
	}

	/**
	 * Ajoute un partenaire dans la base données
	 * @param int $id L'id du partenaire
	 * @param string $name Le nom du partenaire
	 * @param string $url Le site du partenaire
	 * @param mixed[] $image L'image du partenaire
	 * @return boolean true si la création a réussie
	 */
	public function addPartner($id, $name, $url, $image) {
		$success = DataBase::insert($this->_table, array(
			"fields" => array(
				"id" => $id,
				"name" => $name,
				"url" => $url,
				"image" => json_encode($image),
				"creator_id" => $_SESSION["id"],
				"last_editor_id" => $_SESSION["id"],
				"date_created" => "NOW()",
				"date_last_edited" => "NOW()",
			),
		));

		return $success;
	}

	/**
	 * Edite un partenaire dans la base données
	 * @param int $id L'id du partenaire
	 * @param string $name Le nouveau nom du partenaire
	 * @param string $url Le nouveau site du partenaire
	 * @param mixed[] $image La nouvelle image du partenaire
	 * @return boolean true si l'édition a réussie
	 */
	public function editPartner($id, $name, $url, $image) {
		$success = array(
			"fields" => array(
				"name" => $name,
				"url" => $url,
			),
			"conditions" => array(
				"id" => $id,
			),
		);

		if(!empty($image) AND !is_null($image))
			$success["fields"] = array_merge($success["fields"], array("image" => json_encode($image)));

		return DataBase::edit($this->_table, $success);
	}

	/**
	 * Supprime un partenaire de la base données
	 * @param int $id L'id du partenaire à supprimer
	 * @return boolean true si la suppression a réussie
	 */
	public function deletePartner($id) {
		$success = DataBase::delete($this->_table, array(
			"conditions" => array(
				"id" => $id,
			),
		));

		return $success;
	}
}
