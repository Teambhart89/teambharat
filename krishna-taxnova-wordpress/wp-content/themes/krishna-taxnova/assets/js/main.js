/* Eaccountingcart theme: mobile navigation and mega menu toggles */
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

	// Testimonials slider: dots, arrows, swipe and gentle autoplay.
	var slider = document.getElementById('ktn-tslider');
	if (slider) {
		var track = slider.querySelector('.ktn-ttrack');
		var slides = track.children.length;
		var dotsBox = slider.querySelector('.ktn-tdots');
		var index = 0;
		var timer = null;

		for (var i = 0; i < slides; i++) {
			var dot = document.createElement('button');
			dot.type = 'button';
			dot.setAttribute('aria-label', 'Go to testimonial ' + (i + 1));
			(function (n) {
				dot.addEventListener('click', function () { goTo(n); restart(); });
			})(i);
			dotsBox.appendChild(dot);
		}
		var dots = dotsBox.children;

		function goTo(n) {
			index = (n + slides) % slides;
			track.style.transform = 'translateX(-' + index * 100 + '%)';
			for (var d = 0; d < dots.length; d++) {
				dots[d].classList.toggle('is-active', d === index);
			}
		}
		function restart() {
			clearInterval(timer);
			timer = setInterval(function () { goTo(index + 1); }, 6500);
		}

		slider.querySelector('.ktn-tprev').addEventListener('click', function () { goTo(index - 1); restart(); });
		slider.querySelector('.ktn-tnext').addEventListener('click', function () { goTo(index + 1); restart(); });
		slider.addEventListener('mouseenter', function () { clearInterval(timer); });
		slider.addEventListener('mouseleave', restart);

		var startX = null;
		slider.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
		slider.addEventListener('touchend', function (e) {
			if (startX === null) { return; }
			var diff = e.changedTouches[0].clientX - startX;
			if (Math.abs(diff) > 40) { goTo(diff < 0 ? index + 1 : index - 1); restart(); }
			startX = null;
		}, { passive: true });

		goTo(0);
		restart();
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
