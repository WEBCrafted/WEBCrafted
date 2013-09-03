<?php
/**
 * Classe qui permet de gérer de manière efficace des pages.
 * @package fr.solicium.pages
 * @author Solicium Team
 * @version 1.0
 * @since 1.0
 */
class Pages extends Core {
	/**
	 * Le constructeur du bundle Pages
	 * @param string $table La table des pages
	 */
	public function __construct($table = "posts") {
		parent::__construct();

		if(DataBase::tableExists(PREFIX . $table))
			$this->_table = PREFIX . $table;
		else
			$this->errorTableDontExist(PREFIX . $table);
	}

	/**
	 * Récupère les informations d'une page
	 * @param mixed $id L'id de la page
	 * @param bool $online true si l'on écupère que les articles en ligne
	 */
	public function getPage($id, $online = false) {
		$options = array(
			"conditions" => array(
				"id" => $id,
				"type" => "page",
			),
			"limit" => 1,
		);

		if($online)
			$options["conditions"] = array_merge($options["conditions"], array(
				"online" => true,
			));

		$success = DataBase::read($this->_table, $options);
		return $success;
	}

	/**
	 * Récupère des pages
	 * @param bool $online true si l'on écupère que les articles en ligne
	 * @param int $limit Le nombre d'articles à charger.
	 * @param int $page La page actuelle
	 * @return mixed[] Un tableau contenant les pages
	 */
	public function getPages($online = false, $limit = false, $page = 1) {
		$options = array(
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
			"conditions" => array(
				"type" => "page",
			),
			"limit" => $limit,
			"offset" => $limit * ($page - 1),
		);

		if($online)
			$options["conditions"] = array_merge($options["conditions"], array(
				"online" => true,
			));

		$success = DataBase::read($this->_table, $options);

		if(isset($success["id"]))
			$success = array($success);

		return $success;
	}

	/**
	 * Récupère le nombre total de pages
	 * @return int Le nombre total de pages
	 */
	public function countAll() {
		return DataBase::count($this->_table);
	}

	/**
	 * Crée une page dans la base données
	 * @param int $id L'id de la page
	 * @param string $title Le titre de la page
	 * @param string $content Le contenu de la page
	 * @param string $slug Le slug de la page
	 * @param string $category_id L'id de la catégorie de la page
	 * @param string[] $tags Les tags de la page
	 * @param bool $online true si la page est une publication
	 * @return boolean true si la création a réussie
	 */
	public function createPage($id, $title, $content, $slug, $category_id, $tags, $online = true) {
		$success = DataBase::insert($this->_table, array(
			"fields" => array(
				"id" => $id,
				"title" => $title,
				"slug" => !empty($slug) ? $slug : TextUtils::slug($title),
				"content" => stripslashes($content),
				"extract" => TextUtils::extract($content, 400),
				"category_id" => $category_id,
				"tags" => implode(", ", $tags),
				"type" => "page",
				"comments" => 0,
				"online" => $online,
				"creator_id" => $_SESSION["id"],
				"last_editor_id" => $_SESSION["id"],
				"date_created" => "NOW()",
				"date_last_edited" => "NOW()",
			),
		));
		return $success;
	}

	/**
	 * Edite une page dans la base données
	 * @param int $id L'id de la page
	 * @param string $title Le nouveau titre de la page
	 * @param string $content Le nouveau contenu de la page
	 * @param string $slug Le nouveau slug de la page
	 * @param string $category_id L'id de la nouvelle catégorie de la page
	 * @param string[] $tags Les nouveaux tags de la page
	 * @param bool $online true si la page est une publication
	 * @return boolean true si l'édition a réussie
	 */
	public function editPage($id, $title, $content, $slug, $category_id, $tags, $online = true) {
		$success = DataBase::edit($this->_table, array(
			"fields" => array(
				"title" => $title,
				"slug" => !empty($slug) ? $slug : TextUtils::slug($title),
				"content" => stripslashes($content),
				"extract" => TextUtils::extract($content, 400),
				"category_id" => $category_id,
				"tags" => implode(", ", $tags),
				"online" => $online,
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
	 * Supprime une page de la base données
	 * @param int $id L'id de la page à supprimer
	 * @return boolean true si la suppression a réussie
	 */
	public function deletePage($id) {
		$success = DataBase::delete($this->_table, array(
			"conditions" => array(
				"id" => $id,
			),
		));
		return $success;
	}
}
