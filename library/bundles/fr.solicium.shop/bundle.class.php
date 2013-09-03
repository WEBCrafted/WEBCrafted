<?php
/**
 * Classe du Shop. Contient toutes les fonction qui permettent de gérer, d'afficher et de supprimer des articles du magasin
 * @package fr.solicium.shop
 * @author Solicium Team
 * @version 1.0
 * @since 1.0
 */
class Shop extends Core {
	/**
	 * Le constructeur du bundle Shop
	 */
	public function __construct($table = "shop_items") {
		parent::__construct();

		if(DataBase::tableExists(PREFIX . $table))
			$this->_table = PREFIX . $table;
		else
			$this->errorTableDontExist(PREFIX . $table);
	}

	/**
	 * Récupère les articles
	 * @param int $limit Le nombre d'article à récupérer
	 * @param int $page La page actuelle
	 * @return mixed[] les articles récupérés
	 */
	public function getItems($limit = false, $page = 1) {
		$itemdata = DataBase::read($this->_table, array(
			"limit" => $limit,
			"offset" => $limit * ($page - 1),
		));

		if(isset($itemdata["id"]))
			$itemdata = array($itemdata);

		return $itemdata;
	}

	/**
	 * Récupère les articles grâce à leur catégorie
	 * @return mixed[] les articles rangés
	 */
	public function getItemsByCategory($category) {
		$itemdata = DataBase::read($this->_table, array(
			"conditions" => array(
				"category" => $category,
			),
		));

		if(isset($itemdata["id"]))
			$itemdata = array($itemdata);

		return $itemdata;
	}

	/**
	 * Récupère les articles grâce à leur nom
	 * @return mixed[] les articles rangés
	 */
	public function getItemsByName() {
		$itemdata = DataBase::read($this->_table, array(
			"order" => array(
				"column" => "name",
				"method" => "ASC",
			),
		));

		if(isset($itemdata["id"]))
			$itemdata = array($itemdata);

		return $itemdata;
	}
	/**
	 * Récupère les articles grâce à leur prix
	 * @param string $method La méthode à utiliser
	 * @return mixed[] les articles rangés
	 */
	public function getItemsByPrice($method = "ASC") {
		$itemdata = DataBase::read($this->_table, array(
			"order" => array(
				"column" => "price",
				"method" => $method,
			),
		));

		if(isset($itemdata["id"]))
			$itemdata = array($itemdata);

		return $itemdata;
	}

	/**
	 * Récupère les articles grâce à leur durée d'utilisation
	 * @return mixed[] les articles rangés
	 */
	public function getItemsByDuration() {
		$itemdata = DataBase::read($this->_table, array(
			"order" => array(
				"column" => "duration",
				"method" => "ASC",
			),
		));

		if(isset($itemdata["id"]))
			$itemdata = array($itemdata);

		return $itemdata;
	}

	/**
	 * Récupère un article
	 * @param string $id L'id de l'article
	 */
	public function getItem($id) {
		$itemdata = DataBase::read($this->_table, array(
			"conditions" => array(
				"id" => $id,
			),
		));

		if(isset($itemdata["args"]) AND preg_match('/^[\[\{]\"/', $itemdata["args"]))
			$itemdata["args"] = json_decode(TextUtils::fixJson($itemdata["args"]), true);

		return $itemdata;
	}

	/**
	 * Récupère le nombre total d'articles
	 * @return int Le nombre total d'articles
	 */
	public function countAll() {
		return DataBase::count($this->_table);
	}

	/**
	 * Ajoute un article dans la base de données
	 * @param int $id L'id de l'article
	 * @param string $name Le nom de l'article
	 * @param string $image_url L'url de l'image
	 * @param string $description La description de l'article
	 * @param string $category La catégorie de l'article
	 * @param string $price Le prix de l'article
	 * @param string $duration La durée de l'article
	 * @param float Le prix de l'article
	 */
	public function createItem($id, $name, $image_url, $method, $args, $category = "Non classé", $price, $duration) {
		$success = DataBase::insert($this->_table, array(
			"fields" => array(
				"id" => $id,
				"name" => $name,
				"name_raw" => TextUtils::generateRawText($name),
				"image_url" => $image_url,
				"method" => $method,
				"args" => is_array($args) ? json_encode($args) : $args,
				"category" => $category,
				"price" => $price,
				"duration" => $duration,
			),
		));

		return $success;
	}

	/**
	 * Supprime un article dans la base de données
	 * @param int $id L'id de l'article
	 */
	public function deleteItem($id) {
		$success = DataBase::delete($this->_table, array(
			"conditions" => array(
				"id" => $id,
			),
		));

		return $success;
	}

	/**
	 * Edite un article dans la base de données
	 * @param int $id L'id de l'article
	 * @param string $name Le nom de l'article
	 * @param string $image_url L'url de l'image
	 * @param string $description La description de l'article
	 * @param string $category La catégorie de l'article
	 * @param float Le prix de l'article
	 */
	public function editItem($id, $name, $image_url, $method, $args, $category = "Non classé", $price, $duration) {
		if($price < 0)
			$price = 0;

		$success = DataBase::edit($this->_table, array(
			"fields" => array(
				"name" => $name,
				"name_raw" => TextUtils::generateRawText($name),
				"image_url" => $image_url,
				"method" => $method,
				"args" => is_array($args) ? json_encode($args) : $args,
				"category" => $category,
				"price" => $price,
				"duration" => $duration,
			),
			"conditions" => array(
				"id" => $id,
			),
		));

		return $success;
	}
}
