		<section id="wrap">
			<form method="post" action="<?php echo WEBROOT ?>actions/options">
				<input id="token" name="token" type="hidden" value="{session.token}" />
				<fieldset>
					<h2 for="name">Nom du serveur</h2>
					<input id="name" name="name" type="text" value="{options.name}" />
				</fieldset>
				<fieldset>
					<h2 for="slogan">Slogan du serveur</h2>
					<input id="slogan" name="slogan" type="text" value="{options.slogan}" />
				</fieldset>
				<fieldset>
					<h2 for="description">Courte description du site</h2>
					<textarea id="description" name="description">{options.description}</textarea>
				</fieldset>
				<fieldset>
					<h2 for="keywords">Mots clés du site</h2>
					<textarea id="keywords" name="keywords">{options.keywords}</textarea>
				</fieldset>
				<fieldset>
					<h2 for="twitter_account">Thème du site</h2>
					<select id="theme" name="theme">
						<?php foreach($themes as $k => $v): ?>
						<option value="<?php echo $k ?>"<?php if($k == $options["theme"]): ?> selected<?php endif; ?>><?php echo $v ?></option>
						<?php endforeach; ?>
					</select>
				</fieldset>
				<fieldset>
					<h2 for="jsonapi_use">JSONAPI</h2>
					<input id="jsonapi_use" name="jsonapi_use" type="checkbox"<?php if($options["jsonapi_use"]): ?> checked<?php endif; ?> /><label for="jsonapi_use">Connecter mon serveur Minecraft à WEBCrafted ?</label>
					<div id="jsonapi"<?php if(!$options["jsonapi_use"]): ?> style="display: none;"<?php endif; ?>><br />
						<label style="display: block;" for="mc_server">IP du serveur</label><input id="mc_server" name="mc_server" type="text"<?php if($options["jsonapi_use"]): ?> value="{options.server_ip}:{options.server_port}"<?php endif; ?> /><br /><br />
						<label for="jsonapi_username">Utilisateur JSONAPI</label><input id="jsonapi_username" name="jsonapi_username" type="text"<?php if($options["jsonapi_use"]): ?> value="{options.jsonapi_username}"<?php endif; ?> /><br /><br />
						<label for="jsonapi_password">Mot de passe correspondant</label><input id="jsonapi_password" name="jsonapi_password" type="password"<?php if($options["jsonapi_use"]): ?> value="{options.jsonapi_password}"<?php endif; ?> /><br /><br />
						<label for="jsonapi_port">Port JSONAPI</label><input id="jsonapi_port" name="jsonapi_port" type="number"<?php if($options["jsonapi_use"]): ?> value="{options.jsonapi_port}"<?php endif; ?> /><br /><br />
						<label for="jsonapi_salt">Salt JSONAPI</label><input id="jsonapi_salt" name="jsonapi_salt" type="text"<?php if($options["jsonapi_use"]): ?> value="{options.jsonapi_salt}"<?php endif; ?> /><br /><br />
						<input id="shop_use" name="shop_use" type="checkbox"<?php if($options["shop_use"]): ?> checked<?php endif; ?> /><label for="shop_use">Utiliser la boutique WEBCrafted ?</label>
						<div id="shop"<?php if(!$options["shop_use"]): ?> style="display: none;"<?php endif; ?>><br />
							<label style="display: block;" for="shop_starpass_idp">IDP du document Starpass</label><input id="shop_starpass_idp" name="shop_starpass_idp" type="text"<?php if($options["shop_use"]): ?> value="{options.shop_starpass_idp}"<?php endif; ?> /><br /><br />
							<label for="shop_starpass_idd">IDD du document</label><input id="shop_starpass_idd" name="shop_starpass_idd" type="text"<?php if($options["shop_use"]): ?> value="{options.shop_starpass_idd}"<?php endif; ?> /><br /><br />
							<label for="shop_starpass_code">Code de test</label><input id="shop_starpass_code" name="shop_starpass_code" type="text"<?php if($options["shop_use"]): ?> value="{options.shop_starpass_code}"<?php endif; ?> /><br /><br />
							<input id="shop_starpass_usecode" name="shop_starpass_usecode" type="checkbox"<?php if($options["shop_starpass_usecode"]): ?> checked<?php endif; ?> /><label for="shop_starpass_usecode">Activer le code de test ?</label><br /><br />
							<label for="shop_starpass_credit">Émeraudes par code</label><input id="shop_starpass_credit" name="shop_starpass_credit" type="text"<?php if($options["shop_use"]): ?> value="{options.shop_starpass_credit}"<?php endif; ?> />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<h2 for="socialhub">SocialHub</h2>
					<label for="facebook_page">Page Facebook</label>
					<input id="facebook_page" name="facebook_page" type="url" value="{options.facebook_page}" placeholder="https://" /><br /><br />
					<label for="youtube_channel">Chaîne YouTube</label>
					<input id="youtube_channel" name="youtube_channel" type="text" value="{options.youtube_channel}" placeholder="https://" /><br /><br />
					<label for="twitter_account">Compte Twitter</label>
					<input id="twitter_account" name="twitter_account" type="text" value="{options.twitter_account}" placeholder="@" />
				</fieldset>
				<input class="btn btn-success" type="submit" value="Sauvegarder" />
				<button class="btn btn-primary" type="button" onclick="javascript:history.back()">Retour</button>
			</form>
		</section>
<?php $_page->script() ?>
<script src="<?php echo ASSETS ?>js/jquery-2.0.3.min.js"></script>
<script src="<?php echo ASSETS ?>js/ckeditor.js"></script>
<script>
$(function() {
	$("#jsonapi_use").change(function(event) {
		if(event.currentTarget.checked) {
			$("#jsonapi").css("display", "block");
		}
		else {
			$("#jsonapi").css("display", "none");
		}
	});
	$("#shop_use").change(function(event) {
		if(event.currentTarget.checked) {
			$("#shop").css("display", "block");
		}
		else {
			$("#shop").css("display", "none");
		}
	});
});
</script>
<?php $_page->endscript() ?>