# Feature — Premium strip and ns_license free trial

*Status: Done. Verified live on TYPO3 14.3.7 (2026-10-15): strip in the Page module preview and above the
FlexForm sheet tabs (tab "Configuration"); the button opens the ns_license module with "Google Map
(ns_google_map)" preselected in the trial modal. Requires ns_license 14.5.4 (deep-link support) to be released.
v12/v13 not tested.*

## Licensing status

Freemium. Premium product (T3Planet catalog): "Google Map", €79, https://t3planet.de/en/typo3-google-map-extension
(not linked from the UI; the trial stays inside the TYPO3 backend). Catalog features: multiple map types,
unlimited map pins, marker clustering filters, direction routes, custom info pop-ups, radius location search,
Street View controls.

## Dependency

`composer.json` `"nitsan/ns-license": "^14.5.4"`, `ext_emconf.php` `'ns_license' => '14.5.4-14.9.99'`. Does not
raise the minimum TYPO3 version (see `core.md`).

## Placements

| Place | Position |
|---|---|
| Page module, preview of a Google Map content element | Above the settings table of the preview template |
| Content element edit form, tab "Configuration" | Above the FlexForm sheet tabs (General, Map Settings, Frontend Controls, Marker Settings) |

Not shown on address records or other content elements.

## How it works

- `Backend\PremiumStrip::render()`: `actions-rocket` icon, headline and description on two lines,
  `btn btn-primary` "Start Free Trial →" (the arrow is `aria-hidden` markup). Link = route
  `nitsan_nslicensemodule` + `trial=ns_google_map` + `#free-section`, same frame. Returns `''` without
  ns_license, so neither placement shows anything.
- Preview: core renders the TSconfig preview template (`GoogleMap.html` / `GoogleMapV14.html`); both start with
  `<gm:be.premiumStrip />` (`ViewHelpers\Be\PremiumStripViewHelper`), which renders the strip and adds the
  stylesheet through `PageRenderer`.
- Edit form: the FlexForm has four sheets, so core uses `flexFormTabsContainer`. `ext_localconf.php` registers
  `Form\Resolver\PremiumStripFlexFormTabsContainerResolver` for that node, priority **43** (taken:
  ns_revolution_slider 40, ns_news_slider 41, ns_news_slick 42; duplicates make core throw). It matches
  `tt_content.pi_flexform` of CType `nsgooglemap_map` (or legacy `list` + `list_type=nsgooglemap_map`), not
  inline children, and returns `Form\Container\PremiumStripFlexFormTabsContainer`, which prepends the strip and
  adds the stylesheet. Other resolvers return `null` for foreign plugins, so they chain safely (checked live with
  ns_revolution_slider).

## Strip

- Labels in `locallang.xlf`: `premium.strip.headline` "You're using the free version of NS Google Map",
  `premium.strip.description` "Unlock premium features and get more out of NS Google Map.",
  `premium.strip.trial` "Start Free Trial".
- `Resources/Public/Css/backend-premium-strip.css`: `.ns-google-map-premium-strip` — team-wide design (light-blue
  card `#e7f2fc`, border `#8eb6e8`, 4px `#2b6cb0` left accent, 6px radius, padding 14px 18px, `light-dark()`
  for dark mode, button `#007bff` / hover `#0062cc`); inset 16px inside the FlexForm panel.
- Measured on v14.3.7: 849×67px in the edit form (883px panel); 482×119px in the Page module preview, where the
  button wraps below the text.
- ns_license's module requires system maintainer access; other users get access denied after clicking.
