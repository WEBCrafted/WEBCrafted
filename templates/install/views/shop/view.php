			<div class="block block-large">
				<header>
					<h1>Configuration de la boutique</h1>
				</header>
				<div class="block-content">
					<form id="install" method="post" action="<?php echo WEBROOT ?>actions/install/shop">
						<fieldset>
							<div class="inner">
								<h1>L'url du document à indiquer sur StarPass est la suivante :</h1>
								<h3>http://<?php echo $_SERVER["SERVER_NAME"] ?><?php echo $_SERVER["SERVER_PORT"] != 80 ? ":" . $_SERVER["SERVER_PORT"] : "" ?><?php echo WEBROOT ?>actions/starpass/add</h3>
							</div>
						</fieldset>
						<fieldset>
							<div class="inner">
								<h1>IDP du document</h1>
								<h3>L'idp du document</h3>
							</div>
							<input id="shop_starpass_idp" name="shop_starpass_idp" type="number" placeholder="IDP" required />
						</fieldset>
						<fieldset>
							<div class="inner">
								<h1>IDD du document</h1>
								<h3>L'idd du document</h3>
							</div>
							<input id="shop_starpass_idd" name="shop_starpass_idd" type="number" placeholder="IDD" required />
						</fieldset>
						<fieldset>
							<div class="inner">
								<h1>Code de test</h1>
								<h3>Le code de test du document</h3>
							</div>
							<input id="shop_starpass_code" name="shop_starpass_code" type="text" maxlength="8" placeholder="Code de test" required />
						</fieldset>
						<fieldset>
							<div class="inner">
								<h1>Émeraudes</h1>
								<h3>Le nombre d'émeraudes par code</h3>
							</div>
							<input id="shop_starpass_credit" name="shop_starpass_credit" type="number" placeholder="10" required />
						</fieldset>
						<input class="btn btn-success" type="submit" value="Vérifier" />
					</form>
				</div>
			</div>