export default {
	init() {
		if (!document.querySelector("#hamburger")) {
			return;
		}
		const navButton = document.querySelector("#hamburger");
		const navText = document.querySelector(".hamburger--text");

		navButton.addEventListener("click", function () {
			this.classList.toggle("is-active");
			document.body.classList.toggle("menu-open");
			if (navText.textContent === "Menu") {
				navText.textContent = "Close";
			} else {
				navText.textContent = "Menu";
			}
		});

		const mobileButtons = document.querySelectorAll(".mobile-button");

		mobileButtons.forEach((mobileButton) => {
			mobileButton.addEventListener("click", function (e) {
				e.preventDefault();
				mobileButton.closest("li").classList.toggle("active");
			});
		});

		// const mediaQuery = window.matchMedia("(max-width: 991px)");

		// function handleMenuToggle(e) {
		// 	e.preventDefault();
		// 	this.classList.toggle("active");
		// }

		// function attachEventListeners() {
		// 	const parentLinks = document.querySelectorAll(
		// 		"li.menu-item-has-children > a"
		// 	);

		// 	parentLinks.forEach((parentLink) => {
		// 		parentLink.addEventListener("click", handleMenuToggle);
		// 	});
		// }

		// function removeEventListeners() {
		// 	const parentLinks = document.querySelectorAll(
		// 		"li.menu-item-has-children a"
		// 	);

		// 	parentLinks.forEach((parentLink) => {
		// 		parentLink.removeEventListener("click", handleMenuToggle);
		// 	});
		// }

		// function handleScreenSizeChange(e) {
		// 	if (e.matches) {
		// 		attachEventListeners();
		// 	} else {
		// 		removeEventListeners();
		// 	}
		// }

		// mediaQuery.addListener(handleScreenSizeChange);
		// handleScreenSizeChange(mediaQuery);
	},
	destroy() {},
};
