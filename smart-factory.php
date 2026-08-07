<?php
/* Template Name: Smart Factory Solution */
/*
 * Ported from the standalone solutions/smart-factory.html in the syntec-h
 * folder. The body markup is that page's, unchanged; what changed is the shell:
 *
 *  - Asset paths. The standalone page lived in /solutions/ and reached its
 *    images with ../image/... A document-relative path like that resolves
 *    against whatever URL the page is served at, and this one is served at
 *    /smart-factory/ - see the synergy_dev_base() note in about.php for what
 *    that did to the rest of the site. Everything now goes through
 *    get_template_directory_uri(), which is also what WordPress needs.
 *  - Head. Replaced with this theme's head so the page gets the same fonts,
 *    stylesheet, favicon and wpThemeUri that components/scripts.js relies on to
 *    build the navbar and footer.
 *  - Links. ../contact.html and /#solutions were paths on the old static site.
 */
if (isset($_SERVER['REQUEST_URI']) && preg_match('/\.php\/+$/i', $_SERVER['REQUEST_URI'])) {
    $clean_uri = preg_replace('/\.php\/+$/i', '.php', $_SERVER['REQUEST_URI']);
    header("Location: " . $clean_uri, true, 301);
    exit();
}
/* Root-absolute, not '.': document-relative asset URLs break on any URL ending
   in a slash. See the long note on the same helper in about.php. */
