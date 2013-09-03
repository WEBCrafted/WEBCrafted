		<section id="wrap">
			<form method="post" action="<?php echo WEBROOT ?>actions/partners/add" enctype="multipart/form-data">
				<input id="token" name="token" type="hidden" value="{session.token}" />
				<fieldset id="upload">
					<input id="image" name="image" type="file" required />
					<img src="<?php echo ASSETS ?>images/upload.png" />
				</fieldset>
				<fieldset>
					<h2 for="name">Nom du partenaire</h2>
					<input id="name" name="name" type="text" placeholder="Rentrez le nom ici" required />
				</fieldset>
				<fieldset>
					<h2 for="site">Site du partenaire</h2>
					<input id="site" name="site" type="url" placeholder="Rentrez l'url ici" required />
				</fieldset>
				<input class="btn btn-success" name="submit" type="submit" value="Ajouter">
			</form>
		</section>