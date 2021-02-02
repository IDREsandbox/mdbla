mdbla.init = function()
{
	/*

		Initialize the Map

	*/

	mdbla.map.setView([33.98037811701901, -118.23280334472658], 10);
	mdbla.map.addLayer(mdbla.basemap);

	// seed the map
	mdbla.mapGeoJSON(mdbla.geography,mdbla.department);

	// fit to bounds
	mdbla.map.fitBounds(mdbla.mapLayer.getBounds())

	// start the noUiSlider
	mdbla.millionDollarSlider();
	mdbla.help()
}

mdbla.help = function(){
	$('.nav-overlay').append('<button type="button" id="help-button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#mdhModal">?</button>')
}

mdbla.millionDollarSlider = function()
{

	$("#slider").ionRangeSlider({
		min: 0,
		max: mdbla.maxCost,
		from: mdbla.mapDollarThreshold,
		grid: true,
		prefix: "$",
		step: 500000,
		prettify_enabled: true,
		prettify_separator: ",",
		// prettify: function (num) {
		// 	return ("$"+num);
		// },
		onChange:function (data) {
			mdbla.mapDollarThreshold = data.from
			mdbla.mapLayer.setStyle(mdbla.style)
			console.log(data.from);
		},
	});

	// Save slider instance to var
	mdbla.mapSlider = $("#slider").data("ionRangeSlider");

}

/*

	Map the data

*/

mdbla.mapGeoJSON = function()
{
	// update button states
	$.each(mdbla.geographies,function(i,val){
		if(mdbla.geography === val)
		{
			$('#button-'+val).addClass('active')
		}
		else
		{
			$('#button-'+val).removeClass('active')
		}
	})

	$.each(mdbla.departments,function(i,val){
		if(mdbla.department === val)
		{
			$('#button-'+val).addClass('active')
		}
		else
		{
			$('#button-'+val).removeClass('active')
		}
	})

	// update defaults
	// mdbla.geography = geography;
	// mdbla.department = department;

	// find the right data layer
	$.each(mdbla.datalayers,function(i,val){
		if(val.geographyname == mdbla.geography && val.department == mdbla.department)
		{
			mdbla.currentLayer = val;
		}
	})

	// get max cost
	mdbla.maxCost = 0;
	$.each(mdbla.currentLayer.datavar,function(i,val){
		if(val._cost>mdbla.maxCost)
		{
			round2million = Math.round(val._cost / 1000000) * 1000000;
			mdbla.maxCost = round2million
		}
	})
	console.log(mdbla.maxCost)
	if(mdbla.mapSlider !== undefined)
	{
		mdbla.mapSlider.update({max:mdbla.maxCost})
	}

	// if rankings tab is on, refresh the data
	if(mdbla.activeTab === 'Rankings')
	{
		mdbla.displayRankings()
	}

	// update geojson
	mdbla.geojson = mdbla.currentLayer.geography;

	// clear existing layers
	mdbla.mapLayer.clearLayers();

	// map the new layer
	mdbla.mapLayer = L.geoJson(mdbla.geojson, {
		style: mdbla.style,
		onEachFeature: mdbla.onEachFeature
	}).addTo(mdbla.map);
	mdbla.mapLayer.bindTooltip(function(e){return e.feature.properties.name})

	$('#data-subtitle').html(mdbla.currentLayer.title)
}

// things to do for each polygon
mdbla.onEachFeature = function(feature, layer) {
	layer.on({
		mouseover: mdbla.highlightFeature,
		mouseout: mdbla.resetHighlight,
		// click: mdbla.clickFeature
	});
}

mdbla.highlightFeature = function(e)
{

	if(mdbla.allowHover)
	{
		// set it globally
		mdbla.highlightedData = e.target;
		console.log(mdbla.highlightedData)
		// get the data for highlighted polygon
		var identifyer = mdbla.currentLayer.identifyer
		mdbla.highlightedData.data = mdbla.currentLayer.datavar.find(x => x[identifyer] === e.target.feature.properties[identifyer]);
		console.log(mdbla.highlightedData.data)

		// set the style for highlighted polygon
		mdbla.highlightedData.setStyle({
			weight: 4,
			color: mdbla.colorPallete[3],
			dashArray: 1,
			fillOpacity: 0.9
		});

		if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
			mdbla.highlightedData.bringToFront();
		}

		// display the data
		mdbla.displayData();
	}

}

