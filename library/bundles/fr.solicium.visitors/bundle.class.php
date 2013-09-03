<?php
class Visitors extends Core {
	/**
	 * Le constructeur du bundle Visitors
	 */
	public function __construct($table = "stats_visitors") {
		parent::__construct();

		if(DataBase::tableExists(PREFIX . $table))
			$this->_table = PREFIX . $table;
		else
			$this->errorTableDontExist(PREFIX . $table);
	}

	/**
	 * Permet de comptabiliser le nombre de visiteurs uniques
	 */
	public function addVisitor() {
		if(!DataBase::read($this->_table, array("fields" => array("ip"), "conditions" => array("ip" => $_SERVER['REMOTE_ADDR'])))) {
			DataBase::insert($this->_table, array(
				"fields" => array(
					"ip" => $_SERVER['REMOTE_ADDR'],
					"first_visit" => "NOW()"
				),
			));
		}
	}

	/**
	 * Retourne le nombre de visteurs
	 */
	public function getTotalVistors() {
		return DataBase::count($this->_table);
	}
}
