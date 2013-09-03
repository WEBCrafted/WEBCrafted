<?php
/**
 * Classe qui permet de créer simplement des widgets.
 * @package fr.solicium.widgets
 * @author Solicium Team
 * @version 1.0
 * @since 1.0
 */
class Widgets extends Core {
	/**
	 * Le constructeur du bundle Widgets
	 * @param string $table La table des widgets
	 */
	public function __construct($table = "widgets") {
		parent::__construct();

		if(DataBase::tableExists(PREFIX . $table))
			$this->_table = PREFIX . $table;
		else
			$this->errorTableDontExist(PREFIX . $table);
	}

	/**
	 * Récupère les informations d'un widget
	 * @param mixed $id L'id du widget
	 * @param bool $hidden true si l'on veut aussi récupèrer les widgets cachés
	 */
	public function getWidget($id, $hidden = true) {
		$options = array(
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
		);

		if(!$hidden)
			$options["conditions"] = array_merge($options["conditions"], array(
				"hidden" => 0,
			));

		$success = DataBase::read($this->_table, $options);
		return $success;
	}

	/**
	 * Récupère des widgets
	 * @param bool $hidden true si l'on veut aussi récupèrer les widgets cachés
	 * @param int $limit Le nombre de widgets à charger
	 * @param int $page La page actuelle
	 * @return mixed[] Un tableau contenant les widgets
	 */
	public function getWidgets($hidden = true, $limit = false, $page = 1) {
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
			"order" => array(
				"column" => "id",
				"method" => "ASC",
			),
			"limit" => $limit,
			"offset" => $limit * ($page - 1),
		);

		if(!$hidden)
			$options["conditions"] = array(
				"hidden" => 0,
			);

		$success = DataBase::read($this->_table, $options);

		if(isset($success["id"]))
			$success = array($success);

		return $success;
	}

	/**
	 * Récupère le nombre total de widgets
	 * @return int Le nombre total de widgets
	 */
	public function countAll() {
		return DataBase::count($this->_table);
	}

	/**
	 * Crée un widget dans la base données
	 * @param int $id L'id du widget
	 * @param string $title Le titre du widget
	 * @param string $content Le contenu du widget
	 * @param string $hidden true si le widget ne doit pas s'afficher
	 * @return boolean true si la création a réussie
	 */
	public function createWidget($id, $title, $content, $hidden = false) {
		$options = array(
			"fields" => array(
				"id" => $id,
				"title" => $title,
				"content" => stripslashes($content),
				"creator_id" => $_SESSION["id"],
				"last_editor_id" => $_SESSION["id"],
				"date_created" => "NOW()",
				"date_last_edited" => "NOW()",
			),
		);

		if($hidden)
			$options["fields"] = array_merge($options["fields"], array(
				"hidden" => 1,
			));

		$success = DataBase::insert($this->_table, $options);
		return $success;
	}

	/**
	 * Edite un widget dans la base données
	 * @param int $id L'id du widget
	 * @param string $title Le nouveau titre du widget
	 * @param string $content Le nouveau contenu du widget
	 * @param string $hidden true si le widget ne doit pas s'afficher
	 * @return boolean true si l'édition a réussie
	 */
	public function editWidget($id, $title, $content, $hidden = false) {
		$options = array(
			"fields" => array(
				"title" => $title,
				"content" => stripslashes($content),
				"last_editor_id" => $_SESSION["id"],
				"date_last_edited" => "NOW()",
			),
			"conditions" => array(
				"id" => $id,
			),
		);

		if($hidden)
			$options["fields"] = array_merge($options["fields"], array(
				"hidden" => 1,
			));

		$success = DataBase::edit($this->_table, $options);
		return $success;
	}

	/**
	 * Supprime un widget de la base données
	 * @param int $id L'id de lu widget à supprimer
	 * @return boolean true si la suppression a réussie
	 */
	public function deleteWidget($id) {
		$success = DataBase::delete($this->_table, array(
			"conditions" => array(
				"id" => $id,
			),
		));

		return $success;
	}
}
