		<section id="wrap">
			<form method="post" action="<?php echo WEBROOT ?>actions/partners/edit" enctype="multipart/form-data">
				<input id="id" name="id" type="hidden" value="{partner.id}" />
				<input id="token" name="token" type="hidden" value="{session.token}" />
				<fieldset id="upload">
					<input id="image" name="image" type="file" />
					<img src="<?php echo ASSETS ?>images/upload.png" />
				</fieldset>
				<fieldset>
					<h2 for="name">Nom du partenaire</h2>
					<input id="name" name="name" type="text" placeholder="Rentrez le nom ici" value="{partner.name}" required />
				</fieldset>
				<fieldset>
					<h2 for="site">Site du partenaire</h2>
					<input id="site" name="site" type="url" placeholder="Rentrez l'url ici" value="{partner.url}" required />
				</fieldset>
				<input class="btn btn-success" name="submit" type="submit" value="Sauvegarder">
			</form>
		</section>