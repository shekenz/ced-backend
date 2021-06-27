document.getElementById('shipping-allowed-countries').addEventListener('input', e => {
	if(e.target.value.search(/^([A-z]{2},+)*([A-z]{2},*)?$/g) < 0) {
		e.target.classList.add('error');
	} else {
		e.target.classList.remove('error');
	}
});