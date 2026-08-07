<?php
/* Template Name: Smart Agriculture Solution */
/*
 * Ported from the standalone solutions/smart-agriculture.html in the syntec-h
 * folder, the same way smart-factory.php was. The section structure and the
 * imagery are that page's; what changed is the shell and the copy layer:
 *
 *  - Asset paths. The standalone page lived in /solutions/ and reached its
 *    images with ../image/... A document-relative path like that resolves
 *    against whatever URL the page is served at, and this one is served at
 *    /smart-agriculture/. Everything goes through get_template_directory_uri(),
 *    which is also what WordPress needs.
 *  - Head. Replaced with this theme's head so the page gets the same fonts,
 *    stylesheet, favicon and wpThemeUri that components/scripts.js relies on to
 *    build the navbar and footer.
 *  - Every visible string is now a lang-th / lang-en pair. The source page was
 *    Thai-only, and a missing half silently freezes that string in the other
 *    language when the switcher runs (AGENTS.md rule 4).
 *  - Type sizes come from the site's shared .svc-* scale (defined in service.php,
 *    heading clamps taken from about.php), copied into the <style> block below,
 *    instead of Tailwind text-* utilities. components/style.css forces every
 *    text-* step with !important through attribute selectors, so a chain like
 *    "text-3xl sm:text-5xl" renders at its LARGEST step on every breakpoint
 *    (AGENTS.md rule 2) - which is what smart-factory.php still does: measured
 *    59.5px h1 and 46.8px h2 on a 375px phone. See the table in the style block.
 *  - The source markup had an unbalanced </div> in the overview section that
 *    pushed the product card outside its grid column. Fixed here.
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
$sa_img = get_template_directory_uri() . '/image/solutions/';
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smart Agriculture · เกษตรอัจฉริยะ IoT, AWD &amp; Carbon Credit | Synergy Group</title>
  <meta name="description" content="ระบบเกษตรอัจฉริยะ IoT วัด Soil NPK ความชื้น และควบคุมน้ำแบบ AWD ลดก๊าซมีเทน ประหยัดน้ำ พร้อมข้อมูล Carbon Credit Ready สำหรับเกษตรกรและองค์กรในประเทศไทย">
  <meta name="keywords" content="Smart Agriculture Thailand, เกษตรอัจฉริยะ, IoT เกษตร, AWD ข้าว, Soil Sensor NPK, Carbon Credit ข้าว, SYNRiceWater, HandySense, IoT Solar Node">

  <link rel="canonical" href="<?php echo home_url('/smart-agriculture/'); ?>">
  <meta name="robots" content="index,follow">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Synergy Technology">
  <meta property="og:title" content="Smart Agriculture · เกษตรอัจฉริยะ IoT &amp; Carbon Credit">
  <meta property="og:description" content="เครือข่ายเซนเซอร์ไร้สายพลังงานแสงอาทิตย์ ควบคุมน้ำแบบ AWD และข้อมูลพร้อมยื่น Carbon Credit">
  <meta property="og:image" content="<?php echo $sa_img; ?>agri-hero-bg.png">
  <meta property="og:url" content="<?php echo home_url('/smart-agriculture/'); ?>">
  <meta name="twitter:card" content="summary_large_image">

  <!-- Structured data carried over from the source page. The absolute
       synergygroup.co.th URLs are replaced with this site's own; the
       organisation name, address and phone are left exactly as the source had
       them - see the naming note in AGENTS.md rule 1. Verify before launch. -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Service",
    "name": "Smart Agriculture & Carbon Credit IoT System",
    "alternateName": "เทคโนโลยีจัดการเกษตรกรรมและคาร์บอนเครดิต",
    "description": "ระบบ IoT วัดสภาพแปลงนา Soil NPK ความชื้น และควบคุมระดับน้ำแบบ AWD (Alternate Wetting and Drying) ลดการปล่อยก๊าซมีเทน ประหยัดน้ำ พร้อมข้อมูลสำหรับยื่นรับรองคาร์บอนเครดิตมาตรฐานสากล",
    "url": "<?php echo home_url('/smart-agriculture/'); ?>",
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
    "serviceType": "Agricultural IoT & Carbon Management",
    "category": "Smart Agriculture Technology",
    "hasOfferCatalog": {
      "@type": "OfferCatalog",
      "name": "Smart Agriculture Devices",
      "itemListElement": [
        { "@type": "Offer", "itemOffered": { "@type": "Product", "name": "SYNRiceWater AWD Node", "description": "เซนเซอร์วัดระดับน้ำในแปลงนา ประหยัดพลังงาน" } },
        { "@type": "Offer", "itemOffered": { "@type": "Product", "name": "Smart Greenhouse (HandySense)", "description": "ควบคุมพ่นหมอก รดน้ำ และอุณหภูมิอัตโนมัติ" } },
        { "@type": "Offer", "itemOffered": { "@type": "Product", "name": "IoT Solar Node 4G", "description": "ส่งสัญญาณไร้สาย จ่ายไฟโซลาร์เซลล์" } },
        { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Carbon Credit Data Report", "description": "ข้อมูลโปร่งใสพร้อมยื่นรับรองคาร์บอนเครดิตมาตรฐานสากล" } }
      ]
    }
  }
  </script>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/image/s-logo.png">
  <link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/image/s-logo.png">
  <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/image/s-logo.png">

  <!-- Tailwind CSS CDN. Palette kept identical to smart-factory.php so the two
       solution pages render the same greens. -->
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
            muted: "#5C6E65"
          },
          fontFamily: {
            display: ['"Space Grotesk"', 'sans-serif'],
            body: ['Inter', 'Sarabun', 'sans-serif']
          },
          boxShadow: {
            'bento': '0 8px 30px rgba(11, 31, 22, 0.04)',
            'bento-hover': '0 20px 50px rgba(11, 31, 22, 0.1)'
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
      overflow-wrap: break-word;
    }

    /* Thai runs long without spaces, so a browser that is allowed to break
       inside a "word" splits a syllable and strands its vowel or tone mark
       (AGENTS.md rule 3). Prose opts out; the body-level rule above stays, to
       catch stray long Latin strings. */
    p, li, .lang-th {
      overflow-wrap: normal;
      word-break: keep-all;
      hyphens: none;
    }

    /* Tailwind's CDN build does not emit font-300/500/700/800, which the ported
       markup uses. Same shim as smart-factory.php. */
    .font-300 { font-weight: 300; }
    .font-500 { font-weight: 500; }
    .font-700 { font-weight: 700; }
    .font-800 { font-weight: 800; }

    /* ==========================================================================
       TYPE SCALE — the site's shared ladder, not a new one for this page

       components/style.css forces every Tailwind text-* step with !important via
       attribute selectors, so a chain like "text-3xl sm:text-5xl" resolves to its
       LARGEST step at every breakpoint, and p/li/td/th are pinned to 1.075rem
       whatever you write inline (AGENTS.md rule 2). Measured on smart-factory.php:
       its hero h1 is 59.5px and its section h2 46.8px on a 375px phone, and its
       paragraphs sit at 14.9px — under the 16px floor Thai needs (rule 3).

       So the sizes here come from the documented house scale in service.php,
       which itself reuses about.php's heading clamps. Every value below is a step
       the rest of the site already uses (root is 17px, 18.5px at >=1024px):

         text-xs   0.875rem  14.9 -> 16.2px      text-2xl  1.75rem  29.8 -> 32.4px
         text-sm   0.975rem  16.6 -> 18.0px      text-4xl  2.75rem  46.8 -> 50.9px
         text-base 1.075rem  18.3 -> 19.9px
         text-lg   1.25rem   21.2 -> 23.1px

       Names are kept identical to service.php (.svc-*) so the two pages are
       obviously one system. Three tokens this page needs that service.php has no
       equivalent for — .svc-h3, .svc-stat, .svc-num, .svc-metric, .svc-btn — are
       pinned to steps on the same ladder rather than invented sizes.
       ========================================================================== */
    .svc-h1 {                         /* = about.php hero h1 */
      font-size: clamp(30px, 5.6vw, 60px) !important;
      line-height: 1.12 !important;
      letter-spacing: -0.02em !important;
      font-weight: 800 !important;
    }
    .svc-h2 {                         /* = about.php section h2 */
      font-size: clamp(22px, 2.78vw, 44px) !important;
      line-height: 1.2 !important;
      letter-spacing: -0.015em !important;
      font-weight: 800 !important;
    }
    .svc-h3 {                         /* tops out at site text-2xl 29.8 -> 32.4px. Clamped, not
                                         fixed: at 1.75rem flat it rendered 29.8px on a 375px
                                         phone while .svc-h2 had clamped down to 22px, so the
                                         sub-heading outsized the heading above it. */
      font-size: clamp(21px, 2.1vw, 1.75rem) !important;
      line-height: 1.3 !important;
      letter-spacing: -0.015em !important;
      font-weight: 700 !important;
    }
    .svc-lede {                       /* = site text-lg   21.2 -> 23.1px */
      font-size: 1.25rem !important;
      line-height: 1.55 !important;
      font-weight: 700 !important;
    }
    .svc-copy {                       /* = site text-base 18.3 -> 19.9px, the site's body size */
      font-size: 1.075rem !important;
      line-height: 1.75 !important;
      font-weight: 400 !important;
    }
    .svc-label {                      /* = site text-base bold, card and step titles */
      font-size: 1.075rem !important;
      line-height: 1.4 !important;
      font-weight: 700 !important;
    }
    .svc-caption {                    /* = site text-sm   16.6 -> 18.0px, Thai captions and bullets */
      font-size: 0.975rem !important;
      line-height: 1.8 !important;    /* Thai needs 1.8+; tone marks and vowels need the room */
      font-weight: 500 !important;
    }
    .svc-kicker {                     /* = site text-xs, tracked caps eyebrow */
      font-size: 0.875rem !important;
      line-height: 1.4 !important;
      font-weight: 800 !important;
      letter-spacing: 0.14em !important;
      text-transform: uppercase !important;
    }
    .svc-metric {                     /* = site text-sm bold. NOT text-xs: these labels carry
                                         Thai, and 14.9px is below the 16px floor (rule 3). */
      font-size: 0.975rem !important;
      line-height: 1.5 !important;
      font-weight: 700 !important;
    }
    .svc-btn {                        /* = site text-sm bold, button and pill text. Same reason
                                         as .svc-metric: the buttons carry Thai. */
      font-size: 0.975rem !important;
      line-height: 1.4 !important;
      font-weight: 700 !important;
    }
    .svc-stat {                       /* site text-2xl -> text-4xl. Floor in px for the same
                                         reason as .svc-h3: it must not outgrow .svc-h2. */
      font-size: clamp(21px, 2.4vw, 2.75rem) !important;
      line-height: 1.1 !important;
      font-weight: 800 !important;
    }
    .svc-num {                        /* tops out at site text-2xl, same clamping reason */
      font-size: clamp(20px, 1.9vw, 1.75rem) !important;
      line-height: 1 !important;
      font-weight: 800 !important;
    }

    /* Same wrapping guards service.php uses: text-wrap: pretty kills one-word last
       lines, and word-break: normal hands Thai back to the browser's dictionary
       line-breaker instead of letting it split a syllable (rule 3). */
    .svc-copy, .svc-caption, .svc-lede {
      text-wrap: pretty;
      word-break: normal !important;
      overflow-wrap: break-word;
    }
    /* 1.8 is right for Thai and visibly loose for Latin. */
    html[lang="en"] .svc-copy,
    html[lang="en"] .svc-caption,
    html[lang="en"] .svc-lede { line-height: 1.6 !important; }

    /* Tracked caps are a Latin device: on Thai they prise the tone marks away from
       their consonants and read as broken spacing. */
    html[lang="th"] .svc-kicker,
    html[lang="th"] .svc-btn,
    html[lang="th"] .svc-metric { letter-spacing: 0 !important; text-transform: none !important; }

    /* Tech-grid blueprint pattern, carried over from the source page. */
    .sa-mesh {
      background-size: 20px 20px;
      background-image:
        linear-gradient(to right, rgba(0, 0, 0, 0.03) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(0, 0, 0, 0.03) 1px, transparent 1px);
    }
    .sa-mesh-dark {
      background-size: 24px 24px;
      background-image:
        linear-gradient(to right, rgba(255, 255, 255, 0.02) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
    }
    .sa-card   { border: 1px solid rgba(11, 31, 22, 0.06); box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.6); }
    .sa-card-d { border: 1px solid rgba(255, 255, 255, 0.07); box-shadow: inset 0 1px 1px 0 rgba(255, 255, 255, 0.08); }
    .sa-spring { transition-duration: 500ms; transition-timing-function: cubic-bezier(0.16, 1, 0.3, 1); }

    /* The navbar is position:fixed, 80px tall, so in-page anchors need to clear
       it or the heading lands underneath. */
    [id] { scroll-margin-top: 100px; }

    /* Every tap target reaches 44px. The source page's pill buttons were 40px
       on a phone once the padding collapsed. */
    .sa-tap { min-height: 48px; }

    @media (prefers-reduced-motion: reduce) {
      .sa-spring, .transition, [class*="transition-"] { transition: none !important; }
      .animate-pulse, .animate-bounce { animation: none !important; }
    }
  </style>

  <script>
    window.wpThemeUrl = "<?php echo get_template_directory_uri(); ?>/";
    window.wpThemeUri = "<?php echo get_template_directory_uri(); ?>/";
  </script>
  <?php wp_head(); ?>
