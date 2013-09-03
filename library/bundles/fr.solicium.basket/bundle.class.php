<?php
/**
 * Classe du panier. Contient toutes les fonctions pour la gestion d'un panier en PHP.
 * @package fr.solicium.basket
 * @author Solicium Team
 * @version 1.0
 * @since 1.0
 */
class Basket extends Core {
	/**
	 * Le constructeur du bundle Basket
	 * @param string $table La table à utiliser pour le panier, en l'occurence celle des produits
	 */
	public function __construct($table = "shop_items") {
		parent::__construct();

		if(DataBase::tableExists(PREFIX . $table))
			$this->_table = PREFIX . $table;
		else
			$this->errorTableDontExist(PREFIX . $table);
	}

	/**
	 * Ajoute un produit au panier
	 * @param mixed $id L'id du produit
	 * @return boolean Le résultat de l'opération
	 */
	public function addProduct($id) {
		// On va chercher le produit dans la base de données
		$product = DataBase::read($this->_table, array(
			"conditions" => array(
				"id" => $id,
			),
		));

		if(empty($product))
			return false;
		else
			$_SESSION["basket"][$id] = $product;

		return true;
	}

	/**
	 * Supprime un produit du panier
	 * @param mixed $id L'id du produit
	 * @return boolean Le résultat de l'opération
	 */
	public function deleteProduct($id) {
		if(!in_array($id, array_keys($_SESSION["basket"])))
			return false;
		else
			unset($_SESSION["basket"][$id]);

		return true;
	}

	/**
	 * Vide le panier
	 */
	public function clearItems() {
		unset($_SESSION["basket"]);
	}

	/**
	 * Récupère les articles dans le panier
	 * @return mixed[] Les articles
	 */
	public function getItems() {
		return isset($_SESSION["basket"]) ? $_SESSION["basket"] : array();
	}

	/**
	 * Récupère le montant total du panier
	 * @return float Le montant total du panier
	 */
	public function getTotalPrice() {
		$total = 0;

		if(isset($_SESSION["basket"]))
			foreach($_SESSION["basket"] as $k => $v)
				$total += $v["price"];

		return $total;
	}
}
