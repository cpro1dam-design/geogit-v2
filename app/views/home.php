<?php /** @var array $countries ; @var array $continents */ ?>

<section class="hero">
	<h1 class="hero__title">Explorez le monde</h1>
	<p class="hero__subtitle"><?= count($countries) ?> pays · capitales, villes et langues à portée de clic.</p>

	<div class="searchbar">
		<svg class="searchbar__icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 21l-4.35-4.35M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16z" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
		<input id="search" type="search" placeholder="Rechercher un pays ou une capitale…"
			autocomplete="off" aria-label="Rechercher un pays">
	</div>
</section>

<nav class="filters" aria-label="Filtrer par continent">
	<button class="chip is-active" data-continent="">Tous</button>
	<?php foreach ($continents as $continent): ?>
		<button class="chip" data-continent="<?= e($continent) ?>"><?= e($continent) ?></button>
	<?php endforeach; ?>
</nav>

<p id="resultCount" class="result-count" aria-live="polite"></p>

<div id="grid" class="grid">
	<?php foreach ($countries as $c): ?>
		<a class="card"
			href="<?= e(country_url((int) $c->id)) ?>"
			data-name="<?= e(mb_strtolower($c->Name)) ?>"
			data-capital="<?= e(mb_strtolower((string) $c->Capital)) ?>"
			data-continent="<?= e($c->Continent) ?>">
			<div class="card__flag">
				<?php if ($flag = flag_url($c->Code2)): ?>
					<img src="<?= e($flag) ?>" alt="Drapeau : <?= e($c->Name) ?>"
						loading="lazy" width="320" height="213">
				<?php else: ?>
					<span class="card__flag-fallback">🏳️</span>
				<?php endif; ?>
			</div>
			<div class="card__body">
				<h2 class="card__name"><?= e($c->Name) ?></h2>
				<p class="card__meta">
					<span class="card__capital"><?= val($c->Capital) ?></span>
				</p>
				<span class="card__badge"><?= e($c->Continent) ?></span>
			</div>
		</a>
	<?php endforeach; ?>
</div>

<p id="empty" class="empty" hidden>Aucun pays ne correspond à votre recherche.</p>
