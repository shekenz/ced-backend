// Flash fade out
let flash = document.getElementById('flash-wrapper');
if(flash) {
	let flashes = flash.childNodes;
	flashes.forEach((item, index) => {
		if(item.tagName && !item.parentElement.classList.contains('permanent')) {
			setTimeout(function() {
				item.classList.add('opacity-0');
				setTimeout(function() {
					item.classList.add('hidden');
				}, 400);
			}, 3000+(500*(index)));
		};
	});
}