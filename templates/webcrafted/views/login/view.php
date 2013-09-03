			<a href="<?php echo WEBROOT ?>"><img id="logo" src="<?php echo ASSETS ?>images/logo.png" alt="webcrafted" /></a>

			<?php echo getFlash() ?>

			<!-- DEBUT du container des boîtes -->
			<section id="blocks-container">
				<div class="block">
					<header>
						<h1>{page.title}</h1>
					</header>
					<div class="block-content">
						<form id="login" method="post" action="<?php echo WEBROOT ?>actions/users/login">
							<input id="token" name="token" type="hidden" value="{session.token}" />
							<fieldset>
								<div class="inner">
									<h1>Pseudo</h1>
									<h3>L'identifiant avec lequel vous vous êtes inscrit</h3>
								</div>
								<input id="username" name="username" type="text" placeholder="Pseudo" required />
							</fieldset>
							<fieldset>
								<div class="inner">
									<h1>Mot de passe</h1>
									<h3>Le mot de passe correspondant au compte</h3>
								</div>
								<input id="password" name="password" type="password" placeholder="Mot de passe" required />
							</fieldset>
							<input class="btn btn-success" type="submit" value="Connexion" />
						</form>
					</div>
				</div>
			</section>
			<!-- FIN du container des boîtes -->