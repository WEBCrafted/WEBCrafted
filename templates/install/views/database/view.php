			<div class="block">
				<header>
					<h1>Connexion à la base de données</h1>
				</header>
				<div class="block-content">
					<form id="install" method="post" action="<?php echo WEBROOT ?>actions/install/database">
						<fieldset>
							<div class="inner">
								<h1>Adresse de la base de données</h1>
								<h3>L'hôte de votre base de données</h3>
							</div>
							<input id="host" name="host" type="text" placeholder="Adresse" required />
						</fieldset>
						<fieldset>
							<div class="inner">
								<h1>Nom de la base de données</h1>
								<h3>Le nom de la base de données à utiliser</h3>
							</div>
							<input id="name" name="name" type="text" placeholder="Nom" required />
						</fieldset>
						<fieldset>
							<div class="inner">
								<h1>Utilisateur</h1>
								<h3>L'utilisateur associé à la base de données</h3>
							</div>
							<input id="user" name="user" type="text" placeholder="Utilisateur" required />
						</fieldset>
						<fieldset>
							<div class="inner">
								<h1>Mot de passe</h1>
								<h3>Le mot de passe correspondant à l'utilisateur</h3>
							</div>
							<input id="password" name="password" type="password" placeholder="Mot de passe" />
						</fieldset>
						<input class="btn btn-success" type="submit" value="Connexion" />
					</form>
				</div>
			</div>