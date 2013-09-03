<?php
if(
	!isset(
		$_POST["token"],
		$_POST["name"],
		$_POST["image_url"],
		$_POST["method"],
		$_POST["args"],
		$_POST["category"],
		$_POST["price"]
	)) {
	setFlash("Un champ est manquant !", "error");
}
else {
	if($_POST["method"] == "runConsoleCommand") {
		$args = explode("\n", $_POST["args"]);

		foreach($args as $k => $v)
			$args[$k] = trim($v);

		$_POST["args"] = $args;
	}
	elseif($_POST["method"] == "givePlayerItemWithData") {
		$args = explode(";", $_POST["args"]);

		foreach($args as $k => $v) {
			$v = explode(":", $v);
			$v["id"] = (int)$v[0];
			$v["quantity"] = isset($v[1]) ? (int)$v[1] : 64;
			$v["data"] = isset($v[2]) ? (int)$v[2] : 0;
			unset($v[0], $v[1], $v[2]);
			$args[$k] = $v;
		}

		$_POST["args"] = $args;
	}

	$id = DataBase::read(PREFIX . "shop_items", array("fields" => array("id"), "limit" => 1, "order" => array("method" => "DESC")));

	if(empty($id))
		$id = 1;
	else
		$id = current($id) + 1;

	$success = $_shop->createItem(
		$id,
		$_POST["name"],
		$_POST["image_url"],
		$_POST["method"],
		$_POST["args"],
		$_POST["category"],
		$_POST["price"],
		isset($_POST["duration"]) ? $_POST["duration"] : 0
	);

	if(!$success)
		setFlash("Une erreur s'est produite !", "error");
	else
		setFlash("L'offre a été créée !", "success");
}

redirect("admin/shop", false);
