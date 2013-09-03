<?php
/**
 * Classe qui permet de gérer de manière efficace des catégories.
 * @package fr.solicium.catégories
 * @author Solicium Team
 * @version 1.0
 * @since 1.0
 */
class Categories extends Core {
	/**
	 * Le constructeur du bundle Categories
	 * @param string $table La table des catégories
	 */
	public function __construct($table = "categories") {
		parent::__construct();

		if(DataBase::tableExists(PREFIX . $table))
			$this->_table = PREFIX . $table;
		else
			$this->errorTableDontExist(PREFIX . $table);
	}

	/**
	 * Récupère les informations d'une catégorie
	 * @param mixed $id L'id de la catégorie
	 */
	public function getCategory($id) {
		$success = DataBase::read($this->_table, array(
			"conditions" => array(
				"id" => $id,
			),
			"limit" => 1,
		));

		return $success;
	}

	/**
	 * Récupère des catégories
	 * @param int $limit Le nombre d'articles à charger.
	 * @param int $page La page actuelle
	 * @return mixed[] Un tableau contenant les pages
	 */
	public function getCategories($limit = false, $page = 1) {
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
	 * Récupère le nombre total de catégories
	 * @return int Le nombre total de catégories
	 */
	public function countAll() {
		return DataBase::count($this->_table);
	}

	/**
	 * Crée une catégorie dans la base données
	 * @param int $id L'id de la catégorie
	 * @param string $name Le nom de la catégorie
	 * @return boolean true si la création a réussie
	 */
	public function createCategory($id, $name) {
		$success = DataBase::insert($this->_table, array(
			"fields" => array(
				"id" => $id,
				"name" => $name,
				"creator_id" => $_SESSION["id"],
				"last_editor_id" => $_SESSION["id"],
				"date_created" => "NOW()",
				"date_last_edited" => "NOW()",
			),
		));

		return $success;
	}

	/**
	 * Edite une catégorie dans la base données
	 * @param int $id L'id de la catégorie
	 * @param string $name Le nouveau titre de la catégorie
	 * @return boolean true si l'édition a réussie
	 */
	public function editCategory($id, $name) {
		$success = DataBase::edit($this->_table, array(
			"fields" => array(
				"name" => $name,
				"last_editor_id" => $_SESSION["id"],
				"date_last_edited" => "NOW()",
			),
			"conditions" => array(
				"id" => $id,
			),
		));

		return $success;
	}

	/**
	 * Supprime une catégorie de la base données
	 * @param int $id L'id de la catégorie à supprimer
	 * @return boolean true si la suppression a réussie
	 */
	public function deleteCategory($id) {
		$success = DataBase::delete($this->_table, array(
			"conditions" => array(
				"id" => $id,
			),
		));

		return $success;
	}
}
