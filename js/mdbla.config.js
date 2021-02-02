/***

	Config File for MDBLA Maproom v2.0

	Author: yohman
	Last updated: September 26, 2019
	To add/update data refer to:
		https://github.com/IDREsandbox/mdbla/wiki/Adding-Updating-new-data-layers-for-Maproom-v2
	Updated:
		- modal added to start screen


	Author: albert
	Last updated: November 20, 2019

	Updated:
		- commented out all other geographies besides neighborhoods	
***/

/***

	Namespace and defaults

***/

	var mdbla = {};
	mdbla.activeTab = 'Jail Data';
	mdbla.allowHover = true;
	mdbla.currentLayer = 0;
	mdbla.highlightedFeature = '';

	// ranking
	mdbla.rankingList;

/***

	Get the data

***/

$(document).ready(function() {

	// launch the modal with welcome message
	$('#mdhModal').modal()

	// get started with loading data
	mdbla.getData();
});

mdbla.getData = function()
{
	$.when(
		/*

			Data json files:
			New datasets need to added as json files. Note that the json file is
			preceded with defining the json as a javascript object.

		*/
		$.getScript( "data/lasd_2012_2017_by_neighborhood2.js" ),
		$.getScript( "data/lapd_2012_2017_by_neighborhood.js" ),
		// $.getScript( "data/lasd_2012_2017_by_region2.js" ),
		// $.getScript( "data/lapd_2012_2017_by_region.js" ),
		// $.getScript( "data/lasd_2012_2017_by_assembly2.js" ),
		// $.getScript( "data/lapd_2012_2017_by_assembly.js" ),
		// $.getScript( "data/lasd_2012_2017_by_senate2.js" ),
		// $.getScript( "data/lapd_2012_2017_by_senate.js" ),

		// boundaries
		$.getScript( "data/boundaries/neighborhoods.js" ),
		// $.getScript( "data/boundaries/regions.js" ),
		// $.getScript( "data/boundaries/senate.js" ),
		// $.getScript( "data/boundaries/assembly.js" ),

		// javascript
		$.getScript( "js/mdbla.init.js" ),

		// $.Deferred(function( deferred ){
		// 	$( deferred.resolve );
		// })
	).done(function(){
		// now that all the data has loaded...
		mdbla.setParameters();
	});
}


mdbla.setParameters = function()
{
	// valid geography layers
	mdbla.geographies = [
		"Neighborhoods"
		// "Neighborhoods",
		// "Regions",
		// "Senate",
		// "Assembly"
	]

	/*

		Valid police departments

		Note that new departments would be added here (e.g. Culver City, UCPD, etc)

	*/
	mdbla.departments = [
		"LAPD",
		"LASD"
	]

	// default values
	mdbla.geography = "Neighborhoods";
	mdbla.department = "LAPD";
	mdbla.geojson = neighborhoods;
	mdbla.mapDollarThreshold = 6000000;
	mdbla.mapSlider;

	/*

		Data layers
		This is what shows up on the site as button options

	*/
	mdbla.datalayers = [
		{
			title: 			"LAPD 2012-2017 by Neighborhoods",
			department: 	"LAPD",
			years: 			"2012-2017",
			identifyer: 	'slug',
			geographyname: 	"Neighborhoods",
			geography: 		neighborhoods,
			datavar: 		lapd_2012_2017_by_neighborhood
		},
		{
			title: 			"LASD 2012-2017 by Neighborhoods",
			department: 	"LASD",
			years: 			"2012-2017",
			identifyer: 	'slug',
			geographyname: 	"Neighborhoods",
			geography: 		neighborhoods,
			datavar: 		lasd_2012_2017_by_neighborhood
		}
		// {
		// 	title: 			"LAPD 2012-2017 by Regions",
		// 	department: 	"LAPD",
		// 	years: 			"2012-2017",
		// 	identifyer: 	'region',
		// 	geographyname: 	"Regions",
		// 	geography: 		regions,
		// 	datavar: 		lapd_2012_2017_by_region
		// },
		// {
		// 	title: 			"LASD 2012-2017 by Regions",
		// 	department: 	"LASD",
		// 	years: 			"2012-2017",
		// 	identifyer: 	'region',
		// 	geographyname: 	"Regions",
		// 	geography: 		regions,
		// 	datavar: 		lasd_2012_2017_by_region
		// },
		// {
		// 	title: 			"LAPD 2012-2017 by Assembly District",
		// 	department: 	"LAPD",
		// 	years: 			"2012-2017",
		// 	identifyer: 	'assembly',
		// 	geographyname: 	"Assembly",
		// 	geography: 		assembly,
		// 	datavar: 		lapd_2012_2017_by_assembly
		// },
		// {
		// 	title: 			"LASD 2012-2017 by Assembly District",
		// 	department: 	"LASD",
		// 	years: 			"2012-2017",
		// 	identifyer: 	'assembly',
		// 	geographyname: 	"Assembly",
		// 	geography: 		assembly,
		// 	datavar: 		lasd_2012_2017_by_assembly
		// },
		// {
		// 	title: 			"LAPD 2012-2017 by Senate District",
		// 	department: 	"LAPD",
		// 	years: 			"2012-2017",
		// 	identifyer: 	'senate',
		// 	geographyname: 	"Senate",
		// 	geography: 		senate,
		// 	datavar: 		lapd_2012_2017_by_senate
		// },
		// {
		// 	title: 			"LASD 2012-2017 by Senate District",
		// 	department: 	"LASD",
		// 	years: 			"2012-2017",
		// 	identifyer: 	'senate',
		// 	geographyname: 	"Senate",
		// 	geography: 		senate,
		// 	datavar: 		lasd_2012_2017_by_senate
		// },
	];

/***

	Map Settings

***/

	// instantiate the map
	mdbla.map = L.map('map');

	// info control
	mdbla.info = L.control();

	// the geography layer
	mdbla.mapLayer = L.geoJson();

	// the basemap
	//mdbla.basemap = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
	//	maxZoom: 18,
	//	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
	//		'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
	//		'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
	//	id: 'mapbox.light'
	//});
	mdbla.basemap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}', {
	attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ',
	maxZoom: 16
	});


