# ns_google_map — Core facts

## Identity

| Item | Value |
|---|---|
| Extension key | `ns_google_map` |
| Composer name | `nitsan/ns-google-map` |
| Title (ext_emconf) / product name | TYPO3 Google Map Extension / Google Map |
| Namespace | `Nitsan\NsGoogleMap\` → `Classes/` (note the casing `Nitsan`) |
| Version (ext_emconf) | 14.1.0 (latest tag 14.0.0) |
| Repository | https://github.com/nitsan-technologies/ns_google_map (default branch `master`) |
| Licensing status | **Freemium** — this repo is the free version; a paid premium version exists in the T3Planet catalog (the NITSAN Free/Freemium sheet needs a Google login) |
| Premium version (T3Planet catalog) | "Google Map", €79, https://t3planet.de/en/typo3-google-map-extension |

## Compatibility

| Source | TYPO3 | PHP |
|---|---|---|
| `ext_emconf.php` | `12.4.37-14.9.99` | not declared |
| `composer.json` | `^12.4.37 \|\| ^13 \|\| ^14` | not declared |
| ns_license 14.5.4 (dependency) | `12.4.18-14.9.99` | not declared (TYPO3 12.4 needs 8.1+) |

- ns_license does not raise the minimum: TYPO3 12.4.37, PHP 8.1.

## Dependencies

| Package | Constraint | Why |
|---|---|---|
| `typo3/cms-core` | see above | core |
| `nitsan/ns-license` / `ns_license` | `^14.5.4` / `14.5.4-14.9.99` | TYPO3 Shop module + free-trial deep link (see `features/premium-cta.md`) |

External: Google Maps JavaScript API (`maps.googleapis.com`, needs an API key with the Places library).
Bundled: jQuery (`Js/jquery.min.js`), MarkerClusterer (`Js/markerclusterer.js`), Bootstrap CSS
(`Css/bootstrap.min.css`).

## Tooling

- No PHPUnit, PHPStan, CS fixer or package.json in the repo. `composer.json` has a `.Build/` vendor/web-dir
  config for standalone installs.
- CI: `.github/workflows/ter-release.yml` only (publishes tags to TER with tailor; PHP 7.4, deprecated
  `set-output`).
- `.gitattributes` export-ignores `.crowdin.yml`, `.github/`, `AGENTS.md`, `CLAUDE.md`, `context/`, `tasks/` and
  itself, so they are not in the GitHub/Composer archive or the TER package (the TER release uploads the GitHub
  tag archive).
- Translations: Crowdin (`.crowdin.yml`), sources `Resources/Private/Language/*.xlf` (`locallang.xlf` frontend +
  premium strip, `locallang_db.xlf` TCA/FlexForm/preview, `locallang_csh_*.xlf`).

## Conventions

- PHP: 4 spaces; `strict_types` only in the premium-strip classes, `MapUtility` and `PluginMigration`.
- TypoScript: 2 or 4 spaces; Fluid, FlexForm, XLF and `ext_emconf.php`: tabs.
- Public assets in `Resources/Public/{Css,Js,Icons,Images}/`; backend strip CSS
  `Resources/Public/Css/backend-premium-strip.css`.

## Known issues (existing, not fixed)

All code-read unless marked.

- The preview templates use `locallang_db.xl` (missing `f`) in their label keys; labels still showed on
  14.3.7.
- The plugin tab adds the `pages` (record storage) field, but `AddressRepository` disables the storage page, so
  the plugin shows all addresses (or the selected ones) regardless of it.
- `MapUtility` (address map picker) loads jQuery 3.6.0 from `ajax.googleapis.com` and the bundled jQuery, and
  uses `http://` for the Maps API on non-HTTPS backends; it appends `&key=` even when the key is empty.
- `tt_content.php` uses `addPiFlexFormValue()` (deprecated in TYPO3 14) and adds a "Configuration" tab.
- Frontend CSS and JS (`style.css`, Maps API, `map.js`, `custom.js`, `markerclusterer.js`) are included on every
  page via `page.includeCSS` / `includeJSFooter`, not only pages with the plugin; the Maps API URL is built
  even without a key.
- `Css/bootstrap.min.css` appears unused by the templates and TypoScript.
- README badges show v13.0.0 / TYPO3 13 and GPL-3.0; links use the old `t3planet.com` / `demo.t3planet.com`
  hosts; `composer.json` uses the deprecated SPDX id `GPL-2.0+`.
