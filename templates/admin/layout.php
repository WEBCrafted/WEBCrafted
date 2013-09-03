<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>{page.title} | Administration</title>
	<link rel="stylesheet" href="<?php echo ASSETS ?>css/style.css" />
</head>
<body>
	<!-- DEBUT du header -->
	<header id="header">
		<div class="inner">
			<!-- DEBUT de la topbar -->
			<section id="topbar">
				<div class="inner">
					<a href="#" onclick="if(confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) window.location.replace('<?php echo WEBROOT ?>actions/users/logout')"><img class="last" src="<?php echo ASSETS ?>images/logout.png" /></a>
					<img src="<?php echo ASSETS ?>images/profile.png" />
					<img src="<?php echo ASSETS ?>images/messages.png" />
					<p>Bienvenue, {session.username}</p>
					<div class="clear">
				</div>
			</section>
			<!-- FIN de la topbar -->

			<!-- DEBUT de la description -->
			<section id="description">
				<div class="inner">
					<a href="<?php echo WEBROOT ?>"><img id="logo" src="<?php echo ASSETS ?>images/logo.png" alt="WEBCrafted" /></a>
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
			<noscript>
				<div class="alert alert-error">
					<p>
						Pour une navigation fluide et fonctionnelle, merci d'activer JavaScript
					</p>
				</div>
			</noscript>

			<?php echo getFlash() ?>

			<!-- DEBUT de la navigation -->
			<nav id="navigation">
				<ul>
					<li<?php if(!isset($params[0]) OR $params[0] == "home"): ?> class="current"<?php endif; ?>><a href="<?php echo TLINK ?>">Tableau de bord</a></li>
					<?php if(in_array("webcrafted.admin.*", $_SESSION["group_id"]["permissions"]) OR in_array("webcrafted.admin.console", $_SESSION["group_id"]["permissions"])): ?><li<?php if(isset($params[0]) AND $params[0] == "manage"): ?> class="current"<?php endif; ?>><a href="<?php echo TLINK ?>manage">Gérer le serveur</a></li><?php endif; ?>
					<?php if(in_array("webcrafted.admin.*", $_SESSION["group_id"]["permissions"]) OR in_array("webcrafted.admin.users", $_SESSION["group_id"]["permissions"])): ?><li<?php if(isset($params[0]) AND $params[0] == "users"): ?> class="current"<?php endif; ?>><a href="<?php echo TLINK ?>users">Utilisateurs</a></li><?php endif; ?>
					<?php if(in_array("webcrafted.admin.*", $_SESSION["group_id"]["permissions"]) OR in_array("webcrafted.admin.groups", $_SESSION["group_id"]["permissions"])): ?><li<?php if(isset($params[0]) AND $params[0] == "groups"): ?> class="current"<?php endif; ?>><a href="<?php echo TLINK ?>groups">Groupes</a></li><?php endif; ?>
					<?php if(in_array("webcrafted.admin.*", $_SESSION["group_id"]["permissions"]) OR in_array("webcrafted.admin.posts", $_SESSION["group_id"]["permissions"])): ?><li<?php if(isset($params[0]) AND $params[0] == "posts"): ?> class="current"<?php endif; ?>><a href="<?php echo TLINK ?>posts">Actualités</a></li><?php endif; ?>
					<?php if(in_array("webcrafted.admin.*", $_SESSION["group_id"]["permissions"]) OR in_array("webcrafted.admin.categories", $_SESSION["group_id"]["permissions"])): ?><li<?php if(isset($params[0]) AND $params[0] == "categories"): ?> class="current"<?php endif; ?>><a href="<?php echo TLINK ?>categories">Catégories</a></li><?php endif; ?>
					<?php if(in_array("webcrafted.admin.*", $_SESSION["group_id"]["permissions"]) OR in_array("webcrafted.admin.pages", $_SESSION["group_id"]["permissions"])): ?><li<?php if(isset($params[0]) AND $params[0] == "pages"): ?> class="current"<?php endif; ?>><a href="<?php echo TLINK ?>pages">Pages</a></li><?php endif; ?>
					<?php if(in_array("webcrafted.admin.*", $_SESSION["group_id"]["permissions"]) OR in_array("webcrafted.admin.partners", $_SESSION["group_id"]["permissions"])): ?><li<?php if(isset($params[0]) AND $params[0] == "partners"): ?> class="current"<?php endif; ?>><a href="<?php echo TLINK ?>partners">Partenaires</a></li><?php endif; ?>
					<?php if(in_array("webcrafted.admin.*", $_SESSION["group_id"]["permissions"]) OR in_array("webcrafted.admin.widgets", $_SESSION["group_id"]["permissions"])): ?><li<?php if(isset($params[0]) AND $params[0] == "widgets"): ?> class="current"<?php endif; ?>><a href="<?php echo TLINK ?>widgets">Widgets</a></li><?php endif; ?>
					<?php if(in_array("webcrafted.admin.*", $_SESSION["group_id"]["permissions"]) OR in_array("webcrafted.admin.shop", $_SESSION["group_id"]["permissions"])): ?><li<?php if(isset($params[0]) AND $params[0] == "shop"): ?> class="current"<?php endif; ?>><a href="<?php echo TLINK ?>shop">Boutique</a></li><?php endif; ?>
					<?php if(in_array("webcrafted.admin.*", $_SESSION["group_id"]["permissions"]) OR in_array("webcrafted.admin.options", $_SESSION["group_id"]["permissions"])): ?><li class="<?php if(isset($params[0]) AND $params[0] == "options"): ?>current <?php endif; ?>last"><a href="<?php echo TLINK ?>options">Réglages</a></li><?php endif; ?>
				</ul>
			</nav>
			<!-- FIN de la navigation -->

			{page.content}

			<div class="clear"></div>
		</div>
	</section>
	<!-- FIN du container principal -->

	<!-- DEBUT du footer -->
	<footer id="footer">
	</footer>
	<!-- FIN du footer -->

	<?php if(isset($page["js"])): ?>{page.js}<?php endif; ?>
	<!--<script>
	if(navigator.userAgent.indexOf('MSIE')) {
		alert("Téléchargez un vrai navigateur");
		document.location.replace("http://www.mozilla.org/fr/firefox/new/");
	}
	</script>-->
</body>
</html>