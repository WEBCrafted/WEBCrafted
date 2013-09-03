		<section id="wrap">
			<form method="post" action="<?php echo WEBROOT ?>actions/widgets/edit">
				<input id="id" name="id" type="hidden" value="{widget.id}" />
				<input id="token" name="token" type="hidden" value="{session.token}" />
				<fieldset>
					<h2 for="title">Titre du widget</h2>
					<input id="title" name="title" type="text" placeholder="Rentrez le nom ici" value="{widget.title}" />
				</fieldset>
				<fieldset>
					<h2 for="content">Contenu de votre widget</h2>
					<textarea id="content" class="ckeditor" name="content" placeholder="Rentrez le contenu de votre widget ici">{widget.content}</textarea>
				</fieldset>
				<fieldset>
					<h2 for="tags">Propriétés de votre widget</h2>
					<input id="hidden" name="hidden" type="checkbox"<?php if($widget["hidden"]): ?> checked<?php endif; ?> /><label for="hidden">Cacher le widget</label>
				</fieldset>
				<input class="btn btn-success" name="submit" type="submit" value="Sauvegarder">
			</form>
		</section>
<?php $_page->script() ?>
<script src="<?php echo ASSETS ?>js/ckeditor/ckeditor.js"></script>
<?php $_page->endscript() ?>