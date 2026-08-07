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

if (!function_exists('sa_picture')) {
    /**
     * A <picture> with a WebP srcset and the original file as the fallback.
     *
     * Why this exists rather than 15 hand-written <picture> blocks: every image
     * on this page needs the same four things and getting one of them wrong is
     * invisible until someone opens the page on a phone.
     *
     *  - WebP at three widths. The originals are 1350px wide and were being sent
     *    at full size to a 640px phone; the derivatives are generated in
     *    image/solutions/ as <base>-640/-960/-1350.webp.
     *  - width/height on the <img>. Without them the browser cannot reserve the
     *    box before the bytes arrive, and every card below jumps when it does
     *    (cumulative layout shift).
     *  - loading/decoding/fetchpriority. Exactly one image on a page should be
     *    eager with high priority: the one in the first screenful.
     *  - alt text that survives the language switch. alt is a plain attribute,
     *    so it cannot hold a lang-th/lang-en pair (AGENTS.md rule 4); these are
     *    written in English on purpose and describe the picture, not the copy.
     *
     * Note the fallback src still points at the .png original. Those files are
     * actually JPEGs with a .png extension - browsers sniff the content and do
     * not care, but do not assume the extension means anything here.
     */
    function sa_picture($base, $alt, $class, $sizes, $w, $h, $widths = array(640, 960, 1350), $eager = false) {
        $dir = get_template_directory_uri() . '/image/solutions/';
        $srcset = array();
        foreach ($widths as $x) {
            $srcset[] = $dir . $base . '-' . $x . '.webp ' . $x . 'w';
        }
        echo '<picture class="sa-pic">'
           . '<source type="image/webp" sizes="' . htmlspecialchars($sizes, ENT_QUOTES) . '" srcset="' . implode(', ', $srcset) . '">'
           . '<img src="' . $dir . $base . '.png"'
           . ' alt="' . htmlspecialchars($alt, ENT_QUOTES) . '"'
           . ' class="' . htmlspecialchars($class, ENT_QUOTES) . '"'
           . ' width="' . (int) $w . '" height="' . (int) $h . '"'
           . ($eager ? ' fetchpriority="high" decoding="async">' : ' loading="lazy" decoding="async">')
           . '</picture>';
    }
}
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
  <meta property="og:image:width" content="1350">
  <meta property="og:image:height" content="760">
  <meta property="og:image:alt" content="Rice fields with IoT sensor nodes">
  <meta property="og:url" content="<?php echo home_url('/smart-agriculture/'); ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:image" content="<?php echo $sa_img; ?>agri-hero-bg.png">

  <!-- The page is one document that swaps languages client-side rather than two
       URLs, so both hreflang values point here and x-default covers the rest. -->
  <link rel="alternate" hreflang="th" href="<?php echo home_url('/smart-agriculture/'); ?>">
  <link rel="alternate" hreflang="en" href="<?php echo home_url('/smart-agriculture/'); ?>">
  <link rel="alternate" hreflang="x-default" href="<?php echo home_url('/smart-agriculture/'); ?>">

  <!-- LCP. The hero image is the largest element in the first screenful, and a
       preload with imagesrcset lets the browser start it during head parsing at
       the width it will actually use, instead of waiting for layout. -->
  <link rel="preload" as="image" type="image/webp"
        href="<?php echo $sa_img; ?>agri-hero-bg-1350.webp"
        imagesrcset="<?php echo $sa_img; ?>agri-hero-bg-640.webp 640w, <?php echo $sa_img; ?>agri-hero-bg-960.webp 960w, <?php echo $sa_img; ?>agri-hero-bg-1350.webp 1350w"
        imagesizes="100vw" fetchpriority="high">
  <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

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
    /* body sets word-break: break-word, and short labels in narrow grid cells are
       exactly where that bites: "Temp/Humidity" rendered as "Temp/Hu / midity"
       and "HandySense" as "HandySe / nse". Labels break between words or not at
       all. */
    .svc-metric, .svc-btn, .svc-label, .svc-kicker {
      word-break: normal !important;
      overflow-wrap: break-word;
      hyphens: none;
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
    /* ---- Engine cards -------------------------------------------------
       Five cards whose Thai titles run to one or two lines, and whose
       descriptions run to three or four. Without a floor on each, every card
       started its rule and its capability list at a different height - the row
       read as five loose columns rather than one comparison. em, not px, so the
       floors track the font size instead of breaking at the next breakpoint.
       2.8em = two lines of svc-label at 1.4; 7.2em = four lines of svc-caption
       at 1.8. */
    .sa-eng-card { display: flex; flex-direction: column; height: 100%; }

    /* Row-for-row alignment across the five cards. The icon, number, name, Thai
       title, description and capability list each sit in a shared row track, so
       a title that wraps to two lines or a list with five items instead of four
       cannot knock the neighbouring cards out of step. Card 4's description runs
       to eight lines at 252px and card 5's to five - min-heights would have been
       a pixel guess that breaks at the next breakpoint; subgrid measures. */
    @supports (grid-template-rows: subgrid) {
      @media (min-width: 1024px) {
        .sa-eng-grid { grid-template-rows: repeat(6, auto); }
        .sa-eng-card {
          display: grid;
          grid-row: span 6;
          grid-template-rows: subgrid;
        }
      }
    }

    /* Fallback where subgrid is missing: floors on the two variable blocks get
       most of the way there. em, not px, so they track the font size. */
    @supports not (grid-template-rows: subgrid) {
      @media (min-width: 1024px) {
        .sa-eng-title { min-height: 2.8em; }
        .sa-eng-desc  { min-height: 9em; }
      }
    }


    /* The navbar is position:fixed at 80px and the section sub-nav sticks
       directly under it at 49px, so an anchor jump has 129px of chrome to clear.
       Measured: at the old 100px the target section landed 29px behind the
       sub-nav. 140px leaves a small breathing gap on top. */
    /* !important because components/style.css already declares scroll-margin-top
       with !important; without it ours computed to 96px and the section still
       landed 33px behind the sub-nav. */
    [id] { scroll-margin-top: 140px !important; }


    /* Every tap target reaches 44px. The source page's pill buttons were 40px
       on a phone once the padding collapsed. */
    .sa-tap { min-height: 48px; }

    /* <picture> is an inline element, so inside the h-full image frames it left a
       descender gap under the photo and refused to stretch. */
    .sa-pic { display: block; width: 100%; height: 100%; }

    /* Tailwind's CDN build emits .sr-only when it sees the class, but this page
       depends on it for accessible names, so it is defined here too rather than
       left to a build step that could be swapped out later. */
    .sr-only {
      position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px;
      overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border-width: 0;
    }

    /* ==========================================================================
       FOCUS

       Tailwind's preflight removes the browser's default outline, and nothing on
       this page put one back, so keyboard users had no visible caret at all.
       :focus-visible only paints for keyboard/AT focus, never on mouse click. */
    :focus-visible {
      outline: 3px solid #F2C72E;
      outline-offset: 3px;
      border-radius: 4px;
    }
    .bg-ink :focus-visible, .sa-subnav :focus-visible { outline-color: #F2C72E; }

    /* Skip link: hidden until focused, then pinned above everything. Without it
       a keyboard user tabs through the whole navbar on every page. */
    .sa-skip {
      position: absolute; left: 1rem; top: -100px; z-index: 100;
      background: #0B1F16; color: #fff; padding: 0.75rem 1.25rem; border-radius: 0.75rem;
      transition: top 160ms ease;
    }
    .sa-skip:focus { top: 1rem; }

    /* ==========================================================================
       SECTION SUB-NAV

       Five numbered sections is enough that a reader who lands mid-page has no
       idea what else exists. The bar sticks under the fixed 80px navbar and
       scrolls sideways on a phone rather than wrapping to two rows. */
    .sa-subnav {
      position: sticky; top: 80px; z-index: 40;
      backdrop-filter: blur(12px);
      background: rgba(255, 255, 255, 0.88);
      border-bottom: 1px solid rgba(11, 31, 22, 0.07);
    }
    .sa-subnav ol {
      display: flex; gap: 0.25rem; overflow-x: auto; scrollbar-width: none;
      -webkit-overflow-scrolling: touch;
    }
    .sa-subnav ol::-webkit-scrollbar { display: none; }
    .sa-subnav a {
      display: flex; align-items: center; white-space: nowrap;
      min-height: 48px; padding: 0 0.9rem; border-radius: 0.75rem;
      color: #5C6E65; transition: color 200ms ease, background-color 200ms ease;
    }
    .sa-subnav a:hover { color: #1F6B43; background: #E9F2EC; }
    .sa-subnav a[aria-current="true"] { color: #1F6B43; background: #E9F2EC; }
    .sa-subnav a[aria-current="true"] .sa-subnav-dot { opacity: 1; }
    .sa-subnav-dot {
      width: 6px; height: 6px; border-radius: 999px; background: #1F6B43;
      margin-right: 0.5rem; opacity: 0; transition: opacity 200ms ease;
    }

    /* ==========================================================================
       SCROLL REVEAL

       Opt-in, not opt-out: the hidden state is applied only once JS has set
       data-reveal on <html>. If the script never runs - blocked, error, old
       browser - the content is simply visible, which is the whole point. It is
       also skipped entirely when the reader asked for less motion. */
    @media (prefers-reduced-motion: no-preference) {
      html[data-reveal] .sa-reveal {
        opacity: 0;
        transform: translateY(18px);
        transition: opacity 600ms cubic-bezier(0.16, 1, 0.3, 1), transform 600ms cubic-bezier(0.16, 1, 0.3, 1);
      }
      html[data-reveal] .sa-reveal.is-in { opacity: 1; transform: none; }
    }

    @media (prefers-reduced-motion: reduce) {
      .sa-spring, .transition, [class*="transition-"] { transition: none !important; }
      .animate-pulse, .animate-bounce { animation: none !important; }
      .sa-subnav { position: static; }
    }

    /* Printing a spec page is a real thing sales teams do: drop the decoration
       and keep the content. */
    @media print {
      .sa-subnav, #navbar-container, #footer-container, .sa-skip { display: none !important; }
      .sa-reveal { opacity: 1 !important; transform: none !important; }
      section { page-break-inside: avoid; }
      .bg-ink, .bg-brand-deep { background: #fff !important; color: #000 !important; }
    }
  </style>

  <script>
    window.wpThemeUrl = "<?php echo get_template_directory_uri(); ?>/";
    window.wpThemeUri = "<?php echo get_template_directory_uri(); ?>/";
  </script>
  <?php wp_head(); ?>
</head>

<body id="top" <?php body_class("bg-[#F8FAF9] text-body antialiased"); ?>>
  <a class="sa-skip svc-btn" href="#main-content"><span class="lang-th">ข้ามไปยังเนื้อหาหลัก</span><span class="lang-en">Skip to main content</span></a>

  <!-- NAVBAR CONTAINER -->
  <div id="navbar-container"></div>

  <main id="main-content">

    <!-- HERO -->
    <section id="agri-hero" aria-labelledby="agri-hero-title" class="relative bg-ink text-white py-20 sm:py-28 lg:py-32 overflow-hidden flex items-center">
      <div class="absolute inset-0">
        <?php sa_picture('agri-hero-bg', 'Rice fields with IoT sensor nodes and a farmer using a tablet', 'w-full h-full object-cover', '100vw', 1350, 760, array(640, 960, 1350), true); ?>
      </div>
      <div class="absolute inset-0 bg-gradient-to-r from-[rgba(3,12,8,0.88)] via-[rgba(3,12,8,0.62)] to-[rgba(3,12,8,0.22)]" aria-hidden="true"></div>
      <div class="absolute inset-0 bg-gradient-to-t from-[rgba(3,12,8,0.55)] to-transparent" aria-hidden="true"></div>

      <div class="max-w-7xl mx-auto px-5 sm:px-6 relative z-10 w-full">
        <div class="inline-flex items-center gap-2.5 mb-7 bg-white/5 border border-white/10 px-4 sm:px-5 py-2 rounded-full backdrop-blur-md sa-card-d">
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse" aria-hidden="true"></span>
          <span class="text-white/90 svc-kicker"><span class="lang-th">SMART AGRICULTURE</span><span class="lang-en">SMART AGRICULTURE</span></span>
        </div>
        <h1 data-editable="agri-hero-h1-1" <?php echo synergy_style('agri-hero-h1-1', 'smart-agriculture'); ?> id="agri-hero-title" class="font-display svc-h1 text-white tracking-tight mb-4"><?php echo synergy_content('agri-hero-h1-1', '<span class="lang-th">ขับเคลื่อน<span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-brand to-gold-bright">การเกษตรอัจฉริยะ</span>ของคุณ</span><span class="lang-en">Powering Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-brand to-gold-bright">Smart Agriculture</span></span>', 'smart-agriculture'); ?></h1>
        <p data-editable="agri-hero-sub" <?php echo synergy_style('agri-hero-sub', 'smart-agriculture'); ?> class="svc-h3 font-display text-brand-bright mb-5"><?php echo synergy_content('agri-hero-sub', '<span class="lang-th">แพลตฟอร์มเดียวเพื่อการบริหารจัดการเกษตรแม่นยำ</span><span class="lang-en">One Platform for Precision Agriculture Management</span>', 'smart-agriculture'); ?></p>
        <p data-editable="agri-hero-p-1" <?php echo synergy_style('agri-hero-p-1', 'smart-agriculture'); ?> class="svc-copy text-white/80 max-w-3xl mb-10"><?php echo synergy_content('agri-hero-p-1', '<span class="lang-th">เชื่อมต่อข้อมูลจากเซนเซอร์ อุปกรณ์ IoT และระบบการเกษตรไว้ในแพลตฟอร์มเดียว เพื่อการติดตาม วิเคราะห์ และบริหารจัดการฟาร์มแบบ Real-time ช่วยเพิ่มผลผลิต ลดต้นทุน และใช้ทรัพยากรได้อย่างมีประสิทธิภาพ</span><span class="lang-en">Connect agricultural sensors, IoT devices, and farm operations into a single platform for real-time monitoring, analytics, and precision farm management—helping improve productivity, reduce costs, and optimize resource utilization.</span>', 'smart-agriculture'); ?></p>
        <div class="flex">
          <a href="<?php echo home_url('/'); ?>#contact" class="sa-tap bg-brand hover:bg-brand-deep text-white svc-btn uppercase tracking-wider px-8 py-4 rounded-xl transition shadow-lg shadow-brand/20 inline-flex items-center justify-center gap-2 sa-card-d">
            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i><span class="lang-th">ปรึกษาโครงการ</span><span class="lang-en">Talk to Our Experts</span>
          </a>
        </div>
      </div>
    </section>

    <!-- TRUSTED BY AGRICULTURE INNOVATORS -->
    <?php $agri_logos = synergy_list('agri-logos', array(), 'smart-agriculture'); ?>
    <?php if (!empty($agri_logos)): ?>
    <section id="agri-leaders" aria-labelledby="agri-leaders-title" class="py-12 sm:py-16 bg-white border-y border-slate-200/70">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="text-center mb-10 sm:mb-12 sa-reveal">
          <div class="inline-flex items-center gap-3 justify-center mb-4">
            <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
            <span class="text-brand svc-kicker"><span class="lang-th">ได้รับความไว้วางใจด้าน Smart Agriculture</span><span class="lang-en">TRUSTED FOR SMART AGRICULTURE</span></span>
          </div>
          <h2 data-editable="agri-leaders-h2-1" <?php echo synergy_style('agri-leaders-h2-1', 'smart-agriculture'); ?> id="agri-leaders-title" class="font-display svc-h2 text-ink tracking-tight"><?php echo synergy_content('agri-leaders-h2-1', '<span class="lang-th">ได้รับความไว้วางใจจากองค์กรด้านการเกษตร</span><span class="lang-en">Trusted by Agriculture Innovators</span>', 'smart-agriculture'); ?></h2>
        </div>

        <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6 max-w-4xl mx-auto"
             data-editable-list="agri-logos"
             data-list-label="โลโก้องค์กรด้านการเกษตร">
          <?php foreach ($agri_logos as $logo): ?>
          <div class="h-20 sm:h-24 w-[45%] sm:w-56 bg-white rounded-2xl border border-slate-200/70 shadow-[0_2px_10px_rgba(0,0,0,0.04)] flex items-center justify-center px-5 sm:px-7 hover:-translate-y-1 hover:shadow-md transition-all duration-300" data-list-item>
            <img loading="lazy" decoding="async" src="<?php echo esc_url(synergy_media_url($logo['src'])); ?>" alt="<?php echo esc_attr($logo['alt']); ?>" class="max-h-11 sm:max-h-14 w-auto max-w-full object-contain">
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <!-- AGRICULTURE CHALLENGES -->
    <section id="agri-challenges" aria-labelledby="agri-challenges-title" class="py-12 sm:py-16 bg-surface">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 sa-reveal">
          <div class="inline-flex items-center gap-3 justify-center mb-4">
            <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
            <span class="text-brand svc-kicker"><span class="lang-th">ความท้าทายด้านการเกษตร</span><span class="lang-en">AGRICULTURE CHALLENGES</span></span>
          </div>
          <h2 data-editable="agri-challenges-h2-1" <?php echo synergy_style('agri-challenges-h2-1', 'smart-agriculture'); ?> id="agri-challenges-title" class="font-display svc-h2 text-ink tracking-tight mb-5"><?php echo synergy_content('agri-challenges-h2-1', '<span class="lang-th">ปัญหาที่เราช่วยคุณแก้ไข</span><span class="lang-en">Challenges We Help You Solve</span>', 'smart-agriculture'); ?></h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-6 gap-5 sm:gap-6 items-stretch">
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center">
            <div class="w-14 h-14 rounded-full bg-brand-soft text-brand flex items-center justify-center mb-4 shrink-0" aria-hidden="true">
              <i class="fa-solid fa-chart-line text-xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1 text-center">01</div>
            <h3 data-editable="agri-ch-h1" class="svc-label text-ink mb-2"><span class="lang-th">ผลผลิตไม่สม่ำเสมอ</span><span class="lang-en">Unpredictable Crop Yields</span></h3>
            <p class="svc-caption text-muted"><span class="lang-th">ผลผลิตได้รับผลกระทบจากสภาพอากาศและสภาพแวดล้อมที่ควบคุมได้ยาก</span><span class="lang-en">Crop growth is affected by weather and environmental conditions.</span></p>
          </div>
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center">
            <div class="w-14 h-14 rounded-full bg-brand-soft text-brand flex items-center justify-center mb-4 shrink-0" aria-hidden="true">
              <i class="fa-solid fa-droplet text-xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1 text-center">02</div>
            <h3 data-editable="agri-ch-h2" class="svc-label text-ink mb-2"><span class="lang-th">ใช้น้ำและทรัพยากรเกินความจำเป็น</span><span class="lang-en">High Water &amp; Resource Usage</span></h3>
            <p class="svc-caption text-muted"><span class="lang-th">การให้น้ำและใช้ทรัพยากรขาดข้อมูล ทำให้ต้นทุนสูง</span><span class="lang-en">Irrigation and resource usage are difficult to optimize.</span></p>
          </div>
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center">
            <div class="w-14 h-14 rounded-full bg-brand-soft text-brand flex items-center justify-center mb-4 shrink-0" aria-hidden="true">
              <i class="fa-solid fa-eye-slash text-xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1 text-center">03</div>
            <h3 data-editable="agri-ch-h3" class="svc-label text-ink mb-2"><span class="lang-th">มองไม่เห็นข้อมูลภาคสนามแบบ Real-time</span><span class="lang-en">Limited Field Visibility</span></h3>
            <p class="svc-caption text-muted"><span class="lang-th">ไม่สามารถติดตามข้อมูลจากแปลงปลูกได้ทันที ทำให้ตัดสินใจล่าช้า</span><span class="lang-en">Field conditions cannot be monitored in real time.</span></p>
          </div>
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center">
            <div class="w-14 h-14 rounded-full bg-brand-soft text-brand flex items-center justify-center mb-4 shrink-0" aria-hidden="true">
              <i class="fa-solid fa-map-location-dot text-xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1 text-center">04</div>
            <h3 data-editable="agri-ch-h4" class="svc-label text-ink mb-2"><span class="lang-th">บริหารหลายแปลงหรือหลายพื้นที่ได้ยาก</span><span class="lang-en">Managing Multiple Farms</span></h3>
            <p class="svc-caption text-muted"><span class="lang-th">ข้อมูลแต่ละพื้นที่แยกกัน ทำให้บริหารจัดการได้ยาก</span><span class="lang-en">Managing operations across multiple farms is inefficient.</span></p>
          </div>
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center">
            <div class="w-14 h-14 rounded-full bg-brand-soft text-brand flex items-center justify-center mb-4 shrink-0" aria-hidden="true">
              <i class="fa-solid fa-triangle-exclamation text-xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1 text-center">05</div>
            <h3 data-editable="agri-ch-h5" class="svc-label text-ink mb-2"><span class="lang-th">พบปัญหาล่าช้า</span><span class="lang-en">Delayed Problem Detection</span></h3>
            <p class="svc-caption text-muted"><span class="lang-th">ตรวจพบโรคพืช ศัตรูพืช หรืออุปกรณ์ขัดข้องไม่ทันเวลา</span><span class="lang-en">Pest, disease, or equipment issues are detected too late.</span></p>
          </div>
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center">
            <div class="w-14 h-14 rounded-full bg-brand-soft text-brand flex items-center justify-center mb-4 shrink-0" aria-hidden="true">
              <i class="fa-solid fa-brain text-xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1 text-center">06</div>
            <h3 data-editable="agri-ch-h6" class="svc-label text-ink mb-2"><span class="lang-th">ตัดสินใจจากประสบการณ์มากกว่าข้อมูล</span><span class="lang-en">Decisions Based on Guesswork</span></h3>
            <p class="svc-caption text-muted"><span class="lang-th">ขาดข้อมูลสนับสนุน ทำให้การวางแผนและตัดสินใจไม่แม่นยำ</span><span class="lang-en">Farming decisions rely on experience instead of real-time insights.</span></p>
          </div>
        </div>
      </div>
    </section>

    <!-- KEY FEATURES / 4 HIGHLIGHT CARDS -->
    <section id="agri-overview" aria-labelledby="agri-overview-title" class="py-12 sm:py-16 sa-mesh border-b border-slate-200/80">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="text-center max-w-3xl mx-auto mb-12 sa-reveal">
          <div class="inline-flex items-center gap-3 justify-center mb-4">
            <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
            <span class="text-brand svc-kicker"><span class="lang-th">จุดเด่นของระบบ</span><span class="lang-en">SYSTEM HIGHLIGHTS</span></span>
          </div>
          <h2 id="agri-overview-title" class="font-display svc-h2 text-ink tracking-tight mb-4">
            <span class="lang-th">บริหารจัดการการเกษตรได้อย่างครบวงจร</span>
            <span class="lang-en">Comprehensive Smart Agriculture Platform</span>
          </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1.5 sa-spring group sa-reveal flex flex-col">
            <div class="w-12 h-12 rounded-2xl bg-brand-soft text-brand flex items-center justify-center mb-4 group-hover:scale-105 sa-spring" aria-hidden="true">
              <i class="fa-solid fa-plug-circle-plus text-xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1">01</div>
            <h3 class="svc-label text-ink mb-2"><span class="lang-th">เชื่อมต่อทุกอุปกรณ์การเกษตร</span><span class="lang-en">Connect Any Device</span></h3>
            <p class="svc-caption text-muted"><span class="lang-th">เชื่อมต่อเซนเซอร์ สถานีอากาศ ระบบน้ำ โดรน กล้อง และอุปกรณ์การเกษตรหลากหลายผ่านแพลตฟอร์มเดียว</span><span class="lang-en">Connect sensors, weather stations, irrigation systems, drones, cameras, and other agricultural devices through one platform.</span></p>
          </div>

          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1.5 sa-spring group sa-reveal flex flex-col">
            <div class="w-12 h-12 rounded-2xl bg-brand-soft text-brand flex items-center justify-center mb-4 group-hover:scale-105 sa-spring" aria-hidden="true">
              <i class="fa-solid fa-gauge-high text-xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1">02</div>
            <h3 class="svc-label text-ink mb-2"><span class="lang-th">บริหารทุกแปลงจากศูนย์กลาง</span><span class="lang-en">Manage Every Farm</span></h3>
            <p class="svc-caption text-muted"><span class="lang-th">ติดตามข้อมูลจากหลายแปลง หลายฟาร์ม หรือหลายโครงการ ผ่าน Dashboard เดียวแบบ Real-time</span><span class="lang-en">Monitor multiple farms, plots, and agricultural projects in real time from one centralized dashboard.</span></p>
          </div>

          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1.5 sa-spring group sa-reveal flex flex-col">
            <div class="w-12 h-12 rounded-2xl bg-brand-soft text-brand flex items-center justify-center mb-4 group-hover:scale-105 sa-spring" aria-hidden="true">
              <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1">03</div>
            <h3 class="svc-label text-ink mb-2"><span class="lang-th">ติดตั้งได้ทุกสภาพแวดล้อม</span><span class="lang-en">Deploy Anywhere</span></h3>
            <p class="svc-caption text-muted"><span class="lang-th">รองรับการติดตั้งแบบ Cloud, On-Premise หรือ Hybrid ให้เหมาะกับทุกพื้นที่และโครงสร้างระบบ</span><span class="lang-en">Deploy on Cloud, On-Premise, or Hybrid to fit your infrastructure and connectivity.</span></p>
          </div>

          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1.5 sa-spring group sa-reveal flex flex-col">
            <div class="w-12 h-12 rounded-2xl bg-brand-soft text-brand flex items-center justify-center mb-4 group-hover:scale-105 sa-spring" aria-hidden="true">
              <i class="fa-solid fa-network-wired text-xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1">04</div>
            <h3 class="svc-label text-ink mb-2"><span class="lang-th">เชื่อมต่อทุกระบบ</span><span class="lang-en">Integrate Everything</span></h3>
            <p class="svc-caption text-muted"><span class="lang-th">เชื่อมต่อระบบบริหารฟาร์ม GIS แพลตฟอร์มสภาพอากาศ ERP และระบบอื่น ๆ ผ่าน Open API</span><span class="lang-en">Integrate with farm management systems, GIS, weather platforms, ERP, and third-party services through Open API.</span></p>
          </div>
        </div>
      </div>
    </section>

    <!-- THE SYNEXTA ENGINE -->
    <section id="agri-engine" aria-labelledby="agri-engine-title" class="py-12 sm:py-16 bg-white border-b border-slate-100">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 sa-reveal">
          <span class="inline-flex items-center gap-2 bg-brand-soft text-brand svc-kicker px-4 py-2 rounded-full mb-5">
            <i class="fa-solid fa-microchip" aria-hidden="true"></i>
            <span class="lang-th">THE SYNEXTA ENGINE</span><span class="lang-en">THE SYNEXTA ENGINE</span>
          </span>
          <h2 data-editable="agri-engine-h2" <?php echo synergy_style('agri-engine-h2', 'smart-agriculture'); ?> id="agri-engine-title" class="font-display svc-h2 text-ink tracking-tight mb-3"><?php echo synergy_content('agri-engine-h2', '<span class="lang-th">เปลี่ยนข้อมูลการเกษตรให้เป็นการตัดสินใจที่แม่นยำ</span><span class="lang-en">From Connected Data to Intelligent Decisions</span>', 'smart-agriculture'); ?></h2>
          <p data-editable="agri-engine-sub" <?php echo synergy_style('agri-engine-sub', 'smart-agriculture'); ?> class="svc-copy text-body"><?php echo synergy_content('agri-engine-sub', '<span class="lang-th">เชื่อมต่อ เก็บรวบรวม ควบคุม วิเคราะห์ และเพิ่มประสิทธิภาพการเกษตร ผ่านแพลตฟอร์มเดียว</span><span class="lang-en">Connect, collect, control, analyze, and optimize your farm operations through one intelligent platform.</span>', 'smart-agriculture'); ?></p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 sm:gap-6 items-stretch relative sa-eng-grid">
          <!-- 01 SYNC -->
          <div class="relative bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal sa-eng-card">
            <div class="hidden lg:flex items-center justify-center w-7 h-7 rounded-full bg-brand text-white absolute -right-4 top-24 z-20 border-2 border-white shadow" aria-hidden="true"><i class="fa-solid fa-chevron-right text-[10px]"></i></div>
            <div class="w-16 h-16 rounded-full bg-brand-soft text-brand flex items-center justify-center mx-auto mb-4 mt-1" aria-hidden="true">
              <i class="fa-solid fa-diagram-project text-2xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1 text-center">01</div>
            <h3 class="font-display svc-h3 text-ink tracking-tight mb-1 text-center">SYNC</h3>
            <div class="svc-label text-brand mb-4 sa-eng-title text-center"><span class="lang-th">เชื่อมต่อทุกแหล่งข้อมูล</span><span class="lang-en">Connect Everything</span></div>
            <p class="svc-caption text-muted mb-5 sa-eng-desc text-center"><span class="lang-th">เชื่อมต่อเซนเซอร์ อุปกรณ์ IoT สถานีอากาศ ระบบน้ำ โดรน และเครื่องมือการเกษตรไว้ในแพลตฟอร์มเดียว</span><span class="lang-en">Connect sensors, IoT devices, weather stations, irrigation systems, drones, and farm equipment into one platform.</span></p>
            <div class="border-t border-slate-100 pt-4 mt-auto">
              <p class="svc-caption text-body leading-relaxed">
                <span class="lang-th">เซนเซอร์สภาพแวดล้อม • สถานีอากาศ • ระบบน้ำ • โดรนและภาพถ่าย • เครื่องมือการเกษตร</span>
                <span class="lang-en">Environmental Sensors • Weather Station • Irrigation System • Drones &amp; Imaging • Farm Equipment</span>
              </p>
            </div>
          </div>

          <!-- 02 STREAM -->
          <div class="relative bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal sa-eng-card">
            <div class="hidden lg:flex items-center justify-center w-7 h-7 rounded-full bg-brand text-white absolute -right-4 top-24 z-20 border-2 border-white shadow" aria-hidden="true"><i class="fa-solid fa-chevron-right text-[10px]"></i></div>
            <div class="w-16 h-16 rounded-full bg-brand-soft text-brand flex items-center justify-center mx-auto mb-4 mt-1" aria-hidden="true">
              <i class="fa-solid fa-chart-line text-2xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1 text-center">02</div>
            <h3 class="font-display svc-h3 text-ink tracking-tight mb-1 text-center">STREAM</h3>
            <div class="svc-label text-brand mb-4 sa-eng-title text-center"><span class="lang-th">เก็บรวบรวมและติดตามข้อมูล</span><span class="lang-en">Collect &amp; Monitor</span></div>
            <p class="svc-caption text-muted mb-5 sa-eng-desc text-center"><span class="lang-th">ติดตามข้อมูลจากหลายแปลงหรือหลายฟาร์มแบบ Real-time ผ่าน Dashboard เดียว</span><span class="lang-en">Monitor real-time data from multiple farms and visualize operations through one centralized dashboard.</span></p>
            <div class="border-t border-slate-100 pt-4 mt-auto">
              <p class="svc-caption text-body leading-relaxed">
                <span class="lang-th">ข้อมูลแบบ Real-time • มุมมองหลายแปลง • แดชบอร์ดรวมศูนย์ • การแจ้งเตือน</span>
                <span class="lang-en">Real-time Data • Multi-farm View • Central Dashboard • Alerts</span>
              </p>
            </div>
          </div>

          <!-- 03 STEER -->
          <div class="relative bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal sa-eng-card">
            <div class="hidden lg:flex items-center justify-center w-7 h-7 rounded-full bg-brand text-white absolute -right-4 top-24 z-20 border-2 border-white shadow" aria-hidden="true"><i class="fa-solid fa-chevron-right text-[10px]"></i></div>
            <div class="w-16 h-16 rounded-full bg-brand-soft text-brand flex items-center justify-center mx-auto mb-4 mt-1" aria-hidden="true">
              <i class="fa-solid fa-sliders text-2xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1 text-center">03</div>
            <h3 class="font-display svc-h3 text-ink tracking-tight mb-1 text-center">STEER</h3>
            <div class="svc-label text-brand mb-4 sa-eng-title text-center"><span class="lang-th">ควบคุมและสั่งการอัตโนมัติ</span><span class="lang-en">Control &amp; Automate</span></div>
            <p class="svc-caption text-muted mb-5 sa-eng-desc text-center"><span class="lang-th">ควบคุมระบบน้ำ ปั๊ม วาล์ว แสงสว่าง และอุปกรณ์ภาคสนามอัตโนมัติตามเงื่อนไขที่กำหนด</span><span class="lang-en">Automate irrigation, pumps, valves, lighting, and field equipment based on configurable rules.</span></p>
            <div class="border-t border-slate-100 pt-4 mt-auto">
              <p class="svc-caption text-body leading-relaxed">
                <span class="lang-th">ควบคุมระบบน้ำ • ตั้งเวลา • สั่งงานระยะไกล • เชื่อมต่อระบบ</span>
                <span class="lang-en">Irrigation Control • Scheduling • Remote Control • System Integration</span>
              </p>
            </div>
          </div>

          <!-- 04 SOLVE -->
          <div class="relative bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal sa-eng-card">
            <div class="hidden lg:flex items-center justify-center w-7 h-7 rounded-full bg-brand text-white absolute -right-4 top-24 z-20 border-2 border-white shadow" aria-hidden="true"><i class="fa-solid fa-chevron-right text-[10px]"></i></div>
            <div class="w-16 h-16 rounded-full bg-brand-soft text-brand flex items-center justify-center mx-auto mb-4 mt-1" aria-hidden="true">
              <i class="fa-solid fa-brain text-2xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1 text-center">04</div>
            <h3 class="font-display svc-h3 text-ink tracking-tight mb-1 text-center">SOLVE</h3>
            <div class="svc-label text-brand mb-4 sa-eng-title text-center"><span class="lang-th">วิเคราะห์และเพิ่มประสิทธิภาพ</span><span class="lang-en">Analyze &amp; Improve</span></div>
            <p class="svc-caption text-muted mb-5 sa-eng-desc text-center"><span class="lang-th">เปลี่ยนข้อมูลการเกษตรให้เป็นข้อมูลเชิงลึก เพื่อเพิ่มผลผลิตและใช้ทรัพยากรอย่างมีประสิทธิภาพ</span><span class="lang-en">Turn farm data into actionable insights to improve productivity and optimize resource usage.</span></p>
            <div class="border-t border-slate-100 pt-4 mt-auto">
              <p class="svc-caption text-body leading-relaxed">
                <span class="lang-th">วิเคราะห์ด้วย AI • คาดการณ์ผลผลิต • การให้น้ำอัจฉริยะ • รายงานและ KPI</span>
                <span class="lang-en">AI Analytics • Yield Prediction • Smart Irrigation • Reports &amp; KPI</span>
              </p>
            </div>
          </div>

          <!-- 05 SAFE -->
          <div class="relative bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal sa-eng-card">
            <div class="w-16 h-16 rounded-full bg-brand-soft text-brand flex items-center justify-center mx-auto mb-4 mt-1" aria-hidden="true">
              <i class="fa-solid fa-shield-halved text-2xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1 text-center">05</div>
            <h3 class="font-display svc-h3 text-ink tracking-tight mb-1 text-center">SAFE</h3>
            <div class="svc-label text-brand mb-4 sa-eng-title text-center"><span class="lang-th">ปลอดภัยและเชื่อถือได้</span><span class="lang-en">Secure &amp; Reliable</span></div>
            <p class="svc-caption text-muted mb-5 sa-eng-desc text-center"><span class="lang-th">ปกป้องข้อมูลการเกษตรด้วยการกำหนดสิทธิ์ผู้ใช้งาน การสำรองข้อมูล บันทึกการใช้งาน และการติดตามสถานะระบบ</span><span class="lang-en">Secure your agricultural data with role-based access, backups, audit logs, and reliable system monitoring.</span></p>
            <div class="border-t border-slate-100 pt-4 mt-auto">
              <p class="svc-caption text-body leading-relaxed">
                <span class="lang-th">สิทธิ์ผู้ใช้งาน • สำรองข้อมูล • บันทึกการใช้งาน • ตรวจสอบสถานะระบบ</span>
                <span class="lang-en">Access Control • Backup • Audit Trail • System Health</span>
              </p>
            </div>
          </div>
        </div>

        <div class="mt-10 sm:mt-12 rounded-[24px] bg-surface border border-brand/10 px-6 py-6 sm:px-10 sm:py-7 flex items-center gap-5 sa-reveal">
          <span class="w-14 h-14 rounded-full bg-white text-brand flex items-center justify-center shrink-0 border border-brand/10" aria-hidden="true">
                <div class="p-2 hover:bg-surface rounded-xl transition flex flex-col items-center justify-center">
                  <div class="h-12 w-12 rounded overflow-hidden mb-2 bg-slate-50"><?php sa_picture('agri-icon-handysense', 'HandySense controller', 'w-full h-full object-cover', '96px', 96, 96, array(96, 192)); ?></div>
                  <div data-editable="agri-greenhouse-div-4" <?php echo synergy_style('agri-greenhouse-div-4', 'smart-agriculture'); ?> class="svc-metric text-ink"><?php echo synergy_content('agri-greenhouse-div-4', 'HandySense', 'smart-agriculture'); ?></div>
                </div>
                <div class="p-2 hover:bg-surface rounded-xl transition flex flex-col items-center justify-center">
                  <div class="h-12 w-12 rounded overflow-hidden mb-2 bg-slate-50"><?php sa_picture('agri-icon-platform', 'Platform dashboard', 'w-full h-full object-cover', '96px', 96, 96, array(96, 192)); ?></div>
                  <div data-editable="agri-greenhouse-div-5" <?php echo synergy_style('agri-greenhouse-div-5', 'smart-agriculture'); ?> class="svc-metric text-ink"><?php echo synergy_content('agri-greenhouse-div-5', 'Platform', 'smart-agriculture'); ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>



    <!-- CTA -->
    <!-- WHO IT IS FOR
         The page described the system at length without ever saying who it
         suits, so a reader had to work out "is this for me" on their own. The
         four groups are the application areas the IoT Solar Node section
         already lists - nothing new is claimed here. -->
    <section id="agri-audience" aria-labelledby="agri-audience-title" class="py-12 sm:py-16 bg-surface">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="text-center max-w-3xl mx-auto mb-12 sa-reveal">
          <div class="inline-flex items-center gap-3 justify-center mb-4">
            <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
            <span class="text-brand svc-kicker"><span class="lang-th">เหมาะกับใคร</span><span class="lang-en">Who It Is For</span></span>
          </div>
          <h2 data-editable="agri-audience-h2" <?php echo synergy_style('agri-audience-h2', 'smart-agriculture'); ?> id="agri-audience-title" class="font-display svc-h2 text-ink tracking-tight"><?php echo synergy_content('agri-audience-h2', '<span class="lang-th">ใช้ได้กับพื้นที่เกษตรแบบไหนบ้าง</span><span class="lang-en">Where This Works</span>', 'smart-agriculture'); ?></h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6 items-stretch">
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full">
            <div class="w-12 h-12 rounded-2xl bg-brand-soft text-brand flex items-center justify-center mb-4" aria-hidden="true"><i class="fa-solid fa-wheat-awn text-lg"></i></div>
            <h3 data-editable="agri-audience-h3-1" <?php echo synergy_style('agri-audience-h3-1', 'smart-agriculture'); ?> class="svc-label text-ink mb-2"><?php echo synergy_content('agri-audience-h3-1', '<span class="lang-th">แปลงนาข้าว</span><span class="lang-en">Rice Paddies</span>', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-audience-p-1" <?php echo synergy_style('agri-audience-p-1', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-audience-p-1', '<span class="lang-th">จัดการน้ำแบบ AWD เก็บข้อมูลระดับน้ำเพื่อยื่นคาร์บอนเครดิต</span><span class="lang-en">AWD water management with the water-level record a carbon credit claim needs.</span>', 'smart-agriculture'); ?></p>
          </div>
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full">
            <div class="w-12 h-12 rounded-2xl bg-brand-soft text-brand flex items-center justify-center mb-4" aria-hidden="true"><i class="fa-solid fa-warehouse text-lg"></i></div>
            <h3 data-editable="agri-audience-h3-2" <?php echo synergy_style('agri-audience-h3-2', 'smart-agriculture'); ?> class="svc-label text-ink mb-2"><?php echo synergy_content('agri-audience-h3-2', '<span class="lang-th">โรงเรือนอัจฉริยะ</span><span class="lang-en">Smart Greenhouses</span>', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-audience-p-2" <?php echo synergy_style('agri-audience-p-2', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-audience-p-2', '<span class="lang-th">ควบคุมอุณหภูมิ ความชื้น และการให้น้ำอัตโนมัติด้วย HandySense</span><span class="lang-en">Temperature, humidity and irrigation run themselves through HandySense.</span>', 'smart-agriculture'); ?></p>
          </div>
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full">
            <div class="w-12 h-12 rounded-2xl bg-brand-soft text-brand flex items-center justify-center mb-4" aria-hidden="true"><i class="fa-solid fa-carrot text-lg"></i></div>
            <h3 data-editable="agri-audience-h3-3" <?php echo synergy_style('agri-audience-h3-3', 'smart-agriculture'); ?> class="svc-label text-ink mb-2"><?php echo synergy_content('agri-audience-h3-3', '<span class="lang-th">แปลงเพาะปลูกผัก</span><span class="lang-en">Vegetable Plots</span>', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-audience-p-3" <?php echo synergy_style('agri-audience-p-3', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-audience-p-3', '<span class="lang-th">วัดแร่ธาตุ NPK และความชื้นในดิน ให้ปุ๋ยและน้ำตรงตามความต้องการของพืช</span><span class="lang-en">NPK and soil moisture readings so water and fertiliser match what the crop needs.</span>', 'smart-agriculture'); ?></p>
          </div>
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full">
            <div class="w-12 h-12 rounded-2xl bg-brand-soft text-brand flex items-center justify-center mb-4" aria-hidden="true"><i class="fa-solid fa-apple-whole text-lg"></i></div>
            <h3 data-editable="agri-audience-h3-4" <?php echo synergy_style('agri-audience-h3-4', 'smart-agriculture'); ?> class="svc-label text-ink mb-2"><?php echo synergy_content('agri-audience-h3-4', '<span class="lang-th">สวนผลไม้</span><span class="lang-en">Orchards</span>', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-audience-p-4" <?php echo synergy_style('agri-audience-p-4', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-audience-p-4', '<span class="lang-th">Sensor ไร้สายพลังงานแสงอาทิตย์ ครอบคลุมพื้นที่กว้างโดยไม่ต้องเดินสาย</span><span class="lang-en">Solar wireless sensors cover a wide area with no cabling to run.</span>', 'smart-agriculture'); ?></p>
          </div>
        </div>
      </div>
    </section>

    <section id="agri-cta" class="py-12 sm:py-16 bg-white" style="scroll-margin-top:96px">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="relative overflow-hidden rounded-[28px] px-6 py-10 sm:px-10 sm:py-14 lg:px-16 text-white"
             style="background:linear-gradient(135deg,#0d4636 0%,#093427 55%,#06261c 100%)">
          <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none z-0"></div>

          <div class="relative z-10 grid gap-8 lg:grid-cols-[1.35fr_auto] lg:items-center">
            <div>
              <p class="svc-kicker mb-3" style="color:#4ade80">
                <span class="lang-th">เริ่มต้นกับเรา</span>
                <span class="lang-en">GET STARTED</span>
              </p>
              <h2 data-editable="agri-cta-h2" <?php echo synergy_style('agri-cta-h2', 'smart-agriculture'); ?> class="svc-h2 font-display text-white"><?php echo synergy_content('agri-cta-h2', '<span class="lang-th">เริ่มต้นทำเกษตรแม่นยำสูง<br><span class="text-brand-bright">เพื่อยกระดับผลผลิตและวิถีคาร์บอนต่ำ</span></span>
                <span class="lang-en">Start Precision Farming<br><span class="text-brand-bright">For Better Yield and a Low-Carbon Path</span></span>', 'smart-agriculture'); ?></h2>
              <p data-editable="agri-cta-p" <?php echo synergy_style('agri-cta-p', 'smart-agriculture'); ?> class="svc-copy text-slate-200 mt-5 max-w-2xl"><?php echo synergy_content('agri-cta-p', '<span class="lang-th">ทีมวิศวกร IoT เกษตรอัจฉริยะของเราพร้อมให้คำปรึกษาและเข้าสำรวจพื้นที่จริง ตั้งแต่ติดตั้ง Sensor ไร้สายภาคสนาม จนถึงการเตรียมข้อมูลยื่นขอใบรับรองคาร์บอนเครดิต</span>
                <span class="lang-en">Our Smart Agri-IoT engineering team is ready to consult and assess your fields, from deploying wireless sensor nodes to preparing auditable carbon credit data.</span>', 'smart-agriculture'); ?></p>
            </div>

            <div class="flex flex-col sm:flex-row lg:flex-col gap-3 lg:gap-4 lg:min-w-[240px]">
              <a href="<?php echo home_url('/'); ?>#contact"
                 class="svc-btn sa-tap inline-flex items-center justify-center gap-2.5 bg-brand-bright text-white px-8 py-4 rounded-xl font-extrabold uppercase tracking-wider hover:bg-emerald-600 transition-all shadow-lg shadow-brand-bright/30 hover:-translate-y-0.5">
                <i class="fa-solid fa-comments"></i>
                <span class="lang-th">ปรึกษาผู้เชี่ยวชาญ</span>
                <span class="lang-en">Talk to Our Experts</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- FOOTER CONTAINER -->
  <div id="footer-container" class="bg-ink w-full block"></div>

  <!-- Scripts -->
  <script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/scripts.js') : './components/scripts.js'; ?>"></script>
  <script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/live-editor.js') : './components/live-editor.js'; ?>"></script>


  <script>
  /* Page behaviour, deliberately small and dependency-free.
     Everything here is an enhancement: with the script removed the page still
     reads and navigates. */
  (function () {
    'use strict';
    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---- Scroll reveal -------------------------------------------------
       The hidden state lives behind html[data-reveal], set here, so a reader
       whose JS never runs is never left with invisible content. */
    var revealables = Array.prototype.slice.call(document.querySelectorAll('.sa-reveal'));
    if (!reduced && 'IntersectionObserver' in window && revealables.length) {
      document.documentElement.setAttribute('data-reveal', '');

      var show = function (el) {
        if (el.classList.contains('is-in')) return;
        el.classList.add('is-in');
        revealObserver.unobserve(el);              // one-shot: no re-animation on scroll back
      };

      var revealObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) { if (entry.isIntersecting) show(entry.target); });
      }, { rootMargin: '0px 0px -12% 0px', threshold: 0.08 });
      revealables.forEach(function (el) { revealObserver.observe(el); });

      /* Safety sweep. IntersectionObserver samples asynchronously, so a fast
         flick or an anchor jump can carry an element past the viewport between
         two samples and it is then reported as "not intersecting" forever -
         measured here: the metrics banner and the three overview pillars stayed
         at opacity 0 after a scripted scroll to the bottom. This pass reveals
         anything the viewport has already passed, and is rAF-throttled so it
         costs one rect read per frame at most. */
      var sweepQueued = false;
      var sweep = function () {
        sweepQueued = false;
        for (var i = revealables.length - 1; i >= 0; i--) {
          var el = revealables[i];
          if (el.classList.contains('is-in')) { revealables.splice(i, 1); continue; }
          if (el.getBoundingClientRect().top < window.innerHeight) show(el);
        }
        if (!revealables.length) {                  // nothing left to watch
          window.removeEventListener('scroll', queueSweep);
          window.removeEventListener('resize', queueSweep);
        }
      };
      var queueSweep = function () {
        if (sweepQueued) return;
        sweepQueued = true;
        window.requestAnimationFrame(sweep);
      };
      window.addEventListener('scroll', queueSweep, { passive: true });
      window.addEventListener('resize', queueSweep);
      window.addEventListener('load', queueSweep);
      queueSweep();
    }

    /* ---- Sub-nav active state ------------------------------------------
       "Which section am I in" is decided by a line drawn just under the fixed
       navbar and the sticky sub-nav: the active section is the LAST one whose
       top has crossed it.

       The first version compared IntersectionObserver ratios instead, and it
       was wrong in three of five sections when measured - a tall section and a
       short one produce very different ratios for the same reading position, and
       entries for sections that had scrolled away stayed in the tally. Five
       getBoundingClientRect() reads per animation frame is cheap and exact. */
    var navLinks = Array.prototype.slice.call(document.querySelectorAll('.sa-subnav a[href^="#"]'));
    var navTargets = navLinks.map(function (a) { return document.getElementById(a.getAttribute('href').slice(1)); });
    if (navTargets.filter(Boolean).length) {
      var LINE = 150;                             // 80px navbar + 49px sub-nav + a little slack
      var activeHref = null;
      var syncQueued = false;
      var syncNav = function () {
        syncQueued = false;
        var current = null;
        for (var i = 0; i < navTargets.length; i++) {
          var el = navTargets[i];
          if (el && el.getBoundingClientRect().top <= LINE) current = navLinks[i].getAttribute('href');
        }
        /* Past the last section - the related/CTA blocks - keep the final entry
           marked rather than clearing the bar entirely. */
        if (!current && window.scrollY > 0) current = null;
        if (current === activeHref) return;       // nothing changed: no DOM writes
        activeHref = current;
        navLinks.forEach(function (a) {
          if (a.getAttribute('href') === current) { a.setAttribute('aria-current', 'true'); }
          else { a.removeAttribute('aria-current'); }
        });
      };
      var queueSync = function () {
        if (syncQueued) return;
        syncQueued = true;
        window.requestAnimationFrame(syncNav);
      };
      window.addEventListener('scroll', queueSync, { passive: true });
      window.addEventListener('resize', queueSync);
      queueSync();
    }

  })();
  </script>

<?php include __DIR__ . '/components/cookie-consent.php'; ?>
  <?php wp_footer(); ?>
</body>

</html>
