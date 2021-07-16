import { arrayByClass, coolDown } from '../../shared/helpers.mjs';
import { formatISO9075 as formatDate, isThisHour } from 'date-fns';

let ordersForm = document.getElementById('orders-selection');
let orderRowsContainer = document.getElementById('order-rows');
let selectAllButton = document.getElementById('checkall');
let actions = arrayByClass('action');
let filterInput = document.getElementById('filter');
let filterDataInput = document.getElementById('filter-data');
let startDate = document.getElementById('start-date');
let endDate = document.getElementById('end-date');
let visibilityInput = document.getElementById('visibility');
let loader = document.getElementById('loader');
let recycleBlueprint = document.getElementById('recycle-blueprint');
let trashBlueprint = document.getElementById('trash-blueprint');

let coolDownFire = e => {
	if(loader.classList.contains('hidden')) {
		loader.classList.remove('hidden');
	}
	let method = filterInput.value;
	let data = e.target.value;
	let from = startDate.value;
	let to = endDate.value;
	let hidden = visibilityInput.checked;
	fetch(`/api/orders/get/${method}/${from}/${to}/${hidden}/${data}`, {
		method: 'post',
		headers: {
			'accept': 'application/json',
		}
	})
	.then(r => {
		if(r.ok === true) {
			return r.json();
		} else {
			throw new Error('Cannot query server');
		}
	})
	.catch(error => {
		console.error(error);
	})
	.then(rJson => {
		if(rJson) {
			orderRowsContainer.innerHTML = '';
			rJson.forEach((order) => {
				console.log(order);
				let orderCreationDate = new Date(order.created_at);

				// Parent row
				let row = document.createElement('tr');
				if(!order.read) {
					row.classList.add('unread');
				}

				// First cell with checkbox
				let firstCell = document.createElement('td');
				let firstCellInput = document.createElement('input');
				firstCellInput.setAttribute('class', 'checkbox');
				firstCellInput.setAttribute('type', 'checkbox');
				firstCellInput.setAttribute('value', order.id);
				firstCellInput.setAttribute('name', 'ids[]');
				firstCell.append(firstCellInput);
				row.append(firstCell);

				// Cells depending on their index
				let rowCells = [order.order_id, order.full_name, order.email_address, order.books.length, order.status, orderCreationDate, new Date(order.updated_at)];
				rowCells.forEach((cellData, index) => {
					let cell = document.createElement('td');
					
					switch(index) {
						case 0: // order_id
							let orderLink = document.createElement('a');
							orderLink.setAttribute('class', 'default');
							orderLink.setAttribute('href', window.location.origin+'/dashboard/order/'+order.id);
							if(!cellData) {
								cellData = '[ ID commande manquante ]';
							}
							orderLink.append(cellData);
							cell.append(orderLink)
							break;
						case 3:
							cell.setAttribute('class', 'text-right');
							cell.append(cellData);
							break;
						case 4:
							let label = document.createElement('span');
							label.setAttribute('class', 'font-bold text-center inline-block w-full text-white px-2 py-1 rounded');
							let bgClass = '';
							switch(order.status) {
								case 'FAILED': bgClass = 'bg-red-500'; cellData = 'Échec'.toUpperCase(); break;
								case 'CREATED': bgClass = 'bg-yellow-500'; cellData = 'Créé'.toUpperCase(); break;
								case 'COMPLETED': bgClass = 'bg-blue-500'; cellData = 'Payé'.toUpperCase(); break;
								case 'SHIPPED': bgClass = 'bg-green-500'; cellData = 'Envoyé'.toUpperCase(); break;
							}
							if(order.pre_order === 1 && order.status === 'COMPLETED') {
								cellData = 'Pré'.toUpperCase();
							}
							label.classList.add(bgClass);
							label.append(cellData);
							cell.append(label);
							break;
						case (5):
						case (6):
							cell.append(formatDate(cellData));
							break;
						default:
							cell.append(cellData);
							break;
					}
					row.append(cell);
				});

				// Last cell
				let toolsCell = document.createElement('td');
				if(order.status === 'FAILED') {
					let trashLink = document.createElement('a');
					trashLink.setAttribute('href', window.location.origin+'/dashboard/order/cancel/'+order.id);
					trashLink.setAttribute('class', 'icon');
					let trashIcon = trashBlueprint.cloneNode(true);
					trashIcon.classList.remove('hidden');
					trashLink.append(trashIcon);
					toolsCell.append(trashLink);
				} else if(order.status === 'CREATED' && order.order_id && !isThisHour(orderCreationDate)) {
					let recycleLink = document.createElement('a');
					recycleLink.setAttribute('href', window.location.origin+'/dashboard/order/recycle/'+order.order_id);
					recycleLink.setAttribute('class', 'icon');
					let recycleIcon = recycleBlueprint.cloneNode(true);
					recycleIcon.classList.remove('hidden');
					recycleLink.append(recycleIcon);
					toolsCell.append(recycleLink);
				}
				toolsCell.setAttribute('class', 'text-right');
				row.append(toolsCell);

				// Append row
				orderRowsContainer.append(row);
			});
		} else {
			throw new Error('Bad JSON response')
		}
	})
	.catch(error => {
		console.error(error);
	})
	.finally( () => {
		loader.classList.add('hidden');
	});
};

selectAllButton.addEventListener('click', e => {
	let checkboxes = arrayByClass('checkbox');
	checkboxes.forEach(checkbox => {
		checkbox.checked = e.target.checked;
	});
});

actions.forEach(action => {
	action.addEventListener('click', e => {
		ordersForm.action = e.target.dataset.action;
		ordersForm.submit();
	});
});

filterInput.addEventListener('input', e => {
	if(e.target.value !== '') {
		console.log(e.target.value);
		filterDataInput.focus();
	}
});

filterDataInput.addEventListener('input', coolDown(() => {}, coolDownFire, 500));
startDate.addEventListener('input', coolDown(() => {}, coolDownFire, 500));
endDate.addEventListener('input', coolDown(() => {}, coolDownFire, 500));
visibilityInput.addEventListener('input', coolDown(() => {}, coolDownFire, 500));
