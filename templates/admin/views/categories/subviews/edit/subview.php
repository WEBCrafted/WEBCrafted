		<section id="wrap">
			<form method="post" action="<?php echo WEBROOT ?>actions/categories/edit">
				<input id="id" name="id" type="hidden" value="{category.id}" />
				<input id="token" name="token" type="hidden" value="{session.token}" />
				<fieldset>
					<h2 for="name">Nom de la catégorie</h2>
					<input id="name" name="name" type="text" placeholder="Rentrez le nom ici" value="{category.name}" />
				</fieldset>
				<input class="btn btn-success" name="submit" type="submit" value="Sauvegarder">
			</form>
		</section>