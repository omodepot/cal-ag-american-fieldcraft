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

## Site pages, header and footer

Every page uses the same header (logo, menu, phone) and footer as the
approved homepage; both are read from `static-home.html`. Inner pages add a
site index band above the footer with links to every page and the contact
details (the header menu is hidden on phones in the approved design, so this
band is the mobile navigation).

The first time an administrator opens WP Admin with this theme version, it
creates any of these pages that don't exist yet (it never overwrites a page):

| Page | Address | Content file |
|---|---|---|
| Equipment | `/equipment/` | `content/equipment.html` |
| PERFECT Van Wamel | `/equipment/perfect-van-wamel/` | `content/perfect-van-wamel.html` |
| Alpego | `/equipment/alpego/` | `content/alpego.html` |
| Electrostatic sprayers | `/equipment/electrostatic-sprayers/` | `content/electrostatic-sprayers.html` |
| Micron weed sprayers | `/equipment/micron/` | `content/micron.html` |
| Company | `/company/` | `content/company.html` |
| Parts & service | `/parts-service/` | `content/parts-service.html` |
| Contact | `/contact/` | `content/contact.html` |

It also creates the **Primary** menu (Products, Featured, Company,
Parts & service) under Appearance > Menus, and points the homepage's section
links at these pages (only if the Home page hasn't been edited).

Editing inner pages:

- They use normal WordPress blocks: click any heading, paragraph, image, or
  list to edit it directly. Section styles come from each Group block's
  *Additional CSS class* (`fc-section`, `fc-section-dark`, `fc-section-paper`,
  `fc-section-stone`, `fc-section-sage`); keep those classes.
- **Title** and **Excerpt** fill the photo banner at the top.
- To change the banner photo, set a **Featured image**.
- Header menu: Appearance > Menus > Primary (top-level items only; the approved
  header shows four links).

Brochures in `downloads/` (from the client's shared folder) are linked from the
PERFECT Van Wamel page. Not published on purpose: the Basic-line sheet (marked
"Prijslijst"), the rotary toppers/flail mowers brochure (contains placeholder
text), and the Skyros Vario dealer presentation. The Alpego Focus Line
brochure is Italian; the page links to alpego.com instead.
