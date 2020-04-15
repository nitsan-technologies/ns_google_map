
plugin.tx_nsgooglemap_map {
  view {
    # cat=plugin.tx_nsgooglemap_map/file; type=string; label=Path to template root (FE)
    templateRootPath = EXT:ns_google_map/Resources/Private/Templates/
    # cat=plugin.tx_nsgooglemap_map/file; type=string; label=Path to template partials (FE)
    partialRootPath = EXT:ns_google_map/Resources/Private/Partials/
    # cat=plugin.tx_nsgooglemap_map/file; type=string; label=Path to template layouts (FE)
    layoutRootPath = EXT:ns_google_map/Resources/Private/Layouts/
  }
  persistence {
    # cat=plugin.tx_nsgooglemap_map//a; type=string; label=Default storage PID
    storagePid =
  }
  settings{
    # cat=plugin.tx_nsgooglemap_map//a; type=text+; label = LLL:EXT:ns_google_map/Resources/Private/Language/locallang_db.xlf:apiKey
    apiKey =

    # cat=plugin.tx_nsgooglemap_map//b; type=text+; label = LLL:EXT:ns_google_map/Resources/Private/Language/locallang_db.xlf:language
    language = en

    # cat=plugin.tx_nsgooglemap_map//c; type=boolean; label = LLL:EXT:ns_google_map/Resources/Private/Language/locallang_db.xlf:jquery
    jquery = 
  }
}
