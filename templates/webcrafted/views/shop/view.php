		<section id="shop">
			<h1>Boutique</h1>
			<?php if(!isset($_SESSION["isLogged"]) OR !$_SESSION["isLogged"]): ?>
			<div class="alert alert-error">
				<p>
					Vous devez être connecté pour pouvoir accèder à la boutique
				</p>
			</div>
			<?php else: echo getFlash(); ?>
			<div id="wallet">
				<div class="inner">
					<div id="player_info">
						<img src="https://minotar.net/helm/{session.username}/79.png" alt="avatar" />
						<h2>{session.username}</h2>
						<div id="emerald_big">
							<h3>{session.money}</h3>
							<h4>émeraude<?php echo $_SESSION["money"] > 1 ? "s" : "" ?></h4>
							<a href="<?php echo TLINK ?>emeralds">acheter des émeraudes</a>
						</div>
					</div>
					<div id="wallet_summary">
						<h3>Panier</h3>
						<?php if(!isset($_SESSION["basket"]) OR empty($_SESSION["basket"])): ?>
						<ul>
							<li><p>Votre panier est vide</p></li>
						</ul>
						<?php else: ?>
						<ul>
							<?php foreach($_SESSION["basket"] as $k => $v): ?>
							<li><h5><?php echo $v["price"] ?></h5><img src="<?php echo ASSETS ?>images/emerald.png" /><p><?php echo $v["name"] ?></p></li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>
					</div>
					<div id="wallet_total">
						<h3>Total</h3>
						<img src="<?php echo ASSETS ?>images/emerald_total.png" />
						<h4>{totalprice} émeraude{plural.totalprice}</h4>
					</div>
					<div class="clear"></div>
				</div>
				<a id="wallet_pay"<?php if(isset($_SESSION["basket"]) AND !empty($_SESSION["basket"])): ?> class="active" onclick="if(confirm('Êtes-vous sûr de vouloir recevoir votre panier en échange de {totalprice} émeraude{plural.totalprice} ?')) window.location.replace('<?php echo WEBROOT ?>actions/basket/checkout/?token={session.token}')"<?php endif; ?>></a>
			</div>
			<div class="clear"></div>
			<div id="blocks-container">
				<h2>Articles en vente</h2>
				<?php foreach($items as $k => $v): ?>
				<div class="block">
					<header>
						<img src="<?php echo $v["image_url"] ?>" />
					</header>
					<div class="block-content">
						<h4><?php echo $v["name"] ?></h4>
						<ul>
							<li><?php echo $v["price"] ?><img src="<?php echo ASSETS ?>images/emerald.png" /></li>
							<li><img src="<?php echo ASSETS ?>images/clock.png" /> <?php if($v["duration"] == 2592000): ?>1 mois<?php elseif($v["duration"] == 86400): ?>1 jour<?php elseif($v["duration"] == 0): ?>Utilisation unique<?php else: ?><?php echo $v["duration"] ?> secondes<?php endif; ?></li>
						</ul>
					</div>
					<footer>
						<a href="<?php echo WEBROOT ?>actions/basket/add/<?php echo $v["id"] ?>/?token={session.token}"></a>
					</footer>
				</div>
				<?php endforeach; ?>
			</div>
			<nav id="sortby">
				<h2>Catégories</h2>
				<ul>
					<?php foreach($categories as $k => $v): ?>
					<li><a href="<?php echo TLINK ?>shop/?category=<?php echo $v["category"] ?>"><?php echo $v["category"] ?></a></li>
					<?php endforeach; ?>
				</ul>
				<h2>Trier par</h2>
				<ul>
					<li><a href="<?php echo TLINK ?>shop/?sortby=name">Nom</a></li>
					<li><a href="<?php echo TLINK ?>shop/?sortby=price">Prix le moins cher</a></li>
					<li><a href="<?php echo TLINK ?>shop/?sortby=maxprice">Prix le plus cher</a></li>
					<li><a href="<?php echo TLINK ?>shop/?sortby=duration">Durée d'utilisation</a></li>
				</ul>
			</div>
			<?php endif; ?>
		</section>