# Changelog

All notable changes to the CAL-AG American Fieldcraft theme. Versions follow
[Semantic Versioning](https://semver.org/); see `docs/RELEASING.md`.

## [Unreleased]

### Fixed
- Theme images and logo bundled in `assets/` (byte-identical to the review
  site's files) instead of loading from the external chatgpt.site preview.
- Removed hardcoded `noindex` robots meta from `static-home.html`; indexing is
  now controlled by WordPress's search-engine visibility setting.
- Logo links point to the WordPress home URL instead of `index.html`.
- Removed duplicate `<title>` and redundant Content-Type meta (WordPress outputs the title).

### Added
- WordPress theme `wordpress-theme/cal-ag-fieldcraft` (theme header Version 1.0.0).
  `static-home.html`, `styles.css`, `refinement.css` and `site.js` are
  byte-identical to the approved review site.
- Deployment tooling: `.gitignore`, repo hygiene check, DreamHost staging
  workflow, release packaging workflow, deployment/rollback/backup docs.
  No design changes.
