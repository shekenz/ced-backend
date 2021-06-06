// Shipping form

const duplicateInput = document.getElementById('address-duplicate');

if(duplicateInput) {
	const inputsName = ['address-1', 'address-2', 'city', 'postcode', 'country'];

	// When shipping inputs are updated, if #address-duplicate is checked, copy value to invoice inputs
	inputsName.map((item) => {
		let input = document.getElementById('shipping-'+item)
		input.addEventListener('input', (e) => {
			if(duplicateInput.checked) {
				let innvoiceInput = document.getElementById('invoice-'+item);
				innvoiceInput.value = e.currentTarget.value;
				// hidden country element to post value when regular select element is disabled (because select elements don't have readonly attributes)
				if(e.currentTarget.id == 'shipping-country') {
					document.getElementById('invoice-country-hidden').value = e.currentTarget.value;
				}
			}
		});
	});

	// When checking #address-duplicate we :
	// Copy shipping inputs values to invoice inputs
	// Set text inputs to readonly
	// Disable select input (that has no readonly attribute)
	// Enable and set hidden country input to shipping value
	// And we reverse it on unchecking.
	const checkDuplicateInput = (target) => {
		if(target.checked) {
			inputsName.map((item) => {
				let input = document.getElementById('invoice-'+item);
				let shippingInput = document.getElementById('shipping-'+item);
				input.value = shippingInput.value;
				if(input.id == 'invoice-country') {
					inputCountryHidden.value = shippingInput.value;
					let inputCountryHidden = document.getElementById('invoice-country-hidden');
					input.disabled = true;
					inputCountryHidden.removeAttribute('disabled');
				} else {
					input.setAttribute('readonly', 'readonly');
				}
			});
		} else {
			inputsName.map((item) => {
				let input = document.getElementById('invoice-'+item);
				if(input.id == 'invoice-country') {
					let inputCountryHidden = document.getElementById('invoice-country-hidden');
					input.removeAttribute('disabled');
					inputCountryHidden.disabled = true;
				} else {
					input.removeAttribute('readonly');
				}
			});
		}
	}

	// We fire it once in case of php redirect that set #address-duplicate checked (old value)
	checkDuplicateInput(duplicateInput);

	// Checking/Uncheking #address-duplicate
	duplicateInput.addEventListener('change', (e) => {
		checkDuplicateInput(e.currentTarget);
	});
}