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
    <section id="agri-hero" aria-labelledby="agri-hero-title" class="relative bg-ink text-white py-24 sm:py-32 lg:py-40 overflow-hidden flex items-center">
      <!-- The hero art is a real <img>, not a CSS background. A background-image
           is discovered only after the stylesheet is parsed and cannot be
           preloaded, srcset-ed or given fetchpriority - and this image is the
           page's largest contentful paint. As an <img> it starts downloading
           from the preload in <head> at the right width for the viewport. The
           tint that used to be part of the gradient is now its own layer. -->
      <div class="absolute inset-0">
        <?php sa_picture('agri-hero-bg', 'Rice fields with IoT sensor nodes and a farmer using a tablet', 'w-full h-full object-cover', '100vw', 1350, 760, array(640, 960, 1350), true); ?>
      </div>
      <!-- One scrim, weighted to the left where the copy sits, instead of the
           four flat dark layers that were here. Those turned the rice field
           into a black rectangle on a page selling agriculture. Text contrast
           is measured against the darkest sampled pixel behind it, not
           assumed. -->
      <div class="absolute inset-0 bg-gradient-to-r from-[rgba(3,12,8,0.88)] via-[rgba(3,12,8,0.62)] to-[rgba(3,12,8,0.22)]" aria-hidden="true"></div>
      <div class="absolute inset-0 bg-gradient-to-t from-[rgba(3,12,8,0.55)] to-transparent" aria-hidden="true"></div>

      <div class="max-w-7xl mx-auto px-5 sm:px-6 relative z-10 w-full">
        <div class="inline-flex items-center gap-2.5 mb-7 bg-white/5 border border-white/10 px-4 sm:px-5 py-2 rounded-full backdrop-blur-md sa-card-d">
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse" aria-hidden="true"></span>
          <!-- Same Latin string in both languages: it is a product-technology
               label, not prose, and the switcher still needs a pair to act on. -->
          <span class="text-white/90 svc-kicker"><span class="lang-th">SMART AGRICULTURE</span><span class="lang-en">SMART AGRICULTURE</span></span>
        </div>
        <h1 data-editable="agri-hero-h1-1" <?php echo synergy_style('agri-hero-h1-1', 'smart-agriculture'); ?> id="agri-hero-title" class="font-display svc-h1 text-white tracking-tight mb-6"><?php echo synergy_content('agri-hero-h1-1', '<span class="lang-th">ขับเคลื่อน<span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-brand to-gold-bright">การเกษตรอัจฉริยะ</span>ของคุณ</span><span class="lang-en">Powering Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-brand to-gold-bright">Smart Agriculture</span></span>', 'smart-agriculture'); ?></h1>
        <p data-editable="agri-hero-sub" <?php echo synergy_style('agri-hero-sub', 'smart-agriculture'); ?> class="svc-h3 font-display text-brand-bright mb-5"><?php echo synergy_content('agri-hero-sub', '<span class="lang-th">แพลตฟอร์มเดียวเพื่อการบริหารจัดการเกษตรแม่นยำ</span><span class="lang-en">One Platform for Precision Agriculture Management</span>', 'smart-agriculture'); ?></p>
        <!-- svc-copy, not svc-lede: the deck adds a subheading above this line, and
             at svc-lede the paragraph measured 21.3px against the subheading's
             21.0px - the supporting text outranking the line it supports. -->
        <p data-editable="agri-hero-p-1" <?php echo synergy_style('agri-hero-p-1', 'smart-agriculture'); ?> class="svc-copy text-white/75 max-w-3xl mb-10"><?php echo synergy_content('agri-hero-p-1', '<span class="lang-th">เชื่อมต่อข้อมูลจากเซนเซอร์ อุปกรณ์ IoT และระบบการเกษตรไว้ในแพลตฟอร์มเดียว เพื่อการติดตาม วิเคราะห์ และบริหารจัดการฟาร์มแบบ Real-time ช่วยเพิ่มผลผลิต ลดต้นทุน และใช้ทรัพยากรได้อย่างมีประสิทธิภาพ</span><span class="lang-en">Connect agricultural sensors, IoT devices, and farm operations into a single platform for real-time monitoring, analytics, and precision farm management, helping improve productivity, reduce costs, and optimize resource utilization.</span>', 'smart-agriculture'); ?></p>
        <div class="flex">
          <a href="<?php echo home_url('/'); ?>#contact" class="sa-tap bg-brand hover:bg-brand-deep text-white svc-btn uppercase tracking-wider px-8 py-4 rounded-xl transition shadow-lg shadow-brand/20 inline-flex items-center justify-center gap-2 sa-card-d">
            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i><span class="lang-th">ปรึกษาโครงการ</span><span class="lang-en">Talk to Our Experts</span>
          </a>
        </div>
        <!-- Proof strip. Every figure here is already stated further down the
             page; the point is that nobody scrolls thirteen screens to find it.
             Inline in the hero, so it does not reinstate the metrics banner that
             was deliberately removed. -->
        <ul class="mt-9 flex flex-wrap items-center gap-x-8 gap-y-3 border-t border-white/15 pt-6 max-w-3xl">
          <li class="flex items-center gap-2.5 text-white/90">
            <i class="fa-solid fa-leaf text-gold-bright" aria-hidden="true"></i>
            <span class="svc-caption"><span class="lang-th">ลดก๊าซมีเทนด้วยวิธี AWD</span><span class="lang-en">Cuts methane with AWD</span></span>
          </li>
          <li class="flex items-center gap-2.5 text-white/90">
            <i class="fa-solid fa-battery-full text-gold-bright" aria-hidden="true"></i>
            <span class="svc-caption"><span class="lang-th">แบตเตอรี่ภาคสนามใช้ได้ถึง 10 ปี</span><span class="lang-en">Field battery up to 10 years</span></span>
          </li>
          <li class="flex items-center gap-2.5 text-white/90">
            <i class="fa-solid fa-file-shield text-gold-bright" aria-hidden="true"></i>
            <span class="svc-caption"><span class="lang-th">ข้อมูลพร้อมยื่น Carbon Credit</span><span class="lang-en">Carbon credit ready data</span></span>
          </li>
        </ul>
      </div>
    </section>



    <!-- TRUSTED BY AGRICULTURE INNOVATORS
         The logo row is a repeater (synergy_list), the same one the Smart
         Factory wall uses, so logos are added and reordered in the editor
         rather than in this file.

         It ships with an empty list because no agriculture customer logos exist
         in the repository yet, and the whole section is skipped while the list
         is empty. A heading with a blank space under it reads as a broken page;
         the moment a logo is added in the editor the section appears. -->
    <?php $agri_logos = synergy_list('agri-logos', array(), 'smart-agriculture'); ?>
    <?php if (!empty($agri_logos)): ?>
    <section id="agri-leaders" aria-labelledby="agri-leaders-title" class="py-16 sm:py-20 bg-white border-y border-slate-200/70">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="text-center mb-10 sm:mb-12 sa-reveal">
          <div class="inline-flex items-center gap-3 justify-center mb-4">
            <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
            <span class="text-brand svc-kicker"><span class="lang-th">ได้รับความไว้วางใจด้าน Smart Agriculture</span><span class="lang-en">Trusted for Smart Agriculture</span></span>
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
    <section id="agri-challenges" aria-labelledby="agri-challenges-title" class="py-20 sm:py-28 bg-surface">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 sa-reveal">
          <div class="inline-flex items-center gap-3 justify-center mb-4">
            <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
            <span class="text-brand svc-kicker"><span class="lang-th">ความท้าทายด้านการเกษตร</span><span class="lang-en">Agriculture Challenges We Solve</span></span>
          </div>
          <h2 data-editable="agri-challenges-h2-1" <?php echo synergy_style('agri-challenges-h2-1', 'smart-agriculture'); ?> id="agri-challenges-title" class="font-display svc-h2 text-ink tracking-tight mb-5"><?php echo synergy_content('agri-challenges-h2-1', '<span class="lang-th">ปัญหาที่เราช่วยคุณแก้ไข</span><span class="lang-en">Challenges We Help You Solve</span>', 'smart-agriculture'); ?></h2>
          <p data-editable="agri-challenges-p-0" <?php echo synergy_style('agri-challenges-p-0', 'smart-agriculture'); ?> class="svc-lede text-body mx-auto"><?php echo synergy_content('agri-challenges-p-0', '<span class="lang-th">เข้าใจปัญหาที่แท้จริงของเกษตรกร เราพร้อมช่วยให้คุณทำการเกษตรได้อย่างมีประสิทธิภาพและยั่งยืน</span><span class="lang-en">We understand the real challenges farmers face, and deliver solutions for smarter, more sustainable farming.</span>', 'smart-agriculture'); ?></p>
        </div>

        <!-- Six across only from 1536px. The reference layout puts all six in one
             row, but at this page's 1480px container that is about 228px a card,
             and Thai needs more width than Latin for the same legibility - the
             descriptions would break to five or six lines (AGENTS.md rule 3).
             One up on a phone, two on a tablet, three on a laptop, six on a wide
             monitor where the row genuinely fits. -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-6 gap-5 sm:gap-6 items-stretch">
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center">
            <div class="w-16 h-16 rounded-full bg-brand-soft text-brand flex items-center justify-center mb-5 shrink-0" aria-hidden="true">
              <i class="fa-solid fa-seedling text-2xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1">01</div>
            <h3 data-editable="agri-challenges-h3-1" <?php echo synergy_style('agri-challenges-h3-1', 'smart-agriculture'); ?> class="svc-label text-ink mb-2"><?php echo synergy_content('agri-challenges-h3-1', '<span class="lang-th">ผลผลิตไม่สม่ำเสมอ</span><span class="lang-en">Unpredictable Crop Yields</span>', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-challenges-p-1" <?php echo synergy_style('agri-challenges-p-1', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-challenges-p-1', '<span class="lang-th">ผลผลิตได้รับผลกระทบจากสภาพอากาศและสภาพแวดล้อมที่ควบคุมได้ยาก</span><span class="lang-en">Crop growth is affected by weather and environmental conditions.</span>', 'smart-agriculture'); ?></p>
          </div>
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center">
            <div class="w-16 h-16 rounded-full bg-brand-soft text-brand flex items-center justify-center mb-5 shrink-0" aria-hidden="true">
              <i class="fa-solid fa-droplet text-2xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1">02</div>
            <h3 data-editable="agri-challenges-h3-2" <?php echo synergy_style('agri-challenges-h3-2', 'smart-agriculture'); ?> class="svc-label text-ink mb-2"><?php echo synergy_content('agri-challenges-h3-2', '<span class="lang-th">ใช้น้ำและทรัพยากรเกินความจำเป็น</span><span class="lang-en">High Water &amp; Resource Usage</span>', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-challenges-p-2" <?php echo synergy_style('agri-challenges-p-2', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-challenges-p-2', '<span class="lang-th">การให้น้ำและใช้ทรัพยากรขาดข้อมูล ทำให้ต้นทุนสูง</span><span class="lang-en">Irrigation and resource usage are difficult to optimize.</span>', 'smart-agriculture'); ?></p>
          </div>
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center">
            <div class="w-16 h-16 rounded-full bg-brand-soft text-brand flex items-center justify-center mb-5 shrink-0" aria-hidden="true">
              <i class="fa-solid fa-tower-broadcast text-2xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1">03</div>
            <h3 data-editable="agri-challenges-h3-3" <?php echo synergy_style('agri-challenges-h3-3', 'smart-agriculture'); ?> class="svc-label text-ink mb-2"><?php echo synergy_content('agri-challenges-h3-3', '<span class="lang-th">มองไม่เห็นข้อมูลภาคสนามแบบ Real-time</span><span class="lang-en">Limited Field Visibility</span>', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-challenges-p-3" <?php echo synergy_style('agri-challenges-p-3', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-challenges-p-3', '<span class="lang-th">ไม่สามารถติดตามข้อมูลจากแปลงปลูกได้ทันที ทำให้ตัดสินใจล่าช้า</span><span class="lang-en">Field conditions cannot be monitored in real time.</span>', 'smart-agriculture'); ?></p>
          </div>
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center">
            <div class="w-16 h-16 rounded-full bg-brand-soft text-brand flex items-center justify-center mb-5 shrink-0" aria-hidden="true">
              <i class="fa-solid fa-map-location-dot text-2xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1">04</div>
            <h3 data-editable="agri-challenges-h3-4" <?php echo synergy_style('agri-challenges-h3-4', 'smart-agriculture'); ?> class="svc-label text-ink mb-2"><?php echo synergy_content('agri-challenges-h3-4', '<span class="lang-th">บริหารหลายแปลงหรือหลายพื้นที่ได้ยาก</span><span class="lang-en">Managing Multiple Farms</span>', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-challenges-p-4" <?php echo synergy_style('agri-challenges-p-4', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-challenges-p-4', '<span class="lang-th">ข้อมูลแต่ละพื้นที่แยกกัน ทำให้บริหารจัดการได้ยาก</span><span class="lang-en">Managing operations across multiple farms is inefficient.</span>', 'smart-agriculture'); ?></p>
          </div>
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center">
            <div class="w-16 h-16 rounded-full bg-brand-soft text-brand flex items-center justify-center mb-5 shrink-0" aria-hidden="true">
              <i class="fa-solid fa-bug text-2xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1">05</div>
            <h3 data-editable="agri-challenges-h3-5" <?php echo synergy_style('agri-challenges-h3-5', 'smart-agriculture'); ?> class="svc-label text-ink mb-2"><?php echo synergy_content('agri-challenges-h3-5', '<span class="lang-th">พบปัญหาล่าช้า</span><span class="lang-en">Delayed Problem Detection</span>', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-challenges-p-5" <?php echo synergy_style('agri-challenges-p-5', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-challenges-p-5', '<span class="lang-th">ตรวจพบโรคพืช ศัตรูพืช หรืออุปกรณ์ขัดข้องไม่ทันเวลา</span><span class="lang-en">Pest, disease, or equipment issues are detected too late.</span>', 'smart-agriculture'); ?></p>
          </div>
          <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center">
            <div class="w-16 h-16 rounded-full bg-brand-soft text-brand flex items-center justify-center mb-5 shrink-0" aria-hidden="true">
              <i class="fa-solid fa-chart-column text-2xl"></i>
            </div>
            <div class="svc-kicker text-brand mb-1">06</div>
            <h3 data-editable="agri-challenges-h3-6" <?php echo synergy_style('agri-challenges-h3-6', 'smart-agriculture'); ?> class="svc-label text-ink mb-2"><?php echo synergy_content('agri-challenges-h3-6', '<span class="lang-th">ตัดสินใจจากประสบการณ์มากกว่าข้อมูล</span><span class="lang-en">Decisions Based on Guesswork</span>', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-challenges-p-6" <?php echo synergy_style('agri-challenges-p-6', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-challenges-p-6', '<span class="lang-th">ขาดข้อมูลสนับสนุน ทำให้การวางแผนและตัดสินใจไม่แม่นยำ</span><span class="lang-en">Farming decisions rely on experience instead of real-time insights.</span>', 'smart-agriculture'); ?></p>
          </div>
        </div>
      </div>
    </section>

    <!-- 01 · OVERVIEW -->
    <section id="agri-overview" aria-labelledby="agri-overview-title" class="py-20 sm:py-28 lg:py-32 sa-mesh">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="grid lg:grid-cols-12 gap-10 lg:gap-16 items-start">

          <div class="lg:col-span-7 space-y-7">
            <div class="inline-flex items-center gap-3">
              <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
              <span class="text-brand svc-kicker"><span class="lang-th">01 · Smart Agriculture Platform</span><span class="lang-en">01 · Smart Agriculture Platform</span></span>
            </div>
            <h2 data-editable="agri-overview-h2-1" <?php echo synergy_style('agri-overview-h2-1', 'smart-agriculture'); ?> id="agri-overview-title" class="font-display svc-h2 text-ink tracking-tight"><?php echo synergy_content('agri-overview-h2-1', '
              <span class="lang-th">ก้าวสู่ระบบเกษตรกรรมแม่นยำสูง<br>จากแนวคิดสู่การใช้งานจริง</span>
              <span class="lang-en">Precision Agriculture<br>From Concept to Working Farm</span>
            ', 'smart-agriculture'); ?></h2>
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
              <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1.5 sa-spring group sa-reveal">
                <div class="w-11 h-11 rounded-2xl bg-brand-soft text-brand flex items-center justify-center mb-4 group-hover:scale-105 sa-spring" aria-hidden="true">
                  <i class="fa-solid fa-compass"></i>
                </div>
                <h3 data-editable="agri-overview-h3-1" <?php echo synergy_style('agri-overview-h3-1', 'smart-agriculture'); ?> class="svc-label text-ink mb-2"><?php echo synergy_content('agri-overview-h3-1', 'Precision Ag', 'smart-agriculture'); ?></h3>
                <p data-editable="agri-overview-p-1" <?php echo synergy_style('agri-overview-p-1', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-overview-p-1', '
                  <span class="lang-th">วิเคราะห์เฉพาะจุดเพื่อให้ปุ๋ยและน้ำตรงตามความต้องการของพืช</span>
                  <span class="lang-en">Plot-level analysis so water and fertiliser go exactly where the crop needs them.</span>
                ', 'smart-agriculture'); ?></p>
              </div>
              <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1.5 sa-spring group sa-reveal">
                <div class="w-11 h-11 rounded-2xl bg-brand-soft text-brand flex items-center justify-center mb-4 group-hover:scale-105 sa-spring" aria-hidden="true">
                  <i class="fa-solid fa-cloud-sun"></i>
                </div>
                <h3 data-editable="agri-overview-h3-2" <?php echo synergy_style('agri-overview-h3-2', 'smart-agriculture'); ?> class="svc-label text-ink mb-2"><?php echo synergy_content('agri-overview-h3-2', 'Micro Weather', 'smart-agriculture'); ?></h3>
                <p data-editable="agri-overview-p-2" <?php echo synergy_style('agri-overview-p-2', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-overview-p-2', '
                  <span class="lang-th">ตรวจจับอุณหภูมิ ความชื้น แสงสว่าง และปริมาณฝนเฉพาะแปลง</span>
                  <span class="lang-en">Per-plot temperature, humidity, light and rainfall readings.</span>
                ', 'smart-agriculture'); ?></p>
              </div>
              <div class="bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1.5 sa-spring group sa-reveal">
                <div class="w-11 h-11 rounded-2xl bg-brand-soft text-brand flex items-center justify-center mb-4 group-hover:scale-105 sa-spring" aria-hidden="true">
                  <i class="fa-solid fa-tower-broadcast"></i>
                </div>
                <h3 data-editable="agri-overview-h3-3" <?php echo synergy_style('agri-overview-h3-3', 'smart-agriculture'); ?> class="svc-label text-ink mb-2"><?php echo synergy_content('agri-overview-h3-3', 'LPWAN IoT', 'smart-agriculture'); ?></h3>
                <p data-editable="agri-overview-p-3" <?php echo synergy_style('agri-overview-p-3', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-overview-p-3', '
                  <span class="lang-th">เครือข่ายไร้สายระยะไกล ครอบคลุมแปลงเกษตรขนาดใหญ่</span>
                  <span class="lang-en">Long-range wireless coverage across large farming areas.</span>
                ', 'smart-agriculture'); ?></p>
              </div>
            </div>
          </div>

          <!-- System graphic -->
          <div class="lg:col-span-5 relative mt-2 lg:mt-0">
            <div class="relative rounded-[28px] sm:rounded-[32px] overflow-hidden bg-slate-50 sa-card shadow-2xl h-64 sm:h-80">
              <?php sa_picture('agri-aiot-lpwan-system', 'AIoT LPWAN system architecture', 'w-full h-full object-cover', '(min-width:1024px) 40vw, 100vw', 1350, 1013); ?>
              <div class="absolute bottom-4 left-4 right-4 sm:bottom-6 sm:left-6 sm:right-6 bg-brand-deep/90 backdrop-blur-md p-4 sm:p-5 rounded-2xl border border-white/10 text-white">
                <div class="svc-kicker text-gold-bright mb-1"><span class="lang-th">AIoT LPWAN System</span><span class="lang-en">AIoT LPWAN System</span></div>
                <div data-editable="agri-overview-div-1" <?php echo synergy_style('agri-overview-div-1', 'smart-agriculture'); ?> class="svc-label"><?php echo synergy_content('agri-overview-div-1', '
                  <span class="lang-th">Sensor ภาคสนาม → Cloud → Dashboard แบบ Real-time</span>
                  <span class="lang-en">Field Sensors → Cloud → Real-time Dashboard</span>
                ', 'smart-agriculture'); ?></div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- THE SYNEXTA ENGINE
         Five-step flow, the same shape smart-energy.php uses for SYNC / STREAM /
         STEER / SOLVE / SAFE. Five across only from lg; below that the Thai
         copy needs the width (AGENTS.md rule 3). -->
    <section id="agri-engine" aria-labelledby="agri-engine-title" class="py-20 sm:py-28 bg-white border-y border-slate-100">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 sa-reveal">
          <span class="inline-flex items-center gap-2 bg-brand-soft text-brand svc-kicker px-4 py-2 rounded-full mb-5">
            <i class="fa-solid fa-seedling" aria-hidden="true"></i>
            <span class="lang-th">THE SYNEXTA ENGINE</span><span class="lang-en">THE SYNEXTA ENGINE</span>
          </span>
          <h2 data-editable="agri-engine-h2" <?php echo synergy_style('agri-engine-h2', 'smart-agriculture'); ?> id="agri-engine-title" class="font-display svc-h2 text-ink tracking-tight mb-3"><?php echo synergy_content('agri-engine-h2', '<span class="lang-th">เปลี่ยนข้อมูลการเกษตรให้เป็นการตัดสินใจที่แม่นยำ</span><span class="lang-en">From Connected Data to Intelligent Decisions</span>', 'smart-agriculture'); ?></h2>
          <p data-editable="agri-engine-sub" <?php echo synergy_style('agri-engine-sub', 'smart-agriculture'); ?> class="svc-copy text-body"><?php echo synergy_content('agri-engine-sub', '<span class="lang-th">เชื่อมต่อ เก็บรวบรวม ควบคุม วิเคราะห์ และเพิ่มประสิทธิภาพการเกษตร ผ่านแพลตฟอร์มเดียว</span><span class="lang-en">Connect, collect, control, analyze and optimize your farm operations through one smart platform.</span>', 'smart-agriculture'); ?></p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 sm:gap-6 items-stretch relative">
          <div class="relative bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col">
            <div class="hidden lg:flex items-center justify-center w-7 h-7 rounded-full bg-brand text-white absolute -right-4 top-24 z-20 border-2 border-white shadow" aria-hidden="true"><i class="fa-solid fa-chevron-right text-[10px]"></i></div>
            <div class="text-center">
              <div class="svc-kicker text-brand mb-1">01</div>
              <h3 class="font-display svc-h3 text-ink tracking-tight mb-1">SYNC</h3>
              <div data-editable="agri-engine-t-1" <?php echo synergy_style('agri-engine-t-1', 'smart-agriculture'); ?> class="svc-label text-brand mb-4"><?php echo synergy_content('agri-engine-t-1', '<span class="lang-th">เชื่อมต่อทุกแหล่งข้อมูล</span><span class="lang-en">Connect Everything</span>', 'smart-agriculture'); ?></div>
              <div class="w-16 h-16 rounded-full bg-brand-soft text-brand flex items-center justify-center mx-auto mb-4" aria-hidden="true">
                <i class="fa-solid fa-diagram-project text-2xl"></i>
              </div>
              <p data-editable="agri-engine-d-1" <?php echo synergy_style('agri-engine-d-1', 'smart-agriculture'); ?> class="svc-caption text-muted mb-5"><?php echo synergy_content('agri-engine-d-1', '<span class="lang-th">เชื่อมต่อเซนเซอร์ อุปกรณ์ IoT ด้านการเกษตร โดรน สถานีอากาศ และระบบฟาร์มต่างๆ ไว้ในแพลตฟอร์มเดียว</span><span class="lang-en">Bring agricultural sensors, IoT devices, drones, weather stations and farm systems into one platform.</span>', 'smart-agriculture'); ?></p>
            </div>
            <div class="mt-auto border-t border-slate-100 pt-4">
              <ul class="space-y-2.5 svc-caption text-body">
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-seedling text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">เซนเซอร์วัดสภาพแวดล้อม</span><span class="lang-en">Environmental Sensors</span></span></li>
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-cloud-sun text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">สถานีอากาศ</span><span class="lang-en">Weather Stations</span></span></li>
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-faucet-drip text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">ระบบน้ำและปั๊ม</span><span class="lang-en">Irrigation &amp; Pumps</span></span></li>
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-helicopter-symbol text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">โดรนและภาพถ่าย</span><span class="lang-en">Drones &amp; Imagery</span></span></li>
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-microchip text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">เครื่องจักรและอุปกรณ์ IoT</span><span class="lang-en">Machinery &amp; IoT Devices</span></span></li>
              </ul>
            </div>
          </div>
          <div class="relative bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col">
            <div class="hidden lg:flex items-center justify-center w-7 h-7 rounded-full bg-brand text-white absolute -right-4 top-24 z-20 border-2 border-white shadow" aria-hidden="true"><i class="fa-solid fa-chevron-right text-[10px]"></i></div>
            <div class="text-center">
              <div class="svc-kicker text-brand mb-1">02</div>
              <h3 class="font-display svc-h3 text-ink tracking-tight mb-1">STREAM</h3>
              <div data-editable="agri-engine-t-2" <?php echo synergy_style('agri-engine-t-2', 'smart-agriculture'); ?> class="svc-label text-brand mb-4"><?php echo synergy_content('agri-engine-t-2', '<span class="lang-th">เก็บรวบรวมและติดตามข้อมูล</span><span class="lang-en">Collect &amp; Monitor</span>', 'smart-agriculture'); ?></div>
              <div class="w-16 h-16 rounded-full bg-brand-soft text-brand flex items-center justify-center mx-auto mb-4" aria-hidden="true">
                <i class="fa-solid fa-chart-line text-2xl"></i>
              </div>
              <p data-editable="agri-engine-d-2" <?php echo synergy_style('agri-engine-d-2', 'smart-agriculture'); ?> class="svc-caption text-muted mb-5"><?php echo synergy_content('agri-engine-d-2', '<span class="lang-th">รวบรวมข้อมูลแบบ Real-time จากทุกแปลง ทุกฟาร์ม แสดงผลผ่าน Dashboard ให้เห็นภาพรวมได้ทันที</span><span class="lang-en">Gather real-time data from every plot and farm, and see it all on one dashboard.</span>', 'smart-agriculture'); ?></p>
            </div>
            <div class="mt-auto border-t border-slate-100 pt-4">
              <ul class="space-y-2.5 svc-caption text-body">
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-clock text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">ข้อมูลแบบ Real-time</span><span class="lang-en">Real-time Data</span></span></li>
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-layer-group text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">มุมมองหลายแปลง / หลายฟาร์ม</span><span class="lang-en">Multi-plot &amp; Multi-farm View</span></span></li>
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-desktop text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">แดชบอร์ดรวมศูนย์</span><span class="lang-en">Centralized Dashboard</span></span></li>
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-bell text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">การแจ้งเตือนอัตโนมัติ</span><span class="lang-en">Automatic Alerts</span></span></li>
              </ul>
            </div>
          </div>
          <div class="relative bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col">
            <div class="hidden lg:flex items-center justify-center w-7 h-7 rounded-full bg-brand text-white absolute -right-4 top-24 z-20 border-2 border-white shadow" aria-hidden="true"><i class="fa-solid fa-chevron-right text-[10px]"></i></div>
            <div class="text-center">
              <div class="svc-kicker text-brand mb-1">03</div>
              <h3 class="font-display svc-h3 text-ink tracking-tight mb-1">STEER</h3>
              <div data-editable="agri-engine-t-3" <?php echo synergy_style('agri-engine-t-3', 'smart-agriculture'); ?> class="svc-label text-brand mb-4"><?php echo synergy_content('agri-engine-t-3', '<span class="lang-th">ควบคุมและสั่งการอัตโนมัติ</span><span class="lang-en">Control &amp; Automate</span>', 'smart-agriculture'); ?></div>
              <div class="w-16 h-16 rounded-full bg-brand-soft text-brand flex items-center justify-center mx-auto mb-4" aria-hidden="true">
                <i class="fa-solid fa-sliders text-2xl"></i>
              </div>
              <p data-editable="agri-engine-d-3" <?php echo synergy_style('agri-engine-d-3', 'smart-agriculture'); ?> class="svc-caption text-muted mb-5"><?php echo synergy_content('agri-engine-d-3', '<span class="lang-th">ควบคุมระบบน้ำ ปั๊ม ปุ๋ย แสงสว่าง และอุปกรณ์ต่างๆ จากระยะไกล พร้อมตั้งค่าการทำงานอัตโนมัติตามเงื่อนไขที่กำหนด</span><span class="lang-en">Run irrigation, pumps, fertiliser and lighting remotely, with automation rules you define.</span>', 'smart-agriculture'); ?></p>
            </div>
            <div class="mt-auto border-t border-slate-100 pt-4">
              <ul class="space-y-2.5 svc-caption text-body">
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-droplet text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">ควบคุมระบบน้ำอัตโนมัติ</span><span class="lang-en">Automated Irrigation</span></span></li>
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-calendar-check text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">ตั้งเวลาและเงื่อนไขการทำงาน</span><span class="lang-en">Schedules &amp; Conditions</span></span></li>
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-tower-broadcast text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">สั่งงานระยะไกล</span><span class="lang-en">Remote Operation</span></span></li>
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-plug text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">เชื่อมต่อระบบภายนอก</span><span class="lang-en">External Integrations</span></span></li>
              </ul>
            </div>
          </div>
          <div class="relative bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col">
            <div class="hidden lg:flex items-center justify-center w-7 h-7 rounded-full bg-brand text-white absolute -right-4 top-24 z-20 border-2 border-white shadow" aria-hidden="true"><i class="fa-solid fa-chevron-right text-[10px]"></i></div>
            <div class="text-center">
              <div class="svc-kicker text-brand mb-1">04</div>
              <h3 class="font-display svc-h3 text-ink tracking-tight mb-1">SOLVE</h3>
              <div data-editable="agri-engine-t-4" <?php echo synergy_style('agri-engine-t-4', 'smart-agriculture'); ?> class="svc-label text-brand mb-4"><?php echo synergy_content('agri-engine-t-4', '<span class="lang-th">วิเคราะห์และเพิ่มประสิทธิภาพ</span><span class="lang-en">Analyze &amp; Improve</span>', 'smart-agriculture'); ?></div>
              <div class="w-16 h-16 rounded-full bg-brand-soft text-brand flex items-center justify-center mx-auto mb-4" aria-hidden="true">
                <i class="fa-solid fa-brain text-2xl"></i>
              </div>
              <p data-editable="agri-engine-d-4" <?php echo synergy_style('agri-engine-d-4', 'smart-agriculture'); ?> class="svc-caption text-muted mb-5"><?php echo synergy_content('agri-engine-d-4', '<span class="lang-th">วิเคราะห์ข้อมูลด้วย AI และแบบจำลองทางการเกษตร เพื่อคาดการณ์ วางแผน และเพิ่มผลผลิต ลดต้นทุนทรัพยากร</span><span class="lang-en">AI and agronomic models to forecast, plan, raise yield and cut resource cost.</span>', 'smart-agriculture'); ?></p>
            </div>
            <div class="mt-auto border-t border-slate-100 pt-4">
              <ul class="space-y-2.5 svc-caption text-body">
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-wand-magic-sparkles text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">วิเคราะห์ด้วย AI</span><span class="lang-en">AI Analysis</span></span></li>
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-chart-area text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">พยากรณ์ผลผลิตและความเสี่ยง</span><span class="lang-en">Yield &amp; Risk Forecasting</span></span></li>
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-flask text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">แผนการให้น้ำ/ปุ๋ยแม่นยำ</span><span class="lang-en">Precise Water &amp; Fertiliser Plans</span></span></li>
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-file-lines text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">รายงานและ KPI</span><span class="lang-en">Reports &amp; KPIs</span></span></li>
              </ul>
            </div>
          </div>
          <div class="relative bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col">
            <div class="text-center">
              <div class="svc-kicker text-brand mb-1">05</div>
              <h3 class="font-display svc-h3 text-ink tracking-tight mb-1">SAFE</h3>
              <div data-editable="agri-engine-t-5" <?php echo synergy_style('agri-engine-t-5', 'smart-agriculture'); ?> class="svc-label text-brand mb-4"><?php echo synergy_content('agri-engine-t-5', '<span class="lang-th">ปลอดภัยและเชื่อถือได้</span><span class="lang-en">Secure &amp; Reliable</span>', 'smart-agriculture'); ?></div>
              <div class="w-16 h-16 rounded-full bg-brand-soft text-brand flex items-center justify-center mx-auto mb-4" aria-hidden="true">
                <i class="fa-solid fa-shield-halved text-2xl"></i>
              </div>
              <p data-editable="agri-engine-d-5" <?php echo synergy_style('agri-engine-d-5', 'smart-agriculture'); ?> class="svc-caption text-muted mb-5"><?php echo synergy_content('agri-engine-d-5', '<span class="lang-th">ดูแลความปลอดภัยของข้อมูล สิทธิ์การเข้าถึง สำรองข้อมูล และรักษาความต่อเนื่องของระบบอย่างเชื่อถือได้</span><span class="lang-en">Protect the data, control who reaches it, back it up and keep the system running.</span>', 'smart-agriculture'); ?></p>
            </div>
            <div class="mt-auto border-t border-slate-100 pt-4">
              <ul class="space-y-2.5 svc-caption text-body">
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-user-shield text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">ควบคุมสิทธิ์การเข้าถึง</span><span class="lang-en">Access Control</span></span></li>
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-database text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">สำรองข้อมูลอัตโนมัติ</span><span class="lang-en">Automatic Backup</span></span></li>
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-clipboard-check text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">บันทึกการใช้งาน (Audit Trail)</span><span class="lang-en">Audit Trail</span></span></li>
                  <li class="flex items-center gap-2.5"><i class="fa-solid fa-heart-pulse text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">ตรวจสอบสุขภาพระบบ</span><span class="lang-en">System Health</span></span></li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Outcome band, the line the five steps add up to -->
        <div class="mt-10 sm:mt-12 rounded-[24px] bg-surface border border-brand/10 px-6 py-6 sm:px-10 sm:py-7 flex items-center gap-5 sa-reveal">
          <span class="w-14 h-14 rounded-full bg-white text-brand flex items-center justify-center shrink-0 border border-brand/10" aria-hidden="true">
            <i class="fa-solid fa-seedling text-2xl"></i>
          </span>
          <p data-editable="agri-engine-outcome" <?php echo synergy_style('agri-engine-outcome', 'smart-agriculture'); ?> class="svc-copy text-ink"><?php echo synergy_content('agri-engine-outcome', '<span class="lang-th">เพิ่ม<strong class="text-brand">ผลผลิต</strong> ลดต้นทุน ใช้ทรัพยากรอย่างมีประสิทธิภาพ และทำการเกษตรได้อย่างแม่นยำและยั่งยืน</span><span class="lang-en">Increase <strong class="text-brand">yield</strong>, reduce costs, use resources efficiently, and achieve sustainable precision agriculture.</span>', 'smart-agriculture'); ?></p>
        </div>
      </div>
    </section>

    <!-- 02 · DEVICES & TECHNOLOGY -->
    <section id="agri-devices" aria-labelledby="agri-devices-title" class="py-20 sm:py-28 lg:py-32 bg-white relative overflow-hidden">
      <div class="max-w-7xl mx-auto px-5 sm:px-6 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-14 sm:mb-20 sa-reveal">
          <div class="inline-flex items-center gap-3 justify-center mb-4">
            <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
            <span class="text-brand svc-kicker"><span class="lang-th">02 · Devices &amp; Technology</span><span class="lang-en">02 · Devices &amp; Technology</span></span>
          </div>
          <h2 data-editable="agri-devices-h2-1" <?php echo synergy_style('agri-devices-h2-1', 'smart-agriculture'); ?> id="agri-devices-title" class="font-display svc-h2 text-ink tracking-tight mb-5"><?php echo synergy_content('agri-devices-h2-1', '
            <span class="lang-th">เทคโนโลยีและอุปกรณ์ภาคสนาม</span>
            <span class="lang-en">Field Devices &amp; Technology</span>
          ', 'smart-agriculture'); ?></h2>
          <p data-editable="agri-devices-p-1" <?php echo synergy_style('agri-devices-p-1', 'smart-agriculture'); ?> class="svc-lede text-body max-w-2xl mx-auto"><?php echo synergy_content('agri-devices-p-1', '
            <span class="lang-th">การทำงานร่วมกันระหว่างฮาร์ดแวร์วัดค่า แหล่งจ่ายพลังงาน และซอฟต์แวร์บริหารจัดการข้อมูลแผนที่ระดับความแม่นยำสูง</span>
            <span class="lang-en">Measurement hardware, autonomous power and high-precision mapping software working as one system.</span>
          ', 'smart-agriculture'); ?></p>
        </div>

        <div class="grid lg:grid-cols-12 gap-10 lg:gap-12 items-center mb-14 sm:mb-16">
          <div class="lg:col-span-6 space-y-6 order-2 lg:order-1">
            <h3 data-editable="agri-devices-h3-1" <?php echo synergy_style('agri-devices-h3-1', 'smart-agriculture'); ?> class="font-display svc-h3 text-ink"><?php echo synergy_content('agri-devices-h3-1', 'Precision Farming Platform', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-devices-p-2" <?php echo synergy_style('agri-devices-p-2', 'smart-agriculture'); ?> class="svc-copy text-muted"><?php echo synergy_content('agri-devices-p-2', '
              <span class="lang-th">ซอฟต์แวร์ประมวลผลแผนที่แปลงนาและแปลงเกษตรแบบ Real-time เชื่อมต่อกับโดรนและสถานีวัดสภาพอากาศภายนอกได้ ช่วยคำนวณการใช้ทรัพยากร พลังงาน และการปล่อยคาร์บอนผ่านแอปพลิเคชันอย่างเป็นระบบ</span>
              <span class="lang-en">Real-time field mapping software that connects to drones and third-party weather stations, and accounts for resource use, energy and carbon emissions in one application.</span>
            ', 'smart-agriculture'); ?></p>
            <div class="grid sm:grid-cols-2 gap-4">
              <div class="p-5 bg-surface rounded-2xl border border-brand/5">
                <i class="fa-solid fa-solar-panel text-brand mb-2 block" aria-hidden="true"></i>
                <h4 data-editable="agri-devices-h4-1" <?php echo synergy_style('agri-devices-h4-1', 'smart-agriculture'); ?> class="svc-label text-ink mb-1"><?php echo synergy_content('agri-devices-h4-1', 'Solar Powered Nodes', 'smart-agriculture'); ?></h4>
                <p data-editable="agri-devices-p-3" <?php echo synergy_style('agri-devices-p-3', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-devices-p-3', '
                  <span class="lang-th">แผงโซลาร์เซลล์ 200W สำหรับ Gateway และ 80W สำหรับ Node พร้อมแบตเตอรี่ในตัว</span>
                  <span class="lang-en">200W panels for gateways and 80W for nodes, each with an onboard battery.</span>
                ', 'smart-agriculture'); ?></p>
              </div>
              <div class="p-5 bg-surface rounded-2xl border border-brand/5">
                <i class="fa-solid fa-temperature-empty text-brand mb-2 block" aria-hidden="true"></i>
                <h4 data-editable="agri-devices-h4-2" <?php echo synergy_style('agri-devices-h4-2', 'smart-agriculture'); ?> class="svc-label text-ink mb-1"><?php echo synergy_content('agri-devices-h4-2', 'Soil Sensors', 'smart-agriculture'); ?></h4>
                <p data-editable="agri-devices-p-4" <?php echo synergy_style('agri-devices-p-4', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-devices-p-4', '
                  <span class="lang-th">วัดแร่ธาตุ NPK อุณหภูมิ และความชื้นในดินได้ลึก 5 ระดับ</span>
                  <span class="lang-en">NPK, temperature and moisture readings across five soil depths.</span>
                ', 'smart-agriculture'); ?></p>
              </div>
            </div>
          </div>

          <div class="lg:col-span-6 order-1 lg:order-2">
            <div class="rounded-[28px] sm:rounded-[32px] overflow-hidden sa-card shadow-bento h-56 sm:h-72 lg:h-80">
              <?php sa_picture('agri-precision-farming-platform', 'Precision Farming Platform dashboard', 'w-full h-full object-cover', '(min-width:1024px) 45vw, 100vw', 1350, 1013); ?>
            </div>
          </div>
        </div>

        <!-- Spec bar -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
          <div class="bg-surface rounded-2xl p-6 sa-card hover:-translate-y-1 sa-spring sa-reveal">
            <span class="text-brand font-display svc-label block mb-2">IoT LoRaWAN Gateway</span>
            <p data-editable="agri-devices-p-5" <?php echo synergy_style('agri-devices-p-5', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-devices-p-5', '
              <span class="lang-th">เกตเวย์สื่อสารระยะไกล ใช้ Industrial Cellular Router ส่งข้อมูลขึ้นคลาวด์</span>
              <span class="lang-en">Long-range gateway using an industrial cellular router to reach the cloud.</span>
            ', 'smart-agriculture'); ?></p>
          </div>
          <div class="bg-surface rounded-2xl p-6 sa-card hover:-translate-y-1 sa-spring sa-reveal">
            <span class="text-brand font-display svc-label block mb-2">Solar Charger System</span>
            <p data-editable="agri-devices-p-6" <?php echo synergy_style('agri-devices-p-6', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-devices-p-6', '
              <span class="lang-th">บอร์ดบริหารพลังงานสำรอง แบตเตอรี่ 12.8V / 200Ah รองรับการทำงาน 365 วัน</span>
              <span class="lang-en">Power management board with a 12.8V / 200Ah battery rated for year-round duty.</span>
            ', 'smart-agriculture'); ?></p>
          </div>
          <div class="bg-surface rounded-2xl p-6 sa-card hover:-translate-y-1 sa-spring sa-reveal">
            <span class="text-brand font-display svc-label block mb-2">Soil NPK &amp; Moisture</span>
            <p data-editable="agri-devices-p-7" <?php echo synergy_style('agri-devices-p-7', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-devices-p-7', '
              <span class="lang-th">หัว Sensor สเตนเลส 316 ทนการกัดกร่อน วัดแร่ธาตุและการนำไฟฟ้าในดิน</span>
              <span class="lang-en">Corrosion-resistant 316 stainless probes measuring nutrients and soil conductivity.</span>
            ', 'smart-agriculture'); ?></p>
          </div>
          <div class="bg-surface rounded-2xl p-6 sa-card hover:-translate-y-1 sa-spring sa-reveal">
            <span class="text-brand font-display svc-label block mb-2">Light Sensor &amp; HMI Display</span>
            <p data-editable="agri-devices-p-8" <?php echo synergy_style('agri-devices-p-8', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-devices-p-8', '
              <span class="lang-th">จอแสดงผลหน้าตู้สนาม และ Sensor วัดความเข้มแสง Lux สำหรับการสังเคราะห์แสง</span>
              <span class="lang-en">Cabinet-front display plus a lux sensor for photosynthesis monitoring.</span>
            ', 'smart-agriculture'); ?></p>
          </div>
        </div>
      </div>
    </section>

    <!-- 03 · IOT SOLAR NODE 4G -->
    <section id="agri-solar-node" aria-labelledby="agri-solar-node-title" class="py-20 sm:py-28 lg:py-32 bg-surface relative">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="grid lg:grid-cols-12 gap-10 lg:gap-16 items-start">

          <div class="lg:col-span-5">
            <div class="rounded-[28px] sm:rounded-[32px] overflow-hidden sa-card shadow-bento h-56 sm:h-72 lg:h-80">
              <?php sa_picture('agri-iot-solar-node-4g', 'IoT Solar Node 4G field device', 'w-full h-full object-cover', '(min-width:1024px) 40vw, 100vw', 1350, 1013); ?>
            </div>
          </div>

          <div class="lg:col-span-7 space-y-7">
            <div class="inline-flex items-center gap-3">
              <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
              <span class="text-brand svc-kicker"><span class="lang-th">03 · IoT Field Device</span><span class="lang-en">03 · IoT Field Device</span></span>
            </div>
            <h2 data-editable="agri-solar-node-h2-1" <?php echo synergy_style('agri-solar-node-h2-1', 'smart-agriculture'); ?> id="agri-solar-node-title" class="font-display svc-h2 text-ink tracking-tight"><?php echo synergy_content('agri-solar-node-h2-1', 'IoT Solar Node 4G', 'smart-agriculture'); ?></h2>
            <p data-editable="agri-solar-node-p-1" <?php echo synergy_style('agri-solar-node-p-1', 'smart-agriculture'); ?> class="svc-copy text-body"><?php echo synergy_content('agri-solar-node-p-1', '
              <span class="lang-th">โหนด Sensor ภาคสนามระบบไฮบริด ออกแบบให้เป็นสถานีตรวจวัดและส่งข้อมูลแบบ Standalone ชาร์จแบตเตอรี่ในตัวจากแผงโซลาร์เซลล์ด้านบน ส่งสัญญาณไร้สายผ่านโครงข่าย 4G LTE ใช้งานได้ยาวนานถึง 10 ปีโดยไม่ต้องบำรุงรักษาเพิ่ม</span>
              <span class="lang-en">A hybrid field node built as a standalone measure-and-transmit station. It charges its own battery from the panel above and reports over 4G LTE, running up to ten years with no added maintenance.</span>
            ', 'smart-agriculture'); ?></p>

            <div class="grid sm:grid-cols-2 gap-6">
              <div class="space-y-4">
                <h3 data-editable="agri-solar-node-h3-1" <?php echo synergy_style('agri-solar-node-h3-1', 'smart-agriculture'); ?> class="svc-label text-ink"><?php echo synergy_content('agri-solar-node-h3-1', '<i class="fa-solid fa-list-check text-brand mr-2" aria-hidden="true"></i><span class="lang-th">ฟังก์ชันการทำงานหลัก</span><span class="lang-en">Core Functions</span>', 'smart-agriculture'); ?></h3>
                <ul class="space-y-3 svc-caption text-muted">
                  <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle text-[6px] text-brand mt-2 shrink-0" aria-hidden="true"></i><span><span class="lang-th">ทำงานเป็นเอกเทศด้วยโซลาร์เซลล์ชาร์จเจอร์</span><span class="lang-en">Runs autonomously on its solar charger.</span></span></li>
                  <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle text-[6px] text-brand mt-2 shrink-0" aria-hidden="true"></i><span><span class="lang-th">ส่งสัญญาณไร้สายผ่านเครือข่าย 4G LTE ขึ้นคลาวด์</span><span class="lang-en">Sends data to the cloud over 4G LTE.</span></span></li>
                  <li class="flex items-start gap-2.5"><i class="fa-solid fa-circle text-[6px] text-brand mt-2 shrink-0" aria-hidden="true"></i><span><span class="lang-th">มี Open API สำหรับนำข้อมูลไปใช้งานต่อ</span><span class="lang-en">Open API for downstream use of the data.</span></span></li>
                </ul>
              </div>
              <div class="space-y-4">
                <h3 data-editable="agri-solar-node-h3-2" <?php echo synergy_style('agri-solar-node-h3-2', 'smart-agriculture'); ?> class="svc-label text-ink"><?php echo synergy_content('agri-solar-node-h3-2', '<i class="fa-solid fa-crop text-brand mr-2" aria-hidden="true"></i><span class="lang-th">พื้นที่การประยุกต์ใช้งาน</span><span class="lang-en">Where It Is Used</span>', 'smart-agriculture'); ?></h3>
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
                <div data-editable="agri-solar-node-div-1" <?php echo synergy_style('agri-solar-node-div-1', 'smart-agriculture'); ?> class="svc-metric text-muted mt-1"><?php echo synergy_content('agri-solar-node-div-1', '<span class="lang-th">ใช้พลังงานสะอาด</span><span class="lang-en">Clean Energy</span>', 'smart-agriculture'); ?></div>
              </div>
              <div class="border-l border-gray-200 pl-4">
                <span class="font-display svc-num text-brand block">02</span>
                <div data-editable="agri-solar-node-div-2" <?php echo synergy_style('agri-solar-node-div-2', 'smart-agriculture'); ?> class="svc-metric text-muted mt-1"><?php echo synergy_content('agri-solar-node-div-2', '<span class="lang-th">เชื่อมต่อ Sensor ได้หลากหลาย</span><span class="lang-en">Multi-Sensor Ready</span>', 'smart-agriculture'); ?></div>
              </div>
              <div class="border-l border-gray-200 pl-4">
                <span class="font-display svc-num text-brand block">03</span>
                <div data-editable="agri-solar-node-div-3" <?php echo synergy_style('agri-solar-node-div-3', 'smart-agriculture'); ?> class="svc-metric text-muted mt-1"><?php echo synergy_content('agri-solar-node-div-3', '<span class="lang-th">ประหยัดค่าโครงสร้างพื้นฐาน</span><span class="lang-en">Lower Infrastructure Cost</span>', 'smart-agriculture'); ?></div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>

    <!-- 04 · SYNRICEWATER AWD / CARBON CREDIT -->
    <section id="agri-carbon" aria-labelledby="agri-carbon-title" class="py-20 sm:py-28 lg:py-32 bg-white relative">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="grid lg:grid-cols-12 gap-10 lg:gap-16 items-start">

          <div class="lg:col-span-5 space-y-5">
            <div class="rounded-3xl overflow-hidden shadow-lg border border-gray-100 aspect-[3/2]">
              <?php sa_picture('agri-synricewater-awd-1', 'SYNRiceWater AWD sensor in a rice field', 'w-full h-full object-cover', '(min-width:1024px) 40vw, 100vw', 1350, 1013); ?>
            </div>
            <div class="rounded-3xl overflow-hidden shadow-lg border border-gray-100 aspect-[3/2]">
              <?php sa_picture('agri-synricewater-awd-2', 'SYNRiceWater AWD network across rice paddies', 'w-full h-full object-cover', '(min-width:1024px) 40vw, 100vw', 1350, 1013); ?>
            </div>
          </div>

          <div class="lg:col-span-7 space-y-7">
            <div class="inline-flex items-center gap-3">
              <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
              <span class="text-brand svc-kicker"><span class="lang-th">04 · Carbon Credit System</span><span class="lang-en">04 · Carbon Credit System</span></span>
            </div>
            <h2 data-editable="agri-carbon-h2-1" <?php echo synergy_style('agri-carbon-h2-1', 'smart-agriculture'); ?> id="agri-carbon-title" class="font-display svc-h2 text-ink tracking-tight"><?php echo synergy_content('agri-carbon-h2-1', '
              SYNRiceWater AWD<br>
              <span class="text-brand"><span class="lang-th">ลดน้ำ ลดมีเทน เพิ่มรายได้จาก Carbon Credit</span><span class="lang-en">Less Water, Less Methane, More Carbon Credit</span></span>
            ', 'smart-agriculture'); ?></h2>
            <p data-editable="agri-carbon-p-1" <?php echo synergy_style('agri-carbon-p-1', 'smart-agriculture'); ?> class="svc-copy text-body"><?php echo synergy_content('agri-carbon-p-1', '
              <span class="lang-th">การทำนาข้าวแบบน้ำขังเป็นแหล่งกำเนิดหลักของก๊าซมีเทน ซึ่งมีฤทธิ์ทำลายชั้นบรรยากาศรุนแรงกว่า CO₂ ถึง 28 เท่า เราจึงพัฒนา <strong>SYNRiceWater AWD</strong> สำหรับการทำนาเปียกสลับแห้ง พร้อมบันทึกข้อมูลระดับน้ำแบบเข้ารหัสบนคลาวด์ เพื่อยื่นประเมินคาร์บอนเครดิตมาตรฐานสากล</span>
              <span class="lang-en">Continuously flooded rice is a major methane source, and methane traps 28 times more heat than CO₂. <strong>SYNRiceWater AWD</strong> manages alternate wetting and drying while logging tamper-evident water-level records to the cloud, ready for international carbon credit assessment.</span>
            ', 'smart-agriculture'); ?></p>

            <!-- Key features -->
            <div>
              <span class="inline-block bg-brand text-white px-4 py-2 rounded-lg svc-btn uppercase tracking-wider mb-5">Key Features</span>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
                <div class="bg-surface rounded-2xl border border-brand/10 p-5 space-y-2 text-center h-full">
                  <div class="w-10 h-10 rounded-xl bg-brand text-white flex items-center justify-center font-700 mx-auto">01</div>
                  <h3 data-editable="agri-carbon-h3-1" <?php echo synergy_style('agri-carbon-h3-1', 'smart-agriculture'); ?> class="svc-label text-brand"><?php echo synergy_content('agri-carbon-h3-1', 'Built for AWD Farming', 'smart-agriculture'); ?></h3>
                  <p data-editable="agri-carbon-p-2" <?php echo synergy_style('agri-carbon-p-2', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-carbon-p-2', '
                    <span class="lang-th">ออกแบบสำหรับวัดระดับน้ำในท่อ PVC ใต้ดินในแปลงนาข้าว</span>
                    <span class="lang-en">Designed to read water level inside buried PVC tubes in paddy fields.</span>
                  ', 'smart-agriculture'); ?></p>
                </div>
                <div class="bg-surface rounded-2xl border border-brand/10 p-5 space-y-2 text-center h-full">
                  <div class="w-10 h-10 rounded-xl bg-brand text-white flex items-center justify-center font-700 mx-auto">02</div>
                  <h3 data-editable="agri-carbon-h3-2" <?php echo synergy_style('agri-carbon-h3-2', 'smart-agriculture'); ?> class="svc-label text-brand"><?php echo synergy_content('agri-carbon-h3-2', 'Solar + LTE Autonomous', 'smart-agriculture'); ?></h3>
                  <p data-editable="agri-carbon-p-3" <?php echo synergy_style('agri-carbon-p-3', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-carbon-p-3', '
                    <span class="lang-th">ทำงานอัตโนมัติเต็มรูปแบบ ชาร์จไฟจากโซลาร์เซลล์ ส่งข้อมูลผ่าน 4G</span>
                    <span class="lang-en">Fully autonomous, solar charged and reporting over 4G.</span>
                  ', 'smart-agriculture'); ?></p>
                </div>
                <div class="bg-surface rounded-2xl border border-brand/10 p-5 space-y-2 text-center h-full">
                  <div class="w-10 h-10 rounded-xl bg-brand text-white flex items-center justify-center font-700 mx-auto">03</div>
                  <h3 data-editable="agri-carbon-h3-3" <?php echo synergy_style('agri-carbon-h3-3', 'smart-agriculture'); ?> class="svc-label text-brand"><?php echo synergy_content('agri-carbon-h3-3', 'Carbon Credit Ready Data', 'smart-agriculture'); ?></h3>
                  <p data-editable="agri-carbon-p-4" <?php echo synergy_style('agri-carbon-p-4', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-carbon-p-4', '
                    <span class="lang-th">ข้อมูลมีประวัติย้อนหลังถาวร ป้องกันการดัดแปลง ตามเกณฑ์ประเมิน</span>
                    <span class="lang-en">Permanent, tamper-evident history that meets assessment criteria.</span>
                  ', 'smart-agriculture'); ?></p>
                </div>
              </div>
            </div>

            <!-- Benefits -->
            <div>
              <span class="inline-block bg-brand text-white px-4 py-2 rounded-lg svc-btn uppercase tracking-wider mb-4">Benefits</span>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="flex items-start gap-3 bg-surface p-4 sm:p-5 rounded-2xl border border-brand/10 h-full">
                  <span class="font-display svc-num text-brand">1</span>
                  <p data-editable="agri-carbon-p-5" <?php echo synergy_style('agri-carbon-p-5', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-carbon-p-5', '
                    <span class="lang-th">ลดการใช้น้ำและต้นทุนชลประทาน</span>
                    <span class="lang-en">Reduce water usage and irrigation cost</span>
                  ', 'smart-agriculture'); ?></p>
                </div>
                <div class="flex items-start gap-3 bg-surface p-4 sm:p-5 rounded-2xl border border-brand/10 h-full">
                  <span class="font-display svc-num text-brand">2</span>
                  <p data-editable="agri-carbon-p-6" <?php echo synergy_style('agri-carbon-p-6', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-carbon-p-6', '
                    <span class="lang-th">ลดการปล่อยก๊าซมีเทนด้วยวิธี AWD</span>
                    <span class="lang-en">Cut methane emissions through AWD</span>
                  ', 'smart-agriculture'); ?></p>
                </div>
                <div class="flex items-start gap-3 bg-surface p-4 sm:p-5 rounded-2xl border border-brand/10 h-full">
                  <span class="font-display svc-num text-brand">3</span>
                  <p data-editable="agri-carbon-p-7" <?php echo synergy_style('agri-carbon-p-7', 'smart-agriculture'); ?> class="svc-caption text-muted"><?php echo synergy_content('agri-carbon-p-7', '
                    <span class="lang-th">เปิดโอกาสสร้างรายได้จาก Carbon Credit</span>
                    <span class="lang-en">Unlock carbon credit opportunities</span>
                  ', 'smart-agriculture'); ?></p>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- 05 · SMART GREENHOUSE -->
    <section id="agri-greenhouse" aria-labelledby="agri-greenhouse-title" class="py-20 sm:py-28 lg:py-32 bg-surface relative overflow-hidden">
      <div class="absolute inset-0 opacity-20 pointer-events-none sa-mesh"></div>
      <div class="max-w-7xl mx-auto px-5 sm:px-6 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-14 sm:mb-20 sa-reveal">
          <div class="inline-flex items-center gap-3 justify-center mb-4">
            <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
            <span class="text-brand svc-kicker"><span class="lang-th">05 · Closed-Loop Automation</span><span class="lang-en">05 · Closed-Loop Automation</span></span>
          </div>
          <h2 data-editable="agri-greenhouse-h2-1" <?php echo synergy_style('agri-greenhouse-h2-1', 'smart-agriculture'); ?> id="agri-greenhouse-title" class="font-display svc-h2 text-ink tracking-tight mb-5"><?php echo synergy_content('agri-greenhouse-h2-1', '
            <span class="lang-th">Smart Greenhouse โรงเรือนอัจฉริยะ</span>
            <span class="lang-en">Smart Greenhouse</span>
          ', 'smart-agriculture'); ?></h2>
          <p data-editable="agri-greenhouse-p-1" <?php echo synergy_style('agri-greenhouse-p-1', 'smart-agriculture'); ?> class="svc-lede text-body max-w-2xl mx-auto"><?php echo synergy_content('agri-greenhouse-p-1', '
            <span class="lang-th">ระบบโรงเรือนอัตโนมัติครบวงจร ทำงานร่วมกับ HandySense เพื่อตรวจสอบและสั่งการพัดลม ปั๊มน้ำ และระบบพ่นหมอกตามตัวแปรธรรมชาติ</span>
            <span class="lang-en">A complete greenhouse automation system working with HandySense to monitor conditions and drive fans, pumps and misting on their own.</span>
          ', 'smart-agriculture'); ?></p>
        </div>

        <div class="grid lg:grid-cols-12 gap-10 lg:gap-16 items-start">
          <div class="lg:col-span-5 space-y-4">
            <div class="grid grid-cols-2 gap-4">
              <div class="rounded-2xl overflow-hidden sa-card shadow-md h-32 sm:h-36">
                <?php sa_picture('agri-greenhouse-control-panel', 'Smart Greenhouse control panel with HandySense', 'w-full h-full object-cover', '(min-width:1024px) 20vw, 45vw', 1350, 1013); ?>
              </div>
              <div class="rounded-2xl overflow-hidden sa-card shadow-md h-32 sm:h-36">
                <?php sa_picture('agri-greenhouse-interior', 'Smart Greenhouse interior', 'w-full h-full object-cover', '(min-width:1024px) 20vw, 45vw', 1350, 1013); ?>
              </div>
            </div>
            <div class="rounded-3xl overflow-hidden sa-card shadow-lg h-48 sm:h-56">
              <?php sa_picture('agri-greenhouse-exterior', 'Smart Greenhouse exterior', 'w-full h-full object-cover', '(min-width:1024px) 40vw, 100vw', 1350, 1013); ?>
            </div>
          </div>

          <div class="lg:col-span-7 space-y-6">
            <h3 data-editable="agri-greenhouse-h3-1" <?php echo synergy_style('agri-greenhouse-h3-1', 'smart-agriculture'); ?> class="font-display svc-h3 text-ink"><?php echo synergy_content('agri-greenhouse-h3-1', '
              <span class="lang-th">คุณสมบัติระบบโรงเรือนอัจฉริยะ</span>
              <span class="lang-en">Smart Greenhouse System Capabilities</span>
            ', 'smart-agriculture'); ?></h3>
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
              <h4 data-editable="agri-greenhouse-h4-1" <?php echo synergy_style('agri-greenhouse-h4-1', 'smart-agriculture'); ?> class="svc-label text-ink mb-4"><?php echo synergy_content('agri-greenhouse-h4-1', '<i class="fa-solid fa-sliders text-brand mr-2" aria-hidden="true"></i><span class="lang-th">อุปกรณ์และ Sensor ในระบบ Smart Greenhouse</span><span class="lang-en">Devices &amp; Sensors in the Smart Greenhouse</span>', 'smart-agriculture'); ?></h4>
              <!-- 2-up on the narrowest phones, 3-up from 420px, 5-up from the sm
                   breakpoint. Five across at 375px gives ~70px per cell and three
                   across gives ~100px - neither fits "Temp/Humidity" on a line. -->
              <div class="grid grid-cols-2 min-[420px]:grid-cols-3 sm:grid-cols-5 gap-3 text-center">
                <div class="p-2 hover:bg-surface rounded-xl transition flex flex-col items-center justify-center">
                  <div class="h-12 w-12 rounded overflow-hidden mb-2 bg-slate-50"><?php sa_picture('agri-icon-light-sensor', 'Light sensor', 'w-full h-full object-cover', '96px', 96, 96, array(96, 192)); ?></div>
                  <div data-editable="agri-greenhouse-div-1" <?php echo synergy_style('agri-greenhouse-div-1', 'smart-agriculture'); ?> class="svc-metric text-ink"><?php echo synergy_content('agri-greenhouse-div-1', 'Light Sensor', 'smart-agriculture'); ?></div>
                </div>
                <div class="p-2 hover:bg-surface rounded-xl transition flex flex-col items-center justify-center">
                  <div class="h-12 w-12 rounded overflow-hidden mb-2 bg-slate-50"><?php sa_picture('agri-icon-temp-humidity', 'Temperature and humidity sensor', 'w-full h-full object-cover', '96px', 96, 96, array(96, 192)); ?></div>
                  <div data-editable="agri-greenhouse-div-2" <?php echo synergy_style('agri-greenhouse-div-2', 'smart-agriculture'); ?> class="svc-metric text-ink"><?php echo synergy_content('agri-greenhouse-div-2', 'Temp/Humidity', 'smart-agriculture'); ?></div>
                </div>
                <div class="p-2 hover:bg-surface rounded-xl transition flex flex-col items-center justify-center">
                  <div class="h-12 w-12 rounded overflow-hidden mb-2 bg-slate-50"><?php sa_picture('agri-icon-soil-moisture', 'Soil moisture sensor', 'w-full h-full object-cover', '96px', 96, 96, array(96, 192)); ?></div>
                  <div data-editable="agri-greenhouse-div-3" <?php echo synergy_style('agri-greenhouse-div-3', 'smart-agriculture'); ?> class="svc-metric text-ink"><?php echo synergy_content('agri-greenhouse-div-3', 'Soil Moisture', 'smart-agriculture'); ?></div>
                </div>
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
    <section id="agri-audience" aria-labelledby="agri-audience-title" class="py-20 sm:py-28 bg-surface">
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

    <section id="agri-cta" class="py-14 sm:py-20 bg-white" style="scroll-margin-top:96px">
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
