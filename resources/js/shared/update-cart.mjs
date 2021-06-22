export function updateCartQuantity(relativeValue = 0) {
	let el = document.getElementById('cart-menu-item').firstChild;
	let currentQuantityMatch = el.nodeValue.match(/[0-9]+/);
	if (currentQuantityMatch) {
		var currentQuantity = parseInt(currentQuantityMatch[0]);
	} else {
		var currentQuantity = 0;
	}

	let newValue = currentQuantity + relativeValue;
	if(!isNaN(newValue)) {
		if(newValue > 0) {
			el.nodeValue = `cart (${newValue})`;
		} else {
			el.nodeValue = 'cart';
		}
	} else {
		throw new TypeError('newValue is not a number');
	}
}

export function updateCartTotal(relativeValue = 0) {
	let el = document.getElementById('cart-total').firstChild;
	let currentTotal = parseInt(el.nodeValue);
	let newTotal = currentTotal + relativeValue;
	el.nodeValue = newTotal;
	return (newTotal > 0);
}