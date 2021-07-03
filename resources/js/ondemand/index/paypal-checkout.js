import { arrayByClass } from '../../shared/helpers.mjs';
import { popUp } from '../../shared/popup.mjs';
import { updateCartTotal } from '../../shared/update-cart.mjs';

//let shippingPrice = document.getElementById('shipping-price').firstChild.nodeValue;
let shippingPrice = 0;
let shippingMethod = 0;
let shippingMethodInputs = (Array.from(document.getElementsByName('shipping-method')));

// Initiate current shippingMethod ID
shippingMethodInputs.forEach(input => {
	if(input.hasAttribute('checked')) {
		shippingMethod = input.value;
		shippingPrice = parseFloat(input.dataset.price);
		updateCartTotal(shippingPrice);
	}
});

// Update price and shippingMethod ID on change
shippingMethodInputs.forEach(input => {
	input.addEventListener('focus', e => {
		shippingMethod = e.target.value;
		let newShippingPrice = parseFloat(e.target.dataset.price);
		updateCartTotal( (shippingPrice * -1));
		updateCartTotal(newShippingPrice);
		shippingPrice = newShippingPrice;
	});
});

arrayByClass('shipping-method').map(input => {
	input.addEventListener('change', e => {
		let totalEl = document.getElementById('total');
		shippingPrice = parseFloat(e.target.value);
		let totalNoShipping = parseFloat(totalEl.dataset.totalNoShipping);
		totalEl.firstChild.nodeValue = shippingPrice + totalNoShipping;
		document.getElementById('shipping-price').firstChild.nodeValue = shippingPrice;
	});
});

let fetchErrorHandler = () => {
	popUp('Impossible to reach server. Please make sure you are connected to the internet.');
	console.error('Impossible to reach server. Please make sure you are connected to the internet.');
}

let checkCartButton = document.getElementById('checkCartButton');
checkCartButton.addEventListener('click', e => {
	e.preventDefault();
	fetch(`/api/cart/check`, {
		method: 'post',
		headers: {
			'content-type': 'application/json'
		}
	}).then(response => {
		return response.json();
	}).catch(rejected => {
		fetchErrorHandler;
	}).then(jsonResponse => {
		console.log(jsonResponse);
	});
});

if('paypal' in window) {
	paypal.Buttons({
		createOrder: () => {
			return fetch(`/api/cart/check`, {
				method: 'post',
				headers: {
					'content-type': 'application/json'
				}
			}).then( // Check cart fetch response
				cartCheckResponse => {
					return cartCheckResponse.json();
				}, fetchErrorHandler
			).then( // Check cart fetch JSON response
				cartCheckResponseJSON => {
					if(cartCheckResponseJSON.updated) {
						popUp('Some articles from you cart are not available anymore. Your cart will now be reloaded. Please check your order again before payment.', () => { window.location.reload() });
					} else {
						return fetch(`/api/order/create/${shippingMethod}`, {
							method: 'post',
							headers: {
							'content-type': 'application/json'
							}
						}).then( // Create fetch response
							createResponse => {
								return createResponse.json();
							}, fetchErrorHandler
						).then( // Create fetch response JSON
							createResponseJSON => {
								if(createResponseJSON.id && !createResponseJSON.error) {
									return createResponseJSON.id;
								} else if(createResponseJSON.error) {
									// We have error details
									console.error(createResponseJSON.error);
								} else {
									//--------------------------------------------------------- ERROR AT CREATING ORDER
									popUp('An internal error has occured while creating your order. Our team has been warned and we will work on it as soon as possible. Please try to purchase your goods later. We are sorry for the inconvenience.');
								}
							}
						);
					}
				}
			);
		},
		
		onShippingChange: (data, actions) => {
			return fetch(`/api/order/check-country/${data.shipping_address.country_code}`, {
				method: 'post',
				headers: {
					'content-type': 'application/json'
				}
			}).then(
				response => {
					return response.json();
				}, fetchErrorHandler
			).then(jsonResponse => {
					return (jsonResponse.country) ? actions.resolve() : actions.reject();
			});
		},

		onApprove: function(data, actions) {
			return fetch(`/api/order/capture/${data.orderID}`, {
				method: 'post',
				headers: {
					'content-type': 'application/json'
				},
			}).then(
				response => {
					return response.json();
				}, fetchErrorHandler
			).then(jsonResponse => {
				if(jsonResponse.id && !jsonResponse.error) {
					window.location.href = `${window.location.origin}/cart/success`;
				} else if(jsonResponse.error) {
					if(jsonResponse.error.name == 'INSTRUMENT_DECLINED') {
						// If payment refused
						return actions.restart();
					} else {
						console.error(jsonResponse.error);
					}
				} else {
					//--------------------------------------------------------- ERROR AT CAPTURING ORDER
					popUp('An internal error has occured while processing your order. Don\'t panic, your payment has been successfull and your cart has been saved. Our team has been notified and we will contact you as soon as possible on your payapal e-mail address to finalise your order. We are sorry for the inconvenience.');
				}
			});
		},

		onCancel: function (data) {
			return fetch(`/api/order/cancel/${data.orderID}`, {
				method: 'post'
			}).then(
				response => {
					return response.json();
				}, fetchErrorHandler
			).then(jsonResponse => {
				if(jsonResponse.delete == data.orderID) {
					window.location.replace(`${window.location.origin}/cart`);
				}
			});
		},

		onError: (error) => {
			console.error(error);
		},

		style: {
			color:  'black',
			//label: 'pay',
			height: 40,
		}
	}).render('#paypal-checkout-button');
}