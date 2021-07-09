/** @module popUp */

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

/**
 * Callback to customize the popup's content.
 * 
 * @callback run 
 * @param {HTMLElement} el Popup's main wrapper where to append content.
 * @param {HTMLElement} button Popup's accept button for customization.
 */

/**
 * Callback called on accept.
 * 
 * @callback buttonCallback
 * @param returned 
 */

/**
 * Open up a new popup with generated content.
 * 
 * @param {run} Callback Fills up the popup's main wrapper.
 * @param {buttonCallback} Callback Called on accept button click.
 */
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