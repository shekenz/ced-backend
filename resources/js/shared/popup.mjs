export function popUp(message, callback = function() {}) {
	document.getElementById('pop-up-message').innerHTML = message;
	document.getElementById('pop-up-wrapper').classList.toggle('hidden');
	let closeHandler = () => {
		document.getElementById('pop-up-wrapper').classList.toggle('hidden');
		callback();
		document.getElementById('pop-up-close').removeEventListener('click', closeHandler);
	}
	document.getElementById('pop-up-close').addEventListener('click', closeHandler);
}

export function popUpPlus(run = (el, button) => {}, buttonCallback = returned => {}, loader = false) {
	let button = document.getElementById('pop-up-button');
	let innerWrapper = document.getElementById('pop-inner-wrapper');
	let returned = run(innerWrapper, button);
	document.getElementById('pop-up-wrapper').classList.toggle('hidden');

	let closeRoutine = () => {
		document.getElementById('pop-up-wrapper').classList.toggle('hidden');
		innerWrapper.innerHTML = '';
	}

	let loaderRoutine = () => {
		let popup = document.getElementById('pop-up');
		popup.innerHTML = '<div class="text-gray-400 text-center">Loading</div><img class="block m-auto w-32" src="/img/loader.gif">';
	}

	let buttonHandler = e => {
		if(!e.target.hasAttribute('disabled')) {
			buttonCallback(returned);
			if(loader) {
				loaderRoutine();
			} else {
				closeRoutine();
			}
			document.getElementById('pop-up-button').removeEventListener('click', buttonHandler);
		}
	}
	button.addEventListener('click', buttonHandler);

	let closeHandler = () => {
		closeRoutine();
		document.getElementById('pop-up-close').removeEventListener('click', closeHandler);
	}
	document.getElementById('pop-up-close').addEventListener('click', closeHandler);
}