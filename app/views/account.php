<?php /** @var array|null $user (via gw_current_user) */ $user = gw_current_user(); ?>
<section class="auth">
	<div class="auth__card">
		<div class="account__avatar" aria-hidden="true"><?= e(strtoupper(substr($user['firstname'] ?: $user['name'], 0, 1))) ?></div>
		<h1 class="auth__title"><?= e(trim($user['firstname'] . ' ' . $user['name'])) ?></h1>
		<p class="auth__subtitle">Votre espace Geoworld</p>

		<dl class="account__info">
			<div><dt>Email</dt><dd><?= e($user['mail']) ?></dd></div>
			<div><dt>Rôle</dt><dd><span class="badge"><?= e($user['role']) ?></span></dd></div>
		</dl>

		<div class="account__actions">
			<a class="btn btn--ghost" href="index.php">← Retour à l'accueil</a>
			<form method="post" action="index.php">
				<input type="hidden" name="action" value="logout">
				<button type="submit" class="btn btn--primary">Déconnexion</button>
			</form>
		</div>
	</div>
</section>
