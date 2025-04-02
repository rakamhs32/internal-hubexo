window.cookieConsent = window.cookieConsent || [];
cookieConsent.consent_default = {
	accepted: false,
	groups: {
		necessary: "granted",
		analytics: "granted",
		marketing: "granted",
	},
};
cookieConsent.consent_values = {
	true: "granted",
	false: "denied",
	granted: true,
	denied: false,
};
cookieConsent.cookie_name = "CookieConsent";
cookieConsent.cookie_timeout = 31449600000;

cookieConsent.checkItemExists = function (obj) {
	if (
		typeof obj === "undefined" ||
		obj === null ||
		obj === "null" ||
		obj === "" ||
		obj === "undefined"
	)
		return false;
	return obj;
};

cookieConsent.setupEventListener = function (elm, func, type, capture) {
	if (cookieConsent.checkItemExists(elm) !== false) {
		var type = type || "click";
		var capture = capture || void 0;

		if (type === "click" || type === "onclick") {
			elm.addEventListener
				? elm.addEventListener("click", func, capture)
				: elm.attachEvent("onclick", func);
		} else {
			elm.addEventListener(type, func, capture);
		}
	}
};

cookieConsent.removeEventListener = function (elm, func, type, capture) {
	if (cookieConsent.checkItemExists(elm) !== false) {
		var type = type || "click";
		var capture = capture || void 0;

		if (elm.removeEventListener) {
			if (type === "click" || type === "onclick") {
				elm.removeEventListener("click", func, capture);
			} else {
				elm.removeEventListener(type, func, capture);
			}
		}
	}
};

cookieConsent.setConsent = function (data) {
	if (cookieConsent.checkItemExists(data) !== false) {
		var name = cookieConsent.cookie_name;
		var storeTime = cookieConsent.cookie_timeout || 0;
		var data = JSON.stringify(data) || "";

		if (
			cookieConsent.checkItemExists(storeTime) === false ||
			storeTime === 0 ||
			typeof storeTime !== "number"
		) {
			var expiry = "Thu, 01 Jan 1970 00:00:01 GMT";
		} else {
			var date = new Date();
			date.setTime(date.getTime() + storeTime);
			var expiry = date.toUTCString();
		}

		if (location.protocol === "https:") {
			var secureValue = "secure";
		} else {
			var secureValue = "";
		}

		document.cookie =
			name +
			"=" +
			data +
			";expires=" +
			expiry +
			";domain=oystercarehomes.co.uk" +
			";path=/;" +
			secureValue;

		return true;
	} else {
		return false;
	}
};

cookieConsent.getConsent = function () {
	if (cookieConsent.checkItemExists(cookieConsent.cookie_name) !== false) {
		var name = cookieConsent.cookie_name;
		var value = "; " + document.cookie;
		var parts = value.split("; " + name + "=");

		if (parts.length == 2) {
			var cookie = parts.pop().split(";").shift();
			return cookie;
		}
		return "";
	} else {
		return false;
	}
};

cookieConsent.JSONparseSavedConsentString = function (savedString) {
	try {
		return JSON.parse(savedString);
	} catch (e) {
		return cookieConsent.consent_default;
	}
};

cookieConsent.changeVisiblePage = function (pageToReveal) {
	if (pageToReveal === "page_main") {
		if (cookieConsent.checkItemExists(cookieConsent.elm.background_blur))
			cookieConsent.elm.background_blur.style.display = "block";
		if (cookieConsent.checkItemExists(cookieConsent.elm.page_main))
			cookieConsent.elm.page_main.style.display = "block";
		if (cookieConsent.checkItemExists(cookieConsent.elm.page_secondary))
			cookieConsent.elm.page_secondary.style.display = "none";
	} else if (pageToReveal === "page_secondary") {
		cookieConsent.updateUserToggles();

		if (cookieConsent.checkItemExists(cookieConsent.elm.background_blur))
			cookieConsent.elm.background_blur.style.display = "block";
		if (cookieConsent.checkItemExists(cookieConsent.elm.page_main))
			cookieConsent.elm.page_main.style.display = "none";
		if (cookieConsent.checkItemExists(cookieConsent.elm.page_secondary))
			cookieConsent.elm.page_secondary.style.display = "flex";
	} else {
		if (cookieConsent.checkItemExists(cookieConsent.elm.background_blur))
			cookieConsent.elm.background_blur.style.display = "none";
		if (cookieConsent.checkItemExists(cookieConsent.elm.page_main))
			cookieConsent.elm.page_main.style.display = "none";
		if (cookieConsent.checkItemExists(cookieConsent.elm.page_secondary))
			cookieConsent.elm.page_secondary.style.display = "none";
	}
};

