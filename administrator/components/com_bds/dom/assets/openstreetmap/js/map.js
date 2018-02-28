if (typeof(maps) == 'undefined')
	var ck_maps = [];


var ck_loadMap = function (instance, keyAPI)
{

	initMap = function() {

		var mapObject = ck_maps[instance];
		var data = mapObject.data;


		// Instance the map
		var map = new OpenLayers.Map('map_' + instance);

  		// Add the layer
  		map.addLayer(new OpenLayers.Layer.OSM());


		// Store the bounds by ourself, becasue Google add some margins wich brakes the automatic fit
		map._ck = {
			'bounds': null,
			'zoom': data.zoom
		};

		// Store the OpenStreet object
		mapObject.osmObject = map;



		// Zoom
		var zoom = null;
		if (typeof(data.zoom) != 'undefined')
			zoom = data.zoom;


		// TODO : Bounds
		if (typeof(data.bounds) != 'undefined')
		{
			var b = data.bounds;
		}


		// Center
		if (typeof(data.center) != 'undefined')
		{
			var c = data.center;

			var centerPosition = new OpenLayers.LonLat(c.lng, c.lat);

			// TODO ????
			centerPosition.transform(
				new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
				map.getProjectionObject() // to Spherical Mercator Projection
			);

console.log(centerPosition);
console.log(zoom);


			map.setCenter (centerPosition, zoom);

		}



// TODO : Instance the markers
		if ((typeof(mapObject.markers) != 'undefined') && (typeof(mapObject.markers.data) != 'undefined'))
		{
			// Uses a layer for the markers
			var markersLayer = new OpenLayers.Layer.Markers( "Markers" );
	    	map.addLayer(markersLayer);


	    // TODO : FitBounds
	    // TODO : Icons (Sizes, Image)



			var markers = mapObject.markers.data;
			mapObject.markers.osmObject = [];
			var osmMarkers = mapObject.markers.osmObject;



			for (var i = 0 ; i < markers.length ; i++)
			{
				var markerData = markers[i];

				// Index the markers by id
				var idMarker = i;




				//Set the map to the data
				markerData.map = map;

				var markerPosition = null;
				if (typeof(markerData.position) != 'undefined')
				{

					var p = markerData.position;
					markerPosition = new OpenLayers.LonLat(p.lng, p.lat);

				    // TODO ????
				    markerPosition.transform(
						new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
						map.getProjectionObject() // to Spherical Mercator Projection
					);

				}

				var marker = null;

				if (markerPosition)
					marker = new OpenLayers.Marker(markerPosition);

				// Store the Open Street Object in order to keep it in the memory, and not be destroyed by the garbage colector.
				osmMarkers[idMarker] = marker;


				// Instance the marker on the layer
	   			markersLayer.addMarker(marker);


//TODO
var contentString = null;

				// Store the marker in the OSM object for extra features
				marker._ck = {
					'id': idMarker,
					'content': contentString,
				};

			}

		}


	    var lonLat = new OpenLayers.LonLat( -0.1279688 ,51.5077286 )
	          .transform(
	            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
	            map.getProjectionObject() // to Spherical Mercator Projection
	          );

	    var zoom=16;









	};

	jQuery.getScript("http://www.openlayers.org/api/OpenLayers.js", function( data, textStatus, jqxhr ) {
	  initMap();
	});



};

