import { arrayByClass } from '../../shared/helpers.mjs';

let checkboxes = arrayByClass('checkbox');
let allButton = document.getElementById('checkall');

allButton.addEventListener('click', e => {
	checkboxes.forEach(checkbox => {
		checkbox.checked = e.target.checked;
	});
});