export function updateCartQuantity(relativeValue = 0) {
	let el = document.getElementById('cart-menu-item').firstChild;
	let elUnder = document.getElementById('cart-menu-item-under').firstChild;
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
			elUnder.nodeValue = `cart (${newValue})`;
		} else {
			el.nodeValue = 'cart';
			elUnder.nodeValue = 'cart';
		}
	} else {
		throw new TypeError('newValue is not a number');
	}
}

export function setCartTotal(value) {
	let total = Math.round(value * 100) / 100;
	document.getElementById('cart-total').firstChild.nodeValue = total;
	return total;
}