export function updateQuantityFor(id, relativeValue = 0) {
	let el = document.getElementById(`quantity-for-id-${id}`).firstChild;
	let currentQuantity = parseInt(el.nodeValue);
	let newValue = currentQuantity + relativeValue;
	el.nodeValue = newValue;
	return (newValue > 0);
}

export function updateSubTotalFor(id, relativeValue = 0) {
	let el = document.getElementById(`subtotal-for-id-${id}`).firstChild;
	let currentSubTotal = parseInt(el.nodeValue);
	let newValue = currentSubTotal + relativeValue;
	el.nodeValue = newValue;
}