/* Krishna TaxNova theme: mobile navigation and mega menu toggles */
(function () {
	'use strict';

	var toggle = document.querySelector('.ktn-nav-toggle');
	var nav = document.getElementById('ktn-nav');

	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			var open = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
	}

	// On mobile, first tap on a category opens its submenu, second tap follows the link.
	var mq = window.matchMedia('(max-width: 1023px)');
	document.querySelectorAll('.ktn-has-mega > a').forEach(function (link) {
		link.addEventListener('click', function (e) {
			if (!mq.matches) {
				return;
			}
			var li = link.parentElement;
			if (!li.classList.contains('is-open')) {
				e.preventDefault();
				document.querySelectorAll('.ktn-has-mega.is-open').forEach(function (other) {
					if (other !== li) {
						other.classList.remove('is-open');
					}
				});
				li.classList.add('is-open');
			}
		});
	});
})();
