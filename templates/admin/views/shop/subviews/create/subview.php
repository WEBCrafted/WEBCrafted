		<section id="wrap">
			<form method="post" action="<?php echo WEBROOT ?>actions/shop/create">
				<input id="token" name="token" type="hidden" value="{session.token}" />
				<fieldset>
					<h2 for="name">Nom de l'offre</h2>
					<input id="name" name="name" type="text" placeholder="Rentrez le nom ici" required />
				</fieldset>
				<fieldset>
					<h2 for="image_url">Image de présentation</h2>
					<input id="image_url" name="image_url" type="url" placeholder="Rentrez l'url de l'image de présentation" required />
				</fieldset>
				<fieldset>
					<h2 for="method">Méthode</h2>
					<select id="method" name="method" required>
						<option disabled="disabled" selected="selected">Choisissez une méthode</option>
						<option value="givePlayerItemWithData">Donner des items à un joueur</option>
						<option value="addPermission">PermissionsEX : Ajouter une permission au joueur</option>
						<option value="runConsoleCommand">Exécuter une ou plusieurs commandes</option>
					</select>
				</fieldset>
				<fieldset style="display: none;">
					<h2 for="args">Arguments</h2>
					<textarea id="args" name="args" placeholder="Rentrez les IDs des items séparés par un point-virgule ici" required></textarea>
				</fieldset>
				<fieldset style="display: none;">
					<h2 for="duration">Durée de l'offre</h2>
					<select id="duration" name="duration">
						<option disabled selected>Choisissez une durée</option>
					</select>
				</fieldset>
				<fieldset>
					<h2 for="category">Catégorie de l'article</h2>
					<input id="category" name="category" type="text" placeholder="Rentrez la catégorie ici" required />
				</fieldset>
				<fieldset>
					<h2 for="price">Prix en émeraudes</h2>
					<input id="price" name="price" type="number" placeholder="Rentrez le prix ici" required />
				</fieldset>
				<input class="btn btn-success" name="submit" type="submit" value="Créer">
			</form>
		</section>
<?php $_page->script() ?>
<script type="text/javascript" src="<?php echo ASSETS ?>js/jquery-2.0.3.min.js"></script>
<script>
$(function() {
	$("#method").change(function() {
		var value = $(this).val();
		if(value == "givePlayerItemWithData") {
			$("#args").parent().html('<h2 for="args">Arguments</h2><textarea id="args" name="args" placeholder="Rentrez les IDs des items séparés par un point-virgule ici"></textarea>');
			$("#duration").parent().html('');
			$("#duration").parent().hide();
		}
		else if(value == "addPermission") {
			$("#args").parent().html('<h2 for="args">Arguments</h2><input id="args" name="args" type="text" placeholder="Rentrez la permission ici" />');
			$("#duration").parent().html('<h2 for="duration">Durée de l\'offre</h2><select id="duration" name="duration" required><option disabled selected>Choisissez une durée</option><option value="0">A vie</option><option value="2592000">1 mois</option><option value="86400">1 jour</option> <option value="-1">Autre</option></select>');
			$("#duration").parent().show();
		}
		else if(value == "runConsoleCommand") {
			$("#args").parent().html('<h2 for="args">Arguments</h2><textarea id="args" name="args" rows="5" placeholder="Rentrez les commandes séparées par un saut de ligne ici"></textarea><p><strong>$player</strong> = le nom du joueur</p>');
			$("#duration").parent().html('');
			$("#duration").parent().hide();
		}
		$("#args").parent().show();
	});
	$("#duration").change(function() {
		var value = $(this).val();
		if(value == "-1") {
			$("#duration").parent().html('<h2 for="duration">Durée de l\'offre</h2><input id="duration" name="duration" type="number" placeholder="Entrez le temps en seconde que le privilège restera, laissez vide si à vie" />');
		}
	});
});
</script>
<?php $_page->endscript() ?>