		<section id="wrap">
			<form method="post" action="<?php echo WEBROOT ?>actions/users/edit">
				<input id="id" name="id" type="hidden" value="{user.id}" />
				<input id="token" name="token" type="hidden" value="{session.token}" />
				<fieldset>
					<h2 for="username">Pseudo</h2>
					<input id="username" name="username" type="text" placeholder="Pseudo" value="{user.username}" />
				</fieldset>
				<fieldset>
					<h2 for="email">Email</h2>
					<input id="email" name="email" type="email" placeholder="Email" value="{user.email}" />
				</fieldset>
				<fieldset>
					<h2 for="tags">Propriétés de votre utilisateur</h2>
					<p>Choisissez son groupe</p>
					<?php for($i = 0; $i < count($groups); $i++): $group = $groups[$i]; ?>
					<input id="group<?php echo $i ?>" name="group_id" type="radio" value="<?php echo $group["id"] ?>"<?php if($user["group_id"]["id"] == $group["id"]): ?> checked<?php endif; ?> /><label for="group<?php echo $i ?>"><?php echo $group["name"] ?></label>
					<?php endfor; ?>
					<p>Rentrez son nombre d'émeraudes</p>
					<input id="money" type="number" name="money" placeholder="0" value="{user.money}" />
				</fieldset>
				<input class="btn btn-success" name="submit" type="submit" value="Sauvegarder">
			</form>
		</section>