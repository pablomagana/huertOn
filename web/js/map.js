$(function() {
	initMap();
});

var map;

// Initialise the FeatureGroup to store editable layers
var editableItems = new L.FeatureGroup();

var nonEditableItems = new L.FeatureGroup();

var nonEditableItemsBackup = new L.FeatureGroup();

function initMap() {
  //Inicializamos el mapa y sus controles (es necesário tener un div de id="map") y lo centramos en Valencia por defecto
  //Pedimos la geolocalización al usuario, si la acepta centramos el mapa en su ubicación, sinó mostramos el error por consola
  map = L.map('map', {
  	zoomControl: false
  });

  L.control.zoom({
  	position: 'topright',
  	zoomInTitle: 'Acercar',
  	zoomOutTitle: 'Alejar'
  }).addTo(map);

  L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

  map.setView([39.4077013, -0.5015955], 12);

  navigator.geolocation.getCurrentPosition(success, error, options);

  var options = {
  	enableHighAccuracy: true,
  	timeout: 5000,
  	maximumAge: 0
  };

  function success(pos) {
  	var crd = pos.coords;

  	console.log('Your current position is:');
  	console.log('Latitude : ' + crd.latitude);
  	console.log('Longitude: ' + crd.longitude);
  	console.log('More or less ' + crd.accuracy + ' meters.');

  	setMap(crd);
  };

  function error(err) {
  	console.warn('ERROR(' + err.code + '): ' + err.message);
  	setMap();
  };
}

function initDraw() {
  //Inicializamos el plugin Draw y añadimos la capa de layers que se van a poder editar (sólo polígonos)
  L.drawLocal = {
  	draw: {
  		toolbar: {
              // #TODO: this should be reorganized where actions are nested in actions
              // ex: actions.undo  or actions.cancel
              actions: {
              	title: 'Cancelar dibujo',
              	text: 'Cancelar'
              },
              finish: {
              	title: 'Terminar el dibujo',
              	text: 'Terminar'
              },
              undo: {
              	title: 'Eliminar el último punto dibujado',
              	text: 'Eliminar el último punto'
              },
              buttons: {
              	polyline: 'Dibuja una polilínea',
              	polygon: 'Dibuja un polígono!',
              	rectangle: 'Dibuja un rectángulo!',
              	circle: 'Dibuja un círculo!',
              	marker: 'Dibuja un marcador!'
              }
          },
          handlers: {
          	circle: {
          		tooltip: {
          			start: 'Click and drag to draw circle.'
          		},
          		radius: 'Radius'
          	},
          	marker: {
          		tooltip: {
          			start: 'Click map to place marker.'
          		}
          	},
          	polygon: {
          		tooltip: {
          			start: 'Haz clic para empezar a dibujar la forma.',
          			cont: 'Haz clic para continuar dibujando la forma.',
          			end: 'Haz clic en primer punto para cerrar esta forma.'
          		}
          	},
          	polyline: {
          		error: '<strong>Error:</strong> shape edges cannot cross!',
          		tooltip: {
          			start: 'Click to start drawing line.',
          			cont: 'Click to continue drawing line.',
          			end: 'Click last point to finish line.'
          		}
          	},
          	rectangle: {
          		tooltip: {
          			start: 'Click and drag to draw rectangle.'
          		}
          	},
          	simpleshape: {
          		tooltip: {
          			end: 'Release mouse to finish drawing.'
          		}
          	}
          }
      },
      edit: {
      	toolbar: {
      		actions: {
      			save: {
      				title: 'Guardar cambios.',
      				text: 'Guardar'
      			},
      			cancel: {
      				title: 'Cancelar la edición, descarta todos los cambios.',
      				text: 'Cancelar'
      			}
      		},
      		buttons: {
      			edit: 'Editar capas.',
      			editDisabled: 'No hay capas que editar.',
      			remove: 'Eliminar capas.',
      			removeDisabled: 'No hay capas que eliminar.'
      		}
      	},
      	handlers: {
      		edit: {
      			tooltip: {
      				text: 'Arrastre los puntos o marcadores para editar la forma.',
      				subtext: 'Haga clic en cancelar para deshacer los cambios.'
      			}
      		},
      		remove: {
      			tooltip: {
      				text: 'Haga clic en una forma para eliminar'
      			}
      		}
      	}
      }
  };

        // Initialise the draw control and pass it the FeatureGroup of editable layers
        var drawControl = new L.Control.Draw({
        	draw: {
        		marker: false,
        		circle: false,
        		polyline: false,
        		rectangle: false,
        		polygon: {
        			allowIntersection: true,
        			showArea: true,
							shapeOptions: {
                    color: '#3388ff',
										opacity: 1,
										fillOpacity: 0.2
              }
        		}
        	},
        	edit: {
        		featureGroup: editableItems,
        		remove: false
        	}
        });
        map.addControl(drawControl);
    }

    function initGeocoder() {
  //Inicializamos el plugin Geocoder y devolvemos la variable para poder utilizarla más tarde
  var options = {
  	markers: {draggable :true},
  	layers: 'address',
  	'boundary.country': 'ES',
  	sources: 'oa',
  	position: 'topright',
  	fullWidth: false,
  	placeholder: 'Busca tu dirección'
  };

  var geocoder = L.control.geocoder('mapzen-9gW9cQ', options).addTo(map);

  return geocoder;
}

