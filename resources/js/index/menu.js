import { arrayByClass } from '../shared/helpers.mjs';

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