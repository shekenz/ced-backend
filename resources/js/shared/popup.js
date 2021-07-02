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