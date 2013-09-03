<?php
/**
 * Classe de base de tous les bundles. Permet de consulter la liste des bundles chargés.
 * @package fr.solicium.core
 * @author Solicium Team
 * @version 2.0
 * @since 1.0
 */
class Core {
    /** Un array de la liste des bundles chargés */
    protected static $bundlesLoadedList = array();
	/** Le nom de la table du bundle */
	protected $_table;
	/** Le nom de la dernière table */
	private $_old_table;

	/** Le constructeur principal de tous les bundles */
    protected function __construct() {
        self::$bundlesLoadedList[] = get_class($this);
    }

    /**
     * @return La liste des bundles chargés
     */
    public static function getBundlesLoadedList() {
        return self::$bundlesLoadedList;
    }

    /**
     * Affiche une erreur si la table du bundle n'existe pas
     */
    protected function errorTableDontExist($table) {
    	die("[ERREUR] Bundle " . get_class($this) . " : La table $table n'existe pas.");
    }

	/**
	 * Défini la table du bundle
	 * @param String $table Le nom de la nouvelle table
	 */
	public function setTable($table) {
		if(isset($this->_table))
			$this->_old_table = $this->_table;

		$this->_table = $table;
	}

	/**
	 * Annule le changement de table
	 */
	public function undoSetTable() {
		if(isset($this->_old_table)) {
			$this->_table = $this->_old_table;
			unset($this->_old_table);
		}
	}
}
