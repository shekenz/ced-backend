import { popUpPlus } from '../../shared/popup.mjs';

document.getElementById('shipping-allowed-countries').addEventListener('input', e => {
	if(e.target.value.search(/^([A-z]{2},+)*([A-z]{2},*)?$/g) < 0) {
		e.target.classList.add('error');
	} else {
		e.target.classList.remove('error');
	}
});

document.getElementById('add-coupon').addEventListener('click', e => {
	popUpPlus((wrapper, button) => {

		e.preventDefault();

		button.firstChild.nodeValue = 'Add';

		let br = document.createElement('br');

		let title = document.createElement('h2');
		title.append('Add new coupon');

		let couponForm = document.createElement('form');
		couponForm.setAttribute('method', 'POST');
		couponForm.setAttribute('action', e.target.href);

		let dateOutterWrapper = document.createElement('div');
		dateOutterWrapper.classList.add('flex');
		dateOutterWrapper.classList.add('gap-x-2');
		let couponOutterWrapper = dateOutterWrapper.cloneNode();

		dateOutterWrapper.classList.add('mt-3');
		let startsInnerWrapper = document.createElement('div');
		startsInnerWrapper.classList.add('w-full');
		let expiresInnerWrapper = startsInnerWrapper.cloneNode();

		let labelInput = document.createElement('input');
		labelInput.setAttribute('name', 'label');
		labelInput.setAttribute('type', 'text');
		labelInput.setAttribute('placeholder', 'LABEL');
		labelInput.setAttribute('maxlength', '8');
		labelInput.classList.add('coupon-input');
		labelInput.classList.add('flex-grow');

		labelInput.addEventListener('input', e => {
			e.target.value = e.target.value.toUpperCase();
		});

		let valueInput = document.createElement('input');
		valueInput.setAttribute('name', 'value');
		valueInput.setAttribute('type', 'number');
		valueInput.setAttribute('placeholder', 'Value');
		valueInput.classList.add('coupon-input');
		valueInput.classList.add('flex-grow');
		let typeInput = document.createElement('select');
		typeInput.setAttribute('name', 'type');
		typeInput.classList.add('coupon-input');
		let typeOptionPercentage = document.createElement('option');
		typeOptionPercentage.append('%');
		typeOptionPercentage.setAttribute('value', 0);
		let typeOptionAmount = document.createElement('option');
		typeOptionAmount.append('€');
		typeOptionAmount.setAttribute('value', 1);

		let startsInput = document.createElement('input');
		startsInput.setAttribute('name', 'starts_at');
		startsInput.setAttribute('type', 'date');
		startsInput.setAttribute('id', 'starts-at');
		startsInput.classList.add('input-shared');
		let startsInputLabel = document.createElement('label');
		startsInputLabel.append('Valid from :');
		startsInputLabel.setAttribute('for', 'starts-at');
		startsInputLabel.classList.add('label-shared');
		startsInputLabel.classList.add('lg:text-lg');

		let expiresInput = document.createElement('input');
		expiresInput.setAttribute('name', 'expires_at');
		expiresInput.setAttribute('type', 'date');
		expiresInput.setAttribute('id', 'expires-at');
		expiresInput.classList.add('input-shared');
		let expiresInputLabel = document.createElement('label');
		expiresInputLabel.append('To :');
		expiresInputLabel.setAttribute('for', 'expires-at');
		expiresInputLabel.classList.add('label-shared');
		expiresInputLabel.classList.add('lg:text-lg');

		typeInput.append(typeOptionPercentage);
		typeInput.append(typeOptionAmount);
		couponOutterWrapper.append(labelInput);
		couponOutterWrapper.append(valueInput);
		couponOutterWrapper.append(typeInput);
		couponForm.append(couponOutterWrapper);

		startsInnerWrapper.append(startsInputLabel);
		startsInnerWrapper.append(br.cloneNode());
		startsInnerWrapper.append(startsInput);
		expiresInnerWrapper.append(expiresInputLabel);
		expiresInnerWrapper.append(br.cloneNode());
		expiresInnerWrapper.append(expiresInput);
		dateOutterWrapper.append(startsInnerWrapper);
		dateOutterWrapper.append(expiresInnerWrapper);

		couponForm.append(dateOutterWrapper);
		couponForm.append(document.getElementsByName('_token')[0].cloneNode());
		
		wrapper.append(title);
		wrapper.append(couponForm);

		return couponForm;

	}, returned => {

		document.getElementById('loader').classList.toggle('hidden');
		returned.submit();

	});
});