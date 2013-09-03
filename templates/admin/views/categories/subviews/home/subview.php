		<section id="wrap">
			<table id="home">
				<thead>
					<tr>
						<th>Créateur</th>
						<th>Nom</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($categories as $k => $v): ?>
					<tr>
						<td><?php echo $v["creator_id"]["username"] ?></td>
						<td><?php echo $v["name"] ?></td>
						<td>
							<a href="<?php echo TLINK ?>categories/edit/<?php echo $v["id"] ?>"><img src="<?php echo ASSETS ?>images/edit.png" alt="Éditer" /></a>
							<a href="#" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer la catégorie N°<?php echo $v["id"] ?> ?')) window.location.replace('<?php echo WEBROOT ?>actions/categories/delete/<?php echo $v["id"] ?>/?token={session.token}')"><img src="<?php echo ASSETS ?>images/delete.png" alt="Supprimer" /></a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<a class="btn btn-table" href="<?php echo TLINK ?>categories/create">Créer une catégorie</a>
			<div class="pagination">
				<ul>
					<?php for($i = 1; $i < $count_pages; $i++): ?>
					<li><a href="<?php echo TLINK ?>categories/home/<?php echo $i ?>"><?php echo $i ?></a></li>
					<?php endfor; ?>
				</ul>
			</div>
		</section>