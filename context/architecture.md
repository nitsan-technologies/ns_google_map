# ns_google_map — Architecture

One Extbase content-element plugin (`nsgooglemap_map`, action `list`, cached), one address table, no backend
module. Backend additions: a custom FormEngine element for picking a location on address records, the Page
module preview template, and the premium strip.

## Configuration

| File | What |
|---|---|
| `ext_localconf.php` | Plugin `NsGoogleMap`/`Map` as `PLUGIN_TYPE_CONTENT_ELEMENT`; FormEngine `nodeRegistry` 1549261866 (`MapUtility`); `nodeResolver` 1792066218 (`flexFormTabsContainer`, priority 43, premium strip) |
| `Configuration/TCA/Overrides/tt_content.php` | Adds the `map` user field to the address table; `registerPlugin()` (CType `nsgooglemap_map`); "Configuration" tab with `pi_flexform,pages`; `addPiFlexFormValue()` |
| `Configuration/TCA/tx_nsgooglemap_domain_model_address.php` | Address record (`title`, `address`, `infocontent`, `closebyclick`, `openbyclick`, `opened`, `latitude`, `longitude`, `map`); workspaces and languages |
| `ext_tables.sql` | Address table |
| `Configuration/FlexForms/FlexForm.xml` | Four sheets: `sDEF` (addresses, width, height), `mapSetting` (zoom, draggable, scroll / double-click zoom), `controls` (zoom and fullscreen controls + positions), `markerSetting` (cluster, max zoom level, cluster icon style) |
| `Configuration/page.tsconfig` | Wizard item `map` in group `plugins`; preview template `GoogleMap.html` (v12/v13) or `GoogleMapV14.html` (v14). Loaded globally by core; the site set imports it again |
| `Configuration/TCA/Overrides/sys_template.php`, `Configuration/TypoScript/` | Static template; constants `plugin.tx_nsgooglemap_map.{view,settings}.*` (`apiKey`, `language`, `jquery`); setup with global CSS/JS includes |
| `Configuration/Sets/NsGoogleMap/` | Site set `nitsan/ns-google-map`; settings `nsGoogleMap.view.*`, `nsGoogleMap.settings.{apiKey,language,jquery}`; setup imports the classic setup and overrides it |
| `Configuration/ContentSecurityPolicies.php` | Google Maps, gstatic, Google Fonts, `ajax.googleapis.com`, YouTube images |
| `Configuration/Services.yaml` | Autowires `Classes/*` |

## Classes

| Class | Role |
|---|---|
| `Controller\AddressController` | `listAction`: selected addresses (`settings.address`) or all, plus the content row |
| `Domain\Model\Address`, `Domain\Repository\AddressRepository` | Address; `findAddress()` / `findAll()` ignore the storage page |
| `Utility\MapUtility` | FormEngine element for the address `map` field: Places search + draggable marker that fills latitude, longitude and address; API key from TypoScript or site settings |
| `ViewHelpers\ScriptViewHelper`, `ViewHelpers\EscapeViewHelper` | Inline footer script for the map settings; JS escaping |
| `Updates\PluginMigration` | Upgrade wizard `txNsGoogleMapPluginMigration`: `list` + `list_type=nsgooglemap_map` → CType |
| `Backend\PremiumStrip` | Strip HTML + trial URL; `''` when the ns_license route is missing |
| `Form\Resolver\PremiumStripFlexFormTabsContainerResolver`, `Form\Container\PremiumStripFlexFormTabsContainer` | Strip above the FlexForm sheet tabs |
| `ViewHelpers\Be\PremiumStripViewHelper` | Strip in the Page module preview templates |

## Views

- Frontend: `Templates/Address/List.html` → `Layouts/Default.html` → `Partials/Address/{Settings,AddressList,InfoWindow}.html`.
- Backend preview: `Resources/Private/Backend/Backendpreview/GoogleMap.html` (`pi_flexform_transformed`, v12/v13)
  and `GoogleMapV14.html` (`record.pi_flexform.sheets.*`, v14), both starting with `<gm:be.premiumStrip />`.

## Assets

- Frontend: `Css/style.css`, `Js/{map,custom,markerclusterer,jquery.min}.js`, `Images/` (cluster and pin
  icons, referenced from `Settings.html`), `Icons/`.
- Backend: `Js/googleMap.js` (map picker), `Css/backend-premium-strip.css`.
