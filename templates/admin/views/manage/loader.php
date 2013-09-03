<?php
if(!$_users->hasPermission("webcrafted.admin.*") AND !$_users->hasPermission("webcrafted.admin.console")) {
	setFlash("Vous n'avez pas les droits nécessaires pour cette action", "error");
	redirect("login", false);
}

if($options["jsonapi_use"])
{
	$_minecraft = loadBundle("fr.solicium.minecraft");
	$logs = $_minecraft->getLatestConsoleLogs();
	date_default_timezone_set("Europe/Paris");
	$tmp = $logs;
	$logs = array();
	
	for($i = 0; $i < count($tmp); $i++)
	{
		$v = $tmp[$i];

		if(!isset($v))
			continue;
		else if(strstr($v["line"], "[JSONAPI]"))
			continue;

		$v["time"] = date("Y-m-d H:i:s", $v["time"]);

		$aReplaceFrom = array(
			"[0;31;22m",
			"[0;32;22m",
			"[0;33;22m",
			"[0;34;22m",
			"[0;35;22m",
			"[0;36;22m",
			"[0;37;22m",                     
			"[0;30;1m",
			"[0;31;1m",
			"[0;32;1m",
			"[0;33;1m",
			"[0;34;1m",
			"[0;35;1m",
			"[0;36;1m",
			"[0;37;1m",
			"[1;31m",
			"[21m",
			"[9m",
			"[5m",
			"[3m",
			"[0m",
			"[m",
			"<span><span",
			"</span></span>"
		);
		
		$aReplaceTo = array(
			"</span><span style=\"color:#aa0000\">",
			"</span><span style=\"color:#00aa00\">",
			"</span><span style=\"color:#ffaa00\">",
			"</span><span style=\"color:#0000aa\">",
			"</span><span style=\"color:#aa00aa\">",
			"</span><span style=\"color:#00aaaa\">",
			"</span><span style=\"color:#aaaaaa\">",
			"</span><span style=\"color:#555555\">",
			"</span><span style=\"color:#ff5555\">",
			"</span><span style=\"color:#55ff55\">",
			"</span><span style=\"color:#ffffff\">",
			"</span><span style=\"color:#5555ff\">",
			"</span><span style=\"color:#ff55ff\">",
			"</span><span style=\"color:#55ffff\">",
			"</span><span style=\"color:#ffff55\">",
			"",
			"",
			"",
			"",
			"",
			"",
			"</span>",
			"<span",
			"</span>"
		);

		$v["line"] = '<span>'.$v["line"].'</span>';
		$v["line"] = str_replace($aReplaceFrom, $aReplaceTo, $v["line"]);
		$v["line"] = str_replace(array("[WARNING]", "[INFO]", "[SEVERE]", $v["time"]), array('<span class="warning">[WARNING]</span>', '<span class="info">[INFO]</span>', '<span class="severe">[SEVERE]</span>', '<span class="time">' . $v["time"] . '</span>'), $v["line"]);
		$iCount = count($logs)+1;
        $v["num"] = $iCount;
        
		if($iCount < 10)
			$v["num"] = '&nbsp;&nbsp;'.$iCount;
		else if($iCount < 100)
			$v["num"] = '&nbsp;'.$iCount;

		$logs[count($logs)] = $v;
	}
}

set(array(
	"page" => array(
		"title" => "Gérer le serveur",
		"description" => "Permet de voir les logs, exécuter une commande",
	),
));
