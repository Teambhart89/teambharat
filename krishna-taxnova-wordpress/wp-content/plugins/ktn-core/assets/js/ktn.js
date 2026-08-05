/* Eaccountingcart Core: client side form validation and file list preview */
(function () {
	'use strict';

	var input = document.getElementById('ktn-files');
	if (input) {
		input.addEventListener('change', function () {
			var list = input.closest('.ktn-upload-box').querySelector('.ktn-file-list');
			var maxFiles = (window.ktnCore && ktnCore.maxFiles) || 5;
			var maxSize = ((window.ktnCore && ktnCore.maxSize) || 10) * 1024 * 1024;
			list.innerHTML = '';
			var files = Array.prototype.slice.call(input.files);
			if (files.length > maxFiles) {
				list.innerHTML = '<li style="color:#9c2020">You can upload a maximum of ' + maxFiles + ' files. Only the first ' + maxFiles + ' will be sent.</li>';
				files = files.slice(0, maxFiles);
			}
			files.forEach(function (file) {
				var li = document.createElement('li');
				var sizeMb = (file.size / (1024 * 1024)).toFixed(1);
				li.textContent = file.name + ' (' + sizeMb + ' MB)';
				if (file.size > maxSize) {
					li.style.color = '#9c2020';
					li.textContent += ' - too large, will be skipped';
				}
				list.appendChild(li);
			});
		});
	}

	// Basic phone validation hint on submit.
	document.querySelectorAll('.ktn-form').forEach(function (form) {
		form.addEventListener('submit', function (e) {
			var phone = form.querySelector('input[name="ktn_phone"]');
			if (phone) {
				var digits = phone.value.replace(/\D/g, '');
				if (digits.length < 10) {
					e.preventDefault();
					phone.setCustomValidity('Please enter a valid 10 digit mobile number');
					phone.reportValidity();
					return;
				}
				phone.setCustomValidity('');
			}
		});
	});
})();
