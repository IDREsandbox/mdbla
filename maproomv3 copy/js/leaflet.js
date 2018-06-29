
// data layers
var datalayers = [
	// lasd_2012_2016_by_neighborhoods,
	// lapd_2010_2015_by_neighborhoods,
	{
		identifyer: 'slug',
		geography: neighborhoods,
		title: "LAPD 2012-2016 by Neighborhoods",
		datavar: lapd_2012_2016_by_neighborhoods
	},
	{
		identifyer: 'slug',
		geography: neighborhoods,
		title: "LASD 2012-2016 by Neighborhoods",
		datavar: lasd_2012_2016_by_neighborhoods
	},
	{
		identifyer: 'region',
		geography: regions,
		title: "LAPD 2012-2016 by Regions",
		datavar: lapd_2012_2016_by_regions
	},
	{
		identifyer: 'region',
		geography: regions,
		title: "LASD 2012-2016 by Regions",
		datavar: lasd_2012_2016_by_regions
	}
	
];

var currentLayer = 0;

var map = L.map('map');

// info control
var info = L.control();

var geojson = L.geoJson();

var basemap = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
	maxZoom: 18,
	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
		'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
		'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
	id: 'mapbox.light'
});

// run at start time
$( document ).ready(function() {
	init();
});

function init()
{
	// initialize map
	map.setView([33.98037811701901, -118.23280334472658], 10);
	map.addLayer(basemap);

	// seed the map
	mapGeoJSON(currentLayer);
	
	// fit to bounds
	map.fitBounds(geojson.getBounds())

	// create buttons for each layer
	$.each(datalayers,function(i,layer){
		// console.log(layer.datavar)
		$('.nav-overlay').append('<button class="btn btn-info" onmouseover="mapGeoJSON('+i+')">'+i+'</button> ')
	})

}

function mapGeoJSON(i)
{
	currentLayer = i;

	geojson.clearLayers();
	geojson = L.geoJson(datalayers[i].geography, {
		style: style,
		onEachFeature: onEachFeature
	}).addTo(map);		
	geojson.bindTooltip(function(e){return e.feature.properties.name})

	$('.card-title').html(datalayers[i].title)
}

// things to do for each polygon
function onEachFeature(feature, layer) {
	layer.on({
		mouseover: highlightFeature,
		mouseout: resetHighlight,
		click: zoomToFeature
	});
}

function highlightFeature(e) {
	var layer = e.target;

	layer.setStyle({
		weight: 2,
		color: '#666',
		dashArray: '',
		fillOpacity: 0.9
	});

	if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
		layer.bringToFront();
	}
	// console.log(e.target.feature.properties.name)
	$('.card-subtitle').html(e.target.feature.properties.name)
	
	var identifyer = datalayers[currentLayer].identifyer
	var cost = datalayers[currentLayer].datavar.find(x => x[identifyer] === e.target.feature.properties[identifyer])._cost;

	$('.card-text').html(cost)

}

function resetHighlight(e) {
	geojson.resetStyle(e.target);
	
}

function getColor(d) {
	return d > 6000000  ? '#e31a1c' :
		   d > 1000000  ? '#636363' :
		   d > 500000   ? '#969696' :
		   d > 200000   ? '#CCCCCC' :
		   d > 100000   ? '#F7F7F7' :
						'#FFF';
}

function style(feature) {
	// find the _cost
	var identifyer = datalayers[currentLayer].identifyer
	var cost = datalayers[currentLayer].datavar.find(x => x[identifyer] === feature.properties[identifyer])._cost;

	return {
		fillColor: getColor(cost),
		weight: 1,
		opacity: 1,
		color: 'white',
		dashArray: '1',
		fillOpacity: 0.7
	};
}


function zoomToFeature(e) {
	map.fitBounds(e.target.getBounds());
}
