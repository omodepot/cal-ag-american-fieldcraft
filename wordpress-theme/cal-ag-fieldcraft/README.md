# CAL-AG American Fieldcraft WordPress Theme

This package converts the approved American Fieldcraft homepage concept into an
installable WordPress theme while retaining the exact HTML, CSS, imagery, and
responsive behavior of the review site.

## Installation

1. Upload `cal-ag-fieldcraft.zip` in **Appearance > Themes > Add New**.
2. Activate **CAL-AG American Fieldcraft**.
3. In **Settings > Reading**, keep search-engine visibility disabled until launch.

The homepage is sourced from `static-home.html`. WordPress metadata, plugin
hooks, title handling, admin-bar support, and future content integration are
provided by the PHP theme wrapper.

## Editing the homepage

The first time an administrator opens WP Admin with this theme active, it
creates a page called **Home** from the approved design and sets it as the
homepage (Settings > Reading > "A static page"). It never overwrites an
existing page, and if a static homepage is already configured it uses that one.

- Edit it at **Pages > Home**. Each block is one section of the approved
  design (hero, manifesto, equipment range, featured products, field note,
  parts & service, history, contact), stored as a Custom HTML block.
- To change text, open a block, switch to **Edit HTML**, and change only the
  words between tags. Keep tags, `class` and `id` attributes as they are; the
  design depends on them.
- To swap a photo, upload it in Media, copy its URL, and replace the `src` of
  the matching `<img>`.
- Always use **Preview** before **Update**. If something breaks, use the
  page's **Revisions** to restore the previous version.
- The header (logo, menu, phone) and footer are part of the theme
  (`static-home.html`); change them through Git, not WP Admin.

Section content is output exactly as saved (no automatic paragraph or quote
rewriting), so the page matches the approved design until it's edited.
