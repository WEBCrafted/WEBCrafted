<?php
/**
 * Classe qui permet de créer des groupes de permissions.
 * @package fr.solicium.groups
 * @author Solicium Team
 * @version 1.0
 * @since 1.0
 */
class Groups extends Core {
	/**
	 * Le constructeur du bundle Groups
	 * @param string $table La table des groupes
	 */
	public function __construct($table = "groups") {
		parent::__construct();

		if(DataBase::tableExists(PREFIX . $table))
			$this->_table = PREFIX . $table;
		else
			$this->errorTableDontExist(PREFIX . $table);
	}

	/**
	 * Récupère les informations d'un groupe
	 * @param int $id L'id du groupe
	 * @return mixed[] Le tableau contenant les informations
	 */
	public function getGroup($id) {
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

		if(!empty($success["permissions"]))
			$success["permissions"] = json_decode(TextUtils::fixJson($success["permissions"]), true);

		return $success;
	}

	/**
	 * Récupère les informations du groupe par défaut
	 * @return mixed[] Le tableau contenant les informations
	 */
	public function getDefaultGroup() {
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
				"signup" => true,
			),
			"limit" => 1,
		));

		if(!empty($success["permissions"]))
			$success["permissions"] = json_decode(TextUtils::fixJson($success["permissions"]), true);

		return $success;
	}

	/**
	 * Récupère des groupes
	 * @param int $limit Le nombre de groupes à charger
	 * @param int $page La page actuelle
	 * @return mixed[] Un tableau contenant les groupes
	 */
	public function getGroups($limit = false, $page = 1) {
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
	 * Ajoute un groupe dans la base données
	 * @param int $id L'id du groupe
	 * @param string $name Le nom du groupe
	 * @param mixed[] $permissions Les permissions du groupe
	 * @param bool $signup true si le groupe doit être celui par défaut
	 * @return boolean true si la création a réussie
	 */
	public function createGroup($id, $name, $permissions, $signup = false) {
		$success = DataBase::insert($this->_table, array(
			"fields" => array(
				"id" => $id,
				"name" => $name,
				"permissions" => json_encode($permissions),
				"signup" => $signup,
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
	 * @param int $id L'id du groupe
	 * @param string $name Le nom du groupe
	 * @param mixed[] $permissions Les permissions du groupe
	 * @param bool $signup true si le groupe doit être celui par défaut
	 * @return boolean true si l'édition a réussie
	 */
	public function editGroup($id, $name, $permissions, $signup) {
		$success = DataBase::edit($this->_table, array(
			"fields" => array(
				"name" => $name,
				"permissions" => json_encode($permissions),
				"signup" => $signup,
			),
			"conditions" => array(
				"id" => $id,
			),
		));

		return $success;
	}

	/**
	 * Supprime un groupe de la base données
	 * @param int $id L'id du groupe à supprimer
	 * @return boolean true si la suppression a réussie
	 */
	public function deleteGroup($id) {
		$success = DataBase::delete($this->_table, array(
			"conditions" => array(
				"id" => $id,
			),
		));

		return $success;
	}
}
