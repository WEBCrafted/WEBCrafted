<?php
class Users extends Core {
	/**
	 * Le constructeur du bundle Users
	 * @param string $table La table des utilisateurs
	 */
	public function __construct($table = "users") {
		parent::__construct();

		if(DataBase::tableExists(PREFIX . $table))
			$this->_table = PREFIX . $table;
		else
			$this->errorTableDontExist(PREFIX . $table);
	}

	/**
	 * Vérifie ou génére un jeton de sécurité
	 */
	public function verifyToken() {
		global $params;

		if(!isset($_SESSION["token"]))
			$_SESSION["token"] = md5(time() . rand(152, 864));

		if((isset($_POST["token"]) AND $_POST["token"] == $_SESSION["token"]) OR (isset($params["token"]) AND $params["token"] == $_SESSION["token"])) {
			unset($_SESSION["token"]);
			return true;
		}

		return !isset($_POST["token"]) AND !isset($params["token"]);
	}

	/**
	 * Récupère les informations d'un utilisateur
	 * @param mixed $id L'id de l'utilisateur
	 */
	public function getUser($id) {
		$userdata = DataBase::read($this->_table, array(
			"relations" => array(
				PREFIX . "groups" => array(
					"pk" => "id",
					"fk" => "group_id",
				),
			),
			"conditions" => array(
				"id" => $id,
			),
			"limit" => 1,
		));

		return $userdata;
	}

	/**
	 * Récupère des utilisateurs
	 * @param int $limit Le nombre d'utilisateurs à charger
	 * @param int $page La page actuelle
	 * @return mixed[] Un tableau contenant les utilisateurs
	 */
	public function getUsers($limit = false, $page = 1) {
		$success = DataBase::read($this->_table, array(
			"relations" => array(
				PREFIX . "groups" => array(
					"pk" => "id",
					"fk" => "group_id",
				),
			),
			"order" => array(
				"column" => "id",
			),
			"limit" => $limit,
			"offset" => $limit * ($page - 1),
		));

		if(isset($success["id"]))
			$success = array($success);

		return $success;
	}

	/**
	 * Récupère le nombre total d'utilisateurs
	 * @return int Le nombre total d'utilisateurs
	 */
	public function countAll() {
		return DataBase::count($this->_table);
	}

	/**
	 * Edite un utilisateur dans la base de données
	 * @param int $id L'id de l'utilisateur
	 * @param string $username Le nom d'utilisateur
	 * @param string $password Le mot de passe
	 * @param int $money Les tokens de l'utilisateur
	 * @param string $email L'email du compte
	 * @param bool $group_id L'id du groupe de permissions de l'utilisateur
	 * @return boolean true si l'édition a réussie
	 */
	public function editUser($id, $username, $money, $email, $group_id) {
		$success = DataBase::edit($this->_table, array(
			"fields" => array(
				"username" => $username,
				"money" => $money,
				"email" => $email,
				"group_id" => $group_id,
			),
			"conditions" => array(
				"id" => $id,
			),
		));

		return $success;
	}

	/**
	 * Supprime un utilisateur de la base données
	 * @param int $id L'id de l'utilisateur à supprimer
	 * @return boolean true si la suppression a réussie
	 */
	public function deleteUser($id) {
		$success = DataBase::delete($this->_table, array(
			"conditions" => array(
				"id" => $id,
			),
		));

		return $success;
	}

	/**
	 * Récupère un champ dans la ligne d'un utilisateur dans la base de données
	 * @param string $username Le nom de l'utilisateur
	 * @param string $field Le champ à récupérer dans la base de données
	 * @return mixed La valeur du champ
	 */
	public function getField($username, $field) {
		$userdata = DataBase::read($this->_table, array(
			"conditions" => array(
				"username" => $username,
			),
			"fields" => array(
				$field,
			),
			"limit" => 1,
		));

        return $userdata[$field];
	}

	/**
	 * Défini un champ dans la ligne d'un utilisateur dans la base de données
	 * @param string $username Le nom de l'utilisateur
	 * @param string $field Le champ à récupérer dans la base de données
	 */
	public function setField($username, $field, $value) {
		$success = DataBase::edit($this->_table, array(
			"fields" => array(
				$field => $value,
			),
			"conditions" => array(
				"username" => $username,
			),
		));

		return $success;
	}

