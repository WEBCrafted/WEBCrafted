<?php
/**
 * Classe qui permet de gérer de manière efficace des actualités.
 * @package fr.solicium.posts
 * @author Solicium Team
 * @version 1.0
 * @since 1.0
 */
class Posts extends Core {
	/**
	 * Le constructeur du bundle Posts
	 * @param string $table La table des articles
	 */
	public function __construct($table = "posts") {
		parent::__construct();

		if(DataBase::tableExists(PREFIX . $table))
			$this->_table = PREFIX . $table;
		else
			$this->errorTableDontExist(PREFIX . $table);
	}

	/**
	 * Récupère les informations d'un article
	 * @param mixed $id L'id de l'article
	 * @param bool $online true si l'on écupère que les articles en ligne
	 */
	public function getArticle($id, $online = false) {
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
				"type" => "post",
			),
			"limit" => 1,
		);

		if($online)
			$options["conditions"] = array_merge($options["conditions"], array(
				"online" => true,
			));

		$success = DataBase::read($this->_table, $options);

		if(!empty($success["image"]))
			$success["image"] = json_decode(TextUtils::fixJson($success["image"]), true);

		return $success;
	}

	/**
	 * Récupère des articles
	 * @param bool $online true si l'on écupère que les articles en ligne
	 * @param int $limit Le nombre d'articles à charger
	 * @param int $page La page actuelle
	 * @return mixed[] Un tableau contenant les articles
	 */
	public function getArticles($online = false, $limit = false, $page = 1) {
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
				"type" => "post",
			),
			"order" => array(
				"column" => "id",
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

		foreach($success as $k => $v)
			if(!empty($v["image"]))
				$success[$k]["image"] = json_decode(TextUtils::fixJson($v["image"]), true);

		return $success;
	}

	/**
	 * Récupère le nombre total d'articles
	 * @return int Le nombre total d'articles
	 */
	public function countAll() {
		return DataBase::count($this->_table);
	}

	/**
	 * Crée un article dans la base données
	 * @param string $title Le titre de l'article
	 * @param string $content Le contenu de l'article
	 * @param mixed[] $image L'image de l'article
	 * @param string $category_id L'id de la catégorie de l'article
	 * @param string[] $tags Les tags de l'article
	 * @param bool $online true si l'article est une publication
	 * @return boolean true si la création a réussie
	 */
	public function createArticle($id, $title, $content, $category_id, $tags, $comments, $image, $online = true) {
		$success = DataBase::insert($this->_table, array(
			"fields" => array(
				"id" => $id,
				"title" => $title,
				"slug" => TextUtils::slug($title),
				"image" => json_encode($image),
				"content" => stripslashes($content),
				"extract" => TextUtils::extract($content, 315),
				"category_id" => $category_id,
				"tags" => implode(", ", $tags),
				"type" => "post",
				"comments" => $comments,
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
	 * Edite un article dans la base données
	 * @param int $id L'ID de l'article
	 * @param string $title Le nouveau titre de l'article
	 * @param string $content Le nouveau contenu de l'article
	 * @param string $category_id L'id de la nouvelle catégorie de l'article
	 * @param string[] $tags Les nouveaux tags de l'article
	 * @param bool $online true si l'article est une publication
	 * @return boolean true si l'édition a réussie
	 */
	public function editArticle($id, $title, $content, $category_id, $tags, $comments, $image, $online = true) {
		$options = array(
			"fields" => array(
				"title" => $title,
				"slug" => TextUtils::slug($title),
				"content" => stripslashes($content),
				"extract" => TextUtils::extract($content, 315),
				"category_id" => $category_id,
				"tags" => implode(", ", $tags),
				"comments" => $comments,
				"online" => $online,
				"last_editor_id" => $_SESSION["id"],
				"date_last_edited" => "NOW()",
			),
			"conditions" => array(
				"id" => $id,
			),
		);

		if(!empty($image) AND !is_null($image))
			$options["fields"] = array_merge($options["fields"], array("image" => json_encode($image)));

		return DataBase::edit($this->_table, $options);
	}

	/**
	 * Supprime un article de la base données
	 * @param int $id L'ID de l'article à supprimer
	 * @return boolean true si la suppression a réussie
	 */
	public function deleteArticle($id) {
		$success = DataBase::delete($this->_table, array(
			"conditions" => array(
				"id" => $id,
			),
		));

		return $success;
	}
}
