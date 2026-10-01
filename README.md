# Polente DE WordPress Theme

A plain, fast, and accessible block theme for polente.de.

## Description

This is a modern block theme developed for WordPress 7.0 and later (tested up to 7.1, requires 7.0+, PHP 8.3+). It's designed to be lightweight, accessible, and fully responsive. JavaScript is only used for the optional color mode toggle.

## Features

* Block theme compatible with the full-site editor.
* Accessible and responsive design.
* No JavaScript, except one small inline script for the color mode toggle.
* Basic templates for posts, pages, and archives.
* Light and dark mode. Follows the OS setting, with a toggle in every header.

## Color Modes

* The OS setting (`prefers-color-scheme`) is the default. This works without JavaScript.
* The header toggle stores the choice in `localStorage` and sets `data-theme="light|dark"` on `<html>`.
* Picking the mode that matches the OS clears the stored choice. The site follows the OS again.
* The script runs inline at the top of `<head>`, so there is no flash of the wrong mode.
* The toggle is a real `<button>` with `aria-pressed` and a "Dark mode" label. It stays hidden without JavaScript.
* Dark values live in `src/color-modes.css`. They override the palette CSS variables only, so all blocks follow.
* Loaded on the front end only. The editor keeps the light palette, so swatches match what you pick.
* Palette colors changed in the Site Editor apply to light mode. Dark mode uses the values in `color-modes.css`.

## WordPress 7.0 Support

* `theme.json` schema bumped to `wp/7.0`.
* Customizable mobile menu via the new `navigation-overlay` template part, pre-wired into every header.
* `textIndent` typography setting set to `subsequent`, so editors can opt paragraphs into the new WP 7.0 text-indent control.
* Styling and a localised `Home` label for the new core Breadcrumbs block, with an `aria-label="Breadcrumb"` landmark applied via `render_block_core/breadcrumbs`.

## Requirements and Security

* WordPress 7.0 or later. Run core 7.1.2 or later. It fixes an unauthenticated LFI to RCE in page template resolution (CVE-2026-87902).
* PHP 8.3 or later (WordPress recommended version). Linted on PHP 8.5.
* `theme.json` validated against the `wp/7.1` schema.
* JSON-LD output uses `JSON_HEX_TAG`, so no field can close the `<script>` element.
* `og:url` is built from the parsed request path. Raw query strings are not reflected.
* `[blogroll]` shortcode only accepts data attributes. Markup wrappers and classes are fixed.
* Landmark aria-labels are set through the core HTML API (`WP_HTML_Tag_Processor`), not regex.

## Accessibility

* WCAG 2.1 AA-aligned color palette (Accent 4 darkened to `#475569` for contrast on small text).
* Body text at `font-weight: 400` and `line-height: 1.5` for legibility.
* Visible focus outlines via `:focus-visible` and `forced-colors` (Windows High Contrast) styles.
* Skip-to-content link in every header template part.
* `prefers-reduced-motion` honored globally (animations & smooth scroll disabled).
* Semantic landmarks: `<header>`, `<main id="content">`, `<aside aria-label="Sidebar">`, `<footer>`, `<nav aria-label="…">`.
* Heading hierarchy preserved (no level-skipping in footer or sidebar).
* Underlined links inside post content with adjustable thickness on hover.
* Screen-reader utility class `.screen-reader-text` available.

## SEO

* `<meta name="description">` generated from excerpt / content / term description / search query.
* Open Graph and Twitter Card tags (with featured image or site logo fallback).
* JSON-LD structured data: `WebSite` with `SearchAction`, plus `BlogPosting` on single posts.
* `rel="canonical"` for archives, author, post-type archive, and front page.
* `automatic-feed-links`, `responsive-embeds`, `align-wide` theme supports.
* `loading="lazy"` and `decoding="async"` enforced on attachment images.
* `article:published_time` / `article:modified_time` meta on posts.

## Installation

1. Run `npm install` to install the build dependencies.
2. Run `npm run build` to create a distributable zip file in the `build` directory.
3. Upload the generated `polente-de.zip` file through the WordPress admin area under "Appearance" > "Themes" > "Add New".
4. Activate the theme.

## Customization

You can customize the theme's colors, fonts, and layout directly in the Site Editor (Appearance > Editor).
