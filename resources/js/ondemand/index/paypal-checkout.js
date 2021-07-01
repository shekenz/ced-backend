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

let fetchErrorHandler = () => {
	//TODO -------------------------------------------------- CONNECTION ERROR
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
							//TODO --------------------------------------------------------- ERROR AT CREATING ORDER
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
					console.error(jsonResponse.error);
				} else {
					//TODO --------------------------------------------------------- ERROR AT CAPTURING ORDER
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