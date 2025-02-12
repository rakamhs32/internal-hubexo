export default {
	init() {
		const accordions = Array.from(document.querySelectorAll(".accordion")).map(
			(accordion) => {
				return {
					el: accordion,
					open: false,
					grow: accordion.querySelector(".accordion--grow"),
					heading: accordion.querySelector(".accordion--heading"),
					content: accordion.querySelector(".accordion--content"),
				};
			}
		);

		accordions.forEach((accordion) => {
			if (accordion.el.classList.contains("first")) {
				accordion.open = !accordion.open;
				accordion.grow.style.height =
					accordion.content.getBoundingClientRect().height + "px";
				accordion.el.classList.add("is-open");
			}
			accordion.heading.addEventListener("click", () => {
				accordion.open = !accordion.open;
				if (accordion.open) {
					accordion.grow.style.height =
						accordion.content.getBoundingClientRect().height + "px";
					accordion.el.classList.add("is-open");
				} else {
					accordion.el.classList.remove("is-open");
					accordion.grow.style.height = "0px";
				}
			});
		});

		window.addEventListener("resize", () => {
			accordions.forEach((accordion) => {
				if (accordion.open) {
					accordion.grow.style.height =
						accordion.content.getBoundingClientRect().height + "px";
				}
			});
		});
	},
	destroy() {
		// console.log('goodbye');
	},
};
