// Displays optimized media infos

frame = document.getElementById('frame');

for(let item of document.getElementsByClassName('opti-button')) {
	item.addEventListener('click', (e) => {
		e.preventDefault();
		frame.src = '/storage/uploads/'+frame.dataset.hash+'_'+e.currentTarget.dataset.opti+'.'+frame.dataset.ext;
	});
}

document.getElementById('original').addEventListener('click', (e) => {
	e.preventDefault();
	frame.src = '/storage/uploads/'+frame.dataset.hash+'.'+frame.dataset.ext;
});