<?php
/**
 * WordPress front page.
 *
 * This file used to be a full copy of index.php, and the two had drifted:
 * index.php had picked up fixes that this file never received, while WordPress
 * serves THIS file on the home page. So the live home page was running the older
 * markup, and everything below was missing from it:
 *
 *   - the clamp() heading rules that undo the forced text-* scale in
 *     components/style.css (AGENTS.md rule 2). Without them the hero h1 and every
 *     section h2 render at their largest step on a phone.
 *   - the hero as a real <img> with fetchpriority="high" instead of a CSS
 *     background-image, which is what makes the largest contentful paint
 *     preloadable.
 *   - id="home-hero" and id="trusted-by", which in-page anchors point at.
 *
 * Keeping two 3,200-line copies in sync by hand is what caused that, and
 * AGENTS.md rule 5.6 already warned about it. There is now one file. Edit
 * index.php; this is only the name WordPress looks for.
 */

require __DIR__ . '/index.php';
