<?php /** @var string $flash ; @var array $old */ ?>
<section class="auth">
	<div class="auth__card">
		<h1 class="auth__title">Inscription</h1>
		<p class="auth__subtitle">Créez votre compte Geoworld.</p>

		<?php if (!empty($flash)): ?>
			<p class="auth__error" role="alert"><?= e($flash) ?></p>
		<?php endif; ?>

		<form method="post" action="index.php" class="form">
			<input type="hidden" name="action" value="register">
			<input type="hidden" name="csrf" value="<?= e(gw_csrf_token()) ?>">

			<div class="form__row">
				<label class="form__field">
					<span>Prénom</span>
					<input type="text" name="firstname" required value="<?= e($old['firstname'] ?? '') ?>">
				</label>
				<label class="form__field">
					<span>Nom</span>
					<input type="text" name="name" required value="<?= e($old['name'] ?? '') ?>">
				</label>
			</div>

			<label class="form__field">
				<span>Email</span>
				<input type="email" name="mail" required value="<?= e($old['mail'] ?? '') ?>"
					placeholder="vous@exemple.com">
			</label>

			<div class="form__row">
				<label class="form__field">
					<span>Mot de passe</span>
					<input type="password" name="password" required minlength="4" placeholder="••••••••">
				</label>
				<label class="form__field">
					<span>Confirmation</span>
					<input type="password" name="confirm" required minlength="4" placeholder="••••••••">
				</label>
			</div>

			<button type="submit" class="btn btn--primary btn--block">Créer mon compte</button>
		</form>

		<p class="auth__switch">Déjà inscrit ? <a href="index.php?page=login">Connectez-vous</a></p>
	</div>
</section>
