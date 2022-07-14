plugin.tx_nsgooglemap_map {
  view {
    templateRootPaths.0 = EXT:ns_google_map/Resources/Private/Templates/
    templateRootPaths.1 = {$plugin.tx_nsgooglemap_map.view.templateRootPath}
    partialRootPaths.0 = EXT:ns_google_map/Resources/Private/Partials/
    partialRootPaths.1 = {$plugin.tx_nsgooglemap_map.view.partialRootPath}
    layoutRootPaths.0 = EXT:ns_google_map/Resources/Private/Layouts/
    layoutRootPaths.1 = {$plugin.tx_nsgooglemap_map.view.layoutRootPath}
  }

  settings {
    apiKey = {$plugin.tx_nsgooglemap_map.settings.apiKey}
    language = {$plugin.tx_nsgooglemap_map.settings.language}
    jquery = {$plugin.tx_nsgooglemap_map.settings.jquery}
  }
}
page {
    includeCSS {
        mapstyle = EXT:ns_google_map/Resources/Public/Css/style.css
    }
    includeJSLibs {
        nsfjquery = EXT:ns_google_map/Resources/Public/Js/jquery.min.js
        nsfjquery.if.isTrue = {$plugin.tx_nsgooglemap_map.settings.jquery}
    }
    includeJSFooter {
        apiKey = https://maps.google.com/maps/api/js?key={$plugin.tx_nsgooglemap_map.settings.apiKey}&language={$plugin.tx_nsgooglemap_map.settings.language}&libraries=places
        mapjs = EXT:ns_google_map/Resources/Public/Js/map.js
        cluster = https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js
        customJs = EXT:ns_google_map/Resources/Public/Js/custom.js
    }
}
