This is a more complicated SASS setup for a project where we needed to serve separate stylesheets for desktop and mobile. It's extremely modular and also includes some vendor/plugin styles.

Styles in this project were conditionally loaded per-page, rather than being precompiled into a single page-specific stylesheet, so that's why you see some overlapping/redundant styles.

Written by Tom Lagier, with some minor assistance from Ryan Stuhl.