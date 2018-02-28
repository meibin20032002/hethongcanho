if (typeof(maps) == 'undefined')
	var ck_maps = [];


var ck_loadMap = function (instance, keyAPI)
{

	var geoCodeMap = function (map, address)
	{
		geocoder = new google.maps.Geocoder();
		geocoder.geocode({
			'address': address
	    }, function(results, status)
	    {
			if (status == google.maps.GeocoderStatus.OK)
			{
				var position = results[0].geometry.location;
				map.setCenter(position);
	        }
	    });
	};

	var geoCodeMarker = function (marker, address, fitMap, callback)
	{
		geocoder = new google.maps.Geocoder();
		geocoder.geocode({
			'address': address
	    }, function(results, status)
	    {
			if (status == google.maps.GeocoderStatus.OK)
			{
				var position = results[0].geometry.location;
				marker.setPosition(position);

				if (fitMap)
				{
					if (fitMap._ck.bounds)
					{
						fitMap._ck.bounds.extend(position);
						fitMap.fitBounds(fitMap._ck.bounds);
					}
					else
					{
						fitMap._ck.bounds = new google.maps.LatLngBounds(
							new google.maps.LatLng(position.lat(), position.lng()),
							new google.maps.LatLng(position.lat(), position.lng())
						);
						fitMap.setCenter(position);
					}
				}


	        }
	    });
	};



	initMap = function() {

		var mapObject = ck_maps[instance];
		var data = mapObject.data;


		// MapTypeId : Convert to the Google constant (MapTypeId)
		if (typeof(data.mapType) != 'undefined')
		{
			data.mapTypeId = google.maps.MapTypeId[data.mapType];
			data.mapType = null; // Optimisation
		}

		var map = new google.maps.Map(document.getElementById('map_' + instance), data);

		// Store the bounds by ourself, becasue Google add some margins wich brakes the automatic fit
		map._ck = {
			'bounds': null,
			'zoom': data.zoom
		};

		mapObject.googleObject = map;


		var mapPosition = map.getCenter();
		if ((typeof(markerPosition) == 'undefined')
		  && typeof(data.address) != 'undefined')
		{
			geoCodeMap(map, data.address);
		}

		// Bounds : Convert to the Google Bounds (LatLngBounds)
		if (typeof(data.bounds) != 'undefined')
		{
			var b = data.bounds;
			map.fitBounds(new google.maps.LatLngBounds(
				new google.maps.LatLng(b.south, b.west),
				new google.maps.LatLng(b.north, b.east)
				));
		}


		// Instance the markers
		if ((typeof(mapObject.markers) != 'undefined') && (typeof(mapObject.markers.data) != 'undefined'))
		{
			var fitBounds = false;
			if (typeof(mapObject.markers.fitBounds) != 'undefined')
				fitBounds = mapObject.markers.fitBounds;

			if (fitBounds)
			{
				map._ck.bounds = new google.maps.LatLngBounds();
				map._ck.bounds = null;
			}


			// Global Icon sizes
			var iconSizeWidth = 20;
			if (typeof(mapObject.markers.iconWidth) != 'undefined')
				iconSizeWidth = mapObject.markers.iconWidth;

			var iconSizeHeight = 32;
			if (typeof(mapObject.markers.iconHeight) != 'undefined')
				iconSizeHeight = mapObject.markers.iconHeight;


			// Global Animations
			var animation = null;
			if (typeof(mapObject.markers.animation) != 'undefined')
				animation = google.maps.Animation['mapObject.markers.animation'];


			var markers = mapObject.markers.data;
			mapObject.markers.googleObject = [];
			var googleMarkers = mapObject.markers.googleObject;


			for (var i = 0 ; i < markers.length ; i++)
			{
				var markerData = markers[i];

				// Index the markers by id
				var idMarker = i;

				// Set the amimation
				if (animation)
					markerData.animation = animation;

				//Set the map to the data
				markerData.map = map;

				if (typeof(markerData.icon) != 'undefined')
				{

					// Get special sizes for every single marker
					var iconWidth = iconSizeWidth;
					if (typeof(markerData.iconWidth) != 'undefined')
						iconWidth = markerData.iconWidth;

					var iconHeight = iconSizeHeight;
					if (typeof(markerData.iconHeight) != 'undefined')
						iconHeight = markerData.iconHeight;



					markerData.icon = new google.maps.MarkerImage(markerData.icon,
						new google.maps.Size(iconWidth, iconHeight),
						new google.maps.Point(0,0),
						new google.maps.Point(0, 32)
					);
				}

				// Optimization : Don't sent the content string to the marker constructor
				var contentString = null;
				if (typeof(markerData.content) != 'undefined')
				{
					contentString = markerData.content;
					markerData.content = null;
				}

				// Create the marker
				var marker = new google.maps.Marker(markerData);

				// Store the Google Object in order to keep it in the memory, and not be destroyed by the garbage colector.
				googleMarkers[idMarker] = marker;

				// Store the marker in the Google object for extra features
				marker._ck = {
					'id': idMarker,
					'content': contentString,
				};

				// Info Window
				if (contentString)
				{
					// Click Event : Show the Info Window
					marker.addListener('click', function()
					{
						var datas = this._ck;

						var infowindow = new google.maps.InfoWindow({
							content: datas.content
						});
						datas.infowindow = infowindow;

						// Close other info windows
						for (var j = 0 ; j < googleMarkers.length ; j++)
						{
							var m = googleMarkers[j];
							var dat = m._ck;
							if (typeof(dat.infowindow) != 'undefined')
								dat.infowindow.close();
						}

						infowindow.open(map, this);
					});
				}


				var markerPosition = marker.getPosition();
				if ((typeof(markerPosition) != 'undefined'))
				{
					if (fitBounds)
					{
						if (!map._ck.bounds)
						{
							map._ck.bounds = new google.maps.LatLngBounds(
								new google.maps.LatLng(markerPosition.lat(), markerPosition.lng()),
								new google.maps.LatLng(markerPosition.lat(), markerPosition.lng())
							);
							map.setCenter(markerPosition);
						}
						else
						{
							map._ck.bounds.extend(markerPosition);
						}
					}
				}
				else if (typeof(markerData.address) != 'undefined')
				{
					geoCodeMarker(marker, markerData.address, (fitBounds?map:null));
				}
			}

			if (fitBounds && map._ck.bounds && (markers.length > 1))
				map.fitBounds(map._ck.bounds);

		}

		// Instance the directions
		if (typeof(mapObject.directions) != 'undefined')
		{

			var directionsDisplay = new google.maps.DirectionsRenderer({
				map: map
			});

			var directions = mapObject.directions;
			for (var i = 0 ; i < directions.length ; i++)
			{
				var directionsObject = directions[i];

				// Set destination, origin and travel mode.
				var request = {
					destination: directionsObject.destination,
					origin: directionsObject.origin,
					travelMode: google.maps.TravelMode.DRIVING//google.maps.TravelMode[directionsObject.travelMode]
				};

				// Pass the directions request to the directions service.
				var directionsService = new google.maps.DirectionsService();
					directionsService.route(request, function(response, status) {
					if (status == google.maps.DirectionsStatus.OK) {
						// Display the route on the map.
						directionsDisplay.setDirections(response);
					}
				});
			}

		}
	};

	jQuery.getScript("https://maps.googleapis.com/maps/api/js?key=" + keyAPI + "&callback=initMap");
};




/*
 * Sample code for initializing a map named 'default'
 *
 *
 *
ck_maps['default'] = {
	data: {
		center: {lat: -34.397, lng: 150.644},
		scrollwheel: false,
		zoom: 8
	}
};

*/



/*
 * Sample code for loading a map named 'default'
 *
 *
 *
(function ($) {
	$('document').ready(function(){
		ck_loadMap('default');
	});
})(jQuery);


*/