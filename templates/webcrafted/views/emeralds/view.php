		<section id="page">
			<h1>Acheter des émeraudes</h1>
			<?php if(!isset($_SESSION["isLogged"]) OR !$_SESSION["isLogged"]): ?>
			<div class="alert alert-error">
				<p>
					Vous devez être connecté pour pouvoir acheter des tokens
				</p>
			</div>
			<?php else: echo getFlash(); ?>
			<noscript>
				<div class="alert alert-error">
					<p>
						Merci d'activer le JavaScript de votre navigateur
					</p>
				</div>
			</noscript>
			<p>1 code = <?php echo $emeralds ?> émeraude<?php echo $plural["emeralds"] ?></p>
			<div id="starpass_{starpass.idd}"></div>
			{starpass.js}
			<?php endif; ?>
		</section>