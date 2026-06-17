<?php /** @var object $country ; @var array $cities ; @var array $languages */ ?>

<nav class="breadcrumb" aria-label="Fil d'Ariane">
	<a href="index.php">← Tous les pays</a>
</nav>

<header class="country-hero">
	<?php if ($flag = flag_url($country->Code2, 'w640')): ?>
		<img class="country-hero__flag" src="<?= e($flag) ?>"
			alt="Drapeau : <?= e($country->Name) ?>" width="320" height="213">
	<?php endif; ?>
	<div class="country-hero__text">
		<p class="country-hero__continent"><?= e($country->Continent) ?> · <?= e($country->Region) ?></p>
		<h1 class="country-hero__name"><?= e($country->Name) ?></h1>
		<?php if (trim((string) $country->LocalName) !== '' && $country->LocalName !== $country->Name): ?>
			<p class="country-hero__local"><?= e($country->LocalName) ?></p>
		<?php endif; ?>
	</div>
</header>

<section class="stats" aria-label="Statistiques clés">
	<div class="stat">
		<span class="stat__label">Capitale</span>
		<span class="stat__value"><?= val($country->Capital) ?></span>
	</div>
	<div class="stat">
		<span class="stat__label">Population</span>
		<span class="stat__value"><?= num($country->Population) ?></span>
	</div>
	<div class="stat">
		<span class="stat__label">Superficie</span>
		<span class="stat__value"><?= num($country->SurfaceArea) ?> km²</span>
	</div>
	<div class="stat">
		<span class="stat__label">Espérance de vie</span>
		<span class="stat__value"><?= $country->LifeExpectancy ? e($country->LifeExpectancy) . ' ans' : '—' ?></span>
	</div>
	<div class="stat">
		<span class="stat__label">Indépendance</span>
		<span class="stat__value"><?= val($country->IndepYear) ?></span>
	</div>
	<div class="stat">
		<span class="stat__label">PNB</span>
		<span class="stat__value"><?= num($country->GNP) ?> M$</span>
	</div>
</section>

<div class="detail-grid">

	<section class="panel">
		<h2 class="panel__title">Informations</h2>
		<dl class="info">
			<div><dt>Code ISO</dt><dd><?= val($country->Code) ?> / <?= val($country->Code2) ?></dd></div>
			<div><dt>Forme de gouvernement</dt><dd><?= val($country->GovernmentForm) ?></dd></div>
			<div><dt>Chef de l'État</dt><dd><?= val($country->HeadOfState) ?></dd></div>
		</dl>
	</section>

	<?php if ($languages): ?>
	<section class="panel">
		<h2 class="panel__title">Langues <span class="panel__count"><?= count($languages) ?></span></h2>
		<ul class="langs">
			<?php foreach ($languages as $lang): ?>
				<li class="lang">
					<div class="lang__head">
						<span class="lang__name">
							<?= e($lang->language) ?>
							<?php if ($lang->IsOfficial === 'T'): ?>
								<span class="lang__official" title="Langue officielle">officielle</span>
							<?php endif; ?>
						</span>
						<span class="lang__pct"><?= e($lang->Percentage) ?> %</span>
					</div>
					<div class="lang__bar"><span style="width: <?= e(min(100, (float) $lang->Percentage)) ?>%"></span></div>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>
	<?php endif; ?>

</div>

<?php if ($cities): ?>
<section class="panel">
	<h2 class="panel__title">Villes principales <span class="panel__count"><?= count($cities) ?></span></h2>
	<div class="table-wrap">
		<table class="table">
			<thead>
				<tr>
					<th>Ville</th>
					<th>District</th>
					<th class="num">Population</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($cities as $city): ?>
					<tr>
						<td><?= e($city->Name) ?></td>
						<td><?= val($city->District) ?></td>
						<td class="num"><?= num($city->Population) ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</section>
<?php endif; ?>
