import { popUpPlus } from '../../shared/popup.mjs';

let preOrderInput = document.getElementById('pre-order');
let preOrderInitValue = preOrderInput.checked;
let quantityInput = document.getElementById('quantity');
let quantityHiddenInput = document.getElementById('quantity-hidden');
let quantityInitValue = quantityInput.value;
let editForm = document.getElementById('edit-form');

let togglePreOrder = test => {
	quantityInput.disabled = test;
	quantityHiddenInput.disabled = !test;
}

// Init
togglePreOrder(preOrderInitValue);

// Events
preOrderInput.addEventListener('input', e => {
	togglePreOrder(e.target.checked);
	if(quantityInitValue < 0) {
		if(e.target.checked) {
			quantityInput.value = quantityHiddenInput.value = quantityInitValue;
		} else {
			quantityInput.value = quantityHiddenInput.value = 0;
		}
	} else {
		if(e.target.checked) {
			quantityInput.value = quantityHiddenInput.value = 0;
		} else {
			quantityInput.value = quantityHiddenInput.value = quantityInitValue;
		}
	}
});

quantityInput.addEventListener('input', e => {
	quantityHiddenInput.value = e.target.value
});

editForm.addEventListener('submit', e => {
	// If checkbox has changed
	if(preOrderInput.checked !== preOrderInitValue) {
		e.preventDefault();
		popUpPlus((wrapper, button) => {
			let title = document.createElement('h2');
			title.append(document.createTextNode('Warning'));
			wrapper.append(title);
			wrapper.append(document.createTextNode('Stock quantity will be reset. Are you sure you want to proceed ?'));
			button.innerHTML = 'Proceed';
		}, () => {
			e.target.submit();
		});
	}
});