cookieConsent.updateUserToggles = function () {
	if (
		cookieConsent.checkItemExists(cookieConsent.elm.button_secondary_toggles)
	) {
		for (
			var toggle = 0;
			toggle < cookieConsent.elm.button_secondary_toggles.length;
			toggle++
		) {
			var toggle_name =
				cookieConsent.elm.button_secondary_toggles[toggle].value;

			if (
				typeof cookieConsent.consent_current.groups[toggle_name] !==
					"undefined" &&
				toggle_name !== "necessary"
			) {
				cookieConsent.elm.button_secondary_toggles[toggle].checked =
					cookieConsent.consent_values[
						cookieConsent.consent_current.groups[toggle_name]
					] || false;
			}
		}
	}
};

cookieConsent.updateExternal = function (excludeEventName) {
	dataLayerObject = {
		consent: cookieConsent.consent_current,
	};

	if (!excludeEventName) {
		dataLayerObject.event = "cookie_consent";
	}
	window.dataLayer = window.dataLayer || [];
	window.dataLayer.push(dataLayerObject);
};

cookieConsent.acceptAll = function () {
	for (var group in cookieConsent.consent_current.groups) {
		cookieConsent.consent_current.groups[group] =
			cookieConsent.consent_values[true];
	}
	cookieConsent.consent_current.accepted = true;
};

cookieConsent.acceptSpecific = function () {
	if (
		cookieConsent.checkItemExists(cookieConsent.elm.button_secondary_toggles)
	) {
		for (
			var toggle = 0;
			toggle < cookieConsent.elm.button_secondary_toggles.length;
			toggle++
		) {
			var toggle_name =
				cookieConsent.elm.button_secondary_toggles[toggle].value;
			var toggle_state =
				cookieConsent.elm.button_secondary_toggles[toggle].checked;

			if (
				typeof cookieConsent.consent_current.groups[toggle_name] !== "undefined"
			) {
				cookieConsent.consent_current.groups[toggle_name] =
					cookieConsent.consent_values[toggle_state];
			}
		}
	}
	cookieConsent.consent_current.accepted = true;
};

cookieConsent.loadElements = function () {
	cookieConsent.elm = [];
	cookieConsent.elm.button_main_accept = document.querySelector(
		"#cookie-consent .page.main .controls button.acceptall"
	);
	cookieConsent.elm.button_main_manage = document.querySelector(
		"#cookie-consent .page.main .controls button.manage"
	);
	cookieConsent.elm.button_secondary_accpet = document.querySelector(
		"#cookie-consent .page.secondary .controls button.acceptall"
	);
	cookieConsent.elm.button_secondary_save = document.querySelector(
		"#cookie-consent .page.secondary .controls button.save"
	);
	cookieConsent.elm.button_secondary_toggles = document.querySelectorAll(
		"#cookie-consent .page.secondary .toggles .toggle-set input[type=checkbox]"
	);
	cookieConsent.elm.page_main = document.querySelector(
		"#cookie-consent .page.main"
	);
	cookieConsent.elm.page_secondary = document.querySelector(
		"#cookie-consent .page.secondary"
	);
	cookieConsent.elm.background_blur = document.querySelector(
		"#cookie-consent .blur"
	);
	cookieConsent.elm.button_expand_partners = document.querySelectorAll(
		"#cookie-consent .partner-section-title"
	);
};

