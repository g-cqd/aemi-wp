/**
 * 
 * @param {Element} element 
 * @param {String} selector 
 */
function getParents(element, selector) {
	const parents = [];
	let currentElement = element;
	while (currentElement !== document) {
		let currentParent = currentElement.parentElement;
		if (!!!selector || currentParent.matches(selector)) {
			parents.push(currentParent);
		}
		currentElement = currentParent;
	}
	return parents;
}

function checkboxChangeHandler() {
	const checkboxes = document.querySelectorAll('.customize-control-checkbox-multiple input[type="checkbox"]');
	
	console.log(checkboxes);
	
	for (const checkbox of checkboxes) {
		checkbox.addEventListener('change', function () {
			const customizeControls = getParents(checkbox, '.customize-control');
			const checkboxValues = customizeControls
				.flatMap(item => [...item.querySelectorAll('input[type="checkbox"]:checked')].map(({ value }) => value))
				.join(',');
			
			console.log(checkboxValues);
			
			customizeControls.forEach(element => {
				element.querySelectorAll('input[type="hidden"]').forEach(item => {
					console.log(item);
					item.value = checkboxValues;
					item.dispatchEvent(new Event('change'));
				});
			});
		});
	}

	console.warn('used');
}

document.addEventListener('DOMContentLoaded', checkboxChangeHandler);

// jQuery(document).ready(function () {
// 	jQuery( '.customize-control-checkbox-multiple input[type="checkbox"]' ).on(
// 		'change',
// 		function() {
// 			const checkbox_values = jQuery( this ).parents( '.customize-control' ).find( 'input[type="checkbox"]:checked' ).map(
// 				function() {
// 					return this.value;
// 				}
// 			).get().join( ',' );
// 			jQuery( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
// 		}
// 	);
// } );