function setMap(crd){
  //Si el usuario ha permitido la geolocalización centramos el mapa en su ubicación
  if(crd != undefined) {
  	map.setView([crd.latitude, crd.longitude], 12);
  }

  map.addLayer(editableItems);

  map.addLayer(nonEditableItems);

	if($('#Geometry').val() != '') {
		retrieveGeometry($('#Geometry').val());
	}

  initDraw();

  var deleting = false;

  map.on('draw:drawstart', function (e) {
  	var type = e.layerType,
  	layer = e.layer;

    //Cuando empezemos a dibujar debemos borrar todas las capas para evitar conflictos

    clearEditableLayer(true);

    clearNonEditableLayer(true);

    $('#orchard-geometry').attr('value', "");
});

  map.on('draw:created', function (e) {
  	var type = e.layerType,
  	layer = e.layer;

  	layer.on('click', function(e) {
  		if(deleting) {
  			console.log('Borrando capa no editable');
  			clearNonEditableLayer(true);
  		}
  	});

    // Do whatever else you need to. (save to db, add to map etc)
    map.addLayer(layer);

    editableItems.addLayer(layer);

    var marker = L.marker([layer.getBounds().getCenter().lat, layer.getBounds().getCenter().lng], {draggable: true});

    prepareMarker(marker);
});

  map.on('draw:edited', function (e) {
  	var layers = e.layers;
  	layers.eachLayer(function (layer) {
  		prepareGeometry(undefined, layer);
  	});
  });


}

function reverseGeocoding(marker) {
	$.getJSON('https://search.mapzen.com/v1/reverse?api_key=mapzen-imBC1aC&point.lat='+marker.getLatLng().lat+'&point.lon='+marker.getLatLng().lng+'&size=1&layers=address&boundary.country=ES', function(data, status, xhr) {
		if(data.features[0] == undefined){
			marker.bindPopup('No se han encontrado resultados.').openPopup();
		}else{
			marker.bindPopup(data.features[0].properties.label).openPopup();
			if(data.features[0].properties.locality != null){
				var circle = L.circle([marker.getLatLng().lat, marker.getLatLng().lng], data.features[0].properties.distance*1000).addTo(map);
				nonEditableItems.addLayer(circle);
				$('#Town').attr('value', data.features[0].properties.locality).trigger('change');
				$('#Street').attr('value', data.features[0].properties.street).trigger('change');
				$('#Number').attr('value', data.features[0].properties.housenumber).trigger('change');
				$('#Zipcode').attr('value', data.features[0].properties.postalcode).trigger('change');
				console.log('Número '+data.features[0].properties.housenumber+', Calle '+data.features[0].properties.street+', Localidad '+data.features[0].properties.locality+', CP '+data.features[0].properties.postalcode+', Pais '+data.features[0].properties.country+', Distancia '+data.features[0].properties.distance*1000+' m, Exacto a '+data.features[0].properties.confidence);
			}else{
				var circle = L.circle([marker.getLatLng().lat, marker.getLatLng().lng], data.features[0].properties.distance*1000).addTo(map);
				nonEditableItems.addLayer(circle);
				$('#Town').attr('value', data.features[0].properties.localadmin).trigger('change');
				$('#Street').attr('value', data.features[0].properties.street).trigger('change');
				$('#Number').attr('value', data.features[0].properties.housenumber).trigger('change');
				$('#Zipcode').attr('value', data.features[0].properties.postalcode).trigger('change');
				console.log('Número '+data.features[0].properties.housenumber+', Calle '+data.features[0].properties.street+', Localidad '+data.features[0].properties.localadmin+', Pais '+data.features[0].properties.country+', Distancia '+data.features[0].properties.distance*1000+' m, Exacto a '+data.features[0].properties.confidence);
			}
		}
	});

	if(map.hasLayer(editableItems.getLayers()[editableItems.getLayers().length - 1])) {
		prepareGeometry(marker, editableItems.getLayers()[editableItems.getLayers().length - 1]);
	}else{
		prepareGeometry(marker);
	}
}

