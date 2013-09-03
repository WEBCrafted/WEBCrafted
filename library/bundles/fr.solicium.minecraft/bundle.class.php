<?php
class Minecraft extends Users {
	/**
	 * L'instance de classe JSONAPI
	 * @var JSONAPI
	 */
	protected $jsonapi;

	/**
	 * Le constructeur du bundle Minecraft
	 * @param string $table La table des utilisateurs
	 */
	public function __construct($table = "users") {
		parent::__construct($table);

		if(Configure::read("jsonapi_use")) {
			require(VENDORS . "jsonapi.php");
			$this->jsonapi = new JSONAPI(Configure::read("server_ip"), Configure::read("jsonapi_port"), Configure::read("jsonapi_username"), Configure::read("jsonapi_password"), Configure::read("jsonapi_salt"));
		}
	}

	/**
	 * Génère un numéro de session unique
	 * @param string $username Le nom d'utilisateur
	 * @param string $password Le mot de passe
	 * @return string Un numéro de session unique
	 */
	private function generateSession($username, $password) {
		return sha1(md5($username . Configure::read("users_secret_key") . $password . time() . rand()));
	}

	/**
	 * Vérifie si la session d'un utilisateur est active.
	 * @param string $username Le nom d'utilisateur
	 * @param string $session la session  à vérifier
	 * @return bool true si la session existe, est associée à l'utilisateur et est active
	 */
	public function verifySession($username, $session) {
		$data = DataBase::read($this->_table, array(
			"conditions" => array(
				"username" => $username,
				"session" => $session,
				"isActive" => 1
			)
		));

		return isset($data) ? !empty($data) : false;
	}

	/**
	 * Fais une requête à un serveur Minecraft
	 * @return mixed[] Les informations du serveur 
	 */
	public function serverQuery() {
		$statut = @fsockopen(Configure::read("server_ip"), Configure::read("server_port"), $errno, $errstr, 1);
		$query = array();

		if($statut) {
			fwrite($statut, "\xFE\x01");	 
			$data = fread($statut, 1024);
			if ($data != false AND substr($data, 0, 1) == "\xFF") {
				$data = substr($data, 3);
				$data = mb_convert_encoding($data, "auto", "UCS-2");
				$data = explode("\x00", $data);
				fclose($statut);
				$data = str_replace("§b", "", str_replace("§e", "", $data));

				$query = array(
					"protocol" => $data[1],
					"version" => $data[2],
					"motd" => $data[3],
					"onlineplayers" => $data[4],
					"slots" => $data[5],
					"ip" => Configure::read("server_ip") . ":" . Configure::read("server_port"),
					"state" => "online"
				);
			}
			return $query;
		}
		return false;
	}

	/**
	 * Retourne l'objet JSONAPI pour les requêtes spéciales
	 * @return JSONAPI
	 */
	public function getJSONAPIObject() {
		return $this->jsonapi;
	}

	/** 
	 * Récupère les informations tels que les joueurs connectés, la version du serveur...
	 * @return mixed[] Un tableau content les informations du serveur
	 */
	public function getServer() {
		$serverdata = $this->call("getServer");
		return $serverdata;
	}

	/**
	 * Récupère les principales informations sur la dynmap
	 * @return mixed[] Le port et l'ip de la dynmap
	 */
	public function getDynmap() {
		$host = $this->call("dynmap.getHost");

		if(!$host) {
			return false;
		}
		else {
			$port = $this->call("dynmap.getPort");
			return array("host" => $host, "port" => $port);
		}
	}

	/**
	 * Récupère les joueurs connectés sur le serveur
	 * @return mixed[] Un tableau content les dernières logs
	 */
	public function getOnlinePlayers() {
		$serverdata = $this->call("getPlayers");
		return $serverdata;
	}

	/**
	 * Récupère les dernières lignes du fichier logs
	 * @param int $lines Le nombre de lignes à récupèrer
	 * @return mixed[] Un tableau content les dernières logs
	 */
	public function getLatestConsoleLogs($lines = 100) {
		$serverdata = $this->call("getLatestConsoleLogsWithLimit", array(
			$lines,
		));

		return $serverdata;
	}

