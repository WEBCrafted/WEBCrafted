		<section id="wrap">
			<h1>{post.title}</h1>

			<?php echo getFlash() ?>

			<div id="post">
				<header>
					<img src="<?php echo THUMBS ?>posts/<?php echo $post["id"] ?>_664x211.<?php echo $post["image"]["ext"] ?>" />
				</header>
				<div id="post-content">
					{post.content}
					<p id="author">de {post.creator_id.username}</p>
					<div class="clear"></div>
				</div>
			</div>
			<?php if(!$post["comments"]): ?>
			<h1><?php echo count($comments) ?> commentaire{plural.comments}</h1>
			<section id="comments-container">
				<form>
					<textarea id="message" name="message" rows="5" placeholder="Les commentaires sont désactivés sur cette actualité" disabled></textarea>
					<input class="btn btn-primary" type="submit" value="Commenter" disabled />
				</form>
			</section>
			<?php else: ?>
			<h1><?php echo count($comments) ?> commentaire{plural.comments}</h1>
			<section id="comments-container">
				<form method="post" action="<?php echo WEBROOT ?>actions/comments/add">
					<input id="token" name="token" type="hidden" value="{session.token}" />
					<input id="post_id" name="post_id" type="hidden" value="{post.id}" />
					<textarea id="message" name="message" rows="5"<?php if(!isset($_SESSION["isLogged"]) OR !$_SESSION["isLogged"]): ?> placeholder="Vous devez être connecté pour pouvoir poster un commentaire" disabled<?php else: ?> placeholder="Qu'en pensez vous ?"<?php endif; ?>></textarea>
					<input class="btn btn-success" type="submit" value="Commenter" />
				</form>
				<?php foreach($comments as $k => $v): ?>
				<div class="comment">
					<div class="comment-content">
						<div class="left">
							<img src="https://minotar.net/helm/<?php echo $v["creator_id"]["username"] ?>/70.png" alt="avatar" />
						</div>
						<div class="right">
							<h2><?php echo $v["creator_id"]["username"] ?></h2>
							<p><?php echo $v["content"] ?></p>
						</div>
						<div class="clear"></div>
					</div>
				</div>
				<?php endforeach; ?>
			</section>
			<?php endif; ?>
		</section>

		<?php echo element("sidebar") ?>