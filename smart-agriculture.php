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
  <!-- Interactive platform section. Scoped to #energy-platform; the section
       renders as unstyled markup without this. -->
  <link rel="stylesheet" href="<?php echo function_exists('synergy_asset') ? synergy_asset('components/energy-platform.css') : './components/energy-platform.css'; ?>">

  <style>
    /* Wide shell for the platform section - it holds a 3D stage, a device row
       and a screenshot panel, so the normal page container squeezes it. */
    .sa-shell { width: 100%; max-width: 1760px; margin-inline: auto; padding-inline: clamp(16px, 3.2vw, 64px); }
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
    /* Clean, compact, professional card layout for THE SYNEXTA ENGINE */
    .sa-eng-card {
      display: flex !important;
      flex-direction: column !important;
      height: 100% !important;
      justify-content: flex-start !important;
    }
    .sa-eng-title {
      min-height: 2.8em !important;
      margin-bottom: 0.5rem !important;
    }
    .sa-eng-desc {
      min-height: 7.6em !important;
      margin-bottom: 1.25rem !important;
      line-height: 1.6 !important;
    }
    .sa-eng-list {
      /* NOT margin-top:auto. In an equal-height flex card that pushes the
         divider to the bottom, so the card with five capabilities starts its
         divider higher than the ones with four - a visible staircase across
         the row. Fixed margin keeps all five dividers on one line. */
      margin-top: 1rem !important;
      padding-top: 1rem !important;
      border-top: 1px solid #f1f5f9 !important;
      display: flex !important;
      flex-direction: column !important;
      gap: 0.5rem !important;
      width: 100% !important;
    }
    .sa-eng-li {
      display: flex !important;
      align-items: center !important;
      gap: 0.625rem !important;
      margin: 0 !important;
      padding: 0.2rem 0 !important;
      /* 16px / 1.8: the Thai floor and line-height from rule 3 in AGENTS.md.
         Thai stacks vowels and tone marks above and below the baseline, so
         1.5 clips them. */
      font-size: 16px !important;
      line-height: 1.8 !important;
      color: #3a4a41 !important;
    }
    .sa-eng-li span {
      font-size: 16px !important;
      line-height: 1.8 !important;
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

    /* ==========================================================================
       PLATFORM FEATURE CARDS — bigger, denser icon art

       energy-platform.css sizes .feature-icon-box at 48px with 8px of padding,
       which was drawn around a 28px inline SVG whose strokes are set in code.
       This page puts PNG line art in the same slot instead, and that art is
       drawn thin and in a pale mint — at 28px inside a pale mint box it washed
       out to near-invisible. The box grows, the padding shrinks so the artwork
       actually fills it, and the backing goes a shade deeper so the strokes
       have something to sit against.

       Scoped to this page: smart-factory.php and smart-energy.php share
       energy-platform.css and still use the inline SVGs it was tuned for.
       ========================================================================== */
    #energy-platform .feature-icon-box {
      width: 60px;
      height: 60px;
      min-width: 60px;
      padding: 6px;
      border-radius: 16px;
      background: linear-gradient(135deg, #DCF3E8 0%, #EAF9F1 100%);
      border-color: rgba(16, 185, 129, 0.38);
    }
    #energy-platform .feature-icon-box img {
      width: 46px !important;
      height: 46px !important;
      /* The source PNGs are light mint on transparent. Saturating and darkening
         them is what closes the gap to the weight of the surrounding type;
         without it the icon reads as a watermark rather than an icon. */
      filter: saturate(1.5) contrast(1.18) brightness(0.9);
    }
    #energy-platform .feature-card:hover .feature-icon-box img {
      filter: saturate(1.7) contrast(1.25) brightness(0.84);
    }

    /* ==========================================================================
       HERO — WHITE SCRIM + DARK COPY

       Matches the Smart Energy hero. The copy used to be white with a heavy
       black text-shadow over an untinted photograph; the rice-field art is
       bright, so the shadow was doing all the work and the headline's gold
       gradient stop measured well under 3:1 against it. Same fix as
       smart-energy.php: back the copy column with white and darken the text,
       rather than darkening a photo that the user asked to keep visible.

       Stops mirror the energy hero. The copy runs to roughly two thirds of the
       width, so the white holds to 68% and has cleared the field by 88%.
       ========================================================================== */
    .sa-hero-scrim {
      background: linear-gradient(
        to right,
        rgba(255, 255, 255, 0.87) 0%,
        rgba(255, 255, 255, 0.85) 55%,
        rgba(255, 255, 255, 0.70) 68%,
        rgba(255, 255, 255, 0) 88%
      );
    }

    /* Below the 3-column breakpoint the copy is full width, so a left-to-right
       fade would leave the end of every line unbacked. Top-down instead. */
    @media (max-width: 1023px) {
      .sa-hero-scrim {
        background: linear-gradient(
          to bottom,
          rgba(255, 255, 255, 0.86) 0%,
          rgba(255, 255, 255, 0.84) 62%,
          rgba(255, 255, 255, 0.70) 100%
        );
      }
    }

    /* The section still carries Tailwind's bg-ink/text-white. */
    #agri-hero { color: #3A4A41; }

    /* The shadows were tuned to lift white text off a photo. On white they
       print as grey smear behind every glyph. */
    #agri-hero h1,
    #agri-hero p,
    #agri-hero .svc-caption { text-shadow: none !important; }

    /* Kicker chip: white-on-white glass reads as nothing once the scrim is
       light, so it gets a solid tint and a green border instead. */
    #agri-hero .sa-hero-chip {
      background: rgba(255, 255, 255, 0.72) !important;
      border-color: rgba(4, 96, 64, 0.22) !important;
    }
    #agri-hero .sa-hero-chip .svc-kicker,
    #agri-hero .sa-hero-chip .svc-kicker .lang-th,
    #agri-hero .sa-hero-chip .svc-kicker .lang-en { color: #046040 !important; }  /* 5.1:1 */

    /* .text-white below is a class selector and would otherwise out-specify a
       bare element selector here, leaving the headline at body-copy grey. */
    #agri-hero h1.text-white { color: #0B1F16 !important; }            /* 16.9:1 */
    /* The highlight was a three-stop gradient ending in gold-bright, which is
       a light yellow — invisible on white. Solid brand green, same call the
       energy hero makes. */
    #agri-hero h1 .bg-clip-text {
      background: none !important;
      -webkit-background-clip: initial !important;
      background-clip: initial !important;
      -webkit-text-fill-color: #23862D !important;
      color: #23862D !important;                                       /* 5.2:1 */
    }
    #agri-hero .text-emerald-300,
    #agri-hero .text-emerald-300 .lang-th,
    #agri-hero .text-emerald-300 .lang-en { color: #1F6B43 !important; }  /* 6.4:1 */
    #agri-hero .text-white,
    #agri-hero .text-white .lang-th,
    #agri-hero .text-white .lang-en { color: #3A4A41 !important; }        /* 8.9:1 */
    #agri-hero .text-white\/90,
    #agri-hero .text-white\/90 span { color: #3A4A41 !important; }
    /* Gold on white is roughly 1.9:1; the proof-strip icons carry meaning
       alongside their labels, so they move to the same green as the eyebrow. */
    #agri-hero .text-gold-bright { color: #046040 !important; }
    #agri-hero .border-white\/15 { border-color: rgba(11, 31, 22, 0.15) !important; }

    /* The CTA paints its own green background and keeps its white label. */
    #agri-hero .bg-brand { color: #fff !important; }
    #agri-hero .bg-brand .lang-th,
    #agri-hero .bg-brand .lang-en { color: #fff !important; }

    /* ==========================================================================
       MOBILE — the platform section on a phone

       All three measured on a 375x812 viewport.
       ========================================================================== */
    @media (max-width: 767px) {

      /* 1. TAB ROW: two tabs, sized to their labels.

         energy-platform.css wraps the tabs at a quarter of the row each,
         written for the seven-tab bar on smart-energy.php. This section now has
         two. A quarter of a row that has itself shrunk to its content is 28px,
         so both labels were crushed into 28px-wide columns 80px tall - the
         letters stacked more or less vertically and neither tab was readable.

         Natural width plus nowrap is the fix, and with only two tabs there is
         no contest for space: each takes exactly what its label needs and the
         pair centres in the bar. nowrap also guarantees the row can never
         become two rows, whatever the label length. */
      #energy-platform .nav-tabs {
        flex-wrap: nowrap;
        justify-content: center;
        overflow-x: auto;
        gap: 3px;
      }
      #energy-platform .nav-tab {
        flex: 0 0 auto;
        min-width: 0;
        white-space: nowrap;
        padding: 9px 14px;
        min-height: 62px;
      }

      /* 2. DEPLOYMENT: side by side.

         The Cloud / OR / On-Premise stack runs as a column here and costs
         386px of scrolling for two cards. The shared stylesheet already turns
         it into a row at the tablet breakpoint, dashes rotated to match; a
         phone needs that more, not less. Cards come down to 118px so the row
         clears a 360px Android screen rather than only a 375px iPhone. */
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
      #energy-platform .deployment-card-square { width: 118px; height: 118px; }
      #energy-platform .divider-or-circle { width: 40px; height: 40px; }
      #energy-platform .right-deployment-column { height: auto; padding-top: 4px; }
    }

    /* 3. LIGHTBOX: make "tap to enlarge" actually enlarge.

       Same defect, same fix as smart-factory.php. The lightbox centres the
       screenshot with max-width/max-height 100%, so a landscape dashboard on a
       portrait phone fits to WIDTH and opens at essentially the size of the
       thumbnail that was tapped. Sizing by height lets it overflow sideways
       inside a scroll container: it opens about three times larger and pans
       under the finger.

       Bounded at 1023px because a portrait tablet has the same problem, and
       restricted to portrait because fit-to-width is already correct once the
       viewport and the image share an orientation. */
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
      /* Absolute inside what is now a scroll container would carry the close
         button off screen on the first sideways pan. */
      #energy-platform .shot-lightbox-close { position: fixed; }
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
      <!-- The hero art is a real <img>, not a CSS background. A background-image
           is discovered only after the stylesheet is parsed and cannot be
           preloaded, srcset-ed or given fetchpriority - and this image is the
           page's largest contentful paint. As an <img> it starts downloading
           from the preload in <head> at the right width for the viewport. The
           tint that used to be part of the gradient is now its own layer. -->
      <div class="absolute inset-0">
        <?php sa_picture('agri-hero-bg', 'Rice fields with IoT sensor nodes and a farmer using a tablet', 'w-full h-full object-cover', '100vw', 1350, 760, array(640, 960, 1350), true); ?>
        <!-- White scrim, same arrangement as the Smart Energy hero. The photo
             stays fully visible on the right; only the copy column is backed. -->
        <div class="absolute inset-0 sa-hero-scrim pointer-events-none"></div>
      </div>

      <div class="max-w-7xl mx-auto px-5 sm:px-6 relative z-10 w-full">
        <div class="sa-hero-chip inline-flex items-center gap-2.5 mb-7 bg-white/5 border border-white/10 px-4 sm:px-5 py-2 rounded-full backdrop-blur-md sa-card-d">
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse" aria-hidden="true"></span>
          <!-- Same Latin string in both languages: it is a product-technology
               label, not prose, and the switcher still needs a pair to act on. -->
          <span class="text-white/90 svc-kicker"><span class="lang-th">SMART AGRICULTURE</span><span class="lang-en">SMART AGRICULTURE</span></span>
        </div>
        <h1 data-editable="agri-hero-h1-1" <?php echo synergy_style('agri-hero-h1-1', 'smart-agriculture'); ?> id="agri-hero-title" class="font-display svc-h1 text-white tracking-tight mb-6"><?php echo synergy_content('agri-hero-h1-1', '<span class="lang-th">Powering Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-brand to-gold-bright">Smart Agriculture</span></span><span class="lang-en">Powering Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-brand to-gold-bright">Smart Agriculture</span></span>', 'smart-agriculture'); ?></h1>
        <p data-editable="agri-hero-sub" <?php echo synergy_style('agri-hero-sub', 'smart-agriculture'); ?> class="svc-h3 font-display text-emerald-300 mb-5"><?php echo synergy_content('agri-hero-sub', '<span class="lang-th">One Platform for Precision Agriculture Management</span><span class="lang-en">One Platform for Precision Agriculture Management</span>', 'smart-agriculture'); ?></p>
        <!-- svc-copy, not svc-lede: the deck adds a subheading above this line, and
             at svc-lede the paragraph measured 21.3px against the subheading's
             21.0px - the supporting text outranking the line it supports. -->
        <p data-editable="agri-hero-p-1" <?php echo synergy_style('agri-hero-p-1', 'smart-agriculture'); ?> class="svc-copy text-white max-w-3xl mb-10"><?php echo synergy_content('agri-hero-p-1', '<span class="lang-th">เชื่อมต่อข้อมูลจากเซนเซอร์ อุปกรณ์ IoT และระบบการเกษตรไว้ในแพลตฟอร์มเดียว เพื่อการติดตาม วิเคราะห์ และบริหารจัดการฟาร์มแบบ Real-time ช่วยเพิ่มผลผลิต ลดต้นทุน และใช้ทรัพยากรได้อย่างมีประสิทธิภาพ</span><span class="lang-en">Connect agricultural sensors, IoT devices, and farm operations into a single platform for real-time monitoring, analytics, and precision farm management&mdash;helping improve productivity, reduce costs, and optimize resource utilization.</span>', 'smart-agriculture'); ?></p>
        <div class="flex">
          <a href="<?php echo home_url('/'); ?>#contact" class="sa-tap bg-brand hover:bg-brand-deep text-white svc-btn uppercase tracking-wider px-8 py-4 rounded-xl transition shadow-lg shadow-brand/20 inline-flex items-center justify-center gap-2 sa-card-d">
            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i><span class="lang-th">ปรึกษาโครงการ</span><span class="lang-en">Talk to Our Experts</span>
          </a>
        </div>
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
        <div class="text-center max-w-4xl mx-auto mb-12 sm:mb-16 sa-reveal">
          <div class="inline-flex items-center gap-3 justify-center mb-4">
            <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
            <span class="text-brand svc-kicker"><span class="lang-th">ความท้าทายด้านการเกษตร</span><span class="lang-en">Agriculture Challenges We Solve</span></span>
          </div>
          <h2 data-editable="agri-challenges-h2-1" <?php echo synergy_style('agri-challenges-h2-1', 'smart-agriculture'); ?> id="agri-challenges-title" class="font-display svc-h2 text-ink tracking-tight mb-5"><?php echo synergy_content('agri-challenges-h2-1', '<span class="lang-th">ปัญหาที่เราช่วยคุณแก้ไข</span><span class="lang-en">Challenges We Help You Solve</span>', 'smart-agriculture'); ?></h2>
          <p data-editable="agri-challenges-p-0" <?php echo synergy_style('agri-challenges-p-0', 'smart-agriculture'); ?> class="svc-lede text-body mx-auto"><?php echo synergy_content('agri-challenges-p-0', '<span class="lang-th">เข้าใจปัญหาที่แท้จริงของเกษตรกร<br class="hidden sm:inline"> เราพร้อมช่วยให้คุณทำการเกษตรได้อย่างมีประสิทธิภาพและยั่งยืน</span><span class="lang-en">We understand the real challenges farmers face, and deliver solutions<br class="hidden sm:inline"> for smarter, more sustainable farming.</span>', 'smart-agriculture'); ?></p>
        </div>

        <!-- Flexible Auto Layout: 1 line on desktop (xl:grid-cols-6), auto-wrapping on smaller screens -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4 sm:gap-5 items-stretch">

          <!-- 01 -->
          <div class="bg-white rounded-[20px] xl:rounded-[24px] p-5 xl:p-4 2xl:p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center border border-slate-100">
            <div class="w-14 h-14 xl:w-12 xl:h-12 2xl:w-16 2xl:h-16 rounded-2xl bg-brand-soft flex items-center justify-center mb-3 shrink-0 overflow-hidden" aria-hidden="true">
              <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/challenge_1.png" alt="ผลผลิตไม่สม่ำเสมอ" class="w-9 h-9 xl:w-7 xl:h-7 2xl:w-10 2xl:h-10 object-contain">
            </div>
            <div class="svc-kicker text-brand font-bold text-sm mb-1">01</div>
            <h3 data-editable="agri-challenges-h3-1" <?php echo synergy_style('agri-challenges-h3-1', 'smart-agriculture'); ?> class="svc-label text-ink mb-2 font-bold text-base xl:text-sm 2xl:text-base leading-snug"><?php echo synergy_content('agri-challenges-h3-1', '<span class="lang-th">ผลผลิตไม่สม่ำเสมอ</span><span class="lang-en">Unpredictable Crop Yields</span>', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-challenges-p-1" <?php echo synergy_style('agri-challenges-p-1', 'smart-agriculture'); ?> class="svc-caption text-muted text-xs 2xl:text-sm leading-relaxed"><?php echo synergy_content('agri-challenges-p-1', '<span class="lang-th">ผลผลิตได้รับผลกระทบจากสภาพอากาศและสภาพแวดล้อมที่ควบคุมได้ยาก</span><span class="lang-en">Crop growth is affected by weather and environmental conditions.</span>', 'smart-agriculture'); ?></p>
          </div>

          <!-- 02 -->
          <div class="bg-white rounded-[20px] xl:rounded-[24px] p-5 xl:p-4 2xl:p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center border border-slate-100">
            <div class="w-14 h-14 xl:w-12 xl:h-12 2xl:w-16 2xl:h-16 rounded-2xl bg-brand-soft flex items-center justify-center mb-3 shrink-0 overflow-hidden" aria-hidden="true">
              <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/challenge_2.png" alt="ใช้น้ำและทรัพยากรเกินความจำเป็น" class="w-9 h-9 xl:w-7 xl:h-7 2xl:w-10 2xl:h-10 object-contain">
            </div>
            <div class="svc-kicker text-brand font-bold text-sm mb-1">02</div>
            <h3 data-editable="agri-challenges-h3-2" <?php echo synergy_style('agri-challenges-h3-2', 'smart-agriculture'); ?> class="svc-label text-ink mb-2 font-bold text-base xl:text-sm 2xl:text-base leading-snug"><?php echo synergy_content('agri-challenges-h3-2', '<span class="lang-th">ใช้น้ำและทรัพยากรเกินความจำเป็น</span><span class="lang-en">High Water &amp; Resource Usage</span>', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-challenges-p-2" <?php echo synergy_style('agri-challenges-p-2', 'smart-agriculture'); ?> class="svc-caption text-muted text-xs 2xl:text-sm leading-relaxed"><?php echo synergy_content('agri-challenges-p-2', '<span class="lang-th">การให้น้ำและใช้ทรัพยากรขาดข้อมูล ทำให้ต้นทุนสูง</span><span class="lang-en">Irrigation and resource usage are difficult to optimize.</span>', 'smart-agriculture'); ?></p>
          </div>

          <!-- 03 -->
          <div class="bg-white rounded-[20px] xl:rounded-[24px] p-5 xl:p-4 2xl:p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center border border-slate-100">
            <div class="w-14 h-14 xl:w-12 xl:h-12 2xl:w-16 2xl:h-16 rounded-2xl bg-brand-soft flex items-center justify-center mb-3 shrink-0 overflow-hidden" aria-hidden="true">
              <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/challenge_3.png" alt="มองไม่เห็นข้อมูลภาคสนามแบบ Real-time" class="w-9 h-9 xl:w-7 xl:h-7 2xl:w-10 2xl:h-10 object-contain">
            </div>
            <div class="svc-kicker text-brand font-bold text-sm mb-1">03</div>
            <h3 data-editable="agri-challenges-h3-3" <?php echo synergy_style('agri-challenges-h3-3', 'smart-agriculture'); ?> class="svc-label text-ink mb-2 font-bold text-base xl:text-sm 2xl:text-base leading-snug"><?php echo synergy_content('agri-challenges-h3-3', '<span class="lang-th">มองไม่เห็นข้อมูลภาคสนามแบบ Real-time</span><span class="lang-en">Limited Field Visibility</span>', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-challenges-p-3" <?php echo synergy_style('agri-challenges-p-3', 'smart-agriculture'); ?> class="svc-caption text-muted text-xs 2xl:text-sm leading-relaxed"><?php echo synergy_content('agri-challenges-p-3', '<span class="lang-th">ไม่สามารถติดตามข้อมูลจากแปลงปลูกได้ทันที ทำให้ตัดสินใจล่าช้า</span><span class="lang-en">Field conditions cannot be monitored in real time.</span>', 'smart-agriculture'); ?></p>
          </div>

          <!-- 04 -->
          <div class="bg-white rounded-[20px] xl:rounded-[24px] p-5 xl:p-4 2xl:p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center border border-slate-100">
            <div class="w-14 h-14 xl:w-12 xl:h-12 2xl:w-16 2xl:h-16 rounded-2xl bg-brand-soft flex items-center justify-center mb-3 shrink-0 overflow-hidden" aria-hidden="true">
              <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/challenge_4.png" alt="บริหารหลายแปลงหรือหลายพื้นที่ได้ยาก" class="w-9 h-9 xl:w-7 xl:h-7 2xl:w-10 2xl:h-10 object-contain">
            </div>
            <div class="svc-kicker text-brand font-bold text-sm mb-1">04</div>
            <h3 data-editable="agri-challenges-h3-4" <?php echo synergy_style('agri-challenges-h3-4', 'smart-agriculture'); ?> class="svc-label text-ink mb-2 font-bold text-base xl:text-sm 2xl:text-base leading-snug"><?php echo synergy_content('agri-challenges-h3-4', '<span class="lang-th">บริหารหลายแปลงหรือหลายพื้นที่ได้ยาก</span><span class="lang-en">Managing Multiple Farms</span>', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-challenges-p-4" <?php echo synergy_style('agri-challenges-p-4', 'smart-agriculture'); ?> class="svc-caption text-muted text-xs 2xl:text-sm leading-relaxed"><?php echo synergy_content('agri-challenges-p-4', '<span class="lang-th">ข้อมูลแต่ละพื้นที่แยกกัน ทำให้บริหารจัดการได้ยาก</span><span class="lang-en">Managing operations across multiple farms is inefficient.</span>', 'smart-agriculture'); ?></p>
          </div>

          <!-- 05 -->
          <div class="bg-white rounded-[20px] xl:rounded-[24px] p-5 xl:p-4 2xl:p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center border border-slate-100">
            <div class="w-14 h-14 xl:w-12 xl:h-12 2xl:w-16 2xl:h-16 rounded-2xl bg-brand-soft flex items-center justify-center mb-3 shrink-0 overflow-hidden" aria-hidden="true">
              <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/challenge_5.png" alt="พบปัญหาล่าช้า" class="w-9 h-9 xl:w-7 xl:h-7 2xl:w-10 2xl:h-10 object-contain">
            </div>
            <div class="svc-kicker text-brand font-bold text-sm mb-1">05</div>
            <h3 data-editable="agri-challenges-h3-5" <?php echo synergy_style('agri-challenges-h3-5', 'smart-agriculture'); ?> class="svc-label text-ink mb-2 font-bold text-base xl:text-sm 2xl:text-base leading-snug"><?php echo synergy_content('agri-challenges-h3-5', '<span class="lang-th">พบปัญหาล่าช้า</span><span class="lang-en">Delayed Problem Detection</span>', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-challenges-p-5" <?php echo synergy_style('agri-challenges-p-5', 'smart-agriculture'); ?> class="svc-caption text-muted text-xs 2xl:text-sm leading-relaxed"><?php echo synergy_content('agri-challenges-p-5', '<span class="lang-th">ตรวจพบโรคพืช ศัตรูพืช หรืออุปกรณ์ขัดข้องไม่ทันเวลา</span><span class="lang-en">Pest, disease, or equipment issues are detected too late.</span>', 'smart-agriculture'); ?></p>
          </div>

          <!-- 06 -->
          <div class="bg-white rounded-[20px] xl:rounded-[24px] p-5 xl:p-4 2xl:p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal h-full flex flex-col items-center text-center border border-slate-100">
            <div class="w-14 h-14 xl:w-12 xl:h-12 2xl:w-16 2xl:h-16 rounded-2xl bg-brand-soft flex items-center justify-center mb-3 shrink-0 overflow-hidden" aria-hidden="true">
              <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/challenge_6.png" alt="ตัดสินใจจากประสบการณ์มากกว่าข้อมูล" class="w-9 h-9 xl:w-7 xl:h-7 2xl:w-10 2xl:h-10 object-contain">
            </div>
            <div class="svc-kicker text-brand font-bold text-sm mb-1">06</div>
            <h3 data-editable="agri-challenges-h3-6" <?php echo synergy_style('agri-challenges-h3-6', 'smart-agriculture'); ?> class="svc-label text-ink mb-2 font-bold text-base xl:text-sm 2xl:text-base leading-snug"><?php echo synergy_content('agri-challenges-h3-6', '<span class="lang-th">ตัดสินใจจากประสบการณ์มากกว่าข้อมูล</span><span class="lang-en">Decisions Based on Guesswork</span>', 'smart-agriculture'); ?></h3>
            <p data-editable="agri-challenges-p-6" <?php echo synergy_style('agri-challenges-p-6', 'smart-agriculture'); ?> class="svc-caption text-muted text-xs 2xl:text-sm leading-relaxed"><?php echo synergy_content('agri-challenges-p-6', '<span class="lang-th">ขาดข้อมูลสนับสนุน ทำให้การวางแผนและตัดสินใจไม่แม่นยำ</span><span class="lang-en">Farming decisions rely on experience instead of real-time insights.</span>', 'smart-agriculture'); ?></p>
          </div>

        </div>
      </div>
    </section>


    <!-- THE SYNEXTA ENGINE
         Five-step flow, the same shape smart-energy.php uses for SYNC / STREAM /
         STEER / SOLVE / SAFE. Five across only from lg; below that the Thai
         copy needs the width (AGENTS.md rule 3). -->
    <section id="agri-engine" aria-labelledby="agri-engine-title" class="py-12 sm:py-16 bg-white border-y border-slate-100">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 sa-reveal">
          <span class="inline-flex items-center gap-2 bg-brand-soft text-brand svc-kicker px-4 py-2 rounded-full mb-5">
            <i class="fa-solid fa-seedling" aria-hidden="true"></i>
            <span class="lang-th">THE SYNEXTA ENGINE</span><span class="lang-en">THE SYNEXTA ENGINE</span>
          </span>
          <h2 data-editable="agri-engine-h2" <?php echo synergy_style('agri-engine-h2', 'smart-agriculture'); ?> id="agri-engine-title" class="font-display svc-h2 text-ink tracking-tight mb-3"><?php echo synergy_content('agri-engine-h2', '<span class="lang-th">เปลี่ยนข้อมูลการเกษตรให้เป็นการตัดสินใจที่แม่นยำ</span><span class="lang-en">From Connected Data to Intelligent Decisions</span>', 'smart-agriculture'); ?></h2>
          <p data-editable="agri-engine-sub" <?php echo synergy_style('agri-engine-sub', 'smart-agriculture'); ?> class="svc-copy text-body"><?php echo synergy_content('agri-engine-sub', '<span class="lang-th">เชื่อมต่อ เก็บรวบรวม ควบคุม วิเคราะห์ และเพิ่มประสิทธิภาพการเกษตร ผ่านแพลตฟอร์มเดียว</span><span class="lang-en">Connect, collect, control, analyze, and optimize your farm operations through one intelligent platform.</span>', 'smart-agriculture'); ?></p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5 sm:gap-6 items-stretch relative sa-eng-grid">
          <div class="relative bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal sa-eng-card">
            <div class="hidden xl:flex items-center justify-center w-7 h-7 rounded-full bg-brand text-white absolute -right-4 top-24 z-20 border-2 border-white shadow" aria-hidden="true"><i class="fa-solid fa-chevron-right text-[10px]"></i></div>
              <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-50 to-brand-soft border border-brand/15 flex items-center justify-center mx-auto mb-5 mt-1 shadow-sm transition-transform hover:scale-105" aria-hidden="true">
                <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/engine_1.png" alt="SYNC" class="w-14 h-14 object-contain filter drop-shadow-sm">
              </div>
              <div class="svc-kicker text-brand mb-1 text-center">01</div>
              <h3 class="font-display svc-h3 text-ink tracking-tight mb-1 text-center">SYNC</h3>
              <div data-editable="agri-engine-t-1" <?php echo synergy_style('agri-engine-t-1', 'smart-agriculture'); ?> class="svc-label text-brand mb-4 sa-eng-title text-center"><?php echo synergy_content('agri-engine-t-1', '<span class="lang-th">เชื่อมต่อทุกแหล่งข้อมูล</span><span class="lang-en">Connect Everything</span>', 'smart-agriculture'); ?></div>
              <p data-editable="agri-engine-d-1" <?php echo synergy_style('agri-engine-d-1', 'smart-agriculture'); ?> class="svc-caption text-muted mb-5 sa-eng-desc text-center"><?php echo synergy_content('agri-engine-d-1', '<span class="lang-th">เชื่อมต่อเซนเซอร์ อุปกรณ์ IoT สถานีอากาศ ระบบน้ำ โดรน และเครื่องมือการเกษตรไว้ในแพลตฟอร์มเดียว</span><span class="lang-en">Connect sensors, IoT devices, weather stations, irrigation systems, drones, and farm equipment into one platform.</span>', 'smart-agriculture'); ?></p>
              <ul class="sa-eng-list svc-caption text-body">
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-seedling text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">เซนเซอร์สภาพแวดล้อม</span><span class="lang-en">Environmental Sensors</span></span></li>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-cloud-sun text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">สถานีอากาศ</span><span class="lang-en">Weather Station</span></span></li>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-faucet-drip text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">ระบบน้ำ</span><span class="lang-en">Irrigation System</span></span></li>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-helicopter-symbol text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">โดรนและภาพถ่าย</span><span class="lang-en">Drones &amp; Imaging</span></span></li>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-microchip text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">เครื่องมือการเกษตร</span><span class="lang-en">Farm Equipment</span></span></li>
              </ul>
          </div>
          <div class="relative bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal sa-eng-card">
            <div class="hidden xl:flex items-center justify-center w-7 h-7 rounded-full bg-brand text-white absolute -right-4 top-24 z-20 border-2 border-white shadow" aria-hidden="true"><i class="fa-solid fa-chevron-right text-[10px]"></i></div>
              <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-50 to-brand-soft border border-brand/15 flex items-center justify-center mx-auto mb-5 mt-1 shadow-sm transition-transform hover:scale-105" aria-hidden="true">
                <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/engine_2.png" alt="STREAM" class="w-14 h-14 object-contain filter drop-shadow-sm">
              </div>
              <div class="svc-kicker text-brand mb-1 text-center">02</div>
              <h3 class="font-display svc-h3 text-ink tracking-tight mb-1 text-center">STREAM</h3>
              <div data-editable="agri-engine-t-2" <?php echo synergy_style('agri-engine-t-2', 'smart-agriculture'); ?> class="svc-label text-brand mb-4 sa-eng-title text-center"><?php echo synergy_content('agri-engine-t-2', '<span class="lang-th">เก็บรวบรวมและติดตามข้อมูล</span><span class="lang-en">Collect &amp; Monitor</span>', 'smart-agriculture'); ?></div>
              <p data-editable="agri-engine-d-2" <?php echo synergy_style('agri-engine-d-2', 'smart-agriculture'); ?> class="svc-caption text-muted mb-5 sa-eng-desc text-center"><?php echo synergy_content('agri-engine-d-2', '<span class="lang-th">ติดตามข้อมูลจากหลายแปลงหรือหลายฟาร์มแบบ Real-time ผ่าน Dashboard เดียว</span><span class="lang-en">Monitor real-time data from multiple farms and visualize operations through one centralized dashboard.</span>', 'smart-agriculture'); ?></p>
              <ul class="sa-eng-list svc-caption text-body">
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-clock text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">ข้อมูลแบบ Real-time</span><span class="lang-en">Real-time Data</span></span></li>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-layer-group text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">มุมมองหลายแปลง</span><span class="lang-en">Multi-farm View</span></span></li>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-desktop text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">แดชบอร์ดรวมศูนย์</span><span class="lang-en">Central Dashboard</span></span></li>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-bell text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">การแจ้งเตือน</span><span class="lang-en">Alerts</span></span></li>
              </ul>
          </div>
          <div class="relative bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal sa-eng-card">
            <div class="hidden xl:flex items-center justify-center w-7 h-7 rounded-full bg-brand text-white absolute -right-4 top-24 z-20 border-2 border-white shadow" aria-hidden="true"><i class="fa-solid fa-chevron-right text-[10px]"></i></div>
              <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-50 to-brand-soft border border-brand/15 flex items-center justify-center mx-auto mb-5 mt-1 shadow-sm transition-transform hover:scale-105" aria-hidden="true">
                <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/engine_3.png" alt="STEER" class="w-14 h-14 object-contain filter drop-shadow-sm">
              </div>
              <div class="svc-kicker text-brand mb-1 text-center">03</div>
              <h3 class="font-display svc-h3 text-ink tracking-tight mb-1 text-center">STEER</h3>
              <div data-editable="agri-engine-t-3" <?php echo synergy_style('agri-engine-t-3', 'smart-agriculture'); ?> class="svc-label text-brand mb-4 sa-eng-title text-center"><?php echo synergy_content('agri-engine-t-3', '<span class="lang-th">ควบคุมและสั่งการอัตโนมัติ</span><span class="lang-en">Control &amp; Automate</span>', 'smart-agriculture'); ?></div>
              <p data-editable="agri-engine-d-3" <?php echo synergy_style('agri-engine-d-3', 'smart-agriculture'); ?> class="svc-caption text-muted mb-5 sa-eng-desc text-center"><?php echo synergy_content('agri-engine-d-3', '<span class="lang-th">ควบคุมระบบน้ำ ปั๊ม วาล์ว แสงสว่าง และอุปกรณ์ภาคสนามอัตโนมัติตามเงื่อนไขที่กำหนด</span><span class="lang-en">Automate irrigation, pumps, valves, lighting, and field equipment based on configurable rules.</span>', 'smart-agriculture'); ?></p>
              <ul class="sa-eng-list svc-caption text-body">
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-droplet text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">ควบคุมระบบน้ำ</span><span class="lang-en">Irrigation Control</span></span></li>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-calendar-check text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">ตั้งเวลา</span><span class="lang-en">Scheduling</span></span></li>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-tower-broadcast text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">สั่งงานระยะไกล</span><span class="lang-en">Remote Control</span></span></li>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-plug text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">เชื่อมต่อระบบ</span><span class="lang-en">System Integration</span></span></li>
              </ul>
          </div>
          <div class="relative bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal sa-eng-card">
            <div class="hidden xl:flex items-center justify-center w-7 h-7 rounded-full bg-brand text-white absolute -right-4 top-24 z-20 border-2 border-white shadow" aria-hidden="true"><i class="fa-solid fa-chevron-right text-[10px]"></i></div>
              <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-50 to-brand-soft border border-brand/15 flex items-center justify-center mx-auto mb-5 mt-1 shadow-sm transition-transform hover:scale-105" aria-hidden="true">
                <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/engine_4.png" alt="SOLVE" class="w-14 h-14 object-contain filter drop-shadow-sm">
              </div>
              <div class="svc-kicker text-brand mb-1 text-center">04</div>
              <h3 class="font-display svc-h3 text-ink tracking-tight mb-1 text-center">SOLVE</h3>
              <div data-editable="agri-engine-t-4" <?php echo synergy_style('agri-engine-t-4', 'smart-agriculture'); ?> class="svc-label text-brand mb-4 sa-eng-title text-center"><?php echo synergy_content('agri-engine-t-4', '<span class="lang-th">วิเคราะห์และเพิ่มประสิทธิภาพ</span><span class="lang-en">Analyze &amp; Improve</span>', 'smart-agriculture'); ?></div>
              <p data-editable="agri-engine-d-4" <?php echo synergy_style('agri-engine-d-4', 'smart-agriculture'); ?> class="svc-caption text-muted mb-5 sa-eng-desc text-center"><?php echo synergy_content('agri-engine-d-4', '<span class="lang-th">เปลี่ยนข้อมูลการเกษตรให้เป็นข้อมูลเชิงลึก เพื่อเพิ่มผลผลิตและใช้ทรัพยากรอย่างมีประสิทธิภาพ</span><span class="lang-en">Turn farm data into actionable insights to improve productivity and optimize resource usage.</span>', 'smart-agriculture'); ?></p>
              <ul class="sa-eng-list svc-caption text-body">
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-wand-magic-sparkles text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">วิเคราะห์ด้วย AI</span><span class="lang-en">AI Analytics</span></span></li>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-chart-area text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">คาดการณ์ผลผลิต</span><span class="lang-en">Yield Prediction</span></span></li>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-flask text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">การให้น้ำอัจฉริยะ</span><span class="lang-en">Smart Irrigation</span></span></li>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-file-lines text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">รายงานและ KPI</span><span class="lang-en">Reports &amp; KPI</span></span></li>
              </ul>
          </div>
          <div class="relative bg-white rounded-[24px] p-6 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1 sa-spring sa-reveal sa-eng-card">
              <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-50 to-brand-soft border border-brand/15 flex items-center justify-center mx-auto mb-5 mt-1 shadow-sm transition-transform hover:scale-105" aria-hidden="true">
                <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/engine_5.png" alt="SAVE" class="w-14 h-14 object-contain filter drop-shadow-sm">
              </div>
              <div class="svc-kicker text-brand mb-1 text-center">05</div>
              <h3 class="font-display svc-h3 text-ink tracking-tight mb-1 text-center">SAVE</h3>
              <div data-editable="agri-engine-t-5" <?php echo synergy_style('agri-engine-t-5', 'smart-agriculture'); ?> class="svc-label text-brand mb-4 sa-eng-title text-center"><?php echo synergy_content('agri-engine-t-5', '<span class="lang-th">ลดต้นทุนและเพิ่มผลตอบแทน</span><span class="lang-en">Reduce Costs &amp; Maximize ROI</span>', 'smart-agriculture'); ?></div>
              <p data-editable="agri-engine-d-5" <?php echo synergy_style('agri-engine-d-5', 'smart-agriculture'); ?> class="svc-caption text-muted mb-5 sa-eng-desc text-center"><?php echo synergy_content('agri-engine-d-5', '<span class="lang-th">ใช้ข้อมูลจริงเพื่อวิเคราะห์ต้นทุน ลดการสูญเสีย และเพิ่มประสิทธิภาพการดำเนินงาน เพื่อให้การลงทุนสร้างผลตอบแทนสูงสุด</span><span class="lang-en">Turn operational data into actionable insights to reduce costs, minimize waste, and maximize return on investment.</span>', 'smart-agriculture'); ?></p>
              <ul class="sa-eng-list svc-caption text-body">
                  <?php /* These four read Access Control / Backup / Audit Trail / System
                           Health - an IT-governance list carried over from another page's
                           SAVE step. Nothing under "ลดต้นทุนและเพิ่มผลตอบแทน" was about
                           cost at all. Replaced with the four things this step actually
                           does for a farm's P&L. */ ?>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-coins text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">วิเคราะห์ต้นทุนต่อไร่</span><span class="lang-en">Cost per Rai</span></span></li>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-droplet-slash text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">ลดการสูญเสียน้ำและพลังงาน</span><span class="lang-en">Water &amp; Energy Loss</span></span></li>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-chart-line text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">เปรียบเทียบผลตอบแทนรายฤดู</span><span class="lang-en">Season-on-Season ROI</span></span></li>
                  <li class="flex items-center gap-2.5 sa-eng-li"><i class="fa-solid fa-file-invoice-dollar text-brand w-4 text-center shrink-0" aria-hidden="true"></i><span><span class="lang-th">รายงานต้นทุนและผลตอบแทน</span><span class="lang-en">Cost &amp; Return Reports</span></span></li>
              </ul>
          </div>
        </div>

        <!-- Outcome band, the line the five steps add up to -->
        <div class="mt-10 sm:mt-12 rounded-[24px] bg-surface border border-brand/10 px-6 py-6 sm:px-10 sm:py-7 flex items-center justify-between gap-6 sa-reveal">
          <div class="flex items-center gap-5">
            <span class="w-14 h-14 rounded-full bg-white text-brand flex items-center justify-center shrink-0 border border-brand/10 shadow-sm" aria-hidden="true">
              <i class="fa-solid fa-seedling text-2xl"></i>
            </span>
            <p data-editable="agri-engine-outcome" <?php echo synergy_style('agri-engine-outcome', 'smart-agriculture'); ?> class="svc-copy text-ink"><?php echo synergy_content('agri-engine-outcome', '<span class="lang-th">เพิ่ม<strong class="text-brand">ผลผลิต</strong> ลดต้นทุน ใช้ทรัพยากรอย่างมีประสิทธิภาพ และยกระดับการเกษตรสู่ความแม่นยำและยั่งยืน</span><span class="lang-en">Increase <strong class="text-brand">yields</strong>, reduce costs, optimize resources, and enable sustainable precision agriculture.</span>', 'smart-agriculture'); ?></p>
          </div>
          <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/engine_tractor_art.png" alt="Precision agriculture illustration" class="h-14 sm:h-16 lg:h-20 w-auto object-contain shrink-0 hidden md:block opacity-90">
        </div>
      </div>
    </section>

  <!-- INTERACTIVE PLATFORM SECTION -->
  <section id="energy-platform" class="py-12 sm:py-16 bg-[#f4f7f5] border-y border-slate-200/80" style="scroll-margin-top:96px">
    <div class="sa-shell">
      <div class="platform-card">

        <!-- TOP: pitch + capabilities (Above Tab Bar) -->
        <section class="left-pitch-column top-pitch-layout mb-8">
          <div class="top-pitch-header text-center mb-6">
            <div class="mb-4 flex justify-center">
              <img src="<?php echo get_template_directory_uri(); ?>/image/LOGO SYNEXTA.png" alt="SynExta Logo" class="h-10 sm:h-12 w-auto object-contain drop-shadow-sm">
            </div>
            <h2 data-editable="agri-platform-h2-1" <?php echo synergy_style('agri-platform-h2-1', 'smart-agriculture'); ?> class="main-heading font-display text-center sm:whitespace-nowrap"><?php echo synergy_content('agri-platform-h2-1', '<span class="lang-th">เทคโนโลยีหลักที่ขับเคลื่อน<br class="sm:hidden"> <span class="heading-highlight">Smart Agriculture</span></span><span class="lang-en">The Intelligence Behind<br class="sm:hidden"> <span class="heading-highlight">Smart Agriculture</span></span>', 'smart-agriculture'); ?></h2>
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
              <div class="feature-text">
                <h3 class="feature-title">
                  <span class="lang-th">เชื่อมต่อทุกอุปกรณ์การเกษตร</span>
                  <span class="lang-en">Connect Any Device</span>
                </h3>
                <p class="feature-sub">
                  <span class="lang-th">เชื่อมต่อเซนเซอร์ สถานีอากาศ ระบบน้ำ โดรน กล้อง และอุปกรณ์การเกษตรหลากหลายผ่านแพลตฟอร์มเดียว</span>
                  <span class="lang-en">Connect sensors, weather stations, irrigation systems, drones, cameras, and other agricultural devices through one platform.</span>
                </p>
              </div>
            </div>

            <div class="feature-card">
              <div class="feature-icon-box">
                <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_val_scale.png" alt="Manage Every Farm" class="w-7 h-7 object-contain">
              </div>
              <div class="feature-text">
                <h3 class="feature-title">
                  <span class="lang-th">บริหารทุกแปลงจากศูนย์กลาง</span>
                  <span class="lang-en">Manage Every Farm</span>
                </h3>
                <p class="feature-sub">
                  <span class="lang-th">ติดตามข้อมูลจากหลายแปลง หลายฟาร์ม หรือหลายโครงการ ผ่าน Dashboard เดียวแบบ Real-time</span>
                  <span class="lang-en">Monitor multiple farms, plots, and agricultural projects in real time from one centralized dashboard.</span>
                </p>
              </div>
            </div>

            <div class="feature-card">
              <div class="feature-icon-box">
                <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_val_mobile.png" alt="Deploy Anywhere" class="w-7 h-7 object-contain">
              </div>
              <div class="feature-text">
                <h3 class="feature-title">
                  <span class="lang-th">ติดตั้งได้ทุกสภาพแวดล้อม</span>
                  <span class="lang-en">Deploy Anywhere</span>
                </h3>
                <p class="feature-sub">
                  <span class="lang-th">รองรับการติดตั้งแบบ Cloud, On-Premise หรือ Hybrid ให้เหมาะกับทุกพื้นที่และโครงสร้างระบบ</span>
                  <span class="lang-en">Deploy on Cloud, On-Premise, or Hybrid to fit your infrastructure and connectivity.</span>
                </p>
              </div>
            </div>

            <div class="feature-card">
              <div class="feature-icon-box">
                <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_val_yield.png" alt="Integrate Everything" class="w-7 h-7 object-contain">
              </div>
              <div class="feature-text">
                <h3 class="feature-title">
                  <span class="lang-th">เชื่อมต่อทุกระบบ</span>
                  <span class="lang-en">Integrate Everything</span>
                </h3>
                <p class="feature-sub">
                  <span class="lang-th">เชื่อมต่อระบบบริหารฟาร์ม GIS แพลตฟอร์มสภาพอากาศ ERP และระบบอื่น ๆ ผ่าน Open API</span>
                  <span class="lang-en">Integrate with farm management systems, GIS, weather platforms, ERP, and third-party services through Open API.</span>
                </p>
              </div>
            </div>

          </div>
        </section>

        <!-- ---------- Tab bar ---------- -->
        <header class="app-header">
          <div class="nav-tabs-wrap"><div class="nav-tabs" role="tablist" aria-label="SynExta Energy Platform">

            <button type="button" class="nav-tab active" role="tab" aria-selected="true" aria-controls="view-overview" id="tab-overview" data-tab="overview">
              <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <rect x="3" y="3" width="7" height="7" rx="1"></rect><rect x="14" y="3" width="7" height="7" rx="1"></rect>
                <rect x="14" y="14" width="7" height="7" rx="1"></rect><rect x="3" y="14" width="7" height="7" rx="1"></rect>
              </svg>
              <?php /* Label only. The id, data-tab and aria-controls still say "overview"
                       and must keep saying it: energy-platform.js pairs a tab to its panel
                       by matching data-tab against view-<name>, so renaming the hook here
                       without renaming #view-overview would leave the tab wired to
                       nothing. */ ?>
              <span><span class="lang-th">แดชบอร์ด</span><span class="lang-en">Dashboard</span></span>
              <div class="tab-indicator"></div>
            </button>

            <button type="button" class="nav-tab" role="tab" aria-selected="false" tabindex="-1" aria-controls="view-sites" id="tab-sites" data-tab="sites">
              <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M3 21h18M3 7v14M13 3v18M13 11h8v10M7 11h2M7 15h2"></path>
              </svg>
              <span><span class="lang-th">ไซต์งาน</span><span class="lang-en">Sites</span></span>
            </button>



          </div><span class="nav-scroll-cue nav-scroll-cue--left" aria-hidden="true">‹</span><span class="nav-scroll-cue nav-scroll-cue--right" aria-hidden="true">›</span></div>
        </header>

        <!-- ---------- Panels ---------- -->
        <div class="content-container">

          <!-- OVERVIEW -->
          <div id="view-overview" class="tab-view active" role="tabpanel" aria-labelledby="tab-overview">

            <div class="grid-architecture">

              <!-- CENTER: 3D core + field devices -->
              <section class="center-engine-column">

                <!-- Architecture Diagram Screen Frame -->
                <div class="screen-frame mb-8">
                  <div class="screen-chrome" aria-hidden="true">
                    <span class="screen-dot"></span><span class="screen-dot"></span><span class="screen-dot"></span>
                    <span class="screen-chrome-label">SynExta Agriculture · <span class="lang-th">แดชบอร์ด</span><span class="lang-en">Dashboard</span></span>
                  </div>
                  <?php /* agri_architecture_1.jpg and agri_dash_1.jpg are byte-identical
                           (same MD5). The picture is a zone irrigation dashboard, not an
                           architecture diagram, so the reference moves to the filename
                           that describes it - the tab above it says Dashboard now. */ ?>
                  <button type="button" class="screen-shot-btn" data-shot-alt="Smart Agriculture Dashboard">
                    <img class="screen-shot" width="1895" height="937" loading="lazy" decoding="async"
                         src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_dash_1.jpg"
                         alt="หน้าจอแดชบอร์ด Smart Agriculture แสดงสถานะและโหมดการทำงานของโซนที่ 1 ถึง 4 สวิตช์ควบคุมรายโซน และตารางตั้งเวลาเปิดปิดอัตโนมัติ">
                  </button>
                  <div class="screen-zoom-hint">🔍 <span class="lang-th">คลิกที่ภาพเพื่อดูขนาดเต็ม</span><span class="lang-en">Click the image to enlarge</span></div>
                </div>

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

                    <button type="button" class="device-card" data-device="weather-station">
                      <span class="device-img-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_dev_weather.png" alt="Weather Station" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="text-xs text-brand font-semibold mb-0.5 block text-center">01</span>
                      <span class="device-name text-center"><span class="lang-th">สถานีตรวจวัดสภาพอากาศ</span><span class="lang-en">Weather Station</span></span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                          <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line>
                        </svg>
                      </span>
                    </button>

                    <button type="button" class="device-card" data-device="soil-sensor">
                      <span class="device-img-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_dev_soil.png" alt="Soil Sensor" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="text-xs text-brand font-semibold mb-0.5 block text-center">02</span>
                      <span class="device-name text-center"><span class="lang-th">เซนเซอร์ดิน</span><span class="lang-en">Soil Sensor</span></span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                          <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line>
                        </svg>
                      </span>
                    </button>

                    <button type="button" class="device-card" data-device="water-quality-sensor">
                      <span class="device-img-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_dev_water.png" alt="Water Quality Sensor" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="text-xs text-brand font-semibold mb-0.5 block text-center">03</span>
                      <span class="device-name text-center"><span class="lang-th">เซนเซอร์คุณภาพน้ำ</span><span class="lang-en">Water Quality Sensor</span></span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                          <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line>
                        </svg>
                      </span>
                    </button>

                    <button type="button" class="device-card" data-device="smart-irrigation">
                      <span class="device-img-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_dev_irrigation.png" alt="Smart Irrigation" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="text-xs text-brand font-semibold mb-0.5 block text-center">04</span>
                      <span class="device-name text-center"><span class="lang-th">ระบบน้ำอัจฉริยะ</span><span class="lang-en">Smart Irrigation</span></span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                          <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line>
                        </svg>
                      </span>
                    </button>

                    <button type="button" class="device-card" data-device="smart-pump">
                      <span class="device-img-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_dev_pump.png" alt="Smart Pump" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="text-xs text-brand font-semibold mb-0.5 block text-center">05</span>
                      <span class="device-name text-center"><span class="lang-th">ปั๊มน้ำอัจฉริยะ</span><span class="lang-en">Smart Pump</span></span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                          <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line>
                        </svg>
                      </span>
                    </button>

                    <button type="button" class="device-card" data-device="iot-gateway">
                      <span class="device-img-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_dev_gateway.png" alt="IoT Gateway" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="text-xs text-brand font-semibold mb-0.5 block text-center">06</span>
                      <span class="device-name text-center"><span class="lang-th">IoT Gateway</span><span class="lang-en">IoT Gateway</span></span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                          <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line>
                        </svg>
                      </span>
                    </button>

                  </div>
                </div>

              </section>

              <!-- RIGHT: deployment options -->
              <section class="right-deployment-column">
                <div class="deployment-cards-stack">

                  <svg class="stack-connector-svg" viewBox="0 0 60 388" aria-hidden="true">
                    <defs>
                      <linearGradient id="ep-flowGradRight" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#10B981" stop-opacity="0.5"></stop>
                        <stop offset="100%" stop-color="#00A86B" stop-opacity="1"></stop>
                      </linearGradient>
                      <marker id="ep-arrowRight" viewBox="0 0 10 10" refX="6" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
                        <path d="M 0 1.5 L 8 5 L 0 8.5 z" fill="#00A86B"></path>
                      </marker>
                    </defs>
                    <path d="M 0 194 H 25 V 72.5 H 56" fill="none" stroke="url(#ep-flowGradRight)" stroke-width="2.5" stroke-dasharray="5 4" marker-end="url(#ep-arrowRight)"></path>
                    <path d="M 0 194 H 25 V 315.5 H 56" fill="none" stroke="url(#ep-flowGradRight)" stroke-width="2.5" stroke-dasharray="5 4" marker-end="url(#ep-arrowRight)"></path>
                    <circle cx="2" cy="194" r="3.5" fill="#00A86B"></circle>
                    <circle cx="25" cy="194" r="3.5" fill="#10B981"></circle>
                  </svg>

                  <div class="deployment-card-square">
                    <div class="deploy-img-box">
                      <?php /* image/smart-factory/capabilities/ has never existed in this
                               repository, so both of these were 404s showing a broken-image
                               glyph next to their own labels. They now point at 160px
                               renders of the line art the Smart Factory page uses, kept in
                               this page's own folder: the originals are ~900 KB each at
                               1240px, for a box that is 75px wide. */ ?>
                      <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_deploy_cloud.png" alt="" class="deploy-img" loading="lazy" decoding="async">
                    </div>
                    <span class="deploy-label"><span class="lang-th">คลาวด์</span><span class="lang-en">Cloud</span></span>
                  </div>

                  <div class="deploy-vertical-dash"></div>
                  <div class="divider-or-circle"><span>OR</span></div>
                  <div class="deploy-vertical-dash"></div>

                  <div class="deployment-card-square">
                    <div class="deploy-img-box">
                      <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_deploy_onprem.png" alt="" class="deploy-img" loading="lazy" decoding="async">
                    </div>
                    <span class="deploy-label"><span class="lang-th">ภายในองค์กร</span><span class="lang-en">On-Premise</span></span>
                  </div>

                </div>
              </section>

            </div>
          </div>

          <!-- SITES -->
          <div id="view-sites" class="tab-view" role="tabpanel" aria-labelledby="tab-sites">
            <div class="grid-architecture">

              <!-- CENTER: screen frame + field devices -->
              <section class="center-engine-column">

                <div class="screen-frame mb-8">
                  <div class="screen-chrome" aria-hidden="true">
                    <span class="screen-dot"></span><span class="screen-dot"></span><span class="screen-dot"></span>
                    <span class="screen-chrome-label">SynExta Agriculture · <span class="lang-th">ไซต์งาน</span><span class="lang-en">Sites</span></span>
                  </div>
                  <button type="button" class="screen-shot-btn" data-shot-alt="Smart Agriculture site view">
                    <img class="screen-shot" width="1890" height="933" loading="lazy" decoding="async"
                         src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_sites_1.jpg"
                         alt="หน้าจอไซต์งาน แสดงแผนผังสวนทุเรียนแบ่งเป็นโซนที่ 1 ถึง 4 พร้อมค่าจากเซนเซอร์สภาพแวดล้อมในดินและในอากาศแบบ Real-time">
                  </button>
                  <div class="screen-zoom-hint">🔍 <span class="lang-th">คลิกที่ภาพเพื่อดูขนาดเต็ม</span><span class="lang-en">Click the image to enlarge</span></div>
                </div>

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

                    <button type="button" class="device-card" data-device="weather-station">
                      <span class="device-img-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_dev_weather.png" alt="Weather Station" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="text-xs text-brand font-semibold mb-0.5 block text-center">01</span>
                      <span class="device-name text-center"><span class="lang-th">สถานีตรวจวัดสภาพอากาศ</span><span class="lang-en">Weather Station</span></span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                          <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line>
                        </svg>
                      </span>
                    </button>

                    <button type="button" class="device-card" data-device="soil-sensor">
                      <span class="device-img-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_dev_soil.png" alt="Soil Sensor" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="text-xs text-brand font-semibold mb-0.5 block text-center">02</span>
                      <span class="device-name text-center"><span class="lang-th">เซนเซอร์ดิน</span><span class="lang-en">Soil Sensor</span></span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                          <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line>
                        </svg>
                      </span>
                    </button>

                    <button type="button" class="device-card" data-device="water-quality-sensor">
                      <span class="device-img-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_dev_water.png" alt="Water Quality Sensor" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="text-xs text-brand font-semibold mb-0.5 block text-center">03</span>
                      <span class="device-name text-center"><span class="lang-th">เซนเซอร์คุณภาพน้ำ</span><span class="lang-en">Water Quality Sensor</span></span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                          <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line>
                        </svg>
                      </span>
                    </button>

                    <button type="button" class="device-card" data-device="smart-irrigation">
                      <span class="device-img-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_dev_irrigation.png" alt="Smart Irrigation" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="text-xs text-brand font-semibold mb-0.5 block text-center">04</span>
                      <span class="device-name text-center"><span class="lang-th">ระบบน้ำอัจฉริยะ</span><span class="lang-en">Smart Irrigation</span></span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                          <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line>
                        </svg>
                      </span>
                    </button>

                    <button type="button" class="device-card" data-device="smart-pump">
                      <span class="device-img-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_dev_pump.png" alt="Smart Pump" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="text-xs text-brand font-semibold mb-0.5 block text-center">05</span>
                      <span class="device-name text-center"><span class="lang-th">ปั๊มน้ำอัจฉริยะ</span><span class="lang-en">Smart Pump</span></span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                          <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line>
                        </svg>
                      </span>
                    </button>

                    <button type="button" class="device-card" data-device="iot-gateway">
                      <span class="device-img-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_dev_gateway.png" alt="IoT Gateway" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="text-xs text-brand font-semibold mb-0.5 block text-center">06</span>
                      <span class="device-name text-center"><span class="lang-th">IoT Gateway</span><span class="lang-en">IoT Gateway</span></span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                          <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line>
                        </svg>
                      </span>
                    </button>

                  </div>
                </div>

              </section>

              <!-- RIGHT: deployment options -->
              <section class="right-deployment-column">
                <div class="deployment-cards-stack">

                  <svg class="stack-connector-svg" viewBox="0 0 60 388" aria-hidden="true">
                    <path d="M 0 194 H 25 V 72.5 H 56" fill="none" stroke="url(#ep-flowGradRight)" stroke-width="2.5" stroke-dasharray="5 4" marker-end="url(#ep-arrowRight)"></path>
                    <path d="M 0 194 H 25 V 315.5 H 56" fill="none" stroke="url(#ep-flowGradRight)" stroke-width="2.5" stroke-dasharray="5 4" marker-end="url(#ep-arrowRight)"></path>
                    <circle cx="2" cy="194" r="3.5" fill="#00A86B"></circle>
                    <circle cx="25" cy="194" r="3.5" fill="#10B981"></circle>
                  </svg>

                  <div class="deployment-card-square">
                    <div class="deploy-img-box">
                      <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_deploy_cloud.png" alt="" class="deploy-img" loading="lazy" decoding="async">
                    </div>
                    <span class="deploy-label"><span class="lang-th">คลาวด์</span><span class="lang-en">Cloud</span></span>
                  </div>

                  <div class="deploy-vertical-dash"></div>
                  <div class="divider-or-circle"><span>OR</span></div>
                  <div class="deploy-vertical-dash"></div>

                  <div class="deployment-card-square">
                    <div class="deploy-img-box">
                      <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/agri_deploy_onprem.png" alt="" class="deploy-img" loading="lazy" decoding="async">
                    </div>
                    <span class="deploy-label"><span class="lang-th">ภายในองค์กร</span><span class="lang-en">On-Premise</span></span>
                  </div>

                </div>
              </section>

            </div>
          </div>



        </div>

        <?php /* energy-platform.js wires every .screen-shot-btn to this element and
                 bails out if it is missing. It was missing on this page, so both
                 screenshots carried a "คลิกที่ภาพเพื่อดูขนาดเต็ม" hint under them and
                 tapping did nothing at all. Same markup smart-factory.php uses -
                 the script finds it by class within #energy-platform. */ ?>
        <!-- ---------- Screenshot lightbox ---------- -->
        <div class="shot-lightbox" role="dialog" aria-modal="true" aria-label="Enlarged screenshot">
          <button type="button" class="shot-lightbox-close" aria-label="Close">&times;</button>
          <img alt="">
        </div>

      </div>
    </div>
  </section>


  <!-- =============================================
       WHO IS THIS FOR — 5 audience photo cards
       ============================================= -->
  <section id="agri-audience" aria-labelledby="agri-audience-title" class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-6">

      <!-- Header -->
      <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 sa-reveal">
        <div class="inline-flex items-center gap-2 justify-center mb-4">
          <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
          <span class="text-brand svc-kicker"><span class="lang-th">โซลูชันนี้เหมาะกับใคร</span><span class="lang-en">Who Is This Solution For?</span></span>
        </div>
        <h2 id="agri-audience-title" class="font-display svc-h2 text-ink tracking-tight mb-5">
          <span class="lang-th">ออกแบบเพื่อทุกภาคส่วนของการเกษตร</span>
          <span class="lang-en">Built for Every Agricultural Sector</span>
        </h2>
        <p class="svc-lede text-body">
          <span class="lang-th">รองรับทุกกลุ่มผู้ใช้งาน ตอบโจทย์ทุกความต้องการของธุรกิจการเกษตรยุคใหม่</span>
          <span class="lang-en">Designed to support every stakeholder across the agricultural ecosystem with a scalable smart farming platform.</span>
        </p>
      </div>

      <!-- 5-column photo cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-5 sa-reveal">

        <!-- Card 1 -->
        <div class="bg-white rounded-[20px] border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full overflow-hidden text-center">
          <div class="h-44 sm:h-48 overflow-hidden w-full">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/audience_farmer.jpg" alt="เกษตรกรและฟาร์มเอกชน" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
          </div>
          <div class="p-5 flex flex-col items-center flex-grow justify-between">
            <div>
              <h3 class="svc-label text-ink font-bold mb-2 sa-aud-h3">
                <span class="lang-th">เกษตรกรและฟาร์มเอกชน</span>
                <span class="lang-en">Farmers &amp; Private Farms</span>
              </h3>
              <div class="w-8 h-0.5 bg-brand mx-auto mb-3"></div>
            </div>
            <p class="svc-caption text-slate-500 leading-relaxed text-xs sm:text-[13px]">
              <span class="lang-th">ติดตามข้อมูลภาคสนามแบบ Real-time ควบคุมระบบน้ำและอุปกรณ์ พร้อมบริหารจัดการฟาร์มผ่าน Dashboard เดียว</span>
              <span class="lang-en">Monitor field conditions in real time, control irrigation systems and devices, and manage farm operations through one centralized dashboard.</span>
            </p>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-[20px] border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full overflow-hidden text-center">
          <div class="h-44 sm:h-48 overflow-hidden w-full">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/audience_coop.jpg" alt="สหกรณ์และผู้รวบรวมผลผลิต" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
          </div>
          <div class="p-5 flex flex-col items-center flex-grow justify-between">
            <div>
              <h3 class="svc-label text-ink font-bold mb-2 sa-aud-h3">
                <?php /* The <br> sat straight after "&" with no space, so the accessible
                         name and anything copied off the page came out "Cooperatives
                         &Agribusiness". The five cards now wrap naturally and are held to
                         the same height by .sa-aud-h3 instead of hand-placed breaks. */ ?>
                <span class="lang-th">สหกรณ์และผู้รวบรวมผลผลิต</span>
                <span class="lang-en">Cooperatives &amp; Agribusiness</span>
              </h3>
              <div class="w-8 h-0.5 bg-brand mx-auto mb-3"></div>
            </div>
            <p class="svc-caption text-slate-500 leading-relaxed text-xs sm:text-[13px]">
              <span class="lang-th">บริหารจัดการหลายพื้นที่เพาะปลูก ติดตามข้อมูลสมาชิกแบบ Real-time และเพิ่มประสิทธิภาพการดำเนินงาน</span>
              <span class="lang-en">Manage multiple farming areas, monitor member operations in real time, and improve operational efficiency.</span>
            </p>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-[20px] border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full overflow-hidden text-center">
          <div class="h-44 sm:h-48 overflow-hidden w-full">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/audience_gov.jpg" alt="หน่วยงานภาครัฐ" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
          </div>
          <div class="p-5 flex flex-col items-center flex-grow justify-between">
            <div>
              <h3 class="svc-label text-ink font-bold mb-2 sa-aud-h3">
                <span class="lang-th">หน่วยงานภาครัฐ</span>
                <?php /* "(GPS)" was here. On an IoT agriculture page that abbreviation
                         reads as Global Positioning System, and the Thai side has no
                         abbreviation at all. Dropped. */ ?>
                <span class="lang-en">Government &amp; Public Sector</span>
              </h3>
              <div class="w-8 h-0.5 bg-brand mx-auto mb-3"></div>
            </div>
            <p class="svc-caption text-slate-500 leading-relaxed text-xs sm:text-[13px]">
              <span class="lang-th">รองรับโครงการเกษตรขนาดใหญ่ ติดตามข้อมูลหลายพื้นที่จากศูนย์กลาง และสนับสนุนการบริหารจัดการเชิงนโยบาย</span>
              <span class="lang-en">Support large-scale agricultural projects with centralized monitoring and data-driven policy management.</span>
            </p>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-[20px] border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full overflow-hidden text-center">
          <div class="h-44 sm:h-48 overflow-hidden w-full">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/audience_research.jpg" alt="มหาวิทยาลัยและศูนย์วิจัย" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
          </div>
          <div class="p-5 flex flex-col items-center flex-grow justify-between">
            <div>
              <h3 class="svc-label text-ink font-bold mb-2 sa-aud-h3">
                <span class="lang-th">มหาวิทยาลัยและศูนย์วิจัย</span>
                <span class="lang-en">Universities &amp; Research Centers</span>
              </h3>
              <div class="w-8 h-0.5 bg-brand mx-auto mb-3"></div>
            </div>
            <p class="svc-caption text-slate-500 leading-relaxed text-xs sm:text-[13px]">
              <span class="lang-th">เหมาะสำหรับแปลงทดลอง งานวิจัย และการเก็บข้อมูลภาคสนาม เพื่อพัฒนานวัตกรรมการเกษตร</span>
              <span class="lang-en">Ideal for research plots, field experiments, and agricultural data collection to support innovation.</span>
            </p>
          </div>
        </div>

        <!-- Card 5 -->
        <div class="bg-white rounded-[20px] border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full overflow-hidden text-center">
          <div class="h-44 sm:h-48 overflow-hidden w-full">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-agriculture/audience_enterprise.jpg" alt="โครงการเกษตรขนาดใหญ่" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
          </div>
          <div class="p-5 flex flex-col items-center flex-grow justify-between">
            <div>
              <h3 class="svc-label text-ink font-bold mb-2 sa-aud-h3">
                <span class="lang-th">โครงการเกษตรขนาดใหญ่</span>
                <span class="lang-en">Large-scale Agricultural Projects</span>
              </h3>
              <div class="w-8 h-0.5 bg-brand mx-auto mb-3"></div>
            </div>
            <p class="svc-caption text-slate-500 leading-relaxed text-xs sm:text-[13px]">
              <span class="lang-th">รองรับตั้งแต่แปลงทดลองจนถึงพื้นที่ขนาดใหญ่ ด้วย LoRaWAN และการบริหารหลายพื้นที่จากศูนย์กลาง</span>
              <span class="lang-en">Scale from pilot plots to enterprise-scale agricultural projects with LoRaWAN connectivity and centralized management.</span>
            </p>
          </div>
        </div>
      </div>

        <!-- Footer highlights. Four short claims that apply to every audience
             above, so they sit under the row rather than repeating in each
             card. Outside the five-column card grid: as a sixth grid item it
             was squeezed into one 223px column. -->
        <ul class="mt-10 sm:mt-12 grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 sa-reveal">
          <li class="flex items-center gap-3 bg-[#f4f7f5] border border-slate-200/70 rounded-2xl px-4 py-3.5">
            <i class="fa-solid fa-arrows-up-down-left-right text-brand shrink-0" aria-hidden="true"></i>
            <span class="svc-caption text-ink font-medium leading-snug"><span class="lang-th">รองรับทุกขนาดพื้นที่</span><span class="lang-en">Scalable for Every Farm Size</span></span>
          </li>
          <li class="flex items-center gap-3 bg-[#f4f7f5] border border-slate-200/70 rounded-2xl px-4 py-3.5">
            <i class="fa-solid fa-microchip text-brand shrink-0" aria-hidden="true"></i>
            <span class="svc-caption text-ink font-medium leading-snug"><span class="lang-th">เชื่อมต่ออุปกรณ์หลากหลาย</span><span class="lang-en">Connect Multiple Devices</span></span>
          </li>
          <li class="flex items-center gap-3 bg-[#f4f7f5] border border-slate-200/70 rounded-2xl px-4 py-3.5">
            <i class="fa-solid fa-circle-check text-brand shrink-0" aria-hidden="true"></i>
            <span class="svc-caption text-ink font-medium leading-snug"><span class="lang-th">ข้อมูลแม่นยำ เชื่อถือได้</span><span class="lang-en">Accurate &amp; Reliable Data</span></span>
          </li>
          <li class="flex items-center gap-3 bg-[#f4f7f5] border border-slate-200/70 rounded-2xl px-4 py-3.5">
            <i class="fa-solid fa-seedling text-brand shrink-0" aria-hidden="true"></i>
            <span class="svc-caption text-ink font-medium leading-snug"><span class="lang-th">พร้อมขยายในอนาคต</span><span class="lang-en">Ready to Scale</span></span>
          </li>
        </ul>

    </div>
  </section>

  <!-- =============================================
       PLATFORM CAPABILITIES — 2×6 icon grid
       ============================================= -->
  <section id="agri-capabilities" aria-labelledby="agri-cap-title" class="py-16 sm:py-20 bg-[#f4f7f5]">
    <div class="max-w-7xl mx-auto px-5 sm:px-6">

      <!-- Header -->
      <div class="text-center max-w-4xl mx-auto mb-12 sm:mb-16 sa-reveal">
        <div class="inline-flex items-center gap-2 justify-center mb-4">
          <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
          <span class="text-brand svc-kicker"><span class="lang-th">ความสามารถของระบบ</span><span class="lang-en">System Capabilities</span></span>
        </div>
        <h2 id="agri-cap-title" class="font-display svc-h2 text-ink tracking-tight mb-3">
          <span class="lang-th">Smart Agriculture Platform<br><span class="text-brand">รองรับทุกขนาดพื้นที่การเกษตร</span></span>
          <span class="lang-en">Smart Agriculture Platform<br><span class="text-brand">for Farms of Every Size</span></span>
        </h2>
        <p class="svc-lede text-body">
          <span class="lang-th">จากแปลงเล็กสู่พื้นที่ขนาดใหญ่ เชื่อมต่ออุปกรณ์ภาคสนาม เก็บข้อมูลแบบ Real-time<br>และบริหารจัดการผ่านแพลตฟอร์มเดียว</span>
          <span class="lang-en">From small farms to large-scale agricultural projects,<br>connect field devices, collect <span class="whitespace-nowrap">real-time</span> data, and manage everything through one intelligent platform.</span>
        </p>
      </div>

      <!-- 2×6 capability tiles.
           Each tile is its own bordered white card rather than twelve icons
           floating inside one big panel: at six across, a shared panel left the
           columns reading as one run-on row with no edge to separate a label
           from the icon beside it. -->
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 sa-reveal">

        <?php
        /* 'img' is a PNG in image/smart-agriculture/; 'icon' is the Font Awesome
           fallback used until that PNG exists, so a missing artwork file
           degrades to a glyph instead of a broken image. */
        $agri_caps = [
          ['img'=>'agri_cap_1.png',  'icon'=>'fa-satellite-dish',  'th'=>'ติดตามสภาพแวดล้อม<br>แบบ Real-time',          'en'=>'Real-time Environmental<br>Monitoring'],
          ['img'=>'agri_cap_2.png',  'icon'=>'fa-microchip',        'th'=>'รองรับเซนเซอร์และอุปกรณ์<br>เกษตรหลากหลาย',  'en'=>'Multi-sensor &amp;<br>Device Support'],
          ['img'=>'agri_cap_3.png',  'icon'=>'fa-tower-broadcast',  'th'=>'รับส่งข้อมูลระยะไกลด้วย<br>LoRaWAN',          'en'=>'Long-range<br>LoRaWAN Connectivity'],
          ['img'=>'agri_cap_4.png',  'icon'=>'fa-map-location-dot', 'th'=>'แดชบอร์ดรวมศูนย์<br>บริหารหลายแปลง',        'en'=>'Centralized<br>Multi-farm Dashboard'],
          ['img'=>'agri_cap_5.png',  'icon'=>'fa-bell',             'th'=>'แจ้งเตือนและตัดสินใจ<br>ได้รวดเร็ว',         'en'=>'Smart Alerts &amp;<br>Faster Decisions'],
          ['img'=>'agri_cap_6.png',  'icon'=>'fa-shield-halved',    'th'=>'กำหนดสิทธิ์ผู้ใช้งาน<br>อย่างปลอดภัย',      'en'=>'Role-Based<br>Access Control'],
          ['img'=>'agri_cap_7.png',  'icon'=>'fa-sliders',          'th'=>'ควบคุมระบบน้ำและอุปกรณ์<br>จากระยะไกล',      'en'=>'Remote Irrigation<br>&amp; Device Control'],
          ['img'=>'agri_cap_8.png',  'icon'=>'fa-chart-bar',        'th'=>'วิเคราะห์ข้อมูลและ<br>คาดการณ์ผลผลิต',       'en'=>'Analytics &amp;<br>Yield Prediction'],
          ['img'=>'agri_cap_9.png',  'icon'=>'fa-building',         'th'=>'รองรับทุกขนาด<br>พื้นที่การเกษตร',           'en'=>'Scalable for<br>Every Farm Size'],
          ['img'=>'agri_cap_10.png', 'icon'=>'fa-cloud',            'th'=>'รองรับ Cloud และ<br>On-Premise',               'en'=>'Cloud &amp;<br>On-Premise Deployment'],
          ['img'=>'agri_cap_11.png', 'icon'=>'fa-plug-circle-bolt', 'th'=>'เชื่อมต่อระบบ<br>ผ่าน Open API',              'en'=>'Open API<br>Integration'],
          ['img'=>'agri_cap_12.png', 'icon'=>'fa-database',         'th'=>'บันทึกข้อมูลและ<br>ประวัติการใช้งาน',         'en'=>'Data Logging &amp;<br>History Tracking'],
        ];
        $agri_cap_dir_fs  = __DIR__ . '/image/smart-agriculture/';
        $agri_cap_dir_uri = get_template_directory_uri() . '/image/smart-agriculture/';
        foreach ($agri_caps as $cap):
          $cap_has_img = file_exists($agri_cap_dir_fs . $cap['img']); ?>
        <div class="bg-white rounded-2xl border border-slate-200/70 shadow-[0_1px_3px_rgba(0,0,0,0.04)] hover:shadow-bento-hover hover:-translate-y-1 sa-spring px-3 py-6 sm:px-4 flex flex-col items-center text-center gap-3.5 group sa-reveal">
          <div class="w-14 h-14 rounded-2xl bg-brand-soft text-brand flex items-center justify-center text-xl shrink-0 overflow-hidden sa-spring" aria-hidden="true">
            <?php if ($cap_has_img): ?>
            <img src="<?php echo $agri_cap_dir_uri . $cap['img']; ?>" alt="" loading="lazy" decoding="async" class="w-9 h-9 object-contain">
            <?php else: ?>
            <i class="fa-solid <?php echo $cap['icon']; ?>"></i>
            <?php endif; ?>
          </div>
          <span class="svc-caption text-ink font-medium leading-snug">
            <span class="lang-th"><?php echo $cap['th']; ?></span>
            <span class="lang-en"><?php echo $cap['en']; ?></span>
          </span>
        </div>
        <?php endforeach; ?>

      </div>
    </div>
  </section>

  <!-- =============================================
       MEASURABLE RESULTS — 6 outcome cards 01-06
       ============================================= -->
  <section id="agri-results" aria-labelledby="agri-results-title" class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-6">

      <!-- Header -->
      <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 sa-reveal">
        <div class="inline-flex items-center gap-2 justify-center mb-4">
          <span class="w-1.5 h-6 bg-brand rounded-full" aria-hidden="true"></span>
          <?php /* Was "ผลลัพร์" (missing ธ) in both the kicker and the H2 below, and the
                   kicker repeated the H2 word for word with an emoji on the end. The
                   kicker now names the section, the H2 makes the claim. */ ?>
          <span class="text-brand svc-kicker"><span class="lang-th">ผลลัพธ์เชิงตัวเลข</span><span class="lang-en">MEASURABLE IMPACT</span></span>
        </div>
        <h2 id="agri-results-title" class="font-display svc-h2 text-ink tracking-tight mb-4">
          <span class="lang-th">ผลลัพธ์ที่วัดผลได้จริง</span>
          <span class="lang-en">Real, Measurable Outcomes</span>
        </h2>
        <p class="svc-lede text-body">
          <span class="lang-th">ระบบ Smart Agriculture ช่วยลดต้นทุน เพิ่มผลผลิต และยกระดับการเกษตรอย่างยั่งยืน</span>
          <span class="lang-en">Smart Agriculture helps cut costs, boost yield, and elevate farming sustainability.</span>
        </p>
      </div>

      <!-- 3×2 result cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sa-reveal">

        <!-- 01 -->
        <div class="bg-white rounded-[24px] p-7 border border-slate-200/70 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1.5 sa-spring group">
          <div class="flex items-start gap-4 mb-5">
            <div class="w-12 h-12 rounded-full bg-brand-soft text-brand flex items-center justify-center text-xl shrink-0 group-hover:bg-brand group-hover:text-white sa-spring" aria-hidden="true">
              <i class="fa-solid fa-coins"></i>
            </div>
            <div>
              <div class="text-brand svc-kicker font-bold mb-0.5">01</div>
              <h3 class="svc-label text-ink font-semibold">
                <span class="lang-th">ลดต้นทุนการผลิต</span>
                <span class="lang-en">Lower Operating Costs</span>
              </h3>
            </div>
          </div>
          <p class="svc-copy text-body mb-5">
            <span class="lang-th">บริหารจัดการน้ำ พลังงาน เมล็ดพันธุ์ และสารเคมีได้อย่างมีประสิทธิภาพ</span>
            <span class="lang-en">Efficiently manage water, energy, seeds, and chemicals to cut production costs.</span>
          </p>
          <div class="rounded-2xl bg-[#f4f7f5] border border-slate-200/70 px-4 py-4">
            <div class="flex items-center gap-2 mb-1">
              <i class="fa-solid fa-arrow-trend-down text-brand text-sm" aria-hidden="true"></i>
              <span class="svc-kicker text-ink">
                <span class="lang-th">ลดต้นทุนสูงสุด</span>
                <span class="lang-en">Cost savings up to</span>
              </span>
            </div>
            <div class="font-display text-3xl font-bold text-brand">500–1,100</div>
            <div class="svc-caption text-muted">
              <span class="lang-th">บาท/ไร่*</span>
              <span class="lang-en">THB/rai*</span>
            </div>
          </div>
        </div>

        <!-- 02 -->
        <div class="bg-white rounded-[24px] p-7 border border-slate-200/70 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1.5 sa-spring group">
          <div class="flex items-start gap-4 mb-5">
            <div class="w-12 h-12 rounded-full bg-brand-soft text-brand flex items-center justify-center text-xl shrink-0 group-hover:bg-brand group-hover:text-white sa-spring" aria-hidden="true">
              <i class="fa-solid fa-seedling"></i>
            </div>
            <div>
              <div class="text-brand svc-kicker font-bold mb-0.5">02</div>
              <h3 class="svc-label text-ink font-semibold">
                <span class="lang-th">เพิ่มผลผลิต</span>
                <span class="lang-en">Increase Productivity</span>
              </h3>
            </div>
          </div>
          <p class="svc-copy text-body mb-5">
            <span class="lang-th">ควบคุมสภาพแวดล้อมได้แม่นยำ ข้าวแข็งแรง ผลผลิตต่อไร่สูงขึ้น</span>
            <span class="lang-en">Precise environment control makes crops healthier and increases yield per rai.</span>
          </p>
          <div class="rounded-2xl bg-[#f4f7f5] border border-slate-200/70 px-4 py-4">
            <div class="flex items-center gap-2 mb-1">
              <i class="fa-solid fa-arrow-trend-up text-brand text-sm" aria-hidden="true"></i>
              <span class="svc-kicker text-ink">
                <span class="lang-th">เพิ่มรอบการผลิตจาก</span>
                <span class="lang-en">Harvest cycles from</span>
              </span>
            </div>
            <div class="font-display text-3xl font-bold text-brand">3 → 4</div>
            <div class="svc-caption text-muted">
              <span class="lang-th">รอบ/ปี*</span>
              <span class="lang-en">cycles/year*</span>
            </div>
          </div>
        </div>

        <!-- 03 -->
        <div class="bg-white rounded-[24px] p-7 border border-slate-200/70 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1.5 sa-spring group">
          <div class="flex items-start gap-4 mb-5">
            <div class="w-12 h-12 rounded-full bg-brand-soft text-brand flex items-center justify-center text-xl shrink-0 group-hover:bg-brand group-hover:text-white sa-spring" aria-hidden="true">
              <i class="fa-solid fa-droplet"></i>
            </div>
            <div>
              <div class="text-brand svc-kicker font-bold mb-0.5">03</div>
              <h3 class="svc-label text-ink font-semibold">
                <span class="lang-th">ใช้น้ำอย่างมีประสิทธิภาพ</span>
                <span class="lang-en">Optimize Water Usage</span>
              </h3>
            </div>
          </div>
          <p class="svc-copy text-body mb-5">
            <span class="lang-th">ลดการสูบน้ำที่ไม่จำเป็น ใช้น้ำได้คุ้มค่าในทุกฤดูการผลิต</span>
            <span class="lang-en">Cut unnecessary pumping and maximise water efficiency each growing season.</span>
          </p>
          <div class="rounded-2xl bg-[#f4f7f5] border border-slate-200/70 px-4 py-4">
            <div class="flex items-center gap-2 mb-1">
              <i class="fa-solid fa-arrow-trend-down text-brand text-sm" aria-hidden="true"></i>
              <span class="svc-kicker text-ink">
                <span class="lang-th">ลดการสูบน้ำ</span>
                <span class="lang-en">Pumping reduction</span>
              </span>
            </div>
            <div class="font-display text-3xl font-bold text-brand">2–4</div>
            <div class="svc-caption text-muted">
              <span class="lang-th">ครั้ง/ฤดู*</span>
              <span class="lang-en">times/season*</span>
            </div>
          </div>
        </div>

        <!-- 04 -->
        <div class="bg-white rounded-[24px] p-7 border border-slate-200/70 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1.5 sa-spring group">
          <div class="flex items-start gap-4 mb-5">
            <div class="w-12 h-12 rounded-full bg-brand-soft text-brand flex items-center justify-center text-xl shrink-0 group-hover:bg-brand group-hover:text-white sa-spring" aria-hidden="true">
              <i class="fa-solid fa-hand-holding-dollar"></i>
            </div>
            <div>
              <div class="text-brand svc-kicker font-bold mb-0.5">04</div>
              <h3 class="svc-label text-ink font-semibold">
                <span class="lang-th">สร้างรายได้เพิ่ม</span>
                <span class="lang-en">Generate New Revenue</span>
              </h3>
            </div>
          </div>
          <p class="svc-copy text-body mb-5">
            <span class="lang-th">รองรับต่อยอดคาร์บอนเครดิต สร้างรายได้ใหม่ให้กับเกษตรกร</span>
            <span class="lang-en">Enable carbon credit monetisation and unlock new income streams for farmers.</span>
          </p>
          <div class="rounded-2xl bg-[#f4f7f5] border border-slate-200/70 px-4 py-4">
            <div class="flex items-center gap-2 mb-1">
              <i class="fa-solid fa-leaf text-brand text-sm" aria-hidden="true"></i>
              <span class="svc-kicker text-ink">
                <span class="lang-th">คาร์บอนเครดิตสูงสุด</span>
                <span class="lang-en">Carbon credit up to</span>
              </span>
            </div>
            <div class="font-display text-3xl font-bold text-brand">200</div>
            <div class="svc-caption text-muted">
              <span class="lang-th">บาท/ไร่*</span>
              <span class="lang-en">THB/rai*</span>
            </div>
          </div>
        </div>

        <!-- 05 -->
        <div class="bg-white rounded-[24px] p-7 border border-slate-200/70 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1.5 sa-spring group">
          <div class="flex items-start gap-4 mb-5">
            <div class="w-12 h-12 rounded-full bg-brand-soft text-brand flex items-center justify-center text-xl shrink-0 group-hover:bg-brand group-hover:text-white sa-spring" aria-hidden="true">
              <i class="fa-solid fa-earth-asia"></i>
            </div>
            <div>
              <div class="text-brand svc-kicker font-bold mb-0.5">05</div>
              <h3 class="svc-label text-ink font-semibold">
                <span class="lang-th">ทำเกษตรอย่างยั่งยืน</span>
                <span class="lang-en">Sustainable Farming</span>
              </h3>
            </div>
          </div>
          <p class="svc-copy text-body mb-5">
            <span class="lang-th">ลดการใช้น้ำ ลดการปล่อยก๊าซเรือนกระจก ช่วยฟื้นฟูสิ่งแวดล้อมอย่างยั่งยืน</span>
            <span class="lang-en">Reduce water use and greenhouse gas emissions for truly sustainable agriculture.</span>
          </p>
          <div class="rounded-2xl bg-[#f4f7f5] border border-slate-200/70 px-4 py-4">
            <div class="flex flex-wrap items-center gap-3">
              <span class="inline-flex items-center gap-1.5 bg-white rounded-full px-3 py-1 svc-caption text-ink shadow-sm border border-brand/10">
                <i class="fa-solid fa-droplet text-brand text-xs"></i>
                <span class="lang-th">ประหยัดน้ำ</span><span class="lang-en">Water saving</span>
              </span>
              <span class="inline-flex items-center gap-1.5 bg-white rounded-full px-3 py-1 svc-caption text-ink shadow-sm border border-brand/10">
                <i class="fa-solid fa-cloud text-brand text-xs"></i>
                <span class="lang-th">ลดก๊าซเรือนกระจก</span><span class="lang-en">Lower emissions</span>
              </span>
              <span class="inline-flex items-center gap-1.5 bg-white rounded-full px-3 py-1 svc-caption text-ink shadow-sm border border-brand/10">
                <i class="fa-solid fa-leaf text-brand text-xs"></i>
                <span class="lang-th">อนุรักษ์ดินและสิ่งแวดล้อม</span><span class="lang-en">Soil conservation</span>
              </span>
            </div>
          </div>
        </div>

        <!-- 06 -->
        <div class="bg-white rounded-[24px] p-7 border border-slate-200/70 sa-card shadow-bento hover:shadow-bento-hover hover:-translate-y-1.5 sa-spring group">
          <div class="flex items-start gap-4 mb-5">
            <div class="w-12 h-12 rounded-full bg-brand-soft text-brand flex items-center justify-center text-xl shrink-0 group-hover:bg-brand group-hover:text-white sa-spring" aria-hidden="true">
              <i class="fa-solid fa-robot"></i>
            </div>
            <div>
              <div class="text-brand svc-kicker font-bold mb-0.5">06</div>
              <h3 class="svc-label text-ink font-semibold">
                <span class="lang-th">พร้อมต่อยอดด้วย AI</span>
                <span class="lang-en">AI-Ready Platform</span>
              </h3>
            </div>
          </div>
          <p class="svc-copy text-body mb-5">
            <span class="lang-th">สร้างฐานข้อมูลที่เชื่อถือได้ พร้อมสำหรับการวิเคราะห์และ AI ในอนาคต</span>
            <span class="lang-en">Build a trusted data foundation ready for advanced analytics and AI integration.</span>
          </p>
          <div class="rounded-2xl bg-[#f4f7f5] border border-slate-200/70 px-4 py-4">
            <div class="flex flex-wrap items-center gap-3">
              <span class="inline-flex items-center gap-1.5 bg-white rounded-full px-3 py-1 svc-caption text-ink shadow-sm border border-brand/10">
                <i class="fa-solid fa-database text-brand text-xs"></i>
                <span class="lang-th">ข้อมูลแม่นยำเชื่อถือได้</span><span class="lang-en">Reliable data</span>
              </span>
              <span class="inline-flex items-center gap-1.5 bg-white rounded-full px-3 py-1 svc-caption text-ink shadow-sm border border-brand/10">
                <i class="fa-solid fa-chart-line text-brand text-xs"></i>
                <span class="lang-th">วิเคราะห์เชิงคาดการณ์</span><span class="lang-en">Predictive analytics</span>
              </span>
              <span class="inline-flex items-center gap-1.5 bg-white rounded-full px-3 py-1 svc-caption text-ink shadow-sm border border-brand/10">
                <i class="fa-solid fa-microchip text-brand text-xs"></i>
                <span class="lang-th">พร้อมต่อยอด AI ในอนาคต</span><span class="lang-en">Future AI-ready</span>
              </span>
            </div>
          </div>
        </div>

      </div>

      <p class="text-center svc-caption text-muted mt-8">
        <span class="lang-th">*ตัวเลขอ้างอิงจากผลการใช้งานจริงในโครงการนำร่อง อาจแตกต่างกันตามสภาพพื้นที่</span>
        <span class="lang-en">*Figures based on pilot project results. Actual results may vary by location and conditions.</span>
      </p>

    </div>
  </section>

    <!-- CTA -->
    <!-- WHO IT IS FOR
         The page described the system at length without ever saying who it
         suits, so a reader had to work out "is this for me" on their own. The
         four groups are the application areas the IoT Solar Node section
         already lists - nothing new is claimed here. -->
    

    <section id="agri-cta" class="py-12 sm:py-16 bg-white" style="scroll-margin-top:96px">
      <div class="max-w-7xl mx-auto px-5 sm:px-6">
        <div class="relative overflow-hidden rounded-[28px] px-6 py-10 sm:px-10 sm:py-14 lg:px-16 text-white"
             style="background:linear-gradient(135deg,#0d4636 0%,#093427 55%,#06261c 100%)">
          <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none z-0"></div>

          <div class="relative z-10 grid gap-8 lg:grid-cols-[1.35fr_auto] lg:items-center">
            <div>
              <p class="svc-kicker mb-3" style="color:#4ade80">
                <span class="lang-th">เริ่มต้นกับเรา</span>
                <span class="lang-en">START WITH US</span>
              </p>
              <h2 data-editable="agri-cta-h2" <?php echo synergy_style('agri-cta-h2', 'smart-agriculture'); ?> class="svc-h2 font-display text-white"><?php echo synergy_content('agri-cta-h2', '<span class="lang-th">บริหารจัดการเกษตรแม่นยำ<br><span class="text-brand-bright">เพื่อผลผลิตที่ดีกว่าและต้นทุนที่ต่ำลง</span></span>
                <span class="lang-en">Precision Agriculture<br><span class="text-brand-bright">for Higher Yield and Lower Costs</span></span>', 'smart-agriculture'); ?></h2>
              <p data-editable="agri-cta-p" <?php echo synergy_style('agri-cta-p', 'smart-agriculture'); ?> class="svc-copy text-slate-200 mt-5 max-w-2xl"><?php echo synergy_content('agri-cta-p', '<span class="lang-th">เชื่อมต่อข้อมูลจากอุปกรณ์ภาคสนามไว้ในแพลตฟอร์มเดียว เพื่อการติดตาม วิเคราะห์ และบริหารจัดการการเกษตรอย่างมีประสิทธิภาพ</span>
                <span class="lang-en">Connect field data into one intelligent platform for real-time monitoring, analytics, and precision farm management.</span>', 'smart-agriculture'); ?></p>
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
  <!-- Tabs, device dialogs and the 3D viewer for #energy-platform.
       defer: it queries the section on load. -->
  <script defer src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/energy-platform.js') : './components/energy-platform.js'; ?>"></script>


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
