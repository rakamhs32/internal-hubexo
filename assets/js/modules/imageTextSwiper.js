import Swiper from "swiper/bundle";

export default {
	init() {
		const swiper = new Swiper(".image-text-swiper", {
			// Optional parameters
			loop: true,
			autoplay: true,
			effect: "fade",
			speed: 3000,
			fadeEffect: {
				crossFade: true,
			},
		});
	},
	destroy() {},
};
