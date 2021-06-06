// Dark theme switch
document.getElementById('fun').addEventListener('click', (e) => {
	e.preventDefault();
	if (!document.documentElement.classList.contains('dark')) {
		document.documentElement.classList.add('dark');
		localStorage.theme = 'dark';
	} else {
		document.documentElement.classList.remove('dark');
		localStorage.theme = 'light';
	}
});
