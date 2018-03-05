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
	// mdbla.data.Neighborhoods={};
	// mdbla.data.Regions={};
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
	mdbla.geography = 'Neighborhoods'; //neighborhoods or regions
	mdbla.geographies = ['Neighborhoods','Regions']; //neighborhoods or regions
	mdbla.department = 'ALL'; // ALL/LASD/LAPD/LBPD
	// mdbla.departments = ['ALL','LASD','LAPD','LBPD']; // ALL/LASD/LAPD/LBPD
	mdbla.departments = ['ALL','LASD','LAPD']; // ALL/LASD/LAPD/LBPD
	mdbla.map;
	mdbla.layerCarto;
	mdbla.cartoSubLayer1;
	mdbla.cartoSubLayer2;
	mdbla.geographyIDColumn = {
		'Neighborhoods' : 'slug',
		'Regions' 		: 'region',
	}

/*

	CartoDB/Mapbox params

*/
	mdbla.cartoKey = '701af57a932440fbe504882c6ccc8f6b3d83488f';
	mdbla.cartoKey2 = 'db139415a28059e3ab9288e45722a7b3259069f4';

	// the name of the data table
	mdbla.cartoBookingsTable = {
		// 'LASDNeighborhoods' : 'lasd_2010_2015_bookings',
		// 'LAPDNeighborhoods' : 'lapd_2010_2015_bookings',
		// 'LBPDNeighborhoods' : 'lbpd_2010_2015_bookings',
		// 'LASD' : 'lasd_2010_2015_bookings_min',
		// 'LAPD' : 'lapd_2010_2015_bookings',
		// 'LBPD' : 'lbpd_2010_2015_bookings',
		'LASD' : 'lasd_2012_2016_bookings',
		'LAPD' : 'lapd_2012_2016_bookings',
		'LBPD' : 'lbpd_2012_2016_bookings',
	}

	// the name of the polygon (region/neighborhood) layer
	mdbla.cartoLayerTable = {
		// 'LASDNeighborhoods' : 'lasd_2010_2015_by_neighborhoods',
		// 'LAPDNeighborhoods' : 'lapd_2010_2015_by_neighborhoods',
		// 'LBPDNeighborhoods' : 'lbpd_2010_2015_by_neighborhoods',
		'ALL'				: 	{
									'Neighborhoods' : 'all_2012_2016_by_neighborhoods',
									'Regions' 		: 'all_2012_2016_by_regions',									
								},
		'LASD'				: 	{
									// 'Neighborhoods' : 'lasd_2010_2015_by_neighborhoods',
									'Neighborhoods' : 'lasd_2012_2016_by_neighborhoods',
									'Regions' 		: 'lasd_2012_2016_by_regions',									
								},
		'LAPD'				: 	{
									// 'Neighborhoods' : 'lapd_2010_2015_by_neighborhoods',
									'Neighborhoods' : 'lapd_2012_2016_by_neighborhoods',
									'Regions' 		: 'lapd_2012_2016_by_regions',									
								},
		'LBPD'				: 	{
									// 'Neighborhoods' : 'lbpd_2010_2015_by_neighborhoods',
									'Neighborhoods' : 'lbpd_2010_2015_by_neighborhoods',
									'Regions' 		: 'lbpd_2010_2015_by_regions',									
								},
	}

	// This is the id for the carto map
	mdbla.cartoLayerMap = {
		// 'LASDNeighborhoods' : 'https://mdbla.carto.com/api/v2/viz/2b09a2c0-1010-11e7-b12e-0e05a8b3e3d7/viz.json',
		// 'LASDRegions' 		: 'https://mdbla.carto.com/api/v2/viz/e84ffe16-0f2e-11e7-aea3-0e3ff518bd15/viz.json',
		// 'LAPDNeighborhoods' : 'https://mdbla.carto.com/api/v2/viz/d5baf89e-1011-11e7-a7b5-0e3ebc282e83/viz.json',
		// 'LBPDNeighborhoods' : 'https://mdbla.carto.com/api/v2/viz/19e33948-f936-11e6-89cc-0e233c30368f/viz.json',
		'ALL'				: 	{
									'Neighborhoods'	: 'https://mdbla.carto.com/api/v2/viz/a1975981-1986-4ad9-8539-c5b6ee844746/viz.json',
									'Regions'		: 'https://mdbla.carto.com/api/v2/viz/6488a261-6dba-4c94-8c0f-92d2f6916721/viz.json',									
								},
		'LASD'				: 	{
									'Neighborhoods'	: 'https://mdbla.carto.com/api/v2/viz/ae540dc0-78b1-4c54-a51d-2ace60339e60/viz.json',
									'Regions'		: 'https://mdbla.carto.com/api/v2/viz/4ac478b2-2814-4701-b886-104a250dd4a5/viz.json',									
								},
		'LAPD'				: 	{
									'Neighborhoods'	: 'https://mdbla.carto.com/api/v2/viz/f959b667-6dea-41b5-a9dd-b4dbbf34a2fd/viz.json',
									'Regions'		: 'https://mdbla.carto.com/api/v2/viz/8048d618-0f65-4af8-a069-3359b6e41d8a/viz.json',									
								},
		'LBPD'				: 	{
									'Neighborhoods' : 'https://mdbla.carto.com/api/v2/viz/107c742a-167b-43b6-8566-075aece2c468/viz.json',
									'Regions' 		: 'https://mdbla.carto.com/api/v2/viz/8a63b20c-bd30-4d83-a970-41eff8bfc715/viz.json',									
								},
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


/***

	Get all the data in one swoop

***/
	// create count variables to ensure asynchronisity does not happen
	var combineddatacount = mdbla.departments.length + mdbla.geographies.length;
	var ongoingcount = 0;

	$.each(mdbla.departments,function(i,department){
		// create the data object
		mdbla.data[department] = {};

		// loop through eacgh geography
		$.each(mdbla.geographies,function(h,geography){
			// create the data object
			mdbla.data[department][geography] = {};

			// some summary stuff sql
			var sql_summary = 'SELECT MAX(_jaildays) as jailmax,MIN(_jaildays) as jailmin,SUM(_jaildays) as jailsum,MAX(_bookings) as bookingsmax,MIN(_bookings) as bookingsmin,AVG(_jaildays) as "jailavg",AVG(_bookings) as "bookingsavg",SUM(_bookings) as "bookingssum",MAX(_cost) as "costmax",MIN(_cost) as "costmin",AVG(_cost) as "costavg",SUM(_cost) as "costsum",MAX(pop2010) as "pop2010max",MIN(pop2010) as "pop2010min",AVG(pop2010) as "pop2010avg",SUM(pop2010) as "pop2010sum" FROM '+mdbla.cartoLayerTable[department][geography]+'';

			// main data sql
			var sql_cost = 'SELECT * FROM '+mdbla.cartoLayerTable[department][geography]+' WHERE '+mdbla.geographyIDColumn[geography]+' is not null ORDER BY _cost DESC';

			// get geojson for each polygon
			// WARNING: may take time
			var sql_geojson = 'SELECT * FROM '+mdbla.cartoLayerTable[department][geography];
			console.log(sql_geojson)
			var sql1 = $.getJSON('https://mdbla.carto.com/api/v2/sql/?q='+sql_summary+'&api_key='+mdbla.cartoKey, function(data) {
				mdbla.summary[geography] = data.rows[0];
			});

			var sql2 = sql1.then(function(){
				$.getJSON('https://mdbla.carto.com/api/v2/sql/?q='+sql_cost+'&api_key='+mdbla.cartoKey, function(data) {
					// mdbla.data[mdbla.mdbla.geography] = data;
					console.log('creating data for '+geography+' and '+department)
					mdbla.data[department][geography] = data;
					// we got the data, let's populate the dropdown-neighborhood
					// mdbla.createNeighborhoodDropdown();
				})
				.then(function(){
					$.getJSON('https://mdbla.carto.com/api/v2/sql/?format=GeoJSON&q='+sql_geojson+'&api_key='+mdbla.cartoKey, function(data) {
						mdbla.geojson[geography] = data.features;
					})
					.then(function(){
						// data is got. now create the rankings and start the mapping

						if(ongoingcount == combineddatacount)
						{
							console.log('All data acquisition complete!')
							mdbla.initialize();
						}
						else
						{
							console.log('still not enough data... ongoing count::'+ongoingcount+' combined data count::' + combineddatacount)
							ongoingcount++;
						}
						// mdbla.createRankings();
						// mdbla.setMap();
						// mdbla.initialize();
					})
				})
			})
			
		})
	})

						



