		<section id="wrap">
			<form method="post" action="<?php echo WEBROOT ?>actions/shop/edit">
				<input id="id" name="id" type="hidden" value="{item.id}" />
				<input id="token" name="token" type="hidden" value="{session.token}" />
				<fieldset>
					<h2 for="name">Nom de l'offre</h2>
					<input id="name" name="name" type="text" placeholder="Rentrez le nom ici" value="{item.name}" required />
				</fieldset>
				<fieldset>
					<h2 for="image_url">Image de présentation</h2>
					<input id="image_url" name="image_url" type="url" placeholder="Rentrez l'url de l'image de présentation" value="{item.image_url}" required />
				</fieldset>
				<fieldset>
					<h2 for="method">Méthode</h2>
					<select id="method" name="method" required>
						<option disabled>Choisissez une méthode</option>
						<option value="givePlayerItemWithData"<?php if($item["method"] == "givePlayerItemWithData"): ?> selected<?php endif; ?>>Donner des items à un joueur</option>
						<option value="addPermission"<?php if($item["method"] == "addPermission"): ?> selected<?php endif; ?>>PermissionsEX : Ajouter une permission au joueur</option>
						<option value="runConsoleCommand"<?php if($item["method"] == "runConsoleCommand"): ?> selected<?php endif; ?>>Exécuter une ou plusieurs commandes</option>
					</select>
				</fieldset>
				<fieldset>
					<h2 for="args">Arguments</h2>
						<?php
						if($item["method"] == "givePlayerItemWithData")
					    	echo '<textarea id="args" name="args" placeholder="Rentrez les IDs des items séparés par un point-virgule ici" required>{item.args}</textarea>';
						else if($item["method"] == "addPermission")
					    	echo '<input id="args" name="args" type="text" value="{item.args}" required />';
						else if($item["method"] == "runConsoleCommand")
					    	echo '<textarea id="args" name="args" rows="5" placeholder="Rentrez les commandes séparées par un saut de ligne ici" required>{item.args}</textarea>';
					    ?>
				</fieldset>
				<?php if($item["duration"] != "0" AND $item["duration"] != "2592000" AND $item["duration"] != "86400"): ?>
				<fieldset>
					<h2 for="duration">Durée de l'offre</h2>
					<input id="duration" name="duration" type="number" value="Entrez le temps en seconde que le privilège restera, laissez vide si à vie" />
				</fieldset>
				<?php else: ?>
				<fieldset style="display: none;">
					<h2 for="duration">Durée de l'offre</h2>
					<select id="duration" name="duration" required>
						<option disabled>Choisissez une durée</option>
						<option value="0"<?php if($item["duration"] == "0"): ?> selected<?php endif; ?>>A vie</option>
						<option value="2592000"<?php if($item["duration"] == "2592000"): ?> selected<?php endif; ?>>1 mois</option>
						<option value="86400"<?php if($item["duration"] == "86400"): ?> selected<?php endif; ?>>1 jour</option>
						<option value="-1">Autre</option>
					</select>
				</fieldset>
				<?php endif; ?>
				<fieldset>
					<h2 for="category">Catégorie de l'article</h2>
					<input id="category" name="category" type="text" placeholder="Rentrez la catégorie ici" value="{item.category}" required />
				</fieldset>
				<fieldset>
					<h2 for="price">Prix en émeraudes</h2>
					<input id="price" name="price" type="number" placeholder="Rentrez le prix ici" value="{item.price}" required />
				</fieldset>
				<input class="btn btn-success" name="submit" type="submit" value="Editer">
			</form>
		</section>
<?php $_page->script() ?>
<script type="text/javascript" src="<?php echo ASSETS ?>js/jquery-2.0.3.min.js"></script>
<script>
$(function() {
	$("#method").change(function() {
		var value = $(this).val();
		if(value == "givePlayerItemWithData") {
			$("#args").replaceWith($('<textarea id="args" name="args" value="Rentrez les IDs des items séparés par un point-virgule ici"></textarea>'));
			$("#duration").parent().hide();
		}
		else if(value == "addPermission") {
			$("#args").replaceWith($('<input id="args" name="args" type="text" value="Rentrez la permission ici" />'));
			$("#duration").parent().show();
		}
		else if(value == "runConsoleCommand") {
			$("#args").replaceWith($('<textarea id="args" name="args" rows="5" value="Rentrez les commandes séparées par un saut de ligne ici"></textarea>'));
			$("#duration").parent().hide();
		}
		$("#args").parent().show();
	});
	$("#duration").change(function() {
		var value = $(this).val();
		if(value == "-1") {
			$("#duration").parent().html('<h2 for="duration">Durée de l\'offre</h2><input id="duration" name="duration" type="number" value="Entrez le temps en seconde que le privilège restera, laissez vide si à vie" />');
		}
	});
});
</script>
<?php $_page->endscript() ?>