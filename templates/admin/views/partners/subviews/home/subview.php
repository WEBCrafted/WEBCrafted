		<section id="wrap">
			<table id="home">
				<thead>
					<tr>
						<th>Créateur</th>
						<th>Dernier éditeur</th>
						<th>Nom</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($partners as $k => $v): ?>
					<tr>
						<td><?php echo $v["creator_id"]["username"] ?></td>
						<td><?php echo $v["last_editor_id"]["username"] ?></td>
						<td><?php echo $v["name"] ?></td>
						<td>
							<a href="<?php echo TLINK ?>partners/edit/<?php echo $v["id"] ?>"><img src="<?php echo ASSETS ?>images/edit.png" alt="Éditer" /></a>
							<a href="#" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer le partenaire N°<?php echo $v["id"] ?> ?')) window.location.replace('<?php echo WEBROOT ?>actions/partners/delete/<?php echo $v["id"] ?>/?token={session.token}')"><img src="<?php echo ASSETS ?>images/delete.png" alt="Supprimer" /></a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<a class="btn btn-table" href="<?php echo TLINK ?>partners/add">Ajouter un partenaire</a>
			<div class="pagination">
				<ul>
					<?php for($i = 1; $i < $count_pages; $i++): ?>
					<li><a href="<?php echo TLINK ?>partners/home/<?php echo $i ?>"><?php echo $i ?></a></li>
					<?php endfor; ?>
				</ul>
			</div>
		</section>