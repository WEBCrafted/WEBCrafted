		<section id="myserver">
			<?php if(!in_array("webcrafted.admin.*", $_SESSION["group_id"]["permissions"]) AND !in_array("webcrafted.admin.server", $_SESSION["group_id"]["permissions"])): ?>
			<h1>Administration</h1>
			<p>Bienvenue sur le panel d'administration</p>
			<?php else: ?>
			<h1>Votre serveur</h1>
				<?php if($options["jsonapi_use"] AND !empty($serverdata)): ?>
			<div class="left">
				<p><span class="green">{onlinePlayers} joueur{plural.onlinePlayers} connecté{plural.onlinePlayers}</span> sur {maxPlayers}</p>
				<p>{adminPlayers} membre{plural.adminPlayers} de l'équipe connecté{plural.adminPlayers}</p>
				<ul>
					<li><a href="<?php echo TLINK ?>manage">Accèder à la console</a></li>
				</ul>
			</div>
			<div class="right">
				<h3>Actions rapides</h3>
				<ul>
					<li><a href="#" onclick="if(confirm('Êtes-vous sûr de vouloir redémarrer le serveur ? L\'utilisation de RemoteToolkit est obligatoire.')) window.location.replace('<?php echo WEBROOT ?>actions/minecraft/restart/?token={session.token}')"><span class="green">V</span> Relancer le serveur</a></li>
					<li><a href="#" onclick="if(confirm('Êtes-vous sûr de vouloir recharger le serveur ?')) window.location.replace('<?php echo WEBROOT ?>actions/minecraft/reload/?token={session.token}')"><span class="green">O</span> Recharger le serveur</a></li>
					<li><a href="#" onclick="if(confirm('Êtes-vous sûr de vouloir stopper le serveur ? L\'utilisation de RemoteToolkit est obligatoire.')) window.location.replace('<?php echo WEBROOT ?>actions/minecraft/stop/?token={session.token}')"><span class="red">X</span> Stopper le serveur</a></li>
				</ul>
			</div>
			<div class="clear"></div>
			<h3><span class="red">Annonce rapide :</span></h3><form id="broadcast" method="post" action="<?php echo WEBROOT ?>actions/minecraft/broadcast"><input id="token" name="token" type="hidden" value="{session.token}" /><input id="message" name="message" type="text" placeholder="En direct du panel..." autocomplete="off" /><input class="btn btn-error" value="GO" type="submit" /></form>
				<?php elseif(!$options["jsonapi_use"]): ?>
			<div class="left">
				<p>Vous n'avez pas souhaité lier votre serveur Minecraft à WEBCrafted, vous pouvez toujours changer d'avis :</p>
				<a class="btn btn-success" href="<?php echo TLINK ?>options">Connecter mon serveur</a>
			</div>
				<?php else: ?>
			<div class="left">
				<p><span class="red">Votre serveur Minecraft est hors ligne</span></p>
			</div>
			<div class="right">
				<h3>Actions rapides</h3>
				<ul>
					<li><a href="<?php echo WEBROOT ?>actions/minecraft/start/?token={session.token}"><span class="green">V</span> Démarrer le serveur</a></li>
				</ul>
			</div>
				<?php endif; ?>
			<?php endif; ?>
		</section>