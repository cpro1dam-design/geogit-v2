/* =========================================================
   Geoworld — interactions
   - Loader / transitions de page
   - Thème clair / sombre (mémorisé)
   - Recherche instantanée + autocomplétion avec drapeaux
   - Filtre par continent (+ fond + libellé du continent)
   ========================================================= */
(() => {
	'use strict';

	const body = document.body;

	/* ---------- Loader / transitions de page ---------- */
	const reveal = () => body.classList.add('gw-ready');
	if (document.readyState === 'complete') {
		reveal();
	} else {
		window.addEventListener('load', () => setTimeout(reveal, 250));
	}
	document.addEventListener('click', (e) => {
		const a = e.target.closest('a');
		if (!a || !a.href) return;
		if (a.target === '_blank' || e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) return;
		let url;
		try { url = new URL(a.href, location.href); } catch (_) { return; }
		if (url.origin === location.origin && url.href !== location.href) {
			body.classList.remove('gw-ready');
		}
	});
	window.addEventListener('pageshow', (e) => { if (e.persisted) reveal(); });

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

	/* ---------- Accueil : recherche + filtres ---------- */
	const grid = document.getElementById('grid');
	if (!grid) return;

	const search   = document.getElementById('search');
	const chips    = Array.from(document.querySelectorAll('.chip'));
	const cards    = Array.from(grid.querySelectorAll('.card'));
	const countEl  = document.getElementById('resultCount');
	const emptyEl  = document.getElementById('empty');
	const suggest  = document.getElementById('suggestions');
	const gwBg     = document.getElementById('gwBg');

	// Fonds par continent.
	const BG = {
		'':               'assets/bg/background-study.jpg',
		'Asia':           'assets/bg/background-Asie.jpg',
		'Africa':         'assets/bg/background-Afrique.jpg',
		'Europe':         'assets/bg/background-europe.jpg',
		'North America':  'assets/bg/background-amerique-nord.jpg',
		'South America':  'assets/bg/background-amerique-sud.jpg',
		'Oceania':        'assets/bg/background-oceanie.jpg',
		'Antarctica':     'assets/bg/background-Antarctique.jpg',
	};

	// Index des pays construit à partir des cartes déjà rendues.
	const countries = cards.map((card) => ({
		el:        card,
		name:      card.querySelector('.card__name')?.textContent.trim() || '',
		capital:   card.querySelector('.card__capital')?.textContent.trim() || '',
		flag:      card.querySelector('img')?.getAttribute('src') || '',
		href:      card.getAttribute('href'),
		continent: card.dataset.continent,
		search:    (card.dataset.name || '') + ' ' + (card.dataset.capital || ''),
	}));

	let term = '';
	let continent = '';

	const normalize = (s) => s.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase();

	/* --- Filtrage de la grille --- */
	const applyGrid = () => {
		const q = normalize(term.trim());
		let visible = 0;
		cards.forEach((card) => {
			const matchText = !q
				|| normalize(card.dataset.name).includes(q)
				|| normalize(card.dataset.capital).includes(q);
			const matchContinent = !continent || card.dataset.continent === continent;
			const show = matchText && matchContinent;
			card.hidden = !show;
			if (show) visible++;
		});
		countEl.textContent = continent
			? `${continent} · ${visible} pays`
			: (visible ? `${visible} pays affichés` : '');
		emptyEl.hidden = visible !== 0;
	};

	/* --- Autocomplétion avec drapeaux --- */
	let activeIndex = -1;
	let matches = [];

	const closeSuggest = () => {
		suggest.hidden = true;
		suggest.innerHTML = '';
		activeIndex = -1;
		search?.setAttribute('aria-expanded', 'false');
	};

	const renderSuggest = () => {
		const q = normalize(term.trim());
		if (!q) { closeSuggest(); return; }
		matches = countries
			.filter((c) => normalize(c.search).includes(q))
			.slice(0, 8);

		if (!matches.length) { closeSuggest(); return; }

		suggest.innerHTML = matches.map((c, i) => `
			<li role="option" id="sg-${i}" class="suggest__item" data-href="${c.href}">
				${c.flag ? `<img class="suggest__flag" src="${c.flag}" alt="" width="40" height="27" loading="lazy">` : '<span class="suggest__flag"></span>'}
				<span class="suggest__name">${c.name}</span>
				${c.capital && c.capital !== '—' ? `<span class="suggest__cap">${c.capital}</span>` : ''}
			</li>`).join('');
		suggest.hidden = false;
		activeIndex = -1;
		search.setAttribute('aria-expanded', 'true');
	};

	const setActive = (i) => {
		const items = Array.from(suggest.querySelectorAll('.suggest__item'));
		items.forEach((it) => it.classList.remove('is-active'));
		if (i >= 0 && i < items.length) {
			items[i].classList.add('is-active');
			items[i].scrollIntoView({ block: 'nearest' });
			search.setAttribute('aria-activedescendant', items[i].id);
		}
		activeIndex = i;
	};

	suggest.addEventListener('mousedown', (e) => {
		const item = e.target.closest('.suggest__item');
		if (item) { body.classList.remove('gw-ready'); location.href = item.dataset.href; }
	});

	/* --- Événements recherche --- */
	let t;
	search?.addEventListener('input', (e) => {
		term = e.target.value;
		clearTimeout(t);
		t = setTimeout(() => { applyGrid(); renderSuggest(); }, 100);
	});
	search?.addEventListener('keydown', (e) => {
		if (suggest.hidden) return;
		if (e.key === 'ArrowDown') { e.preventDefault(); setActive(Math.min(activeIndex + 1, matches.length - 1)); }
		else if (e.key === 'ArrowUp') { e.preventDefault(); setActive(Math.max(activeIndex - 1, 0)); }
		else if (e.key === 'Enter') {
			const pick = matches[activeIndex] || matches[0];
			if (pick) { e.preventDefault(); body.classList.remove('gw-ready'); location.href = pick.href; }
		} else if (e.key === 'Escape') { closeSuggest(); }
	});
	search?.addEventListener('blur', () => setTimeout(closeSuggest, 120));
	search?.addEventListener('focus', () => { if (term.trim()) renderSuggest(); });

	/* --- Filtre par continent (+ fond) --- */
	chips.forEach((chip) => {
		chip.addEventListener('click', () => {
			chips.forEach((c) => c.classList.remove('is-active'));
			chip.classList.add('is-active');
			continent = chip.dataset.continent;
			if (gwBg) gwBg.style.backgroundImage = `url('${BG[continent] || BG['']}')`;
			applyGrid();
		});
	});

	applyGrid();
})();
