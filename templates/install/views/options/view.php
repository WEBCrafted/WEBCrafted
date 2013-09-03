			<div class="block block-big">
				<header>
					<h1>Configuration du site</h1>
				</header>
				<div class="block-content">
					<form id="install" method="post" action="<?php echo WEBROOT ?>actions/install/options">
						<fieldset>
							<div class="inner">
								<h1>Nom du site</h1>
								<h3>Le nom de votre site</h3>
							</div>
							<input id="name" name="name" type="text" placeholder="Nom" required />
						</fieldset>
						<fieldset>
							<div class="inner">
								<h1>Slogan</h1>
								<h3>Une courte phrase définissant votre site</h3>
							</div>
							<input id="slogan" name="slogan" type="text" placeholder="Slogan" required />
						</fieldset>
						<fieldset>
							<div class="inner">
								<h1>Description</h1>
								<h3>Une courte description de votre serveur</h3>
							</div>
							<input id="description" name="description" type="text" placeholder="Description" required />
						</fieldset>
						<fieldset>
							<div class="inner">
								<h1>Mots clés</h1>
								<h3>Votre site en quelques mots (pour le référencement)</h3>
							</div>
							<input id="keywords" name="keywords" type="text" placeholder="Les mots clés séparés par une virgule" required />
						</fieldset>
						<fieldset>
							<div class="inner">
								<h1>Connexion à JSONAPI</h1>
								<h3>Connecter WEBCrafted à votre serveur Minecraft ?</h3>
							</div>
							<input id="jsonapi_use" name="jsonapi_use" type="checkbox"<?php if(!extension_loaded("cURL")): ?> disabled<?php else: ?> checked<?php endif; ?> />
						</fieldset>
						<fieldset>
							<div class="inner">
								<h1>Activer la boutique</h1>
								<h3>Améliorer l'expérience de votre serveur en utilisant la boutique intégrée de WEBCrafted ?</h3>
							</div>
							<input id="shop_use" name="shop_use" type="checkbox"<?php if(!extension_loaded("cURL")): ?> disabled<?php else: ?> checked<?php endif; ?> />
						</fieldset>
						<input class="btn btn-success" type="submit" value="Sauvegarder" />
					</form>
				</div>
			</div>
<?php $_page->script() ?>
<script src="<?php echo ASSETS ?>js/jquery-2.0.3.min.js"></script>
<script>
$(function() {
	$("#jsonapi_use").change(function(event) {
		var checked = $(this).is(":checked");
		if(!checked) {
			if($("#shop_use").is(":checked")) {
				$("#shop_use").prop("checked", false);
			}
		}
	});
	$("#shop_use").change(function(event) {
		var checked = $(this).is(":checked");
		if(checked) {
			if(!$("#jsonapi_use").is(":checked")) {
				$("#jsonapi_use").prop("checked", true);
			}
		}
	});
});
</script>
<?php $_page->endscript() ?>