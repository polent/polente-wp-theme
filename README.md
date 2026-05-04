# Polente DE WordPress Theme

A plain, fast, and accessible block theme for polente.de.

## Description

This is a modern block theme developed for WordPress 6.9 and later. It's designed to be lightweight, accessible, and fully responsive without relying on JavaScript.

## Features

* Block theme compatible with the full-site editor.
* Accessible and responsive design.
* No JavaScript for a fast user experience.
* Basic templates for posts, pages, and archives.

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
