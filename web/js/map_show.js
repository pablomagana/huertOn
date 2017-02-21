$(function(){initMap()});var map;var map_mobile;var hasMobile=!1;if($('#map-show-mobile').length){hasMobile=!0}
function initMap(){map=L.map('map-show',{zoomControl:!1,scrollWheelZoom:!1});if(hasMobile){map_mobile=L.map('map-show-mobile',{zoomControl:!1,scrollWheelZoom:!1})}
L.control.zoom({position:'topright',zoomInTitle:'Acercar',zoomOutTitle:'Alejar'}).addTo(map);if(hasMobile){L.control.zoom({position:'topright',zoomInTitle:'Acercar',zoomOutTitle:'Alejar'}).addTo(map_mobile)}
L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);if(hasMobile){L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map_mobile)}
setMap()}
function setMap(){$('.geometry').each(function(){if($(this).val()!=''){retrieveGeometry($(this).val())}})}
function reverseGeocoding(marker,marker_mobile){$.getJSON('https://search.mapzen.com/v1/reverse?api_key=mapzen-imBC1aC&point.lat='+marker.getLatLng().lat+'&point.lon='+marker.getLatLng().lng+'&size=1&layers=address&boundary.country=ES',function(data,status,xhr){if(data.features[0]==undefined){marker.bindPopup('No se han encontrado resultados.').openPopup();if(hasMobile){marker_mobile.bindPopup('No se han encontrado resultados.').openPopup()}}else{marker.bindPopup(data.features[0].properties.label).openPopup();if(hasMobile){marker_mobile.bindPopup(data.features[0].properties.label).openPopup()}
if(data.features[0].properties.locality!=null){var circle=L.circle([marker.getLatLng().lat,marker.getLatLng().lng],data.features[0].properties.distance*1000).addTo(map);if(hasMobile){var circle_mobile=L.circle([marker_mobile.getLatLng().lat,marker_mobile.getLatLng().lng],data.features[0].properties.distance*1000).addTo(map_mobile)}
$('#Town').attr('value',data.features[0].properties.locality).trigger('change');$('#Street').attr('value',data.features[0].properties.street).trigger('change');$('#Number').attr('value',data.features[0].properties.housenumber).trigger('change');$('#Zipcode').attr('value',data.features[0].properties.postalcode).trigger('change')}else{var circle=L.circle([marker.getLatLng().lat,marker.getLatLng().lng],data.features[0].properties.distance*1000).addTo(map);if(hasMobile){var circle_mobile=L.circle([marker_mobile.getLatLng().lat,marker_mobile.getLatLng().lng],data.features[0].properties.distance*1000).addTo(map_mobile)}
$('#Town').attr('value',data.features[0].properties.localadmin).trigger('change');$('#Street').attr('value',data.features[0].properties.street).trigger('change');$('#Number').attr('value',data.features[0].properties.housenumber).trigger('change');$('#Zipcode').attr('value',data.features[0].properties.postalcode).trigger('change')}}})}
function retrieveGeometry(geometry){var geojsonFeature=JSON.parse(geometry.replace(/&quot;/g,'"'));if(Object.prototype.toString.call(geojsonFeature)==='[object Array]'){var geojsonFeaturePoint=geojsonFeature[0];var geojsonFeaturePolygon=geojsonFeature[1];if(geojsonFeaturePoint.geometry.type=='Point'){var marker=L.marker([geojsonFeaturePoint.geometry.coordinates[1],geojsonFeaturePoint.geometry.coordinates[0]],{draggable:!1});if(hasMobile){var marker_mobile=L.marker([geojsonFeaturePoint.geometry.coordinates[1],geojsonFeaturePoint.geometry.coordinates[0]],{draggable:!1})}
prepareMarker(marker,marker_mobile)}
if(geojsonFeaturePolygon.geometry.type=='Polygon'){var layer=L.geoJson(geojsonFeaturePolygon).addTo(map);if(hasMobile){var layer_mobile=L.geoJson(geojsonFeaturePolygon).addTo(map_mobile)}}}else{if(geojsonFeature.geometry.type=='Point'){var marker=L.marker([geojsonFeature.geometry.coordinates[1],geojsonFeature.geometry.coordinates[0]],{draggable:!1});if(hasMobile){var marker_mobile=L.marker([geojsonFeature.geometry.coordinates[1],geojsonFeature.geometry.coordinates[0]],{draggable:!1})}
prepareMarker(marker,marker_mobile)}}}
function prepareMarker(marker,marker_mobile){marker.addTo(map);if(hasMobile){marker_mobile.addTo(map_mobile);reverseGeocoding(marker,marker_mobile)}else{reverseGeocoding(marker)}
if($('#type').val()=='profile'){map.setView([marker.getLatLng().lat,marker.getLatLng().lng],19);if(hasMobile){map_mobile.setView([marker_mobile.getLatLng().lat,marker_mobile.getLatLng().lng],19)}}else{map.setView([39.4077013,-0.5015955],10);if(hasMobile){map_mobile.setView([39.4077013,-0.5015955],10)}}}
