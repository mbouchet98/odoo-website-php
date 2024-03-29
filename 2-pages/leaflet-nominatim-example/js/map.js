var map;
var feature;

function load_map() {
	map = new L.Map('map', {zoomControl: true});

	var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
		osmAttribution = 'Map data &copy; 2012 <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
		osm = new L.TileLayer(osmUrl, {maxZoom: 18, attribution: osmAttribution});

	map.setView(new L.LatLng(46.3277732, 0.4102214), 5).addLayer(osm);

	// modifié la position initial de la map.

}

function chooseAddr(lat1, lng1, lat2, lng2, osm_type, text) {
	//
	var loc1 = new L.LatLng(lat1, lng1);
	var loc2 = new L.LatLng(lat2, lng2);
	var bounds = new L.LatLngBounds(loc1, loc2);

	if (feature) {
		map.removeLayer(feature);
	}
	if (osm_type == "node") {
		feature = L.circle( loc1, 25, {color: 'green', fill: false}).addTo(map);
		map.fitBounds(bounds);
		map.setZoom(18);
	} else {
		var loc3 = new L.LatLng(lat1, lng2);
		var loc4 = new L.LatLng(lat2, lng1);

		//alert(loc1+" / "+loc2);

		//feature = L.polyline( [loc1, loc4, loc2, loc3, loc1], {color: 'red'}).addTo(map);
		map.fitBounds(bounds);

		feature = L.marker({
			/*autoClose:false,
			closeOnEscapeKey:false,
			closeOnClick: false,
			closeButton: false,
			className: 'marker',
			maxWidth: 400*/

		})
		.setLatLng([lat1, lng1])
		.bindPopup(text)
		.addTo(this.map);

		//alert(text);
		//document.getElementById("addr") = text;
		//envoyer le taxt dans un input pour l'envoyer direct la mon champs odoo.
		document.getElementById("demo").value = text;
	}
		// ici modif la view map pour mettre un marker.
	
}

function addr_search() {

	//affichage de resultat de adresse
    var inp = document.getElementById("addr");

    $.getJSON('http://nominatim.openstreetmap.org/search?format=json&limit=5&q=' + inp.value, function(data) {
        var items = [];

        $.each(data, function(key, val) {
            bb = val.boundingbox;
            items.push("<li><a href='#' id='getAddress' onclick='chooseAddr(" + bb[0] + ", " + bb[2] + ", " + bb[1] + ", " + bb[3]  + ", \"" + val.osm_type + "\",\""+val.display_name+"\");return false;'>" + val.display_name + '</a></li>');
			
        });

		$('#results').empty();
        if (items.length != 0) {
            $('<p>', { html: "Search results:" }).appendTo('#results');
            $('<ul/>', {
                'class': 'my-new-list',
                html: items.join('')
            }).appendTo('#results');
            //var testest = document.getElementById("getAddress").innerHTML;
	       // document.getElementById("addr").innerHTML = val.display_name;
	       	// print(testest);
	    } else {
            $('<p>', { html: "No results found" }).appendTo('#results');
        }
    });
}

window.onload = load_map;
