/***

	Window resize adjustments

***/
$( window ).resize(function() {
	mdbla.resize();
});

mdbla.resize = function()
{
	$('#map').css('height',$(window).height()+'px');
	// calculate how much to subtract from window height
	var subtractamount = 35+$('#main-menu').height()+$('#display-bookmarks-container').height()+$('#display-geography-title').height()+$('#footer').height();
	$('.menu-content').css('height',$(window).height()-subtractamount+'px');
}

/***

	Booking data is stored in CartoDB. 
	These SQL calls pull the data into
	the application

***/
mdbla.cartoSQL = function(sql)
{
	console.log('in cartoSQL')
	// some summary stuff sql
	var sql_statement1 = 'SELECT MAX(_jaildays) as jailmax,MIN(_jaildays) as jailmin,SUM(_jaildays) as jailsum,MAX(_bookings) as bookingsmax,MIN(_bookings) as bookingsmin,AVG(_jaildays) as "jailavg",AVG(_bookings) as "bookingsavg",SUM(_bookings) as "bookingssum",MAX(_cost) as "costmax",MIN(_cost) as "costmin",AVG(_cost) as "costavg",SUM(_cost) as "costsum",MAX(pop2010) as "pop2010max",MIN(pop2010) as "pop2010min",AVG(pop2010) as "pop2010avg",SUM(pop2010) as "pop2010sum" FROM '+mdbla.cartoLayerTable[mdbla.department][mdbla.geography]+'';


	// main data sql
	// var sql_statement2 = 'SELECT name,slug,_bookings,_jaildays,_cost FROM '+mdbla.cartoLayerTable[mdbla.department][mdbla.geography]+' ORDER BY _cost DESC ';
	var sql_statement2 = 'SELECT * FROM '+mdbla.cartoLayerTable[mdbla.department][mdbla.geography]+' WHERE '+mdbla.geographyIDColumn[mdbla.geography]+' is not null ORDER BY _cost DESC';

	// get geojson for each polygon
	// WARNING: may take time
	var sql_statement3 = 'SELECT * FROM '+mdbla.cartoLayerTable[mdbla.department][mdbla.geography];

	// go fetch 'em
	// if(mdbla.summary[mdbla.geography] == undefined)
	// {
	// 	var sql1 = $.getJSON('https://mdbla.carto.com/api/v2/sql/?q='+sql_statement1+'&api_key='+mdbla.cartoKey, function(data) {
	// 		mdbla.summary[mdbla.geography] = data.rows[0];
	// 	});
	// }

	/*
		Go get the data from Carto
		Cache the data into mdbla objects
		Chain them so that ajax doesn't screw us
	*/
	// if it hasn't been cached
	if(mdbla.data[mdbla.department][mdbla.geography] == undefined)
	
	{
		console.log('creating data...')

		var sql1 = $.getJSON('https://mdbla.carto.com/api/v2/sql/?q='+sql_statement1+'&api_key='+mdbla.cartoKey, function(data) {
			mdbla.summary[mdbla.geography] = data.rows[0];
		});

		var sql2 = sql1.then(function(){
			$.getJSON('https://mdbla.carto.com/api/v2/sql/?q='+sql_statement2+'&api_key='+mdbla.cartoKey, function(data) {
				// mdbla.data[mdbla.geography] = data;
				mdbla.data[mdbla.department][mdbla.geography] = data;
				// we got the data, let's populate the dropdown-neighborhood
				// mdbla.createNeighborhoodDropdown();
			})
			.then(function(){
				$.getJSON('https://mdbla.carto.com/api/v2/sql/?format=GeoJSON&q='+sql_statement3+'&api_key='+mdbla.cartoKey, function(data) {
					mdbla.geojson[mdbla.geography] = data.features;
				})
				.then(function(){
					// data is got. now create the rankings and start the mapping
					mdbla.createRankings();
					mdbla.setMap();
				})
			})
		})
	}
	// use cached data
	else
	{
		// data is got. now create the rankings and start the mapping
		// mdbla.createRankings();
		mdbla.setMap();		
	}
}

/***

	Assign buttons to perform various functions

***/
mdbla.clickFunctions = function()
{
	$('#button-neighborhoods').click(function(){ mdbla.toggleData(mdbla.department,'Neighborhoods') })
	$('#button-regions').click(function(){ mdbla.toggleData(mdbla.department,'Regions') })

	// police departments
	$('#button-ALL').click(function(){ mdbla.toggleData('ALL',mdbla.geography) })
	$('#button-LASD').click(function(){ mdbla.toggleData('LASD',mdbla.geography) })
	$('#button-LAPD').click(function(){ mdbla.toggleData('LAPD',mdbla.geography) })
	$('#button-LBPD').click(function(){ mdbla.toggleData('LBPD',mdbla.geography) })

	// tabs
	$('#button-prison').click(function(){ mdbla.activeTab = 'Jail Data'; mdbla.displayPrisonData() })
	$('#button-charges').click(function(){ mdbla.activeTab = 'Charges'; mdbla.displayCharges() })
	$('#button-rankings').click(function(){ mdbla.activeTab = 'Rankings'; mdbla.displayRankings() })

}

