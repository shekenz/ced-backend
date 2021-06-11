// Select classes to array
export function arrayByClass(className) {
	return(Array.from(document.getElementsByClassName(className)));
};

export let throttleConsole = (function(i) {
	let defi = i;
	return function(message) {
		if(i == defi) {
			console.log(message);
		}
		i--;
		if(i == 0) {
			i = defi;
		}
	}
})(500);