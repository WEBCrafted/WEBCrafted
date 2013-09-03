<?php
if(!$options["shop_use"]) { ?>
		<section id="myserver">
			<h1>Boutique</h1>
			<div class="left">
				<p>Vous n'avez pas souhaité activer la boutique WEBCrafted mais vous pouvez toujours changer d'avis :</p>
				<a class="btn btn-success" href="<?php echo TLINK ?>options">Activer la boutique</a>
			</div>
		</section>
<?php }
else {
	if(!isset($params[1])) {
		$params[1] = "home";
	}
	switch ($params[1]) {
		case "home":
			set(array("page" => array("title" => "Boutique", "description" => "Gérer votre boutique WEBCrafted")));
			break;
		case "create":
			set(array("page" => array("title" => "Boutique", "description" => "Créer une offre")));
			break;
		case "edit":
			set(array("page" => array("title" => "Boutique", "description" => "Modifier une offre")));
			break;
		default: 
			break;
	}
	if(file_exists(TROOT . "views/shop/subviews/{$params[1]}/subview.php")) {
		if(file_exists(TROOT . "views/shop/subviews/{$params[1]}/loader.php")) {
			include_once(TROOT . "views/shop/subviews/{$params[1]}/loader.php");
		}
		include_once(TROOT . "views/shop/subviews/{$params[1]}/subview.php");
	} else {
		include_once(TROOT . "views/404/view.php");
	}
}