	/**
	 * Renvoi la liste des opérateurs du serveur
	 * @return mixed[] Un tableau contenant les opérateurs
	 */
	public function getOpList() {
		$serverdata = $this->call("getOpList");
		return $serverdata;
	}

	/**
	 * Renvoi la liste des IPs bannis
	 * @return mixed[] Un tableau des contenant les IPs bannis
	 */
	public function getBannedIPs() {
		$serverdata = $this->call("getBannedIPs");
		return $serverdata;
	}

	/**
	 * Renvoi la liste des joueurs bannis
	 * @return mixed[] Un tableau des contenant les joueurs bannis
	 */
	public function getBannedPlayers() {
		$serverdata = $this->call("getBannedPlayers");
		return $serverdata;
	}

	/**
	 * Donne un item à un joueur
	 * @param string $pname Le nom du joueur
	 * @param int $id L'id de l'item
	 * @param int $quantity La quantité
	 * @return bool true si succès
	 */
	public function givePlayerItem($pname, $id, $quantity) {
		$success = $this->givePlayerItemWithData($pname, $id, $quantity, 0);
		return $success;
	}

	/**
	 * Donne un item avec des metadatas à un joueur
	 * @param string $pname Le nom du joueur
	 * @param int $id L'id de l'item
	 * @param int $quantity La quantité
	 * @param int $data Le metadata de l'item
	 * @return bool true si succès
	 */
	public function givePlayerItemWithData($pname, $id, $quantity, $data = 0) {
		$success = $this->call("givePlayerItemWithData", array(
			$pname,
			$id,
			$quantity,
			$data,
		));

		return $success;
	}

	/**
	 * Met le joueur dans un groupe
	 * @param string $user Le pseudo du joueur
	 * @param string $group Le nom du groupe
	 * @param int $timed Combien de temps en secondes le grade lui est attribué
	 * @return bool true si succès
	 */
	public function addPlayerToGroup($user, $group, $timed = 0) {
		if($timed > 0)
			$success = $this->runConsoleCommand("pex user $user group add $group $timed");
		else
			$success = $this->runConsoleCommand("pex user $user group add $group");

		return $success;
	}

	/**
	 * Relance le serveur
	 * @return bool true si succès
	 */
	public function restartServer() {
		return $this->call("remotetoolkit.restartServer");
	}

	/**
	 * Recharge le serveur
	 * @return bool true si succès
	 */
	public function reloadServer() {
		return $this->call("reloadServer");
	}

	/**
	 * Démarre le serveur
	 * @return bool true si succès
	 */
	public function startServer() {
		return $this->call("remotetoolkit.startServer");
	}

	/**
	 * Stoppe le serveur
	 * @return bool true si succès
	 */
	public function stopServer() {
		return $this->call("remotetoolkit.stopServer");
	}

	/**
	 * Ajoute une permission à un joueur
	 * @param string $user Le pseudo du joueur
	 * @param string $permission La permission à donner
	 * @param int $timed Le temps en secondes que la permission restera
	 * @return bool true si succès
	 */
	public function addPermission($user, $permission, $timed = 0) {
		if($timed > 0)
			$success = $this->runConsoleCommand("pex user $user timed add $permission $timed");
		else
			$success = $this->runConsoleCommand("pex user $user add $permission");

		return $success;
	}

	/**
	 * Envoie un message en broadcast sur le serveur
	 * @param $message Le message
	 * @return bool true si succès
	 */
	public function broadcast($message) {
		$success = $this->call("broadcast", array(
			$message
		));

		return $success;
	}

	/**
	 * Exécute une commande en tant que console
	 * @param string $command La commande à exécuter
	 * @return bool true si succès
	 */
	public function runConsoleCommand($command) {
		$success = $this->call("runConsoleCommand", array(
			$command,
		));

		return $success;
	}

	/**
	 * Appele une méthode JSONAPI
	 * @param string $method La fonction à appeler
	 * @param mixed[] $args Les arguments de la fonction
	 * @param bool $current true si renvoyer l'index success
	 * @return mixed[] Le résultat
	 */
	public function call($method, $args = array(), $current = true) {
		if(!$this->jsonapi)
			return false;

		$data = $this->jsonapi->call($method, $args);

		if(isset($data["result"]) AND $data["result"] == "success")
			if(is_array($data["success"]))
				return $data["success"];
			else
				return true;

		return false;
	}
}
?>