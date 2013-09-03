		<!-- DEBUT de la sidebar -->
		<section id="sidebar">
			<h1>Sidebar</h1>
			<section id="widgets-container">
				<?php foreach($widgets as $k => $v): ?>
				<div class="widget">
					<header>
						<h1><?php echo $v["title"] ?></h1>
					</header>
					<div class="widget-content">
						<?php echo $v["content"] ?>
					</div>
				</div>
				<?php endforeach; ?>
			</section>
		</section>
		<!-- FIN de la sidebar -->