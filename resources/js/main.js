// Select classes to array
function arrayByClass(className) {
	return(Array.from(document.getElementsByClassName(className)));
}

load(() => {
	console.log('Loaded !');

	let widthOffset = 20;
	let activeEl = arrayByClass('base-menu-link-active')[0];

	let menu = document.getElementById('menu-wrapper');
	let blackSquare = document.createElement('div');
	blackSquare.setAttribute('id', 'black-square');
	blackSquare.style.top = activeEl.offsetTop + 'px';
	blackSquare.style.left = (activeEl.offsetLeft - (widthOffset/2)) + 'px';
	blackSquare.style.width = (activeEl.offsetWidth + widthOffset) + 'px';
	blackSquare.style.height = (activeEl.offsetHeight + 3) + 'px';

	menu.parentNode.insertBefore(blackSquare, menu.nextSibling);

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

	function anim(el) {
		console.log(el.scrollLeft + el.offsetWidth >= el.offsetWidth*2);
		el.scrollBy(10, 0);
		if(el.scrollLeft + el.offsetWidth >= el.offsetWidth *2) {
			cancelAnimationFrame(animId);
		} else {
			
			animId = requestAnimationFrame(function() {
				anim(el);
			});
		}
	}

	let sliders = arrayByClass('base-slider');
	if(sliders.length > 0) {
		sliders.map((item) => {
			item.addEventListener('click', (e) => {
				e.stopPropagation();
				
				console.log();

				anim(e.currentTarget);

			});
		});
	}

});