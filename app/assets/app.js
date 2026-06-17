/* =========================================================
   Geoworld — interactions
   - Bascule thème clair/sombre (mémorisée)
   - Recherche instantanée + filtre par continent
   ========================================================= */
(() => {
	'use strict';

	/* ---------- Thème clair / sombre ---------- */
	const root = document.documentElement;
	const toggle = document.getElementById('themeToggle');

	const applyTheme = (theme) => {
		root.dataset.theme = theme;
		if (toggle) {
			toggle.querySelector('.theme-toggle__icon').textContent = theme === 'dark' ? '☀️' : '🌙';
		}
	};

	const saved = localStorage.getItem('gw-theme');
	const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
	applyTheme(saved || (prefersDark ? 'dark' : 'light'));

	toggle?.addEventListener('click', () => {
		const next = root.dataset.theme === 'dark' ? 'light' : 'dark';
		applyTheme(next);
		localStorage.setItem('gw-theme', next);
	});

	/* ---------- Recherche + filtre (page d'accueil uniquement) ---------- */
	const grid = document.getElementById('grid');
	if (!grid) return;

	const search = document.getElementById('search');
	const chips = Array.from(document.querySelectorAll('.chip'));
	const cards = Array.from(grid.querySelectorAll('.card'));
	const countEl = document.getElementById('resultCount');
	const emptyEl = document.getElementById('empty');

	let term = '';
	let continent = '';

	const normalize = (s) =>
		s.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase();

	const apply = () => {
		const q = normalize(term.trim());
		let visible = 0;

		cards.forEach((card) => {
			const matchText =
				!q ||
				normalize(card.dataset.name).includes(q) ||
				normalize(card.dataset.capital).includes(q);
			const matchContinent = !continent || card.dataset.continent === continent;
			const show = matchText && matchContinent;
			card.hidden = !show;
			if (show) visible++;
		});

		countEl.textContent = visible
			? `${visible} pays affiché${visible > 1 ? 's' : ''}`
			: '';
		emptyEl.hidden = visible !== 0;
	};

	// Recherche avec léger debounce.
	let t;
	search?.addEventListener('input', (e) => {
		clearTimeout(t);
		term = e.target.value;
		t = setTimeout(apply, 120);
	});

	chips.forEach((chip) => {
		chip.addEventListener('click', () => {
			chips.forEach((c) => c.classList.remove('is-active'));
			chip.classList.add('is-active');
			continent = chip.dataset.continent;
			apply();
		});
	});

	apply();
})();
