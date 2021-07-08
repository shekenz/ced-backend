import { arrayByClass } from '../../shared/helpers.mjs';
import { updateQuantityFor, updateSubTotalFor } from '../../shared/update-article.mjs';
import { updateCartQuantity, updateCartTotal } from '../../shared/update-cart.mjs';
const axios = require('axios');

let incrementButtons = arrayByClass('qte-button');

incrementButtons.map(button => {
	button.addEventListener('click', e => {
		e.preventDefault();
		// Returns any numbers at the end of string
		let id = /[0-9]+$/.exec(e.target.href)[0];
		axios({
			method: 'post',
			url: e.target.href,
			headers: {
				accept: 'application/json'
			}
		})
		.then(response => {
			let book = response.data.book;
			// Book modifier is 1 when adding book and -1 when removing book
			updateCartQuantity(book.modifier);
			updateSubTotalFor(book.id, book.price * book.modifier);
			// updateQuantityFor returns false when article quantity reaches 0
			if(!updateQuantityFor(book.id, book.modifier)) {
				document.getElementById('cart').removeChild(document.getElementById(`article-${book.id}`));
			};
			// updateCartTotal returns false when total price reaches 0
			if(!updateCartTotal(book.price * book.modifier)) {
				document.getElementById('content').removeChild(document.getElementById('cart-wrapper'));
				document.getElementById('empty-cart-info').classList.toggle('hidden');
			}
		})
		.catch(error => {
			if(!error.response) {
				console.error(error);
			}
		});
	})
});