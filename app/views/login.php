<?php /** @var string $flash ; @var array $old */ ?>
<section class="auth">
	<div class="auth__card">
		<h1 class="auth__title">Connexion</h1>
		<p class="auth__subtitle">Accédez à votre espace Geoworld.</p>

		<?php if (!empty($flash)): ?>
			<p class="auth__error" role="alert"><?= e($flash) ?></p>
		<?php endif; ?>

		<form method="post" action="index.php" class="form">
			<input type="hidden" name="action" value="login">
			<input type="hidden" name="csrf" value="<?= e(gw_csrf_token()) ?>">

			<label class="form__field">
				<span>Email</span>
				<input type="email" name="mail" required autofocus
					value="<?= e($old['mail'] ?? '') ?>" placeholder="vous@exemple.com">
			</label>

			<label class="form__field">
				<span>Mot de passe</span>
				<input type="password" name="password" required placeholder="••••••••">
			</label>

			<button type="submit" class="btn btn--primary btn--block">Se connecter</button>
		</form>

		<p class="auth__switch">Pas encore de compte ? <a href="index.php?page=register">Inscrivez-vous</a></p>
	</div>
</section>
