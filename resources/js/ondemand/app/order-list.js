import { arrayByClass } from '../../shared/helpers.mjs';

let checkboxes = arrayByClass('checkbox');
let ordersForm = document.getElementById('orders-selection');
let allButton = document.getElementById('checkall');
let hideButton = document.getElementById('hide');

allButton.addEventListener('click', e => {
	checkboxes.forEach(checkbox => {
		checkbox.checked = e.target.checked;
	});
});

hideButton.addEventListener('click', e => {
	ordersForm.action = e.target.dataset.action;
	ordersForm.submit();
});