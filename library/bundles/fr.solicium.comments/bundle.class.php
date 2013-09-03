<?php
/**
 * Classe qui permet de gérer de manière efficace des commentaires.
 * @package fr.solicium.comments
 * @author Solicium Team
 * @version 1.0
 * @since 1.0
 */
class Comments extends Core {
	/**
	 * Le constructeur du bundle Comments
	 * @param string $table La table des commentaires
	 */
	public function __construct($table = "comments") {
		parent::__construct();

		if(DataBase::tableExists(PREFIX . $table))
			$this->_table = PREFIX . $table;
		else
			$this->errorTableDontExist(PREFIX . $table);
	}

	/**
	 * Ajoute un commentaire
	 * @param int $id L'id du commentaire
	 * @param int $post_id L'id de l'article
	 * @param string $content Le contenu du commentaire
	 * @return bool true si le commentaire a été posté
	 */
	public function addComment($id, $post_id, $content) {
		$success = DataBase::insert($this->_table, array(
			"fields" => array(
				"id" => $id,
				"content" => $content,
				"post_id" => $post_id,
				"creator_id" => $_SESSION["id"],
				"date_created" => "NOW()",
			),
		));

		return $success;
	}

	/**
	 * Supprime un commentaire de la base données
	 * @param int $id L'id du commentaire à supprimer
	 * @return boolean true si la suppression a réussie
	 */
	public function deleteComment($id) {
		$success = DataBase::delete($this->_table, array(
			"conditions" => array(
				"id" => $id,
			),
		));

		return $success;
	}

	/**
	 * Récupère les commentaires d'un article
	 * @param int $id L'id de l'article
	 * @return mixed[] Les commentaires
	 */
	public function findComments($id) {
		$comments = DataBase::read($this->_table, array(
			"relations" => array(
				PREFIX . "users" => array(
					"pk" => "id",
					"fk" => "creator_id",
				),
			),
			"conditions" => array(
				"post_id" => $id,
			),
			"order" => array(
				"column" => "id",
				"method" => "DESC",
			),
		));

		if(isset($comments["id"]))
			$comments = array($comments);

		return $comments;
	}

	/**
	 * Récupère les derniers commentaires postés
	 * @param int $limit Le nombre de commentaires à récupèrer
	 * @return mixed[] Les commentaires
	 */
	public function getLastComments($limit = 2) {
		$comments = DataBase::read($this->_table, array(
			"relations" => array(
				PREFIX . "users" => array(
					"pk" => "id",
					"fk" => "creator_id",
				),
			),
			"order" => array(
				"column" => "id",
				"method" => "DESC",
			),
			"limit" => $limit,
		));

		if(isset($comments["id"]))
			$comments = array($comments);

		return $comments;
	}
}
