(function($) {
    var GoogleMap = window.GoogleMap = window.GoogleMap || {};
    /**
     * Controller for Map functionality
     *
     * @param {HTMLElement} element
     * @param {GoogleMap.Data} googlemap
     * @constructor
     */
    GoogleMap = function(element, googlemap) {
        var $element = this.element = $(element);
        this.googlemap = googlemap;
        this.data = googlemap;
        this.bounds = new google.maps.LatLngBounds();
        this.markers = [];
        this.map = new google.maps.Map(document.getElementById(googlemap.mapSettings.id), this.getMapOptions());
        this.initMap();
        this.addStyle();
        // open info window
        window.setTimeout(function() {
            $element.trigger("openinfo");
        }, 2000);
        this.refreshMap($element, googlemap);
            

            /* Raidus Search - Start*/
           

            map = this.map;
            var markers = [];

            infowindow = new google.maps.InfoWindow();
            var service = new google.maps.places.PlacesService(map);
            
            $('#rdus_btn_'+googlemap.mapSettings.id).click(function(){

                var placeadd = $('#rdus_src_'+googlemap.mapSettings.id).val();                
                var placetype = $('#rdus_src_type_'+googlemap.mapSettings.id).val();
                var redius = $('#rdus_'+googlemap.mapSettings.id).val();

                getLatitudeLongitude(showResult, placeadd);   

                // alert(placeadd);
                // alert(placetype);
                // alert(redius);

                var placeRadius = redius*1000;
                
                clearMarkers();
                function showResult(result) {
                    console.log(result);
                    service.nearbySearch({
                      location: {lat: result.geometry.location.lat(), lng: result.geometry.location.lng()},
                      radius: placeRadius,
                      type: placetype,
                      zoom:10,
                    }, callback);
                   
                    map.setCenter({
                        lat : result.geometry.location.lat(),
                        lng : result.geometry.location.lng(),                        
                    });
                    map.setZoom(15);
                } 


                // function showResult(result) {
                //     console.log(result);
                //     service.nearbySearch({
                //       location: {lat: -33.8665433, lng: 151.1956316},
                //       radius: '500',
                //       type: ['food'],
                //       zoom:10,
                //     }, callback);
                   
                //     map.setCenter({
                //         lat : -33.8665433,
                //         lng : 151.1956316,                        
                //     });
                //     map.setZoom(15);
                // }               

            });        

          function callback(results, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
              for (var i = 0; i < results.length; i++) {
                createMarker(results[i]);                
              }
            }
          }

          function createMarker(place) {
            
            var placeLoc = place.geometry.location;
            var marker = new google.maps.Marker({
              map: map,
              position: place.geometry.location
            });           
            markers.push(marker);

            google.maps.event.addListener(marker, 'click', function() {
                  infowindow.setContent(place.name);                  
                  infowindow.open(map, marker);
            });
        } 

        // Sets the map on all markers in the array.
        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
              markers[i].setMap(map);
            }
        }      
        // Removes the markers from the map, but keeps them in the array.
        function clearMarkers() {
            setMapOnAll(null);
        } 

        function getLatitudeLongitude(callback, address) {
            // If adress is not supplied, use default value 'Ferrol, Galicia, Spain'
            address = "'"+address+"'" || 'Ferrol, Galicia, Spain';
            // Initialize the Geocoder
            geocoder = new google.maps.Geocoder();
            if (geocoder) {
                geocoder.geocode({
                    'address': address
                }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        callback(results[0]);
                    }
                });
            }
        } 

        /* Raidus Search - End*/     






        /*---------------------Get distance with direction - start----------------*/
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        directionsDisplay.setMap(this.map);
        directionsDisplay.setPanel(document.getElementById('dis_dir_block'));
        $('#get_direction_' + googlemap.mapSettings.id).click(function() {
            directionsService.route({
                origin: document.getElementById('start_' + googlemap.mapSettings.id).value,
                destination: document.getElementById('end_' + googlemap.mapSettings.id).value,
                travelMode: document.getElementById('mode').value,
            }, function(response, status) {
                if (status === 'OK') {
                    directionsDisplay.setDirections(response);
                } else {
                    var notfoundmsg = document.getElementById('notfound_' + googlemap.mapSettings.id).value;
                    window.alert(notfoundmsg);
                }
            });
        });
        /*----------------------------------End----------------------------------*/
    };
    GoogleMap.prototype = {       
        // Add css for map
        addStyle: function() {
            var googlemap = this.googlemap;
            this.element.css("width", this.googlemap.mapSettings.width).css("height", this.googlemap.mapSettings.height);
        },
        // Get map configuration options
        getMapOptions: function(googlemap) {
            var googlemap = this.googlemap;
            var mapTypeControlOptions = this.getMapControlOptions(googlemap);
            var zoomControlOptions = this.getZoomControlOptions(googlemap);
            var streetViewControlOptions = this.getStreetViewControlOptions(googlemap);
            var fullscreenControlOptions = this.getFullscreenControlOptions(googlemap);
            var mapOptions = [];
            mapOptions = {
                zoom: googlemap.mapSettings.zoom,
                mapTypeId: googlemap.defaultMapTypes[googlemap.mapSettings.defaultType],
                scrollwheel: googlemap.mapSettings.scrollZoom,
                draggable: googlemap.mapSettings.draggable,
                disableDoubleClickZoom: googlemap.mapSettings.doubleClickZoom,
                mapTypeControl: googlemap.mapSettings.mapTypeControl,
                mapTypeControlOptions: mapTypeControlOptions,
                zoomControl: googlemap.mapSettings.zoomControl,
                zoomControlOptions: zoomControlOptions,
                scaleControl: googlemap.mapSettings.scaleControl,
                streetViewControl: googlemap.mapSettings.streetViewControl,
                streetViewControlOptions: streetViewControlOptions,
                fullscreenControl: googlemap.mapSettings.fullscreenControl,
                fullscreenControlOptions: fullscreenControlOptions
            };
            if (googlemap.locations.length > 0) {
                mapOptions.center = {
                    lat: googlemap.locations[0].latitude,
                    lng: googlemap.locations[0].longitude
                };
            }
            return mapOptions;
        },
        // Get Map controlling options
        getMapControlOptions: function(googlemap) {
            if (googlemap.mapSettings.mapTypeControl != false) {
                mapTypeControlOptions = [];
                mapTypeControlOptions = {
                    style: googlemap.mapSettings.mapTypeControlOptions.style,
                    position: googlemap.mapSettings.mapTypeControlOptions.position,
                    mapTypeIds: googlemap.mapSettings.mapTypes
                };
            } else {
                mapTypeControlOptions = null;
            }
            return mapTypeControlOptions;
        },
        // Get Zoom Controlling options
        getZoomControlOptions: function(googlemap) {
            if (googlemap.mapSettings.zoomControl != false) {
                zoomControlOptions = [];
                zoomControlOptions = {
                    position: googlemap.mapSettings.zoomControlOptions.position
                };
            } else {
                zoomControlOptions = null;
            }
            return zoomControlOptions;
        },
        // Get Streetview Controlling options
        getStreetViewControlOptions: function(googlemap) {
            if (googlemap.mapSettings.streetViewControl != false) {
                streetViewControlOptions = [];
                streetViewControlOptions = {
                    position: googlemap.mapSettings.streetViewControlOptions.position
                };
            } else {
                streetViewControlOptions = null;
            }
            return streetViewControlOptions;
        },
        // Get Fullscreen Controlling options
        getFullscreenControlOptions: function(googlemap) {
            if (googlemap.mapSettings.fullscreenControl != false) {
                fullscreenControlOptions = [];
                fullscreenControlOptions = {
                    position: googlemap.mapSettings.fullscreenControlOptions.position
                };
            } else {
                fullscreenControlOptions = null;
            }
            return fullscreenControlOptions;
        },
        // Refresh Map for set bound for map 
        refreshMap: function($element, googlemap) {
            var _map = this.map;
            if (googlemap.mapSettings.zoom == 0) {
                _map.fitBounds(this.bounds);
            }
        },
        // Initialized Map
        initMap: function() {
            var googlemap = this.googlemap;
            $element = this.element;
            var _this = this;
            var _map = this.map;
            $.each(googlemap.locations, function(index, address) {
                var latitude = address.latitude;
                var longitude = address.longitude;
                var position = new google.maps.LatLng(latitude, longitude);
                _this.bounds.extend(position);
            });
            if (googlemap.locations.length > 0) {
                _this.setMarker($element, googlemap);
            }
            /****************************************************/
            google.maps.event.addDomListener(document.getElementById('gmaptheme'), 'change', function() {
                var selMap = $(this).val();
                switch (selMap) {
                    case 'ExpressRoute':
                        _map.mapTypes.set('styled_map', ExpressRoute);
                        _map.setMapTypeId('styled_map');
                        break;
                    case 'DarkBluePower':
                        _map.mapTypes.set('styled_map', DARKBLUEPOWER);
                        _map.setMapTypeId('styled_map');
                        break;
                    case 'Energy':
                        _map.mapTypes.set('styled_map', Energy);
                        _map.setMapTypeId('styled_map');
                        break;
                    case 'UltraLight':
                        _map.mapTypes.set('styled_map', UltraLight);
                        _map.setMapTypeId('styled_map');
                        break;
                    case 'GreenSerenity':
                        _map.mapTypes.set('styled_map', GreenSerenity);
                        _map.setMapTypeId('styled_map');
                        break;
                    case 'BlackAndWhite':
                        _map.mapTypes.set('styled_map', BlackAndWhite);
                        _map.setMapTypeId('styled_map');
                     case 'default':
                         _map.mapTypes.set('styled_map', ROADMAP);
                        _map.setMapTypeId('styled_map');
                        //_map.setMapTypeId('map');                        
                        break;
                    default:
                        _map.setMapTypeId('map');
                }
            });

            $('#map-search').click(function() {
                  var address = document.getElementById('address').value;
                  var radius = parseInt(document.getElementById('radius').value, 10)*1000;
                  geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                      _map.setCenter(results[0].geometry.location);
                      var marker = new google.maps.Marker({
                        map: _map,
                        position: results[0].geometry.location
                      });
                      if (circle) circle.setMap(null);
                      circle = new google.maps.Circle({center:marker.getPosition(),
                                                     radius: radius,
                                                     fillOpacity: 0.35,
                                                     fillColor: "#FF0000",
                                                     map: map});
                      var bounds = new google.maps.LatLngBounds();
                      for (var i=0; i<gmarkers.length;i++) {
                        if (google.maps.geometry.spherical.computeDistanceBetween(gmarkers[i].getPosition(),marker.getPosition()) < radius) {
                          bounds.extend(gmarkers[i].getPosition())
                          gmarkers[i].setMap(map);
                        } else {
                          gmarkers[i].setMap(null);
                        }
                      }
                      map.fitBounds(bounds);

                    } else {
                      alert('Geocode was not successful for the following reason: ' + status);
                    }
                  });

            });

            /**************************************************/
        },
        // Set marker on map
        setMarker: function($element, googlemap) {
            var markers = [];
            var _map = this.map;
            var _this = this;
            var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            var labelIndex = 0;
            var markers = googlemap.locations.map(function(location, i) {
                if (googlemap.mapSettings.markerLabel == 1) {
                    markerLabel = labels[labelIndex++ % labels.length];
                } else {
                    markerLabel = null;
                }
                var marker = _this.createMarker(location, markerLabel);
                var infowindow = new google.maps.InfoWindow({
                    content: location.infoWindowContent,
                    maxWidth: 263
                });
                google.maps.event.addListener(marker, 'click', (function(marker) {
                    return function() {
                        infowindow.open(_map, marker);
                    }
                })(marker));
                markers.push(marker);
                $('.map-add').click(function() {
                    infowindow.close();
                    var addID = $(this).attr('data-markerid');
                    google.maps.event.trigger(markers[addID], 'click');
                    _map.setZoom(9);
                    _map.setCenter(markers[addID].getPosition());
                    //markers[addID].setAnimation(google.maps.Animation.DROP);
                });
                if (location.openByClick) {
                    marker.addListener('click', function() {
                        infowindow.open(_map, marker);
                    });
                } else {
                    marker.addListener('mouseover', function() {
                        infowindow.open(_map, marker);
                    });
                }
                if (!location.closeByClick) {
                    marker.addListener('mouseout', function() {
                        infowindow.close();
                    });
                }
                if (location.opened) {
                    infowindow.open(_map, marker);
                }
                return marker;
            });
            var styles = this.getMarkerClusterStyle();
            var mcOptions = {
                maxZoom: googlemap.mapSettings.markerClusterZoom,
                gridSize: googlemap.mapSettings.markerClusterSize,
                styles: styles[googlemap.mapSettings.markerClusterStyle],
                imagePath: 'typo3conf/ext/ns_google_map/Resources/Public/Images/m'
            };
            if (googlemap.mapSettings.markerCluster == 1) {
                var markerCluster = new MarkerClusterer(_map, markers, mcOptions);
            }
        },
        // Create marker for map
        createMarker: function(loc, markerLabel) {
            if (loc.icon != '') {
                var image = {
                    url: loc.icon,
                    size: new google.maps.Size(50, 50),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(0, 0),
                    scaledSize: new google.maps.Size(50, 50)
                };
            } else {
                var image = '';
            }
            var shape = {
                //coords: [1, 1, 1, 20, 18, 20, 18, 1],
                type: 'poly'
            };
            var googlemap = this.googlemap;
            var _map = this.map;
            var newMarker = new google.maps.Marker({
                position: {
                    lat: loc.latitude,
                    lng: loc.longitude
                },
                map: _map,
                title: loc.title,
                label: markerLabel,
                //animation: google.maps.Animation.DROP,
                shape: shape,
                clickable: true,
                opacity: googlemap.mapSettings.markerOpacity
            });
            return newMarker;
        },
        // Get custom marker style
        getMarkerClusterStyle: function() {
            var styles = [
                [{
                    url: 'typo3conf/ext/ns_google_map/Resources/Public/Images/people35.png',
                    height: 35,
                    width: 35,
                    textColor: '#ff00ff',
                    textSize: 10
                }, {
                    url: 'typo3conf/ext/ns_google_map/Resources/Public/Images/people45.png',
                    height: 45,
                    width: 45,
                    textColor: '#ff0000',
                    textSize: 11
                }, {
                    url: 'typo3conf/ext/ns_google_map/Resources/Public/Images/people55.png',
                    height: 55,
                    width: 55,
                    textColor: '#ffffff',
                    textSize: 12
                }],
                [{
                    url: 'typo3conf/ext/ns_google_map/Resources/Public/Images/conv30.png',
                    height: 27,
                    width: 30,
                    textColor: '#ff00ff',
                    textSize: 10
                }, {
                    url: 'typo3conf/ext/ns_google_map/Resources/Public/Images/conv40.png',
                    height: 36,
                    width: 40,
                    textColor: '#ff0000',
                    textSize: 11
                }, {
                    url: 'typo3conf/ext/ns_google_map/Resources/Public/Images/conv50.png',
                    width: 50,
                    height: 45,
                    textSize: 12
                }],
                [{
                    url: 'typo3conf/ext/ns_google_map/Resources/Public/Images/heart30.png',
                    height: 26,
                    width: 30,
                    textColor: '#ff00ff',
                    textSize: 10
                }, {
                    url: 'typo3conf/ext/ns_google_map/Resources/Public/Images/heart40.png',
                    height: 35,
                    width: 40,
                    textColor: '#ff0000',
                    textSize: 11
                }, {
                    url: 'typo3conf/ext/ns_google_map/Resources/Public/Images/heart50.png',
                    width: 50,
                    height: 44,
                    textSize: 12
                }],
                [{
                    url: 'typo3conf/ext/ns_google_map/Resources/Public/Images/pin.png',
                    height: 48,
                    width: 30,
                    textColor: '#ffffff',
                    textSize: 10
                }]
            ];
            return styles;
        }
    };
    // Create a new Google Map
    $.fn.nsgooglemap = function(googlemap) {
        var $element = $(this);
        if (!$element.data('googlemap')) {
            $element.data('googlemap', new GoogleMap($element, googlemap));
        }
    };
 
    var ROADMAP = new google.maps.StyledMapType([
            
          ]);
    var ExpressRoute = new google.maps.StyledMapType(
        [{
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [{
                "color": "#808080"
            }, {
                "lightness": -32
            }]
        }, {
            "featureType": "landscape",
            "stylers": [{
                "color": "#808080"
            }]
        }, {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [{
                "color": "#808080"
            }, {
                "lightness": -14
            }]
        }, {
            "featureType": "administrative",
            "elementType": "geometry.stroke",
            "stylers": [{
                "color": "#808080"
            }, {
                "lightness": 32
            }]
        }, {
            "featureType": "road",
            "elementType": "geometry.fill",
            "stylers": [{
                "lightness": 11
            }, {
                "color": "#e69b24"
            }]
        }, {
            "featureType": "road",
            "elementType": "geometry.stroke",
            "stylers": [{
                "color": "#ebbc63"
            }, {
                "lightness": 11
            }]
        }, {
            "elementType": "labels.icon",
            "stylers": [{
                "hue": "#ff0000"
            }]
        }, {
            "elementType": "labels.text.fill",
            "stylers": [{
                "saturation": -100
            }]
        }, {
            "featureType": "transit",
            "elementType": "geometry",
            "stylers": [{
                "saturation": -100
            }]
        }]);
    var DARKBLUEPOWER = new google.maps.StyledMapType(
        [{
            "stylers": [{
                "hue": "#00eeff"
            }, {
                "invert_lightness": true
            }]
        }, {
            "featureType": "road",
            "stylers": [{
                "hue": "#ff6e00"
            }, {
                "gamma": 2
            }, {
                "lightness": -11
            }]
        }, {
            "featureType": "water",
            "stylers": [{
                "hue": "#0099ff"
            }, {
                "saturation": 100
            }, {
                "lightness": -83
            }, {
                "gamma": 1.96
            }]
        }]);
    var Energy = new google.maps.StyledMapType([{
        "featureType": "water",
        "stylers": [{
            "invert_lightness": true
        }, {
            "lightness": -26
        }]
    }, {
        "featureType": "landscape",
        "elementType": "geometry",
        "stylers": [{
            "color": "#80a2b7"
        }, {
            "lightness": -76
        }, {
            "saturation": 59
        }]
    }, {
        "featureType": "poi",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "transit",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [{
            "lightness": 9
        }, {
            "color": "#80aedf"
        }]
    }, {
        "featureType": "road",
        "elementType": "geometry.stroke",
        "stylers": [{
            "color": "#80aedf"
        }, {
            "lightness": 41
        }, {
            "weight": 0.7
        }]
    }, {
        "elementType": "labels.text.fill"
    }, {
        "elementType": "labels.text.stroke",
        "stylers": [{
            "color": "#80aedf"
        }, {
            "weight": 1.9
        }, {
            "lightness": 1
        }]
    }, {
        "featureType": "administrative",
        "elementType": "geometry.fill",
        "stylers": [{
            "color": "#80b1ff"
        }, {
            "lightness": -78
        }, {
            "saturation": -67
        }]
    }, {
        "elementType": "labels.icon",
        "stylers": [{
            "hue": "#007fff"
        }]
    }]);
    var UltraLight = new google.maps.StyledMapType(
        [{
            "featureType": "water",
            "stylers": [{
                "color": "#eeeeee"
            }]
        }, {
            "featureType": "landscape",
            "stylers": [{
                "color": "#dddddd"
            }]
        }, {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [{
                "color": "#808080"
            }]
        }, {
            "featureType": "poi",
            "stylers": [{
                "weight": 0.1
            }, {
                "color": "#cccccc"
            }]
        }, {
            "featureType": "road",
            "elementType": "labels.icon",
            "stylers": [{
                "visibility": "off"
            }]
        }, {}, {}]);
    var GreenSerenity = new google.maps.StyledMapType(
        [{
            "stylers": [{
                "hue": "#00ff19"
            }]
        }, {
            "featureType": "water",
            "stylers": [{
                "hue": "#00ccff"
            }]
        }]);
    var BlackAndWhite = new google.maps.StyledMapType(
        [{
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [{
                "saturation": -100
            }, {
                "lightness": 100
            }]
        }, {
            "featureType": "landscape",
            "elementType": "geometry.fill",
            "stylers": [{
                "color": "#808080"
            }, {
                "lightness": -75
            }]
        }, {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [{
                "color": "#808080"
            }, {
                "lightness": 32
            }]
        }, {
            "featureType": "transit.line",
            "elementType": "geometry",
            "stylers": [{
                "color": "#808080"
            }, {
                "lightness": 41
            }]
        }, {
            "featureType": "administrative",
            "elementType": "geometry",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#808080"
            }, {
                "lightness": -100
            }]
        }, {
            "elementType": "labels.text.stroke",
            "stylers": [{
                "color": "#808080"
            }, {
                "lightness": 100
            }]
        }, {
            "elementType": "labels.icon",
            "stylers": [{
                "saturation": -100
            }, {
                "lightness": 13
            }, {
                "gamma": 0.41
            }]
        }]);
}(jQuery));