mdbla.clickFeature = function(e) {

	// mdbla.resetHighlight(e);
	mdbla.mapLayer.resetStyle(mdbla.highlightedData);
	mdbla.allowHover = true;
	mdbla.highlightFeature(e);

	mdbla.map.fitBounds(e.target.getBounds());
	mdbla.allowHover = false;
}

mdbla.displayData = function()
{

	if(typeof mdbla.highlightedData.data == "undefined")
	{
		// there is no data, so cleat the data panel
		$('#data-title').html('No data')
		$('#data-text1').html('')
		$('#data-text2').html('')
	}
	else
	{

		// $('#data-title').html(mdbla.highlightedData.feature.properties.name)
		$('#data-title').html(mdbla.highlightedData.data.name)

		// cost
		var html = '<div class="col-sm data-box" style="text-align:center;"><span class="stats-title" style="color:'+mdbla.colorPallete[4]+'">$'+mdbla.numberWithCommas(Math.round(mdbla.highlightedData.data._cost))+'</span><h4>Cost of incarceration</h4></div>';

		// days in jail
		html += '<div class="col-sm data-box" style="text-align:center;"><span class="stats-title" style="color:'+mdbla.colorPallete[4]+'">'+mdbla.numberWithCommas(Math.round(mdbla.highlightedData.data._jaildays))+'</span><h4>Days in jail</h4></div>';

		// number of arrests
		html += '<div class="col-sm data-box" style="text-align:center;"><span class="stats-title" style="color:'+mdbla.colorPallete[4]+'">'+mdbla.numberWithCommas(Math.round(mdbla.highlightedData.data._bookings))+'</span><h4>Number of arrests</h4></div>';

		$('#data-text1').html(html)

		/*

			WAFFLES!!

		*/

		// race waffle
		var wafflevalues = {};
		wafflevalues.title = 'Race';
		wafflevalues.data = [mdbla.highlightedData.data._race_h,mdbla.highlightedData.data._race_b,mdbla.highlightedData.data._race_w,Number(mdbla.highlightedData.data._race_o2)]
		wafflevalues.labels = ['Hispanic','Black','White','Other']
		$('#data-text2').html('<div class="col-sm">'+mdbla.createWaffleChart(wafflevalues)+'</div>');

		// gender waffle
		var wafflevalues = {};
		wafflevalues.title = 'Gender';
		wafflevalues.data = [mdbla.highlightedData.data._sex_m,mdbla.highlightedData.data._sex_f]
		wafflevalues.labels = ['Male','Female']
		$('#data-text2').append('<div class="col-sm">'+mdbla.createWaffleChart(wafflevalues)+'</div>');

		// charge waffle
		if(mdbla.department == 'LASD' || mdbla.department == 'LBPD')
		{
			var wafflevalues = {};
			wafflevalues.title = 'Charge';
			wafflevalues.data = [mdbla.highlightedData.data._charge_m,mdbla.highlightedData.data._charge_f,mdbla.highlightedData.data._charge_o]
			wafflevalues.labels = ['Misdemeanor','Felony','Other']
			$('#data-text2').append('<div class="col-sm">'+mdbla.createWaffleChart(wafflevalues)+'</div>');
		}

		// $('#data-text2').html(html)
	}
}

mdbla.resetHighlight = function(e) {
	if(mdbla.allowHover)
	{
		mdbla.mapLayer.resetStyle(e.target);
	}
}

mdbla.getColor = function(d) {
	return d > mdbla.mapDollarThreshold  ? '#e31a1c' :
		   // d > 1000000  ? '#636363' :
		   // d > 500000   ? '#969696' :
		   // d > 200000   ? '#CCCCCC' :
		   // d > 100000   ? '#F7F7F7' :
						'#969696';
}

// mdbla.getColor = function(d) {
// 	return d > 6000000  ? '#e31a1c' :
// 		   d > 1000000  ? '#636363' :
// 		   d > 500000   ? '#969696' :
// 		   d > 200000   ? '#CCCCCC' :
// 		   d > 100000   ? '#F7F7F7' :
// 						'#FFF';
// }
//
mdbla.style = function(feature) {
	// find the _cost
	var identifyer = mdbla.currentLayer.identifyer

	var featurejoin = objectFindByKey(mdbla.currentLayer.datavar,identifyer,feature.properties[identifyer])
	if(featurejoin == null)
	{
		var cost = 0;
	}
	else
	{
		var cost = featurejoin._cost;
	}

	return {
		fillColor: mdbla.getColor(cost),
		weight: 1,
		opacity: 1,
		color: 'white',
		dashArray: '1',
		fillOpacity: 0.7
	};
}

