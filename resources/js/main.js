// Select classes to array
function arrayByClass(className) {
	return(Array.from(document.getElementsByClassName(className)));
}

import Glide from '@glidejs/glide';

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

	let blackSquare;
	let widthOffset = 20;
	let activeEl = arrayByClass('base-menu-link-active')[0];
	let menu = document.getElementById('menu-wrapper');

	let init = () => {
		blackSquare = document.createElement('div');
		blackSquare.setAttribute('id', 'black-square');
		blackSquare.style.top = activeEl.offsetTop + 'px';
		blackSquare.style.left = (activeEl.offsetLeft - (widthOffset/2)) + 'px';
		blackSquare.style.width = (activeEl.offsetWidth + widthOffset) + 'px';
		blackSquare.style.height = (activeEl.offsetHeight + 3) + 'px';
		menu.parentNode.insertBefore(blackSquare, menu.nextSibling);
	}

	init();

	window.addEventListener('resize', () => {
		document.getElementById('black-square').remove();
		init();
	});

	let links = arrayByClass('base-menu-animated');
	links.map((item) => {
		item.addEventListener('click', (e) => {
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
		});
	});	

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
	
});