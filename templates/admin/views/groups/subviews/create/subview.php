		<section id="wrap">
			<form method="post" action="<?php echo WEBROOT ?>actions/groups/create">
				<input id="token" name="token" type="hidden" value="{session.token}" />
				<fieldset>
					<h2 for="name">Nom du groupe</h2>
					<input id="name" name="name" type="text" placeholder="Rentrez le nom ici" required />
				</fieldset>
				<fieldset>
					<h2 for="permissions">Permissions</h2>
					<input id="webcrafted.admin.server" name="permissions[webcrafted.admin.server]" type="checkbox" /><label for="webcrafted.admin.server">Gestion du serveur sur la page d'accueil</label>
					<input id="webcrafted.admin.console" name="permissions[webcrafted.admin.console]" type="checkbox" /><label for="webcrafted.admin.console">Accès à la console</label>
					<input id="webcrafted.admin.users" name="permissions[webcrafted.admin.users]" type="checkbox" /><label for="webcrafted.admin.users">Gérer les utilisateurs</label>
					<input id="webcrafted.admin.groups" name="permissions[webcrafted.admin.groups]" type="checkbox" /><label for="webcrafted.admin.groups">Gérer les groupes</label>
					<input id="webcrafted.admin.posts" name="permissions[webcrafted.admin.posts]" type="checkbox" /><label for="webcrafted.admin.posts">Gérer les actualités</label>
					<input id="webcrafted.admin.categories" name="permissions[webcrafted.admin.categories]" type="checkbox" /><label for="webcrafted.admin.categories">Gérer les catégories</label>
					<input id="webcrafted.admin.pages" name="permissions[webcrafted.admin.pages]" type="checkbox" /><label for="webcrafted.admin.pages">Gérer les pages</label>
					<input id="webcrafted.admin.partners" name="permissions[webcrafted.admin.partners]" type="checkbox" /><label for="webcrafted.admin.partners">Gérer les partenaires</label>
					<input id="webcrafted.admin.widgets" name="permissions[webcrafted.admin.widgets]" type="checkbox" /><label for="webcrafted.admin.widgets">Gérer les widgets</label>
					<input id="webcrafted.admin.shop" name="permissions[webcrafted.admin.shop]" type="checkbox" /><label for="webcrafted.admin.shop">Gérer la boutique</label>
					<input id="webcrafted.admin.options" name="permissions[webcrafted.admin.options]" type="checkbox" /><label for="webcrafted.admin.options">Gérer les options</label>
				</fieldset>
				<fieldset>
					<h2 for="tags">Propriétés de votre groupe</h2>
					<input id="signup" name="signup" type="checkbox" /><label for="signup">Groupe par défaut</label>
				</fieldset>
				<input class="btn btn-success" name="submit" type="submit" value="Créer">
			</form>
		</section>