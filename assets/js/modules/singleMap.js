export default {
	init() {
		if (!document.querySelector("#map")) {
			return;
		}
		var mapElement = document.getElementById("map");
		var mapField = {
			lat: parseFloat(mapElement.getAttribute("data-lat")),
			lng: parseFloat(mapElement.getAttribute("data-lng")),
		};

		if (!isNaN(mapField.lat) && !isNaN(mapField.lng)) {
			var mapOptions = {
				center: new google.maps.LatLng(mapField.lat, mapField.lng),
				zoom: 15, // You can set the initial zoom level here
				mapTypeId: google.maps.MapTypeId.ROADMAP,
			};
			var map = new google.maps.Map(mapElement, mapOptions);

			var customMarker = "/wp-content/themes/oyster/img/map-marker.png"; // Replace with your custom marker image URL

			var marker = new google.maps.Marker({
				position: mapOptions.center,
				map: map,
				icon: customMarker, // Set the custom marker image here
			});
		}
	},
	destroy() {},
};
