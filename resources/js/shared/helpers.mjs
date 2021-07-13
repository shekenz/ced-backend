// Select classes to array
export function arrayByClass(className) {
	return(Array.from(document.getElementsByClassName(className)));
};

/**
 * Executes callback(param) only after a cool down time. If coolDown() is called before, timer is reset.
 * Also executes init(param) every time coolDown() is called, with no delay.
 * @param init Function to be executed at every call. 
 * @param callback Function to be executed after cool down time.
 * @param timeout Cool down time.
 */
export const coolDown = (init, callback, timeout) => {
	let timeoutId = false;
	return param => {
		init(param);
		if(timeoutId) { clearTimeout(timeoutId); }
		timeoutId = setTimeout(() => {
			callback(param);
		}, timeout);
	}
};
