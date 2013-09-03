		<section id="myserver">
			<h1>Console Minecraft</h1>
			<?php if(!$options["jsonapi_use"]): ?>
			<div class="left">
				<p>Vous n'avez pas souhaité lier votre serveur Minecraft à WEBCrafted, vous pouvez toujours changer d'avis :</p>
				<a class="btn btn-success" href="<?php echo TLINK ?>options">Connecter mon serveur</a>
			</div>
			<?php elseif(empty($logs)): ?>
			<div class="left">
				<p><span class="red">Votre serveur ne contient aucune log à afficher</span></p>
			</div>
			<?php else: ?>
			<section id="console">
				<div id="scroll-pane" class="inner">
					<table id="consol">
						<?php foreach($logs as $k => $v): ?>
						<tr valign="top">
							<td class="lines">
								<div><?php echo $v["num"] ?></div>
							</td>
							<td class="logs">
								<div><?php echo $v["line"] ?></div>
							</td>
						</tr>
						<?php endforeach; ?>
					</table>
					<div class="clear"></div>
				</div>
				<form method="post" action="<?php echo WEBROOT ?>actions/minecraft/command">
					<input id="token" name="token" type="hidden" value="{session.token}" />
					<input id="command" name="command" type="text" onclick="if(getElementById('command').value == 'Rentrez une commande et appuyez sur entrée...') getElementById('command').value = ''" value="Rentrez une commande et appuyez sur entrée..." />
				</form>
			</section>
			<?php endif; ?>
		</section>
<?php $_page->script() ?>
<script type="text/javascript" src="<?php echo ASSETS ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="<?php echo ASSETS ?>js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo ASSETS ?>js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript">
$(function() {
	$("#scroll-pane")
		.scrollTop($("#scroll-pane").prop("scrollHeight"))
		.jScrollPane({
			"mouseWheelSpeed": 60,
			"hideFocus": true,
		});
});
</script>
<?php $_page->endscript() ?>