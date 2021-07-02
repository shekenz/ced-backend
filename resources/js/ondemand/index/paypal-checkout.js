import { arrayByClass } from '../../shared/helpers.mjs';

let shippingPrice = document.getElementById('shipping-price').firstChild.nodeValue;

arrayByClass('shipping-method').map(input => {
	input.addEventListener('change', e => {
		let totalEl = document.getElementById('total');
		shippingPrice = parseFloat(e.target.value);
		let totalNoShipping = parseFloat(totalEl.dataset.totalNoShipping);
		totalEl.firstChild.nodeValue = shippingPrice + totalNoShipping;
		document.getElementById('shipping-price').firstChild.nodeValue = shippingPrice;
	});
});

let popUp = message => {
	document.getElementById('pop-up-message').innerHTML = message;
	document.getElementById('pop-up-wrapper').classList.toggle('hidden');
	let closeHandler = () => {
		document.getElementById('pop-up-wrapper').classList.toggle('hidden');
		document.getElementById('pop-up-close').removeEventListener('click', closeHandler);
	}
	document.getElementById('pop-up-close').addEventListener('click', closeHandler);
}

let fetchErrorHandler = () => {
	popUp('Impossible to reach server. Please make sure you are connected to the internet.');
	console.error('Impossible to reach server. Please make sure you are connected to the internet.');
}

if('paypal' in window) {
		paypal.Buttons({
			createOrder: () => {
				return fetch(`/api/order/create/${shippingPrice}`, {
					method: 'post',
					headers: {
					  'content-type': 'application/json'
					}
				}).then(
					response => {
						return response.json();
					}, fetchErrorHandler
				).then(
					jsonResponse => {
						if(jsonResponse.id && !jsonResponse.error) {
							return jsonResponse.id;
						} else if(jsonResponse.error) {
							// We have error details
							console.error(jsonResponse.error);
						} else {
							//--------------------------------------------------------- ERROR AT CREATING ORDER
							popUp('An internal error has occured while creating your order. Our team has been warned and we will work on it as soon as possible. Please try to purchase your goods later. We are sorry for the inconvenience.');
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