/*

	Colors for charts
	blue: 	#1F78B4
	orage: 	#FF7F00
	green: 	#33A02C
	purple: #6A3D9A
	red: 	#E31A1C

*/
	mdbla.colorPallete = ['#6A3D9A','#FF7F00','#33A02C','#1F78B4','#E31A1C'];

/***

	Assign buttons to perform various functions

***/

// mdbla.clickFunctions = function()
// {
	// $('#button-neighborhoods').click(function(){ mdbla.toggleData(mdbla.department,'Neighborhoods') })
	// $('#button-regions').click(function(){ mdbla.toggleData(mdbla.department,'Regions') })

	// // police departments
	// $('#button-ALL').click(function(){ mdbla.toggleData('ALL',mdbla.geography) })
	// $('#button-LASD').click(function(){ mdbla.toggleData('LASD',mdbla.geography) })
	// $('#button-LAPD').click(function(){ mdbla.toggleData('LAPD',mdbla.geography) })
	// $('#button-LBPD').click(function(){ mdbla.toggleData('LBPD',mdbla.geography) })

	// tabs

	mdbla.activeTab = 'Jail Data';

	$('#prison-tab').click(function(){ mdbla.activeTab = 'Jail Data'; mdbla.displayPrisonData() })
	$('#charges-tab').click(function(){ mdbla.activeTab = 'Charges'; mdbla.displayCharges() })
	$('#rankings-tab').click(function(){ mdbla.activeTab = 'Rankings'; mdbla.displayRankings() })

// }

	/*

		create buttons for each layer

	*/

	var html = '<div class="btn-group" role="group">';

	// geography options
	$.each(mdbla.geographies,function(i,geography){
		// set button states
		if(geography === mdbla.geography)
		{
			setactiveclass = "active"
		}
		else
		{
			setactiveclass = ""
		}

		//AK: Removed the neighborhood button!
		// html += '<button id="button-'+geography+'" type="button" class="btn btn-sm btn-secondary '+setactiveclass+' " onclick="mdbla.geography=\''+geography+'\';mdbla.mapGeoJSON(\''+geography+'\',\''+mdbla.department+'\')">'+geography+'</button> ';
	})

	// divider
	html += '</div> <div class="btn-group" role="group">';

	// police departments
	$.each(mdbla.departments,function(i,department){
		// set button states
		if(department === mdbla.department)
		{
			setactiveclass = "active"
		}
		else
		{
			setactiveclass = ""
		}

		html += '<button id="button-'+department+'" type="button" class="btn btn-sm btn-secondary '+setactiveclass+'" onclick="mdbla.department=\''+department+'\';mdbla.mapGeoJSON(\''+mdbla.geography+'\',\''+department+'\')">'+department+'</button> ';
	})

	// end buttons
	html += '</div>'

	$('.nav-overlay').append(html)

/***

	Initialize

***/

	mdbla.init();

}
