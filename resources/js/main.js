// Select classes to array
function arrayByClass(className) {
	return(Array.from(document.getElementsByClassName(className)));
}

import Glide from '@glidejs/glide';

load(() => {

	// Flash disapearing timeout
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

	// Menu items underlaying black square -- TODO needs rework
	let blackSquare;
	let widthOffset = 20;
	let activeEl = arrayByClass('base-menu-link-active')[0];
	let menu = document.getElementById('menu-wrapper');

	let init = () => {
		if(activeEl) {
			blackSquare = document.createElement('div');
			blackSquare.setAttribute('id', 'black-square');
			blackSquare.style.top = activeEl.offsetTop + 'px';
			blackSquare.style.left = (activeEl.offsetLeft - (widthOffset/2)) + 'px';
			blackSquare.style.width = (activeEl.offsetWidth + widthOffset) + 'px';
			blackSquare.style.height = (activeEl.offsetHeight + 3) + 'px';
			menu.parentNode.insertBefore(blackSquare, menu.nextSibling);
		}
	}

	init();

	window.addEventListener('resize', () => {
		if(document.getElementById('black-square')) {
			document.getElementById('black-square').remove();
			init();
		}
	});

	let links = arrayByClass('base-menu-animated');
	links.map((item) => {
		item.addEventListener('click', (e) => {
			if(blackSquare) {
				e.preventDefault();
				blackSquare.style.top = e.target.offsetTop + 'px';
				blackSquare.style.left = (e.target.offsetLeft - (widthOffset/2)) + 'px';
				blackSquare.style.width = (e.target.offsetWidth + widthOffset) + 'px';
				e.target.classList.add('base-menu-link-active');
				activeEl.classList.remove('base-menu-link-active');

				setTimeout(() => {
					
					window.location = e.target.href
				}
				, 500);
			}
		});
	});	

	// Glides
	let glides = new Array;

	arrayByClass('glide').map((item,index) => {
		glides[index] = new Glide(item, {
			type: 'carousel',
			keyboard: false,
			animationDuration: 700,
			rewind: true,
			swipeThreshold: 50,
			gap: 0,
		}).mount();
	});

	glides.map((item, index) => {
		item.on('move.after', () => {
			document.getElementById('counter-'+index).firstChild.firstChild.nodeValue = item.index + 1;
		});
	});

	// Dark theme switch
	document.getElementById('fun').addEventListener('click', (e) => {
		e.preventDefault();
		if (!document.documentElement.classList.contains('dark')) {
			document.documentElement.classList.add('dark');
			localStorage.theme = 'dark';
		} else {
			document.documentElement.classList.remove('dark');
			localStorage.theme = 'light';
		}
	});

	// Shipping form
	const duplicateInput = document.getElementById('address-duplicate');
	if(duplicateInput) {
		const inputsName = ['address-1', 'address-2', 'city', 'postcode', 'country'];

		inputsName.map((item) => {
			let input = document.getElementById('shipping-'+item)
			input.addEventListener('input', (e) => {
				if(duplicateInput.checked) {
					let innvoiceInput = document.getElementById('invoice-'+item);
					innvoiceInput.value = e.currentTarget.value;
					if(e.currentTarget.id == 'shipping-country') {
						document.getElementById('invoice-country-hidden').value = e.currentTarget.value;
					}
				}
			});
		});

		const checkDuplicateInput = (target) => {
			if(target.checked) {
				inputsName.map((item) => {
					let input = document.getElementById('invoice-'+item);
					let shippingInput = document.getElementById('shipping-'+item);
					input.value = shippingInput.value;
					if(input.id == 'invoice-country') {
						let inputCountryHidden = document.getElementById('invoice-country-hidden');
						input.disabled = true;
						inputCountryHidden.removeAttribute('disabled');
						inputCountryHidden.value = shippingInput.value;
					} else {
						input.setAttribute('readonly', 'readonly');
					}
				});
			} else {
				inputsName.map((item) => {
					let input = document.getElementById('invoice-'+item);
					if(input.id == 'invoice-country') {
						let inputCountryHidden = document.getElementById('invoice-country-hidden');
						input.removeAttribute('disabled');
						inputCountryHidden.disabled = true;
					} else {
						input.removeAttribute('readonly');
					}
				});
			}
		}

		checkDuplicateInput(duplicateInput);

		duplicateInput.addEventListener('change', (e) => {
			checkDuplicateInput(e.currentTarget);
		});
	}
});