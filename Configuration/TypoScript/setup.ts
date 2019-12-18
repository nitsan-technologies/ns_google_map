
plugin.tx_nsgooglemap_map {
  view {
    templateRootPaths.0 = EXT:ns_google_map/Resources/Private/Templates/
    templateRootPaths.1 = {$plugin.tx_nsgooglemap_map.view.templateRootPath}
    partialRootPaths.0 = EXT:ns_google_map/Resources/Private/Partials/
    partialRootPaths.1 = {$plugin.tx_nsgooglemap_map.view.partialRootPath}
    layoutRootPaths.0 = EXT:ns_google_map/Resources/Private/Layouts/
    layoutRootPaths.1 = {$plugin.tx_nsgooglemap_map.view.layoutRootPath}
  }
  persistence {
    storagePid = {$plugin.tx_nsgooglemap_map.persistence.storagePid}
  }
  settings{
    apiKey = {$plugin.tx_nsgooglemap_map.settings.apiKey}
    language = {$plugin.tx_nsgooglemap_map.settings.language}
    jquery = {$plugin.tx_nsgooglemap_map.settings.jquery}
  }
}
page.includeCSS{
  mapstyle = EXT:ns_google_map/Resources/Public/Css/style.css
}
page.includeJSFooter{
  mapjs = EXT:ns_google_map/Resources/Public/Js/map.js
  customJs = EXT:ns_google_map/Resources/Public/Js/custom.js
}
[globalVar = LIT:1 = {$plugin.tx_nsgooglemap_map.settings.jquery}]
  page.includeJS.mapjs = EXT:ns_google_map/Resources/Public/Js/jquery.min.js
[global]
