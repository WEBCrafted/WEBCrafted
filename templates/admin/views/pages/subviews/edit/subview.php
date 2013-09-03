		<section id="wrap">
			<form method="post" action="<?php echo WEBROOT ?>actions/pages/edit">
				<input id="id" name="id" type="hidden" value="{post.id}" />
				<input id="token" name="token" type="hidden" value="{session.token}" />
				<fieldset>
					<h2 for="title">Titre de la page</h2>
					<input id="title" name="title" type="text" placeholder="Rentrez votre titre ici" value="{post.title}" />
				</fieldset>
				<fieldset>
					<h2 for="redirect">Redirection de la page</h2>
					<input id="redirect" name="redirect" type="checkbox"<?php if(strpos($post["slug"], "http://") !== false): ?> checked<?php endif; ?> /><label for="redirect">Votre page doit rediriger vers un lien ?</label>
				</fieldset>
				<fieldset<?php if(strpos($post["slug"], "http://") === false): ?> style="display: none;"<?php endif; ?>>
					<h2 for="slug">URL de la page</h2>
					<input id="slug" name="slug" type="url" placeholder="Rentrez l'url vers laquelle rediriger ici"<?php if(strpos($post["slug"], "http://") !== false): ?> value="{post.slug}"<?php endif; ?> />
				</fieldset>
				<fieldset<?php if(strpos($post["slug"], "http://") !== false): ?> style="display: none;"<?php endif; ?>>
					<h2 for="content">Contenu de votre page</h2>
					<textarea id="content" class="ckeditor" name="content" placeholder="Rentrez le contenu de votre page ici">{post.content}</textarea>
				</fieldset>
				<fieldset<?php if(strpos($post["slug"], "http://") !== false): ?> style="display: none;"<?php endif; ?>>
					<h2 for="tags">Propriétés de votre page</h2>
					<p>Choisissez votre catégorie</p>
					<?php for($i = 0; $i < count($categories); $i++): $category = $categories[$i]; ?>
					<input id="category<?php echo $i ?>" name="category_id" type="radio" value="<?php echo $category["id"] ?>"<?php if($post["category_id"] == $category["id"]): ?> checked<?php endif; ?> /><label for="category<?php echo $i ?>"><?php echo $category["name"] ?></label>
					<?php endfor; ?>
					<p>Rentrez les tags associés au contenu, séparez les par une virgule</p>
					<textarea id="tags" name="tags">{post.tags}</textarea>
				</fieldset>
				<fieldset>
					<h2>Finalisez la création de votre page</h2>
					<input class="btn btn-success" name="submit" type="submit" value="Publier">
					<input class="btn btn-primary" name="submit" type="submit" value="Sauvegarder">
				</fieldset>
			</form>
		</section>
<?php $_page->script() ?>
<script src="<?php echo ASSETS ?>js/jquery-2.0.3.min.js"></script>
<script src="<?php echo ASSETS ?>js/ckeditor/ckeditor.js"></script>
<script>
	$("#redirect").change(function(event) {
		if(event.currentTarget.checked) {
			$('#content[name="content"]').parent().css("display", "none");
			$("#tags").parent().css("display", "none");
			$("#slug").parent().css("display", "block");
		}
		else {
			$("#slug").parent().css("display", "none");
			$('#content[name="content"]').parent().css("display", "block");
			$("#tags").parent().css("display", "block");
		}
	});
</script>
<?php $_page->endscript() ?>