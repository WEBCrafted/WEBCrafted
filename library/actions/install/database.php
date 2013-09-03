<?php
if(!isset($_SESSION["install"]["requirements"]) OR !$_SESSION["install"]["requirements"]) {
	redirect("install/requirements", false);
}

if(
	!isset(
		$_POST["host"],
		$_POST["name"],
		$_POST["user"],
		$_POST["password"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	try {
		$db = new PDO("mysql:host={$_POST["host"]};dbname={$_POST["name"]};", $_POST["user"], $_POST["password"]);
		$request = $db->query("SHOW TABLES");
		$tmp = $request->fetchAll(PDO::FETCH_ASSOC);
		$tables = array();

		foreach($tmp as $table)
			$tables[] = current($table);

		if(!in_array("wc_stats_visitors", $tables) AND !in_array("stats_visitors", $tables)) {
			$db->exec(str_replace("{database.name}", $_POST["name"], file_get_contents(ROOT . "config/database.sql")));
		}
		else if(in_array("stats_visitors", $tables) OR in_array("wc_stats_visitors", $tables)) {
			if(!in_array("wc_stats_visitors", $tables))
				$db->exec(str_replace("{database.name}", $_POST["name"], file_get_contents(ROOT . "config/updates/0-7-3.sql")));

			$request = $db->query("SELECT * FROM `{$_POST["name"]}`.`" . PREFIX . "users`");
			$users = $request->fetchAll(PDO::FETCH_ASSOC);

			if(isset($users[0]["admin"]) AND !isset($users[0]["group_id"])) {
				$db->exec(str_replace("{database.name}", $_POST["name"], file_get_contents(ROOT . "config/updates/0-7-5.sql")));

				foreach($users as $v) {
					$request = $db->prepare("UPDATE `{$_POST["name"]}`.`" . PREFIX . "users` SET `group_id`=? WHERE `username`=?");
					$request->execute(array(
						$v["admin"] ? 1 : 2,
						$v["username"],
					));
				}
			}

			$request = $db->query("SELECT * FROM `{$_POST["name"]}`.`" . PREFIX . "options`");
			$options = $request->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);

			if(version_compare($options["version"][0], "0-7-6", "<")) {
				$request = $db->query("SELECT id FROM `{$_POST["name"]}`.`" . PREFIX . "users` WHERE group_id=1 ORDER BY id ASC LIMIT 1");
				$uid = $request->fetch(PDO::FETCH_ASSOC);

				if(!$uid)
					die("Compte administrateur introuvable, migration impossile");
				else
					$uid = current($uid);

				if(version_compare($options["version"][0], "0-7-4", "<")) {
					$request = $db->query("SELECT id FROM `{$_POST["name"]}`.`" . PREFIX . "widgets` ORDER BY id DESC LIMIT 1");
					$id = $request->fetch(PDO::FETCH_ASSOC);

					if(!$id)
						$id = 1;
					else
						$id = current($id) + 1;

					$request = $db->prepare("INSERT INTO `{$_POST["name"]}`.`" . PREFIX . "widgets` (`id`, `title`, `content`, `creator_id`, `last_editor_id`, `date_created`, `date_last_edited`) VALUES (:id, :title, :content, :creator_id, :last_editor_id, NOW(), NOW())");
					$request->execute(array(
						"id" => $id,
						"title" => "Etat du serveur",
						"content" => '<h2>{serverdata.state}</h2><h3>{serverdata.players}/{serverdata.maxPlayers} joueurs</h3><h3><span class="gray">IP : {serverdata.ip}:{serverdata.port}</span></h3>',
						"creator_id" => $uid,
						"last_editor_id" => $uid,
					));
				}

				if(version_compare($options["version"][0], "0-7-6", "<")) {
					$request = $db->query("SELECT id FROM `{$_POST["name"]}`.`" . PREFIX . "widgets` ORDER BY id DESC LIMIT 1");
					$id = $request->fetch(PDO::FETCH_ASSOC);

					if(empty($id))
						$id = 1;
					else
						$id = current($id) + 1;

					$request = $db->prepare("INSERT INTO `{$_POST["name"]}`.`" . PREFIX . "widgets` (`id`, `title`, `content`, `creator_id`, `last_editor_id`, `date_created`, `date_last_edited`) VALUES (:id, :title, :content, :creator_id, :last_editor_id, NOW(), NOW())");
					$request->execute(array(
						"id" => $id,
						"title" => "Socialhub",
						"content" => '<a href="{options.facebook}"><img src="' . WEBROOT . 'templates/' . $options["theme"][0] . '/assets/images/facebook.png" alt="facebook" /></a><a href="{options.youtube}"><img src="' . WEBROOT . 'templates/' . $options["theme"][0] . '/assets/images/youtube.png" alt="youtube" /></a><a href="https://twitter.com/{options.twitter}"><img src="' . WEBROOT . 'templates/' . $options["theme"][0] . '/assets/images/twitter.png" alt="twitter" /></a>',
						"creator_id" => $uid,
						"last_editor_id" => $uid,
					));
				}

				if(version_compare($options["version"][0], "0-7-7", "<"))
					$db->exec(str_replace("{database.name}", $_POST["name"], file_get_contents(ROOT . "config/updates/0-7-7.sql")));

				$db->exec(str_replace("{database.name}", $_POST["name"], file_get_contents(ROOT . "config/updates/0-7-6.sql")));
			}

			$db->exec("UPDATE `{$_POST["name"]}`.`" . PREFIX . "options` SET `value` = '0-7-6' WHERE `entry` = 'version'");
		}
		else
			die("Migration impossible.");

		$handle = fopen(ROOT . "config/database.php", "r+b");
		flock($handle, LOCK_EX);
		$content = "";

		while(!feof($handle)) {
			$buffer = fgets($handle);
			$content .= $buffer;
		}

		$content = str_replace(array("127.0.0.1", "{database.name}", "{database.user}", "{database.password}"), array($_POST["host"], $_POST["name"], $_POST["user"], $_POST["password"]), $content);
		ftruncate($handle, 0);
		fseek($handle, 0);
		fputs($handle, $content);
		fflush($handle);
		flock($handle, LOCK_UN);
		fclose($handle);

		if(!in_array("wc_stats_visitors", $tables) AND !in_array("stats_visitors", $tables)) {
			$_SESSION["install"]["database"] = true;
			redirect("install/options", false);
		}
		else if(in_array("stats_visitors", $tables) OR in_array("wc_stats_visitors", $tables)) {
			unset($_SESSION["install"]);
			setFlash("Mise à jour effectué avec succès", "success");
			redirect("login", false);
		}
	}
	catch(PDOException $ex) {
		setFlash("Impossible de se connecter à la base de données", "error");
	}
	catch(FileException $ex) {
		setFlash("Impossible d'écrire le fichier database.php", "error");
	}
}

redirect("install/database", false);
