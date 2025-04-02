import Swiper from "swiper/bundle";

export default {
	init() {
		const carousels = document.querySelectorAll(".fullscreen-swiper");

		carousels.forEach((carousel) => {
			new Swiper(carousel, {
				loop: true,
				autoplay: {
					delay: 3000,
				},
				effect: "fade",
				speed: 2000,
				fadeEffect: {
					crossFade: true,
				},
			});
		});
	},
	destroy() {},
};