function storeGeometry(layer) {
    //Layer puede ser tanto un polígono como un marcador
    //Convertimos el layer a un objetivo GeoJSON y lo convertimos a string para poder guardarlo
    var geojson = layer.toGeoJSON();
    var forma = JSON.stringify(geojson);

    return forma;
}

function retrieveGeometry(geometry) {
    //Geometry será el string recuperado de la BBDD
    //Convertimos el string en un objeto JSON eliminando los errores y lo añadimos al mapa
    var geojsonFeature = JSON.parse(geometry.replace(/&quot;/g,'"'));

		console.log(geojsonFeature);

		//Si es un array es porque contiene un punto y un polígono
		if(Object.prototype.toString.call(geojsonFeature) === '[object Array]') {
    	var geojsonFeaturePoint = geojsonFeature[0];
			var geojsonFeaturePolygon = geojsonFeature[1];
			if(geojsonFeaturePoint.geometry.type == 'Point') {
				var marker = L.marker([geojsonFeaturePoint.geometry.coordinates[1], geojsonFeaturePoint.geometry.coordinates[0]], {draggable: true});
				prepareMarker(marker);
			}
			if(geojsonFeaturePolygon.geometry.type == 'Polygon') {
				var layer = L.geoJson(geojsonFeaturePolygon).addTo(map);

				editableItems.addLayer(layer);
			}
		}else {
			if(geojsonFeature.geometry.type == 'Point') {
				var marker = L.marker([geojsonFeature.geometry.coordinates[1], geojsonFeature.geometry.coordinates[0]], {draggable: true});
				prepareMarker(marker);
			}
		}
}

function prepareMarker(marker) {

	//Borramos la capa no editable para evitar conflictos
	clearNonEditableLayer(true);

	marker.on('dragend', function() { reverseGeocoding(marker); });

	marker.on('dragstart', function() {
		clearNonEditableLayer(false);
	});

	marker.addTo(map);

	nonEditableItems.addLayer(marker);

	reverseGeocoding(marker);

	map.setView([marker.getLatLng().lat, marker.getLatLng().lng], 19);
}

function prepareGeometry(marker, polygon) {
	var geojsonFeature;
	if(marker != undefined) {
		geojsonFeature = {
			"type": "Feature",
			"properties": {},
			"geometry": {
				"type": "Point",
				"coordinates": [marker.getLatLng().lng, marker.getLatLng().lat]
			}
		};
	}

	$('#Latitude').attr('value', marker.getLatLng().lat);
	$('#Longitude').attr('value', marker.getLatLng().lng);

	if(polygon != undefined) {
		var geojson = polygon.toGeoJSON()
		var forma = JSON.stringify(geojson);

		if(marker == undefined) {
			$('#Geometry').attr('value', $('#Geometry').val().slice(0, 121)+forma+']');
		}else{
			$('#Geometry').attr('value', '['+JSON.stringify(geojsonFeature)+', '+forma+']');
		}
	}else{
		$('#Geometry').attr('value', JSON.stringify(geojsonFeature));
	}
}

function clearEditableLayer(all) {
	editableItems.eachLayer(function(layer) {
		if(all) {
			map.removeLayer(layer);
		}else{
			if(layer instanceof L.Circle) {
				map.removeLayer(layer);
			}
		}
	});
}

function clearNonEditableLayer(all) {
	nonEditableItems.eachLayer(function(layer) {
		if(all) {
			map.removeLayer(layer);
		}else{
			if(layer instanceof L.Circle) {
				map.removeLayer(layer);
			}
		}
	});
}
