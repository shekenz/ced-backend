// Select classes to array
function arrayByClass(className) {
	return(Array.from(document.getElementsByClassName(className)));
}

import Glide from '@glidejs/glide';

load(() => {
	console.log('Loaded !');

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

	arrayByClass('glide').map(item => {
		new Glide(item, {
			type: 'carousel',
			keyboard: false,
			animationDuration: 1000,
			rewind: true,
		}).mount();

	});

	
});