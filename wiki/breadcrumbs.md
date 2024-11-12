# Breadcrumbs on Eternia

Breadcrumbs are used throughout the site to provide user with context on where they are in the site map, and to provide an easy access for ancestoral pages. Breadcrumbs are usually displayed on all pages except the home page. Although breacrumbs are not defined as necessary in accessibility guidelines, they ease the navigation for users with and without cognitive disabilities.

## The Breadcrumb Template

When you want to use the breadcrumbs in templates, you'll usually want to call the `breadcrumbs-markup` -template. For the most part, the template does not require you to provide parameters or modify the Breadcrumbs class itself on instance basis. For most projects, the class settings are set once. The template part initiates the Breadcrumb class and returns the relevant markup. 

## The Breadcrumb Class

If you need to modify the breadcrumbs for a project, you'll need to edit the Breadcrumb class, located at `inc/includes/breadcrumb`. Most of the relevant settings can be updated by filter hooks documented below:

- `eternia_breadcrumb_home_url` - The URL for the home page, by default the site home URL.
- `rnb_breadcrumb_recent_text` - String used as label for archive page or home page, by default translation from Finnish word 'Ajankohtaista'.
- `rnb_breadcrumb_home`- Single list item markup for home page link.
- `rnb_breadcrumb_category` - Single list item markup for category link.
- `rnb_breadcrumb_archive` - Single list item markup for archive link.
- `rnb_breadcrumb_search` - Single list item markup for search page.
- `rnb_breadcrumb_single_post_archive` - Single list item markup for the post archive.
- `rnb_breadcrumb_single_cpt_archive` - Single list item markup for other post type archives.
- `rnb_breadcrumb_enable_ancestors` - Boolean value for whether ancestors of the current page should be shown. True by default. Note that home will be shown regardless of this setting.
- `rnb_breadcrumb_current` - Single list item markup for the current page.
- `rnb_breadcrumb_open` - The opening half of the breadcrumb wrapper. 
- `rnb_breadcrumb_close` - The closing half of the breadcrumb wrapper.
- `rnb_breadcrumb_transient` - The expiration time for the breadcrumb transient. Five minutes by default.
- `rnb_breadcrumb_use_cache` - Whether or not caching is used for breadcrumbs.

## Caching

By default, breadcrumbs are cached into transients; this can be controlled with filter hook `rnb_breadcrumb_use_cache`. Singular post (any post type) breadcrumb cache is busted when post or any of its translations are modified. Same goes for any taxonomy-term archive breadcrumbs. Other breadcrumb transients are cleared after expiration time (`rnb_breadcrumb_transient`) has passed.