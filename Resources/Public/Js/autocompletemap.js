(function($){

	var origin = document.getElementsByClassName("origin");

	google.maps.event.addDomListener(window, 'load', function () {
        var places = new google.maps.places.Autocomplete(origin[0]);
    });

})(TYPO3.jQuery);
