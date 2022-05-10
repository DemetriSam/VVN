window.onload = function () {
	document.addEventListener("click", documentActions);
	checkTheCart();
	// Actions (делегирование события click)
	function documentActions(e) {
		const targetElement = e.target;
		if (targetElement.classList.contains('search-form__icon')) {
			document.querySelector('.search-form').classList.toggle('_active');
			setTimeout(function () {
				document.getElementById('search_input').focus();
				document.getElementById('search_input').select();
			}, 100);


		} else if (!targetElement.closest('.search-form') && document.querySelector('.search-form._active')) {
			document.querySelector('.search-form').classList.remove('_active');
		}

		if (targetElement.classList.contains('add-to-cart')) {
			const productId = targetElement.closest('.the-product').dataset.nid;
			addToCart(productId);
		}
	}
}