	/**
	 * Connecte un utilisateur
	 * @param string $table La table des utilisateurs
	 * @param string $username Le nom d'utilsateur
	 * @param string $password Le mot de passe hashé
	 * @return boolean Le résultat de l'opération
	 */
	public function login($username, $password) {
		$userdata = DataBase::read($this->_table, array(
			"relations" => array(
				PREFIX . "groups" => array(
					"pk" => "id",
					"fk" => "group_id",
				),
			),
			"conditions" => array(
				"username" => $username,
				"password" => $password,
			),
			"limit" => 1,
		));

		if(!$userdata) {
			$_SESSION["isLogged"] = false;
		}
		else {
			$userdata["group_id"]["permissions"] = json_decode(TextUtils::fixJson($userdata["group_id"]["permissions"]), true);
			$_SESSION = array_merge((array)$_SESSION, (array)$userdata);
			$_SESSION["isLogged"] = true;
			$this->setField($username, "last_login_date", "NOW()");
		}

		return !empty($userdata);
	}

	/**
	 * Déconnecte l'utilisateur courant
	 */
	public function logout() {
		if (isset($_SESSION["isLogged"]))
			session_destroy();
	}

	/**
	 * Ajoute un utilisateur dans la base de données
	 * @param int $id L'id de l'utilisateur
	 * @param string $username Le nom d'utilisateur
	 * @param string $password Le mot de passe
	 * @param int $money Les tokens de l'utilisateur
	 * @param string $email L'email du compte
	 * @param bool $group_id L'id du groupe de permissions de l'utilisateur
	 * @return bool Le résultat de l'opération
	 */
	public function signup($id, $username, $password, $email, $group_id) {
		$success = DataBase::insert($this->_table, array(
			"fields" => array(
				"id" => $id,
				"username" => $username,
				"password" => $this->hashPassword($password),
				"email" => $email,
				"money" => 0,
				"signup_date" => "NOW()",
				"group_id" => $group_id,
			)
		));

		return $success;
	}

	/**
	 * Change le mot de passe de l'utilisateur
	 * @param string $username Le nom de l'utilisateur à qui on veut changer le mot de passe
	 * @param string $new Le nouveau mot de passe hashé
	 * @return boolean Le résultat de l'opération
	 */
	public function changePassword($username, $new) {
		$userdata = DataBase::read($this->_table, array(
			"fields" => array(
				"password",
			),
			"conditions" => array(
				"username" => $username,
			),
		));

		if($userdata) {
			$success = DataBase::edit($this->_table, array(
				"fields" => array(
					"password" => $this->hashPassword($new),
				),
				"conditions" => array(
					"username" => $username,
				),
			));

			return $success;
		}
		return false;
	}

	/**
	 * Change le mail de l'utilisateur
	 * @param string $username Le nom de l'utilisateur à qui on veut changer le mail
	 * @param string $password Le mot de passe de l'utilisateur
	 * @param string $new Le nouveau mail
	 * @return boolean Le résultat de l'opération
	 */
	public function changeMail($username, $password, $new) {
		$userdata = DataBase::read($this->_table, array(
			"fields" => array(
				"password"
			),
			"conditions" => array(
				"username" => $username,
				"password" => $this->hashPassword($password),
			),
		));

		if($userdata) {
			$success = DataBase::edit($this->_table, array(
				"fields" => array(
					"mail" => $new,
				),
				"conditions" => array(
					"username" => $username,
				),
			));

			return $success;
		}
		return false;
	}

	/**
	 * Ajoute de l'argent à l'utilisateur
	 * @param string $money Le nombre d'argent à donner
	 * @return boolean Le résultat de l'opération
	 */
	public function addMoney($money) {
		$success = DataBase::edit($this->_table, array(
			"fields" => array(
				"money" => $_SESSION["money"] + $money,
			),
			"conditions" => array(
				"username" => $_SESSION["username"],
			),
		));

		return $success;
	}

	/**
	 * Hashe le mot de passe
	 * @param string $password Le mot de passe à hasher
	 * @return string Le mot de passe hashé
	 */
	public function hashPassword($password) {
		global $_config;
		return sha1(md5($password) . Configure::read("users_secret_key"));
	}

    /**
     * Vérifie si l'utilisateur spécifié existe déjà
     * @param string $username
     * @return boolean true si l'utilisateur existe déjà
     */
    public function userExists($username) {
		$userdata = DataBase::read($this->_table, array(
			"conditions" => array(
				"username" => $username,
			),
			"limit" => 1,
		));

        return !empty($userdata);
	}

	/**
     * Vérifie si l'utilisateur est connecté
     * @param string $username
     * @return boolean true si l'utilisateur est connecté
     */
    public function isLogged() {
    	return isset($_SESSION["isLogged"]) AND $_SESSION["isLogged"];
	}

	/**
     * Vérifie si l'utilisateur a la permission
     * @param string $permission La permission
     * @return boolean true si l'utilisateur a la permission
     */
    public function hasPermission($permission) {
    	return isset($_SESSION["group_id"]["permissions"]) AND in_array($permission, $_SESSION["group_id"]["permissions"]);
	}
}
