# Polente DE WordPress Theme

## Project

- This repository contains a WordPress block theme. The installable theme files are in `src/`.
- The theme targets WordPress 7.0+ and PHP 8.3+.
- `src/style.css` and `src/color-modes.css` are the editable stylesheets. Their minified counterparts are generated and checked in.
- `src/functions.php` contains the theme's PHP behavior. Preserve WordPress escaping, accessibility, and security practices when changing it.

## Working rules

- Follow the existing code style and keep changes focused.
- Preserve responsive behavior, semantic markup, and accessibility support.
- Do not edit minified CSS by hand. Run `npm run build:css` after changing either source stylesheet.
- Avoid adding JavaScript or dependencies unless the task requires them. The existing color-mode toggle is the theme's only JavaScript behavior.
- Do not commit generated build output unless the task explicitly requires it.

## Checks

- Run `npm run build:css` after stylesheet changes.
- Run `php -l src/functions.php` after PHP changes.
- Validate JSON changes with Node, for example `node -e "JSON.parse(require('fs').readFileSync('src/theme.json', 'utf8'))"`.