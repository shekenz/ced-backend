// Publication switch
let pubSwitch = document.getElementById('publish-switch');
pubSwitch.addEventListener('click', (e) => {
	e.currentTarget.classList.toggle('off');
});