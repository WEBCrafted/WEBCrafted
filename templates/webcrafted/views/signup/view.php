			<img id="logo" src="<?php echo ASSETS ?>images/logo.png" alt="webcrafted" />

			<?php echo getFlash() ?>

			<!-- DEBUT du container des boîtes -->
			<section id="blocks-container">
				<div class="block">
					<header>
						<h1>Inscription</h1>
					</header>
					<div class="block-content">
						<form id="signup" method="post" action="<?php echo WEBROOT ?>actions/users/signup">
							<input id="token" name="token" type="hidden" value="{session.token}" />
							<fieldset>
								<div class="inner">
									<h1>Nom de compte</h1>
									<h3>Le nom de compte qui servira à vous identifier<br />(de préférence votre pseudo minecraft)</h3>
								</div>
								<input id="username" name="username" type="text" placeholder="Pseudo" required />
							</fieldset>
							<fieldset>
								<div class="inner">
									<h1>Email</h1>
									<h3>L'email qui servira à récupèrer vos identifiants</h3>
								</div>
								<input id="email" name="email" type="email" placeholder="Email" required />
							</fieldset>
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
							<input class="btn btn-success" type="submit" value="Inscription" />
						</form>
					</div>
				</div>
			</section>
			<!-- FIN du container des boîtes -->