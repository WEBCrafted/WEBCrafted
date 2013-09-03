			<img id="logo" src="<?php echo ASSETS ?>images/logo.png" alt="webcrafted" />

			<?php echo getFlash() ?>

			<!-- DEBUT du container des boîtes -->
			<section id="blocks-container">
				<div class="block">
					<header>
						<h1>Réinitialisation du mot de passe</h1>
					</header>
					<div class="block-content">
						<form id="login" method="post" action="<?php echo WEBROOT ?>actions/users/forgotpass">
							<input id="id" name="id" type="hidden" value="{user.id}" />
							<input id="token" name="token" type="hidden" value="{session.token}" />
							<input id="secretkey" name="secretkey" type="hidden" value="{secretkey}" />
							<fieldset>
								<div class="inner">
									<h1>Mot de passe</h1>
									<h3>Le mot de passe pour protéger votre compte</h3>
								</div>
								<input id="password" name="password" type="password" placeholder="Mot de passe" required />
							</fieldset>
							<fieldset>
								<div class="inner">
									<h1>Confirmation</h1>
									<h3>La confirmation du mot de passe</h3>
								</div>
								<input id="password2" name="password2" type="password" placeholder="Mot de passe" required />
							</fieldset>
							<input class="btn btn-success" type="submit" value="Réinitialisation" />
						</form>
					</div>
				</div>
			</section>
			<!-- FIN du container des boîtes -->