var map = null;
var currentInfoWindow;
var detail_center = null;

$(function(){

	if (file != 'detail') {
		var zoom = 6;
		var tmp = false;
	} else {
		var zoom = 6;
		var tmp = true;
	}

	var c_latlng = new google.maps.LatLng(65.134857, -18.544922);
	var myOptions = {
		zoom: zoom,
		center: c_latlng,
		scrollwheel: tmp,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: true,
		mapTypeControlOptions: {
			style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
			position: google.maps.ControlPosition.TOP_RIGHT
		},
		panControl: true,
		panControlOptions: {
			position: google.maps.ControlPosition.TOP_RIGHT
		},
		zoomControl: true,
		zoomControlOptions: {
			style: google.maps.ZoomControlStyle.LARGE,
			position: google.maps.ControlPosition.RIGHT_TOP
		},
		streetViewControl: true,
		streetViewControlOptions: {
			position: google.maps.ControlPosition.RIGHT_TOP
		},
		scaleControl: true,
		scaleControlOptions: {
			position: google.maps.ControlPosition.RIGHT_BOTTOM
		}
	};
	map = new google.maps.Map(document.getElementById('map'), myOptions);

	$.each(dat, function(i, n) {
		if (n.lat != '' && n.lng != '') {

			var info = '';

			switch (file) {
				case 'town':
					var info = '<div class="clearfix infowindow text-center">'
					+	'<p class="mb10"><img src="'+n.image+'" alt="'+n.name+'" class="img-responsive img-circle" /></p>'
					+	'<h4>'+n.is_name+'</h4>'
					+	'<p class="mb10">'+n.name+'</p>'
					+	'<p><a href="'+n.link+'" class="btn btn-primary">Detail</a></p>'
					+	'</div>';
					break;
			}

			var center = new google.maps.LatLng(n.lat, n.lng);
			var myMarker = new google.maps.Marker({
				position: center,
				map: map,
			});

			if (file != 'detail') {
				var infoWnd = new google.maps.InfoWindow({
					content: info
				});
				attachMessage(myMarker, info, infoWnd);
			} else {
				detail_center = new google.maps.LatLng(n.lat, n.lng);
			}
		}
	});
});

function attachMessage(marker, msg, infoWnd) {
	google.maps.event.addListener(marker, 'click', function(event) {

		var latlng = new google.maps.LatLng( marker.getPosition().lat(), marker.getPosition().lng() );
		map.panTo( latlng );
		if (currentInfoWindow) {
			currentInfoWindow.close();
		}
		infoWnd.open(marker.getMap(), marker);
		currentInfoWindow = infoWnd;

	});
}
