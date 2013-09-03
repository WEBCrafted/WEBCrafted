<?php
if(!$options["shop_use"]) {
	$_page->load("404");
	die();
}
$_shop = loadBundle("fr.solicium.shop");
$_basket = loadBundle("fr.solicium.basket");
$args = array(false);

if(!isset($params["sortby"])) {
	$method = "getItems";
}
elseif($params["sortby"] == "name") {
	$method = "getItemsByName";
}
elseif($params["sortby"] == "price") {
	$method = "getItemsByPrice";
}
elseif($params["sortby"] == "maxprice") {
	$method = "getItemsByPrice";
	$args[0] = "DESC";
}
elseif($params["sortby"] == "duration") {
	$method = "getItemsByDuration";
}
else {
	setFlash("Méthode inexistante", "error");
	redirect("shop");
}

$totalprice = $_basket->getTotalPrice();
$db = DataBase::getObject();
$categories = $db->query("SELECT COUNT(category) AS count, category FROM " . PREFIX . "shop_items GROUP BY category");
$categories = $categories->fetchAll(PDO::FETCH_ASSOC);

if(isset($params["category"])) {
	if(!in_array($params["category"], $categories)) {
		setFlash("La catégorie n'existe pas", "error");
		redirect("shop");
	}
	else {
		$method = "getItemsByCategory";
		$args[0] = $params["category"];
	}
}

$reflect = new ReflectionMethod("Shop", $method);
$items = $reflect->invokeArgs($_shop, $args);

set(array(
	"page" => array(
		"title" => "Boutique",
	),
	"plural" => array(
		"totalprice" => $totalprice > 1 ? "s" : "",
	),
	"items" => $items,
	"totalprice" => $totalprice,
	"categories" => $categories,
));
