		<section id="wrap">
			<form method="post" action="<?php echo WEBROOT ?>actions/posts/edit" enctype="multipart/form-data">
				<input id="id" name="id" type="hidden" value="{post.id}" />
				<input id="token" name="token" type="hidden" value="{session.token}" />
				<fieldset id="upload">
					<input id="image" name="image" type="file" />
					<img src="<?php echo ASSETS ?>images/upload.png" />
				</fieldset>
				<fieldset>
					<h2 for="title">Titre de l'article</h2>
					<input id="title" name="title" type="text" placeholder="Rentrez votre titre ici" value="{post.title}" />
				</fieldset>
				<fieldset>
					<h2 for="content">Contenu de votre actualité</h2>
					<textarea id="content" class="ckeditor" name="content" placeholder="Rentrez le contenu de votre actualité ici">{post.content}</textarea>
				</fieldset>
				<fieldset>
					<h2 for="tags">Propriétés de votre actualité</h2>
					<p>Choisissez votre catégorie</p>
					<?php for($i = 0; $i < count($categories); $i++): $category = $categories[$i]; ?>
					<input id="category<?php echo $i ?>" name="category_id" type="radio" value="<?php echo $category["id"] ?>"<?php if($post["category_id"] == $category["id"]): ?> checked<?php endif; ?> /><label for="category<?php echo $i ?>"><?php echo $category["name"] ?></label>
					<?php endfor; ?>
					<p>Rentrez les tags associés au contenu, séparez les par une virgule</p>
					<textarea id="tags" name="tags">{post.tags}</textarea>
					<input id="comments" name="comments" type="checkbox"<?php if($post["comments"]): ?> checked<?php endif; ?> /><label for="comments">Autoriser les commentaires</label>
				</fieldset>
				<fieldset>
					<h2 for="tags">Finalisez l'édition de votre actualité</h2>
					<input class="btn btn-success" name="submit" type="submit" value="Publier">
					<input class="btn btn-primary" name="submit" type="submit" value="Sauvegarder">
				</fieldset>
			</form>
		</section>
<?php $_page->script() ?>
<script src="<?php echo ASSETS ?>js/ckeditor/ckeditor.js"></script>
<?php $_page->endscript() ?>