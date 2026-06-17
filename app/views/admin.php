<?php /** @var array $users */ ?>
<section class="panel">
	<h1 class="panel__title">👑 Administration <span class="panel__count"><?= count($users) ?> utilisateurs</span></h1>
	<p class="space__hint">Liste des comptes enregistrés.</p>

	<?php if ($users): ?>
		<div class="table-wrap">
			<table class="table">
				<thead>
					<tr>
						<th>Prénom</th>
						<th>Nom</th>
						<th>Email</th>
						<th>Rôle</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($users as $u): ?>
						<tr>
							<td><?= val($u->firstname) ?></td>
							<td><?= val($u->name) ?></td>
							<td><?= e($u->mail) ?></td>
							<td><span class="badge"><?= e($u->role) ?></span></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	<?php else: ?>
		<p class="empty">Aucun utilisateur.</p>
	<?php endif; ?>
</section>
