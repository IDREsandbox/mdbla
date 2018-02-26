/***

	Initialize the map and add the CartoDB layer

***/
mdbla.setMap = function()
{
	console.log('setting map...')
	// remove layer if it exists
	if(mdbla.cartoLayers)
	{
		mdbla.cartoLayers.remove()
	}

	$('#display-geography-title').empty();

	mdbla.layerCarto = cartodb.createLayer(mdbla.map, mdbla.cartoLayerMap[mdbla.department][mdbla.geography],{legends:false,zIndex:2})
		.addTo(mdbla.map)
		.on('done',function(layer){

			console.log('map created...')
			mdbla.cartoLayers = layer;

			layer.on('featureClick',function(e, pos, latlng, data){
				// turn off the hovering and add a button to allow it back
				mdbla.allowHover = false;

				// assign map actions
				mdbla.mapAction(data);

				// create bookmark
				mdbla.createBookmark();

				// highlight the polygon
				mdbla.highlightPolygon(data[mdbla.geographyIDColumn[mdbla.geography]],true);

				mdbla.scrollToRanking(data[mdbla.geographyIDColumn[mdbla.geography]]);

			})
			.on('featureOver', function(e, latlng, pos, data) 
			{
				console.log('hovering over map features...')
				console.log(data)
				// let's change the cursor cuz that hand is too vague
				$('#map').css('cursor', 'pointer');

				// only refresh the data if we hover over a new feature
				if(mdbla.highlightedGeographyID != data[mdbla.geographyIDColumn[mdbla.geography]] && mdbla.allowHover)
				{
					console.log('hovering over NEW feature...')
					// assign map actions
					mdbla.mapAction(data);

					// highlight the polygon
					mdbla.highlightPolygon(data[mdbla.geographyIDColumn[mdbla.geography]],false);
				}
			})
			.on('load',function(){

			})
		})

};

mdbla.mapAction = function(data)
{
	console.log('map action...')
	// let the app know what happened
	mdbla.highlightedData = data;
	mdbla.highlightedGeographyID = data[mdbla.geographyIDColumn[mdbla.geography]];
	mdbla.highlightedGeographyName = data.name;

	rateofincarecration = mdbla.highlightedData._bookings / mdbla.highlightedData.pop2010 * 100;
	rateofincarecration = Math.round(rateofincarecration)+'%';
	// populate the title box
	// var html = '<div><span class="stats-title">'+mdbla.highlightedGeographyName+'</span><br>Booking data from 2010 - 2015<br>2010 population: '+mdbla.numberWithCommas(data.pop2010)+'</div>';
	var html = '<div><span class="stats-title">' + mdbla.highlightedGeographyName + '</span><br>Showing booking data from 2012 to 2016<br>Cost ranking: <b>' + (mdbla.costranks.length - mdbla.costranks[mdbla.slugarray.indexOf(mdbla.highlightedData.slug)] + 1) + '</b> out of ' + mdbla.costranks.length + ' neighborhoods<table class="table table-sm"><tr><td>2010 population</td><td><strong>' + mdbla.numberWithCommas(mdbla.highlightedData.pop2010) + '</strong></td></tr><tr><td>2010 18 and over population</td><td><strong>' + mdbla.numberWithCommas(mdbla.highlightedData.pop2010_18) + '</strong></td></tr><tr><td>Rate of incarceration</td><td><strong>' + rateofincarecration +'</strong></td></tr></table></div>';
	// $('#display-geography-title').html(html);

	// // populate the title box
	// var percentPop = Math.round(data.pop2010/mdbla.summary[mdbla.geography].pop2010sum*100);
	// var percentBooked = Math.round(data._bookings/mdbla.summary[mdbla.geography].bookingssum*100);
	// var percentCost = Math.round(data._cost/mdbla.summary[mdbla.geography].costsum*100);
	// var html = '<div class="stats-title">'+mdbla.highlightedGeographyName+'</div><div class="well"><span class="stats-number">'+percentPop+'%</span> of Los Angeles County population, <span class="stats-number">'+percentBooked+'%</span> of all jail bookings and <span class="stats-number">'+percentCost+'%</span> of total costs</div>';


	// process data for active tab only
	// tabs with switches here enables the data to be refreshed as user hovers over map (data intensive)
	// keeping "rankings" out of this functionality
	switch (mdbla.activeTab)
	{
		case 'Jail Data': mdbla.displayPrisonData(); break;
		case 'Charges' : mdbla.displayCharges(); break;
		case 'timeline' : mdbla.displayTimeline(); break;
		case 'daysinjail' : mdbla.displayDaysInJailChart(); break;
		// case 'rankings' : mdbla.displayRankings(); break;
	}
	$('#display-geography-title').html(html);

}

mdbla.highlightRanking = function(id)
{
	$('#ranking-'+id).css('background-color','yellow')
	if(mdbla.highlightedRanking) mdbla.highlightedRanking.css('background-color','white');
	mdbla.highlightedRanking = $('#ranking-'+id);
}

mdbla.scrollToRanking = function(id)
{
	$('#rankings').animate({
		scrollTop: $('#ranking-'+id).offset().top - $('#rankings').offset().top + $('#rankings').scrollTop()
	});
}

mdbla.highlightPolygon = function(id,zoomornot)
{
	if(mdbla.activeTab == 'Rankings') mdbla.highlightRanking(id);

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

	$.each(mdbla.geojson[mdbla.geography],function(i,val){
		if(val.properties[mdbla.geographyIDColumn[mdbla.geography]] == id)
		{
			thisGeoJSON = val
		}
	})

	if(mdbla.highlightedPolygon) {mdbla.map.removeLayer(mdbla.highlightedPolygon)};
	mdbla.highlightedPolygon = L.geoJson(thisGeoJSON,mdbla.highlightedPolygonStyle).addTo(mdbla.map);

	// zoom to the polygon
	if(zoomornot) mdbla.map.fitBounds(mdbla.highlightedPolygon.getBounds()); 

}

mdbla.getCentroid = function(slug)
{

	function arrayMin(arr) {
	  var len = arr.length, min = Infinity;
	  while (len--) {
	    if (arr[len] < min) {
	      min = arr[len];
	    }
	  }
	  return min;
	};

	function arrayMax(arr) {
	  var len = arr.length, max = -Infinity;
	  while (len--) {
	    if (arr[len] > max) {
	      max = arr[len];
	    }
	  }
	  return max;
	};

	var hiIcon = L.icon({
		iconUrl: 'img/hi.png',

		iconSize:     [36, 45], // size of the icon
		iconAnchor:   [0, 0], // point of the icon which will correspond to marker's location
		popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
	});

	var result = $.grep(mdbla.geojson[mdbla.geography], function(e){ return e.properties.slug == slug; });
	var coords = result[0].geometry.coordinates[0][0];
	// var coords = mdbla.geojson[mdbla.geography][0].geometry.coordinates[0][0];
	console.log(coords)
	var lat_list = [];
	var lng_list = [];
	$.each(coords,function(i,val){
		lng_list.push(val[0]);
		lat_list.push(val[1]);
	})
	console.log(arrayMax(lat_list))
	console.log(arrayMin(lat_list))

	var centroid_lat = (arrayMax(lat_list)-arrayMin(lat_list))/2+arrayMin(lat_list);
	var centroid_lng = (arrayMax(lng_list)-arrayMin(lng_list))/2+arrayMin(lng_list);

	L.marker([centroid_lat,centroid_lng],{icon:hiIcon}).addTo(mdbla.map);
	// return [centroid_lat,centroid_lng];
}