mdbla.searchArray = function (array, s){
    var matches = [], i, key;

    for( i = array.length; i--; )
        for( key in array[i] )
            if( array[i].hasOwnProperty(key) && array[i][key].indexOf(s) > -1 )
                matches.push( array[i] );  // <-- This can be changed to anything

    return matches;
};

function objectFindByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return array[i];
        }
    }
    return null;
}

var array = [{'id':'73','foo':'bar'},{'id':'45','foo':'bar'}];
var result_obj = objectFindByKey(array, 'id', '45');


mdbla.numberWithCommas = function(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


mdbla.createWaffleChart = function(values)
{
	// var values = [40,20,10,5];
	var sum = 0;
	$.each(values.data,function(i,val){
		sum += val;
	})

	var normalizedValues = [];
	$.each(values.data,function(i,val){
		normalizedValues.push(Math.round(val/sum*100))
	})
	var count = 0;

	// waffle table
	var waffle = '<div class="container" style="text-align:center">';


	// waffle it
	waffle += '<div class="row waffle-container"><br>';

	$.each(normalizedValues,function(i,val){
		for (var j = 0; j < val; j++)
		{
			waffle += '<div class="waffle-border" style="float:left;"><div class="waffle-box" style="background-color:'+mdbla.colorPallete[i]+'"></div></div>';
		}
	})
	waffle += '</div>';

	// title
	waffle += '<h4>'+values.title+'</h4>';


	// stats and values
	waffle += '<table class="table table-sm table-condensed smallfont" style="text-align:left;">';

	for (var i = 0; i < values.data.length; i++) {
		waffle += '<tr><td><div class="waffle-box-empty smallfont" style="background-color:'+mdbla.colorPallete[i]+'"> &nbsp&nbsp&nbsp&nbsp</div></td><td>'+values.labels[i]+' '+values.data[i]+' ('+normalizedValues[i]+'%)</td><td><div class="waffle-border" style="float:left;"></div></td></tr>';
		// waffle += '<tr><td width="60%"><div class="waffle-box-empty smallfont" style="background-color:'+mdbla.colorPallete[i]+'"> &nbsp&nbsp&nbsp&nbsp'+values.labels[i]+'</div></td><td class="smallfont" width="40%" align="right">'+values.data[i]+' ('+normalizedValues[i]+'%)</td><td><div class="waffle-border" style="float:left;"></div></td></tr>';
	}

	waffle += '</table></div>'

	return waffle;
}


mdbla.highlightPolygon = function(id,zoomornot)
{
	// if(mdbla.activeTab == 'Rankings') mdbla.highlightRanking(id);

	mdbla.highlightedPolygonStyle = {
		weight: 3,
		color: 'yellow',
		opacity: 1,
		fillColor: '#FFFFFF',
		fillOpacity: 0,
		onEachFeature: function(feature, layer){
			layer.on({
				click: 0
			})
		}
	};

	function getObjects(obj, key, val) {
		var objects = [];
		for (var i in obj) {
			if (!obj.hasOwnProperty(i)) continue;
			if (typeof obj[i] == 'object') {
				objects = objects.concat(getObjects(obj[i], key, val));
			} else if (i == key && obj[key] == val) {
				objects.push(obj);
			}
		}
		return objects;
	}

	$.each(mdbla.geojson.features,function(i,val){
		if(val.properties[mdbla.currentLayer["identifyer"]] == id)
		{
			thisGeoJSON = val
		}
	})

	if(mdbla.highlightedPolygon) {mdbla.map.removeLayer(mdbla.highlightedPolygon)};
	mdbla.highlightedPolygon = L.geoJson(thisGeoJSON,mdbla.highlightedPolygonStyle).addTo(mdbla.map);

	// zoom to the polygon
	if(zoomornot) mdbla.map.fitBounds(mdbla.highlightedPolygon.getBounds());

}
