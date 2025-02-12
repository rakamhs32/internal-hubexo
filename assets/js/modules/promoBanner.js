import Cookies from "js-cookie";

export default {
	init() {
		function showPromoBanner() {
			if (document.querySelector(".header-message")) {
				const promoBanner = document.querySelector(".header-message");
				const body = document.querySelector("body");
				let agreedCookies = Cookies.get("hubexo_promo_banner");
				if (typeof agreedCookies == "undefined") {
					promoBanner.style.display = "block";
					body.classList.add("has-promo-banner");
				}
			}
		}
		showPromoBanner();

		function hidePromoBanner() {
			if (document.querySelector(".header-message")) {
				const promoButton = document.querySelector(".header-message button");
				const promoBanner = document.querySelector(".header-message");
				const body = document.querySelector("body");
				promoButton.addEventListener("click", function () {
					Cookies.set("hubexo_promo_banner");
					promoBanner.style.display = "none";
					body.classList.remove("has-promo-banner");
				});
			}
		}

		hidePromoBanner();
	},
	destroy() {},
};