</head>

<body id="top" <?php body_class("bg-[#F8FAF9] text-body antialiased"); ?>>
  <!-- NAVBAR CONTAINER -->
  <div id="navbar-container"></div>

  <main id="main-content">

    <!-- HERO -->
    <section id="agri-hero" class="relative bg-ink text-white py-24 sm:py-32 lg:py-40 overflow-hidden flex items-center">
      <div class="absolute inset-0 bg-cover bg-center" style="background-image: linear-gradient(rgba(2, 4, 3, 0.4), rgba(2, 4, 3, 0.7)), url('<?php echo $sa_img; ?>agri-hero-bg.png');"></div>
      <div class="absolute inset-0 pointer-events-none opacity-60 sa-mesh-dark"></div>
      <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-[-20%] right-[-10%] w-[420px] h-[420px] lg:w-[600px] lg:h-[600px] bg-brand/20 rounded-full blur-[140px]"></div>
        <div class="absolute bottom-[-10%] left-[-15%] w-[360px] h-[360px] lg:w-[500px] lg:h-[500px] bg-gold-bright/5 rounded-full blur-[120px]"></div>
      </div>

      <div class="max-w-7xl mx-auto px-5 sm:px-6 relative z-10 w-full">
        <div class="mb-5">
          <a href="<?php echo home_url('/'); ?>#solutions" class="text-white/60 hover:text-gold-bright svc-btn uppercase tracking-wider transition inline-flex items-center gap-2">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i><span class="lang-th">โซลูชัน</span><span class="lang-en">Solutions</span>
          </a>
        </div>
        <div class="inline-flex items-center gap-2.5 mb-7 bg-white/5 border border-white/10 px-4 sm:px-5 py-2 rounded-full backdrop-blur-md sa-card-d">
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse" aria-hidden="true"></span>
          <!-- Same Latin string in both languages: it is a product-technology
               label, not prose, and the switcher still needs a pair to act on. -->
          <span class="text-white/90 svc-kicker"><span class="lang-th">AIoT LPWAN Technology</span><span class="lang-en">AIoT LPWAN Technology</span></span>
        </div>
        <h1 class="font-display svc-h1 text-white tracking-tight mb-6">
          <span class="lang-th">เทคโนโลยีเกษตรอัจฉริยะ<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-brand to-gold-bright">และคาร์บอนเครดิต</span></span>
          <span class="lang-en">Smart Agriculture<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-brand to-gold-bright">&amp; Carbon Credit</span></span>
        </h1>
        <p class="svc-lede text-white/75 max-w-3xl mb-10">
          <span class="lang-th">ยกระดับการทำเกษตรแม่นยำสูง (Precision Agriculture) ด้วยเครือข่าย Sensor ไร้สายพลังงานแสงอาทิตย์ และการจัดเก็บข้อมูลระดับคาร์บอนเครดิตที่โปร่งใสและตรวจสอบได้จริง</span>
          <span class="lang-en">Precision agriculture built on solar-powered wireless sensor networks, with carbon-grade field data that is transparent and auditable.</span>
        </p>
        <div class="flex flex-col sm:flex-row flex-wrap gap-4">
          <a href="<?php echo home_url('/'); ?>#contact" class="sa-tap bg-brand hover:bg-brand-deep text-white svc-btn uppercase tracking-wider px-8 py-4 rounded-xl transition shadow-lg shadow-brand/20 inline-flex items-center justify-center gap-2 sa-card-d">
            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i><span class="lang-th">ปรึกษาโครงการ</span><span class="lang-en">Talk to Our Experts</span>
          </a>
          <a href="#agri-overview" class="sa-tap border border-white/20 hover:bg-white/10 text-white svc-btn uppercase tracking-wider px-8 py-4 rounded-xl transition inline-flex items-center justify-center gap-2 sa-card-d">
            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i><span class="lang-th">สำรวจโซลูชัน</span><span class="lang-en">Explore the Solution</span>
          </a>
        </div>
      </div>
    </section>

    <!-- METRICS BANNER -->
    <section class="relative z-20 -mt-10 sm:-mt-12 max-w-7xl mx-auto px-5 sm:px-6" aria-label="Key figures">
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 p-4 sm:p-5 rounded-[28px] sm:rounded-[32px] bg-white/85 backdrop-blur-xl border border-white/60 shadow-bento">
        <div class="p-5 sm:p-8 text-center bg-white rounded-2xl sa-card group hover:border-brand/20 hover:shadow-bento-hover sa-spring">
          <div class="font-display svc-stat text-brand mb-2 group-hover:scale-105 sa-spring">AWD</div>
          <div class="svc-metric text-muted"><span class="lang-th">ระบบควบคุมน้ำเปียกสลับแห้ง</span><span class="lang-en">Alternate Wetting &amp; Drying</span></div>
        </div>
        <div class="p-5 sm:p-8 text-center bg-white rounded-2xl sa-card group hover:border-brand/20 hover:shadow-bento-hover sa-spring">
          <div class="font-display svc-stat text-brand mb-2 group-hover:scale-105 sa-spring">NPK</div>
          <div class="svc-metric text-muted"><span class="lang-th">Sensor วัดแร่ธาตุในดินแม่นยำ</span><span class="lang-en">Precise Soil Nutrient Sensing</span></div>
        </div>
        <div class="p-5 sm:p-8 text-center bg-white rounded-2xl sa-card group hover:border-brand/20 hover:shadow-bento-hover sa-spring">
          <div class="font-display svc-stat text-brand mb-2 group-hover:scale-105 sa-spring">10+</div>
          <div class="svc-metric text-muted"><span class="lang-th">อายุแบตเตอรี่โหนดภาคสนาม (ปี)</span><span class="lang-en">Years of Field Node Battery Life</span></div>
        </div>
        <div class="p-5 sm:p-8 text-center bg-white rounded-2xl sa-card group hover:border-brand/20 hover:shadow-bento-hover sa-spring">
          <div class="font-display svc-stat text-brand mb-2 group-hover:scale-105 sa-spring">Carbon</div>
          <div class="svc-metric text-muted"><span class="lang-th">ข้อมูลพร้อมยื่น Carbon Credit</span><span class="lang-en">Carbon Credit Ready Data</span></div>
        </div>
      </div>
    </section>

    <!-- 01 · OVERVIEW -->
    <section id="agri-overview" class="py-20 sm:py-28 lg:py-32 sa-mesh">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="grid lg:grid-cols-12 gap-10 lg:gap-16 items-center">

          <div class="lg:col-span-7 space-y-7">
            <div class="inline-flex items-center gap-3">
              <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
              <span class="text-brand svc-kicker"><span class="lang-th">01 · Smart Agriculture Platform</span><span class="lang-en">01 · Smart Agriculture Platform</span></span>
            </div>
            <h2 class="font-display svc-h2 text-ink tracking-tight">
              <span class="lang-th">ก้าวสู่ระบบเกษตรกรรมแม่นยำสูง<br>จากแนวคิดสู่การใช้งานจริง</span>
              <span class="lang-en">Precision Agriculture<br>From Concept to Working Farm</span>
            </h2>
            <div class="svc-copy text-body space-y-5">
              <p>
                <span class="lang-th">โซลูชัน <strong>Smart Agriculture (AIoT LPWAN)</strong> ของเรา เปลี่ยนกระบวนการทางการเกษตรดั้งเดิมให้เป็นดิจิทัลอย่างแท้จริง ด้วย Sensor วิเคราะห์พื้นที่เพาะปลูกแบบเจาะลึกเฉพาะตำแหน่ง</span>
                <span class="lang-en">Our <strong>Smart Agriculture (AIoT LPWAN)</strong> solution digitises traditional farming end to end, using sensors that analyse each plot position by position.</span>
              </p>
              <p>
                <span class="lang-th">ระบบทำงานผ่านเครือข่ายไร้สายระยะไกลที่ใช้พลังงานต่ำ ส่งข้อมูลสภาพอากาศ (Micro Weather Station) ระดับน้ำ (Flood Warning) และแร่ธาตุในดินขึ้นคลาวด์อัตโนมัติ ช่วยให้คุณลดต้นทุนแรงงานและวางแผนเพาะปลูกได้แม่นยำขึ้น</span>
                <span class="lang-en">A low-power, long-range wireless network streams micro weather, flood warning and soil nutrient readings to the cloud automatically, so you cut labour cost and plan each crop cycle with confidence.</span>
              </p>
            </div>

            <!-- Mini pillars -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5 pt-2">
              <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1.5 sa-spring group">
                <div class="w-11 h-11 rounded-2xl bg-brand-soft text-brand flex items-center justify-center mb-4 group-hover:scale-105 sa-spring" aria-hidden="true">
                  <i class="fa-solid fa-compass"></i>
                </div>
                <h3 class="svc-label text-ink mb-2">Precision Ag</h3>
                <p class="svc-caption text-muted">
                  <span class="lang-th">วิเคราะห์เฉพาะจุดเพื่อให้ปุ๋ยและน้ำตรงตามความต้องการของพืช</span>
                  <span class="lang-en">Plot-level analysis so water and fertiliser go exactly where the crop needs them.</span>
                </p>
              </div>
              <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1.5 sa-spring group">
                <div class="w-11 h-11 rounded-2xl bg-brand-soft text-brand flex items-center justify-center mb-4 group-hover:scale-105 sa-spring" aria-hidden="true">
                  <i class="fa-solid fa-cloud-sun"></i>
                </div>
                <h3 class="svc-label text-ink mb-2">Micro Weather</h3>
                <p class="svc-caption text-muted">
                  <span class="lang-th">ตรวจจับอุณหภูมิ ความชื้น แสงสว่าง และปริมาณฝนเฉพาะแปลง</span>
                  <span class="lang-en">Per-plot temperature, humidity, light and rainfall readings.</span>
                </p>
              </div>
              <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1.5 sa-spring group">
                <div class="w-11 h-11 rounded-2xl bg-brand-soft text-brand flex items-center justify-center mb-4 group-hover:scale-105 sa-spring" aria-hidden="true">
                  <i class="fa-solid fa-tower-broadcast"></i>
                </div>
                <h3 class="svc-label text-ink mb-2">LPWAN IoT</h3>
                <p class="svc-caption text-muted">
                  <span class="lang-th">เครือข่ายไร้สายระยะไกล ครอบคลุมแปลงเกษตรขนาดใหญ่</span>
                  <span class="lang-en">Long-range wireless coverage across large farming areas.</span>
                </p>
              </div>
            </div>
          </div>

          <!-- System graphic -->
          <div class="lg:col-span-5 relative mt-2 lg:mt-0">
            <div class="relative rounded-[28px] sm:rounded-[32px] overflow-hidden bg-slate-50 sa-card shadow-2xl h-64 sm:h-80">
              <img loading="lazy" decoding="async" src="<?php echo $sa_img; ?>agri-aiot-lpwan-system.png" alt="AIoT LPWAN system architecture" class="w-full h-full object-cover">
              <div class="absolute bottom-4 left-4 right-4 sm:bottom-6 sm:left-6 sm:right-6 bg-brand-deep/90 backdrop-blur-md p-4 sm:p-5 rounded-2xl border border-white/10 text-white">
                <div class="svc-kicker text-gold-bright mb-1"><span class="lang-th">AIoT LPWAN System</span><span class="lang-en">AIoT LPWAN System</span></div>
                <div class="svc-label">
                  <span class="lang-th">Sensor ภาคสนาม → Cloud → Dashboard แบบ Real-time</span>
                  <span class="lang-en">Field Sensors → Cloud → Real-time Dashboard</span>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- 02 · DEVICES & TECHNOLOGY -->
    <section id="agri-devices" class="py-20 sm:py-28 lg:py-32 bg-white relative overflow-hidden">
      <div class="max-w-7xl mx-auto px-5 sm:px-6 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-14 sm:mb-20">
          <div class="inline-flex items-center gap-3 justify-center mb-4">
            <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
            <span class="text-brand svc-kicker"><span class="lang-th">02 · Devices &amp; Technology</span><span class="lang-en">02 · Devices &amp; Technology</span></span>
          </div>
          <h2 class="font-display svc-h2 text-ink tracking-tight mb-5">
            <span class="lang-th">เทคโนโลยีและอุปกรณ์ภาคสนาม</span>
            <span class="lang-en">Field Devices &amp; Technology</span>
          </h2>
          <p class="svc-lede text-body max-w-2xl mx-auto">
            <span class="lang-th">การทำงานร่วมกันระหว่างฮาร์ดแวร์วัดค่า แหล่งจ่ายพลังงาน และซอฟต์แวร์บริหารจัดการข้อมูลแผนที่ระดับความแม่นยำสูง</span>
            <span class="lang-en">Measurement hardware, autonomous power and high-precision mapping software working as one system.</span>
          </p>
        </div>

        <div class="grid lg:grid-cols-12 gap-10 lg:gap-12 items-center mb-14 sm:mb-16">
          <div class="lg:col-span-6 space-y-6 order-2 lg:order-1">
            <h3 class="font-display svc-h3 text-ink">Precision Farming Platform</h3>
            <p class="svc-copy text-muted">
              <span class="lang-th">ซอฟต์แวร์ประมวลผลแผนที่แปลงนาและแปลงเกษตรแบบ Real-time เชื่อมต่อกับโดรนและสถานีวัดสภาพอากาศภายนอกได้ ช่วยคำนวณการใช้ทรัพยากร พลังงาน และการปล่อยคาร์บอนผ่านแอปพลิเคชันอย่างเป็นระบบ</span>
              <span class="lang-en">Real-time field mapping software that connects to drones and third-party weather stations, and accounts for resource use, energy and carbon emissions in one application.</span>
            </p>
            <div class="grid sm:grid-cols-2 gap-4">
              <div class="p-5 bg-surface rounded-2xl border border-brand/5">
                <i class="fa-solid fa-solar-panel text-brand mb-2 block" aria-hidden="true"></i>
                <h4 class="svc-label text-ink mb-1">Solar Powered Nodes</h4>
                <p class="svc-caption text-muted">
                  <span class="lang-th">แผงโซลาร์เซลล์ 200W สำหรับ Gateway และ 80W สำหรับ Node พร้อมแบตเตอรี่ในตัว</span>
                  <span class="lang-en">200W panels for gateways and 80W for nodes, each with an onboard battery.</span>
                </p>
              </div>
              <div class="p-5 bg-surface rounded-2xl border border-brand/5">
                <i class="fa-solid fa-temperature-empty text-brand mb-2 block" aria-hidden="true"></i>
                <h4 class="svc-label text-ink mb-1">Soil Sensors</h4>
                <p class="svc-caption text-muted">
                  <span class="lang-th">วัดแร่ธาตุ NPK อุณหภูมิ และความชื้นในดินได้ลึก 5 ระดับ</span>
                  <span class="lang-en">NPK, temperature and moisture readings across five soil depths.</span>
                </p>
              </div>
            </div>
          </div>

          <div class="lg:col-span-6 order-1 lg:order-2">
            <div class="rounded-[28px] sm:rounded-[32px] overflow-hidden sa-card shadow-bento h-56 sm:h-72 lg:h-80">
              <img loading="lazy" decoding="async" src="<?php echo $sa_img; ?>agri-precision-farming-platform.png" alt="Precision Farming Platform dashboard" class="w-full h-full object-cover">
            </div>
          </div>
        </div>

        <!-- Spec bar -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
          <div class="bg-surface rounded-2xl p-6 sa-card hover:-translate-y-1 sa-spring">
            <span class="text-brand font-display svc-label block mb-2">IoT LoRaWAN Gateway</span>
            <p class="svc-caption text-muted">
              <span class="lang-th">เกตเวย์สื่อสารระยะไกล ใช้ Industrial Cellular Router ส่งข้อมูลขึ้นคลาวด์</span>
              <span class="lang-en">Long-range gateway using an industrial cellular router to reach the cloud.</span>
            </p>
          </div>
          <div class="bg-surface rounded-2xl p-6 sa-card hover:-translate-y-1 sa-spring">
            <span class="text-brand font-display svc-label block mb-2">Solar Charger System</span>
            <p class="svc-caption text-muted">
              <span class="lang-th">บอร์ดบริหารพลังงานสำรอง แบตเตอรี่ 12.8V / 200Ah รองรับการทำงาน 365 วัน</span>
              <span class="lang-en">Power management board with a 12.8V / 200Ah battery rated for year-round duty.</span>
            </p>
          </div>
          <div class="bg-surface rounded-2xl p-6 sa-card hover:-translate-y-1 sa-spring">
            <span class="text-brand font-display svc-label block mb-2">Soil NPK &amp; Moisture</span>
            <p class="svc-caption text-muted">
              <span class="lang-th">หัว Sensor สเตนเลส 316 ทนการกัดกร่อน วัดแร่ธาตุและการนำไฟฟ้าในดิน</span>
              <span class="lang-en">Corrosion-resistant 316 stainless probes measuring nutrients and soil conductivity.</span>
            </p>
          </div>
          <div class="bg-surface rounded-2xl p-6 sa-card hover:-translate-y-1 sa-spring">
            <span class="text-brand font-display svc-label block mb-2">Light Sensor &amp; HMI Display</span>
            <p class="svc-caption text-muted">
              <span class="lang-th">จอแสดงผลหน้าตู้สนาม และ Sensor วัดความเข้มแสง Lux สำหรับการสังเคราะห์แสง</span>
              <span class="lang-en">Cabinet-front display plus a lux sensor for photosynthesis monitoring.</span>
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- 03 · IOT SOLAR NODE 4G -->
    <section id="agri-solar-node" class="py-20 sm:py-28 lg:py-32 bg-surface relative">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="grid lg:grid-cols-12 gap-10 lg:gap-16 items-center">

          <div class="lg:col-span-5">
            <div class="rounded-[28px] sm:rounded-[32px] overflow-hidden sa-card shadow-bento h-56 sm:h-72 lg:h-80">
              <img loading="lazy" decoding="async" src="<?php echo $sa_img; ?>agri-iot-solar-node-4g.png" alt="IoT Solar Node 4G field device" class="w-full h-full object-cover">
            </div>
          </div>

          <div class="lg:col-span-7 space-y-7">
            <div class="inline-flex items-center gap-3">
              <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
              <span class="text-brand svc-kicker"><span class="lang-th">03 · IoT Field Device</span><span class="lang-en">03 · IoT Field Device</span></span>
            </div>
            <h2 class="font-display svc-h2 text-ink tracking-tight">IoT Solar Node 4G</h2>
            <p class="svc-copy text-body">
              <span class="lang-th">โหนด Sensor ภาคสนามระบบไฮบริด ออกแบบให้เป็นสถานีตรวจวัดและส่งข้อมูลแบบ Standalone ชาร์จแบตเตอรี่ในตัวจากแผงโซลาร์เซลล์ด้านบน ส่งสัญญาณไร้สายผ่านโครงข่าย 4G LTE ใช้งานได้ยาวนานถึง 10 ปีโดยไม่ต้องบำรุงรักษาเพิ่ม</span>
              <span class="lang-en">A hybrid field node built as a standalone measure-and-transmit station. It charges its own battery from the panel above and reports over 4G LTE, running up to ten years with no added maintenance.</span>
            </p>

            <div class="grid sm:grid-cols-2 gap-6">
              <div class="space-y-4">
                <h4 class="svc-label text-ink"><i class="fa-solid fa-list-check text-brand mr-2" aria-hidden="true"></i><span class="lang-th">ฟังก์ชันการทำงานหลัก</span><span class="lang-en">Core Functions</span></h4>
                <ul class="space-y-3 svc-caption text-muted">
                  <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle text-[6px] text-brand mt-2 shrink-0" aria-hidden="true"></i><span><span class="lang-th">ทำงานเป็นเอกเทศด้วยโซลาร์เซลล์ชาร์จเจอร์</span><span class="lang-en">Runs autonomously on its solar charger.</span></span></li>
                  <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle text-[6px] text-brand mt-2 shrink-0" aria-hidden="true"></i><span><span class="lang-th">ส่งสัญญาณไร้สายผ่านเครือข่าย 4G LTE ขึ้นคลาวด์</span><span class="lang-en">Sends data to the cloud over 4G LTE.</span></span></li>
                  <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle text-[6px] text-brand mt-2 shrink-0" aria-hidden="true"></i><span><span class="lang-th">มี Open API สำหรับนำข้อมูลไปใช้งานต่อ</span><span class="lang-en">Open API for downstream use of the data.</span></span></li>
                </ul>
              </div>
              <div class="space-y-4">
                <h4 class="svc-label text-ink"><i class="fa-solid fa-crop text-brand mr-2" aria-hidden="true"></i><span class="lang-th">พื้นที่การประยุกต์ใช้งาน</span><span class="lang-en">Where It Is Used</span></h4>
                <div class="flex flex-wrap gap-2">
                  <span class="bg-white border border-gray-100 px-3 py-2 rounded-lg svc-caption text-muted"><span class="lang-th">แปลงเพาะปลูกผัก</span><span class="lang-en">Vegetable Plots</span></span>
                  <span class="bg-white border border-gray-100 px-3 py-2 rounded-lg svc-caption text-muted"><span class="lang-th">โรงเรือนอัจฉริยะ</span><span class="lang-en">Smart Greenhouses</span></span>
                  <span class="bg-white border border-gray-100 px-3 py-2 rounded-lg svc-caption text-muted"><span class="lang-th">แปลงนาข้าว</span><span class="lang-en">Rice Paddies</span></span>
                  <span class="bg-white border border-gray-100 px-3 py-2 rounded-lg svc-caption text-muted"><span class="lang-th">สวนผลไม้</span><span class="lang-en">Orchards</span></span>
                </div>
              </div>
            </div>

            <div class="border-t border-gray-200 pt-6 grid grid-cols-3 gap-4">
              <div>
                <span class="font-display svc-num text-brand block">01</span>
                <div class="svc-metric text-muted mt-1"><span class="lang-th">ใช้พลังงานสะอาด</span><span class="lang-en">Clean Energy</span></div>
              </div>
              <div class="border-l border-gray-200 pl-4">
                <span class="font-display svc-num text-brand block">02</span>
                <div class="svc-metric text-muted mt-1"><span class="lang-th">เชื่อมต่อ Sensor ได้หลากหลาย</span><span class="lang-en">Multi-Sensor Ready</span></div>
              </div>
              <div class="border-l border-gray-200 pl-4">
                <span class="font-display svc-num text-brand block">03</span>
                <div class="svc-metric text-muted mt-1"><span class="lang-th">ประหยัดค่าโครงสร้างพื้นฐาน</span><span class="lang-en">Lower Infrastructure Cost</span></div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>

    <!-- 04 · SYNRICEWATER AWD / CARBON CREDIT -->
    <section id="agri-carbon" class="py-20 sm:py-28 lg:py-32 bg-white relative">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="grid lg:grid-cols-12 gap-10 lg:gap-16 items-center">

          <div class="lg:col-span-5 space-y-5">
            <div class="rounded-3xl overflow-hidden shadow-lg border border-gray-100 h-40 sm:h-48">
              <img loading="lazy" decoding="async" src="<?php echo $sa_img; ?>agri-synricewater-awd-1.png" alt="SYNRiceWater AWD sensor in a rice field" class="w-full h-full object-cover">
            </div>
            <div class="rounded-3xl overflow-hidden shadow-lg border border-gray-100 h-40 sm:h-48">
              <img loading="lazy" decoding="async" src="<?php echo $sa_img; ?>agri-synricewater-awd-2.png" alt="SYNRiceWater AWD network across rice paddies" class="w-full h-full object-cover">
            </div>
          </div>

          <div class="lg:col-span-7 space-y-7">
            <div class="inline-flex items-center gap-3">
              <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
              <span class="text-brand svc-kicker"><span class="lang-th">04 · Carbon Credit System</span><span class="lang-en">04 · Carbon Credit System</span></span>
            </div>
            <h2 class="font-display svc-h2 text-ink tracking-tight">
              SYNRiceWater AWD<br>
              <span class="text-brand"><span class="lang-th">ลดน้ำ ลดมีเทน เพิ่มรายได้จาก Carbon Credit</span><span class="lang-en">Less Water, Less Methane, More Carbon Credit</span></span>
            </h2>
            <p class="svc-copy text-body">
              <span class="lang-th">การทำนาข้าวแบบน้ำขังเป็นแหล่งกำเนิดหลักของก๊าซมีเทน ซึ่งมีฤทธิ์ทำลายชั้นบรรยากาศรุนแรงกว่า CO₂ ถึง 28 เท่า เราจึงพัฒนา <strong>SYNRiceWater AWD</strong> สำหรับการทำนาเปียกสลับแห้ง พร้อมบันทึกข้อมูลระดับน้ำแบบเข้ารหัสบนคลาวด์ เพื่อยื่นประเมินคาร์บอนเครดิตมาตรฐานสากล</span>
              <span class="lang-en">Continuously flooded rice is a major methane source, and methane traps 28 times more heat than CO₂. <strong>SYNRiceWater AWD</strong> manages alternate wetting and drying while logging tamper-evident water-level records to the cloud, ready for international carbon credit assessment.</span>
            </p>

            <!-- Key features -->
            <div>
              <span class="inline-block bg-brand text-white px-4 py-2 rounded-lg svc-btn uppercase tracking-wider mb-5">Key Features</span>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="space-y-2 text-center">
                  <div class="w-10 h-10 rounded-xl bg-brand text-white flex items-center justify-center font-700 mx-auto">01</div>
                  <h4 class="svc-label text-brand">Built for AWD Farming</h4>
                  <p class="svc-caption text-muted">
                    <span class="lang-th">ออกแบบสำหรับวัดระดับน้ำในท่อ PVC ใต้ดินในแปลงนาข้าว</span>
                    <span class="lang-en">Designed to read water level inside buried PVC tubes in paddy fields.</span>
                  </p>
                </div>
                <div class="space-y-2 text-center">
                  <div class="w-10 h-10 rounded-xl bg-brand text-white flex items-center justify-center font-700 mx-auto">02</div>
                  <h4 class="svc-label text-brand">Solar + LTE Autonomous</h4>
                  <p class="svc-caption text-muted">
                    <span class="lang-th">ทำงานอัตโนมัติเต็มรูปแบบ ชาร์จไฟจากโซลาร์เซลล์ ส่งข้อมูลผ่าน 4G</span>
                    <span class="lang-en">Fully autonomous, solar charged and reporting over 4G.</span>
                  </p>
                </div>
                <div class="space-y-2 text-center">
                  <div class="w-10 h-10 rounded-xl bg-brand text-white flex items-center justify-center font-700 mx-auto">03</div>
                  <h4 class="svc-label text-brand">Carbon Credit Ready Data</h4>
                  <p class="svc-caption text-muted">
                    <span class="lang-th">ข้อมูลมีประวัติย้อนหลังถาวร ป้องกันการดัดแปลง ตามเกณฑ์ประเมิน</span>
                    <span class="lang-en">Permanent, tamper-evident history that meets assessment criteria.</span>
                  </p>
                </div>
              </div>
            </div>

            <!-- Benefits -->
            <div>
              <span class="inline-block bg-brand text-white px-4 py-2 rounded-lg svc-btn uppercase tracking-wider mb-4">Benefits</span>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="flex items-start gap-3 bg-white p-4 rounded-3xl border border-gray-100 shadow-lg">
                  <span class="font-display svc-num text-brand">1</span>
                  <p class="svc-caption text-muted">
                    <span class="lang-th">ลดการใช้น้ำและต้นทุนชลประทาน</span>
                    <span class="lang-en">Reduce water usage and irrigation cost</span>
                  </p>
                </div>
                <div class="flex items-start gap-3 bg-white p-4 rounded-3xl border border-gray-100 shadow-lg">
                  <span class="font-display svc-num text-brand">2</span>
                  <p class="svc-caption text-muted">
                    <span class="lang-th">ลดการปล่อยก๊าซมีเทนด้วยวิธี AWD</span>
                    <span class="lang-en">Cut methane emissions through AWD</span>
                  </p>
                </div>
                <div class="flex items-start gap-3 bg-white p-4 rounded-3xl border border-gray-100 shadow-lg">
                  <span class="font-display svc-num text-brand">3</span>
                  <p class="svc-caption text-muted">
                    <span class="lang-th">เปิดโอกาสสร้างรายได้จาก Carbon Credit</span>
                    <span class="lang-en">Unlock carbon credit opportunities</span>
                  </p>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- 05 · SMART GREENHOUSE -->
    <section id="agri-greenhouse" class="py-20 sm:py-28 lg:py-32 bg-surface relative overflow-hidden">
      <div class="absolute inset-0 opacity-20 pointer-events-none sa-mesh"></div>
      <div class="max-w-7xl mx-auto px-5 sm:px-6 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-14 sm:mb-20">
          <div class="inline-flex items-center gap-3 justify-center mb-4">
            <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
            <span class="text-brand svc-kicker"><span class="lang-th">05 · Closed-Loop Automation</span><span class="lang-en">05 · Closed-Loop Automation</span></span>
          </div>
          <h2 class="font-display svc-h2 text-ink tracking-tight mb-5">
            <span class="lang-th">Smart Greenhouse โรงเรือนอัจฉริยะ</span>
            <span class="lang-en">Smart Greenhouse</span>
          </h2>
          <p class="svc-lede text-body max-w-2xl mx-auto">
            <span class="lang-th">ระบบโรงเรือนอัตโนมัติครบวงจร ทำงานร่วมกับ HandySense เพื่อตรวจสอบและสั่งการพัดลม ปั๊มน้ำ และระบบพ่นหมอกตามตัวแปรธรรมชาติ</span>
            <span class="lang-en">A complete greenhouse automation system working with HandySense to monitor conditions and drive fans, pumps and misting on their own.</span>
          </p>
        </div>

        <div class="grid lg:grid-cols-12 gap-10 lg:gap-16 items-center">
          <div class="lg:col-span-5 space-y-4">
            <div class="grid grid-cols-2 gap-4">
              <div class="rounded-2xl overflow-hidden sa-card shadow-md h-32 sm:h-36">
                <img loading="lazy" decoding="async" src="<?php echo $sa_img; ?>agri-greenhouse-control-panel.png" alt="Smart Greenhouse control panel with HandySense" class="w-full h-full object-cover">
              </div>
              <div class="rounded-2xl overflow-hidden sa-card shadow-md h-32 sm:h-36">
                <img loading="lazy" decoding="async" src="<?php echo $sa_img; ?>agri-greenhouse-interior.png" alt="Smart Greenhouse interior" class="w-full h-full object-cover">
              </div>
            </div>
            <div class="rounded-3xl overflow-hidden sa-card shadow-lg h-48 sm:h-56">
              <img loading="lazy" decoding="async" src="<?php echo $sa_img; ?>agri-greenhouse-exterior.png" alt="Smart Greenhouse exterior" class="w-full h-full object-cover">
            </div>
          </div>

          <div class="lg:col-span-7 space-y-6">
            <h3 class="font-display svc-h3 text-ink">
              <span class="lang-th">คุณสมบัติระบบโรงเรือนอัจฉริยะ</span>
              <span class="lang-en">Smart Greenhouse System Capabilities</span>
            </h3>
            <ul class="grid sm:grid-cols-2 gap-4 svc-caption text-muted">
              <li class="flex items-start gap-2.5">
                <i class="fa-solid fa-circle-check text-brand mt-1" aria-hidden="true"></i>
                <span>
                  <span class="lang-th"><strong>ระบบ Sensor ตรวจจับหลากหลาย</strong> ติดตั้ง Sensor อุณหภูมิ ความชื้น แสงสว่าง และธาตุอาหารดินครบถ้วน</span>
                  <span class="lang-en"><strong>Full sensing coverage.</strong> Temperature, humidity, light and soil nutrient sensors across the house.</span>
                </span>
              </li>
              <li class="flex items-start gap-2.5">
                <i class="fa-solid fa-circle-check text-brand mt-1" aria-hidden="true"></i>
                <span>
                  <span class="lang-th"><strong>ควบคุมหัวจ่ายและพัดลม</strong> ควบคุมมอเตอร์ ปั๊มน้ำ และโซลินอยด์วาล์วพ่นหมอก</span>
                  <span class="lang-en"><strong>Actuator control.</strong> Motors, water pumps and misting solenoid valves.</span>
                </span>
              </li>
              <li class="flex items-start gap-2.5">
                <i class="fa-solid fa-circle-check text-brand mt-1" aria-hidden="true"></i>
                <span>
                  <span class="lang-th"><strong>การรับส่งสัญญาณระบบไฮบริด</strong> เชื่อมต่ออินเทอร์เน็ตผ่านสาย และมี Wi-Fi 4G LTE Router ในตัว</span>
                  <span class="lang-en"><strong>Hybrid connectivity.</strong> Wired internet plus a built-in Wi-Fi 4G LTE router.</span>
                </span>
              </li>
              <li class="flex items-start gap-2.5">
                <i class="fa-solid fa-circle-check text-brand mt-1" aria-hidden="true"></i>
                <span>
                  <span class="lang-th"><strong>พร้อมติดตั้งและขยายขนาด</strong> บอร์ดพร้อมติดตั้งในกล่องมาตรฐานอุตสาหกรรม ทนน้ำทนฝุ่นระดับ IP65</span>
                  <span class="lang-en"><strong>Ready to deploy and scale.</strong> Boards ship in industrial IP65 enclosures.</span>
                </span>
              </li>
            </ul>

            <div class="bg-white rounded-[24px] p-5 sm:p-6 sa-card shadow-bento">
              <h4 class="svc-label text-ink mb-4"><i class="fa-solid fa-sliders text-brand mr-2" aria-hidden="true"></i><span class="lang-th">อุปกรณ์และ Sensor ในระบบ Smart Greenhouse</span><span class="lang-en">Devices &amp; Sensors in the Smart Greenhouse</span></h4>
              <!-- 3-up on phones: five Thai labels across one row at 390px leaves
                   ~70px per cell, which breaks each label onto three lines. -->
              <div class="grid grid-cols-3 sm:grid-cols-5 gap-3 text-center">
                <div class="p-2 hover:bg-surface rounded-xl transition flex flex-col items-center justify-center">
                  <div class="h-12 w-12 rounded overflow-hidden mb-2 bg-slate-50"><img loading="lazy" decoding="async" src="<?php echo $sa_img; ?>agri-icon-light-sensor.png" alt="Light sensor" class="w-full h-full object-cover"></div>
                  <div class="svc-metric text-ink">Light Sensor</div>
                </div>
                <div class="p-2 hover:bg-surface rounded-xl transition flex flex-col items-center justify-center">
                  <div class="h-12 w-12 rounded overflow-hidden mb-2 bg-slate-50"><img loading="lazy" decoding="async" src="<?php echo $sa_img; ?>agri-icon-temp-humidity.png" alt="Temperature and humidity sensor" class="w-full h-full object-cover"></div>
                  <div class="svc-metric text-ink">Temp/Humidity</div>
                </div>
                <div class="p-2 hover:bg-surface rounded-xl transition flex flex-col items-center justify-center">
                  <div class="h-12 w-12 rounded overflow-hidden mb-2 bg-slate-50"><img loading="lazy" decoding="async" src="<?php echo $sa_img; ?>agri-icon-soil-moisture.png" alt="Soil moisture sensor" class="w-full h-full object-cover"></div>
                  <div class="svc-metric text-ink">Soil Moisture</div>
                </div>
                <div class="p-2 hover:bg-surface rounded-xl transition flex flex-col items-center justify-center">
                  <div class="h-12 w-12 rounded overflow-hidden mb-2 bg-slate-50"><img loading="lazy" decoding="async" src="<?php echo $sa_img; ?>agri-icon-handysense.png" alt="HandySense controller" class="w-full h-full object-cover"></div>
                  <div class="svc-metric text-ink">HandySense</div>
                </div>
                <div class="p-2 hover:bg-surface rounded-xl transition flex flex-col items-center justify-center">
                  <div class="h-12 w-12 rounded overflow-hidden mb-2 bg-slate-50"><img loading="lazy" decoding="async" src="<?php echo $sa_img; ?>agri-icon-platform.png" alt="Platform dashboard" class="w-full h-full object-cover"></div>
                  <div class="svc-metric text-ink">Platform</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- OTHER SOLUTIONS -->
    <section id="agri-related" class="py-16 sm:py-20 bg-white border-t border-gray-100">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <p class="text-center svc-metric text-muted mb-8"><span class="lang-th">โซลูชันอื่นๆ</span><span class="lang-en">Other Solutions</span></p>
        <div class="grid sm:grid-cols-2 gap-5 max-w-3xl mx-auto">
          <a href="<?php echo home_url('/smart-energy/'); ?>" class="bg-white border border-gray-100 rounded-3xl p-5 sm:p-6 flex items-center gap-5 hover:shadow-bento-hover hover:border-brand/25 transition sa-spring group shadow-bento">
            <span class="w-12 h-12 rounded-2xl bg-brand-soft text-brand flex items-center justify-center group-hover:bg-brand group-hover:text-white transition shrink-0">
              <i class="fa-solid fa-bolt" aria-hidden="true"></i>
            </span>
            <span>
              <span class="block svc-label text-ink mb-1">Smart Energy</span>
              <span class="block svc-caption text-muted"><span class="lang-th">บริหารพลังงานอัจฉริยะในโรงงานและอาคาร</span><span class="lang-en">Intelligent energy management for plants and buildings.</span></span>
            </span>
          </a>
          <a href="<?php echo home_url('/smart-factory/'); ?>" class="bg-white border border-gray-100 rounded-3xl p-5 sm:p-6 flex items-center gap-5 hover:shadow-bento-hover hover:border-brand/25 transition sa-spring group shadow-bento">
            <span class="w-12 h-12 rounded-2xl bg-brand-soft text-brand flex items-center justify-center group-hover:bg-brand group-hover:text-white transition shrink-0">
              <i class="fa-solid fa-gears" aria-hidden="true"></i>
            </span>
            <span>
              <span class="block svc-label text-ink mb-1">Smart Factory</span>
              <span class="block svc-caption text-muted"><span class="lang-th">วิเคราะห์ OEE เครื่องจักรและระบบคลังสินค้าอัตโนมัติ</span><span class="lang-en">Machine OEE analytics and warehouse automation.</span></span>
            </span>
          </a>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section id="agri-cta" class="py-20 sm:py-28 bg-ink text-white relative overflow-hidden">
      <div class="absolute inset-0 pointer-events-none opacity-40 sa-mesh-dark"></div>
      <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-[30%] left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[350px] bg-brand-deep rounded-full blur-[110px]" aria-hidden="true"></div>
      </div>

      <div class="max-w-4xl mx-auto px-5 sm:px-6 text-center relative z-10">
        <i class="fa-solid fa-seedling text-gold-bright text-3xl mb-6 block" aria-hidden="true"></i>
        <h2 class="font-display svc-h2 text-white mb-5 tracking-tight">
          <span class="lang-th">เริ่มต้นทำเกษตรแม่นยำสูง<br>เพื่อยกระดับผลผลิตและวิถีคาร์บอนต่ำ</span>
          <span class="lang-en">Start Precision Farming<br>For Better Yield and a Low-Carbon Path</span>
        </h2>
        <p class="svc-copy text-white/70 mb-10 max-w-2xl mx-auto">
          <span class="lang-th">ทีมวิศวกร IoT เกษตรอัจฉริยะของเราพร้อมให้คำปรึกษาและเข้าสำรวจพื้นที่จริง ตั้งแต่ติดตั้ง Sensor ไร้สายภาคสนาม จนถึงการเตรียมข้อมูลยื่นขอใบรับรองคาร์บอนเครดิต</span>
          <span class="lang-en">Our agricultural IoT engineers advise and survey on site, from installing field sensors to preparing the data for carbon credit certification.</span>
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-stretch sm:items-center">
          <a href="<?php echo home_url('/'); ?>#contact" class="sa-tap w-full sm:w-auto bg-brand hover:bg-brand-deep text-white svc-btn uppercase tracking-wider px-8 py-4 rounded-xl transition shadow-lg shadow-brand/20 inline-flex items-center justify-center gap-2 sa-card-d">
            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i><span class="lang-th">ติดต่อทีมวิศวกร</span><span class="lang-en">Contact Our Engineers</span>
          </a>
          <a href="<?php echo home_url('/service/'); ?>" class="sa-tap w-full sm:w-auto border border-white/20 hover:bg-white/10 hover:border-white/40 text-white svc-btn uppercase tracking-wider px-8 py-4 rounded-xl transition inline-flex items-center justify-center gap-2 sa-card-d">
            <i class="fa-solid fa-microchip" aria-hidden="true"></i><span class="lang-th">ขีดความสามารถวิศวกรรม</span><span class="lang-en">Engineering Capabilities</span>
          </a>
        </div>
      </div>
    </section>
  </main>

  <!-- FOOTER CONTAINER -->
  <div id="footer-container" class="bg-ink w-full block"></div>

  <!-- Scripts -->
  <script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/scripts.js') : './components/scripts.js'; ?>"></script>
  <script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/live-editor.js') : './components/live-editor.js'; ?>"></script>

<?php include __DIR__ . '/components/cookie-consent.php'; ?>
  <?php wp_footer(); ?>
</body>

</html>
