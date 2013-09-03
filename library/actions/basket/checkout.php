<?php
if(!$_users->isLogged()) {
	setFlash("Vous devez être connecté", "error");
	redirect("login");
}
elseif
	(!isset(
		$params["token"]
	)) {
	setFlash("Un paramètre est manquant !", "error");
}
else {
	$basket = $_basket->getItems();

	if(empty($basket)) {
		setFlash("Votre panier est vide", "error");
	}
	else {
		if(!isset($_SESSION["money"]) OR $_SESSION["money"] < $_basket->getTotalPrice()) {
			setFlash("Vous n'avez pas assez d'émeraudes", "error");
		}
		else {
			$_minecraft = loadBundle("fr.solicium.minecraft");
			$players = $_minecraft->getOnlinePlayers();
			$find = false;

			foreach($players as $v) {
				if($v["name"] == $_SESSION["username"]) {
					$find = true;
					break;
				}
			}

			if(!$find) {
				setFlash("Vous devez être connecté sur le serveur !", "error");
			}
			else {
				$_shop = loadBundle("fr.solicium.shop");

				foreach($basket as $k => $v) {
					$item = $_shop->getItem($k);

					if(!$item) {
						unset($_SESSION["basket"][$k]);
						continue;
					}
					else {
						$method = $item["method"];
						$args = $item["args"];

						if($method == "addPermission") {
							$_minecraft->addPermission($_SESSION["username"], $args, $item["duration"]);
						}
						elseif($method == "givePlayerItemWithData") {
							$args = json_decode(TextUtils::fixJson($args), true);

							foreach($args as $v)
								$_minecraft->givePlayerItem($_SESSION["username"], $v["id"], $v["quantity"]);
						}
						elseif($method == "runConsoleCommand") {
							foreach($args as $v) {
								$v = str_replace(array("/", '$player'), array("", $_SESSION["username"]), $v);
								$_minecraft->runConsoleCommand($v);
							}
						}
					}
				}

				$totalprice = $_basket->getTotalPrice();
				$_users->setField($_SESSION["username"], "money", $_SESSION["money"] - $totalprice);
				$content = array();

				for($i = 0; $i < count($_SESSION["basket"]) + 1; $i++)
					$content[$i] = array("item_id" => array_shift($_SESSION["basket"])["id"]);

				$_history = loadBundle("fr.solicium.history");
				$_history->checkout($content, "items");

				setFlash("Vous avez reçu vos lots en échange de $totalprice émeraudes", "success");
			}
		}
	}
}

redirect("shop");
