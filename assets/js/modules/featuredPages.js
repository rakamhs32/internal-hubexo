import Swiper from "swiper/bundle";

export default {
	textAndImageCarousels: [], // An array to store the swiper instances
	init() {
		const swiperElements = document.querySelectorAll(
			".featured-pages--carousel"
		); // Assuming you use a common class for swiper containers

		swiperElements.forEach((element) => {
			const swiper = new Swiper(element, {
				spaceBetween: 10,
				slidesPerView: 1.5,
				// Add other swiper options here
				speed: 500,
				freeMode: true,
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
				},
				breakpoints: {
					768: {
						slidesPerView: 2.5,
						loop: false,
						spaceBetween: 23,
					},
					1200: {
						slidesPerView: 3,
						loop: false,
						spaceBetween: 23,
					},
				},
			});

			this.textAndImageCarousels.push(swiper); // Store the swiper instance in the array
		});
	},
	destroy() {
		this.textAndImageCarousels.forEach((swiper) => {
			swiper.destroy();
		});
	},
};
