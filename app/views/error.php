<?php /** @var string $errorDetail */ ?>
<section class="message">
	<div class="message__emoji">⚠️</div>
	<h1>Service momentanément indisponible</h1>
	<p>Impossible de joindre la base de données pour l'instant. Merci de réessayer plus tard.</p>
	<?php if (!empty($errorDetail)): ?>
		<pre class="message__detail"><?= e($errorDetail) ?></pre>
	<?php endif; ?>
	<a class="btn" href="index.php">↻ Réessayer</a>
</section>
