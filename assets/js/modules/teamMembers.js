import Masonry from "masonry-layout";

export default {
	init() {
		if (!document.querySelector(".team-member")) {
			return;
		}

		var grid = document.querySelector(".grid");
		var msnry = new Masonry(grid, {
			// options...
			itemSelector: ".grid-item",
			gutter: 24,
			percentPosition: true,
			horizontalOrder: true,
		});

		const teamMemberButtons = document.querySelectorAll(".team-member--button");

		teamMemberButtons.forEach((teamMemberButton) => {
			teamMemberButton.addEventListener("click", (e) => {
				const teamMember = teamMemberButton.closest(".team-member");
				teamMember.classList.toggle("active");

				const buttonText = teamMemberButton.querySelector(".button--text");
				if (buttonText.textContent === "Show more") {
					buttonText.textContent = "Show less";
				} else {
					buttonText.textContent = "Show more";
				}

				// Trigger Masonry layout refresh
				msnry.layout();
			});
		});
	},
	destroy() {},
};
