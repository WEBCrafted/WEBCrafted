		<?php echo getFlash() ?>

		<?php if(!empty($posts)): ?>
		<section id="slider">
			<?php foreach($posts as $k => $v): ?>
			<img src="<?php echo THUMBS ?>posts/<?php echo $v["id"] ?>_970x285.<?php echo $v["image"]["ext"] ?>" title="#post-<?php echo $k ?>-caption" />
			<?php endforeach; ?>
		</section>
			<?php foreach($posts as $k => $v): ?>
		<div id="post-<?php echo $k ?>-caption" class="nivo-html-caption">
			<h1><?php echo $v["title"] ?></h1>
			<p><?php echo TextUtils::extract($v["extract"], 270) ?></p>
			<a href="<?php echo TLINK ?>post/<?php echo $v["id"] ?>">Lire la <span>suite</span></a>
		</div>
			<?php endforeach; ?>
		<?php endif; ?>

		<section id="posts-container">
			<h1>Dernières actualités</h1>
			<?php foreach($posts as $k => $v): ?>
			<div class="post">
				<img src="<?php echo THUMBS ?>posts/<?php echo $v["id"] ?>_190x190.<?php echo $v["image"]["ext"] ?>" />
				<div class="post-content"> 
					<header>
						<h1><a href="<?php echo TLINK ?>post/<?php echo $v["id"] ?>"><?php echo $v["title"] ?></a></h1>
					</header>
					<p><?php echo $v["extract"] ?></p>
					<a class="more" href="<?php echo TLINK ?>post/<?php echo $v["id"] ?>"><span class="gray">[+]</span> Lire la suite</a>
				</div>
			</div>
			<?php endforeach; ?>
		</section>

		<?php echo element("sidebar") ?>
<?php $_page->script() ?>
<script src="<?php echo ASSETS ?>js/jquery-2.0.3.min.js"></script>
<script src="<?php echo ASSETS ?>js/jquery.nivo.slider.js"></script>
<script>
$(function() {
	$("#slider").nivoSlider({
		effect: "random",
		pauseOnHover: true,
		controlNav: false,
		directionNav: false,
	});
});
</script>
<?php $_page->endscript() ?>