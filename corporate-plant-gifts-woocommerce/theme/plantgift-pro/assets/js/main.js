/**
 * PlantGift Pro front end behaviour.
 * Vanilla JS, no dependencies, no external requests.
 */
(function () {
	'use strict';

	var doc = document;

	function ready(fn) {
		if (doc.readyState !== 'loading') {
			fn();
		} else {
			doc.addEventListener('DOMContentLoaded', fn);
		}
	}

	/* Mobile navigation ---------------------------------------------------- */

	function initNav() {
		var nav = doc.querySelector('[data-pg-nav]');
		var toggle = doc.querySelector('[data-pg-nav-toggle]');
		var close = doc.querySelector('[data-pg-nav-close]');
		var scrim = doc.querySelector('[data-pg-scrim]');

		if (!nav || !toggle) {
			return;
		}

		function setOpen(open) {
			nav.setAttribute('data-open', open ? 'true' : 'false');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			if (scrim) {
				scrim.setAttribute('data-open', open ? 'true' : 'false');
			}
			doc.documentElement.style.overflow = open ? 'hidden' : '';
			if (open) {
				var first = nav.querySelector('a, button');
				if (first) {
					first.focus();
				}
			}
		}

		toggle.addEventListener('click', function () {
			setOpen(nav.getAttribute('data-open') !== 'true');
		});

		if (close) {
			close.addEventListener('click', function () {
				setOpen(false);
				toggle.focus();
			});
		}

		if (scrim) {
			scrim.addEventListener('click', function () {
				setOpen(false);
			});
		}

		doc.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && nav.getAttribute('data-open') === 'true') {
				setOpen(false);
				toggle.focus();
			}
		});

		// Sub menu toggles on touch devices.
		nav.querySelectorAll('.menu-item-has-children > a').forEach(function (link) {
			link.addEventListener('click', function (e) {
				if (window.matchMedia('(max-width: 61.99em)').matches) {
					var sub = link.parentNode.querySelector('.sub-menu');
					if (sub && link.getAttribute('data-expanded') !== 'true') {
						e.preventDefault();
						link.setAttribute('data-expanded', 'true');
					}
				}
			});
		});
	}

	/* FAQ accordion: open one, keep the rest closed on small screens -------- */

	function initFaq() {
		var groups = doc.querySelectorAll('[data-pg-faq]');
		groups.forEach(function (group) {
			var items = group.querySelectorAll('details');
			items.forEach(function (item) {
				item.addEventListener('toggle', function () {
					if (!item.open) {
						return;
					}
					if (group.getAttribute('data-pg-faq') === 'multi') {
						return;
					}
					items.forEach(function (other) {
						if (other !== item) {
							other.open = false;
						}
					});
				});
			});
		});

		// Open the item targeted by the URL hash so shared FAQ links land correctly.
		if (window.location.hash) {
			var target = doc.querySelector(window.location.hash);
			if (target && target.tagName === 'DETAILS') {
				target.open = true;
			}
		}
	}

	/* Build a table of contents from the H2 headings of long form pages ----- */

	function initToc() {
		var holder = doc.querySelector('[data-pg-toc]');
		if (!holder) {
			return;
		}

		var scope = doc.querySelector(holder.getAttribute('data-pg-toc-scope') || '.pg-entry');
		if (!scope) {
			holder.remove();
			return;
		}

		var headings = scope.querySelectorAll('h2');
		if (headings.length < 3) {
			holder.remove();
			return;
		}

		var list = doc.createElement('ol');
		var used = {};

		headings.forEach(function (h) {
			var id = h.id;
			if (!id) {
				id = h.textContent.toLowerCase().trim()
					.replace(/[^a-z0-9\s]/g, '')
					.replace(/\s+/g, '-')
					.slice(0, 60);
				if (used[id]) {
					used[id] += 1;
					id = id + '-' + used[id];
				} else {
					used[id] = 1;
				}
				h.id = id;
			}
			var li = doc.createElement('li');
			var a = doc.createElement('a');
			a.href = '#' + id;
			a.textContent = h.textContent;
			li.appendChild(a);
			list.appendChild(li);
		});

		holder.appendChild(list);
	}

	/* Sticky header shadow on scroll --------------------------------------- */

	function initHeaderScroll() {
		var header = doc.querySelector('.pg-header');
		if (!header) {
			return;
		}
		var last = false;
		window.addEventListener('scroll', function () {
			var scrolled = window.scrollY > 8;
			if (scrolled !== last) {
				header.style.boxShadow = scrolled ? '0 2px 12px rgba(18,41,27,0.08)' : '';
				last = scrolled;
			}
		}, { passive: true });
	}

	/* Quantity stepper on product pages ------------------------------------ */

	function initQuantity() {
		doc.querySelectorAll('form.cart div.quantity').forEach(function (wrap) {
			if (wrap.querySelector('.pg-qty-btn')) {
				return;
			}
			var input = wrap.querySelector('input.qty');
			if (!input) {
				return;
			}

			function make(label, delta) {
				var b = doc.createElement('button');
				b.type = 'button';
				b.className = 'pg-qty-btn';
				b.textContent = label;
				b.setAttribute('aria-label', delta > 0 ? 'Increase quantity' : 'Decrease quantity');
				b.addEventListener('click', function () {
					var step = parseFloat(input.getAttribute('step')) || 1;
					var min = parseFloat(input.getAttribute('min'));
					var max = parseFloat(input.getAttribute('max'));
					var value = (parseFloat(input.value) || 0) + (delta * step);
					if (!isNaN(min) && value < min) { value = min; }
					if (!isNaN(max) && value > max) { value = max; }
					input.value = value;
					input.dispatchEvent(new Event('change', { bubbles: true }));
				});
				return b;
			}

			wrap.insertBefore(make('−', -1), input);
			wrap.appendChild(make('+', 1));
		});
	}

	/* Lazy load images that WordPress did not already mark ------------------ */

	function initLazy() {
		doc.querySelectorAll('.pg-card__media img, .pg-split__media img').forEach(function (img) {
			if (!img.getAttribute('loading')) {
				img.setAttribute('loading', 'lazy');
				img.setAttribute('decoding', 'async');
			}
		});
	}

	/* Reveal the sticky bar and floating CTA once the visitor has scrolled --- */

	function initStickyCta() {
		var bar = doc.querySelector('[data-pg-sticky-bar]');
		var float = doc.querySelector('[data-pg-float-cta]');
		if (!bar && !float) {
			return;
		}

		var footer = doc.querySelector('.pg-footer');
		var shown = null;

		function update() {
			// Show after one viewport of scrolling, hide once the footer is in view
			// so the buttons never sit on top of the contact details.
			var scrolled = window.scrollY > window.innerHeight * 0.6;
			var atFooter = false;

			if (footer) {
				var rect = footer.getBoundingClientRect();
				atFooter = rect.top < window.innerHeight - 80;
			}

			var show = scrolled && !atFooter;
			if (show === shown) {
				return;
			}
			shown = show;

			if (bar) { bar.setAttribute('data-show', show ? 'true' : 'false'); }
			if (float) { float.setAttribute('data-show', show ? 'true' : 'false'); }
		}

		window.addEventListener('scroll', update, { passive: true });
		window.addEventListener('resize', update, { passive: true });
		update();
	}

	/* Sticky bar buy button scrolls to the variation form ------------------- */

	function initScrollTo() {
		doc.querySelectorAll('[data-pg-scroll-to]').forEach(function (link) {
			link.addEventListener('click', function (e) {
				var target = doc.querySelector(link.getAttribute('data-pg-scroll-to'));
				if (!target) {
					return;
				}
				e.preventDefault();
				target.scrollIntoView({ behavior: 'smooth', block: 'center' });

				// Move focus to the first control so keyboard users land there too.
				var field = target.querySelector('select, input, button');
				if (field) {
					window.setTimeout(function () { field.focus({ preventScroll: true }); }, 420);
				}
			});
		});
	}

	ready(function () {
		initNav();
		initFaq();
		initToc();
		initHeaderScroll();
		initQuantity();
		initLazy();
		initStickyCta();
		initScrollTo();
	});

	// WooCommerce replaces DOM after AJAX events, so rebind what matters.
	doc.body && doc.addEventListener('wc_fragments_refreshed', initQuantity);
	if (window.jQuery) {
		window.jQuery(document.body).on('updated_wc_div found_variation', initQuantity);
	}
})();
