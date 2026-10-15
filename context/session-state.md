# ns_google_map — Session state

## 2026-10-15 — ns_license integration + premium strip + agent context

- Branch `feature/ns-license-premium-strip` from `master` (efa73d5).
- Added `nitsan/ns-license ^14.5.4` / `ns_license 14.5.4-14.9.99` (minimum stays TYPO3 12.4.37).
  Version 14.0.0 → 14.1.0.
- Premium strip with "Start Free Trial" → ns_license module `?trial=ns_google_map#free-section` in the Page
  module preview and above the FlexForm sheet tabs (tab "Configuration"), team-wide wording and design (see
  `features/premium-cta.md`). Resolver `flexFormTabsContainer` priority 43.
- Verified live on TYPO3 14.3.7 classic: extension temporarily added to `PackageStates.php`, address table
  created temporarily, `serverConnectionTime` cookie set before login, temporary system-maintainer admin and
  test element. All removed (table dropped); `PackageStates.php` and `settings.php` restored byte-identical;
  no other extension's files changed; the extension is **not active** in that install. ns_revolution_slider's
  form strip still works next to the new resolver. PHP 8.4 and 8.1 lint clean.
- Created agent context (`AGENTS.md`, `CLAUDE.md`, `context/`, `tasks/`) and `.gitattributes`; no previous
  context existed. Added "ns_google_map 43" to the `flexFormTabsContainer` lists of ns_revolution_slider,
  ns_news_slider and ns_news_slick.
- Open: ns_license 14.5.4 not yet published; v12/v13 not tested; frontend only code-read.
