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
	},
	destroy() {},
};
