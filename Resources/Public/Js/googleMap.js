
$(document).ready(function () {
	if (typeof GoogleMap == 'undefined') GoogleMap = {};

	String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, ''); } 

	GoogleMap.init = function() {
		var latitude = $('.latitude').val();
		var longitude = $('.longitude').val();
		var mapId = $('.mapId').val();
		var addressId = $('.addressId').val();
		var latitudeField = $('.latitudeField').val();
		var longitudeField = $('.longitudeField').val();
		var addressField = $('.addressField').val();
		GoogleMap.origin = new google.maps.LatLng(latitude, longitude);
		
		var myOptions = {
			zoom: 12,
			center: GoogleMap.origin,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		GoogleMap.map = new google.maps.Map(document.getElementById(mapId), myOptions);
		GoogleMap.marker = new google.maps.Marker({
			map: GoogleMap.map,
			position: GoogleMap.origin,
			draggable: true
		});

		google.maps.event.addListener(GoogleMap.marker, 'dragend', function() {
			var lat = GoogleMap.marker.getPosition().lat().toFixed(6);
			var lng = GoogleMap.marker.getPosition().lng().toFixed(6);

	        // update fields
			GoogleMap.updateValue(latitudeField, lat);
	        GoogleMap.updateValue(longitudeField, lng);

			// Update address
			GoogleMap.reverseGeocode(GoogleMap.marker.getPosition().lat(), GoogleMap.marker.getPosition().lng(),addressField);
			
			// Update Position
			var position = document.getElementById(addressId);
			position.value = lat + "," + lng;
			
			// Tell TYPO3 that fields were updated
			GoogleMap.positionChanged();
		});
		GoogleMap.geocoder = new google.maps.Geocoder();

	};

	GoogleMap.refreshMap = function() {
		google.maps.event.trigger(GoogleMap.map, 'resize');
		GoogleMap.map.setCenter(GoogleMap.marker.getPosition());
		// No need to do it again
		Ext.fly(GoogleMap.tabPrefix + '-MENU').un('click', GoogleMap.refreshMap);
	}
	
	/***************************/
	GoogleMap.codeAddress = function() {
		var latitude = $('.latitude').val();
		var longitude = $('.longitude').val();
		var mapId = $('.mapId').val();
		var addressId = $('.addressId').val();
		var latitudeField = $('.latitudeField').val();
		var longitudeField = $('.longitudeField').val();
		var addressField = $('.addressField').val();
		var address = document.getElementById(addressId).value;
		var lat = 0;
		var lng = 0;
		if(address.match(/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/)) {
			// Get Position
			lat = address.substr(0, address.lastIndexOf(',')).trim();
			lng = address.substr(address.lastIndexOf(',')+1).trim();
			position = new google.maps.LatLng(lat, lng);
			
			// Update Map
			GoogleMap.map.setCenter(position);
			GoogleMap.marker.setPosition(position);
			
			// Update visible fields
			GoogleMap.updateValue(latitudeField, lat);
	        GoogleMap.updateValue(longitudeField, lng);

			// Get Address
			GoogleMap.reverseGeocode(lat, lng, addressField);
		} else {
			GoogleMap.geocoder.geocode({'address': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					// Get Position
					lat = results[0].geometry.location.lat().toFixed(6);
					lng = results[0].geometry.location.lng().toFixed(6);

					formatedAddress = results[0].formatted_address
					
					// Update Map
					GoogleMap.map.setCenter(results[0].geometry.location);
					GoogleMap.marker.setPosition(results[0].geometry.location);
					
					// Update fields
	                GoogleMap.updateValue(latitudeField, lat);
	                GoogleMap.updateValue(longitudeField, lng);
	                GoogleMap.updateValue(addressField, formatedAddress);

	                GoogleMap.positionChanged();
				} else {
					alert("Geocode was not successful for the following reason: " + status);
				}
			});
		}
	}

	GoogleMap.positionChanged = function() {
	    $('.updateLatitudeJs').val()
	    $('.updateLongitudeJs').val()
	    $('.updateAddressJs').val()
	    TYPO3.FormEngine.Validation.validate();
	}

	GoogleMap.updateValue = function(fieldName, value) {
		var version = $('.version').val();

	    document[TBE_EDITOR.formname][fieldName].value = value;
	    if(version < 7005000) {
	        document[TBE_EDITOR.formname][fieldName + '_hr'].value = value;
	    } else {
	        $('[data-formengine-input-name="' + fieldName + '"]').val(value);
	    }
	}

	GoogleMap.setMarker = function(lat, lng) {
		var addressInput = document.getElementById(addressId);
		var latlng = new google.maps.LatLng(lat, lng);
		GoogleMap.geocoder.geocode({'latLng': latlng}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				GoogleMap.map.setCenter(results[0].geometry.location);
				GoogleMap.marker.setPosition(results[0].geometry.location);
			} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
	}

	GoogleMap.reverseGeocode = function(latitude, longitude,addressField) {
		var latlng = new google.maps.LatLng(latitude, longitude);

		GoogleMap.geocoder.geocode({'latLng': latlng}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK && results[0]) {
			    GoogleMap.updateValue(addressField, results[0].formatted_address);
				GoogleMap.positionChanged();
			}
		});
	}

	GoogleMap.convertAddress = function(addressOld) {
		addressInput = document.getElementById("{$addressId}");
		
		GoogleMap.geocoder.geocode({'address':addressOld}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				GoogleMap.map.setCenter(results[0].geometry.location);
				GoogleMap.marker.setPosition(results[0].geometry.location);
				var lat = GoogleMap.marker.getPosition().lat().toFixed(6);
				var lng = GoogleMap.marker.getPosition().lng().toFixed(6);

	            GoogleMap.updateValue(latitudeField, lat);
	            GoogleMap.updateValue(longitudeField, lng);

				// Update visible fields
				addressInput.value = addressOld;
				
			} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
	}
	window.onload = GoogleMap.init;
});
