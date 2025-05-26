import Swiper from "swiper/bundle";

export default {
	init() {
		const carousels = document.querySelectorAll(
			".fifty-fifty-carousel--swiper"
		);

		carousels.forEach((carousel) => {
			new Swiper(carousel, {
				loop: true,
				autoplay: {
					delay: 6000,
				},
				effect: "fade",
				speed: 2000,
				fadeEffect: {
					crossFade: true,
				},
				pagination: {
					el: carousel.querySelector(".swiper-pagination"),
				},
			});
		});
	},
	destroy() {},
};
