<?php
/**
 * Classe de la base de données. Toutes les fonctions sont en static, car elles sont appelées à de nombreux endroits.
 * @package fr.solicium.database
 * @author Solicium Team
 * @version 2.0
 * @since 1.0
 */
class DataBase extends Core {
	/**
	 * L'objet PDO qui sert de base à toute la classe
	 * @var PDO
	 * @static
	 */
	private static $db;

	/**
	 * Tableau contenant les tables
	 * @var array
	 * @static
	 */
	private static $_tables = array();

	/**
	 * Initialise la base de données. Cette fonction DOIT ÊTRE appelée avant toute interaction avec la base de données
	 * @static
	 */
	public static function init() {
		global $_config;

		try {
			self::$db = new PDO("mysql:dbname={$_config["database_name"]};host={$_config["database_host"]}", $_config["database_user"], $_config["database_password"],
			array(
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
				//PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_PERSISTENT => true,
			));
		}
		catch(PDOException $e) {
			//die("[ERREUR] Connexion échouée : " . $e->getMessage());
		}
	}

	/**
	 * Retourne l'objet PDO pour les requêtes spéciales
	 * @see fr.solicium.stats.bundle.class.php
	 * @static
	 */
	public static function getObject() {
		return self::$db;
	}

	/**
	 * Lit tous les champs dans la base de données
	 * @param string $table Le nom de la table à utiliser
	 * @param mixed[] $options Un tableau des options à utiliser pour la requête
	 * @return mixed[] Un tableau associatif de chaque champ
	 * @static
	 */
	public static function read($table, $options = null) {
		if(isset($options["relations"]) AND $options["relations"]) {
			$relations = array();

			foreach($options["relations"] as $k => $v) {
				if (isset($v[0]))
					foreach($v as $k2 => $v2)
						$relations = array_merge($relations, array(
							$v2["fk"] => "SELECT * FROM `$k` WHERE `{$v2["pk"]}` = ?"
						));
				else
					$relations = array_merge($relations, array(
						$v["fk"] => "SELECT * FROM `$k` WHERE `{$v["pk"]}` = ?"
					));
			}
		}
		$fields = "*";

		if(isset($options["fields"]) AND $options["fields"]) {
			$fields = "";

		    foreach ($options["fields"] as $k => $v)
		        $fields .= "$v, ";

		    $fields = substr($fields, 0, -2);
		}

		$values = array();
		$conditions = "";

		if(isset($options["conditions"]) AND $options["conditions"]) {
			$conditions = "WHERE 1=1 AND ";
			$i = 0;

			foreach($options["conditions"] as $k => $v) {
		        $conditions .= "`$k`=? AND ";
		        $values[$i] = $v;
		        $i++;
		    }

			$conditions = substr($conditions, 0, -5);
		}
		$order = "";

		if(isset($options["order"]) AND $options["order"])
		    $order = "ORDER BY `$table`.`" . (isset($options["order"]["column"]) ? $options["order"]["column"] : "id") . "` " . (isset($options["order"]["method"]) ? $options["order"]["method"] : "DESC");

		$limit = "";

		if(isset($options["limit"]) AND $options["limit"])
		    $limit = "LIMIT " . (isset($options["offset"]) ? $options["offset"] : 0) . ", {$options["limit"]}";

		if(self::$db == null)
			return false;

		$request = self::$db->prepare("SELECT $fields FROM `$table` $conditions $order $limit");
		$request->execute($values);

		if(empty($request)) {
			return false;
		}
		else {
			$data = $request->fetchAll(PDO::FETCH_ASSOC);

			if(isset($relations)) {
				foreach($data as $k => $v) {
					foreach($relations as $k2 => $v2) {
						if(isset($v[$k2])) {
							$sql = self::$db->prepare($v2);
							$sql->execute(array($v[$k2]));
							$data[$k][$k2] = current($sql->fetchAll(PDO::FETCH_ASSOC));
						}
					}
				}
			}

			if(count($data) == 1)
				$data = current($data);

			$request->closeCursor();
			return $data;
		}
	}

