import { arrayByClass } from '../../shared/helpers.mjs'

const mainWrapper = document.getElementById('mainWrapper');
const labels = arrayByClass('label');
const extraInput = document.getElementById('extra');
const form = document.getElementById('mainForm');
const submitPackagingList = document.getElementById('submit-packaging-list');
const submitLabels = document.getElementById('submit-labels');

const pageBlueprint = document.createElement('div');
pageBlueprint.setAttribute('class', 'page border border-black my-12 mx-auto bg-white shadow-lg grid grid-cols-2 grid-rows-6');
const labelBlueprint = document.createElement('div');
labelBlueprint.setAttribute('class', 'label empty border-b border-r border-dotted flex items-center');

extraInput.addEventListener('input', e => {
	mainWrapper.innerHTML = null;
	const empties = Array.apply(null, Array(parseInt(e.target.value))).map(item => labelBlueprint.cloneNode());
	const newLabels = [...empties, ...labels];
	let currentNewPage;
	newLabels.forEach((item, i) => {
		if( i%12 === 0 ) {
			currentNewPage = pageBlueprint.cloneNode();
			mainWrapper.append(currentNewPage);
		}
		currentNewPage.append(item);
	});
});

submitLabels.addEventListener('click', e => {
	e.preventDefault();
	form.action = window.location.origin+'/dashboard/orders/print/labels/'+extraInput.value;
	form.submit();
});

submitPackagingList.addEventListener('click', e => {
	e.preventDefault();
	form.action = window.location.origin+'/dashboard/orders/print/packaging-list';
	form.submit();
});






