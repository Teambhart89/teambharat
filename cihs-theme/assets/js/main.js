/**
 * CIHS theme front-end behaviour.
 * Vanilla JS, no dependencies.
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {

		/* ---------- Mobile menu toggle ---------- */
		var toggle = document.querySelector('.menu-toggle');
		var nav = document.getElementById('site-navigation');
		if (toggle && nav) {
			toggle.addEventListener('click', function () {
				var open = nav.classList.toggle('is-open');
				toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			});
			document.addEventListener('keyup', function (e) {
				if (e.key === 'Escape' && nav.classList.contains('is-open')) {
					nav.classList.remove('is-open');
					toggle.setAttribute('aria-expanded', 'false');
					toggle.focus();
				}
			});
		}

		/* ---------- Live date/time in header ---------- */
		var clock = document.getElementById('cihs-datetime');
		if (clock) {
			var pad = function (n) { return (n < 10 ? '0' : '') + n; };
			var tick = function () {
				var d = new Date();
				clock.textContent = pad(d.getDate()) + '.' + pad(d.getMonth() + 1) + '.' + d.getFullYear() +
					' ' + pad(d.getHours()) + ':' + pad(d.getMinutes());
			};
			tick();
			setInterval(tick, 15000);
		}

		/* ---------- Header search toggle ---------- */
		var searchToggle = document.querySelector('.cihs-search-toggle');
		var searchPanel = document.getElementById('cihs-header-search');
		if (searchToggle && searchPanel) {
			searchToggle.addEventListener('click', function () {
				var open = searchPanel.hasAttribute('hidden');
				if (open) {
					searchPanel.removeAttribute('hidden');
					searchToggle.setAttribute('aria-expanded', 'true');
					var field = searchPanel.querySelector('input[type="search"]');
					if (field) { field.focus(); }
				} else {
					searchPanel.setAttribute('hidden', '');
					searchToggle.setAttribute('aria-expanded', 'false');
				}
			});
			document.addEventListener('keyup', function (e) {
				if (e.key === 'Escape' && !searchPanel.hasAttribute('hidden')) {
					searchPanel.setAttribute('hidden', '');
					searchToggle.setAttribute('aria-expanded', 'false');
					searchToggle.focus();
				}
			});
		}

		/* ---------- Donation preset amounts ---------- */
		var amountInput = document.getElementById('cihs_d_amount');
		var amountBtns = document.querySelectorAll('.cihs-amount-btn');
		if (amountInput && amountBtns.length) {
			amountBtns.forEach(function (btn) {
				btn.addEventListener('click', function () {
					amountBtns.forEach(function (b) { b.classList.remove('is-selected'); });
					btn.classList.add('is-selected');
					amountInput.value = btn.getAttribute('data-amount');
				});
			});
			amountInput.addEventListener('input', function () {
				amountBtns.forEach(function (b) { b.classList.remove('is-selected'); });
			});
		}

		/* ---------- Sticky header shadow ---------- */
		var header = document.querySelector('.site-header');
		if (header) {
			var onScroll = function () {
				header.classList.toggle('is-scrolled', window.scrollY > 10);
			};
			window.addEventListener('scroll', onScroll, { passive: true });
			onScroll();
		}

		/* ---------- Hero slider ---------- */
		var slides = document.querySelectorAll('.cihs-hero__slide');
		var dotsWrap = document.querySelector('.cihs-hero__dots');
		if (slides.length > 1 && dotsWrap) {
			var current = 0;
			var timer = null;
			var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

			slides.forEach(function (_, i) {
				var dot = document.createElement('button');
				dot.className = 'cihs-hero__dot' + (i === 0 ? ' is-active' : '');
				dot.setAttribute('aria-label', 'Slide ' + (i + 1));
				dot.addEventListener('click', function () {
					show(i);
					restart();
				});
				dotsWrap.appendChild(dot);
			});
			var dots = dotsWrap.querySelectorAll('.cihs-hero__dot');

			function show(i) {
				slides[current].classList.remove('is-active');
				dots[current].classList.remove('is-active');
				current = i;
				slides[current].classList.add('is-active');
				dots[current].classList.add('is-active');
			}
			function next() {
				show((current + 1) % slides.length);
			}
			function restart() {
				if (reduced) { return; }
				if (timer) { clearInterval(timer); }
				timer = setInterval(next, 6500);
			}
			restart();
		} else if (dotsWrap) {
			dotsWrap.style.display = 'none';
		}

		/* ---------- Reveal on scroll ---------- */
		var revealEls = document.querySelectorAll('.cihs-reveal');
		if ('IntersectionObserver' in window && revealEls.length) {
			var io = new IntersectionObserver(function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.classList.add('is-inview');
						io.unobserve(entry.target);
					}
				});
			}, { threshold: 0.12 });
			revealEls.forEach(function (el) { io.observe(el); });
		} else {
			revealEls.forEach(function (el) { el.classList.add('is-inview'); });
		}

		/* ---------- Back to top ---------- */
		var topBtn = document.querySelector('.cihs-top-btn');
		if (topBtn) {
			var onScrollTop = function () {
				topBtn.classList.toggle('is-visible', window.scrollY > 600);
			};
			window.addEventListener('scroll', onScrollTop, { passive: true });
			onScrollTop();
			topBtn.addEventListener('click', function () {
				window.scrollTo({ top: 0, behavior: 'smooth' });
			});
		}
	});
})();