	/**
	 * Insère une ligne dans une table de la base de données
	 * @param string $table Le nom de la table à utiliser
	 * @param mixed[] $options Un tableau des options à utiliser pour la requête
	 * @return boolean true si l'insertion a réussie
	 * @static
	 */
	public static function insert($table, $options) {
		$values = "";
		$columns = "";

		if(isset($options["fields"])) {
			foreach($options["fields"] as $k => $v) {
				if($v === "") {
					unset($options["fields"][$k]);
					continue;
				}

				$columns .= $k . ',';

				if($v === "NOW()") {
					unset($options["fields"][$k]);
					$values .= "NOW(),";
				}
				else
					$values .= ":" . $k . ",";
			}

			$columns = substr($columns, 0, -1);
			$values = substr($values, 0, -1);

			if(self::$db == null)
				return false;

			$request = self::$db->prepare("INSERT INTO $table ($columns) VALUES ($values)");
			return $request->execute($options["fields"]);
		}
		else {
			die('Bundle DataBase : $options["fields"] n\'est pas défini.');
			return false;
		}
	}

	/**
	 * Édite un champ dans la base de données
	 * @param string $table Le nom de la table à utiliser
	 * @param mixed[] $options Un tableau des options à utiliser pour la requête
	 * @return boolean true si l'édition a réussie
	 * @static
	 */
	public static function edit($table, $options) {
		$sql = "";

		if(isset($options["fields"])) {
			$values = array();

			foreach($options["fields"] as $k => $v) {
				if($v === "NOW()") {
					unset($options["fields"][$k]);
					$sql .= $k . " = NOW(), ";
				}
				else {
					$sql .= "$k = :$k, ";
					$values[$k] = $v;
				}
			}

			$sql = substr($sql, 0, -2);
			$sql .= " ";
			$conditions = "";

			if(isset($options["conditions"])) {
				$conditions = "WHERE 1=1 AND ";

				foreach ($options["conditions"] as $k => $v) {
			        $conditions .= "$k=:$k AND ";
			        $values[$k] = $v;
			    }

			    $conditions = substr($conditions, 0, -5);
			}
			$request = self::$db->prepare("UPDATE $table SET $sql $conditions");
			return $request->execute($values);
		}
		else {
			die('Bundle DataBase : $options["fields"] n\'est pas défini.');
			return false;
		}
	}

	/**
	 * Supprime une entrée de la base de données
	 * @param string $table Le nom de la table à utiliser
	 * @param mixed[] $options Un tableau des options à utiliser pour la requête
	 * @return boolean true si la suppression a réussie
	 * @static
	 */
	public static function delete($table, $options) {
		if(isset($options["conditions"])) {
			$values = array();
			$conditions = "";

			if(isset($options["conditions"])) {
				$conditions = "WHERE 1=1 AND ";

				foreach ($options["conditions"] as $k => $v) {
			        $conditions .= "$k=:$k AND ";
			        $values[$k] = $v;
			    }

			    $conditions = substr($conditions, 0, -5);
			}

			$request = self::$db->prepare("DELETE FROM $table $conditions");
			return $request->execute($values);
		}
		else {
			die('Bundle DataBase : $options["conditions"] n\'est pas défini.');
			return false;
		}
	}

	/**
	 * Retourne le nombre d'entrées d'une table
	 * @param string $table Le nom de la table à étudier
	 * @param mixed[] $options Un tableau des options à utiliser pour la requête
	 * @return int Le nombre d'entrées
	 * @static
	 */
	public static function count($table) {
		$options = array(
			"fields" => array("COUNT(*)"),
		);
		$result = self::read($table, $options);

		return $result["COUNT(*)"];
	}

	/**
	 * Retourne le nombre de lignes correspondant à la condition de date, antérieures à l'offset.
	 * @param string $table Le nom de la table à étudier
	 * @param string $field Le nom du champ à comparer
	 * @param int $offset L'offset de la date (positif ou négatif)
	 * @static
	 */
	public static function countSince($table, $field, $offset = 0) {
		$request = self::$db->prepare("SELECT COUNT(*) FROM :table WHERE :field <= DATE_ADD(CURDATE(), INTERVAL :offset DAY)");
		$data = $request->execute(array(
			"table" => $table,
			"field" => $field,
			"offset" => $offset,
		));

		return $request->fetchColumn();
	}

	/**
	 * Vérifie si une table existe dans la base de données
	 * @param string $tableName Le nom de la table à tester
	 * @return boolean true si la table existe
	 * @static
	 */
	public static function tableExists($tableName) {
		if(self::$db == null)
			return true;

		elseif(empty(self::$_tables)) {
			global $_config;

			$request = self::$db->query("SHOW TABLES");
			$data = $request->fetchAll(PDO::FETCH_ASSOC);

			foreach ($data as $v)
				self::$_tables[] = current($v);
		}

		return in_array($tableName, self::$_tables);
	}
}
