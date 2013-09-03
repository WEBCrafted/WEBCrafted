		<section id="wrap">
			<form method="post" action="<?php echo WEBROOT ?>actions/posts/create" enctype="multipart/form-data">
				<input id="token" name="token" type="hidden" value="{session.token}" />
				<fieldset id="upload">
					<input id="image" name="image" type="file" required />
					<img src="<?php echo ASSETS ?>images/upload.png" />
				</fieldset>
				<fieldset>
					<h2 for="title">Titre de l'article</h2>
					<input id="title" name="title" type="text" placeholder="Rentrez votre titre ici" />
				</fieldset>
				<fieldset>
					<h2 for="content">Contenu de votre actualité</h2>
					<textarea id="content" class="ckeditor" name="content" placeholder="Rentrez le contenu de votre actualité ici"></textarea>
				</fieldset>
				<fieldset>
					<h2 for="tags">Propriétés de votre actualité</h2>
					<p>Choisissez votre catégorie</p>
					<?php for($i = 0; $i < count($categories); $i++): $category = $categories[$i]; ?>
					<input id="category<?php echo $i ?>" name="category_id" type="radio" value="<?php echo $category["id"] ?>" /><label for="category<?php echo $i ?>"><?php echo $category["name"] ?></label>
					<?php endfor; ?>
					<p>Rentrez les tags associés au contenu, séparez les par une virgule</p>
					<textarea id="tags" name="tags"></textarea>
					<input id="comments" name="comments" type="checkbox" checked /><label for="comments">Autoriser les commentaires</label>
				</fieldset>
				<fieldset>
					<h2 for="tags">Finalisez la création de votre actualité</h2>
					<input class="btn btn-success" name="submit" type="submit" value="Publier">
					<input class="btn btn-primary" name="submit" type="submit" value="Sauvegarder">
				</fieldset>
			</form>
		</section>
<?php $_page->script() ?>
<script src="<?php echo ASSETS ?>js/ckeditor/ckeditor.js"></script>
<?php $_page->endscript() ?>