import { arrayByClass } from '../shared/helpers.mjs';

// Switches
let switches = arrayByClass('switch');
switches.map(switchEl => {
	switchEl.addEventListener('click', (e) => {
		e.currentTarget.classList.toggle('off');
	});
});
