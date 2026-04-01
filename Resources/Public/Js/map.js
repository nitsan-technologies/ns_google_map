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
        this.bounds = this.createBounds();
        this.markers = [];
        this.map = new google.maps.Map(document.getElementById(googlemap.mapSettings.id), this.getMapOptions());
        this.initMap();
        this.addStyle();
        // open info window
        window.setTimeout(function() {
            $element.trigger("openinfo");
        }, 2000);
        this.refreshMap($element, googlemap);
    };
    GoogleMap.prototype = {       
        // Create bounds in a way that works across Maps API variants.
        createBounds: function() {
            if (google.maps && typeof google.maps.LatLngBounds === 'function') {
                return new google.maps.LatLngBounds();
            }
            return {
                north: null,
                south: null,
                east: null,
                west: null,
                extend: function(position) {
                    var lat = typeof position.lat === 'function' ? position.lat() : position.lat;
                    var lng = typeof position.lng === 'function' ? position.lng() : position.lng;
                    if (this.north === null || lat > this.north) this.north = lat;
                    if (this.south === null || lat < this.south) this.south = lat;
                    if (this.east === null || lng > this.east) this.east = lng;
                    if (this.west === null || lng < this.west) this.west = lng;
                }
            };
        },
        // Add css for map
        addStyle: function() {
            var googlemap = this.googlemap;
            this.element.css("width", this.googlemap.mapSettings.width).css("height", this.googlemap.mapSettings.height);
        },
        // Get map configuration options
        getMapOptions: function(googlemap) {
            var googlemap = this.googlemap;
            var zoomControlOptions = this.getZoomControlOptions(googlemap);
            var fullscreenControlOptions = this.getFullscreenControlOptions(googlemap);
            var mapOptions = [];
            mapOptions = {
                zoom: googlemap.mapSettings.zoom,
                mapTypeId: 'roadmap',
                scrollwheel: googlemap.mapSettings.scrollZoom,
                draggable: googlemap.mapSettings.draggable,
                disableDoubleClickZoom: googlemap.mapSettings.doubleClickZoom,
                zoomControl: googlemap.mapSettings.zoomControl,
                zoomControlOptions: zoomControlOptions,
                scaleControl: false,
                streetViewControl: false,
                mapTypeControl: false,
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
                if (this.bounds && typeof this.bounds.getNorthEast === 'function') {
                    _map.fitBounds(this.bounds);
                } else if (this.bounds && this.bounds.north !== null) {
                    _map.fitBounds({
                        north: this.bounds.north,
                        south: this.bounds.south,
                        east: this.bounds.east,
                        west: this.bounds.west
                    });
                }
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
            /**************************************************/
        },
        // Set marker on map
        setMarker: function($element, googlemap) {
            var markers = [];
            var _map = this.map;
            var _this = this;
            var markerClusterStyle = parseInt(googlemap.mapSettings.markerClusterStyle, 10);
            if (isNaN(markerClusterStyle)) {
                markerClusterStyle = -1;
            }
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

            var styles = this.getMarkerClusterStyle(googlemap, markerClusterStyle);
            var mcOptions = {
                maxZoom: googlemap.mapSettings.markerClusterZoom,
                disableClusteringAtZoom: googlemap.mapSettings.markerClusterZoom,
                styles: styles,
                imagePath: googlemap.iconBase
            };
            if (googlemap.mapSettings.markerCluster == 1) {
                new MarkerClusterer(_map, markers, mcOptions);
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
        getMarkerClusterStyle: function(googlemap, markerClusterStyle) {
            var cacheBuster = String(markerClusterStyle) + '-' + String(Date.now());
            var withCacheBuster = function(url) {
                if (!url) {
                    return url;
                }
                return url + (url.indexOf('?') === -1 ? '?' : '&') + '_v=' + encodeURIComponent(cacheBuster);
            };
            var imageUrl;
            switch (markerClusterStyle) {
                case 0:
                        imageUrl = googlemap.clusterVariance2;
                    break;
                case 1:
                        imageUrl = googlemap.clusterVariance3;
                    break;
                case 2:
                        imageUrl = googlemap.clusterVariance4;
                    break;  
                case 3:
                        imageUrl = googlemap.placeIcon;
                    break;                                                    
                default:
                    imageUrl = googlemap.clusterVariance1;
                    break;
            }
            imageUrl = withCacheBuster(imageUrl);
            var styles = [{
                url: imageUrl,
                height: 35,
                width: 35,
                textColor: '#ff00ff',
                textSize: 10
            }, {
                url: imageUrl,
                height: 27,
                width: 30,
                textColor: '#ff00ff',
                textSize: 10
            }, {
                url: imageUrl,
                height: 26,
                width: 30,
                textColor: '#ff00ff',
                textSize: 10
            }, {
                url: imageUrl,
                height: 48,
                width: 30,
                textColor: '#ffffff',
                textSize: 10
            }];
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
}(jQuery));