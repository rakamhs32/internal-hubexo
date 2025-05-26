import { Splide } from "@splidejs/splide";

export default {
	init() {
		document.querySelectorAll(".testimonials-slider").forEach((carousel) =>
			new Splide(carousel, {
				perPage: 1,
				type: "loop",
				pagination: false,
				type: "fade",
				rewind: true,
			}).mount()
		);
	},
	destroy() {},
};