cookieConsent.detachEventsFromElements = function () {
	cookieConsent.removeEventListener(
		cookieConsent.elm.button_main_manage,
		cookieConsent.clickFunctions.button_main_manage
	);
	cookieConsent.removeEventListener(
		cookieConsent.elm.button_main_accept,
		cookieConsent.clickFunctions.button_main_accept
	);
	cookieConsent.removeEventListener(
		cookieConsent.elm.button_secondary_accpet,
		cookieConsent.clickFunctions.button_secondary_accpet
	);
	cookieConsent.removeEventListener(
		cookieConsent.elm.button_secondary_save,
		cookieConsent.clickFunctions.button_secondary_save
	);
};

cookieConsent.clickFunctions = [];
cookieConsent.clickFunctions.button_main_manage = function () {
	cookieConsent.changeVisiblePage("page_secondary");
};
cookieConsent.clickFunctions.button_main_accept = function () {
	cookieConsent.changeVisiblePage(null);
	cookieConsent.acceptAll();
	cookieConsent.setConsent(cookieConsent.consent_current);
	cookieConsent.updateExternal();
	cookieConsent.detachEventsFromElements();
};
cookieConsent.clickFunctions.button_secondary_accpet = function () {
	cookieConsent.changeVisiblePage(null);
	cookieConsent.acceptAll();
	cookieConsent.setConsent(cookieConsent.consent_current);
	cookieConsent.updateExternal();
	cookieConsent.detachEventsFromElements();
};
cookieConsent.clickFunctions.button_secondary_save = function () {
	cookieConsent.changeVisiblePage(null);
	cookieConsent.acceptSpecific();
	cookieConsent.setConsent(cookieConsent.consent_current);
	cookieConsent.updateExternal();
	cookieConsent.detachEventsFromElements();
};
cookieConsent.clickFunctions.button_expand_partners = function (event) {
	var elm_parent = this.parentNode;
	var elm_expand_symbol = this.querySelector("span");
	var elm_partners_list = elm_parent.querySelector(".partner-list");

	if (elm_partners_list.classList.contains("open")) {
		if (elm_expand_symbol) elm_expand_symbol.innerText = "+";
		if (elm_partners_list) elm_partners_list.classList.remove("open");
	} else {
		if (elm_expand_symbol) elm_expand_symbol.innerText = "-";
		if (elm_partners_list) elm_partners_list.classList.add("open");
	}
};

cookieConsent.loadUserControls = function () {
	cookieConsent.loadElements();

	//Reveal the secondary page containing granular controls
	cookieConsent.setupEventListener(
		cookieConsent.elm.button_main_manage,
		cookieConsent.clickFunctions.button_main_manage
	);

	//Accept all cookies from all groups via main page
	cookieConsent.setupEventListener(
		cookieConsent.elm.button_main_accept,
		cookieConsent.clickFunctions.button_main_accept
	);

	//Accept all cookies from all groups via secondary page
	cookieConsent.setupEventListener(
		cookieConsent.elm.button_secondary_accpet,
		cookieConsent.clickFunctions.button_secondary_accpet
	);

	//Accept specific cookies defined by user toggle settings
	cookieConsent.setupEventListener(
		cookieConsent.elm.button_secondary_save,
		cookieConsent.clickFunctions.button_secondary_save
	);

	//Exapnd the list of associated partners to reveal policy links
	for (var i = 0; i < cookieConsent.elm.button_expand_partners.length; i++) {
		cookieConsent.setupEventListener(
			cookieConsent.elm.button_expand_partners[i],
			cookieConsent.clickFunctions.button_expand_partners
		);
	}

	cookieConsent.changeVisiblePage("page_main");
};

cookieConsent.init = function () {
	var savedConsent = cookieConsent.getConsent();

	if (savedConsent === false || savedConsent === "") {
		cookieConsent.consent_current = cookieConsent.consent_default;
	} else {
		cookieConsent.consent_current =
			cookieConsent.JSONparseSavedConsentString(savedConsent);
	}

	if (cookieConsent.consent_current.accepted === false) {
		if (
			document.readyState === "interactive" ||
			document.readyState === "complete"
		) {
			cookieConsent.loadUserControls();
		} else {
			cookieConsent.setupEventListener(
				window,
				cookieConsent.loadUserControls,
				"DOMContentLoaded"
			);
		}
	}

	var excludeEventName = true;
	cookieConsent.updateExternal(excludeEventName);
};

cookieConsent.init();
