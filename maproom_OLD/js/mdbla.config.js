/***

	Namespace and defaults

***/
	var mdbla = {};
	mdbla.activeTab = 'Jail Data';
	mdbla.slugarray = [];
	mdbla.jailarray = [];
	mdbla.jailranks;
	mdbla.bookingsarray = [];
	mdbla.bookingsranks;
	mdbla.costarray = [];
	mdbla.costranks;
	mdbla.bookmarks = [];
	mdbla.allowHover = true;


/*

	Highlighted polygon/data

*/
	mdbla.highlightedPolygon;
	mdbla.highlightedData;
	mdbla.highlightedGeographyID;
	mdbla.highlightedGeographyName;

/*

	Data storage

*/
	mdbla.summary={};
	mdbla.data={};
	mdbla.geojson={};

/*

	Colors for charts
	blue: 	#1F78B4
	orage: 	#FF7F00
	green: 	#33A02C
	purple: #6A3D9A
	red: 	#E31A1C

*/
	mdbla.colorPallete = ['#6A3D9A','#FF7F00','#33A02C','#1F78B4','#E31A1C'];


/*

	Map related settings

*/
	mdbla.geography = 'LASDNeighborhoods';
	mdbla.department = 'LASD';
	mdbla.map;
	mdbla.layerCarto;
	mdbla.cartoSubLayer1;
	mdbla.cartoSubLayer2;
	mdbla.geographyIDColumn = {
		'BlockGroups' : 'fips_1',
		'LASDNeighborhoods' : 'slug',
		'LAPDNeighborhoods' : 'slug',
		'LBPDNeighborhoods' : 'slug',
	}

/*

	CartoDB/Mapbox params

*/
	mdbla.cartoKey = '701af57a932440fbe504882c6ccc8f6b3d83488f';

	// the name of the data table
	mdbla.cartoBookingsTable = {
		'LASDNeighborhoods' : 'lasd_2010_2015_bookings',
		'LAPDNeighborhoods' : 'lapd_2010_2015_bookings',
		'LBPDNeighborhoods' : 'lbpd_2010_2015_bookings',
	}

	// the name of the polygon (region/neighborhood) layer
	mdbla.cartoLayerTable = {
		'LASDNeighborhoods' : 'lasd_2010_2015_by_neighborhoods',
		//regions 'LASDNeighborhoods' : 'lasd_bookings_by_region',
		'LAPDNeighborhoods' : 'lapd_2010_2015_by_neighborhoods',
		'LBPDNeighborhoods' : 'lbpd_2010_2015_by_neighborhoods',
	}

	// This is the id for the carto map
	mdbla.cartoLayerMap = {
		'LASDNeighborhoods' : 'https://mdbla.carto.com/api/v2/viz/2b09a2c0-1010-11e7-b12e-0e05a8b3e3d7/viz.json',
		//regions 'LASDNeighborhoods' : 'https://mdbla.carto.com/api/v2/viz/e84ffe16-0f2e-11e7-aea3-0e3ff518bd15/viz.json',
		'LAPDNeighborhoods' : 'https://mdbla.carto.com/api/v2/viz/510784bd-87b8-4a46-9cae-eda134be761c/viz.json',
		// 'LAPDNeighborhoods' : 'https://mdbla.carto.com/api/v2/viz/d5baf89e-1011-11e7-a7b5-0e3ebc282e83/viz.json',
		// 'LBPDNeighborhoods' : 'https://mdbla.carto.com/api/v2/viz/19e33948-f936-11e6-89cc-0e233c30368f/viz.json',
		'LBPDNeighborhoods' : 'https://mdbla.carto.com/api/v2/viz/0a1b2117-4c3c-4fe6-a511-6539e386b32b/viz.json',
	}

	// mapbox token
	L.mapbox.accessToken = 'pk.eyJ1IjoieW9obWFuIiwiYSI6IkxuRThfNFkifQ.u2xRJMiChx914U7mOZMiZw';

/*

	Map layers

*/
	// satellite layer
	mdbla.layerSatellite = L.mapbox.styleLayer('mapbox://styles/mapbox/satellite-v9',{'zIndex':0})

	// label layer
	mdbla.layerLabel = L.tileLayer('http://{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="http://cartodb.com/attributions">CartoDB</a>',
		subdomains: 'abcd',
		maxZoom: 19,
		zIndex: 3
	})
