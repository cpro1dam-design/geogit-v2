<?php /** @var array $queries ; @var string $spaceTitle ; @var string $spaceHint */ ?>
<section class="panel">
	<h1 class="panel__title"><?= e($spaceTitle) ?> <span class="panel__count"><?= count($queries) ?></span></h1>
	<p class="space__hint"><?= e($spaceHint) ?></p>

	<?php if ($queries): ?>
		<div class="table-wrap">
			<table class="table">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Requête</th>
						<th>Statut</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($queries as $q): ?>
						<tr>
							<td><?= val($q->query_name) ?></td>
							<td><code><?= e($q->query_data) ?></code></td>
							<td><span class="badge"><?= val($q->query_statut) ?></span></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	<?php else: ?>
		<p class="empty">Aucune requête pour le moment.</p>
	<?php endif; ?>
</section>
