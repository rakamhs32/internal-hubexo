export default {
	init() {
		if (!document.querySelector("[data-form]")) {
			return;
		}
		const modalFormButtons = document.querySelectorAll("[data-form]");
		const modalWrappers = document.querySelectorAll(".form-modal");
		const body = document.querySelector("body");
		const closeButtons = document.querySelectorAll(".form-modal--close");

		modalFormButtons.forEach((modalFormButton) => {
			modalFormButton.addEventListener("click", (e) => {
				var formToGet = document.querySelector(modalFormButton.dataset.form);
				formToGet.style.display = "flex";
				body.classList.add("modal-open");
				setTimeout(function () {
					formToGet.style.opacity = 1;
				}, 50);
			});
		});

		modalWrappers.forEach((modalWrapper) => {
			modalWrapper.addEventListener("click", (e) => {
				if (e.target !== e.currentTarget) {
				} else {
					body.classList.remove("modal-open");
					modalWrapper.style.opacity = 0;
					setTimeout(function () {
						modalWrapper.style.display = "none";
					}, 300);
				}
			});
		});
		closeButtons.forEach((closeButton) => {
			closeButton.addEventListener("click", (e) => {
				body.classList.remove("modal-open");
				closeButton.closest(".form-modal").style.opacity = 0;
				setTimeout(function () {
					closeButton.closest(".form-modal").style.display = "none";
				}, 300);
			});
		});
	},
	destroy() {},
};
