<?php
$_comments = loadBundle("fr.solicium.comments");
$_minecraft = loadBundle("fr.solicium.minecraft");
$_pages = loadBundle("fr.solicium.pages");
$_partners = loadBundle("fr.solicium.partners");
$_widgets = loadBundle("fr.solicium.widgets");
$pages = $_pages->getPages(true);
$serverdata = $_minecraft->getServer();
$lastcomments = $_comments->getLastComments();
$partners = $_partners->getPartners();
$widgets = $_widgets->getWidgets(false);
$admin = false;

if(!empty($serverdata))
	$serverdata = array(
		"ip"			=> Configure::read("server_ip"),
		"port"			=> $serverdata["port"],
		"players"		=> count($serverdata["players"]),
		"maxPlayers"	=> $serverdata["maxPlayers"],
		"state"			=> "<span class=\"green\">En ligne</span>",
	);
else
	$serverdata = array(
		"ip"			=> Configure::read("server_ip"),
		"port"			=> Configure::read("server_port"),
		"players"		=> 0,
		"maxPlayers"	=> 0,
		"state"			=> "<span class=\"red\">Hors ligne</span>",
	);

if(
	$_users->hasPermission("webcrafted.admin.*")
	OR $_users->hasPermission("webcrafted.admin.server")
	OR $_users->hasPermission("webcrafted.admin.console")
	OR $_users->hasPermission("webcrafted.admin.posts")
	OR $_users->hasPermission("webcrafted.admin.pages")
	OR $_users->hasPermission("webcrafted.admin.users")
	OR $_users->hasPermission("webcrafted.admin.groups")
	OR $_users->hasPermission("webcrafted.admin.partners")
	OR $_users->hasPermission("webcrafted.admin.shop")
	OR $_users->hasPermission("webcrafted.admin.options")) {
	$admin = true;
}

set(array(
	"page" => array(
		"name" => Configure::read("name"),
		"slogan" => Configure::read("slogan"),
		"description" => Configure::read("description"),
		"keywords" => Configure::read("keywords"),
	),
	"options" => array(
		"jsonapi_use" => Configure::read("jsonapi_use"),
		"shop_use" => Configure::read("shop_use"),
		"facebook" => Configure::read("facebook_page"),
		"youtube" => Configure::read("youtube_channel"),
		"twitter" => str_replace("@", "", Configure::read("twitter_account")),
	),
	"lastcomments" => $lastcomments,
	"serverdata" => $serverdata,
	"pages" => $pages,
	"partners" => $partners,
	"widgets" => $widgets,
	"admin" => $admin,
));
