var InfiniteScroll = require("infinite-scroll");
import basicIntersections from "../modules/basicIntersections";

export default {
	init() {
		if (document.querySelector(".next-link")) {
			var elem = document.querySelector("#posts-wrap");
			var infScroll = new InfiniteScroll(elem, {
				// options
				path: ".next-link",
				append: ".blog-post-block",
				history: false,
			});

			infScroll.on("append", function (response, path, items) {
				basicIntersections.init();
			});
		}
	},
	destroy() {},
};
