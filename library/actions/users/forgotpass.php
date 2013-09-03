<?php
if(!isset($params["id"])) {
	setFlash("Un champ est manquant", "error");
	redirect("login", false);
}

$userdata = $_users->getUser($params["id"]);
$secretkey = substr(sha1(md5($userdata["email"]) . Configure::read("users_secret_key")), 13, 20);

if(isset($params["method"]) AND $params["method"] == "email") {
	$email = "noreply@" . $_SERVER["SERVER_NAME"];
	$headers = "From: \"" . Configure::read("name") . "\"<$email>\n";
	$headers .= "Reply-To: $email\n";
	$headers .= "Content-Type: text/plain; charset=\"utf-8\"";
	mail($userdata["email"], "Changement de mot de passe", "http://" . $_SERVER["SERVER_NAME"] . ($_SERVER["SERVER_PORT"] != 80 ? ":" . $_SERVER["SERVER_PORT"] : "") . WEBROOT . "forgotpass/?id={$params["id"]}&secretkey=$secretkey", $headers);
	return;
}
elseif(
	!isset(
		$_POST["token"],
		$_POST["secretkey"],
		$_POST["password"],
		$_POST["password2"])
	) {
	setFlash("Un champ est manquant", "error");
	redirect("login", false);
}

if(!$userdata) {
	setFlash("Lien de réinitialisation incorrect", "error");
}
else {
	if($_POST["password"] != $_POST["password2"]) {
        setFlash("Les mots de passe sont différents", "error");
	}
	else {
		if($secretkey != $_POST["secretkey"]) {
			setFlash("Erreur de sécurité, réessayez", "error");
		}
		else {
			$success = $_users->changePassword($userdata["username"], $_POST["password"]);

			if(!$success)
				setFlash("Une erreur s'est produite !", "error");
			else
				setFlash("Mot de passe changé avec succès", "success");
		}
	}
}

redirect("login", false);
