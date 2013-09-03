		<section id="wrap">
			<table id="home">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Prix</th>
						<th>Durée</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($items as $k => $v): ?>
					<tr>
						<td><?php echo $v["name"] ?></td>
						<td><?php echo $v["price"] ?></td>
						<td><?php if($v["duration"] == 2592000): ?>1 mois<?php elseif($v["duration"] == 86400): ?>1 jour<?php elseif($v["duration"] == 0): ?>Utilisation unique<?php else: ?><?php echo $v["duration"] ?> secondes<?php endif; ?></td>
						<td>
							<a href="<?php echo TLINK ?>shop/edit/<?php echo $v["id"] ?>"><img src="<?php echo ASSETS ?>images/edit.png" alt="Éditer" /></a>
							<a href="#" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer l\'offre N°<?php echo $v["id"] ?> ?')) window.location.replace('<?php echo WEBROOT ?>actions/shop/delete/<?php echo $v["id"] ?>/?token={session.token}')"><img src="<?php echo ASSETS ?>images/delete.png" alt="Supprimer" /></a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<a class="btn btn-table" href="<?php echo TLINK ?>shop/create">Créer une offre</a>
			<div class="pagination">
				<ul>
					<?php for($i = 1; $i < $count_pages; $i++): ?>
					<li><a href="<?php echo TLINK ?>shop/home/<?php echo $i ?>"><?php echo $i ?></a></li>
					<?php endfor; ?>
				</ul>
			</div>
		</section>