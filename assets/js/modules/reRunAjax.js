import basicIntersections from "../modules/basicIntersections";

export default {
	init() {
		if (!document.querySelector(".blog-post-grid")) {
			return;
		}

		var open = window.XMLHttpRequest.prototype.open,
			send = window.XMLHttpRequest.prototype.send,
			onReadyStateChange;

		function openReplacement(method, url, async, user, password) {
			var syncMode = async !== false ? "async" : "sync";
			return open.apply(this, arguments);
		}

		function sendReplacement(data) {
			if (this.onreadystatechange) {
				this._onreadystatechange = this.onreadystatechange;
			}
			this.onreadystatechange = onReadyStateChangeReplacement;

			return send.apply(this, arguments);
		}

		function onReadyStateChangeReplacement() {
			setTimeout(function () {
				basicIntersections.init();
			}, 1);
			if (this._onreadystatechange) {
				return this._onreadystatechange.apply(this, arguments);
			}
		}

		window.XMLHttpRequest.prototype.open = openReplacement;
		window.XMLHttpRequest.prototype.send = sendReplacement;
	},
	destroy() {},
};