/***

	Let's get this show on the road

***/
// $( function() 
mdbla.initialize = function()
{
	console.log('initialize...')
	
	// adjust windows
	mdbla.resize()

	// create the map
	mdbla.map = new L.Map('map');

	// add search for the map
	mdbla.map
	.addControl(L.mapbox.geocoderControl('mapbox.places', {
		autocomplete: true
	}));
	
	// fit the map to LA County
	mdbla.map.fitBounds([
		[34.7, -118.85],
		[33.8, -117.75]
	]);

	// add satellite basemap
	mdbla.layerSatellite.addTo(mdbla.map)

	// add layer control
	mdbla.layerControl = L.control.layers(null,{"Satellite":mdbla.layerSatellite,"Labels":mdbla.layerLabel}).addTo(mdbla.map)

	// create real-time css for color pallete
	$("<style>")
		.prop("type", "text/css")
		.html(".vis-item.vis-dot.color1{border-color:"+mdbla.colorPallete[0]+";}")
		.append(".vis-item.vis-dot.color2{border-color:"+mdbla.colorPallete[1]+";}")
		.append(".vis-item.vis-dot.color3{border-color:"+mdbla.colorPallete[2]+";}")
		.append(".vis-item.vis-dot.color4{border-color:"+mdbla.colorPallete[3]+";}")
		.appendTo("head");

	// activate tooltips
	$('[data-toggle="tooltip"]').tooltip()

	// go get the data
	// mdbla.cartoSQL();
	mdbla.createRankings();
	mdbla.setMap();

	// click functions
	mdbla.clickFunctions();
	
};

/***

	Allow toggling of main geography
	Neighborhoods or Census BlockGroups

***/
mdbla.toggleData = function(department,geography)
{
	console.log('toggling data...')
	mdbla.department = department;
	mdbla.geography = geography;

	// reset rankings
	mdbla.createRankings();

	// remove highlighted polygon
	if(mdbla.highlightedPolygon) {mdbla.map.removeLayer(mdbla.highlightedPolygon)};

	// get rid of any open tooltip windows and statss
	$('.cartodb-tooltip').hide();

	//clear title
	$('#display-geography-title').html('...loading...');

	// clear bookmarks
	$('#display-bookmarks').empty();
	mdbla.bookmarks.length = 0;


	mdbla.allowHover = true;

	// reset the tabs
	$('#stats-content-prison1').empty();
	$('#stats-content-prison2').empty();
	$('#stats-content-charges').empty();
	$('#stats-content-timeline').empty();
	$('#stats-content-daysinjail').empty();
	$('#stats-content-rankings').empty();

	// if(mdbla.geography == 'Neighborhoods')
	// {
	// 	mdbla.geography = 'BlockGroups';
	// 	$('#display-geography').html('Block Groups');
	// }
	// else
	// {
	// 	mdbla.geography = 'Neighborhoods';
	// 	$('#display-geography').html('Neighborhoods');
	// }

	if(mdbla.department == 'LASD')
	{
		$('#display-department').html("Los Angeles Sheriff's Department (LASD) <span class='caret'></span>");
	}
	else if (mdbla.department == 'LAPD')
	{
		$('#display-department').html('Los Angeles Police Department (LAPD) <span class="caret"></span>');
	}
	else if (mdbla.department == 'LBPD')
	{
		$('#display-department').html('Long Beach Police Department (LBPD) <span class="caret"></span>');
	}
	else if (mdbla.department == 'ALL')
	{
		$('#display-department').html('Combined Total <span class="caret"></span>');
	}

	if(mdbla.geography == 'Neighborhoods')
	{
		$('#display-geography').html("Neighborhoods <span class='caret'></span>");
	}
	else if (mdbla.geography == 'Regions')
	{
		$('#display-geography').html('Regions <span class="caret"></span>');
	}

	// add the layer control back to the map
	// mdbla.cartoSQL();
	mdbla.setMap();
}

/*
	Depracated waffle function
*/
mdbla.waffle = function(val)
{
	var waffle = '<div class="stats-title">$'+mdbla.numberWithCommas(Math.round(val))+'</div>';

	var cells = Math.ceil(val/10000);
	var cols = Math.ceil(cells/10);
	var remainder = cells%10;

	for (var i = 0; i < 10; i++) 
	{
		waffle += '<div class="waffle-column" style="float:left;">';
		if(i==cols-1){colcells = remainder}else{colcells = 10}
		for (var j = 0; j < 10; j++) {
			if((i>cols-1) || (i==cols-1 && colcells<10 && j >= remainder && remainder != 0))
			{
				waffle += '<div class="waffle-border"><div class="waffle-box-empty"></div></div>';
			}
			else
			{
				waffle += '<div class="waffle-border"><div class="waffle-box"></div></div>';
			}
		}
		waffle+='</div>';
	};

	return waffle;
}

mdbla.numberWithCommas = function(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}