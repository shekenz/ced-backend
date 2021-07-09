import { popUpPlus } from '../../shared/popup.mjs';
import { arrayByClass } from '../../shared/helpers.mjs';

arrayByClass('new-tab').forEach(item => {
	item.addEventListener('click', e => {
		e.preventDefault();
		window.open(e.target.href);
	});
});

document.getElementById('ship-form').addEventListener('submit', e => {
	e.preventDefault();
	popUpPlus((wrapper, button) => {

		button.firstChild.nodeValue = 'Ship';
		button.setAttribute('disabled', true);

		let trackingData = document.getElementById('tracking-data').dataset;

		let title = document.createElement('h2');
		title.appendChild(document.createTextNode('Confirm shipping'));

		let shipTrackingForm = document.createElement('form');
		shipTrackingForm.setAttribute('method', 'POST');
		shipTrackingForm.setAttribute('action', e.target.action);
		shipTrackingForm.appendChild(document.getElementsByName('_token')[0].cloneNode());
		
		// Tracking Number
		let shipTrackingNumber = document.createElement('input');
		shipTrackingNumber.setAttribute('type', 'text');
		shipTrackingNumber.setAttribute('name', 'tracking_number');
		shipTrackingNumber.classList.add('input-shared');
		let shipTrackingNumberLabel = document.createElement('label');
		shipTrackingNumberLabel.classList.add('label-shared');
		shipTrackingNumberLabel.classList.add('text-lg');
		shipTrackingNumberLabel.appendChild(document.createTextNode('Tracking number :'))
		
		// Tracking URL
		let shipTrackingURL = document.createElement('input');
		shipTrackingURL.setAttribute('type', 'text');
		shipTrackingURL.classList.add('input-shared');
		let shipTrackingURLLabel = document.createElement('label');
		shipTrackingURLLabel.classList.add('label-shared');
		shipTrackingURLLabel.classList.add('block');
		shipTrackingURLLabel.classList.add('text-lg');
		shipTrackingURLLabel.classList.add('mt-4');
		shipTrackingURLLabel.appendChild(document.createTextNode('Tracking URL :'))
		// Hidden input
		var shipTrackingURLHidden = document.createElement('input');
		shipTrackingURLHidden.setAttribute('type', 'hidden');
		shipTrackingURLHidden.setAttribute('name', 'tracking_url');

		// URL Tester
		let urlTesterCaption = document.createElement('span');
		urlTesterCaption.appendChild(document.createTextNode('Test your URL : '))
		urlTesterCaption.classList.add('label-shared');
		urlTesterCaption.classList.add('text-base');
		let urlTester = document.createElement('a');
		urlTester.appendChild(document.createTextNode(''));
		urlTester.setAttribute('href', '#');
		urlTester.classList.add('underline');
		urlTester.classList.add('hover:text-gray-500');
		urlTester.classList.add('transition-colors');
		urlTester.classList.add('duration-300');
		let urlTesterWrapper = document.createElement('div');
		urlTesterWrapper.appendChild(urlTesterCaption);
		urlTesterWrapper.appendChild(document.createElement('br'));
		urlTesterWrapper.appendChild(urlTester);
		urlTesterWrapper.classList.add('mt-6');
		urlTesterWrapper.classList.add('hidden');

		// Validate inputs
		let validate = () => {
			if(shipTrackingNumber.value != '' && shipTrackingURLHidden.value != '') {
				button.removeAttribute('disabled');
			} else {
				button.setAttribute('disabled', true);
			}
		}

		let updateTester = url => {
			if(url != '' && url != trackingData.trackingUrl.replace(/\{tracking\}/, '')) {
				urlTesterWrapper.classList.remove('hidden');
				urlTester.href = url;
				urlTester.firstChild.nodeValue = url;
			} else {
				urlTesterWrapper.classList.add('hidden');
			}
		}
		
		// If we have an automated tracking address
		if(trackingData.trackingUrl != '') {

			// Disable Tracking URL Input
			shipTrackingURL.setAttribute('disabled', true);

			// Set value to automated tracking address
			shipTrackingURL.setAttribute('value', trackingData.trackingUrl.replace(/\{tracking\}/, ''));

			// Create custom URL option
			var shipTrackingURLCustom = document.createElement('input');
			shipTrackingURLCustom.setAttribute('type', 'checkbox');
			shipTrackingURLCustom.setAttribute('id', 'ship-tracking-url-custom');
			var shipTrackingURLCustomLabel = document.createElement('label');
			shipTrackingURLCustomLabel.append(document.createTextNode(' Custom tracking URL'));
			shipTrackingURLCustomLabel.setAttribute('for', 'ship-tracking-url-custom');
			shipTrackingURLCustomLabel.classList.add('label-shared');
			var shipTrackingURLCustomWrapper = document.createElement('div');
			shipTrackingURLCustomWrapper.classList.add('mt-1');
			shipTrackingURLCustomWrapper.appendChild(shipTrackingURLCustom);
			shipTrackingURLCustomWrapper.appendChild(shipTrackingURLCustomLabel);
		}

		// Events --------------------------------------------

		// URL Tester pops new window
		urlTester.addEventListener('click', e => {
			e.preventDefault();
			window.open(e.target.href);
		});

		// Tracking number update
		shipTrackingNumber.addEventListener('input', e => {
			if(shipTrackingURLCustom && !shipTrackingURLCustom.checked) {
				let shipTrackingURLValue = trackingData.trackingUrl.replace(/\{tracking\}/, encodeURIComponent(e.target.value));
				shipTrackingURL.value = shipTrackingURLValue;
				shipTrackingURLHidden.value = shipTrackingURLValue;
				updateTester(shipTrackingURLValue);
			}
			validate();
		});

		// Tracking URL update
		shipTrackingURL.addEventListener('input', e => {
			shipTrackingURLHidden.value = e.target.value;
			updateTester(e.target.value);
			validate();
		});

		// If we have an automated tracking address
		if(trackingData.trackingUrl != '') {
			// Listen to Check/Uncheck custom URL
			shipTrackingURLCustom.addEventListener('input', e => {
				if(e.target.checked) {
					// Disable Tracking URL Input
					shipTrackingURL.removeAttribute('disabled');
					shipTrackingURL.classList.add('bg-transparent');
					shipTrackingURL.classList.add('text-inherit');
					shipTrackingURL.value = '';
					shipTrackingURLHidden.value = '';
					updateTester('');
				} else {
					// Eneable Tracking URL Input
					shipTrackingURL.setAttribute('disabled', true);
					shipTrackingURL.classList.remove('bg-transparent');
					shipTrackingURL.classList.remove('text-inherit');
					let shipTrackingURLValue = trackingData.trackingUrl.replace(/\{tracking\}/, encodeURIComponent(shipTrackingNumber.value));
					shipTrackingURL.value = shipTrackingURLValue;
					shipTrackingURLHidden.value = shipTrackingURLValue;
					updateTester(shipTrackingURLValue);
				}
				validate();
			});
		}

		// Appending
		shipTrackingForm.appendChild(shipTrackingNumberLabel);
		shipTrackingForm.appendChild(shipTrackingNumber);
		shipTrackingForm.appendChild(shipTrackingURLLabel);
		shipTrackingForm.appendChild(shipTrackingURL);
		shipTrackingForm.appendChild(shipTrackingURLHidden);
		if(shipTrackingURLCustomWrapper) {
			shipTrackingForm.appendChild(shipTrackingURLCustomWrapper);
		}
		shipTrackingForm.appendChild(urlTesterWrapper);
		
		wrapper.appendChild(title);
		wrapper.appendChild(shipTrackingForm);
		return shipTrackingForm;
	},
	returned => {
		document.getElementById('loader').classList.toggle('hidden');
		returned.submit();
	}, true);
});