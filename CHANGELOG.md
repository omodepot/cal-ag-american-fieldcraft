# Changelog

All notable changes to the CAL-AG American Fieldcraft theme. Versions follow
[Semantic Versioning](https://semver.org/); see `docs/RELEASING.md`.

## [Unreleased]

### Added
- Shared header/footer on every page, inner page template, site index band.
- Pages: Equipment, PERFECT Van Wamel, Alpego, Electrostatic sprayers, Micron,
  Company, Parts & service, Contact (content from cal-ag.com and the
  client's brochures), Primary menu, four PERFECT brochure downloads.
- New client photos, including two PERFECT machines (resized for web).

### Changed
- Homepage sections are now an editable WordPress page (Pages > Home), created
  automatically from the approved design and set as the front page. Header,
  footer and rendered output are unchanged (verified byte-identical on staging).

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
