require('./bootstrap');
require('alpinejs');
window.load = require('window-load');

load(() => {

	let flash = document.getElementById('flash-wrapper');
	if(flash) {
		let flashes = flash.childNodes;
		flashes.forEach((item, index) => {
			if(item.tagName) {
				setTimeout(function() {
					item.classList.add('opacity-0');
					setTimeout(function() {
						item.classList.add('hidden');
					}, 400);
				}, 3000+(500*(index)));
			};
		});
	}
});