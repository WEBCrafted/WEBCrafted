<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>{page.title} | {page.name}</title>
	<meta name="description" content="{page.description}" />
	<meta name="keywords" content="{page.keywords}" />
	<?php if(isset($params[0]) AND ($params[0] == "login" OR $params[0] == "forgotpass")): ?>
	<link rel="stylesheet" href="<?php echo ASSETS ?>css/login.css" />
	<?php elseif(isset($params[0]) AND $params[0] == "signup"): ?>
	<link rel="stylesheet" href="<?php echo ASSETS ?>css/signup.css" />
	<?php else: ?>
	<link rel="stylesheet" href="<?php echo ASSETS ?>css/style.css" />
	<link rel="stylesheet" href="<?php echo ASSETS ?>css/nivo-slider.css" />
	<?php endif; ?>
</head>
<body>
	<?php if(!isset($params[0]) OR ($params[0] != "login" AND $params[0] != "signup" AND $params[0] != "forgotpass")): ?>
	<!-- DEBUT du header -->
	<header id="header">
		<div class="inner">
			<div id="description" class="left">
				<h1>{page.name}</h1>
				<h2>{page.slogan}</h2>
			</div>
			<div id="signup" class="right">
				<ul>
					<?php if(isset($_SESSION["isLogged"]) AND $_SESSION["isLogged"]): ?>
					<li><a href="<?php if(!$admin): ?>#<?php else: ?><?php echo TLINK ?>admin<?php endif; ?>">{session.username}</a></li>
					<li>
					<a href="#" onclick="if(confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) window.location.replace('<?php echo WEBROOT ?>actions/users/logout')">Déconnexion</a></li>
					<?php else: ?>
					<li><a href="<?php echo TLINK ?>login">Connexion</a></li>
					<li><a href="<?php echo TLINK ?>signup">Inscription</a></li>
					<?php endif; ?>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
	</header>
	<!-- FIN du header -->

	<!-- DEBUT de la navigation -->
	<nav id="navigation">
		<div class="inner">
			<ul>
				<li><a href="<?php echo TLINK ?>home">Accueil</a></li>
				<?php foreach($pages as $k => $v): ?>
				<li><a href="<?php if(strpos($v["slug"], "http://") !== false): ?><?php echo $v["slug"] ?><?php else: ?><?php echo TLINK ?>page/<?php echo $v["id"] ?><?php endif; ?>"><?php echo $v["title"] ?></a></li>
				<?php endforeach; ?>
				<?php if($options["shop_use"]): ?>
				<li><a href="<?php echo TLINK ?>shop">Boutique</a></li>
				<?php endif; ?>
			</ul>
		</div>
	</nav>
	<!-- FIN de la navigation -->
	<?php endif; ?>

	<!-- DEBUT du container principal -->
	<section id="content">
		<div class="inner">
			{page.content}

			<div class="clear"></div>
		</div>
	</section>
	<!-- FIN du container principal -->


	<?php if(!isset($params[0]) OR ($params[0] != "login" AND $params[0] != "signup" AND $params[0] != "forgotpass")): ?>
	<!-- DEBUT du footer -->
	<footer id="footer">
		<div class="inner">
			<section id="comments-container">
				<header>
					<h1 class="center">Derniers commentaires</h1>
				</header>
				<?php foreach($lastcomments as $k => $v): ?>
				<div class="comment">
					<div class="comment-content">
						<div class="left">
							<img src="https://minotar.net/helm/<?php echo $v["creator_id"]["username"] ?>/70.png" alt="avatar" />
						</div>
						<div class="right">
							<h2><?php echo $v["creator_id"]["username"] ?></h2>
							<p><?php echo TextUtils::extract($v["content"], 315) ?></p>
						</div>
					</div>
					<footer>
						<div class="left">
							<h2><a href="<?php echo TLINK ?>post/<?php echo $v["post_id"] ?>">>> Voir l'actualité concernée</a></h2>
						</div>
						<div class="right">
							<h2><?php echo TimeUtils::getTimeDiff($v["date_created"]) ?></h2>
						</div>
					</footer>
				</div>
				<?php endforeach; ?>
			</section>
			<section id="partners">
				<header>
					<h1>Partenaires</h1>
				</header>
				<ul>
					<?php foreach($partners as $k => $v): ?>
					<li><a href="<?= $v["url"] ?>"><img src="<?= WEBROOT ?>templates/commons/uploads/partners/<?= $v["id"] ?>.<?= $v["image"]["ext"] ?>" /></a></li>
					<?php endforeach; ?>
				</ul>
			</section>
			<div class="clear"></div>
		</div>
	</footer>
	<!-- FIN du footer -->
	<?php endif; ?>

	<?php if(isset($page["js"])): ?>{page.js}<?php endif; ?>
</body>
</html>