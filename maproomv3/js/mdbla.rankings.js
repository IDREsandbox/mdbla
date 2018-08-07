mdbla.displayRankings = function()
{

	// populate the title box
	// var html = '<div><span class="stats-title">'+mdbla.highlightedGeographyName+'</span><br>2010 population: '+mdbla.numberWithCommas(mdbla.highlightedData.pop2010)+'</div>';
	// $('#display-geography-title').html(html);	

	// clear container
	$('#rankings').empty();

	// create the table headers
	var htmltableheader = '';
	htmltableheader = '<div id="rankings-container"><table id="rankings-table" class="table table-hover table-sm table-condensed "><thead>';
	// rank and name
	htmltableheader += '<th></th><th class="sort" data-sort="name">name</th>';
	// cost
	htmltableheader += '<th class="sort" data-sort="cost">cost</th>';
	// jail days
	htmltableheader += '<th class="sort" data-sort="jaildays">days in jail</th>';
	// arrests
	htmltableheader += '<th class="sort" data-sort="arrests">arrests</th>';
	// pop 2010
	htmltableheader += '<th class="sort" data-sort="pop2010">2010 Population</th>';
	// end table
	htmltableheader += '</thead><tbody id="ranking-list" class="list">';
	// htmltableheader += '</thead><tbody id="ranking-list" class="list"></tbody></table></div>';

	$('#rankings').html(htmltableheader);

	// ranking options for list.js
	var options = {
		valueNames: [ 
			'name',
			'costdisplay',
			'jaildaysdisplay',
			'arrestsdisplay',
			'pop2010display',
			{data:['cost']},
			{data:['jaildays']},
			{data:['arrests']},
			{data:['pop2010']},
		]
	};

	// loop through data
	$.each(mdbla.currentLayer.datavar,function(i,val){

		var cost = Math.round(val._cost);
		var arrests = Math.round(val._bookings);
		var jaildays = Math.round(val._jaildays);
		var pop2010 = Math.round(val.pop2010);

		var costdisplay = '$'+mdbla.numberWithCommas(Math.round(val._cost));
		var arrestsdisplay = mdbla.numberWithCommas(Math.round(val._bookings));
		var jaildaysdisplay = mdbla.numberWithCommas(Math.round(val._jaildays));
		var pop2010display = mdbla.numberWithCommas(Math.round(val.pop2010));

		// var costwidth = Math.round(cost/mdbla.summary[mdbla.geography]["costmax"]*100);
		// var arrestswidth = Math.round(arrests/mdbla.summary[mdbla.geography]["bookingsmax"]*100);
		// var jaildayswidth = Math.round(jaildays/mdbla.summary[mdbla.geography]["jailmax"]*100);
		// var pop2010width = Math.round(pop2010/mdbla.summary[mdbla.geography]["pop2010max"]*100);

		var thisrowhtml = '';

		// add each data params to the tr
		thisrowhtml += '<tr id="ranking-'+val[mdbla.currentLayer.identifyer]+'" onmouse data-cost='+cost+' data-arrests='+val._bookings+' data-jaildays='+val._jaildays+' data-pop2010='+val.pop2010+'>';
		// rank and name
		thisrowhtml += '<td>'+(i+1)+'</td><td class="name">'+val.name+'</td>';
		// cost
		thisrowhtml += '<td class="cost">'+costdisplay+'</td>';
		// jail days
		thisrowhtml += '<td class="jaildays">'+jaildaysdisplay+'</td>';
		// arrests
		thisrowhtml += '<td class="arrests">'+arrestsdisplay+'</td>';
		// 2010 population
		thisrowhtml += '<td class="pop2010">'+pop2010display+'</td>';
		// close tr and table
		thisrowhtml += '</tr></tbody></table></div>';
		
		$('#ranking-list').append(thisrowhtml);

		// $('#ranking-'+val[mdbla.currentLayer.identifyer]).mouseover(function(event) {
		$('#ranking-'+val[mdbla.currentLayer.identifyer]).mouseover(function(event) {
			mdbla.highlightPolygon(val[mdbla.currentLayer.identifyer]);
			// let's change the cursor cuz that hand is too vague

			$('#map').css('cursor', 'pointer');

			// only refresh the data if we hover over a new feature
			if(mdbla.highlightedGeographyID != val[mdbla.currentLayer.identifyer] && mdbla.allowHover)
			{
				// assign map actions
				// mdbla.mapAction(val);

				// highlight the polygon
				mdbla.highlightPolygon(val[mdbla.currentLayer.identifyer],false);
			}
		});
		$('#ranking-'+val[mdbla.currentLayer.identifyer]).mouseout(function(event) {
			// $('#ranking-'+val[mdbla.currentLayer.identifyer]).css('background-color','white')
		});
		$('#ranking-'+val[mdbla.currentLayer.identifyer]).click(function(event) {
			// mdbla.highlightPolygon(val[mdbla.currentLayer.identifyer],true);
			// turn off the hovering and add a button to allow it back

			mdbla.allowHover = false;

			// assign map actions
			mdbla.mapAction(val);

			// create bookmark
			mdbla.createBookmark();

			// highlight the polygon
			mdbla.highlightPolygon(val[mdbla.currentLayer.identifyer],true);

		});
	})

	// mdbla.rankingList = new List('rankings-container', options);
	// mdbla.rankingList.sort('cost',{order:'desc'})
	$('#rankings-table').DataTable({
		"order":[[2,"desc"]],
		"paging": false,
		
	});

}