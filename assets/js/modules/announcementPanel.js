import Cookies from "js-cookie";

export default {
	init() {
		if (document.querySelector(".announcement-modal")) {
			let agreedCookies = Cookies.get("oyster_promo_popup");
			let modalTime = document.querySelector(".announcement-modal").dataset
				.time;
			var modal = document.querySelector(".announcement-modal");
			var closeModalButtons = document.querySelectorAll(
				".close-announcement-modal"
			);

			if (typeof agreedCookies == "undefined") {
				setTimeout(function () {
					document.querySelector("body").classList.add("modal-open");
					modal.style.display = "flex";
					setTimeout(function () {
						modal.style.opacity = 1;
					}, 50);
				}, modalTime * 1000);
			}

			closeModalButtons.forEach((closeModalButton) => {
				closeModalButton.addEventListener("click", function (e) {
					Cookies.set("oyster_promo_popup");
					document.querySelector("body").classList.remove("modal-open");
					closeModalButton.closest(".announcement-modal").style.opacity = 0;
					setTimeout(function () {
						closeModalButton.closest(".announcement-modal").style.display =
							"none";
					}, 300);
				});
			});

			modal.addEventListener("click", function (e) {
				if (e.target !== this) return;
				modal.style.opacity = 0;
				setTimeout(function () {
					modal.style.display = "none";
				}, 300);
				document.querySelector("body").classList.remove("modal-open");
				Cookies.set("oyster_promo_popup");
			});
		}
	},
	destroy() {},
};