if (!function_exists('synergy_dev_base')) {
    function synergy_dev_base() {
        $root = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : '';
        $root = $root ? str_replace('\\', '/', $root) : '';
        $here = str_replace('\\', '/', __DIR__);
        if ($root !== '' && strpos($here, $root) === 0) {
            return rtrim(substr($here, strlen($root)), '/');
        }
        return '';
    }
}
if (!function_exists('get_template_directory_uri')) {
    function get_template_directory_uri() { return synergy_dev_base(); }
}
if (!function_exists('get_stylesheet_directory_uri')) {
    function get_stylesheet_directory_uri() { return synergy_dev_base(); }
}
if (!function_exists('get_template_directory')) {
    function get_template_directory() { return __DIR__; }
}
if (!function_exists('get_stylesheet_directory')) {
    function get_stylesheet_directory() { return __DIR__; }
}
if (!function_exists('get_stylesheet_uri')) {
    function get_stylesheet_uri() { return synergy_dev_base() . '/style.css'; }
}
if (!function_exists('home_url')) {
    function home_url($path = '/') { return synergy_dev_base() . '/' . ltrim($path, '/'); }
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
  <title>Smart Factory · ระบบโรงงานอัจฉริยะ OEE, OT/IT Integration &amp; Predictive Maintenance | Synergy Group</title>
  <meta name="description" content="ระบบ Smart Factory วิเคราะห์ OEE เครื่องจักร เชื่อมต่อ OT/IT ป้องกันความเสียหายด้วย Predictive Maintenance และ Warehouse Automation สำหรับโรงงานอุตสาหกรรมในประเทศไทย">
  <meta name="keywords" content="Smart Factory Thailand, OEE วิเคราะห์ประสิทธิภาพเครื่องจักร, OT IT Integration, Predictive Maintenance, AGV Warehouse, SynExta, โรงงานอัจฉริยะ">

  <link rel="canonical" href="<?php echo home_url('/smart-factory/'); ?>">
  <meta name="robots" content="index,follow">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Synergy Technology">
  <meta property="og:title" content="Smart Factory · ระบบโรงงานอัจฉริยะ OEE &amp; OT/IT Integration">
  <meta property="og:description" content="วิเคราะห์ OEE เครื่องจักรและ Warehouse Automation ด้วย IIoT สำหรับโรงงานอุตสาหกรรมไทย">
  <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/image/smart-factory-architecture.png">
  <meta property="og:url" content="<?php echo home_url('/smart-factory/'); ?>">
  <meta name="twitter:card" content="summary_large_image">

  <!-- Structured data carried over from the source page. The absolute
       synergygroup.co.th URLs are replaced with this site's own, but the
       organisation name, address and phone are left exactly as the source had
       them - see the naming note in AGENTS.md rule 1. Verify before launch. -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Service",
    "name": "Smart Factory OEE & OT/IT Integration",
    "alternateName": "ระบบโรงงานอัจฉริยะและการเชื่อมต่อ OT/IT",
    "description": "วิเคราะห์ประสิทธิภาพโดยรวมเครื่องจักร (OEE) เชื่อมต่อ Sensor วัดอุณหภูมิ แรงดัน และ Flow Rate พร้อมระบบควบคุม AGV และ AMR ในคลังสินค้า",
    "url": "<?php echo home_url('/smart-factory/'); ?>",
    "provider": {
      "@type": "Organization",
      "name": "Synergy Group Holding Co., Ltd.",
      "url": "<?php echo home_url('/'); ?>",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "96 หมู่ 1 ตำบลคลองหนึ่ง อำเภอคลองหลวง",
        "addressLocality": "ปทุมธานี",
        "addressRegion": "TH-13",
        "postalCode": "12120",
        "addressCountry": "TH"
      },
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+66-2-516-1594",
        "contactType": "sales",
        "areaServed": ["TH","SG","MY","VN","ID"],
        "availableLanguage": ["Thai","English"]
      }
    },
    "serviceType": "Industrial IoT & Factory Automation",
    "category": "Smart Manufacturing Technology"
  }
  </script>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/image/s-logo.png">
  <link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/image/s-logo.png">
  <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/image/s-logo.png">

  <!-- Tailwind CSS CDN. Palette matches the other pages in this theme; the
       source page also declared brand.deep/soft and gold.soft, which its markup
       uses, so those are kept as nested keys here. -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            ink: "#0B1F16",
            brand: { DEFAULT: "#1F6B43", deep: "#0E3B2E", soft: "#E9F2EC" },
            "brand-bright": "#23862D",
            "brand-deep": "#165031",
            "brand-light": "#EAF3ED",
            gold: { DEFAULT: "#C99700", bright: "#F2C72E", soft: "#FBEFC9" },
            "gold-bright": "#F2C72E",
            surface: "#F6FAF7",
            body: "#3A4A41",
            muted: "#6E8076"
          },
          fontFamily: {
            display: ['"Space Grotesk"', 'sans-serif'],
            body: ['Inter', 'Sarabun', 'sans-serif']
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
  <!-- Interactive platform section. Scoped to #energy-platform; see the
       header of the file for why every size in it carries !important. -->
  <link rel="stylesheet" href="<?php echo function_exists('synergy_asset') ? synergy_asset('components/energy-platform.css') : './components/energy-platform.css'; ?>">

  <style>
    /* Wide shell for the platform section - it holds a 3D stage, a device
       row and a screenshot panel, so the 1280px page container squeezes it. */
    .sf-shell { width: 100%; max-width: 1760px; margin-inline: auto; padding-inline: clamp(16px, 3.2vw, 64px); }
    /* The SukhumvitSet @font-face set is injected by components/scripts.js for
       every page in this theme, so the source page's own copy is dropped here
       rather than duplicated. */
    body {
      font-family: 'SukhumvitSet', 'Inter', 'Sarabun', sans-serif;
      scroll-behavior: smooth;
      word-break: break-word;
      overflow-wrap: break-word;
    }
    h1, h2, h3, h4, h5, h6, .font-display {
      font-family: 'SukhumvitSet', 'Space Grotesk', 'Sarabun', sans-serif;
      word-break: keep-all;
      overflow-wrap: break-word;
    }

    /* Thai runs long without spaces, so a browser that is allowed to break
       inside a "word" will split a syllable and strand its vowel or tone mark
       (rule 3 in AGENTS.md). Prose on this page opts out; only the body-level
       rule above stays, to catch stray long Latin strings. */
    p, li, .lang-th {
      overflow-wrap: normal;
      word-break: keep-all;
      hyphens: none;
    }

    /* The source page used font-300 / font-700 utilities. Tailwind's CDN build
       does not emit those class names, so they were silently doing nothing and
       every "bold" label rendered at the inherited weight. Defined here rather
       than rewritten across ~1000 lines of markup. */
    .font-300 { font-weight: 300; }
    .font-500 { font-weight: 500; }
    .font-700 { font-weight: 700; }
    .font-800 { font-weight: 800; }

    /* Tokens for the closing CTA, copied step for step from the equivalent
       block on smart-energy.php so the two pages end the same way. They are
       declared here rather than reusing that page's .se-* classes because those
       are local to it - and clamped rather than written as Tailwind text-*
       steps, which components/style.css would pin to their largest value at
       every breakpoint (AGENTS.md rule 2). */
    /* Architecture headline. It has to hold one line, and the Tailwind chain it
       used to carry (text-2xl sm:text-3xl lg:text-4xl) could not: components/
       style.css pins that scale to its largest step at every breakpoint (rule
       2), so at a 700px viewport the text still rendered at 46.75px and ran 838px
       wide inside a 649px box - clipped, not wrapped, because the section is
       overflow-hidden. A clamp actually scales, so the line fits from the sm
       breakpoint up. */
    }

    .sf-arch-h2 { font-size: clamp(22px, 3.4vw, 44px) !important; line-height: 1.2 !important; font-weight: 900; }

    .sf-cta-eyebrow { font-size: 0.875rem !important; font-weight: 800; letter-spacing: 0.18em; text-transform: uppercase; }
    .sf-cta-h2      { font-size: clamp(22px, 2.78vw, 44px) !important; line-height: 1.2 !important; font-weight: 800; }
    .sf-cta-lede    { font-size: 1.075rem !important; line-height: 1.7 !important; overflow-wrap: normal; word-break: keep-all; }
    .sf-cta-label   { font-size: 0.975rem !important; letter-spacing: .06em; }
    /* Tracked caps are a Latin device; on Thai they prise tone marks away from
       their consonants (rule 3). */
    html[lang="th"] .sf-cta-eyebrow { letter-spacing: 0 !important; text-transform: none !important; }

    /* Tracked caps are a Latin typesetting device. On Thai the extra tracking
       drags tone marks away from their consonants and uppercase does nothing at
       all, so the eyebrow labels drop both when the page is in Thai
       (AGENTS.md rule 3). This became visible once the kicker stopped being the
       same English string in both languages. */
    html[lang="th"] .uppercase.tracking-\[0\.2em\],
    html[lang="th"] .uppercase.tracking-\[0\.25em\],
    html[lang="th"] .uppercase.tracking-wider,
    html[lang="th"] .uppercase.tracking-widest {
      letter-spacing: 0 !important;
      text-transform: none !important;
    }

    /* ==========================================================================
       PLATFORM SCREENSHOTS — fit one screen

       The five tab screenshots are 1536x1024 (3:2). energy-platform.css lets
       .screen-frame run the full content width, which on a 1280x720 laptop
       rendered the frame at 1183x824 - taller than the viewport. You could
       never see a whole screen at once, and the tab bar scrolled away the
       moment you looked at the image, so switching tabs meant scrolling back
       up each time.

       The cap is expressed as a width because the image drives its own height
       from the aspect ratio: work back from the height that should fit, and
       multiply by 3/2. 76vh leaves room for the tab bar and the section
       heading above; the 44px is the chrome strip plus the zoom hint below.
       min() keeps it from ever exceeding the column on a narrow window, and
       the whole thing collapses to plain full width on phones, where vertical
       space is the scarce thing anyway and the image is small regardless.

       Scoped to this page: smart-energy.php shares this stylesheet but its
       screenshots are a mix of aspect ratios, so a 3:2 assumption would crop
       the reasoning out from under them.

       The 680px floor stops a short window (a laptop with a docked devtools
       panel, say) from shrinking a dense dashboard into a thumbnail; past that
       point letting it overflow slightly beats making it unreadable. min() is
       applied last so the column width always wins.
       ========================================================================== */
    @media (min-width: 768px) {
      #energy-platform .screen-frame {
        max-width: min(100%, max(680px, calc((76vh - 44px) * 1.5)));
        margin-inline: auto;
      }
    }

    /* .center-engine-column is a flex column with align-items:center, which was
       written for the fixed-width 3D stage that used to live in it. A block
       child inherits that centring as a shrink-to-fit width, and the tab panels
       collapsed to 327px of a 1049px column - the screenshot with them. They
       need the full column; the centring still applies to everything else. */
    #energy-platform .center-engine-column > .content-container { width: 100%; }

    /* ==========================================================================
       MOBILE — the platform section on a phone

       Three fixes, all measured on a 375x812 viewport.
       ========================================================================== */
    @media (max-width: 767px) {

      /* 1. TAB ROW: one line, never wrapped.

         energy-platform.css wraps the tabs at a quarter of the row each. That
         was sized for the seven-tab bar on smart-energy.php, where a quarter
         gives a tidy 4 + 3. Five tabs at a quarter give 4 + 1, with "รายงาน"
         stranded alone on a second row, and at 79px "ศูนย์แจ้งเตือน" broke onto two
         lines while its neighbours stayed on one.

         Fixed width per tab is the wrong tool here: the five labels are not
         the same length, so any single fraction either wastes space on the
         short ones or breaks the long one. Natural width plus nowrap lets each
         tab take exactly what its label needs, and measured on a 375px screen
         the five come to about 320px against 331px of usable row - they fit on
         one line with room to spare.

         overflow-x stays on as the fallback, and the mask fades and chevrons
         that the shared stylesheet switches off for the wrapped layout come
         back with it. If a longer translation or a larger system font ever
         pushes the row past the edge, it scrolls - it does not wrap. */
      #energy-platform .nav-tabs {
        flex-wrap: nowrap;
        justify-content: flex-start;
        overflow-x: auto;
        scroll-snap-type: x proximity;
        gap: 2px;
      }
      #energy-platform .nav-tab {
        flex: 0 0 auto;
        min-width: 0;
        white-space: nowrap;
        padding: 9px 4px;
        min-height: 62px;
        /* Tuned against the longest label in each language rather than picked
           round: English "Alarm Center" and "Maintenance" are wider per
           character than the Thai, so Latin needs the smaller of the two to
           keep the same five-across fit when the switcher is on EN. */
        font-size: 11px !important;
      }
      html[lang="th"] #energy-platform .nav-tab { font-size: 13px !important; }

      /* Re-enable the scroll affordance the wrapped layout had no use for. */
      #energy-platform .nav-tabs.can-scroll-right {
        -webkit-mask-image: linear-gradient(to right, #000 calc(100% - 34px), transparent 100%);
                mask-image: linear-gradient(to right, #000 calc(100% - 34px), transparent 100%);
      }
      #energy-platform .nav-tabs.can-scroll-left {
        -webkit-mask-image: linear-gradient(to right, transparent 0, #000 34px);
                mask-image: linear-gradient(to right, transparent 0, #000 34px);
      }
      #energy-platform .nav-tabs.can-scroll-left.can-scroll-right {
        -webkit-mask-image: linear-gradient(to right, transparent 0, #000 34px, #000 calc(100% - 34px), transparent 100%);
                mask-image: linear-gradient(to right, transparent 0, #000 34px, #000 calc(100% - 34px), transparent 100%);
      }
      #energy-platform .nav-tabs-wrap .nav-scroll-cue { display: flex !important; }
      /* Nothing to scroll: the JS only adds these classes when the row really
         does overflow, so with all five on screen no chevron ever appears. */
      #energy-platform .nav-tabs-wrap:not(.can-scroll-left) .nav-scroll-cue--left,
      #energy-platform .nav-tabs-wrap:not(.can-scroll-right) .nav-scroll-cue--right {
        display: none !important;
      }

      /* 2. DEPLOYMENT: side by side.

         The Cloud / OR / On-Premise stack is a column here, which costs 378px
         of scroll for two 136px cards and a divider. The stylesheet already
         turns it into a row at the tablet breakpoint and rotates the dashes
         with it; that treatment is even more worth having on a phone, where
         vertical space is the scarce axis. Two 138px cards and the OR badge
         fit a 343px row with room to spare. */
      #energy-platform .deployment-cards-stack {
        flex-direction: row;
        justify-content: center;
        gap: 4px;
      }
      #energy-platform .deploy-vertical-dash {
        width: 14px;
        height: 1.5px;
        border-left: none;
        border-top: 2px dashed rgba(0, 168, 107, 0.4);
      }
      #energy-platform .right-deployment-column { height: auto; padding-top: 4px; }
      /* Two 138px cards, two dashes and the 46px OR badge come to 374px, which
         overflowed a 360px Android screen and made the whole page scroll
         sideways. Trimming the cards to 118px brings the row to 330px, inside
         the 348px of usable width the narrowest common phone leaves. */
      #energy-platform .deployment-card-square { width: 118px; height: 118px; }
      #energy-platform .divider-or-circle { width: 40px; height: 40px; }
    }

    /* 3. LIGHTBOX: make "tap to enlarge" actually enlarge.

       The lightbox centres the screenshot with max-width/max-height 100%, so a
       3:2 dashboard on a portrait phone fits to WIDTH and lands at 351x234 -
       eight pixels wider than the 343px thumbnail it was opened from. The
       control promised a full-size view and delivered the same picture.

       Sizing by height instead lets the image overflow sideways inside a
       scroll container, so it opens about three times larger and pans under
       the finger. Landscape is left alone: fit-to-width is already the right
       answer when the viewport matches the image's orientation.

       The bound is 1023px, not the 767px used above, because a portrait tablet
       has the same defect for the same reason - measured at 768x1024, tapping
       a 702px thumbnail opened it at 707px. The tab and deployment fixes stay
       at 767px, where they are actually needed. */
    @media (max-width: 1023px) and (orientation: portrait) {
      #energy-platform .shot-lightbox.show {
        display: block;
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        overscroll-behavior: contain;
        padding: 64px 0 28px;
      }
      #energy-platform .shot-lightbox img {
        max-width: none;
        max-height: none;
        width: auto;
        height: calc(100dvh - 92px);
        border-radius: 0;
      }
      /* The close button was absolute inside what is now a scroll container,
         so panning right would carry it off screen. */
      #energy-platform .shot-lightbox-close { position: fixed; }
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


  <!-- HERO -->
  <section id="factory-hero" class="relative bg-white text-slate-900 py-24 sm:py-36 overflow-hidden flex items-center">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: linear-gradient(to right, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.88) 55%, rgba(255, 255, 255, 0.70) 70%, rgba(255, 255, 255, 0.25) 100%), url('<?php echo get_template_directory_uri(); ?>/image/solutions/factory-hero-automotive.jpg');"></div>
    <div class="absolute inset-0 pointer-events-none">
      <div class="absolute top-0 right-10 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
      <div class="absolute bottom-0 left-0 w-80 h-80 bg-brand/10 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 w-full">
      <div class="mb-4">
        <a href="<?php echo home_url('/'); ?>#solutions" class="text-slate-500 hover:text-slate-900 text-xs font-700 tracking-wider uppercase transition">
          <i class="fa-solid fa-arrow-left mr-2"></i><span class="lang-th">โซลูชัน</span><span class="lang-en">Solutions</span>
        </a>
      </div>
      <div class="flex items-center gap-3 mb-6">
        <span class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200/80 flex items-center justify-center shadow-2xs">
          <i class="fa-solid fa-gears text-emerald-600"></i>
        </span>
        <span class="text-emerald-700 text-xs font-700 tracking-[0.25em] uppercase"><span class="lang-th">SMART FACTORY SOLUTION</span><span class="lang-en">SMART FACTORY SOLUTION</span></span>
      </div>
      <h1 data-editable="factory-hero-h1-1" <?php echo synergy_style('factory-hero-h1-1', 'smart-factory'); ?> class="font-display font-bold text-4xl sm:text-5xl lg:text-6xl text-slate-900 tracking-tight leading-tight mb-6"><?php echo synergy_content('factory-hero-h1-1', '<span class="lang-th">ยกระดับโรงงานของคุณสู่<br><span class="text-emerald-600">Smart Factory</span></span>
        <span class="lang-en">Powering Your <br><span class="text-emerald-600">Smart Factory</span></span>', 'smart-factory'); ?></h1>
      <p data-editable="factory-hero-p-1" <?php echo synergy_style('factory-hero-p-1', 'smart-factory'); ?> class="text-lg sm:text-xl text-slate-600 font-300 leading-relaxed max-w-2xl mb-10"><?php echo synergy_content('factory-hero-p-1', '<span class="lang-th">เชื่อมต่อข้อมูลจากเครื่องจักรและระบบการผลิตไว้ในแพลตฟอร์มเดียว เพื่อให้ติดตาม วิเคราะห์ และบริหารจัดการโรงงานได้อย่างมีประสิทธิภาพ</span>
        <span class="lang-en">Unify machine and production data in a single platform for real-time visibility, analytics, and smarter manufacturing decisions.</span>', 'smart-factory'); ?></p>
      <div class="flex flex-wrap gap-4">
        <a href="<?php echo home_url('/'); ?>#contact" class="bg-brand hover:bg-brand-deep text-white font-700 text-xs tracking-wider uppercase px-8 py-4 rounded-xl transition shadow-lg shadow-brand/20">
          <i class="fa-solid fa-paper-plane mr-2"></i><span class="lang-th">ปรึกษาผู้เชี่ยวชาญ</span><span class="lang-en">Talk to Our Engineers</span>
        </a>
      </div>
    </div>
  </section>

  <!-- TRUSTED BY LEADING MANUFACTURERS STRIP (Full Color Logos) -->
  <section id="factory-leaders" class="py-12 sm:py-14 bg-slate-50 border-y border-slate-200/80 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
      
      <!-- Section Header -->
      <div class="text-center mb-9 sm:mb-11">
        <h2 class="font-display font-black text-base sm:text-lg md:text-xl text-emerald-800 tracking-[0.25em] uppercase leading-tight">
          <span class="lang-th">องค์กรชั้นนำที่ไว้วางใจเรา</span><span class="lang-en">Trusted by Leading Manufacturers</span>
        </h2>
        <div class="w-16 h-1 bg-gradient-to-r from-emerald-500 via-brand to-gold-bright rounded-full mx-auto mt-3.5 opacity-90"></div>
      </div>

      <?php
      /* The eight logos used to be eight hard-coded blocks, so the live editor
         could swap one image but never add a ninth or drop one - the count was
         a property of the PHP, not of the content. They are a list now, and the
         array below is only the starting point: once anyone edits the wall,
         data/content_smart-factory.json holds the real one. Deleting every logo
         is a valid saved state and does NOT fall back to this array. */
      $factory_logos = synergy_list('factory-logos', array(
          array('src' => 'assets/logos/trusted_manufacturers/tfp-industrial.png', 'alt' => 'TFP Automotive Accessories'),
          array('src' => 'assets/logos/trusted_manufacturers/sp-metal-part.png',  'alt' => 'SP Metal Part'),
          array('src' => 'assets/logos/trusted_manufacturers/michelin.png',       'alt' => 'Michelin'),
      ), 'smart-factory');
      ?>

      <!-- Manufacturers Logo Wall.
           Three logos, so a centred row rather than the eight-across grid this
           used to be - eight columns holding three items leaves them huddled at
           the left. The white card behind each one is doing real work: these
           three arrived with different backgrounds baked in (Michelin on
           transparent, the other two on white), and without it the two white
           ones read as pale rectangles against the slate section. -->
      <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6 max-w-4xl mx-auto"
           data-editable-list="factory-logos"
           data-list-label="โลโก้องค์กรที่ไว้วางใจเรา">
        <?php foreach ($factory_logos as $logo): ?>
        <div class="h-20 sm:h-24 w-[45%] sm:w-56 bg-white rounded-2xl border border-slate-200/70 shadow-[0_2px_10px_rgba(0,0,0,0.04)] flex items-center justify-center px-5 sm:px-7 hover:-translate-y-1 hover:shadow-md transition-all duration-300" data-list-item>
          <img loading="lazy" decoding="async" src="<?php echo esc_url(synergy_media_url($logo['src'])); ?>" alt="<?php echo esc_attr($logo['alt']); ?>" class="max-h-11 sm:max-h-14 w-auto max-w-full object-contain">
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- CHALLENGES WE HELP YOU SOLVE -->
  <section id="factory-challenges" class="py-16 sm:py-20 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-6">
      <div class="mb-10 sm:mb-12 text-center">
        <span class="text-emerald-700 text-xs font-800 tracking-[0.2em] uppercase font-display block">
          <span class="lang-th">ความท้าทายทางธุรกิจ</span><span class="lang-en">BUSINESS CHALLENGES</span>
        </span>
        <h2 class="font-display font-800 text-2xl sm:text-3xl lg:text-4xl text-ink mt-3 tracking-tight">
          <span class="lang-th">ปัญหาที่เราช่วยคุณแก้ไข</span><span class="lang-en">Challenges We Help You Solve</span>
        </h2>
      </div>

      <!-- 6 Challenges Columns -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-8 lg:gap-0 divide-y sm:divide-y-0 lg:divide-x divide-slate-200/80">
        
        <!-- 01 Low Productivity -->
        <div class="lg:px-5 first:pl-0 last:pr-0 pt-6 sm:pt-0 flex flex-col items-center text-center">
          <div class="w-14 h-14 flex items-center justify-center mb-4">
            <img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/solutions/challenges/icon-1-chart.svg" alt="Low productivity" class="w-11 h-11 object-contain">
          </div>
          <h3 data-editable="factory-challenges-h3-1" <?php echo synergy_style('factory-challenges-h3-1', 'smart-factory'); ?> class="font-display font-800 text-base text-ink mb-2"><?php echo synergy_content('factory-challenges-h3-1', '<span class="lang-th">การผลิตไม่มีประสิทธิภาพ</span><span class="lang-en">Low Production Efficiency</span>', 'smart-factory'); ?></h3>
          <p data-editable="factory-challenges-p-1" <?php echo synergy_style('factory-challenges-p-1', 'smart-factory'); ?> class="text-xs text-slate-500 font-300 leading-relaxed"><?php echo synergy_content('factory-challenges-p-1', '<span class="lang-th">มองไม่เห็นข้อมูลการผลิต ทำให้ปรับปรุงประสิทธิภาพได้ยาก</span><span class="lang-en">Limited production visibility reduces operational efficiency.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 02 Frequent Downtime -->
        <div class="lg:px-5 pt-6 sm:pt-0 flex flex-col items-center text-center">
          <div class="w-14 h-14 flex items-center justify-center mb-4">
            <img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/solutions/challenges/icon-2-wrench.svg" alt="Frequent downtime" class="w-11 h-11 object-contain">
          </div>
          <h3 data-editable="factory-challenges-h3-2" <?php echo synergy_style('factory-challenges-h3-2', 'smart-factory'); ?> class="font-display font-800 text-base text-ink mb-2"><?php echo synergy_content('factory-challenges-h3-2', '<span class="lang-th">เครื่องจักรหยุดทำงานโดยไม่คาดคิด</span><span class="lang-en">Unexpected Machine Downtime</span>', 'smart-factory'); ?></h3>
          <p data-editable="factory-challenges-p-2" <?php echo synergy_style('factory-challenges-p-2', 'smart-factory'); ?> class="text-xs text-slate-500 font-300 leading-relaxed"><?php echo synergy_content('factory-challenges-p-2', '<span class="lang-th">เครื่องจักรหยุดกะทันหัน ส่งผลต่อการผลิตและต้นทุน</span><span class="lang-en">Unplanned downtime disrupts production and increases costs.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 03 Data Silos -->
        <div class="lg:px-5 pt-6 sm:pt-0 flex flex-col items-center text-center">
          <div class="w-14 h-14 flex items-center justify-center mb-4">
            <img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/solutions/challenges/icon-3-database.svg" alt="Data silos" class="w-11 h-11 object-contain">
          </div>
          <h3 data-editable="factory-challenges-h3-3" <?php echo synergy_style('factory-challenges-h3-3', 'smart-factory'); ?> class="font-display font-800 text-base text-ink mb-2"><?php echo synergy_content('factory-challenges-h3-3', '<span class="lang-th">ข้อมูลกระจัดกระจายหลายระบบ</span><span class="lang-en">Data Silos</span>', 'smart-factory'); ?></h3>
          <p data-editable="factory-challenges-p-3" <?php echo synergy_style('factory-challenges-p-3', 'smart-factory'); ?> class="text-xs text-slate-500 font-300 leading-relaxed"><?php echo synergy_content('factory-challenges-p-3', '<span class="lang-th">ข้อมูลกระจัดกระจาย ทำให้วิเคราะห์และใช้งานร่วมกันได้ยาก</span><span class="lang-en">Production data is scattered across multiple systems.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 04 High Energy Cost -->
        <div class="lg:px-5 pt-6 sm:pt-0 flex flex-col items-center text-center">
          <div class="w-14 h-14 flex items-center justify-center mb-4">
            <img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/solutions/challenges/icon-4-lightning.svg" alt="High energy cost" class="w-11 h-11 object-contain">
          </div>
          <h3 data-editable="factory-challenges-h3-4" <?php echo synergy_style('factory-challenges-h3-4', 'smart-factory'); ?> class="font-display font-800 text-base text-ink mb-2"><?php echo synergy_content('factory-challenges-h3-4', '<span class="lang-th">ต้นทุนการผลิตสูง</span><span class="lang-en">High Operating Costs</span>', 'smart-factory'); ?></h3>
          <p data-editable="factory-challenges-p-4" <?php echo synergy_style('factory-challenges-p-4', 'smart-factory'); ?> class="text-xs text-slate-500 font-300 leading-relaxed"><?php echo synergy_content('factory-challenges-p-4', '<span class="lang-th">ขาดข้อมูลที่ช่วยบริหารต้นทุนและทรัพยากรอย่างมีประสิทธิภาพ</span><span class="lang-en">Limited visibility makes cost optimization difficult.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 05 No Traceability -->
        <div class="lg:px-5 pt-6 sm:pt-0 flex flex-col items-center text-center">
          <div class="w-14 h-14 flex items-center justify-center mb-4">
            <img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/solutions/challenges/icon-5-link.svg" alt="No traceability" class="w-11 h-11 object-contain">
          </div>
          <h3 data-editable="factory-challenges-h3-5" <?php echo synergy_style('factory-challenges-h3-5', 'smart-factory'); ?> class="font-display font-800 text-base text-ink mb-2"><?php echo synergy_content('factory-challenges-h3-5', '<span class="lang-th">ตรวจสอบย้อนหลังได้ยาก</span><span class="lang-en">Limited Traceability</span>', 'smart-factory'); ?></h3>
          <p data-editable="factory-challenges-p-5" <?php echo synergy_style('factory-challenges-p-5', 'smart-factory'); ?> class="text-xs text-slate-500 font-300 leading-relaxed"><?php echo synergy_content('factory-challenges-p-5', '<span class="lang-th">ติดตามข้อมูลการผลิตและคุณภาพได้ไม่ครบถ้วน</span><span class="lang-en">Production and quality records are difficult to trace.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 06 Complex Integration -->
        <div class="lg:px-5 pt-6 sm:pt-0 flex flex-col items-center text-center">
          <div class="w-14 h-14 flex items-center justify-center mb-4">
            <img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/solutions/challenges/icon-6-network.svg" alt="Complex integration" class="w-11 h-11 object-contain">
          </div>
          <h3 data-editable="factory-challenges-h3-6" <?php echo synergy_style('factory-challenges-h3-6', 'smart-factory'); ?> class="font-display font-800 text-base text-ink mb-2"><?php echo synergy_content('factory-challenges-h3-6', '<span class="lang-th">ระบบต่าง ๆ ไม่สามารถเชื่อมต่อกัน</span><span class="lang-en">Disconnected Systems</span>', 'smart-factory'); ?></h3>
          <p data-editable="factory-challenges-p-6" <?php echo synergy_style('factory-challenges-p-6', 'smart-factory'); ?> class="text-xs text-slate-500 font-300 leading-relaxed"><?php echo synergy_content('factory-challenges-p-6', '<span class="lang-th">เครื่องจักรและระบบองค์กรทำงานแยกกัน ทำให้ข้อมูลไม่ต่อเนื่อง</span><span class="lang-en">Machines and enterprise systems are disconnected.</span>', 'smart-factory'); ?></p>
        </div>

      </div>
    </div>
  </section>

  <!-- END-TO-END ENGINEERING SOLUTION -->
  <section id="factory-process" class="py-20 sm:py-24 bg-slate-50/70 border-b border-slate-200/80 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
      
      <!-- Section Header -->
      <div class="text-center mb-14 sm:mb-16">
        <span class="text-emerald-700 text-xs font-800 tracking-[0.25em] uppercase font-display block mb-3">
          <span class="lang-th">บริการวิศวกรรมครบวงจร</span><span class="lang-en">END-TO-END ENGINEERING SOLUTION</span>
        </span>
        <h2 class="font-display font-black text-3xl sm:text-4xl lg:text-5xl text-ink tracking-tight">
          <span class="lang-th">จากแนวคิดทางวิศวกรรม สู่ผลลัพธ์ทางธุรกิจ</span><span class="lang-en">From Engineering to Impact</span>
        </h2>
      </div>

      <!-- Process Cards Grid with Horizontal Connectors -->
      <div class="relative">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6 relative z-10">
          
          <!-- STEP 01 -->
          <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-full group text-center relative">
            <div>
              <!-- Step Circle Badge & Line -->
              <div class="flex items-center justify-center mb-4">
                <div class="w-10 h-10 rounded-full border-2 border-emerald-600 text-emerald-700 font-extrabold text-sm flex items-center justify-center bg-emerald-50/50 shadow-2xs group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
                  01
                </div>
              </div>
              <h3 data-editable="factory-process-h3-1" <?php echo synergy_style('factory-process-h3-1', 'smart-factory'); ?> class="font-display font-800 text-xs text-ink uppercase tracking-wider mb-2"><?php echo synergy_content('factory-process-h3-1', '<span class="lang-th">วิเคราะห์ความต้องการ</span><span class="lang-en">Consult &amp; Assess</span>', 'smart-factory'); ?></h3>
              <p data-editable="factory-process-p-1" <?php echo synergy_style('factory-process-p-1', 'smart-factory'); ?> class="text-[11px] text-slate-500 font-300 leading-snug mb-5"><?php echo synergy_content('factory-process-p-1', '<span class="lang-th">ศึกษาปัญหา เป้าหมาย และกระบวนการทำงานของลูกค้า</span><span class="lang-en">Understand business goals and operational challenges.</span>', 'smart-factory'); ?></p>
            </div>
            <div class="hidden lg:flex items-center gap-1 absolute top-[42px] -right-5 w-10 z-20 text-slate-300 pointer-events-none">
              <span class="flex-1 h-px bg-slate-300"></span>
              <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </div>
            <div class="w-full h-28 rounded-xl overflow-hidden bg-slate-100 border border-slate-100">
              <!-- WebP first, JPEG as the fallback. The card is ~370px wide, so
                   760px covers a 2x screen without shipping the 1448px original. -->
              <picture>
                <source type="image/webp" srcset="<?php echo get_template_directory_uri(); ?>/image/factory-process-01-consult.webp">
                <img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/factory-process-01-consult.jpg" alt="Engineers reviewing a customer's process data" width="760" height="570" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
              </picture>
            </div>
          </div>

          <!-- STEP 02 -->
          <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-full group text-center relative">
            <div>
              <div class="flex items-center justify-center mb-4">
                <div class="w-10 h-10 rounded-full border-2 border-emerald-600 text-emerald-700 font-extrabold text-sm flex items-center justify-center bg-emerald-50/50 shadow-2xs group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
                  02
                </div>
              </div>
              <h3 data-editable="factory-process-h3-2" <?php echo synergy_style('factory-process-h3-2', 'smart-factory'); ?> class="font-display font-800 text-xs text-ink uppercase tracking-wider mb-2"><?php echo synergy_content('factory-process-h3-2', '<span class="lang-th">ออกแบบระบบวิศวกรรม</span><span class="lang-en">Engineering Design</span>', 'smart-factory'); ?></h3>
              <p data-editable="factory-process-p-2" <?php echo synergy_style('factory-process-p-2', 'smart-factory'); ?> class="text-[11px] text-slate-500 font-300 leading-snug mb-5"><?php echo synergy_content('factory-process-p-2', '<span class="lang-th">ออกแบบสถาปัตยกรรมระบบ ฮาร์ดแวร์ ระบบไฟฟ้า Embedded และ Automation</span><span class="lang-en">System architecture, electrical, embedded and automation design.</span>', 'smart-factory'); ?></p>
            </div>
            <div class="hidden lg:flex items-center gap-1 absolute top-[42px] -right-5 w-10 z-20 text-slate-300 pointer-events-none">
              <span class="flex-1 h-px bg-slate-300"></span>
              <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </div>
            <div class="w-full h-28 rounded-xl overflow-hidden bg-slate-100 border border-slate-100">
              <img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/smart-factory-architecture.png" alt="Engineering Design" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            </div>
          </div>

          <!-- STEP 03 -->
          <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-full group text-center relative">
            <div>
              <div class="flex items-center justify-center mb-4">
                <div class="w-10 h-10 rounded-full border-2 border-emerald-600 text-emerald-700 font-extrabold text-sm flex items-center justify-center bg-emerald-50/50 shadow-2xs group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
                  03
                </div>
              </div>
              <h3 data-editable="factory-process-h3-3" <?php echo synergy_style('factory-process-h3-3', 'smart-factory'); ?> class="font-display font-800 text-xs text-ink uppercase tracking-wider mb-2"><?php echo synergy_content('factory-process-h3-3', '<span class="lang-th">พัฒนาฮาร์ดแวร์</span><span class="lang-en">Hardware Development</span>', 'smart-factory'); ?></h3>
              <p data-editable="factory-process-p-3" <?php echo synergy_style('factory-process-p-3', 'smart-factory'); ?> class="text-[11px] text-slate-500 font-300 leading-snug mb-5"><?php echo synergy_content('factory-process-p-3', '<span class="lang-th">ออกแบบและผลิต PCB, Gateway, Controller และอุปกรณ์ IoT สำหรับโรงงาน</span><span class="lang-en">Industrial hardware, PCB, edge gateway, and controller development.</span>', 'smart-factory'); ?></p>
            </div>
            <div class="hidden lg:flex items-center gap-1 absolute top-[42px] -right-5 w-10 z-20 text-slate-300 pointer-events-none">
              <span class="flex-1 h-px bg-slate-300"></span>
              <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </div>
            <div class="w-full h-28 rounded-xl overflow-hidden bg-slate-100 border border-slate-100">
              <img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/pcb-design-prototyping.png" alt="Hardware Development" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            </div>
          </div>

          <!-- STEP 04 -->
          <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-full group text-center relative">
            <div>
              <div class="flex items-center justify-center mb-4">
                <div class="w-10 h-10 rounded-full border-2 border-emerald-600 text-emerald-700 font-extrabold text-sm flex items-center justify-center bg-emerald-50/50 shadow-2xs group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
                  04
                </div>
              </div>
              <h3 data-editable="factory-process-h3-4" <?php echo synergy_style('factory-process-h3-4', 'smart-factory'); ?> class="font-display font-800 text-xs text-ink uppercase tracking-wider mb-2"><?php echo synergy_content('factory-process-h3-4', '<span class="lang-th">พัฒนาซอฟต์แวร์และ Firmware</span><span class="lang-en">Firmware &amp; Software</span>', 'smart-factory'); ?></h3>
              <p data-editable="factory-process-p-4" <?php echo synergy_style('factory-process-p-4', 'smart-factory'); ?> class="text-[11px] text-slate-500 font-300 leading-snug mb-5"><?php echo synergy_content('factory-process-p-4', '<span class="lang-th">พัฒนา Embedded Firmware ระบบ Industrial IoT และแพลตฟอร์ม SynExta</span><span class="lang-en">Embedded firmware, IIoT software and platform development.</span>', 'smart-factory'); ?></p>
            </div>
            <div class="hidden lg:flex items-center gap-1 absolute top-[42px] -right-5 w-10 z-20 text-slate-300 pointer-events-none">
              <span class="flex-1 h-px bg-slate-300"></span>
              <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </div>
            <div class="w-full h-28 rounded-xl overflow-hidden bg-slate-100 border border-slate-100">
              <img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/synexta_platform.png" alt="Firmware & Software" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            </div>
          </div>

          <!-- STEP 05 -->
          <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-full group text-center relative">
            <div>
              <div class="flex items-center justify-center mb-4">
                <div class="w-10 h-10 rounded-full border-2 border-emerald-600 text-emerald-700 font-extrabold text-sm flex items-center justify-center bg-emerald-50/50 shadow-2xs group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
                  05
                </div>
              </div>
              <h3 data-editable="factory-process-h3-5" <?php echo synergy_style('factory-process-h3-5', 'smart-factory'); ?> class="font-display font-800 text-xs text-ink uppercase tracking-wider mb-2"><?php echo synergy_content('factory-process-h3-5', '<span class="lang-th">ติดตั้งและเชื่อมต่อระบบ</span><span class="lang-en">Implementation</span>', 'smart-factory'); ?></h3>
              <p data-editable="factory-process-p-5" <?php echo synergy_style('factory-process-p-5', 'smart-factory'); ?> class="text-[11px] text-slate-500 font-300 leading-snug mb-5"><?php echo synergy_content('factory-process-p-5', '<span class="lang-th">ติดตั้ง ทดสอบ เชื่อมต่อกับเครื่องจักรและระบบ ERP พร้อมอบรมการใช้งาน</span><span class="lang-en">Installation, commissioning, integration and user training.</span>', 'smart-factory'); ?></p>
            </div>
            <div class="hidden lg:flex items-center gap-1 absolute top-[42px] -right-5 w-10 z-20 text-slate-300 pointer-events-none">
              <span class="flex-1 h-px bg-slate-300"></span>
              <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </div>
            <div class="w-full h-28 rounded-xl overflow-hidden bg-slate-100 border border-slate-100">
              <img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/box-build-system-integration.png" alt="Implementation" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            </div>
          </div>

          <!-- STEP 06 -->
          <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between h-full group text-center relative">
            <div>
              <div class="flex items-center justify-center mb-4">
                <div class="w-10 h-10 rounded-full border-2 border-emerald-600 text-emerald-700 font-extrabold text-sm flex items-center justify-center bg-emerald-50/50 shadow-2xs group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
                  06
                </div>
              </div>
              <h3 data-editable="factory-process-h3-6" <?php echo synergy_style('factory-process-h3-6', 'smart-factory'); ?> class="font-display font-800 text-xs text-ink uppercase tracking-wider mb-2"><?php echo synergy_content('factory-process-h3-6', '<span class="lang-th">ดูแลและพัฒนาต่อเนื่อง</span><span class="lang-en">Support &amp; Maintenance</span>', 'smart-factory'); ?></h3>
              <p data-editable="factory-process-p-6" <?php echo synergy_style('factory-process-p-6', 'smart-factory'); ?> class="text-[11px] text-slate-500 font-300 leading-snug mb-5"><?php echo synergy_content('factory-process-p-6', '<span class="lang-th">บริการบำรุงรักษา Monitoring ปรับปรุงระบบ และขยายโซลูชันตามการเติบโตของธุรกิจ</span><span class="lang-en">Maintenance, monitoring, upgrades and continuous improvement.</span>', 'smart-factory'); ?></p>
            </div>
            <div class="w-full h-28 rounded-xl overflow-hidden bg-slate-100 border border-slate-100">
              <img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/iot-operations-data-center.png" alt="Support &amp; Maintenance" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- ================= 5 ขั้นตอนสู่โรงงานอัจฉริยะ (END-TO-END PROCESS) ================= -->
  <section id="factory-5steps-flow" class="py-16 sm:py-24 bg-white border-t border-slate-200/80" style="scroll-margin-top:96px">
    <div class="max-w-7xl mx-auto px-6">
      
      <!-- Section Header -->
      <div class="text-center mb-12 sm:mb-16">
        <p class="text-[#0d5c3a] font-bold text-sm sm:text-base tracking-wide text-center mb-2">
          <span class="lang-th">เปลี่ยนข้อมูลจากโรงงานสู่ผลลัพธ์ทางธุรกิจที่เหนือกว่า</span>
          <span class="lang-en">From Factory Data to Operational Excellence</span>
        </p>
        <h2 class="font-display font-black text-2xl sm:text-3xl lg:text-4xl text-ink tracking-tight text-center">
          <span class="lang-th">โซลูชัน Smart Factory แบบครบวงจร</span>
          <span class="lang-en">END-TO-END SMART FACTORY SOLUTION</span>
        </h2>
      </div>

      <!-- 5 Steps Flow Grid -->
      <div class="relative">
        <!-- Connecting Green Dotted Line (Desktop) -->
        <div class="hidden lg:block absolute top-[72px] left-[10%] right-[10%] h-0.5 border-b-2 border-dashed border-[#0d5c3a]/40 z-0"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 relative z-10 items-stretch">

          <!-- Step 01: SYNC -->
          <div class="bg-white border border-slate-200/90 rounded-[28px] p-6 shadow-[0_8px_30px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group relative h-full">
            <div class="hidden lg:flex items-center justify-center w-8 h-8 rounded-full bg-[#0d5c3a] text-white text-xs shadow-md border-2 border-white absolute -right-5 top-[56px] z-20">
              <i class="fa-solid fa-chevron-right"></i>
            </div>
            <div>
              <div class="w-28 h-28 sm:w-32 sm:h-32 mx-auto mb-4 flex items-center justify-center p-2 group-hover:scale-105 transition-transform duration-300">
                <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_step_3.png" alt="01 SYNC" class="w-full h-full object-contain">
              </div>
              <div class="text-[#0d5c3a] font-extrabold text-sm sm:text-base text-center">01</div>
              <h3 class="text-[#0d5c3a] font-display font-extrabold text-2xl sm:text-3xl text-center tracking-tight mb-1">
                SYNC
              </h3>
              <p class="text-slate-900 font-bold text-sm sm:text-base text-center mb-2 min-h-[24px] flex items-center justify-center">
                <span class="lang-th">เชื่อมต่อทุกระบบ</span>
                <span class="lang-en">Connect Everything</span>
              </p>
              <p class="text-slate-500 text-xs sm:text-[13px] leading-relaxed text-center mb-5 min-h-[70px] px-1 flex items-center justify-center">
                <span class="lang-th">เชื่อมต่อเครื่องจักรและอุปกรณ์ทุกระบบในโรงงาน เพื่อรวบรวมข้อมูลเข้าสู่แพลตฟอร์มเดียวอย่างปลอดภัย</span>
                <span class="lang-en">Build a single source of truth across your factory.</span>
              </p>
            </div>

            <div>
              <div class="w-full h-px bg-slate-100 mb-4"></div>
              <div class="flex flex-col gap-2">
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-microchip text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">เชื่อมต่อเครื่องจักร (PLC, CNC)</span><span class="lang-en">Machine Connectivity (PLC, CNC)</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-wifi text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">เซ็นเซอร์ IoT</span><span class="lang-en">IoT Sensors</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-network-wired text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">ระบบ SCADA / HMI</span><span class="lang-en">SCADA / HMI Systems</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-check-double text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">ระบบคุณภาพ</span><span class="lang-en">Quality Systems</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-screwdriver-wrench text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">ระบบบริหารงานซ่อมบำรุง (PM)</span><span class="lang-en">Maintenance Systems (PM)</span></span>
                </div>
              </div>
            </div>
          </div>

          <!-- Step 02: STREAM -->
          <div class="bg-white border border-slate-200/90 rounded-[28px] p-6 shadow-[0_8px_30px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group relative h-full">
            <div class="hidden lg:flex items-center justify-center w-8 h-8 rounded-full bg-[#0d5c3a] text-white text-xs shadow-md border-2 border-white absolute -right-5 top-[56px] z-20">
              <i class="fa-solid fa-chevron-right"></i>
            </div>
            <div>
              <div class="w-28 h-28 sm:w-32 sm:h-32 mx-auto mb-4 flex items-center justify-center p-2 group-hover:scale-105 transition-transform duration-300">
                <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_step_1.png" alt="02 STREAM" class="w-full h-full object-contain">
              </div>
              <div class="text-[#0d5c3a] font-extrabold text-sm sm:text-base text-center">02</div>
              <h3 class="text-[#0d5c3a] font-display font-extrabold text-2xl sm:text-3xl text-center tracking-tight mb-1">
                STREAM
              </h3>
              <p class="text-slate-900 font-bold text-sm sm:text-base text-center mb-2 min-h-[24px] flex items-center justify-center">
                <span class="lang-th">รวบรวมและติดตามข้อมูล</span>
                <span class="lang-en">Centralize Data</span>
              </p>
              <p class="text-slate-500 text-xs sm:text-[13px] leading-relaxed text-center mb-5 min-h-[70px] px-1 flex items-center justify-center">
                <span class="lang-th">รวบรวมข้อมูลจากทุกแหล่งแบบ Real-time สู่ระบบกลาง เพื่อให้มองเห็นข้อมูลได้อย่างครบถ้วน</span>
                <span class="lang-en">Gain complete visibility into your operations.</span>
              </p>
            </div>

            <div>
              <div class="w-full h-px bg-slate-100 mb-4"></div>
              <div class="flex flex-col gap-2">
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-regular fa-clock text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">ข้อมูลแบบ Real-time</span><span class="lang-en">Real-time Data</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-layer-group text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">รวมศูนย์ทุกแหล่งข้อมูล</span><span class="lang-en">Multi-source Integration</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-desktop text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">แดชบอร์ดแบบ Real-time</span><span class="lang-en">Instant Dashboard</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-regular fa-bell text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">แจ้งเตือนความผิดปกติ</span><span class="lang-en">Alerts &amp; Notifications</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-clock-rotate-left text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">ข้อมูลย้อนหลัง</span><span class="lang-en">Historical Data Log</span></span>
                </div>
              </div>
            </div>
          </div>

          <!-- Step 03: STEER -->
          <div class="bg-white border border-slate-200/90 rounded-[28px] p-6 shadow-[0_8px_30px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group relative h-full">
            <div class="hidden lg:flex items-center justify-center w-8 h-8 rounded-full bg-[#0d5c3a] text-white text-xs shadow-md border-2 border-white absolute -right-5 top-[56px] z-20">
              <i class="fa-solid fa-chevron-right"></i>
            </div>
            <div>
              <div class="w-28 h-28 sm:w-32 sm:h-32 mx-auto mb-4 flex items-center justify-center p-2 group-hover:scale-105 transition-transform duration-300">
                <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_step_4.png" alt="03 STEER" class="w-full h-full object-contain">
              </div>
              <div class="text-[#0d5c3a] font-extrabold text-sm sm:text-base text-center">03</div>
              <h3 class="text-[#0d5c3a] font-display font-extrabold text-2xl sm:text-3xl text-center tracking-tight mb-1">
                STEER
              </h3>
              <p class="text-slate-900 font-bold text-sm sm:text-base text-center mb-2 min-h-[24px] flex items-center justify-center">
                <span class="lang-th">ควบคุมการทำงานอัตโนมัติ</span>
                <span class="lang-en">Automate Operations</span>
              </p>
              <p class="text-slate-500 text-xs sm:text-[13px] leading-relaxed text-center mb-5 min-h-[70px] px-1 flex items-center justify-center">
                <span class="lang-th">ควบคุมและสั่งการกระบวนการผลิตแบบอัตโนมัติ ผ่านระบบที่กำหนดกฎการทำงานได้อย่างยืดหยุ่น</span>
                <span class="lang-en">Reduce manual work and improve production control.</span>
              </p>
            </div>

            <div>
              <div class="w-full h-px bg-slate-100 mb-4"></div>
              <div class="flex flex-col gap-2">
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-gears text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">ควบคุมเครื่องจักรอัตโนมัติ</span><span class="lang-en">Automated Machine Control</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-sliders text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">ตั้งค่ากฎและเงื่อนไขการทำงาน</span><span class="lang-en">Rule &amp; Logic Configuration</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-tower-broadcast text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">สั่งการระยะไกล</span><span class="lang-en">Remote Command</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-route text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">ปรับเปลี่ยนแผนการผลิต</span><span class="lang-en">Dynamic Plan Adjustment</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-link text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">เชื่อมต่อระบบ ERP / MES</span><span class="lang-en">ERP / MES Integration</span></span>
                </div>
              </div>
            </div>
          </div>

          <!-- Step 04: SOLVE -->
          <div class="bg-white border border-slate-200/90 rounded-[28px] p-6 shadow-[0_8px_30px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group relative h-full">
            <div class="hidden lg:flex items-center justify-center w-8 h-8 rounded-full bg-[#0d5c3a] text-white text-xs shadow-md border-2 border-white absolute -right-5 top-[56px] z-20">
              <i class="fa-solid fa-chevron-right"></i>
            </div>
            <div>
              <div class="w-28 h-28 sm:w-32 sm:h-32 mx-auto mb-4 flex items-center justify-center p-2 group-hover:scale-105 transition-transform duration-300">
                <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_step_2.png" alt="04 SOLVE" class="w-full h-full object-contain">
              </div>
              <div class="text-[#0d5c3a] font-extrabold text-sm sm:text-base text-center">04</div>
              <h3 class="text-[#0d5c3a] font-display font-extrabold text-2xl sm:text-3xl text-center tracking-tight mb-1">
                SOLVE
              </h3>
              <p class="text-slate-900 font-bold text-sm sm:text-base text-center mb-2 min-h-[24px] flex items-center justify-center">
                <span class="lang-th">เพิ่มประสิทธิภาพสูงสุด</span>
                <span class="lang-en">Optimize Performance</span>
              </p>
              <p class="text-slate-500 text-xs sm:text-[13px] leading-relaxed text-center mb-5 min-h-[70px] px-1 flex items-center justify-center">
                <span class="lang-th">วิเคราะห์ข้อมูลด้วย AI และเครื่องมือทางสถิติ เพื่อค้นหาปัญหาและโอกาสในการเพิ่มประสิทธิภาพการผลิต</span>
                <span class="lang-en">Turn operational data into smarter decisions.</span>
              </p>
            </div>

            <div>
              <div class="w-full h-px bg-slate-100 mb-4"></div>
              <div class="flex flex-col gap-2">
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-brain text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">วิเคราะห์ด้วย AI และ Machine Learning</span><span class="lang-en">AI / Machine Learning Analytics</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-magnifying-glass-chart text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">วิเคราะห์สาเหตุของปัญหา</span><span class="lang-en">Root Cause Analysis</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-chart-line text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">เพิ่มประสิทธิภาพการผลิต (OEE)</span><span class="lang-en">OEE Improvement</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-wrench text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">คาดการณ์ความต้องการและซ่อมบำรุง</span><span class="lang-en">Predictive Maintenance</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-chart-pie text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">แดชบอร์ดและ KPI แบบ Real-time</span><span class="lang-en">Real-time KPI Reports</span></span>
                </div>
              </div>
            </div>
          </div>

          <!-- Step 05: SAVE -->
          <div class="bg-white border border-slate-200/90 rounded-[28px] p-6 shadow-[0_8px_30px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group relative h-full">
            <div>
              <div class="w-28 h-28 sm:w-32 sm:h-32 mx-auto mb-4 flex items-center justify-center p-2 group-hover:scale-105 transition-transform duration-300">
                <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_step_5.png" alt="05 SAVE" class="w-full h-full object-contain">
              </div>
              <div class="text-[#0d5c3a] font-extrabold text-sm sm:text-base text-center">05</div>
              <h3 class="text-[#0d5c3a] font-display font-extrabold text-2xl sm:text-3xl text-center tracking-tight mb-1">
                SAVE
              </h3>
              <p class="text-slate-900 font-bold text-sm sm:text-base text-center mb-2 min-h-[24px] flex items-center justify-center">
                <span class="lang-th">เพิ่มผลตอบแทนสูงสุด</span>
                <span class="lang-en">Maximize ROI</span>
              </p>
              <p class="text-slate-500 text-xs sm:text-[13px] leading-relaxed text-center mb-5 min-h-[70px] px-1 flex items-center justify-center">
                <span class="lang-th">ลดต้นทุนการผลิตและเพิ่มมูลค่าสูงสุดให้แก่ธุรกิจ</span>
                <span class="lang-en">Reduce costs and increase business value.</span>
              </p>
            </div>

            <div>
              <div class="w-full h-px bg-slate-100 mb-4"></div>
              <div class="flex flex-col gap-2">
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-coins text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">ลดต้นทุนการผลิต</span><span class="lang-en">Production Cost Reduction</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-recycle text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">ลดของเสียและควบคุมคุณภาพ</span><span class="lang-en">Waste Reduction &amp; QC</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-leaf text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">ประหยัดพลังงานและทรัพยากร</span><span class="lang-en">Resource &amp; Energy Savings</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-shield-halved text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">ยืดอายุการใช้งานเครื่องจักร</span><span class="lang-en">Extend Machine Lifespan</span></span>
                </div>
                <div class="flex items-center gap-3 text-slate-700 text-xs font-medium min-h-[44px] py-1">
                  <i class="fa-solid fa-arrow-trend-up text-[#0d5c3a] text-sm w-5 text-center shrink-0"></i>
                  <span class="leading-snug"><span class="lang-th">เพิ่มผลตอบแทนจากการลงทุน (ROI)</span><span class="lang-en">Maximize Return on Investment</span></span>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </section>

  <!-- ================= แพลตฟอร์มเดียว ควบคุมทุกระบบ (INTERACTIVE PLATFORM) =================
       Ported from smart-energy.php. It keeps id="energy-platform" because
       components/energy-platform.css is scoped to that id and
       components/energy-platform.js roots itself there - renaming the id here
       would silently unstyle and deaden the whole section. Ids only have to be
       unique per document, and this page has one.

       The class names inside are generic (.feature-card, .device-card,
       .nav-tab, .modal-backdrop) and would collide with the rest of the site if
       that scope were ever removed.

       The layout was lifted from the Smart Energy deck, and for a while the copy
       came with it - inverter brands, solar, "Smart Energy Management". That has
       been rewritten for the factory: the four cards now read machines, sites,
       deployment, integration. Text is editable per-page under the
       factory-platform-* keys, so check those before assuming what renders. -->
  <section id="energy-platform" class="py-12 sm:py-16 bg-[#f4f7f5] border-y border-slate-200/80" style="scroll-margin-top:96px">
    <div class="sf-shell">
      <div class="platform-card">

        <!-- TOP: pitch + capabilities (Above Tab Bar) -->
        <section class="left-pitch-column top-pitch-layout mb-8">
          <div class="top-pitch-header text-center mb-6">
            <div class="mb-4 flex justify-center">
              <img src="<?php echo get_template_directory_uri(); ?>/image/LOGO SYNEXTA.png" alt="SynExta Logo" class="h-10 sm:h-12 w-auto object-contain drop-shadow-sm">
            </div>
            <h2 data-editable="factory-platform-h2-1" <?php echo synergy_style('factory-platform-h2-1', 'smart-factory'); ?> class="main-heading font-display text-center sm:whitespace-nowrap"><?php echo synergy_content('factory-platform-h2-1', '<span class="lang-th">เทคโนโลยีหลักที่ขับเคลื่อน<br class="sm:hidden"> <span class="heading-highlight">Smart Factory</span></span><span class="lang-en">The Intelligence Behind<br class="sm:hidden"> <span class="heading-highlight">Your Smart Factory</span></span>', 'smart-factory'); ?></h2>
          </div>

          <div class="feature-list">

            <div class="feature-card">
              <div class="feature-icon-box">
                <svg viewBox="0 0 32 32" fill="none" class="feature-svg-icon" aria-hidden="true">
                  <defs><linearGradient id="ep-boltGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#10B981"/><stop offset="100%" stop-color="#00A86B"/>
                  </linearGradient></defs>
                  <path d="M18 3L6 17h8l-2 12 14-14h-8l2-12z" fill="url(#ep-boltGrad)" stroke="#059669" stroke-width="1.5" stroke-linejoin="round"/>
                  <path d="M16 7l-7.5 9.5H14l-1.5 8.5 9-9H16.5l1.5-9z" fill="#FFFFFF" opacity="0.3"/>
                </svg>
              </div>
              <?php /* This card was three separate faults at once: an <h3> closed by a
                       </p>, no lang-th span at all (so the card rendered completely empty
                       in Thai, which is the default), and the one string it did carry was
                       Smart Energy copy about solar inverter brands sitting on the Smart
                       Factory page. Rebuilt to match the three cards below it: title plus
                       feature-sub, both languages, factory subject matter. */ ?>
              <div class="feature-text">
                <h3 class="feature-title">
                  <span class="lang-th">เชื่อมต่อทุกเครื่องจักร</span>
                  <span class="lang-en">Connect Any Machine</span>
                </h3>
                <p class="feature-sub">
                  <span class="lang-th">เชื่อมต่อ PLC, SCADA, เซนเซอร์ และเครื่องจักรหลายยี่ห้อไว้ในแพลตฟอร์มเดียว</span>
                  <span class="lang-en">Connect PLCs, SCADA, sensors, and machines from any brand into one platform.</span>
                </p>
              </div>
            </div>

            <div class="feature-card">
              <div class="feature-icon-box">
                <svg viewBox="0 0 32 32" fill="none" class="feature-svg-icon" aria-hidden="true">
                  <defs><linearGradient id="ep-barGrad" x1="0%" y1="100%" x2="0%" y2="0%">
                    <stop offset="0%" stop-color="#00A86B"/><stop offset="100%" stop-color="#34D399"/>
                  </linearGradient></defs>
                  <rect x="5" y="18" width="5" height="9" rx="1.5" fill="url(#ep-barGrad)"/>
                  <rect x="13.5" y="12" width="5" height="15" rx="1.5" fill="url(#ep-barGrad)"/>
                  <rect x="22" y="6" width="5" height="21" rx="1.5" fill="url(#ep-barGrad)"/>
                  <path d="M5 16l8-6 6 4 8-9" stroke="#00A86B" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <circle cx="27" cy="5" r="2.5" fill="#10B981" stroke="#FFFFFF" stroke-width="1"/>
                </svg>
              </div>
              <div class="feature-text">
                <h3 class="feature-title">
                  <span class="lang-th">บริหารจัดการหลายไซต์</span>
                  <span class="lang-en">Multi-site Management</span>
                </h3>
                <p class="feature-sub">
                  <?php /* Same Smart Energy bleed as the card above: "ระบบ Solar" / "Solar
                           systems" has nothing to do with Smart Factory. Swapped for the
                           production lines this page actually monitors. */ ?>
                  <span class="lang-th">ติดตามโรงงาน สาขา และสายการผลิตได้แบบ Real-time จากศูนย์กลางเดียว</span>
                  <span class="lang-en">Monitor factories, branches, and production lines in real time from one central hub.</span>
                </p>
              </div>
            </div>

            <div class="feature-card">
              <div class="feature-icon-box">
                <svg viewBox="0 0 32 32" fill="none" class="feature-svg-icon" aria-hidden="true">
                  <defs><linearGradient id="ep-cloudGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#34D399"/><stop offset="100%" stop-color="#059669"/>
                  </linearGradient></defs>
                  <path d="M23 23H9a5.5 5.5 0 0 1-.8-10.9A7.5 7.5 0 0 1 23 10a5.5 5.5 0 0 1 0 11z" fill="url(#ep-cloudGrad)"/>
                  <circle cx="16" cy="17" r="2.5" fill="#FFFFFF"/>
                  <path d="M16 11.5v2M16 20v2M10.5 17h2M19.5 17h2" stroke="#FFFFFF" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
              </div>
              <div class="feature-text">
                <h3 class="feature-title">
                  <span class="lang-th">ติดตั้งได้ยืดหยุ่น</span>
                  <span class="lang-en">Flexible Deployment</span>
                </h3>
                <p class="feature-sub">
                  <span class="lang-th">เลือกติดตั้งแบบ Cloud, On-Premise หรือ Hybrid ได้ตามนโยบายด้าน IT</span>
                  <span class="lang-en">Deploy on Cloud, On-Premise, or Hybrid based on IT policies.</span>
                </p>
              </div>
            </div>

            <div class="feature-card">
              <div class="feature-icon-box">
                <svg viewBox="0 0 32 32" fill="none" class="feature-svg-icon" aria-hidden="true">
                  <defs><linearGradient id="ep-shieldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#10B981"/><stop offset="100%" stop-color="#00A86B"/>
                  </linearGradient></defs>
                  <path d="M16 4l10 4v8c0 7.5-5.5 11.5-10 13.5C11.5 27.5 6 23.5 6 16V8l10-4z" fill="url(#ep-shieldGrad)" stroke="#059669" stroke-width="1.2"/>
                  <path d="M11.5 16.5l3.5 3.5 6.5-6.5" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <div class="feature-text">
                <h3 class="feature-title">
                  <span class="lang-th">เชื่อมต่อระบบอัตโนมัติ</span>
                  <span class="lang-en">Automated Open API</span>
                </h3>
                <p class="feature-sub">
                  <span class="lang-th">เชื่อมต่อกับ ERP, BMS, CMMS และระบบอื่น ๆ ขององค์กรได้ผ่าน Open API</span>
                  <span class="lang-en">Integrate with ERP, BMS, CMMS, and enterprise systems via Open API.</span>
                </p>
              </div>
            </div>

          </div>
        </section>

        <!-- ---------- Tab bar ---------- -->
        <header class="app-header">
          <div class="nav-tabs" role="tablist" aria-label="SynExta Factory Platform">

            <button type="button" class="nav-tab active" role="tab" aria-selected="true" aria-controls="view-dashboard" id="tab-dashboard" data-tab="dashboard">
              <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                <line x1="3" y1="9" x2="21" y2="9"/>
                <line x1="9" y1="21" x2="9" y2="9"/>
              </svg>
              <span><span class="lang-th">แดชบอร์ด</span><span class="lang-en">Dashboard</span></span>
              <div class="tab-indicator"></div>
            </button>

            <button type="button" class="nav-tab" role="tab" aria-selected="false" tabindex="-1" aria-controls="view-production" id="tab-production" data-tab="production">
              <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M3 21h18"/><path d="M4 21V10l5 3V10l5 3V6l6 4v11"/>
                <line x1="9" y1="17" x2="9" y2="21"/><line x1="14" y1="17" x2="14" y2="21"/>
              </svg>
              <span><span class="lang-th">การผลิต</span><span class="lang-en">Production</span></span>
            </button>

            <button type="button" class="nav-tab" role="tab" aria-selected="false" tabindex="-1" aria-controls="view-maintenance" id="tab-maintenance" data-tab="maintenance">
              <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M14.7 6.3a4 4 0 0 0 5 5l-9.6 9.6a2.8 2.8 0 0 1-4-4l9.6-9.6a4 4 0 0 0-1-1.4 4 4 0 0 1 5.6 0"/>
              </svg>
              <span><span class="lang-th">ซ่อมบำรุง</span><span class="lang-en">Maintenance</span></span>
            </button>

            <button type="button" class="nav-tab" role="tab" aria-selected="false" tabindex="-1" aria-controls="view-alarms" id="tab-alarms" data-tab="alarms">
              <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
              </svg>
              <span><span class="lang-th">ศูนย์แจ้งเตือน</span><span class="lang-en">Alarm Center</span></span>
            </button>

            <button type="button" class="nav-tab" role="tab" aria-selected="false" tabindex="-1" aria-controls="view-report" id="tab-report" data-tab="report">
              <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
              </svg>
              <span><span class="lang-th">รายงาน</span><span class="lang-en">Report</span></span>
            </button>

          </div>
        </header>

        <!-- ---------- Panels + deployment ----------
             .content-container sits inside the grid so the Cloud / On-Premise
             stack lands BESIDE the screenshot rather than under it - the same
             arrangement smart-agriculture.php uses, where grid-architecture
             holds the screen on the left and the deployment choice on the
             right. The field equipment band goes in the same left column,
             below the screen.

             The whole grid is outside .tab-view, so switching tabs swaps only
             the screenshot; the equipment row and the deployment stack stay
             put instead of being torn down and rebuilt on every click.
             ---------------------------------------------------------------- -->
        <div class="grid-architecture mt-6">

          <section class="center-engine-column">

        <div class="content-container">


          <!-- DASHBOARD -->
          <div id="view-dashboard" class="tab-view active" role="tabpanel" aria-labelledby="tab-dashboard">
            <div class="screen-frame">
              <div class="screen-chrome" aria-hidden="true">
                <span class="screen-dot"></span><span class="screen-dot"></span><span class="screen-dot"></span>
                <span class="screen-chrome-label">SynExta Factory · <span class="lang-th">แดชบอร์ด</span><span class="lang-en">Dashboard</span></span>
              </div>
              <button type="button" class="screen-shot-btn" data-shot-alt="OEE Dashboard">
                <img class="screen-shot" width="1536" height="1024" loading="lazy" decoding="async"
                     src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-factory/platform/screens/dashboard.png') : './image/smart-factory/platform/screens/dashboard.png'; ?>"
                     alt="หน้าจอแดชบอร์ด OEE แสดงค่า OEE, Availability, Performance, Quality, กราฟแนวโน้ม OEE รายชั่วโมง, OEE รายเครื่องจักร, สถานะเครื่องจักร, สาเหตุ Downtime และรายการแจ้งเตือนที่ยังไม่ปิด">
              </button>
              <div class="screen-zoom-hint">🔍 <span class="lang-th">คลิกที่ภาพเพื่อดูขนาดเต็ม</span><span class="lang-en">Click the image to enlarge</span></div>
            </div>
            <p data-editable="factory-platform-p-1" <?php echo synergy_style('factory-platform-p-1', 'smart-factory'); ?> class="demo-note"><?php echo synergy_content('factory-platform-p-1', 'ℹ️
              <span class="lang-th">ตัวเลขในหน้าจอตัวอย่างนี้เป็นข้อมูลจำลองเพื่อสาธิตการทำงาน</span>
              <span class="lang-en">Figures shown in these screens are sample data for demonstration.</span>', 'smart-factory'); ?></p>
          </div>

          <!-- PRODUCTION -->
          <div id="view-production" class="tab-view" role="tabpanel" aria-labelledby="tab-production">
            <div class="screen-frame">
              <div class="screen-chrome" aria-hidden="true">
                <span class="screen-dot"></span><span class="screen-dot"></span><span class="screen-dot"></span>
                <span class="screen-chrome-label">SynExta Factory · <span class="lang-th">การผลิต</span><span class="lang-en">Production</span></span>
              </div>
              <button type="button" class="screen-shot-btn" data-shot-alt="Production Dashboard">
                <img class="screen-shot" width="1536" height="1024" loading="lazy" decoding="async"
                     src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-factory/platform/screens/production.png') : './image/smart-factory/platform/screens/production.png'; ?>"
                     alt="หน้าจอติดตามการผลิต แสดงยอดผลิตวันนี้ อัตราความสำเร็จตามเป้า จำนวน Good Parts และ NG Parts กราฟการผลิตรายชั่วโมง ยอดผลิตแยกตามไลน์ Work Order ปัจจุบัน และประสิทธิภาพรายกะ">
              </button>
              <div class="screen-zoom-hint">🔍 <span class="lang-th">คลิกที่ภาพเพื่อดูขนาดเต็ม</span><span class="lang-en">Click the image to enlarge</span></div>
            </div>
            <p data-editable="factory-platform-p-2" <?php echo synergy_style('factory-platform-p-2', 'smart-factory'); ?> class="demo-note"><?php echo synergy_content('factory-platform-p-2', 'ℹ️
              <span class="lang-th">ตัวเลขในหน้าจอตัวอย่างนี้เป็นข้อมูลจำลองเพื่อสาธิตการทำงาน</span>
              <span class="lang-en">Figures shown in these screens are sample data for demonstration.</span>', 'smart-factory'); ?></p>
          </div>

          <!-- MAINTENANCE -->
          <div id="view-maintenance" class="tab-view" role="tabpanel" aria-labelledby="tab-maintenance">
            <div class="screen-frame">
              <div class="screen-chrome" aria-hidden="true">
                <span class="screen-dot"></span><span class="screen-dot"></span><span class="screen-dot"></span>
                <span class="screen-chrome-label">SynExta Factory · <span class="lang-th">ซ่อมบำรุง</span><span class="lang-en">Maintenance</span></span>
              </div>
              <button type="button" class="screen-shot-btn" data-shot-alt="Maintenance Dashboard">
                <img class="screen-shot" width="1536" height="1024" loading="lazy" decoding="async"
                     src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-factory/platform/screens/maintenance.png') : './image/smart-factory/platform/screens/maintenance.png'; ?>"
                     alt="หน้าจอซ่อมบำรุง แสดงค่า MTBF MTTR Availability จำนวน Breakdown และ PM Compliance ภาพรวมสุขภาพเครื่องจักร ปฏิทินงานบำรุงรักษา Predictive Maintenance และรายการใบสั่งงานล่าสุด">
              </button>
              <div class="screen-zoom-hint">🔍 <span class="lang-th">คลิกที่ภาพเพื่อดูขนาดเต็ม</span><span class="lang-en">Click the image to enlarge</span></div>
            </div>
            <p data-editable="factory-platform-p-3" <?php echo synergy_style('factory-platform-p-3', 'smart-factory'); ?> class="demo-note"><?php echo synergy_content('factory-platform-p-3', 'ℹ️
              <span class="lang-th">ตัวเลขในหน้าจอตัวอย่างนี้เป็นข้อมูลจำลองเพื่อสาธิตการทำงาน</span>
              <span class="lang-en">Figures shown in these screens are sample data for demonstration.</span>', 'smart-factory'); ?></p>
          </div>

          <!-- ALARM CENTER -->
          <div id="view-alarms" class="tab-view" role="tabpanel" aria-labelledby="tab-alarms">
            <div class="screen-frame">
              <div class="screen-chrome" aria-hidden="true">
                <span class="screen-dot"></span><span class="screen-dot"></span><span class="screen-dot"></span>
                <span class="screen-chrome-label">SynExta Factory · <span class="lang-th">ศูนย์แจ้งเตือน</span><span class="lang-en">Alarm Center</span></span>
              </div>
              <button type="button" class="screen-shot-btn" data-shot-alt="Alarm Center">
                <img class="screen-shot" width="1536" height="1024" loading="lazy" decoding="async"
                     src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-factory/platform/screens/alarm-center.png') : './image/smart-factory/platform/screens/alarm-center.png'; ?>"
                     alt="หน้าจอศูนย์แจ้งเตือน แสดงจำนวน Critical Warning และ Info Alarms เวลาตอบสนองเฉลี่ย ตารางการแจ้งเตือนที่ยัง Active สัดส่วนตามระดับความรุนแรง แนวโน้มรายชั่วโมง และรายละเอียดการแจ้งเตือนพร้อมปุ่ม Acknowledge">
              </button>
              <div class="screen-zoom-hint">🔍 <span class="lang-th">คลิกที่ภาพเพื่อดูขนาดเต็ม</span><span class="lang-en">Click the image to enlarge</span></div>
            </div>
            <p data-editable="factory-platform-p-4" <?php echo synergy_style('factory-platform-p-4', 'smart-factory'); ?> class="demo-note"><?php echo synergy_content('factory-platform-p-4', 'ℹ️
              <span class="lang-th">ตัวเลขในหน้าจอตัวอย่างนี้เป็นข้อมูลจำลองเพื่อสาธิตการทำงาน</span>
              <span class="lang-en">Figures shown in these screens are sample data for demonstration.</span>', 'smart-factory'); ?></p>
          </div>

          <!-- REPORT -->
          <div id="view-report" class="tab-view" role="tabpanel" aria-labelledby="tab-report">
            <div class="screen-frame">
              <div class="screen-chrome" aria-hidden="true">
                <span class="screen-dot"></span><span class="screen-dot"></span><span class="screen-dot"></span>
                <span class="screen-chrome-label">SynExta Factory · <span class="lang-th">รายงาน</span><span class="lang-en">Report</span></span>
              </div>
              <button type="button" class="screen-shot-btn" data-shot-alt="Reports Dashboard">
                <img class="screen-shot" width="1536" height="1024" loading="lazy" decoding="async"
                     src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-factory/platform/screens/report.png') : './image/smart-factory/platform/screens/report.png'; ?>"
                     alt="หน้าจอรายงาน แสดงค่าเฉลี่ย OEE Availability Performance Quality ยอดผลิตรวมและอัตราของเสีย กราฟแนวโน้มรายวัน สาเหตุ Downtime สูงสุด ของเสีย 5 อันดับแรก รายการรายงานล่าสุด และปุ่มส่งออก PDF Excel CSV">
              </button>
              <div class="screen-zoom-hint">🔍 <span class="lang-th">คลิกที่ภาพเพื่อดูขนาดเต็ม</span><span class="lang-en">Click the image to enlarge</span></div>
            </div>
            <p data-editable="factory-platform-p-5" <?php echo synergy_style('factory-platform-p-5', 'smart-factory'); ?> class="demo-note"><?php echo synergy_content('factory-platform-p-5', 'ℹ️
              <span class="lang-th">ตัวเลขในหน้าจอตัวอย่างนี้เป็นข้อมูลจำลองเพื่อสาธิตการทำงาน</span>
              <span class="lang-en">Figures shown in these screens are sample data for demonstration.</span>', 'smart-factory'); ?></p>
          </div>

        </div>

        <!-- ---------- Field equipment ----------
             Sits under the screenshot in the same grid column, the way
             smart-agriculture.php stacks its screen and its equipment row.

             Three deliberate differences from the agriculture copy:

             1. Factory equipment, not farm equipment. A Soil Sensor and a
                Smart Irrigation valve on a Smart Factory page would be the same
                class of mistake this page already had (its original device row
                listed Solar Inverter and EV Charger, carried over from
                smart-energy.php). All eight images are reused from the
                capability grid further down this page, so they cost no extra
                bytes - the browser has already fetched them by the time this
                renders.

             2. Cards are <div>, not <button>. energy-platform.js opens the
                telemetry dialog from a DEVICES map keyed by data-device, and
                that map holds only the six energy keys. A <button> whose click
                is a no-op is worse than plain markup: it advertises an action
                that does not exist, and screen readers announce it as
                actionable.

             3. No stack-connector-svg. That SVG hard-codes a 388px-tall
                viewBox with the arrow endpoints measured against the
                agriculture column, which is taller here; it is decorative, and
                the stylesheet already hides it below 1280px anyway.
             ---------------------------------------------------------------- -->
            <div class="field-devices-container">

              <div class="field-section-banner">
                <span class="banner-text">
                  <span class="lang-th">เชื่อมต่ออุปกรณ์และระบบภาคสนาม</span>
                  <span class="lang-en">Field Equipment &amp; System Integration</span>
                </span>
                <div class="banner-connector-stem"></div>
              </div>

              <div class="field-energy-bus" aria-hidden="true">
                <div class="bus-main-line"></div>
                <div class="bus-nodes-row">
                  <div class="bus-node-item"><span class="bus-dot"></span><div class="bus-drop-line"></div></div>
                  <div class="bus-node-item"><span class="bus-dot"></span><div class="bus-drop-line"></div></div>
                  <div class="bus-node-item"><span class="bus-dot"></span><div class="bus-drop-line"></div></div>
                  <div class="bus-node-item"><span class="bus-dot"></span><div class="bus-drop-line"></div></div>
                  <div class="bus-node-item"><span class="bus-dot"></span><div class="bus-drop-line"></div></div>
                  <div class="bus-node-item"><span class="bus-dot"></span><div class="bus-drop-line"></div></div>
                </div>
              </div>

              <div class="devices-row">
                <?php
                /* Photographic equipment renders, copied out of
                   image/smart-agriculture/ where they were mislabelled: the file
                   called agri_dev_weather.png is a production line, agri_dev_soil.png
                   is an industrial router, agri_dev_water.png is a six-axis robot arm.
                   None of them is farm equipment - they belong here. Each label below
                   describes what its picture actually shows.

                   They replace the flat line-art circles this row used before
                   (machine_monitoring.png and friends), which are drawn for the
                   capability grid at the bottom of the page and read as a different
                   visual language at device-card size. */
                $factory_devices = [
                  ['img' => 'fact_dev_line.png',       'th' => 'สายการผลิตและเครื่องจักร', 'en' => 'Production Line &amp; Machines'],
                  ['img' => 'fact_dev_robot.png',      'th' => 'หุ่นยนต์แขนกล',            'en' => 'Robotic Arm'],
                  ['img' => 'fact_dev_vision.png',     'th' => 'กล้องตรวจสอบคุณภาพ',        'en' => 'Machine Vision Camera'],
                  ['img' => 'fact_dev_sensor.png',     'th' => 'เซนเซอร์ตรวจจับในไลน์',     'en' => 'Inline Sensors'],
                  ['img' => 'fact_dev_controller.png', 'th' => 'คอนโทรลเลอร์และมิเตอร์',    'en' => 'Controller &amp; Meter'],
                  ['img' => 'fact_dev_gateway.png',    'th' => 'IIoT Gateway',             'en' => 'IIoT Gateway'],
                ];
                foreach ($factory_devices as $i => $dev): ?>
                <div class="device-card">
                  <span class="device-img-wrapper">
                    <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/<?php echo $dev['img']; ?>" alt="" class="device-img" loading="lazy" decoding="async">
                  </span>
                  <span class="text-xs text-brand font-semibold mb-0.5 block text-center"><?php echo sprintf('%02d', $i + 1); ?></span>
                  <span class="device-name text-center"><span class="lang-th"><?php echo $dev['th']; ?></span><span class="lang-en"><?php echo $dev['en']; ?></span></span>
                  <span class="device-subicon-badge" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                      <path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                      <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line>
                    </svg>
                  </span>
                </div>
                <?php endforeach; ?>
              </div>

            </div>
          </section>

          <!-- RIGHT: deployment options -->
          <section class="right-deployment-column">
            <div class="deployment-cards-stack">

              <div class="deployment-card-square">
                <div class="deploy-img-box">
                  <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/cloud_platform.png" alt="" class="deploy-img" loading="lazy" decoding="async">
                </div>
                <span class="deploy-label"><span class="lang-th">คลาวด์</span><span class="lang-en">Cloud</span></span>
              </div>

              <div class="deploy-vertical-dash"></div>
              <div class="divider-or-circle"><span>OR</span></div>
              <div class="deploy-vertical-dash"></div>

              <div class="deployment-card-square">
                <div class="deploy-img-box">
                  <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/on_premise_deployment.png" alt="" class="deploy-img" loading="lazy" decoding="async">
                </div>
                <span class="deploy-label"><span class="lang-th">ภายในองค์กร</span><span class="lang-en">On-Premise</span></span>
              </div>

            </div>
          </section>

        </div>

        <!-- ---------- Screenshot lightbox ---------- -->
        <div class="shot-lightbox" role="dialog" aria-modal="true" aria-label="Enlarged screenshot">
          <button type="button" class="shot-lightbox-close" aria-label="Close">&times;</button>
          <img alt="">
        </div>

        <!-- ---------- Telemetry dialog ---------- -->
        <div class="modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="ep-modal-title">
          <div class="modal-card">
            <div class="modal-header">
              <h3 id="ep-modal-title">Device Telemetry</h3>
              <button type="button" class="close-btn" aria-label="Close">&times;</button>
            </div>
            <div id="ep-modal-content"></div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= 6. ความสามารถของระบบ SMART ENERGY MANAGEMENT ================= -->

  <section id="factory-capabilities" class="py-20 sm:py-24 bg-slate-50/70 border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-12 sm:mb-14">
        <h2 class="font-display font-black text-2xl sm:text-3xl lg:text-4xl text-slate-900 tracking-tight uppercase">
          SMART FACTORY <span class="text-emerald-600">CAPABILITIES</span>
        </h2>
        <div class="w-12 h-1 bg-emerald-600 rounded-full mx-auto mt-3"></div>
      </div>

      <!-- 12 Cards Grid (3 Rows x 4 Columns) -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-7">

        <!-- 01. Industrial IoT (IIoT) -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
          <div class="w-16 h-16 sm:w-20 sm:h-20 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/iiot.png" alt="Industrial IoT (IIoT)" class="w-full h-full object-contain">
          </div>
          <h3 class="font-display font-800 text-base sm:text-lg text-ink mb-1.5 group-hover:text-emerald-700 transition-colors">
            Industrial IoT (IIoT)
          </h3>
          <p data-editable="factory-capabilities-p-1" <?php echo synergy_style('factory-capabilities-p-1', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[220px]"><?php echo synergy_content('factory-capabilities-p-1', '<span class="lang-th">เชื่อมต่ออุปกรณ์อุตสาหกรรมอย่างปลอดภัย</span>
            <span class="lang-en">Connect industrial equipment securely.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 02. Machine Monitoring -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
          <div class="w-16 h-16 sm:w-20 sm:h-20 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/machine_monitoring.png" alt="Machine Monitoring" class="w-full h-full object-contain">
          </div>
          <h3 class="font-display font-800 text-base sm:text-lg text-ink mb-1.5 group-hover:text-emerald-700 transition-colors">
            Machine Monitoring
          </h3>
          <p data-editable="factory-capabilities-p-2" <?php echo synergy_style('factory-capabilities-p-2', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[260px]"><?php echo synergy_content('factory-capabilities-p-2', '<span class="lang-th">ติดตามสถานะเครื่องจักรแบบ Real-time เพื่อลด Downtime และเพิ่มประสิทธิภาพการผลิต</span>
            <span class="lang-en">Real-time machine monitoring to reduce downtime and improve production efficiency.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 03. OEE Analytics -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
          <div class="w-16 h-16 sm:w-20 sm:h-20 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/oee_analytics.png" alt="OEE Analytics" class="w-full h-full object-contain">
          </div>
          <h3 class="font-display font-800 text-base sm:text-lg text-ink mb-1.5 group-hover:text-emerald-700 transition-colors">
            OEE Analytics
          </h3>
          <p data-editable="factory-capabilities-p-3" <?php echo synergy_style('factory-capabilities-p-3', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[220px]"><?php echo synergy_content('factory-capabilities-p-3', '<span class="lang-th">วัดและปรับปรุงประสิทธิภาพการผลิต</span>
            <span class="lang-en">Measure and improve manufacturing efficiency.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 04. Predictive Maintenance -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
          <div class="w-16 h-16 sm:w-20 sm:h-20 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/predictive_maintenance.png" alt="Predictive Maintenance" class="w-full h-full object-contain">
          </div>
          <h3 class="font-display font-800 text-base sm:text-lg text-ink mb-1.5 group-hover:text-emerald-700 transition-colors">
            Predictive Maintenance
          </h3>
          <p data-editable="factory-capabilities-p-4" <?php echo synergy_style('factory-capabilities-p-4', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[260px]"><?php echo synergy_content('factory-capabilities-p-4', '<span class="lang-th">คาดการณ์ความเสียหายก่อนเกิดขึ้นจริง</span>
            <span class="lang-en">Predict equipment failures before they actually occur.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 05. AI Analytics -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
          <div class="w-16 h-16 sm:w-20 sm:h-20 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/ai_analytics.png" alt="AI Analytics" class="w-full h-full object-contain">
          </div>
          <h3 class="font-display font-800 text-base sm:text-lg text-ink mb-1.5 group-hover:text-emerald-700 transition-colors">
            AI Analytics
          </h3>
          <p data-editable="factory-capabilities-p-5" <?php echo synergy_style('factory-capabilities-p-5', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[260px]"><?php echo synergy_content('factory-capabilities-p-5', '<span class="lang-th">เปลี่ยนข้อมูลการผลิตเป็นข้อมูลเชิงลึก เพื่อการตัดสินใจที่แม่นยำ</span>
            <span class="lang-en">Transform production data into actionable insights for precise decision-making.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 06. Production Traceability -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
          <div class="w-16 h-16 sm:w-20 sm:h-20 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/production_traceability.png" alt="Production Traceability" class="w-full h-full object-contain">
          </div>
          <h3 class="font-display font-800 text-base sm:text-lg text-ink mb-1.5 group-hover:text-emerald-700 transition-colors">
            Production Traceability
          </h3>
          <p data-editable="factory-capabilities-p-6" <?php echo synergy_style('factory-capabilities-p-6', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[260px]"><?php echo synergy_content('factory-capabilities-p-6', '<span class="lang-th">ติดตามย้อนกลับกระบวนการผลิต ตั้งแต่วัตถุดิบจนถึงสินค้าสำเร็จรูป</span>
            <span class="lang-en">Trace production processes from raw materials to finished products.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 07. Energy Monitoring -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
          <div class="w-16 h-16 sm:w-20 sm:h-20 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/energy_monitoring.png" alt="Energy Monitoring" class="w-full h-full object-contain">
          </div>
          <h3 class="font-display font-800 text-base sm:text-lg text-ink mb-1.5 group-hover:text-emerald-700 transition-colors">
            Energy Monitoring
          </h3>
          <p data-editable="factory-capabilities-p-7" <?php echo synergy_style('factory-capabilities-p-7', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[220px]"><?php echo synergy_content('factory-capabilities-p-7', '<span class="lang-th">ติดตามการใช้พลังงานและลดการสูญเสีย</span>
            <span class="lang-en">Monitor energy usage and reduce waste.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 08. Industrial Dashboard -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
          <div class="w-16 h-16 sm:w-20 sm:h-20 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/industrial_dashboard.png" alt="Industrial Dashboard" class="w-full h-full object-contain">
          </div>
          <h3 class="font-display font-800 text-base sm:text-lg text-ink mb-1.5 group-hover:text-emerald-700 transition-colors">
            Industrial Dashboard
          </h3>
          <p data-editable="factory-capabilities-p-8" <?php echo synergy_style('factory-capabilities-p-8', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[260px]"><?php echo synergy_content('factory-capabilities-p-8', '<span class="lang-th">แดชบอร์ดสำหรับผู้บริหาร ช่วยติดตาม KPI ของโรงงานแบบ Real-time</span>
            <span class="lang-en">Executive dashboard for tracking factory KPIs in real time.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 09. Edge Computing -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
          <div class="w-16 h-16 sm:w-20 sm:h-20 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/edge_computing.png" alt="Edge Computing" class="w-full h-full object-contain">
          </div>
          <h3 class="font-display font-800 text-base sm:text-lg text-ink mb-1.5 group-hover:text-emerald-700 transition-colors">
            Edge Computing
          </h3>
          <p data-editable="factory-capabilities-p-9" <?php echo synergy_style('factory-capabilities-p-9', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[220px]"><?php echo synergy_content('factory-capabilities-p-9', '<span class="lang-th">ประมวลผลข้อมูลใกล้เครื่องจักร</span>
            <span class="lang-en">Process data close to machines.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 10. Cloud Platform -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
          <div class="w-16 h-16 sm:w-20 sm:h-20 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/cloud_platform.png" alt="Cloud Platform" class="w-full h-full object-contain">
          </div>
          <h3 class="font-display font-800 text-base sm:text-lg text-ink mb-1.5 group-hover:text-emerald-700 transition-colors">
            Cloud Platform
          </h3>
          <p data-editable="factory-capabilities-p-10" <?php echo synergy_style('factory-capabilities-p-10', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[260px]"><?php echo synergy_content('factory-capabilities-p-10', '<span class="lang-th">รองรับการขยายระบบในอนาคต โดยไม่ต้องลงทุนโครงสร้างพื้นฐานใหม่</span>
            <span class="lang-en">Built to scale as your business grows.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 11. On-Premise Deployment -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
          <div class="w-16 h-16 sm:w-20 sm:h-20 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/on_premise_deployment.png" alt="On-Premise Deployment" class="w-full h-full object-contain">
          </div>
          <h3 class="font-display font-800 text-base sm:text-lg text-ink mb-1.5 group-hover:text-emerald-700 transition-colors">
            On-Premise Deployment
          </h3>
          <p data-editable="factory-capabilities-p-11" <?php echo synergy_style('factory-capabilities-p-11', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[220px]"><?php echo synergy_content('factory-capabilities-p-11', '<span class="lang-th">โครงสร้างภายในองค์กรระดับ enterprise</span>
            <span class="lang-en">Deploy within your enterprise&#39;s private infrastructure.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 12. ERP / MES Integration -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
          <div class="w-16 h-16 sm:w-20 sm:h-20 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/erp_mes_integration.png" alt="ERP / MES Integration" class="w-full h-full object-contain">
          </div>
          <h3 class="font-display font-800 text-base sm:text-lg text-ink mb-1.5 group-hover:text-emerald-700 transition-colors">
            ERP / MES Integration
          </h3>
          <p data-editable="factory-capabilities-p-12" <?php echo synergy_style('factory-capabilities-p-12', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[220px]"><?php echo synergy_content('factory-capabilities-p-12', '<span class="lang-th">เชื่อมระบบโรงงานเข้ากับระบบองค์กร</span>
            <span class="lang-en">Connect factory and enterprise systems.</span>', 'smart-factory'); ?></p>
        </div>

      </div>
    </div>
  </section>

  <!-- INDUSTRIES WE SERVE -->
  <section id="factory-industries" class="py-20 sm:py-24 bg-slate-50/70 border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-12">
        <span class="text-emerald-700 text-xs font-800 tracking-[0.25em] uppercase block mb-3"><span class="lang-th">โซลูชันนี้เหมาะกับใคร</span><span class="lang-en">WHO IS THIS SOLUTION FOR</span></span>
        <h2 class="font-display font-black text-3xl sm:text-4xl text-ink tracking-tight"><span class="lang-th">อุตสาหกรรมที่เราให้บริการ</span><span class="lang-en">Industries We Serve</span></h2>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center group">
          <div class="w-full aspect-[4/3] mb-3.5 rounded-xl overflow-hidden shadow-sm group-hover:scale-102 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/ind_automotive_arm.png" alt="Automotive" class="w-full h-full object-cover">
          </div>
          <p data-editable="factory-industries-p-1" <?php echo synergy_style('factory-industries-p-1', 'smart-factory'); ?> class="font-700 text-base text-ink mb-1"><?php echo synergy_content('factory-industries-p-1', '<span class="lang-th">ยานยนต์</span><span class="lang-en">Automotive</span>', 'smart-factory'); ?></p>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center group">
          <div class="w-full aspect-[4/3] mb-3.5 rounded-xl overflow-hidden shadow-sm group-hover:scale-102 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/ind_electronics_chip.png" alt="Electronics" class="w-full h-full object-cover">
          </div>
          <p data-editable="factory-industries-p-2" <?php echo synergy_style('factory-industries-p-2', 'smart-factory'); ?> class="font-700 text-base text-ink mb-1"><?php echo synergy_content('factory-industries-p-2', '<span class="lang-th">อิเล็กทรอนิกส์</span><span class="lang-en">Electronics</span>', 'smart-factory'); ?></p>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center group">
          <div class="w-full aspect-[4/3] mb-3.5 rounded-xl overflow-hidden shadow-sm group-hover:scale-102 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/ind_food_bottles.png" alt="Food" class="w-full h-full object-cover">
          </div>
          <p data-editable="factory-industries-p-3" <?php echo synergy_style('factory-industries-p-3', 'smart-factory'); ?> class="font-700 text-base text-ink mb-1"><?php echo synergy_content('factory-industries-p-3', '<span class="lang-th">อาหารและเครื่องดื่ม</span><span class="lang-en">Food &amp; Beverage</span>', 'smart-factory'); ?></p>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center group">
          <div class="w-full aspect-[4/3] mb-3.5 rounded-xl overflow-hidden shadow-sm group-hover:scale-102 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/ind_pharma_medicine.png" alt="Pharmaceutical" class="w-full h-full object-cover">
          </div>
          <p data-editable="factory-industries-p-4" <?php echo synergy_style('factory-industries-p-4', 'smart-factory'); ?> class="font-700 text-base text-ink mb-1"><?php echo synergy_content('factory-industries-p-4', '<span class="lang-th">เวชภัณฑ์และยา</span><span class="lang-en">Pharmaceutical</span>', 'smart-factory'); ?></p>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center group">
          <div class="w-full aspect-[4/3] mb-3.5 rounded-xl overflow-hidden shadow-sm group-hover:scale-102 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/ind_packaging_box.png" alt="Packaging" class="w-full h-full object-cover">
          </div>
          <p data-editable="factory-industries-p-5" <?php echo synergy_style('factory-industries-p-5', 'smart-factory'); ?> class="font-700 text-base text-ink mb-1"><?php echo synergy_content('factory-industries-p-5', '<span class="lang-th">บรรจุภัณฑ์</span><span class="lang-en">Packaging</span>', 'smart-factory'); ?></p>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center group">
          <div class="w-full aspect-[4/3] mb-3.5 rounded-xl overflow-hidden shadow-sm group-hover:scale-102 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/ind_energy_solar.png" alt="Energy" class="w-full h-full object-cover">
          </div>
          <p data-editable="factory-industries-p-6" <?php echo synergy_style('factory-industries-p-6', 'smart-factory'); ?> class="font-700 text-base text-ink mb-1"><?php echo synergy_content('factory-industries-p-6', '<span class="lang-th">พลังงาน</span><span class="lang-en">Energy</span>', 'smart-factory'); ?></p>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center group">
          <div class="w-full aspect-[4/3] mb-3.5 rounded-xl overflow-hidden shadow-sm group-hover:scale-102 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/ind_metal_furnace.png" alt="Metal" class="w-full h-full object-cover">
          </div>
          <p data-editable="factory-industries-p-7" <?php echo synergy_style('factory-industries-p-7', 'smart-factory'); ?> class="font-700 text-base text-ink mb-1"><?php echo synergy_content('factory-industries-p-7', '<span class="lang-th">โลหะและเหล็ก</span><span class="lang-en">Metal</span>', 'smart-factory'); ?></p>
        </div>

        <div class="rounded-2xl border border-slate-200/80 bg-white p-4 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center group">
          <div class="w-full aspect-[4/3] mb-3.5 rounded-xl overflow-hidden shadow-sm group-hover:scale-102 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/ind_other_globe.png" alt="Other Industries" class="w-full h-full object-cover">
          </div>
          <p data-editable="factory-industries-p-8" <?php echo synergy_style('factory-industries-p-8', 'smart-factory'); ?> class="font-700 text-base text-ink mb-1"><?php echo synergy_content('factory-industries-p-8', '<span class="lang-th">อุตสาหกรรมอื่น ๆ</span><span class="lang-en">Other Industries</span>', 'smart-factory'); ?></p>
        </div>
      </div>
    </div>
  </section>

  <section id="factory-cta" class="py-14 sm:py-20 bg-white" style="scroll-margin-top:96px">
    <div class="max-w-7xl mx-auto px-6">
      <div class="relative overflow-hidden rounded-[28px] px-6 py-10 sm:px-10 sm:py-14 lg:px-16 text-white"
           style="background:linear-gradient(135deg,#0d4636 0%,#093427 55%,#06261c 100%)">
        <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none z-0"></div>

        <div class="relative z-10 grid gap-8 lg:grid-cols-[1.35fr_auto] lg:items-center">
          <div>
            <p class="sf-cta-eyebrow mb-3" style="color:#4ade80">
              <span class="lang-th">เริ่มต้นกับเรา</span>
              <span class="lang-en">GET STARTED</span>
            </p>
            <h2 data-editable="factory-cta-h2" <?php echo synergy_style('factory-cta-h2', 'smart-factory'); ?> class="sf-cta-h2 font-display text-white"><?php echo synergy_content('factory-cta-h2', '<span class="lang-th">ยกระดับโรงงานของคุณสู่ <span class="text-brand-bright">Smart Factory</span></span>
              <span class="lang-en">Transform Your Plant into a <span class="text-brand-bright">Smart Factory</span></span>', 'smart-factory'); ?></h2>
            <p data-editable="factory-cta-p" <?php echo synergy_style('factory-cta-p', 'smart-factory'); ?> class="sf-cta-lede text-slate-200 mt-5 max-w-2xl"><?php echo synergy_content('factory-cta-p', '<span class="lang-th">ทีมวิศวกรพร้อมสำรวจหน้างานและออกแบบระบบที่เหมาะสมกับกระบวนการผลิตของคุณ</span>
              <span class="lang-en">Our engineers are ready to assess your site and design a system that fits your production process.</span>', 'smart-factory'); ?></p>
          </div>

          <div class="flex flex-col sm:flex-row lg:flex-col gap-3 lg:gap-4 lg:min-w-[240px]">
            <a href="<?php echo home_url('/'); ?>#contact"
               class="sf-cta-label inline-flex items-center justify-center gap-2.5 bg-brand-bright text-white px-8 py-4 rounded-xl font-800 uppercase tracking-wider hover:bg-emerald-600 transition-all shadow-lg shadow-brand-bright/30 hover:-translate-y-0.5">
              <i class="fa-solid fa-paper-plane"></i>
              <span class="lang-th">ติดต่อทีมวิศวกร</span>
              <span class="lang-en">Contact Our Engineers</span>
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
  <script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/live-editor.js') : './components/live-editor.js'; ?>"></script>
  <!-- Tabs, device dialogs and the lazily-attached 3D viewer for
       #energy-platform. defer: it queries the section on load. -->
  <script defer src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/energy-platform.js') : './components/energy-platform.js'; ?>"></script>


  <!-- IMAGE LIGHTBOX ZOOM MODAL -->

<?php include __DIR__ . '/components/cookie-consent.php'; ?>
  <?php wp_footer(); ?>
</body>

</html>
