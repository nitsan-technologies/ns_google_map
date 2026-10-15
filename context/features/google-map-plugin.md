# Feature — Google Map plugin

*Status: Done (free version). Code-read (2026-10-15); content element, edit form and Page module preview seen on
v14.3.7, frontend and the address map picker not tested.*

## Editor flow

1. Set the Google Maps API key: site set setting `nsGoogleMap.settings.apiKey` (v14 message points here) or the
   classic constant `plugin.tx_nsgooglemap_map.settings.apiKey`. Without a key the address form shows a warning.
2. Create address records (`tx_nsgooglemap_domain_model_address`) in a folder; the `map` field searches a
   place and sets latitude, longitude and address (`MapUtility`, `Js/googleMap.js`).
3. Add the content element "Google Map" (wizard group plugins, CType `nsgooglemap_map`). Tab "Configuration":
   addresses (none = all), width/height, zoom and interaction, zoom/fullscreen controls, marker clustering
   (max zoom level and cluster icon style, shown only when clustering is on).
4. Include the static template or the site set `nitsan/ns-google-map`.

## Rendering

- `listAction()` assigns `locations` (selected or all addresses, storage page ignored) and the content row.
- `Partials/Address/Settings.html` writes the map options and the `nsGoogleMapInit` callback inline
  (`ScriptViewHelper`); the Maps API loads async with `libraries=places` and that callback; `map.js` draws
  markers, info windows (`InfoWindow.html`) and optional clustering (`markerclusterer.js`).
- `settings.jquery` loads the bundled jQuery first (off by default).

## Settings

| Classic constant | Site set setting |
|---|---|
| `plugin.tx_nsgooglemap_map.view.{templateRootPath,partialRootPath,layoutRootPath}` | `nsGoogleMap.view.*` |
| `plugin.tx_nsgooglemap_map.settings.{apiKey,language,jquery}` | `nsGoogleMap.settings.{apiKey,language,jquery}` |

## Page module preview

TSconfig `mod.web_layout.tt_content.preview.nsgooglemap_map`: `GoogleMap.html` (v12/v13) or `GoogleMapV14.html`
(v14) — premium strip, then tables for General, Map Settings, controls and marker settings (seen on 14.3.7).
