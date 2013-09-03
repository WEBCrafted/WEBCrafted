<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>{page.title} | WEBCrafted</title>
	<link rel="stylesheet" href="<?php echo ASSETS ?>css/style.css" />
</head>
<body>
	<!-- DEBUT du header -->
	<header id="header">
		<div class="inner">
			<!-- DEBUT de la topbar -->
			<section id="topbar">
				<div class="inner">
					<p>Bienvenue dans l'installation de WEBCrafted</p>
				</div>
			</section>
			<!-- FIN de la topbar -->

			<!-- DEBUT de la description -->
			<section id="description">
				<div class="inner">
					<img id="logo" src="<?php echo ASSETS ?>images/logo.png" alt="webcrafted" />
					<h1>{page.title}</h1>
					<h2>{page.description}</h2>
					<div class="clear">
				</div>
			</section>
			<!-- FIN de la description -->
		</div>
	</header>
	<!-- FIN du header -->

	<!-- DEBUT du container principal -->
	<section id="content">
		<div class="inner">
			<!-- DEBUT des étapes -->
			<section id="steps">
				<ul>
					<li<?php if(isset($params[0]) AND $params[0] == "requirements"): ?> class="current"<?php endif; ?>>Etape 1</li>
					<li<?php if(isset($params[0]) AND $params[0] == "database"): ?> class="current"<?php endif; ?>>Etape 2</li>
					<li<?php if(isset($params[0]) AND $params[0] == "options"): ?> class="current"<?php endif; ?>>Etape 3</li>
					<li<?php if(isset($params[0]) AND $params[0] == "jsonapi"): ?> class="current"<?php endif; ?>>Etape 4</li>
					<li<?php if(isset($params[0]) AND $params[0] == "shop"): ?> class="current"<?php endif; ?>>Etape 5</li>
					<li<?php if(isset($params[0]) AND $params[0] == "admin"): ?> class="current"<?php endif; ?>>Etape 6</li>
				</ul>
			</section>
			<!-- FIN des étapes -->

			<!-- DEBUT du container des boîtes -->
			<section id="blocks-container">
				<?php echo getFlash() ?>

				{page.content}
			</section>
			<!-- FIN du container des boîtes -->

			<div class="clear"></div>
		</div>
	</section>
	<!-- FIN du container principal -->

	<!-- DEBUT du footer -->
	<footer id="footer">
	</footer>
	<!-- FIN du footer -->

	<?php if(isset($page["js"])): ?>{page.js}<?php endif; ?>
</body>
</html>