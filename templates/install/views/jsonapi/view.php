			<div class="block block-large">
				<header>
					<h1>Configuration de JSONAPI</h1>
				</header>
				<div class="block-content">
					<form id="install" method="post" action="<?php echo WEBROOT ?>actions/install/jsonapi">
						<fieldset>
							<div class="inner">
								<h1>IP du serveur</h1>
								<h3>L'IP de votre serveur Minecraft</h3>
							</div>
							<input id="mc_server" name="mc_server" type="text" placeholder="IP du serveur" required />
						</fieldset>
						<fieldset>
							<div class="inner">
								<h1>Port JSONAPI</h1>
								<h3>Le port de JSONAPI</h3>
							</div>
							<input id="jsonapi_port" name="jsonapi_port" type="number" placeholder="Port" required />
						</fieldset>
						<fieldset>
							<div class="inner">
								<h1>Utilisateur JSONAPI</h1>
								<h3>Le nom d'utilisateur de JSONAPI</h3>
							</div>
							<input id="jsonapi_username" name="jsonapi_username" type="text" placeholder="Utilisateur" />
						</fieldset>
						<fieldset>
							<div class="inner">
								<h1>Mot de passe JSONAPI</h1>
								<h3>Le mot de passe correspondant à l'utilisateur</h3>
							</div>
							<input id="jsonapi_password" name="jsonapi_password" type="password" placeholder="Mot de passe" />
						</fieldset>
						<fieldset>
							<div class="inner">
								<h1>Salt JSONAPI</h1>
								<h3>Le salt de JSONAPI</h3>
							</div>
							<input id="jsonapi_salt" name="jsonapi_salt" type="text" placeholder="Salt" />
						</fieldset>
						<input class="btn btn-success" type="submit" value="Tester" />
					</form>
				</div>
			</div>