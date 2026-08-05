<?php
/* Template Name: Smart Energy Solution */
if (isset($_SERVER['REQUEST_URI']) && preg_match('/\.php\/+$/i', $_SERVER['REQUEST_URI'])) {
    $clean_uri = preg_replace('/\.php\/+$/i', '.php', $_SERVER['REQUEST_URI']);
    header("Location: " . $clean_uri, true, 301);
    exit();
}
if (!function_exists('get_template_directory_uri')) {
    function get_template_directory_uri() { return '.'; }
}
if (!function_exists('get_stylesheet_directory_uri')) {
    function get_stylesheet_directory_uri() { return '.'; }
}
if (!function_exists('get_template_directory')) {
    function get_template_directory() { return __DIR__; }
}
if (!function_exists('get_stylesheet_directory')) {
    function get_stylesheet_directory() { return __DIR__; }
}
if (!function_exists('get_stylesheet_uri')) {
    function get_stylesheet_uri() { return './style.css'; }
}
if (!function_exists('home_url')) {
    function home_url($path = '/') { return '.' . $path; }
}
if (!function_exists('body_class')) {
    function body_class($class = '') {
        $c = is_array($class) ? implode(' ', $class) : $class;
        echo 'class="' . htmlspecialchars($c) . '"';
    }
}
if (!function_exists('wp_head')) {
    function wp_head() {}
}
if (!function_exists('wp_footer')) {
    function wp_footer() {}
}
if (!function_exists('language_attributes')) {
    function language_attributes() { echo 'lang="th"'; }
}
if (file_exists(__DIR__ . '/functions.php')) {
    require_once __DIR__ . '/functions.php';
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smart Energy Solution · ระบบจัดการพลังงานอัจฉริยะ โซลาร์เซลล์ & EV Charger | Synergy Group</title>
  <meta name="description" content="ยกระดับการบริหารจัดการพลังงานอัจฉริยะ โซลาร์เซลล์ สถานีชาร์จ EV และการเพิ่มประสิทธิภาพพลังงานโรงงานอุตสาหกรรม ด้วยแพลตฟอร์ม SynExta Energy Engine จาก Synergy Group">
  
  <link rel="canonical" href="<?php echo home_url('/smart-energy/'); ?>">
  <meta name="robots" content="index,follow">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Synergy Technology">
  <meta property="og:title" content="Smart Energy Solution · ระบบจัดการพลังงานอัจฉริยะ โซลาร์เซลล์ & EV Charger">
  <meta property="og:description" content="โซลูชันบริหารจัดการพลังงานอัจฉริยะ Solar Rooftop, EV Charging Station และ Microgrid มุ่งสู่พลังงานสะอาดยั่งยืน">
  <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/image/smart-energy.png">
  <meta property="og:url" content="<?php echo home_url('/smart-energy/'); ?>">
  <meta name="twitter:card" content="summary_large_image">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/image/s-logo.png">
  <link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/image/s-logo.png">
  <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/image/s-logo.png">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            ink: "#0B1F16",
            brand: "#1F6B43",
            "brand-bright": "#23862D",
            "brand-deep": "#165031",
            "brand-light": "#EAF3ED",
            surface: "#F8FAF9",
            body: "#2A3831",
            muted: "#5C6E65",
            "gold-bright": "#F2C72E",
          }
        }
      }
    }
  </script>
  <!-- Google Fonts & FontAwesome CDN -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Sarabun:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="<?php echo function_exists('synergy_asset') ? synergy_asset('components/style.css') : './components/style.css'; ?>">

  <style>
    body {
      font-family: 'SukhumvitSet', 'Inter', 'Sarabun', sans-serif;
      scroll-behavior: smooth;
      word-break: break-word;
      overflow-wrap: break-word;
    }
    h1, h2, h3, h4, h5, h6, .font-display {
      font-family: 'Space Grotesk', 'SukhumvitSet', sans-serif;
      word-break: keep-all;
      overflow-wrap: break-word;
    }

    /* ==========================================================================
       TYPE SCALE — matched to the site's own steps

       components/style.css fixes the site scale with !important, so it is knowable:
       root 17px / 18.5px from 1024px up, giving text-xs 14.9-16.2px, text-sm
       16.6-18.0px, text-base 18.3-19.9px, text-lg 21.2-23.1px. front-page.php leans on
       text-sm and text-xs; the smallest text anywhere else on the site is 16.2px.

       Measured on this page before the change: eyebrow 11.8px, card body 12.7px, the
       architecture labels 9.5-10.4px. Thai supporting copy at 12.7px is below any
       readable floor — Thai needs MORE than Latin at the same nominal size because
       ko-kai height matches Latin CAP height, not x-height, and the stacked vowels and
       tone marks fill in. 16px is also the accepted body minimum (Material 3 says 16sp,
       Apple HIG 17pt).

       Every token below is now a step the rest of the site already uses, in rem so it
       scales with the shared root rather than being pinned to px on this page alone.
       ========================================================================== */
    .se-eyebrow {
      font-size: 0.875rem !important;          /* = text-xs   14.9 -> 16.2px */
      font-weight: 800 !important;
      letter-spacing: .18em;
      text-transform: uppercase;
      color: #23862D;
    }
    #energy-hero .se-eyebrow { color: #4ade80; }
    /* สูตร h2 กลางของทั้งไซต์: 22px @390 / 40px @1440 / 44px @1920 (ตรงกับ index.php และ about.php) */
    .se-h2 { font-size: clamp(22px, 2.78vw, 44px) !important; line-height: 1.2 !important; font-weight: 800; }
    .se-lede { font-size: 1.075rem !important; line-height: 1.7 !important; }   /* = text-base 18.3 -> 19.9px */
    /* คำโปรยใน hero ใช้ขนาด/น้ำหนักเดียวกับ hero ของ about.php (20px / 500) */
    #energy-hero .se-lede { font-size: 1.25rem !important; font-weight: 500 !important; }  /* = text-lg 21.2 -> 23.1px */
    .se-card-t { font-size: 1.075rem !important; line-height: 1.35 !important; font-weight: 800; }   /* = text-base, bold */
    /* Cards sitting in the same row must put their description on the same line. A
       one-line title next to a longer one pushed them out of step.

       The reserve is expressed in LINES, because how many lines a title needs depends on
       how wide its column is — and the Thai titles need three at 6-across (measured:
       "เพิ่มประสิทธิภาพการผลิตไฟจากโซลาร์" wraps to 3 lines in a 6-across cell while
       "ลดค่าไฟฟ้า" takes 1). The count therefore steps down with the grid, so no
       breakpoint is left with dead space above its descriptions.
       1.35 = the .se-card-t line-height. */
    .se-card-t.se-titlebox {
      min-height: calc(var(--se-title-lines, 2) * 1.35em);
      display: flex; align-items: center;
    }
    .se-card-t.se-titlebox--center { justify-content: center; }
    .se-c6, .se-c5 { --se-title-lines: 3; }  /* 6/5 across: the longest titles need three */
    @media (max-width: 1599px) {
      .se-c6 { --se-title-lines: 2; }           /* 3 across from here: two lines is enough */
    }
    @media (max-width: 1180px) {
      .se-c5 { --se-title-lines: 2; }
    }
    @media (max-width: 520px) {
      .se-c6, .se-c5 { --se-title-lines: 1; }   /* single column: nothing wraps */
    }

    /* A flex item defaults to min-width:auto, so a long title refused to shrink below
       its longest word and pushed its card 93px past the viewport at 1265px in English.
       min-width:0 lets the text block wrap inside its grid track instead. */
    /* the card is both a grid item and a flex row; every level needs to be allowed
       to shrink or the longest word re-inflates the track */
    .se-grid > * { min-width: 0; }
    .se-grid .se-card-t, .se-grid .se-card-p, .se-grid > div > div { min-width: 0; }
    .se-grid .se-card-t > span, .se-grid .se-card-p > span { min-width: 0; }

    .se-card-p { font-size: 0.975rem !important; line-height: 1.8 !important; overflow-wrap: normal; word-break: keep-all; hyphens: none; }   /* = text-sm; 1.8 leading for Thai */
    .se-grid { display: grid; grid-auto-rows: 1fr; }
    /* ===== Page shell =================================================
       Measured at 1920px: max-w-[1400px] filled only 73.5% of the viewport, leaving a
       253px gutter each side, while every type clamp had already topped out at ~1400px.
       A big monitor therefore showed small text in a narrow column. The shell grows to
       1760px with a fluid gutter, and the raised clamps above keep scaling into it. */
    /* The primary action must not be the smallest text in its own section. */
    .se-cta-label { font-size: 0.975rem !important; letter-spacing: .06em; }

    .se-shell { width: 100%; max-width: 1760px; margin-inline: auto; padding-inline: clamp(16px, 3.2vw, 64px); }
    /* ===== SynExta architecture section - palette taken from the reference =====
       eyebrow rgb(0,98,82) | headline rgb(0,13,36) | accent word rgb(7,105,54)
       block title rgb(41,41,41) | block sub rgb(84,84,84) | tier label rgb(34,34,34)
       deployment label rgb(30,42,48) */
    #energy-platform .se-eyebrow { color: #006252; }
    #energy-platform .se-h2 { color: #000D24; }
    #energy-platform .se-accent { color: #076936; }
    #energy-platform .se-card-t { color: #292929; }

    /* Smallest phones: two columns left 136px-wide cards 505px tall at 320px,
       so these two grids fall to a single column below 380px. */
    @media (max-width: 379px) { .se-tight { grid-template-columns: 1fr !important; } }



    /* Layout column responsiveness */
    .se-c3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .se-c4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    .se-c5 { grid-template-columns: repeat(5, minmax(0, 1fr)); }
    .se-c6 { grid-template-columns: repeat(6, minmax(0, 1fr)); }
    .se-c8 { grid-template-columns: repeat(8, minmax(0, 1fr)); }

    /* The 6-up outcome row only works when a cell is wide enough for its title. At
       1265px it measured 182px per cell, where the longest titles ran to four lines and
       no two-line reserve could align them. Six across is therefore held back until
       1600px, where a cell is ~250px; below that the row reads better as 3 + 3 than as
       six cramped columns. */
    @media(max-width:1599px) {
      .se-c6 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
    @media(max-width:1180px) {
      .se-c8 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
      .se-c5 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
      .se-c4 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }
    @media(max-width:820px) {
      .se-c8 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
      .se-c6, .se-c5, .se-c4, .se-c3 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media(max-width:520px) {
      .se-c8 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
      .se-c6, .se-c5, .se-c4, .se-c3 { grid-template-columns: minmax(0, 1fr); }
    }

    /* Logo flex row */
    .se-logos {
      display: flex; flex-wrap: wrap; align-items: center; justify-content: center;
      gap: clamp(20px, 3.4vw, 56px);
    }
    .se-logos img {
      height: clamp(34px, 3.9vw, 58px); width: auto; max-width: 100%;
      object-fit: contain; display: block;
      transition: transform .2s, opacity .2s;
    }
    .se-logos img:hover { transform: translateY(-2px); }

    /* Challenge cards */

    /* Step flow */

    /* ======================================================================
       SECTION 5 — SYNEXTA ENERGY PLATFORM ARCHITECTURE
       Rebuilt to the supplied reference diagram: four stacked tiers (Enterprise
       Dashboard → Energy Engine → Energy Gateway → field devices) joined by dashed
       connectors that point UP the stack, with the Cloud / OR / On-Premise column
       branching off to the right.

       Sizes are clamp()ed because components/style.css forces every Tailwind step
       with !important and its selectors also catch the responsive variants — a plain
       text-xs here would render ~16px and blow the diagram apart.
       ====================================================================== */
    .sea {
      /* --sea-gap doubles as the length of the branch connectors that reach across the
         grid gap into the Cloud / On-Premise column, so the two can never fall out of
         step with each other. */
      --sea-gap: clamp(18px, 2vw, 30px);
      --sea-dash: #1F6B43;
      --sea-dev-gap: clamp(6px, .7vw, 13px);
      --sea-head: #1F6B43;
      display: grid; gap: var(--sea-gap);
    }
    @media (min-width: 1180px) {
      .sea {
        --sea-gap: clamp(22px, 2.4vw, 44px);
        grid-template-columns: minmax(270px, 26%) 1fr minmax(120px, 148px);
        align-items: center;
      }
    }

    /* ---- left column: the four platform features ---- */
    .sea-rule { width: 46px; height: 3px; border-radius: 99px; background: #1f6b43; margin: 14px 0 22px; }
    .sea-feats { list-style: none; margin: 0; padding: 0; display: grid; gap: clamp(16px, 1.6vw, 26px); }
    .sea-feat { display: flex; gap: 14px; align-items: flex-start; }
    .sea-feat-i {
      flex: none; width: 44px; height: 44px; border-radius: 12px;
      background: #fff; border: 1px solid #e3e9e5; color: #1f6b43;
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 1px 2px rgba(11, 31, 22, .04);
    }
    .sea-feat-i svg { width: 22px; height: 22px; }
    .sea-feat-t { font-size: 1.075rem !important; font-weight: 800; color: #0B1F16; line-height: 1.35 !important; margin-bottom: 5px; }
    .sea-feat-p { font-size: 0.975rem !important; color: #5C6E65; line-height: 1.8 !important; overflow-wrap: normal; word-break: keep-all; }

    /* ---- centre column: the diagram stack ---- */
    .sea-stack { display: grid; gap: 0; position: relative; }
    .sea-tier {
      background: #fff; border: 1px solid #e6ece8; border-radius: 16px;
      padding: clamp(12px, 1.15vw, 18px) clamp(10px, 1.1vw, 18px);
      box-shadow: 0 1px 3px rgba(11, 31, 22, .04);
      position: relative;
    }
    .sea-label {
      font-size: 0.875rem !important; font-weight: 800; letter-spacing: .14em;
      text-transform: uppercase; color: #1F6B43; text-align: center; line-height: 1.4 !important;
      margin-bottom: clamp(8px, .9vw, 14px);
    }

    /* ----------------------------------------------------------------------
       CONNECTOR LAYER — Vivid Dark Green Dashed Lines & Arrowheads
       ---------------------------------------------------------------------- */

    /* vertical run with an arrowhead pointing up the stack */
    .sea-link { height: clamp(24px, 2.2vw, 38px); position: relative; }
    .sea-link::before {
      content: ''; position: absolute; top: 0; bottom: 0; left: 50%;
      border-left: 2px dashed #1F6B43; opacity: 0.85;
    }
    .sea-link::after {
      content: ''; position: absolute; top: -2px; left: 50%; transform: translateX(-50%);
      width: 0; height: 0; border: 6px solid transparent; border-bottom-color: #1F6B43; border-top: 0;
    }

    /* The device bus: 6 device stubs rising to horizontal dashed line, 3 gateway risers going up */
    .sea-bus {
      height: clamp(28px, 2.6vw, 44px); position: relative;
      display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); column-gap: var(--sea-dev-gap);
    }
    .sea-bus::before {
      content: ''; position: absolute; top: 50%;
      left: calc((100% - 5 * var(--sea-dev-gap)) / 12);
      right: calc((100% - 5 * var(--sea-dev-gap)) / 12);
      border-top: 2px dashed #1F6B43; opacity: 0.85;
    }
    .sea-bus-cell { position: relative; }
    .sea-bus-cell::before {
      content: ''; position: absolute; top: 50%; bottom: 0; left: 50%;
      border-left: 2px dashed #1F6B43; opacity: 0.85;
    }
    /* 3 Risers pointing UP into Gateway 1, Gateway 2, Gateway 3 */
    .sea-bus-riser { position: absolute; top: 0; bottom: 50%; left: 50%; }
    .sea-bus-riser::before { content: ''; position: absolute; inset: 0; border-left: 2px dashed #1F6B43; opacity: 0.85; }
    .sea-bus-riser::after {
      content: ''; position: absolute; top: -2px; left: 0; transform: translateX(-50%);
      width: 0; height: 0; border: 6px solid transparent; border-bottom-color: #1F6B43; border-top: 0;
    }

    /* Branch connectors into the deployment column (Desktop min-width 1180px) */
    @media (min-width: 1180px) {
      .sea-engine, .sea-tier { position: relative; }
      /* Right horizontal output line extending from Engine/Tier to the vertical trunk line */
      .sea-engine::before,
      .sea-tier::before {
        content: ''; position: absolute; top: 50%; left: 100%;
        width: calc(var(--sea-gap) * 0.5); border-top: 2px dashed #1F6B43; opacity: 0.85; pointer-events: none;
      }
      
      .sea-dep-box { position: relative; }
      /* Left horizontal input line extending into Cloud / On-Premise box from vertical trunk line */
      .sea-dep-box::before {
        content: ''; position: absolute; top: 50%; right: 100%;
        width: calc(var(--sea-gap) * 0.5); border-top: 2px dashed #1F6B43; opacity: 0.85;
      }
      /* Node junction dot at the box entrance */
      .sea-dep-box::after {
        content: ''; position: absolute; top: 50%; right: calc(100% - 4px); transform: translateY(-50%);
        width: 8px; height: 8px; border-radius: 999px; background: #1F6B43;
        box-shadow: 0 0 8px rgba(31, 107, 67, 0.4);
      }
      
      /* Vertical branch trunk connecting the 3 tiers on the right side */
      .sea-stack::after {
        content: ''; position: absolute; top: 12%; bottom: 12%; right: calc(var(--sea-gap) * -0.5);
        border-right: 2px dashed #1F6B43; opacity: 0.85; pointer-events: none;
      }
    }
    /* Stacked layout: the branch comes from above instead of from the left. */
    @media (max-width: 1179px) {
      .sea-deploy { position: relative; padding-top: clamp(20px, 2vw, 34px); }
      .sea-deploy::before {
        content: ''; position: absolute; top: 0; height: clamp(20px, 2vw, 34px); left: 50%;
        border-left: 2px dashed #1F6B43; opacity: 0.85;
      }
      .sea-deploy::after {
        content: ''; position: absolute; top: clamp(20px, 2vw, 34px); left: 50%;
        transform: translate(-50%, -50%);
        width: 8px; height: 8px; border-radius: 999px; background: #1F6B43;
        box-shadow: 0 0 8px rgba(31, 107, 67, 0.4);
      }
    }

    /* dashboard / device rows */
    .sea-row { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); }
    .sea-cell { text-align: center; padding: 0 clamp(2px, .4vw, 8px); position: relative; }
    .sea-cell + .sea-cell::before {
      content: ''; position: absolute; left: 0; top: 12%; bottom: 12%; border-left: 1px solid #eef2f0;
    }
    .sea-cell svg { width: clamp(20px, 1.5vw, 26px); height: clamp(20px, 1.5vw, 26px); color: #1f6b43; margin: 0 auto clamp(5px, .5vw, 9px); display: block; }
    .sea-cell-t { font-size: 0.875rem !important; font-weight: 700; color: #2A3831; line-height: 1.35 !important; }

    /* the green engine tier */
    .sea-engine {
      background: linear-gradient(135deg, #21744a 0%, #1c6a42 45%, #14572f 100%);
      border: 0; border-radius: 16px; padding: clamp(14px, 1.3vw, 22px) clamp(12px, 1.2vw, 20px);
      position: relative; overflow: hidden;
    }
    .sea-engine::after {
      /* the faint dotted texture in the reference's top-right corner */
      content: ''; position: absolute; top: 0; right: 0; width: 42%; height: 100%;
      background-image: radial-gradient(rgba(255,255,255,.16) 1.5px, transparent 1.5px);
      background-size: 13px 13px; pointer-events: none;
    }
    .sea-engine-t {
      position: relative; z-index: 1; text-align: center; color: #fff;
      font-size: clamp(15px, 1.35vw, 25px) !important; font-weight: 800; line-height: 1.25 !important;
      margin-bottom: clamp(10px, 1.1vw, 18px);
    }
    .sea-eng-grid { position: relative; z-index: 1; display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: clamp(7px, .8vw, 14px); }
    .sea-eng-box {
      background: rgba(255, 255, 255, .13); border: 1px solid rgba(255, 255, 255, .2);
      border-radius: 11px; padding: clamp(10px, 1vw, 18px) clamp(4px, .5vw, 10px); text-align: center;
    }
    .sea-eng-box svg { width: clamp(19px, 1.4vw, 25px); height: clamp(19px, 1.4vw, 25px); color: #fff; margin: 0 auto clamp(5px, .55vw, 10px); display: block; }
    .sea-eng-box span { display: block; color: #fff; font-size: 0.875rem !important; font-weight: 700; line-height: 1.35 !important; }

    /* gateway row — three units linked left-to-right by dashed arrows */
    .sea-gw { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); align-items: center; gap: clamp(6px, .8vw, 16px); }
    .sea-gw-cell { position: relative; display: flex; justify-content: center; }
    /* left-to-right run between gateways, arrowhead on the receiving side */
    .sea-gw-cell + .sea-gw-cell::before {
      content: ''; position: absolute; top: 50%; right: 100%; width: clamp(6px, .8vw, 16px);
      border-top: 2px dashed #1F6B43; opacity: 0.85;
    }
    .sea-gw-cell + .sea-gw-cell::after {
      content: ''; position: absolute; top: 50%; right: 100%; transform: translateY(-50%);
      width: 0; height: 0; border: 6px solid transparent; border-left-color: #1F6B43; border-right: 0;
    }
    /* Capped at the source's own 106px width — upscaling these small PNGs past their
       native size only makes them soft. */
    .sea-gw img { width: 100%; max-width: clamp(72px, 7vw, 106px); height: auto; display: block; }

    /* field device row */
    .sea-devs { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: var(--sea-dev-gap); }
    .sea-dev {
      background: #fff; border: 1px solid #e6ece8; border-radius: 13px;
      padding: clamp(8px, .85vw, 14px) clamp(4px, .5vw, 9px);
      display: flex; flex-direction: column; align-items: center; justify-content: flex-start; gap: clamp(5px, .6vw, 10px);
      box-shadow: 0 1px 3px rgba(11, 31, 22, .04);
    }
    .sea-dev-img { height: clamp(38px, 3.6vw, 62px); display: flex; align-items: center; justify-content: center; }
    .sea-dev-img img { max-height: 100%; width: auto; max-width: 100%; display: block; }
    .sea-dev-img svg { height: 100%; width: auto; color: #1f6b43; }
    .sea-dev-t { font-size: 0.875rem !important; font-weight: 700; color: #2A3831; text-align: center; line-height: 1.3 !important; }

    /* ---- right column: deployment choice ---- */
    .sea-deploy { display: flex; flex-direction: column; align-items: center; gap: clamp(8px, 1vw, 14px); }
    .sea-dep-box {
      width: 100%; background: #fff; border: 1px solid #e6ece8; border-radius: 15px;
      padding: clamp(12px, 1.2vw, 20px) clamp(8px, .9vw, 14px); text-align: center;
      box-shadow: 0 1px 3px rgba(11, 31, 22, .04);
    }
    .sea-dep-box svg { width: clamp(24px, 2vw, 34px); height: clamp(24px, 2vw, 34px); color: #1f6b43; margin: 0 auto clamp(6px, .7vw, 11px); display: block; }
    .sea-dep-t { font-size: 0.975rem !important; font-weight: 800; color: #0B1F16; line-height: 1.35 !important; }
    .sea-dep-p { font-size: 0.875rem !important; color: #6E8076; line-height: 1.55 !important; margin-top: 5px; overflow-wrap: normal; word-break: keep-all; }
    .sea-or {
      width: clamp(38px, 3vw, 52px); aspect-ratio: 1; border-radius: 50%; background: #1f6b43; color: #fff;
      display: flex; align-items: center; justify-content: center; font-weight: 800;
      font-size: 0.875rem !important; letter-spacing: .06em; flex: none;
    }

    /* ---- responsive: the six-across rows cannot hold legible type on a phone ---- */
    @media (max-width: 700px) {
      .sea-row { grid-template-columns: repeat(3, minmax(0, 1fr)); row-gap: clamp(12px, 3vw, 18px); }
      .sea-cell:nth-child(3n+1)::before { display: none; }
      .sea-devs { grid-template-columns: repeat(3, minmax(0, 1fr)); }
      .sea-eng-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }

      /* Once the devices wrap onto several rows a single horizontal bus would point at
         nothing, so the junction collapses to the same plain vertical connector used
         between the other tiers. */
      .sea-bus::before,
      .sea-bus-cell::before { display: none; }
      .sea-bus-riser { top: 0; bottom: 0; }
    }
    @media (max-width: 430px) {
      .sea-row { grid-template-columns: repeat(2, minmax(0, 1fr)); }
      .sea-cell::before { display: none; }
      .sea-devs { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

  </style>

  <script>
    window.wpThemeUrl = "<?php echo get_template_directory_uri(); ?>/";
    window.wpThemeUri = "<?php echo get_template_directory_uri(); ?>/";
  </script>
  <?php wp_head(); ?>
</head>

<body id="top" <?php body_class("bg-white text-body antialiased"); ?>>
  <!-- NAVBAR CONTAINER -->
  <div id="navbar-container"></div>

  <!-- ================= 1. ส่วน HERO (ภาพหลัก) ================= -->
  <section id="energy-hero" class="relative pt-12 pb-24 sm:pt-16 sm:pb-32 lg:pt-20 lg:pb-40 text-white overflow-hidden bg-[#0a1118] min-h-[720px] sm:min-h-[800px] lg:min-h-[860px] flex items-center">
    <!-- Background Image Layer -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
      <img loading="eager" fetchpriority="high" decoding="async" class="w-full h-full object-cover object-center" src="<?php echo get_template_directory_uri(); ?>/images/hero-smart-energy.jpg" alt="Smart Energy Management Background">
      <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
    </div>
    <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#23862D_1px,transparent_1px)] [background-size:32px_32px] pointer-events-none z-0"></div>

    <div class="se-shell relative z-10 w-full">
      <!-- คอลัมน์เดียว หลังเอาภาพ dashboard ออก จำกัดความกว้างที่ max-w-3xl เท่า hero ของ about.php -->
      <div class="max-w-3xl">
          <!-- Label -->
          <p class="se-eyebrow mb-3">
            <span class="lang-th">ENERGY INTELLIGENCE</span>
            <span class="lang-en">ENERGY INTELLIGENCE</span>
          </p>
          
          <!-- หัวข้อหลัก (Locked in English) -->
          <h1 class="font-display font-extrabold text-white tracking-tight" style="font-size:clamp(30px,4.17vw,60px);line-height:1.15">
            Power Your Business with<br>
            <span class="text-brand-bright">Smart Energy Management</span>
          </h1>

          <div class="mt-2 text-emerald-400 font-semibold tracking-wide se-lede">
            One Platform for Complete Energy Visibility
          </div>

          <!-- คำอธิบาย -->
          <p class="se-lede text-slate-300 font-light mt-5 max-w-2xl">
            <span class="lang-th">
              SynExta คือแพลตฟอร์ม Smart Energy Management ที่ช่วยบริหารจัดการการใช้พลังงานและการผลิตไฟฟ้าจาก Solar Rooftop แบบ Real-time รองรับการเชื่อมต่อกับ Inverter ได้หลายแบรนด์ พร้อมควบคุมอุปกรณ์ไฟฟ้า กำหนดเวลาเปิด–ปิดอัตโนมัติ แจ้งเตือนเมื่ออุปกรณ์ผิดปกติ และเชื่อมโยงข้อมูลจากทุกไซต์งานไว้ในแพลตฟอร์มเดียว
            </span>
            <span class="lang-en">
              Monitor, control, and optimize your energy consumption and solar generation from a single intelligent platform. SynExta seamlessly integrates with multiple inverter brands, supports real-time monitoring, automated energy control, and enterprise-wide energy management across factories, commercial buildings, and multi-site businesses.
            </span>
          </p>

          <!-- ปุ่ม -->
          <div class="mt-8 flex flex-wrap gap-4">
            <a href="<?php echo home_url('/'); ?>#contact" class="inline-flex items-center gap-2.5 bg-brand-bright text-white px-8 py-4 rounded-xl font-extrabold uppercase tracking-wider hover:bg-emerald-600 transition-all shadow-lg shadow-brand-bright/30 hover:-translate-y-0.5 se-cta-label">
              <i class="fa-solid fa-paper-plane text-xs"></i>
              <span class="lang-th">ปรึกษาผู้เชี่ยวชาญ</span>
              <span class="lang-en">Talk to Our Experts</span>
            </a>
          </div>
      </div>
    </div>
  </section>

  <!-- ================= 2. ลูกค้าที่ไว้วางใจ ================= -->
  <section id="energy-leaders" class="py-10 sm:py-12 bg-white border-b border-slate-100">
    <div class="se-shell">
      <p class="se-eyebrow text-center mb-2">
        <span class="lang-th">ลูกค้าที่ไว้วางใจ</span>
        <span class="lang-en">TRUSTED FOR ENERGY MANAGEMENT</span>
      </p>
      <!-- หัวข้อ -->
      <h2 class="se-h2 font-display text-ink text-center mb-8">
        <span class="lang-th">โซลูชันที่ตอบโจทย์ธุรกิจด้านพลังงาน</span>
        <span class="lang-en">Trusted by Energy Leaders</span>
      </h2>
      <!-- โลโก้ลูกค้า -->
      <div class="se-logos">
        <img src="<?php echo get_template_directory_uri(); ?>/image/NIDA_WISDOM.png" alt="NIDA WISDOM for Change" title="NIDA" loading="lazy">
        <img src="<?php echo get_template_directory_uri(); ?>/images/nida-logo.jpg" alt="NIDA Smart Energy Project" title="NIDA Project" loading="lazy">
        <img src="<?php echo get_template_directory_uri(); ?>/image/SANSIRI.png" alt="SANSIRI" title="San Siri" loading="lazy">
        <img src="<?php echo get_template_directory_uri(); ?>/image/Valuation_Engineering.png" alt="Valuation Engineering" title="VALUATION ENGINEERING" loading="lazy">
      </div>
    </div>
  </section>

  <!-- ================= 3. ปัญหาที่เราช่วยแก้ไข ================= -->
  <section id="energy-challenges" class="py-12 sm:py-16 bg-slate-50/50" style="scroll-margin-top:96px">
    <div class="se-shell">
      <p class="se-eyebrow text-center mb-2">
        <span class="lang-th">ปัญหาที่เราช่วยแก้ไข</span>
        <span class="lang-en">ENERGY CHALLENGES WE SOLVE</span>
      </p>
      <!-- หัวข้อ -->
      <h2 class="se-h2 font-display text-ink text-center mb-9 sm:mb-12">
        <span class="lang-th">ปัญหาด้านพลังงานที่ธุรกิจส่วนใหญ่กำลังเผชิญ</span>
        <span class="lang-en">Challenges We Help You Solve</span>
      </h2>
      <!-- 6 Cards Grid (Exact match with reference image) -->
      <div class="se-tight grid auto-rows-fr grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4 sm:gap-5">

        <!-- Card 1: No Real-Time Energy Visibility -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col items-center text-center group">
          <div class="w-20 h-20 sm:w-24 sm:h-24 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/challenge_canva_1.png" alt="No Real-Time Energy Visibility" class="w-full h-full object-contain drop-shadow-sm">
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-2 leading-snug tracking-tight">
            <span class="lang-th">มองไม่เห็นข้อมูลการใช้พลังงานแบบ Real-time</span>
            <span class="lang-en">No Real-Time<br>Energy Visibility</span>
          </h3>
          <p class="text-[11px] sm:text-xs text-slate-500 font-normal leading-relaxed">
            <span class="lang-th">ไม่สามารถติดตามการใช้ไฟฟ้าและการผลิตไฟจาก Solar ได้ทันที ทำให้ตัดสินใจได้ช้า</span>
            <span class="lang-en">Unable to monitor electricity usage and solar production in real time.</span>
          </p>
        </div>

        <!-- Card 2: Multiple Inverter Brands -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col items-center text-center group">
          <div class="w-20 h-20 sm:w-24 sm:h-24 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/challenge_canva_2.png" alt="Multiple Inverter Brands" class="w-full h-full object-contain drop-shadow-sm">
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-2 leading-snug tracking-tight">
            <span class="lang-th">ใช้ Inverter หลายแบรนด์</span>
            <span class="lang-en">Multiple Inverter<br>Brands</span>
          </h3>
          <p class="text-[11px] sm:text-xs text-slate-500 font-normal leading-relaxed">
            <span class="lang-th">แต่ละแบรนด์มีระบบ Monitoring แยกกัน ทำให้บริหารจัดการข้อมูลได้ยาก</span>
            <span class="lang-en">Different monitoring systems make solar management complicated.</span>
          </p>
        </div>

        <!-- Card 3: Multiple Sites -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col items-center text-center group">
          <div class="w-20 h-20 sm:w-24 sm:h-24 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/challenge_canva_3.png" alt="Multiple Sites" class="w-full h-full object-contain drop-shadow-sm">
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-2 leading-snug tracking-tight">
            <span class="lang-th">มีหลายโรงงานหรือหลายสาขา</span>
            <span class="lang-en">Multiple Sites</span>
          </h3>
          <p class="text-[11px] sm:text-xs text-slate-500 font-normal leading-relaxed">
            <span class="lang-th">ต้องเปิดหลายระบบเพื่อดูข้อมูลของแต่ละไซต์ ทำให้เสียเวลาและควบคุมได้ยาก</span>
            <span class="lang-en">Managing dozens or hundreds of branches from different platforms.</span>
          </p>
        </div>

        <!-- Card 4: High Electricity Cost -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col items-center text-center group">
          <div class="w-20 h-20 sm:w-24 sm:h-24 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/challenge_canva_4.png" alt="High Electricity Cost" class="w-full h-full object-contain drop-shadow-sm">
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-2 leading-snug tracking-tight">
            <span class="lang-th">ค่าไฟฟ้าสูงขึ้นอย่างต่อเนื่อง</span>
            <span class="lang-en">High Electricity<br>Cost</span>
          </h3>
          <p class="text-[11px] sm:text-xs text-slate-500 font-normal leading-relaxed">
            <span class="lang-th">ไม่ทราบว่าพลังงานถูกใช้ในส่วนใดมากที่สุด จึงไม่สามารถลดต้นทุนได้อย่างมีประสิทธิภาพ</span>
            <span class="lang-en">Lack of insight into energy usage increases operating expenses.</span>
          </p>
        </div>

        <!-- Card 5: Late Equipment Failure Detection -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col items-center text-center group">
          <div class="w-20 h-20 sm:w-24 sm:h-24 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/challenge_canva_5.png" alt="Late Equipment Failure Detection" class="w-full h-full object-contain drop-shadow-sm">
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-2 leading-snug tracking-tight">
            <span class="lang-th">อุปกรณ์เสียแต่รู้ตัวช้า</span>
            <span class="lang-en">Late Equipment<br>Failure Detection</span>
          </h3>
          <p class="text-[11px] sm:text-xs text-slate-500 font-normal leading-relaxed">
            <span class="lang-th">Inverter หรืออุปกรณ์ไฟฟ้ามีปัญหา แต่ไม่มีระบบแจ้งเตือน ทำให้สูญเสียโอกาสในการผลิตไฟฟ้า</span>
            <span class="lang-en">Equipment problems are discovered after production losses occur.</span>
          </p>
        </div>

        <!-- Card 6: Limited User Management -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col items-center text-center group">
          <div class="w-20 h-20 sm:w-24 sm:h-24 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/challenge_canva_6.png" alt="Limited User Management" class="w-full h-full object-contain drop-shadow-sm">
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-2 leading-snug tracking-tight">
            <span class="lang-th">จัดการสิทธิ์ผู้ใช้งานได้ยาก</span>
            <span class="lang-en">Limited User<br>Management</span>
          </h3>
          <p class="text-[11px] sm:text-xs text-slate-500 font-normal leading-relaxed">
            <span class="lang-th">ไม่สามารถกำหนดสิทธิ์ให้เจ้าของกิจการ ผู้ติดตั้ง และผู้จัดการแต่ละสาขาเข้าถึงข้อมูลเฉพาะที่เกี่ยวข้องได้</span>
            <span class="lang-en">Difficult to control access for installers, owners and branch managers.</span>
          </p>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= 4. จากข้อมูลพลังงาน สู่การบริหารจัดการอัจฉริยะ ================= -->
  <section id="energy-flow" class="py-12 sm:py-16 bg-white border-y border-slate-100" style="scroll-margin-top:96px">
    <div class="se-shell">
      <p class="se-eyebrow text-center mb-2">
        <span class="lang-th">จากข้อมูลพลังงาน สู่การบริหารจัดการอัจฉริยะ</span>
        <span class="lang-en">END-TO-END ENERGY MANAGEMENT</span>
      </p>
      <!-- หัวข้อ -->
      <h2 class="se-h2 font-display text-ink text-center mb-10 sm:mb-12">
        <span class="lang-th">เปลี่ยนข้อมูลพลังงานให้เป็นการตัดสินใจที่มีประสิทธิภาพ</span>
        <span class="lang-en">From Energy Data to Intelligent Decisions</span>
      </h2>

      <!-- 6 Steps Grid (Exact match with reference image) -->
      <div class="grid auto-rows-fr grid-cols-1 sm:grid-cols-2 md:grid-cols-3 2xl:grid-cols-6 gap-4 sm:gap-5">
        
        <!-- Step 01: Connect -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group">
          <div>
            <!-- Top Step Badge -->
            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-extrabold flex items-center justify-center text-xs mb-4 shadow-sm">
              01
            </div>

            <!-- 3D Graphic Image -->
            <div class="w-full h-28 sm:h-32 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
              <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_canva/step_1.png" alt="01 Connect" class="max-w-full max-h-full object-contain drop-shadow-sm">
            </div>

            <!-- Title & Description -->
            <h3 class="font-extrabold text-slate-900 text-base mb-2 tracking-tight">
              <span class="lang-th">01 Connect</span>
              <span class="lang-en">01 Connect</span>
            </h3>
            <p class="text-xs text-slate-500 font-normal leading-relaxed">
              <span class="lang-th">เชื่อมต่อ Solar Inverter, Energy Meter, ระบบไฟฟ้า และอุปกรณ์ IoT Sensors</span>
              <span class="lang-en">Connect Solar Inverters, Energy Meters, Building Devices, and IoT Sensors.</span>
            </p>
          </div>

          <!-- Bottom Tags -->
          <div>
            <div class="w-12 h-0.5 bg-emerald-300 rounded-full my-3.5"></div>
            <div class="flex flex-col gap-2">
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-solar-panel text-emerald-600 text-xs"></i>
                <span>Solar Inverter</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-bolt text-emerald-600 text-xs"></i>
                <span>Energy Meter</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-plug text-emerald-600 text-xs"></i>
                <span class="lang-th">ระบบไฟฟ้า</span><span class="lang-en">Building System</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-wifi text-emerald-600 text-xs"></i>
                <span>IoT Sensors</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 02: Collect -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group">
          <div>
            <!-- Top Step Badge -->
            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-extrabold flex items-center justify-center text-xs mb-4 shadow-sm">
              02
            </div>

            <!-- 3D Graphic Image -->
            <div class="w-full h-28 sm:h-32 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
              <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_canva/step_2.png" alt="02 Collect" class="max-w-full max-h-full object-contain drop-shadow-sm">
            </div>

            <!-- Title & Description -->
            <h3 class="font-extrabold text-slate-900 text-base mb-2 tracking-tight">
              <span class="lang-th">02 Collect</span>
              <span class="lang-en">02 Collect</span>
            </h3>
            <p class="text-xs text-slate-500 font-normal leading-relaxed">
              <span class="lang-th">รวบรวมข้อมูลการผลิตไฟและการใช้พลังงานจากทุกไซต์เข้าสู่แพลตฟอร์มเดียว</span>
              <span class="lang-en">Collect real-time energy data from every site into one platform.</span>
            </p>
          </div>

          <!-- Bottom Tags -->
          <div>
            <div class="w-12 h-0.5 bg-emerald-300 rounded-full my-3.5"></div>
            <div class="flex flex-col gap-2">
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-regular fa-clock text-emerald-600 text-xs"></i>
                <span>Real-time Data</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-sitemap text-emerald-600 text-xs"></i>
                <span>Multi-site Aggregation</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 03: Visualize -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group">
          <div>
            <!-- Top Step Badge -->
            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-extrabold flex items-center justify-center text-xs mb-4 shadow-sm">
              03
            </div>

            <!-- 3D Graphic Image -->
            <div class="w-full h-28 sm:h-32 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
              <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_canva/step_3.png" alt="03 Visualize" class="max-w-full max-h-full object-contain drop-shadow-sm">
            </div>

            <!-- Title & Description -->
            <h3 class="font-extrabold text-slate-900 text-base mb-2 tracking-tight">
              <span class="lang-th">03 Visualize</span>
              <span class="lang-en">03 Visualize</span>
            </h3>
            <p class="text-xs text-slate-500 font-normal leading-relaxed">
              <span class="lang-th">Dashboard, รายงาน, Energy KPIs และระบบการแจ้งเตือนแบบ Real-time</span>
              <span class="lang-en">Dashboard, Reports, Alerts, Energy KPIs — all in real-time.</span>
            </p>
          </div>

          <!-- Bottom Tags -->
          <div>
            <div class="w-12 h-0.5 bg-emerald-300 rounded-full my-3.5"></div>
            <div class="flex flex-col gap-2">
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-table-cells-large text-emerald-600 text-xs"></i>
                <span>Dashboard</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-regular fa-file-lines text-emerald-600 text-xs"></i>
                <span class="lang-th">รายงาน</span><span class="lang-en">Reports</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-bullseye text-emerald-600 text-xs"></i>
                <span>KPI</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-regular fa-bell text-emerald-600 text-xs"></i>
                <span class="lang-th">แจ้งเตือน Real-time</span><span class="lang-en">Real-time Alerts</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 04: Optimize -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group">
          <div>
            <!-- Top Step Badge -->
            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-extrabold flex items-center justify-center text-xs mb-4 shadow-sm">
              04
            </div>

            <!-- 3D Graphic Image -->
            <div class="w-full h-28 sm:h-32 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
              <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_canva/step_4.png" alt="04 Optimize" class="max-w-full max-h-full object-contain drop-shadow-sm">
            </div>

            <!-- Title & Description -->
            <h3 class="font-extrabold text-slate-900 text-base mb-2 tracking-tight">
              <span class="lang-th">04 Optimize</span>
              <span class="lang-en">04 Optimize</span>
            </h3>
            <p class="text-xs text-slate-500 font-normal leading-relaxed">
              <span class="lang-th">สั่งเปิด–ปิดอุปกรณ์ไฟฟ้า กำหนดเวลาการทำงาน และบริหารโหลดไฟฟ้าอัตโนมัติ</span>
              <span class="lang-en">Lighting Automation, Schedule Control, and Load Management.</span>
            </p>
          </div>

          <!-- Bottom Tags -->
          <div>
            <div class="w-12 h-0.5 bg-emerald-300 rounded-full my-3.5"></div>
            <div class="flex flex-col gap-2">
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-power-off text-emerald-600 text-xs"></i>
                <span class="lang-th">เปิด-ปิดอุปกรณ์</span><span class="lang-en">Device Switch</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-regular fa-clock text-emerald-600 text-xs"></i>
                <span class="lang-th">กำหนดเวลาการทำงาน</span><span class="lang-en">Schedule Control</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-emerald-600 text-xs"></i>
                <span>Load Management</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 05: Integrate -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group">
          <div>
            <!-- Top Step Badge -->
            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-extrabold flex items-center justify-center text-xs mb-4 shadow-sm">
              05
            </div>

            <!-- 3D Graphic Image -->
            <div class="w-full h-28 sm:h-32 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
              <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_canva/step_5.png" alt="05 Integrate" class="max-w-full max-h-full object-contain drop-shadow-sm">
            </div>

            <!-- Title & Description -->
            <h3 class="font-extrabold text-slate-900 text-base mb-2 tracking-tight">
              <span class="lang-th">05 Integrate</span>
              <span class="lang-en">05 Integrate</span>
            </h3>
            <p class="text-xs text-slate-500 font-normal leading-relaxed">
              <span class="lang-th">เชื่อมต่อ ERP, BMS, SCADA และระบบภายนอกองค์กรผ่าน Open API</span>
              <span class="lang-en">Connect ERP, BMS, SCADA and external systems via API.</span>
            </p>
          </div>

          <!-- Bottom Tags -->
          <div>
            <div class="w-12 h-0.5 bg-emerald-300 rounded-full my-3.5"></div>
            <div class="flex flex-col gap-2">
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-regular fa-folder text-emerald-600 text-xs"></i>
                <span>ERP</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-building text-emerald-600 text-xs"></i>
                <span>BMS</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-desktop text-emerald-600 text-xs"></i>
                <span>SCADA</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-code text-emerald-600 text-xs"></i>
                <span>API</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 06: Grow with AI -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group">
          <div>
            <!-- Top Step Badge -->
            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-extrabold flex items-center justify-center text-xs mb-4 shadow-sm">
              06
            </div>

            <!-- 3D Graphic Image -->
            <div class="w-full h-28 sm:h-32 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
              <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_canva/step_6.png" alt="06 Grow with AI" class="max-w-full max-h-full object-contain drop-shadow-sm">
            </div>

            <!-- Title & Description -->
            <h3 class="font-extrabold text-slate-900 text-base mb-2 tracking-tight">
              <span class="lang-th">06 Grow with AI</span>
              <span class="lang-en">06 Grow with AI</span>
            </h3>
            <p class="text-xs text-slate-500 font-normal leading-relaxed">
              <span class="lang-th">คำแนะนำจาก AI ในการประหยัดพลังงาน และวิเคราะห์คาดการณ์ล่วงหน้า</span>
              <span class="lang-en">AI Recommendations, Energy Saving Suggestions, and Predictive Analytics.</span>
            </p>
          </div>

          <!-- Bottom Tags -->
          <div>
            <div class="w-12 h-0.5 bg-emerald-300 rounded-full my-3.5"></div>
            <div class="flex flex-col gap-2">
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-wand-magic-sparkles text-emerald-600 text-xs"></i>
                <span>AI Recommendations</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-leaf text-emerald-600 text-xs"></i>
                <span>Energy Saving Suggestions</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-emerald-600 text-xs"></i>
                <span>Predictive Analytics</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= 5. สถาปัตยกรรมแพลตฟอร์ม SYNEXTA ENERGY ================= -->
  <section id="energy-platform" class="py-12 sm:py-16 bg-[#f6f8f7] border-y border-slate-100" style="scroll-margin-top:96px">
    <div class="se-shell">
      <div class="sea">

        <!-- ═══════════ LEFT: heading + the four platform features ═══════════ -->
        <div>
          <p class="se-eyebrow mb-3">
            <span class="lang-th">แพลตฟอร์ม SYNEXTA ENERGY</span>
            <span class="lang-en">SYNEXTA ENERGY PLATFORM</span>
          </p>
          <!-- หัวข้อ -->
          <h2 class="se-h2 font-display text-ink">
            <span class="lang-th">แพลตฟอร์มเดียว<br>บริหารพลังงาน<span class="se-accent">ทุกไซต์งาน</span></span>
            <span class="lang-en">One Platform.<br><span class="se-accent">Every Site.</span></span>
          </h2>
          <div class="sea-rule"></div>

          <ul class="sea-feats">

            <!-- 1. รองรับ Inverter หลายแบรนด์ -->
            <li class="sea-feat">
              <span class="sea-feat-i" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="12" r="3.1"/>
                  <path d="M12 2.4v3M12 18.5v3M2.4 12h3M18.5 12h3M5.2 5.2l2.1 2.1M16.7 16.7l2.1 2.1M18.8 5.2l-2.1 2.1M7.3 16.7l-2.1 2.1"/>
                </svg>
              </span>
              <div>
                <div class="sea-feat-t">
                  <span class="lang-th">รองรับ Inverter หลายแบรนด์</span>
                  <span class="lang-en">Multi-brand Inverter Integration</span>
                </div>
                <p class="sea-feat-p">
                  <span class="lang-th">เชื่อมต่ออินเวอร์เตอร์แบรนด์หลักได้ทั้งหมด ทั้ง Huawei, Sungrow, GoodWe, Growatt, SMA, Fronius, Delta, Solis และแบรนด์อื่น ๆ ไว้ในแพลตฟอร์มเดียว</span>
                  <span class="lang-en">Connect all major inverter brands — Huawei, Sungrow, GoodWe, Growatt, SMA, Fronius, Delta, Solis and more — into one unified platform.</span>
                </p>
              </div>
            </li>

            <!-- 2. บริหารจัดการหลายไซต์ -->
            <li class="sea-feat">
              <span class="sea-feat-i" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M3 21h18M5 21V8.6l5.4-3.4V21M14 21V10.4l5 2.6V21"/>
                  <path d="M7.6 11.4h.9M7.6 14.4h.9M16.4 15.6h.9"/>
                </svg>
              </span>
              <div>
                <div class="sea-feat-t">
                  <span class="lang-th">บริหารจัดการหลายไซต์</span>
                  <span class="lang-en">Multi-site Management</span>
                </div>
                <p class="sea-feat-p">
                  <span class="lang-th">ติดตามไซต์งาน โรงงาน สาขา และระบบ Solar ได้ไม่จำกัดจำนวน จากศูนย์กลางเดียว</span>
                  <span class="lang-en">Monitor unlimited sites, factories, branches and solar installations.</span>
                </p>
              </div>
            </li>

            <!-- 3. ติดตั้งได้ยืดหยุ่น -->
            <li class="sea-feat">
              <span class="sea-feat-i" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M6.6 18.4h10.9a3.6 3.6 0 0 0 .5-7.16 5.4 5.4 0 0 0-10.4-1.5A4.35 4.35 0 0 0 6.6 18.4Z"/>
                </svg>
              </span>
              <div>
                <div class="sea-feat-t">
                  <span class="lang-th">ติดตั้งได้ยืดหยุ่น</span>
                  <span class="lang-en">Flexible Deployment</span>
                </div>
                <p class="sea-feat-p">
                  <span class="lang-th">เลือกติดตั้งแบบ Cloud, On-Premise หรือ Hybrid ได้ตามนโยบายด้าน IT ขององค์กร</span>
                  <span class="lang-en">Cloud, On-Premise or Hybrid deployment to fit your IT policy.</span>
                </p>
              </div>
            </li>

            <!-- 4. เชื่อมต่อระบบอื่นได้ -->
            <li class="sea-feat">
              <span class="sea-feat-i" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 2.7l7.4 3v5.6c0 4.5-3 8.3-7.4 9.9-4.4-1.6-7.4-5.4-7.4-9.9V5.7l7.4-3Z"/>
                  <path d="M9.3 12.1l1.9 1.9 3.6-3.7"/>
                </svg>
              </span>
              <div>
                <div class="sea-feat-t">
                  <span class="lang-th">เชื่อมต่อระบบอื่นได้</span>
                  <span class="lang-en">Open Integration</span>
                </div>
                <p class="sea-feat-p">
                  <span class="lang-th">เชื่อมต่อกับ ERP, BMS, CMMS และระบบอื่น ๆ ขององค์กรได้ผ่าน Open API</span>
                  <span class="lang-en">Seamlessly integrate with ERP, BMS, CMMS and other systems via open API.</span>
                </p>
              </div>
            </li>

          </ul>
        </div>

        <!-- ═══════════ CENTRE: the architecture stack ═══════════ -->
        <div class="sea-stack">

          <!-- Tier 1 — Enterprise Dashboard -->
          <div class="sea-tier">
            <div class="sea-label">
              <span class="lang-th">แดชบอร์ดสำหรับองค์กร</span>
              <span class="lang-en">Enterprise Dashboard</span>
            </div>
            <div class="sea-row">
              <div class="sea-cell">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <rect x="3" y="3" width="7.4" height="7.4" rx="1.6"/><rect x="13.6" y="3" width="7.4" height="7.4" rx="1.6"/>
                  <rect x="3" y="13.6" width="7.4" height="7.4" rx="1.6"/><rect x="13.6" y="13.6" width="7.4" height="7.4" rx="1.6"/>
                </svg>
                <div class="sea-cell-t"><span class="lang-th">ภาพรวม</span><span class="lang-en">Overview</span></div>
              </div>
              <div class="sea-cell">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M3 21h18M5 21V6.4l6-2.6V21M15 21v-9.4l4.6 2V21"/><path d="M7.7 9h.8M7.7 12h.8M7.7 15h.8"/>
                </svg>
                <div class="sea-cell-t"><span class="lang-th">ไซต์งาน</span><span class="lang-en">Sites</span></div>
              </div>
              <div class="sea-cell">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M6.4 2.8h7.2L18.6 8v13.2H6.4V2.8Z"/><path d="M13.4 2.8V8h5.2"/><path d="M9.2 12.4h6M9.2 16h4.2"/>
                </svg>
                <div class="sea-cell-t"><span class="lang-th">รายงาน</span><span class="lang-en">Reports</span></div>
              </div>
              <div class="sea-cell">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M18 16.4V11a6 6 0 1 0-12 0v5.4L4.4 18.6h15.2L18 16.4Z"/><path d="M10.2 21.4h3.6"/>
                </svg>
                <div class="sea-cell-t"><span class="lang-th">การแจ้งเตือน</span><span class="lang-en">Alerts</span></div>
              </div>
              <div class="sea-cell">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M3.4 17.6l5-5.6 3.6 2.8 4-5.2 4.6-2.6"/><path d="M16.4 7h4.2v4.2"/>
                </svg>
                <div class="sea-cell-t"><span class="lang-th">วิเคราะห์ข้อมูล</span><span class="lang-en">Analytics</span></div>
              </div>
              <div class="sea-cell">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <circle cx="9.2" cy="8.4" r="3.4"/><path d="M3.2 20.2a6 6 0 0 1 12 0"/>
                  <path d="M16.2 5.4a3.2 3.2 0 0 1 0 6M18.6 20.2a5.9 5.9 0 0 0-2.2-4.6"/>
                </svg>
                <div class="sea-cell-t"><span class="lang-th">ผู้ใช้งาน</span><span class="lang-en">Users</span></div>
              </div>
            </div>
          </div>

          <!-- Tier 2 — SynExta Energy Engine -->
          <div class="sea-engine">
            <div class="sea-engine-t">SynExta Energy Engine</div>
            <div class="sea-eng-grid">
              <div class="sea-eng-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <rect x="3.4" y="5.4" width="17.2" height="13.2" rx="3"/>
                  <path d="M8.4 15V11l1.8 2.6L12 11v4M15 11v4h2.6"/>
                </svg>
                <span>AI Analytics</span>
              </div>
              <div class="sea-eng-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M6.4 2.8h7.2L18.6 8v13.2H6.4V2.8Z"/><path d="M13.4 2.8V8h5.2"/>
                  <path d="M9.4 13.4l1.6 1.6 3.4-3.4"/>
                </svg>
                <span>Rule Engine</span>
              </div>
              <div class="sea-eng-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <rect x="3.4" y="4" width="17.2" height="16" rx="2.6"/>
                  <path d="M8 15.6V11M12 15.6V8.4M16 15.6v-3"/>
                </svg>
                <span>Energy Analytics</span>
              </div>
              <div class="sea-eng-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M17.6 15.4V11a5.6 5.6 0 1 0-11.2 0v4.4L5 17.4h14l-1.4-2Z"/>
                  <path d="M10.4 20.2h3.2"/><circle cx="18.4" cy="6.2" r="2.6"/>
                </svg>
                <span>Alert Engine</span>
              </div>
            </div>
          </div>

          <!-- 2 Vertical Dashed SVG Arrows connecting Gateway up to Energy Engine -->
          <div class="h-9 relative my-1 hidden sm:block">
            <svg class="w-full h-full overflow-visible" preserveAspectRatio="none">
              <defs>
                <marker id="sea-up-arrow" viewBox="0 0 10 10" refX="5" refY="1.5" markerWidth="6" markerHeight="6" orient="auto">
                  <path d="M 1.5 8.5 L 5 1.5 L 8.5 8.5 z" fill="#1F6B43" />
                </marker>
              </defs>
              <line id="sea-line-left-v" x1="16.66%" y1="36" x2="12.5%" y2="8" stroke="#1F6B43" stroke-width="2" stroke-dasharray="4 4" marker-end="url(#sea-up-arrow)" />
              <line id="sea-line-right-v" x1="83.33%" y1="36" x2="87.5%" y2="8" stroke="#1F6B43" stroke-width="2" stroke-dasharray="4 4" marker-end="url(#sea-up-arrow)" />
            </svg>
          </div>
          <div class="h-6 relative my-1 block sm:hidden">
            <svg class="w-full h-full overflow-visible" preserveAspectRatio="none">
              <line x1="50%" y1="24" x2="50%" y2="6" stroke="#1F6B43" stroke-width="2" stroke-dasharray="4 4" marker-end="url(#sea-up-arrow)" />
            </svg>
          </div>

          <!-- Tier 3 — Energy Gateway -->
          <div class="sea-tier relative">
            <div class="sea-label">
              <span class="lang-th">เกตเวย์พลังงาน</span>
              <span class="lang-en">Energy Gateway</span>
            </div>

            <!-- SVG Dashed Lines Connecting Gateway 1 <-> 2 <-> 3 -->
            <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 pointer-events-none hidden sm:block z-0 px-[16.66%]">
              <svg class="w-full h-4 overflow-visible" preserveAspectRatio="none">
                <defs>
                  <marker id="sea-left-arrow" viewBox="0 0 10 10" refX="1.5" refY="5" markerWidth="6" markerHeight="6" orient="auto">
                    <path d="M 8.5 1.5 L 1.5 5 L 8.5 8.5 z" fill="#1F6B43" />
                  </marker>
                  <marker id="sea-right-arrow" viewBox="0 0 10 10" refX="8.5" refY="5" markerWidth="6" markerHeight="6" orient="auto">
                    <path d="M 1.5 1.5 L 8.5 5 L 1.5 8.5 z" fill="#1F6B43" />
                  </marker>
                </defs>
                <line id="sea-line-gw-12" x1="12%" y1="8" x2="38%" y2="8" stroke="#1F6B43" stroke-width="2" stroke-dasharray="4 4" marker-start="url(#sea-left-arrow)" marker-end="url(#sea-right-arrow)" />
                <line id="sea-line-gw-23" x1="62%" y1="8" x2="88%" y2="8" stroke="#1F6B43" stroke-width="2" stroke-dasharray="4 4" marker-start="url(#sea-left-arrow)" marker-end="url(#sea-right-arrow)" />
              </svg>
            </div>

            <div class="grid grid-cols-3 gap-4 relative z-10">
              <div class="flex justify-center items-center"><img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/energy-arch/gateway-1.png" alt="Energy Gateway 1" class="max-w-[106px] w-full h-auto"></div>
              <div class="flex justify-center items-center"><img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/energy-arch/gateway-2.png" alt="Energy Gateway 2" class="max-w-[106px] w-full h-auto"></div>
              <div class="flex justify-center items-center"><img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/energy-arch/gateway-3.png" alt="Energy Gateway 3" class="max-w-[106px] w-full h-auto"></div>
            </div>
          </div>

          <!-- Gateway <-> Device Junction Bus with 6 Device Stubs and Center Riser into Gateway 2 -->
          <div class="h-10 relative my-1 hidden sm:block">
            <svg class="w-full h-full overflow-visible" preserveAspectRatio="none">
              <defs>
                <marker id="sea-up-arrow-bus" viewBox="0 0 10 10" refX="5" refY="1.5" markerWidth="6" markerHeight="6" orient="auto">
                  <path d="M 1.5 8.5 L 5 1.5 L 8.5 8.5 z" fill="#1F6B43" />
                </marker>
              </defs>
              <!-- Horizontal Bus Line -->
              <line id="sea-line-bus-main" x1="8.33%" y1="20" x2="91.66%" y2="20" stroke="#1F6B43" stroke-width="2" stroke-dasharray="4 4" />
              
              <!-- 6 Device Stubs pointing UP to the bus line -->
              <line x1="8.33%" y1="40" x2="8.33%" y2="22" stroke="#1F6B43" stroke-width="2" stroke-dasharray="4 4" marker-end="url(#sea-up-arrow-bus)" />
              <line x1="25%" y1="40" x2="25%" y2="22" stroke="#1F6B43" stroke-width="2" stroke-dasharray="4 4" marker-end="url(#sea-up-arrow-bus)" />
              <line x1="41.66%" y1="40" x2="41.66%" y2="22" stroke="#1F6B43" stroke-width="2" stroke-dasharray="4 4" marker-end="url(#sea-up-arrow-bus)" />
              <line x1="58.33%" y1="40" x2="58.33%" y2="22" stroke="#1F6B43" stroke-width="2" stroke-dasharray="4 4" marker-end="url(#sea-up-arrow-bus)" />
              <line x1="75%" y1="40" x2="75%" y2="22" stroke="#1F6B43" stroke-width="2" stroke-dasharray="4 4" marker-end="url(#sea-up-arrow-bus)" />
              <line x1="91.66%" y1="40" x2="91.66%" y2="22" stroke="#1F6B43" stroke-width="2" stroke-dasharray="4 4" marker-end="url(#sea-up-arrow-bus)" />

              <!-- Center Gateway Riser pointing UP into Gateway 2 -->
              <line id="sea-line-bus-riser" x1="50%" y1="20" x2="50%" y2="6" stroke="#1F6B43" stroke-width="2" stroke-dasharray="4 4" marker-end="url(#sea-up-arrow-bus)" />
            </svg>
          </div>
          <div class="h-6 relative my-1 block sm:hidden">
            <svg class="w-full h-full overflow-visible" preserveAspectRatio="none">
              <line x1="50%" y1="24" x2="50%" y2="6" stroke="#1F6B43" stroke-width="2" stroke-dasharray="4 4" marker-end="url(#sea-up-arrow-bus)" />
            </svg>
          </div>

          <!-- Tier 4 — field devices -->
          <div class="sea-devs">
            <div class="sea-dev">
              <span class="sea-dev-img"><img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/energy-arch/solar-inverter.png" alt="Solar Inverter อินเวอร์เตอร์แปลงไฟจากแผงโซลาร์"></span>
              <div class="sea-dev-t">Solar Inverter</div>
            </div>
            <div class="sea-dev">
              <span class="sea-dev-img"><img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/energy-arch/energy-meter.png" alt="Energy Meter มิเตอร์วัดพลังงานไฟฟ้า"></span>
              <div class="sea-dev-t">Energy Meter</div>
            </div>
            <div class="sea-dev">
              <span class="sea-dev-img"><img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/energy-arch/lighting-controller.png" alt="Lighting Controller ชุดควบคุมระบบแสงสว่าง"></span>
              <div class="sea-dev-t">Lighting Controller</div>
            </div>
            <div class="sea-dev">
              <span class="sea-dev-img"><img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/energy-arch/hvac.png" alt="HVAC ระบบปรับอากาศ"></span>
              <div class="sea-dev-t">HVAC</div>
            </div>
            <div class="sea-dev">
              <span class="sea-dev-img"><img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/energy-arch/ev-charger.png" alt="EV Charger เครื่องอัดประจุยานยนต์ไฟฟ้า"></span>
              <div class="sea-dev-t">EV Charger</div>
            </div>
            <div class="sea-dev">
              <span class="sea-dev-img" aria-hidden="true">
                <!-- IoT Sensor drawn inline as the reference's green node graphic -->
                <svg viewBox="0 0 62 62" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                  <circle cx="31" cy="31" r="6.4" fill="#eef5f1"/>
                  <path d="M31 24.6V12M31 37.4v12.6M24.6 31H12M37.4 31H50"/>
                  <circle cx="31" cy="9" r="4.2"/><circle cx="31" cy="53" r="4.2"/>
                  <circle cx="9" cy="31" r="4.2"/><circle cx="53" cy="31" r="4.2"/>
                </svg>
              </span>
              <div class="sea-dev-t">IoT Sensor</div>
            </div>
          </div>
        </div>

        <!-- ═══════════ RIGHT: deployment choice ═══════════ -->
        <div class="sea-deploy">
          <div class="sea-dep-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M6.6 18.4h10.9a3.6 3.6 0 0 0 .5-7.16 5.4 5.4 0 0 0-10.4-1.5A4.35 4.35 0 0 0 6.6 18.4Z"/>
            </svg>
            <div class="sea-dep-t">Cloud</div>
            <p class="sea-dep-p">
              <span class="lang-th">โครงสร้างคลาวด์ ปลอดภัยและขยายได้</span>
              <span class="lang-en">Secure &amp; Scalable Cloud Infrastructure</span>
            </p>
          </div>

          <div class="sea-or"><span class="lang-th">หรือ</span><span class="lang-en">OR</span></div>

          <div class="sea-dep-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <rect x="3.4" y="4" width="17.2" height="6" rx="1.8"/><rect x="3.4" y="14" width="17.2" height="6" rx="1.8"/>
              <path d="M7 7h.02M7 17h.02M10.4 7h4M10.4 17h4"/>
            </svg>
            <div class="sea-dep-t">On-Premise</div>
            <p class="sea-dep-p">
              <span class="lang-th">เซิร์ฟเวอร์ภายในเครือข่ายองค์กร</span>
              <span class="lang-en">Local Server On Your Network</span>
            </p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= 6. ความสามารถของระบบ SMART ENERGY MANAGEMENT ================= -->
  <section id="energy-capabilities" class="py-14 sm:py-20 bg-white" style="scroll-margin-top:96px">
    <div class="se-shell">
      <div class="text-center max-w-3xl mx-auto mb-12">
        <p class="se-eyebrow mb-2">
          <span class="lang-th">ความสามารถของระบบ</span>
          <span class="lang-en">SMART ENERGY CAPABILITIES</span>
        </p>
        <!-- หัวข้อ -->
        <h2 class="se-h2 font-display text-ink">
          <span class="lang-th">ความสามารถของระบบ Smart Energy Management</span>
          <span class="lang-en">Smart Energy Management Capabilities</span>
        </h2>
      </div>

      <!-- 12 CARDS GRID -->
      <div class="se-tight grid auto-rows-fr grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-6 gap-4 sm:gap-6">

        <!-- 1. ติดตามการผลิตไฟ Solar -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-solar-panel"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">ระบบติดตามการผลิตไฟฟ้าจาก Solar Rooftop</span>
            <span class="lang-en">Solar Monitoring</span>
          </h3>
        </div>

        <!-- 2. รองรับ Inverter หลายแบรนด์ -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-plug"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">รองรับ Inverter หลายแบรนด์</span>
            <span class="lang-en">Multi-Brand Inverter</span>
          </h3>
        </div>

        <!-- 3. Dashboard พลังงานแบบ Real-time -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-chart-pie"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">Dashboard พลังงานแบบ Real-time</span>
            <span class="lang-en">Energy Dashboard</span>
          </h3>
        </div>

        <!-- 4. ระบบติดตามการใช้พลังงาน -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-gauge-high"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">ระบบติดตามการใช้พลังงาน</span>
            <span class="lang-en">Real-Time Monitoring</span>
          </h3>
        </div>

        <!-- 5. ระบบควบคุมเปิด-ปิดไฟอัตโนมัติ -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-regular fa-lightbulb"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">ระบบควบคุมการเปิด–ปิดไฟอัตโนมัติ</span>
            <span class="lang-en">Lighting Automation</span>
          </h3>
        </div>

        <!-- 6. ระบบกำหนดเวลาเปิด-ปิดอุปกรณ์ไฟฟ้า -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-clock"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">ระบบกำหนดเวลาเปิด–ปิดอุปกรณ์ไฟฟ้า</span>
            <span class="lang-en">Energy Scheduling</span>
          </h3>
        </div>

        <!-- 7. ระบบแจ้งเตือนเมื่ออุปกรณ์ผิดปกติ -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-bell"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">ระบบแจ้งเตือนเมื่ออุปกรณ์ผิดปกติ</span>
            <span class="lang-en">Alert Notification</span>
          </h3>
        </div>

        <!-- 8. วิเคราะห์ข้อมูลการใช้พลังงาน -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-chart-line"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">วิเคราะห์ข้อมูลการใช้พลังงาน</span>
            <span class="lang-en">Energy Analytics</span>
          </h3>
        </div>

        <!-- 9. บริหารจัดการหลายโรงงานหรือหลายสาขา -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-building-user"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">บริหารจัดการหลายโรงงานหรือหลายสาขา</span>
            <span class="lang-en">Multi-Site Management</span>
          </h3>
        </div>

        <!-- 10. กำหนดสิทธิ์ผู้ใช้งาน -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-user-shield"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">กำหนดสิทธิ์ผู้ใช้งาน (Role-Based Access Control)</span>
            <span class="lang-en">Role-Based Access Control</span>
          </h3>
        </div>

        <!-- 11. รองรับ Cloud และ On-Premise -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-cloud-sun"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">รองรับ Cloud และ On-Premise</span>
            <span class="lang-en">Cloud &amp; On-Premise</span>
          </h3>
        </div>

        <!-- 12. เชื่อมต่อระบบ ERP และ BMS ผ่าน API -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-brand flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-code"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">เชื่อมต่อระบบ ERP และ BMS ผ่าน API</span>
            <span class="lang-en">Open API Integration</span>
          </h3>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= 7. ผลลัพธ์ที่ธุรกิจได้รับ ================= -->
  <section id="energy-outcomes" class="py-12 sm:py-16 bg-[#f6f8f7] border-y border-slate-100">
    <div class="se-shell">
      <p class="se-eyebrow text-center mb-2">
        <span class="lang-th">ผลลัพธ์ที่ธุรกิจได้รับ</span>
        <span class="lang-en">BUSINESS OUTCOMES</span>
      </p>
      <!-- หัวข้อ -->
      <h2 class="se-h2 font-display text-ink text-center mb-10">
        <span class="lang-th">ผลลัพธ์ที่วัดผลได้จริง</span>
        <span class="lang-en">Business Outcomes That Matter</span>
      </h2>

      <div class="se-grid se-c6" style="gap:clamp(12px,1.4vw,20px)">
        
        <!-- 1. ลดค่าไฟฟ้า -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 flex items-start gap-4 shadow-sm hover:border-brand transition-all">
          <span class="w-11 h-11 rounded-xl bg-brand/10 flex items-center justify-center flex-none text-brand font-bold text-lg"><i class="fa-solid fa-arrow-trend-down"></i></span>
          <div>
            <div class="se-card-t se-titlebox text-ink mb-1">
              <span class="lang-th">ลดค่าไฟฟ้า</span>
              <span class="lang-en">Reduce Electricity Cost</span>
            </div>
            <p class="se-card-p text-muted"><span class="lang-th">ลดค่าใช้จ่ายด้านพลังงานขององค์กรอย่างยั่งยืน</span><span class="lang-en">Lower overall operational energy costs.</span></p>
          </div>
        </div>

        <!-- 2. เพิ่มประสิทธิภาพการผลิตไฟจาก Solar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 flex items-start gap-4 shadow-sm hover:border-brand transition-all">
          <span class="w-11 h-11 rounded-xl bg-brand/10 flex items-center justify-center flex-none text-brand font-bold text-lg"><i class="fa-solid fa-solar-panel"></i></span>
          <div>
            <div class="se-card-t se-titlebox text-ink mb-1">
              <span class="lang-th">เพิ่มประสิทธิภาพการผลิตไฟจาก Solar</span>
              <span class="lang-en">Increase Solar Performance</span>
            </div>
            <p class="se-card-p text-muted"><span class="lang-th">เพิ่มประสิทธิภาพการผลิตและการใช้งานไฟฟ้าโซลาร์เซลล์สูงสุด</span><span class="lang-en">Maximize solar generation efficiency.</span></p>
          </div>
        </div>

        <!-- 3. ลดการสูญเสียพลังงาน -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 flex items-start gap-4 shadow-sm hover:border-brand transition-all">
          <span class="w-11 h-11 rounded-xl bg-brand/10 flex items-center justify-center flex-none text-brand font-bold text-lg"><i class="fa-solid fa-leaf"></i></span>
          <div>
            <div class="se-card-t se-titlebox text-ink mb-1">
              <span class="lang-th">ลดการสูญเสียพลังงาน</span>
              <span class="lang-en">Reduce Energy Waste</span>
            </div>
            <p class="se-card-p text-muted"><span class="lang-th">ควบคุมการใช้พลังงานเพื่อป้องกันการสูญเสียโดยไม่จำเป็น</span><span class="lang-en">Eliminate unnecessary power consumption.</span></p>
          </div>
        </div>

        <!-- 4. ติดตามข้อมูลแบบ Real-time -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 flex items-start gap-4 shadow-sm hover:border-brand transition-all">
          <span class="w-11 h-11 rounded-xl bg-brand/10 flex items-center justify-center flex-none text-brand font-bold text-lg"><i class="fa-solid fa-eye"></i></span>
          <div>
            <div class="se-card-t se-titlebox text-ink mb-1">
              <span class="lang-th">ติดตามข้อมูลแบบ Real-time</span>
              <span class="lang-en">Real-Time Visibility</span>
            </div>
            <p class="se-card-p text-muted"><span class="lang-th">มองเห็นสถานะการใช้ไฟฟ้าและการผลิตไฟได้ทันทีตลอด 24 ชม.</span><span class="lang-en">Complete instant clarity into energy metrics.</span></p>
          </div>
        </div>

        <!-- 5. บริหารจัดการทุกไซต์จากศูนย์กลาง -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 flex items-start gap-4 shadow-sm hover:border-brand transition-all">
          <span class="w-11 h-11 rounded-xl bg-brand/10 flex items-center justify-center flex-none text-brand font-bold text-lg"><i class="fa-solid fa-network-wired"></i></span>
          <div>
            <div class="se-card-t se-titlebox text-ink mb-1">
              <span class="lang-th">บริหารจัดการทุกไซต์จากศูนย์กลาง</span>
              <span class="lang-en">Manage Unlimited Sites</span>
            </div>
            <p class="se-card-p text-muted"><span class="lang-th">ควบคุมทุกโรงงานและทุกสาขาผ่านแดชบอร์ดเดียว</span><span class="lang-en">Scale management across all locations.</span></p>
          </div>
        </div>

        <!-- 6. แก้ไขปัญหาได้รวดเร็วยิ่งขึ้น -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 flex items-start gap-4 shadow-sm hover:border-brand transition-all">
          <span class="w-11 h-11 rounded-xl bg-brand/10 flex items-center justify-center flex-none text-brand font-bold text-lg"><i class="fa-solid fa-wrench"></i></span>
          <div>
            <div class="se-card-t se-titlebox text-ink mb-1">
              <span class="lang-th">แก้ไขปัญหาได้รวดเร็วยิ่งขึ้น</span>
              <span class="lang-en">Faster Issue Resolution</span>
            </div>
            <p class="se-card-p text-muted"><span class="lang-th">ระบบแจ้งเตือนความผิดปกติเพื่อการบำรุงรักษาอย่างทันท่วงที</span><span class="lang-en">Detect and fix anomalies quickly.</span></p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= 8. โซลูชันนี้เหมาะกับใคร ================= -->
  <section id="energy-audience" class="py-12 sm:py-16 bg-white" style="scroll-margin-top:96px">
    <div class="se-shell">
      <p class="se-eyebrow text-center mb-2">
        <span class="lang-th">โซลูชันนี้เหมาะกับใคร</span>
        <span class="lang-en">WHO IS THIS FOR?</span>
      </p>
      <!-- หัวข้อ -->
      <h2 class="se-h2 font-display text-ink text-center mb-10">
        <span class="lang-th">ออกแบบมาเพื่อธุรกิจที่ต้องการบริหารจัดการพลังงานอย่างมีประสิทธิภาพ</span>
        <span class="lang-en">Built for Businesses That Want Energy Under Control</span>
      </h2>

      <div class="se-grid se-c5" style="gap:clamp(14px,1.5vw,22px)">

        <!-- 1. บริษัทรับติดตั้ง Solar Rooftop -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden hover:border-brand hover:shadow-lg transition-all flex flex-col">
          <div class="w-full bg-slate-100 overflow-hidden" style="aspect-ratio:16/11">
            <img loading="lazy" decoding="async" class="w-full h-full object-cover" src="<?php echo get_template_directory_uri(); ?>/image/solutions/solar_asset_mgmt.png" alt="บริษัทรับติดตั้ง Solar Rooftop บริหารระบบ Solar ทุกโครงการจากแพลตฟอร์มเดียว">
          </div>
          <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
              <div class="se-card-t se-titlebox text-ink mb-2">
                <span class="lang-th">บริษัทรับติดตั้ง Solar Rooftop</span>
                <span class="lang-en">Solar EPC</span>
              </div>
              <p class="se-card-p text-muted">
                <span class="lang-th">บริหารจัดการระบบ Solar ของลูกค้าทุกโครงการจากแพลตฟอร์มเดียว รองรับ Inverter หลายแบรนด์ พร้อมกำหนดสิทธิ์ให้เจ้าของโครงการเข้าถึงข้อมูลของตนเอง</span>
                <span class="lang-en">Provide one monitoring platform for every customer. Supports multi-brand inverters and customer permission management.</span>
              </p>
            </div>
          </div>
        </div>

        <!-- 2. โรงงานอุตสาหกรรม -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden hover:border-brand hover:shadow-lg transition-all flex flex-col">
          <div class="w-full bg-slate-100 overflow-hidden" style="aspect-ratio:16/11">
            <img loading="lazy" decoding="async" class="w-full h-full object-cover" src="<?php echo get_template_directory_uri(); ?>/image/solutions/factory-hero-automotive.jpg" alt="โรงงานอุตสาหกรรม ติดตามการใช้ไฟฟ้าและควบคุมอุปกรณ์แบบ Real-time">
          </div>
          <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
              <div class="se-card-t se-titlebox text-ink mb-2">
                <span class="lang-th">โรงงานอุตสาหกรรม</span>
                <span class="lang-en">Manufacturing</span>
              </div>
              <p class="se-card-p text-muted">
                <span class="lang-th">ติดตามการใช้ไฟฟ้า การผลิตไฟจาก Solar และควบคุมอุปกรณ์ไฟฟ้าแบบ Real-time เพื่อช่วยลดต้นทุนด้านพลังงาน</span>
                <span class="lang-en">Monitor factory energy and solar generation in real time to reduce operational electricity expenses.</span>
              </p>
            </div>
          </div>
        </div>

        <!-- 3. อาคารสำนักงาน -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden hover:border-brand hover:shadow-lg transition-all flex flex-col">
          <div class="w-full bg-slate-100 overflow-hidden" style="aspect-ratio:16/11">
            <img loading="lazy" decoding="async" class="w-full h-full object-cover" src="<?php echo get_template_directory_uri(); ?>/image/cases/nida.jpg" alt="อาคารสำนักงาน ติดตามการใช้พลังงานรายอาคารจากศูนย์กลาง">
          </div>
          <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
              <div class="se-card-t se-titlebox text-ink mb-2">
                <span class="lang-th">อาคารสำนักงาน</span>
                <span class="lang-en">Commercial Buildings</span>
              </div>
              <p class="se-card-p text-muted">
                <span class="lang-th">ควบคุมระบบแสงสว่างและอุปกรณ์ไฟฟ้า กำหนดเวลาเปิด–ปิดอัตโนมัติ และติดตามการใช้พลังงานของทั้งอาคาร</span>
                <span class="lang-en">Optimize electricity consumption automatically with smart lighting and automated schedule controls.</span>
              </p>
            </div>
          </div>
        </div>

        <!-- 4. ธุรกิจค้าปลีกและร้านแฟรนไชส์ -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden hover:border-brand hover:shadow-lg transition-all flex flex-col">
          <div class="w-full bg-slate-100 overflow-hidden" style="aspect-ratio:16/11">
            <img loading="lazy" decoding="async" class="w-full h-full object-cover" src="<?php echo get_template_directory_uri(); ?>/image/solutions/energy-remote-monitoring.png" alt="ธุรกิจค้าปลีกและร้านแฟรนไชส์ สำนักงานใหญ่ติดตามทุกสาขาจากศูนย์กลาง">
          </div>
          <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
              <div class="se-card-t se-titlebox text-ink mb-2">
                <span class="lang-th">ธุรกิจค้าปลีกและร้านแฟรนไชส์</span>
                <span class="lang-en">Retail &amp; Franchise</span>
              </div>
              <p class="se-card-p text-muted">
                <span class="lang-th">สำนักงานใหญ่สามารถติดตามข้อมูลการใช้พลังงานและการผลิตไฟฟ้าของทุกสาขาได้จากศูนย์กลาง พร้อมกำหนดสิทธิ์ให้ผู้จัดการแต่ละสาขาเข้าถึงเฉพาะข้อมูลของตนเอง</span>
                <span class="lang-en">Monitor all branches from headquarters while allowing branch managers to access only their own locations.</span>
              </p>
            </div>
          </div>
        </div>

        <!-- 5. เจ้าของโครงการอสังหาริมทรัพย์ -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden hover:border-brand hover:shadow-lg transition-all flex flex-col">
          <div class="w-full bg-slate-100 overflow-hidden" style="aspect-ratio:16/11">
            <img loading="lazy" decoding="async" class="w-full h-full object-cover" src="<?php echo get_template_directory_uri(); ?>/image/cases/valuation.jpg" alt="เจ้าของโครงการอสังหาริมทรัพย์ บริหารพลังงานหลายอาคารจากแพลตฟอร์มเดียว">
          </div>
          <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
              <div class="se-card-t se-titlebox text-ink mb-2">
                <span class="lang-th">เจ้าของโครงการอสังหาริมทรัพย์</span>
                <span class="lang-en">Property Developers</span>
              </div>
              <p class="se-card-p text-muted">
                <span class="lang-th">บริหารจัดการพลังงานของหลายอาคาร หลายโครงการ และติดตามข้อมูลได้จากแพลตฟอร์มเดียว</span>
                <span class="lang-en">Centralized energy management for every building and property development project.</span>
              </p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= 9. เริ่มต้นกับเรา (ปิดท้าย) ================= -->
  <!-- The page's only call to action used to be the hero button, ~6,000px above the
       footer. This closes the page where a visitor who has read everything actually is.
       Both strings are reused from the hero, so no new copy is introduced. -->
  <section id="energy-cta" class="py-14 sm:py-20 bg-white" style="scroll-margin-top:96px">
    <div class="se-shell">
      <div class="relative overflow-hidden rounded-[28px] px-6 py-10 sm:px-10 sm:py-14 lg:px-16 text-white"
           style="background:linear-gradient(135deg,#0d4636 0%,#093427 55%,#06261c 100%)">
        <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none z-0"></div>

        <div class="relative z-10 grid gap-8 lg:grid-cols-[1.35fr_auto] lg:items-center">
          <div>
            <p class="se-eyebrow mb-3" style="color:#4ade80">
              <span class="lang-th">เริ่มต้นกับเรา</span>
              <span class="lang-en">GET STARTED</span>
            </p>
            <h2 class="se-h2 font-display text-white">
              <span class="lang-th">บริหารจัดการพลังงานอัจฉริยะ<br><span class="text-brand-bright">เพื่อธุรกิจที่ใช้พลังงานอย่างมีประสิทธิภาพ</span></span>
              <span class="lang-en">Power Your Business with<br><span class="text-brand-bright">Smart Energy Management</span></span>
            </h2>
            <p class="se-lede text-slate-200 mt-5 max-w-2xl">
              <span class="lang-th">แพลตฟอร์มเดียวสำหรับบริหารจัดการพลังงานและระบบ Solar ครบวงจร</span>
              <span class="lang-en">One Platform for Complete Energy Visibility</span>
            </p>
          </div>

          <div class="flex flex-col sm:flex-row lg:flex-col gap-3 lg:gap-4 lg:min-w-[240px]">
            <a href="<?php echo home_url('/'); ?>#contact"
               class="se-cta-label inline-flex items-center justify-center gap-2.5 bg-brand-bright text-white px-8 py-4 rounded-xl font-extrabold uppercase tracking-wider hover:bg-emerald-600 transition-all shadow-lg shadow-brand-bright/30 hover:-translate-y-0.5">
              <i class="fa-solid fa-comments"></i>
              <span class="lang-th">ปรึกษาผู้เชี่ยวชาญ</span>
              <span class="lang-en">Talk to Our Experts</span>
            </a>
            <a href="#energy-platform"
               class="se-cta-label inline-flex items-center justify-center gap-2.5 border border-white/30 bg-white/5 text-white px-8 py-4 rounded-xl font-extrabold uppercase tracking-wider hover:bg-white/10 hover:border-white/50 transition-all">
              <i class="fa-solid fa-diagram-project"></i>
              <span class="lang-th">ดูสถาปัตยกรรมระบบ</span>
              <span class="lang-en">See the Architecture</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER CONTAINER -->
  <div id="footer-container" class="bg-ink w-full block"></div>

  <!-- Scripts -->
  <script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/scripts.js') : './components/scripts.js'; ?>"></script>

<?php include __DIR__ . '/components/cookie-consent.php'; ?>
  <?php wp_footer(); ?>
</body>

</html>
