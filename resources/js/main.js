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

	let links = arrayByClass('base-menu-link');
	links.map((item) => {
		item.addEventListener('click', (e) => {
			e.preventDefault();
			blackSquare.style.top = e.currentTarget.offsetTop + 'px';
			blackSquare.style.left = (e.currentTarget.offsetLeft - (widthOffset/2)) + 'px';
			blackSquare.style.width = (e.currentTarget.offsetWidth + widthOffset) + 'px';
			e.target.classList.add('base-menu-link-active');
			activeEl.classList.remove('base-menu-link-active');

			setTimeout(() => {
				
				window.location = e.target.href
			}
			, 500);
		});
	});

});