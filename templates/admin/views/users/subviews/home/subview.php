		<section id="wrap">
			<table id="home">
				<thead>
					<tr>
						<th>Pseudo</th>
						<th>Inscription</th>
						<th>Dernière connexion</th>
						<th>Groupe</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<form id="admin" method="post" action="<?php echo WEBROOT ?>actions/users/admin">
						<input id="token" name="token" type="hidden" value="{session.token}" />
						<?php foreach($users as $k => $v): ?>
						<tr>
							<td><?php echo $v["username"] ?></td>
							<td><?php echo TimeUtils::getTimeDiff($v["signup_date"]) ?></td>
							<td><?php echo TimeUtils::getTimeDiff($v["last_login_date"]) ?></td>
							<td><?php echo $v["group_id"]["name"] ?></td>
							<td>
								<a href="<?php echo TLINK ?>users/edit/<?php echo $v["id"] ?>"><img src="<?php echo ASSETS ?>images/edit.png" alt="Éditer" /></a>
								<a href="#" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer l\'utilisateur <?php echo $v["username"] ?> ?')) window.location.replace('<?php echo WEBROOT ?>actions/users/delete/<?php echo $v["id"] ?>/?token={session.token}')"><img src="<?php echo ASSETS ?>images/delete.png" alt="Supprimer" /></a>
							</td>
						</tr>
						<?php endforeach; ?>
					</form>
				</tbody>
			</table>
			<a class="btn btn-table" href="<?php echo TLINK ?>widgets/create">Sauvegarder</a>
			<div class="pagination">
				<ul>
					<?php for($i = 1; $i < $count_pages; $i++): ?>
					<li><a href="<?php echo TLINK ?>users/home/<?php echo $i ?>"><?php echo $i ?></a></li>
					<?php endfor; ?>
				</ul>
			</div>
		</section>