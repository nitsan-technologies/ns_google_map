# AGENTS.md — ns_google_map (TYPO3 Google Map)

Agent router for the Google Map free extension. Load only what your task needs.

> **Principles:** `context/principles.md`
> **Session log:** `context/session-state.md`
> **Doc index:** `context/docs-map.md`

---

## Always load

| File | Why |
|---|---|
| `context/principles.md` | Guardrails, "nothing that works may break" rule |
| `context/core.md` | Identity, TYPO3/PHP/ns_license constraints, tooling, known issues |

---

## Task router

| Task | Load |
|---|---|
| Google Map plugin: address records, FlexForm, API key / TypoScript / site set, frontend map, Page module preview | `context/features/google-map-plugin.md` |
| Address record map picker in the backend (`MapUtility`) | `context/features/google-map-plugin.md` |
| Premium strip / free trial / ns_license dependency | `context/features/premium-cta.md` |
| Files, classes, TypoScript structure, assets | `context/architecture.md` |
| Lint / validate / manual test | `tasks/run-quality.md` |
| Update agent context after a change | `tasks/context-update.md` |

---

## Feature status

| Feature | Status | Agent entry |
|---|---|---|
| Google Map content element with address markers, info windows, controls and marker clustering | Done (code-read; edit form and preview seen on v14.3.7) | `context/features/google-map-plugin.md` |
| Premium strip in the Page module preview and the plugin options + ns_license free-trial deep link | Done (needs ns_license 14.5.4 release) | `context/features/premium-cta.md` |

---

## Quick commands

```bash
cd packages/ns_google_map          # or typo3conf/ext/ns_google_map in Classic mode
for f in $(find . -name "*.php" -not -path "./.git/*"); do php -l "$f"; done
composer validate --no-check-publish
for f in Resources/Private/Language/*.xlf Configuration/FlexForms/*.xml; do xmllint --noout "$f"; done
```
