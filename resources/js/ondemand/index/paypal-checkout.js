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

if('paypal' in window) {
		paypal.Buttons({

		createOrder: function() {
			return fetch(`/api/order/create/${shippingPrice}`, {
			  method: 'post',
			  headers: {
				'content-type': 'application/json'
			  }
			}).then(function(res) {
				if(res.status == '200') {
					return res.json();
				} else {
					throw new Error(`Server responded with status ${res.status} : ${res.statusText}`);
				}
			}).then(function(data) {
				//console.log(data);
				return data.id;
			})
		},

		onShippingChange: function(data, actions) {
			return fetch(`/api/order/check-country/${data.shipping_address.country_code}`, {
				method: 'post',
				headers: {
					'content-type': 'application/json'
				}
			}).then(res => {
					return (res.status != 200) ? actions.reject() : actions.resolve();
			});
		},

		onApprove: function(data, actions) {
			//console.log(data);
			return actions.order.capture().then(function(details) {
				
				return fetch('/api/order/capture', {
					method: 'post',
					headers: {
						'content-type': 'application/json'
					},
					body: JSON.stringify(details)
				}).then(res => {
					return res.json();
				}).then(res => {
					if(res.error) {
						//TODO Inform client about fatal error
					} else {
						window.location.href = `${window.location.origin}/cart/success`;
					}
				});
			});
		},

		onCancel: function (data) {
			return fetch(`/api/order/cancel/${data.orderID}`, {
				method: 'post'
			}).then(() => {
				window.location.replace(`${window.location.origin}/cart`);
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