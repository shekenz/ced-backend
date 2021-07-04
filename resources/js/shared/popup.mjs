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

export function popUpPlus(run = (el, button) => {}, buttonCallback = returned => {}) {
	let button = document.getElementById('pop-up-button');
	let innerWrapper = document.getElementById('pop-inner-wrapper');
	let returned = run(innerWrapper, button);
	document.getElementById('pop-up-wrapper').classList.toggle('hidden');

	let closeRoutine = () => {
		document.getElementById('pop-up-wrapper').classList.toggle('hidden');
		innerWrapper.innerHTML = '';
	}

	let buttonHandler = e => {
		if(!e.target.hasAttribute('disabled')) {
			new Promise(() => {
				buttonCallback(returned);
			}).then(() => {
				closeRoutine();
			});
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