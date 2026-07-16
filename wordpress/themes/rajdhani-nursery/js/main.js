/**
 * Rajdhani Nursery theme scripts:
 * mobile navigation, FAQ accordion, booking price preview and AJAX booking.
 */
(function () {
	'use strict';

	/* ---------- Mobile navigation ---------- */
	var navToggle = document.getElementById('rn-nav-toggle');
	var nav = document.getElementById('rn-nav');
	if (navToggle && nav) {
		navToggle.addEventListener('click', function () {
			var open = nav.classList.toggle('open');
			navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
	}

	/* ---------- FAQ accordion ---------- */
	document.querySelectorAll('.rn-faq-q').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var item = btn.closest('.rn-faq-item');
			var isOpen = item.classList.contains('open');
			item.closest('.rn-faq').querySelectorAll('.rn-faq-item').forEach(function (el) {
				el.classList.remove('open');
				el.querySelector('.rn-faq-q').setAttribute('aria-expanded', 'false');
			});
			if (!isOpen) {
				item.classList.add('open');
				btn.setAttribute('aria-expanded', 'true');
			}
		});
	});

	/* ---------- Booking form ---------- */
	var form = document.getElementById('rn-booking-form');
	if (!form || typeof rnBooking === 'undefined') {
		return;
	}

	var preview = document.getElementById('rn-price-preview');
	var msgBox = document.getElementById('rn-booking-msg');
	var submitBtn = document.getElementById('rn-booking-submit');

	function updatePricePreview() {
		var checked = form.querySelector('input[name="duration"]:checked');
		if (!checked || !preview) {
			return;
		}
		var d = rnBooking.durations[checked.value];
		if (d) {
			preview.textContent = 'Selected: ' + d.label + ' visit, estimated price ₹' + Number(d.price).toLocaleString('en-IN') + '. Final price confirmed on call.';
		}
	}
	form.querySelectorAll('input[name="duration"]').forEach(function (radio) {
		radio.addEventListener('change', updatePricePreview);
	});
	updatePricePreview();

	function showMessage(type, html) {
		msgBox.className = 'rn-form-msg ' + type;
		msgBox.innerHTML = html;
		msgBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
	}

	form.addEventListener('submit', function (e) {
		e.preventDefault();

		var phone = form.querySelector('#rn-phone').value.replace(/\D/g, '');
		if (phone.length !== 10) {
			showMessage('error', 'Please enter a valid 10 digit mobile number.');
			return;
		}
		if (!form.querySelector('#rn-date').value) {
			showMessage('error', 'Please select a date for your maali visit.');
			return;
		}
		if (!form.querySelector('#rn-time').value) {
			showMessage('error', 'Please select a time slot.');
			return;
		}

		var data = new FormData(form);
		data.append('action', 'rn_book_maali');
		data.append('nonce', rnBooking.nonce);

		submitBtn.disabled = true;
		submitBtn.textContent = 'Booking...';

		fetch(rnBooking.ajaxUrl, { method: 'POST', body: data, credentials: 'same-origin' })
			.then(function (res) { return res.json(); })
			.then(function (res) {
				if (res.success) {
					var html = res.data.message;
					if (res.data.waLink) {
						html += ' <br><a href="' + res.data.waLink + '" target="_blank" rel="noopener" style="display:inline-block;margin-top:10px;font-weight:800;">Confirm faster on WhatsApp →</a>';
					}
					showMessage('success', html);
					form.reset();
					updatePricePreview();
				} else {
					showMessage('error', (res.data && res.data.message) || 'Something went wrong. Please try again.');
				}
			})
			.catch(function () {
				showMessage('error', 'Network error. Please try again, or message us on WhatsApp using the green button.');
			})
			.finally(function () {
				submitBtn.disabled = false;
				submitBtn.textContent = 'Confirm My Booking';
			});
	});
})();
