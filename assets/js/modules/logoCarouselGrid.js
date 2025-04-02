import { Splide } from "@splidejs/splide";
import { AutoScroll } from "@splidejs/splide-extension-auto-scroll";
import { Grid } from '@splidejs/splide-extension-grid';

export default {
  init() {
    document.querySelectorAll(".logo-slider.grid").forEach((carousel) =>
      new Splide(carousel, {
        // perPage: 7,
        autoWidth: true,
        type: "loop",
        arrows: false,
        gap: 20,
        pagination: false,
        autoScroll: {
          speed: 0.5,
          pauseOnHover: false,
        },
        grid: {
          rows: 2,
          // cols: 2,
          gap : {
            row: '1rem',
            col: '1.5rem',
          },
        },
        // breakpoints: {
        //   991: {
        //     perPage: 5,
        //   },
        //   767: {
        //     perPage: 3,
        //   },
        // },
      }).mount({AutoScroll, Grid })
    );
    // new Splide("#logo-carousel", {
    // 	perPage: 7,
    // 	type: "loop",
    // 	arrows: false,
    // 	pagination: false,
    // 	autoScroll: {
    // 		pauseOnHover: false,
    // 	},
    // 	breakpoints: {
    // 		991: {
    // 			perPage: 3,
    // 		},
    // 	},
    // }).mount({ AutoScroll });
  },
  destroy() {},
};
