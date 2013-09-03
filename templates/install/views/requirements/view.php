			<div class="block block-large">
				<header>
					<h1>Vérification des dépendances</h1>
				</header>
				<div class="block-content">
					<div class="alert alert-<?php echo $phpversion ? "success" : "error" ?>">
						<p>
							<?php if($phpversion): ?>
							{phpversion_success}
							<?php else: ?>
							{phpversion_error}
							<?php endif; ?>
						</p>
					</div>
					<div class="alert alert-<?php echo $mod_rewrite ? "success" : "error" ?>">
						<p>
							<?php if($mod_rewrite): ?>
							{mod_rewrite_success}
							<?php else: ?>
							{mod_rewrite_error}
							<?php endif; ?>
						</p>
					</div>
					<div class="alert alert-<?php echo $is_writable ? "success" : "error" ?>">
						<p>
							<?php if($is_writable): ?>
							{is_writable_success}
							<?php else: ?>
							{is_writable_error}
							<?php endif; ?>
						</p>
					</div>
					<div class="alert alert-<?php echo $curl ? "success" : "error" ?>">
						<p>
							<?php if($curl): ?>
							{curl_success}
							<?php else: ?>
							{curl_error}
							<?php endif; ?>
						</p>
					</div>
					<?php if($install): ?>
					<div class="alert alert-success">
						<p>
							Le CMS peut être installé
						</p>
					</div>
					<a href="<?php echo TLINK ?>database" class="btn btn-success">Go !</a>
					<?php else: ?>
					<div class="alert alert-error">
						<p>
							Le CMS ne peut pas être installé
						</p>
					</div>
					<a href="http://bukkit.fr/index.php?threads/web-crafted-le-cms-minecraft.4138/" class="btn btn-error">Solutions</a>
					<?php endif; ?>
				</div>
			</div>
