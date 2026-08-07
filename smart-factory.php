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
  <section id="factory-hero" class="relative bg-ink text-white py-24 sm:py-36 overflow-hidden flex items-center">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: linear-gradient(rgba(2, 4, 3, 0.45), rgba(2, 4, 3, 0.7)), url('<?php echo get_template_directory_uri(); ?>/image/solutions/factory-hero-automotive.jpg');"></div>
    <div class="absolute inset-0 pointer-events-none">
      <div class="absolute top-0 right-0 w-96 h-96 bg-brand/10 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 w-full">
      <div class="mb-4">
        <a href="<?php echo home_url('/'); ?>#solutions" class="text-white/50 hover:text-white text-xs font-700 tracking-wider uppercase transition">
          <i class="fa-solid fa-arrow-left mr-2"></i><span class="lang-th">โซลูชัน</span><span class="lang-en">Solutions</span>
        </a>
      </div>
      <div class="flex items-center gap-3 mb-6">
        <span class="w-10 h-10 rounded-xl bg-brand/30 border border-brand/40 flex items-center justify-center">
          <i class="fa-solid fa-gears text-gold-bright"></i>
        </span>
        <!-- The label is the same English string in both languages, per the copy
             deck. Kept as a lang pair anyway so the switcher has something to
             act on and the markup stays uniform with the rest of the page. -->
        <span class="text-gold-bright text-xs font-700 tracking-[0.25em] uppercase"><span class="lang-th">ENGINEERING INTELLIGENCE</span><span class="lang-en">ENGINEERING INTELLIGENCE</span></span>
      </div>
      <h1 data-editable="factory-hero-h1-1" <?php echo synergy_style('factory-hero-h1-1', 'smart-factory'); ?> class="font-display font-bold text-4xl sm:text-5xl lg:text-6xl text-white tracking-tight leading-tight mb-6"><?php echo synergy_content('factory-hero-h1-1', '<span class="lang-th">ยกระดับโรงงานของคุณสู่<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-brand to-gold-bright">Smart Factory</span></span>
        <span class="lang-en">Powering Your<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-brand to-gold-bright">Smart Factory</span></span>', 'smart-factory'); ?></h1>
      <p data-editable="factory-hero-p-1" <?php echo synergy_style('factory-hero-p-1', 'smart-factory'); ?> class="text-lg sm:text-xl text-white/70 font-300 leading-relaxed max-w-2xl mb-10"><?php echo synergy_content('factory-hero-p-1', '<span class="lang-th">เชื่อมต่อข้อมูลจากเครื่องจักรและระบบการผลิตไว้ในแพลตฟอร์มเดียว เพื่อการติดตาม วิเคราะห์ และบริหารจัดการโรงงานอย่างมีประสิทธิภาพ</span>
        <span class="lang-en">Connect machine and production data into a single platform for real-time monitoring, analytics, and efficient factory management.</span>', 'smart-factory'); ?></p>
      <div class="flex flex-wrap gap-4">
        <a href="<?php echo home_url('/'); ?>#contact" class="bg-brand hover:bg-brand-deep text-white font-700 text-xs tracking-wider uppercase px-8 py-4 rounded-xl transition shadow-lg shadow-brand/20">
          <i class="fa-solid fa-paper-plane mr-2"></i><span class="lang-th">ปรึกษาผู้เชี่ยวชาญ</span><span class="lang-en">Talk to Our Experts</span>
        </a>
        <a href="#factory-capabilities" class="border border-white/20 hover:bg-white/10 text-white font-700 text-xs tracking-wider uppercase px-8 py-4 rounded-xl transition">
          <i class="fa-solid fa-chevron-down mr-2"></i><span class="lang-th">ดูรายละเอียด</span><span class="lang-en">Learn More</span>
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
      <div class="mb-10 sm:mb-12">
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
          <h3 data-editable="factory-challenges-h3-3" <?php echo synergy_style('factory-challenges-h3-3', 'smart-factory'); ?> class="font-display font-800 text-base text-ink mb-2"><?php echo synergy_content('factory-challenges-h3-3', '<span class="lang-th">ข้อมูลแยกหลายระบบ</span><span class="lang-en">Data Silos</span>', 'smart-factory'); ?></h3>
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
          <h3 data-editable="factory-challenges-h3-6" <?php echo synergy_style('factory-challenges-h3-6', 'smart-factory'); ?> class="font-display font-800 text-base text-ink mb-2"><?php echo synergy_content('factory-challenges-h3-6', '<span class="lang-th">ระบบไม่เชื่อมต่อกัน</span><span class="lang-en">Disconnected Systems</span>', 'smart-factory'); ?></h3>
          <p data-editable="factory-challenges-p-6" <?php echo synergy_style('factory-challenges-p-6', 'smart-factory'); ?> class="text-xs text-slate-500 font-300 leading-relaxed"><?php echo synergy_content('factory-challenges-p-6', '<span class="lang-th">เครื่องจักรและระบบองค์กรทำงานแยกกัน ทำให้ข้อมูลไม่ต่อเนื่อง</span><span class="lang-en">Machines and enterprise systems operate separately.</span>', 'smart-factory'); ?></p>
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
              <p data-editable="factory-process-p-3" <?php echo synergy_style('factory-process-p-3', 'smart-factory'); ?> class="text-[11px] text-slate-500 font-300 leading-snug mb-5"><?php echo synergy_content('factory-process-p-3', '<span class="lang-th">ออกแบบและผลิต PCB, Gateway, Controller และอุปกรณ์ IoT สำหรับโรงงาน</span><span class="lang-en">Industrial hardware, PCB, Edge Gateway and controller development.</span>', 'smart-factory'); ?></p>
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
              <h3 data-editable="factory-process-h3-6" <?php echo synergy_style('factory-process-h3-6', 'smart-factory'); ?> class="font-display font-800 text-xs text-ink uppercase tracking-wider mb-2"><?php echo synergy_content('factory-process-h3-6', '<span class="lang-th">ดูแลและพัฒนาต่อเนื่อง</span><span class="lang-en">Support &amp; Evolution</span>', 'smart-factory'); ?></h3>
              <p data-editable="factory-process-p-6" <?php echo synergy_style('factory-process-p-6', 'smart-factory'); ?> class="text-[11px] text-slate-500 font-300 leading-snug mb-5"><?php echo synergy_content('factory-process-p-6', '<span class="lang-th">บริการบำรุงรักษา Monitoring ปรับปรุงระบบ และขยายโซลูชันตามการเติบโตของธุรกิจ</span><span class="lang-en">Maintenance, monitoring, upgrades and continuous improvement.</span>', 'smart-factory'); ?></p>
            </div>
            <div class="w-full h-28 rounded-xl overflow-hidden bg-slate-100 border border-slate-100">
              <img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/iot-operations-data-center.png" alt="Support & Evolution" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
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

       The copy is still the Smart Energy deck - inverter brands, solar,
       "Smart Energy Management" - because the request was for this exact
       section. It is editable per-page under factory-platform-* keys. -->
  <section id="energy-platform" class="py-12 sm:py-16 bg-[#f4f7f5] border-y border-slate-200/80" style="scroll-margin-top:96px">
    <div class="sf-shell">
      <div class="platform-card">

        <!-- TOP: pitch + capabilities (Above Tab Bar) -->
        <section class="left-pitch-column top-pitch-layout mb-8">
          <div class="top-pitch-header text-center mb-6">
            <div class="mb-4 flex justify-center">
              <img src="<?php echo get_template_directory_uri(); ?>/image/LOGO SYNEXTA.png" alt="SynExta Logo" class="h-10 sm:h-12 w-auto object-contain drop-shadow-sm">
            </div>
            <h2 data-editable="factory-platform-h2-1" <?php echo synergy_style('factory-platform-h2-1', 'smart-factory'); ?> class="main-heading font-display text-center sm:whitespace-nowrap"><?php echo synergy_content('factory-platform-h2-1', '<span class="lang-th">เทคโนโลยีหลักที่ขับเคลื่อน<br class="sm:hidden"> <span class="heading-highlight">Smart Energy Management</span></span><span class="lang-en">The Intelligence Behind<br class="sm:hidden"> <span class="heading-highlight">Smart Energy Management</span></span>', 'smart-factory'); ?></h2>
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
                  <span class="lang-th">รองรับ Inverter หลายแบรนด์</span>
                  <span class="lang-en">Multi-brand Inverter Support</span>
                </h3>
                <p class="feature-sub">
                  <span class="lang-th">เชื่อมต่ออินเวอร์เตอร์แบรนด์ชั้นนำ Huawei, Sungrow, GoodWe, Growatt, SMA, Fronius, Delta, Solis และแบรนด์อื่น ๆ</span>
                  <span class="lang-en">Connect top inverter brands: Huawei, Sungrow, GoodWe, Growatt, SMA, Fronius, Delta, Solis and more.</span>
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
                  <span class="lang-th">ติดตามการใช้งานโรงงาน สาขา และระบบ Solar ได้แบบ Real-time จากศูนย์กลางเดียว</span>
                  <span class="lang-en">Monitor factories, branches, and Solar systems in real-time from a central hub.</span>
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
          <div class="nav-tabs" role="tablist" aria-label="SynExta Energy Platform">

            <button type="button" class="nav-tab active" role="tab" aria-selected="true" aria-controls="view-overview" id="tab-overview" data-tab="overview">
              <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>
              </svg>
              <span><span class="lang-th">ภาพรวม</span><span class="lang-en">Overview</span></span>
              <div class="tab-indicator"></div>
            </button>

            <button type="button" class="nav-tab" role="tab" aria-selected="false" tabindex="-1" aria-controls="view-dashboard" id="tab-dashboard" data-tab="dashboard">
              <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                <line x1="3" y1="9" x2="21" y2="9"/>
                <line x1="9" y1="21" x2="9" y2="9"/>
              </svg>
              <span><span class="lang-th">แดชบอร์ด</span><span class="lang-en">Dashboard</span></span>
            </button>

            <button type="button" class="nav-tab" role="tab" aria-selected="false" tabindex="-1" aria-controls="view-sites" id="tab-sites" data-tab="sites">
              <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M3 21h18M3 7v14M13 3v18M13 11h8v10M7 11h2M7 15h2"/>
              </svg>
              <span><span class="lang-th">ไซต์งาน</span><span class="lang-en">Sites</span></span>
            </button>

            <button type="button" class="nav-tab" role="tab" aria-selected="false" tabindex="-1" aria-controls="view-reports" id="tab-reports" data-tab="reports">
              <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
              </svg>
              <span><span class="lang-th">รายงาน</span><span class="lang-en">Reports</span></span>
            </button>

            <button type="button" class="nav-tab" role="tab" aria-selected="false" tabindex="-1" aria-controls="view-alerts" id="tab-alerts" data-tab="alerts">
              <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
              </svg>
              <span><span class="lang-th">การแจ้งเตือน</span><span class="lang-en">Alerts</span></span>
            </button>

            <button type="button" class="nav-tab" role="tab" aria-selected="false" tabindex="-1" aria-controls="view-analytics" id="tab-analytics" data-tab="analytics">
              <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
                <line x1="6" y1="20" x2="6" y2="14"/><polyline points="3 8 9 3 15 9 21 3"/>
              </svg>
              <span><span class="lang-th">วิเคราะห์ข้อมูล</span><span class="lang-en">Analytics</span></span>
            </button>

            <button type="button" class="nav-tab" role="tab" aria-selected="false" tabindex="-1" aria-controls="view-users" id="tab-users" data-tab="users">
              <svg class="tab-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
              </svg>
              <span><span class="lang-th">ผู้ใช้งาน</span><span class="lang-en">Users</span></span>
            </button>

          </div>
        </header>

        <!-- ---------- Panels ---------- -->
        <div class="content-container">

          <!-- OVERVIEW -->
          <div id="view-overview" class="tab-view active" role="tabpanel" aria-labelledby="tab-overview">

            <div class="grid-architecture">

              <!-- CENTER: 3D core + field devices -->
              <section class="center-engine-column">

                <!-- The viewer library and the .glb are attached by
                     energy-platform.js once the section nears the viewport;
                     until then this shows the poster below. -->
                <div class="central-architecture-stage"
                     data-model-src="<?php echo function_exists('synergy_asset') ? synergy_asset('models/syntech_building.glb') : './models/syntech_building.glb'; ?>"
                     data-viewer-src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"
                     data-model-alt="SynExta Energy - 3D building model">
                  <div class="stage-poster">
                    <div class="stage-poster-ring" aria-hidden="true"></div>
                    <span><span class="lang-th">กำลังโหลดโมเดล 3 มิติ</span><span class="lang-en">Loading 3D model</span></span>
                  </div>
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

                    <button type="button" class="device-card" data-device="solar-inverter">
                      <span class="device-img-wrapper">
                        <img src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-energy/platform/solar_inverter.jpg') : './image/smart-energy/platform/solar_inverter.jpg'; ?>" alt="" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="device-name">Solar Inverter</span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                          <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                          <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                        </svg>
                      </span>
                    </button>

                    <button type="button" class="device-card" data-device="energy-meter">
                      <span class="device-img-wrapper">
                        <img src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-energy/platform/energy_meter.jpg') : './image/smart-energy/platform/energy_meter.jpg'; ?>" alt="" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="device-name">Energy Meter</span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                        </svg>
                      </span>
                    </button>

                    <button type="button" class="device-card" data-device="lighting-controller">
                      <span class="device-img-wrapper">
                        <img src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-energy/platform/lighting.jpg') : './image/smart-energy/platform/lighting.jpg'; ?>" alt="" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="device-name">Lighting Controller</span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <path d="M9 18h6"/><path d="M10 22h4"/>
                          <path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1.55.6 2.95 1.5 4 .76.76 1.23 1.52 1.41 2.5"/>
                        </svg>
                      </span>
                    </button>

                    <button type="button" class="device-card" data-device="hvac">
                      <span class="device-img-wrapper">
                        <img src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-energy/platform/hvac.jpg') : './image/smart-energy/platform/hvac.jpg'; ?>" alt="" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="device-name">HVAC</span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                      </span>
                    </button>

                    <button type="button" class="device-card" data-device="ev-charger">
                      <span class="device-img-wrapper">
                        <img src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-energy/platform/ev_charger.jpg') : './image/smart-energy/platform/ev_charger.jpg'; ?>" alt="" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="device-name">EV Charger</span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                      </span>
                    </button>

                    <button type="button" class="device-card" data-device="iot-sensor">
                      <span class="device-img-wrapper">
                        <img src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-energy/platform/iot_sensor.jpg') : './image/smart-energy/platform/iot_sensor.jpg'; ?>" alt="" class="device-img" loading="lazy" decoding="async">
                      </span>
                      <span class="device-name">IoT Sensor</span>
                      <span class="device-subicon-badge" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                          <path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/>
                          <path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/>
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
                        <stop offset="0%" stop-color="#10B981" stop-opacity="0.5"/>
                        <stop offset="100%" stop-color="#00A86B" stop-opacity="1"/>
                      </linearGradient>
                      <marker id="ep-arrowRight" viewBox="0 0 10 10" refX="6" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
                        <path d="M 0 1.5 L 8 5 L 0 8.5 z" fill="#00A86B"/>
                      </marker>
                    </defs>
                    <path d="M 0 194 H 25 V 72.5 H 56" fill="none" stroke="url(#ep-flowGradRight)" stroke-width="2.5" stroke-dasharray="5 4" marker-end="url(#ep-arrowRight)"/>
                    <path d="M 0 194 H 25 V 315.5 H 56" fill="none" stroke="url(#ep-flowGradRight)" stroke-width="2.5" stroke-dasharray="5 4" marker-end="url(#ep-arrowRight)"/>
                    <circle cx="2" cy="194" r="3.5" fill="#00A86B"/>
                    <circle cx="25" cy="194" r="3.5" fill="#10B981"/>
                  </svg>

                  <div class="deployment-card-square">
                    <div class="deploy-img-box">
                      <img src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-energy/platform/cloud.jpg') : './image/smart-energy/platform/cloud.jpg'; ?>" alt="" class="deploy-img" loading="lazy" decoding="async">
                    </div>
                    <span class="deploy-label"><span class="lang-th">คลาวด์</span><span class="lang-en">Cloud</span></span>
                  </div>

                  <div class="deploy-vertical-dash"></div>
                  <div class="divider-or-circle"><span>OR</span></div>
                  <div class="deploy-vertical-dash"></div>

                  <div class="deployment-card-square">
                    <div class="deploy-img-box">
                      <img src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-energy/platform/onpremise.jpg') : './image/smart-energy/platform/onpremise.jpg'; ?>" alt="" class="deploy-img" loading="lazy" decoding="async">
                    </div>
                    <span class="deploy-label"><span class="lang-th">ภายในองค์กร</span><span class="lang-en">On-Premise</span></span>
                  </div>

                </div>
              </section>

            </div>
          </div>

          <!-- DASHBOARD -->
          <div id="view-dashboard" class="tab-view" role="tabpanel" aria-labelledby="tab-dashboard">
            <div class="view-header">
              <h3><span class="lang-th">แดชบอร์ดระบบ</span><span class="lang-en">System Dashboard</span></h3>
              <p>
                <span class="lang-th">ติดตามข้อมูลพลังงานรวม การผลิตไฟจาก Solar การลดคาร์บอน และสถานะอุปกรณ์แบบ Real-time</span>
                <span class="lang-en">Monitor total energy, solar generation, carbon reduction, and real-time equipment status.</span>
              </p>
            </div>
            <div class="screen-frame">
              <div class="screen-chrome" aria-hidden="true">
                <span class="screen-dot"></span><span class="screen-dot"></span><span class="screen-dot"></span>
                <span class="screen-chrome-label">SynExta Energy · <span class="lang-th">แดชบอร์ด</span><span class="lang-en">Dashboard</span></span>
              </div>
              <button type="button" class="screen-shot-btn" data-shot-alt="Dashboard overview">
                <img class="screen-shot" width="1388" height="1041" loading="lazy" decoding="async"
                     src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-energy/platform/screens/overview.png') : './image/smart-energy/platform/screens/overview.png'; ?>"
                     alt="หน้าจอแดชบอร์ดของแพลตฟอร์ม แสดงจำนวนไซต์งาน พลังงานรวม การลดคาร์บอน กราฟการผลิตและการใช้พลังงานรายวัน และแผนที่ไซต์งาน">
              </button>
              <div class="screen-zoom-hint">🔍 <span class="lang-th">คลิกที่ภาพเพื่อดูขนาดเต็ม</span><span class="lang-en">Click the image to enlarge</span></div>
            </div>
            <p data-editable="factory-platform-p-1" <?php echo synergy_style('factory-platform-p-1', 'smart-factory'); ?> class="demo-note"><?php echo synergy_content('factory-platform-p-1', 'ℹ️
              <span class="lang-th">ตัวเลขในหน้าจอตัวอย่างนี้เป็นข้อมูลจำลองเพื่อสาธิตการทำงาน</span>
              <span class="lang-en">Figures shown in these screens are sample data for demonstration.</span>', 'smart-factory'); ?></p>
          </div>

          <!-- SITES -->
          <div id="view-sites" class="tab-view" role="tabpanel" aria-labelledby="tab-sites">
            <div class="view-header">
              <h3><span class="lang-th">ไซต์งานทั้งหมด</span><span class="lang-en">All Sites &amp; Facilities</span></h3>
              <p>
                <span class="lang-th">ติดตามและบริหารจัดการไซต์งาน โครงการโซลาร์ และอาคารในเครือข่าย</span>
                <span class="lang-en">Track and manage sites, solar projects, and buildings across the network.</span>
              </p>
            </div>
            <div class="screen-frame">
              <div class="screen-chrome" aria-hidden="true">
                <span class="screen-dot"></span><span class="screen-dot"></span><span class="screen-dot"></span>
                <span class="screen-chrome-label">SynExta Energy · <span class="lang-th">ไซต์งาน</span><span class="lang-en">Sites</span></span>
              </div>
              <button type="button" class="screen-shot-btn" data-shot-alt="Sites map">
                <img class="screen-shot" width="1693" height="1017" loading="lazy" decoding="async"
                     src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-energy/platform/screens/sites.png') : './image/smart-energy/platform/screens/sites.png'; ?>"
                     alt="หน้าจอไซต์งาน แสดงแผนที่ตำแหน่งไซต์ทั่วประเทศ จำนวนอุปกรณ์ทั้งหมด สถานะออนไลน์ ออฟไลน์ และรายการซ่อมบำรุง">
              </button>
              <div class="screen-zoom-hint">🔍 <span class="lang-th">คลิกที่ภาพเพื่อดูขนาดเต็ม</span><span class="lang-en">Click the image to enlarge</span></div>
            </div>
            <p data-editable="factory-platform-p-2" <?php echo synergy_style('factory-platform-p-2', 'smart-factory'); ?> class="demo-note"><?php echo synergy_content('factory-platform-p-2', 'ℹ️
              <span class="lang-th">ตัวเลขในหน้าตัวอย่างนี้เป็นข้อมูลจำลองเพื่อสาธิตการทำงาน</span>
              <span class="lang-en">Figures shown here are sample data for demonstration.</span>', 'smart-factory'); ?></p>
          </div>

          <!-- REPORTS -->
          <div id="view-reports" class="tab-view" role="tabpanel" aria-labelledby="tab-reports">
            <div class="view-header">
              <h3><span class="lang-th">รายงานพลังงานและคาร์บอน</span><span class="lang-en">Energy &amp; ESG Reports</span></h3>
              <p>
                <span class="lang-th">ดาวน์โหลดรายงานภาพรวมการใช้พลังงาน รายงานลด CO₂ และการปฏิบัติตามมาตรฐาน ESG</span>
                <span class="lang-en">Download energy overview reports, CO₂ reduction summaries, and ESG compliance documents.</span>
              </p>
            </div>
            <div class="screen-frame">
              <div class="screen-chrome" aria-hidden="true">
                <span class="screen-dot"></span><span class="screen-dot"></span><span class="screen-dot"></span>
                <span class="screen-chrome-label">SynExta Energy · <span class="lang-th">รายงาน</span><span class="lang-en">Reports</span></span>
              </div>
              <button type="button" class="screen-shot-btn" data-shot-alt="Reports list">
                <img class="screen-shot" width="1318" height="988" loading="lazy" decoding="async"
                     src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-energy/platform/screens/reports.png') : './image/smart-energy/platform/screens/reports.png'; ?>"
                     alt="หน้าจอรายงาน แสดงรายการรายงานพลังงานรายวัน รายเดือน รายงานการปล่อย CO₂ และ Peak Demand พร้อมสถานะและปุ่มดาวน์โหลด">
              </button>
              <div class="screen-zoom-hint">🔍 <span class="lang-th">คลิกที่ภาพเพื่อดูขนาดเต็ม</span><span class="lang-en">Click the image to enlarge</span></div>
            </div>
            <p data-editable="factory-platform-p-3" <?php echo synergy_style('factory-platform-p-3', 'smart-factory'); ?> class="demo-note"><?php echo synergy_content('factory-platform-p-3', 'ℹ️
              <span class="lang-th">ตัวเลขในหน้าตัวอย่างนี้เป็นข้อมูลจำลองเพื่อสาธิตการทำงาน</span>
              <span class="lang-en">Figures shown here are sample data for demonstration.</span>', 'smart-factory'); ?></p>
          </div>

          <!-- ALERTS -->
          <div id="view-alerts" class="tab-view" role="tabpanel" aria-labelledby="tab-alerts">
            <div class="view-header">
              <h3><span class="lang-th">การแจ้งเตือนระบบ</span><span class="lang-en">System Alerts &amp; Diagnostics</span></h3>
              <p>
                <span class="lang-th">รายการแจ้งเตือนจากอุปกรณ์ Inverter, Meter และ IoT Sensor</span>
                <span class="lang-en">Alerts from inverters, meters, and IoT sensors.</span>
              </p>
            </div>
            <div class="screen-frame">
              <div class="screen-chrome" aria-hidden="true">
                <span class="screen-dot"></span><span class="screen-dot"></span><span class="screen-dot"></span>
                <span class="screen-chrome-label">SynExta Energy · <span class="lang-th">การแจ้งเตือน</span><span class="lang-en">Alerts</span></span>
              </div>
              <button type="button" class="screen-shot-btn" data-shot-alt="Alerts table">
                <img class="screen-shot" width="1331" height="998" loading="lazy" decoding="async"
                     src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-energy/platform/screens/alerts.png') : './image/smart-energy/platform/screens/alerts.png'; ?>"
                     alt="หน้าจอการแจ้งเตือน แยกตามระดับความรุนแรง วิกฤต สูง ปานกลาง ต่ำ พร้อมตารางรายการแจ้งเตือนของแต่ละไซต์และอุปกรณ์">
              </button>
              <div class="screen-zoom-hint">🔍 <span class="lang-th">คลิกที่ภาพเพื่อดูขนาดเต็ม</span><span class="lang-en">Click the image to enlarge</span></div>
            </div>
            <p data-editable="factory-platform-p-4" <?php echo synergy_style('factory-platform-p-4', 'smart-factory'); ?> class="demo-note"><?php echo synergy_content('factory-platform-p-4', 'ℹ️
              <span class="lang-th">ตัวเลขในหน้าตัวอย่างนี้เป็นข้อมูลจำลองเพื่อสาธิตการทำงาน</span>
              <span class="lang-en">Figures shown here are sample data for demonstration.</span>', 'smart-factory'); ?></p>
          </div>

          <!-- ANALYTICS -->
          <div id="view-analytics" class="tab-view" role="tabpanel" aria-labelledby="tab-analytics">
            <div class="view-header">
              <h3><span class="lang-th">การวิเคราะห์ข้อมูลขั้นสูง</span><span class="lang-en">Advanced Analytics &amp; Forecast</span></h3>
              <p>
                <span class="lang-th">วิเคราะห์แนวโน้มการผลิตไฟฟ้าจากโซลาร์เซลล์และการพยากรณ์การใช้พลังงานด้วย AI</span>
                <span class="lang-en">Analyze solar generation trends and forecast energy demand with AI.</span>
              </p>
            </div>
            <div class="screen-frame">
              <div class="screen-chrome" aria-hidden="true">
                <span class="screen-dot"></span><span class="screen-dot"></span><span class="screen-dot"></span>
                <span class="screen-chrome-label">SynExta Energy · <span class="lang-th">วิเคราะห์ข้อมูล</span><span class="lang-en">Analytics</span></span>
              </div>
              <button type="button" class="screen-shot-btn" data-shot-alt="Analytics dashboard">
                <img class="screen-shot" width="1399" height="1050" loading="lazy" decoding="async"
                     src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-energy/platform/screens/analytics.png') : './image/smart-energy/platform/screens/analytics.png'; ?>"
                     alt="หน้าจอวิเคราะห์ข้อมูล แสดงแนวโน้มพลังงานรายวัน สัดส่วนพลังงานผลิตและพลังงานใช้ การวิเคราะห์ Peak Demand และตัวชี้วัดประสิทธิภาพระบบ">
              </button>
              <div class="screen-zoom-hint">🔍 <span class="lang-th">คลิกที่ภาพเพื่อดูขนาดเต็ม</span><span class="lang-en">Click the image to enlarge</span></div>
            </div>
            <p data-editable="factory-platform-p-5" <?php echo synergy_style('factory-platform-p-5', 'smart-factory'); ?> class="demo-note"><?php echo synergy_content('factory-platform-p-5', 'ℹ️
              <span class="lang-th">ตัวเลขในหน้าตัวอย่างนี้เป็นข้อมูลจำลองเพื่อสาธิตการทำงาน</span>
              <span class="lang-en">Figures shown here are sample data for demonstration.</span>', 'smart-factory'); ?></p>
          </div>

          <!-- USERS -->
          <div id="view-users" class="tab-view" role="tabpanel" aria-labelledby="tab-users">
            <div class="view-header">
              <h3><span class="lang-th">การจัดการผู้ใช้งานและสิทธิ์</span><span class="lang-en">User Management &amp; Roles</span></h3>
              <p>
                <span class="lang-th">ตั้งค่าสิทธิ์การเข้าถึงสำหรับผู้ดูแลระบบ วิศวกร และผู้บริหาร</span>
                <span class="lang-en">Configure access rights for administrators, engineers, and executives.</span>
              </p>
            </div>
            <div class="screen-frame">
              <div class="screen-chrome" aria-hidden="true">
                <span class="screen-dot"></span><span class="screen-dot"></span><span class="screen-dot"></span>
                <span class="screen-chrome-label">SynExta Energy · <span class="lang-th">ผู้ใช้งาน</span><span class="lang-en">Users</span></span>
              </div>
              <button type="button" class="screen-shot-btn" data-shot-alt="User management">
                <img class="screen-shot" width="1422" height="1061" loading="lazy" decoding="async"
                     src="<?php echo function_exists('synergy_asset') ? synergy_asset('image/smart-energy/platform/screens/users.png') : './image/smart-energy/platform/screens/users.png'; ?>"
                     alt="หน้าจอจัดการผู้ใช้งาน แสดงจำนวนผู้ใช้ในระบบ และตารางรายชื่อผู้ใช้พร้อมองค์กร บทบาท และสถานะการใช้งาน">
              </button>
              <div class="screen-zoom-hint">🔍 <span class="lang-th">คลิกที่ภาพเพื่อดูขนาดเต็ม</span><span class="lang-en">Click the image to enlarge</span></div>
            </div>
            <p data-editable="factory-platform-p-6" <?php echo synergy_style('factory-platform-p-6', 'smart-factory'); ?> class="demo-note"><?php echo synergy_content('factory-platform-p-6', 'ℹ️
              <span class="lang-th">ตัวเลขในหน้าจอตัวอย่างนี้เป็นข้อมูลจำลองเพื่อสาธิตการทำงาน</span>
              <span class="lang-en">Figures shown in these screens are sample data for demonstration.</span>', 'smart-factory'); ?></p>
          </div>

        </div>

        <!-- ---------- Benefits strip ---------- -->
        <div class="app-footer-strip">

          <div class="benefit-item">
            <div class="benefit-icon-wrapper" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/>
                <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
              </svg>
            </div>
            <div class="benefit-content">
              <h4 class="benefit-title"><span class="lang-th">ลดต้นทุนพลังงาน</span><span class="lang-en">Reduce Energy Costs</span></h4>
              <p class="benefit-desc"><span class="lang-th">เพิ่มประสิทธิภาพการใช้พลังงาน</span><span class="lang-en">Maximize energy efficiency.</span></p>
            </div>
          </div>

          <div class="benefit-item">
            <div class="benefit-icon-wrapper" aria-hidden="true"><div class="co2-badge-text">CO₂</div></div>
            <div class="benefit-content">
              <h4 class="benefit-title"><span class="lang-th">ลดการปล่อยคาร์บอน</span><span class="lang-en">Reduce Carbon Emissions</span></h4>
              <p class="benefit-desc"><span class="lang-th">สอดคล้องเป้าหมาย Net Zero</span><span class="lang-en">Align with Net Zero goals.</span></p>
            </div>
          </div>

          <div class="benefit-item">
            <div class="benefit-icon-wrapper" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/>
              </svg>
            </div>
            <div class="benefit-content">
              <h4 class="benefit-title"><span class="lang-th">ปลอดภัย เชื่อถือได้</span><span class="lang-en">Safe &amp; Reliable</span></h4>
              <p class="benefit-desc"><span class="lang-th">ด้วยมาตรฐานความปลอดภัยระดับสากล</span><span class="lang-en">International standard security.</span></p>
            </div>
          </div>

          <div class="benefit-item">
            <div class="benefit-icon-wrapper" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="#00A86B" stroke-width="2">
                <rect x="4" y="14" width="4" height="7" rx="1"/><rect x="10" y="10" width="4" height="11" rx="1"/>
                <rect x="16" y="6" width="4" height="15" rx="1"/><polyline points="4 8 10 3 16 7 22 2"/>
              </svg>
            </div>
            <div class="benefit-content">
              <h4 class="benefit-title"><span class="lang-th">ขยายธุรกิจได้ไม่จำกัด</span><span class="lang-en">Infinitely Scalable</span></h4>
              <p class="benefit-desc"><span class="lang-th">รองรับการเติบโตในอนาคต</span><span class="lang-en">Ready for future growth.</span></p>
            </div>
          </div>

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
          <p data-editable="factory-capabilities-p-2" <?php echo synergy_style('factory-capabilities-p-2', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[220px]"><?php echo synergy_content('factory-capabilities-p-2', '<span class="lang-th">ติดตามสถานะเครื่องจักรแบบเรียลไทม์</span>
            <span class="lang-en">Real-time machine monitoring.</span>', 'smart-factory'); ?></p>
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
          <p data-editable="factory-capabilities-p-4" <?php echo synergy_style('factory-capabilities-p-4', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[220px]"><?php echo synergy_content('factory-capabilities-p-4', '<span class="lang-th">ทำนายความเสียหายก่อนเกิดจริง</span>
            <span class="lang-en">Predict equipment failures before they happen.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 05. AI Analytics -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
          <div class="w-16 h-16 sm:w-20 sm:h-20 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/ai_analytics.png" alt="AI Analytics" class="w-full h-full object-contain">
          </div>
          <h3 class="font-display font-800 text-base sm:text-lg text-ink mb-1.5 group-hover:text-emerald-700 transition-colors">
            AI Analytics
          </h3>
          <p data-editable="factory-capabilities-p-5" <?php echo synergy_style('factory-capabilities-p-5', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[220px]"><?php echo synergy_content('factory-capabilities-p-5', '<span class="lang-th">เปลี่ยนข้อมูลให้เป็นข้อมูลเชิงลึกที่ใช้งานได้</span>
            <span class="lang-en">Transform industrial data into actionable insights.</span>', 'smart-factory'); ?></p>
        </div>

        <!-- 06. Production Traceability -->
        <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-emerald-500/40 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center group">
          <div class="w-16 h-16 sm:w-20 sm:h-20 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/smart-factory/production_traceability.png" alt="Production Traceability" class="w-full h-full object-contain">
          </div>
          <h3 class="font-display font-800 text-base sm:text-lg text-ink mb-1.5 group-hover:text-emerald-700 transition-colors">
            Production Traceability
          </h3>
          <p data-editable="factory-capabilities-p-6" <?php echo synergy_style('factory-capabilities-p-6', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[220px]"><?php echo synergy_content('factory-capabilities-p-6', '<span class="lang-th">ตามรอยการผลิตตั้งแต่วัตถุดิบถึงสินค้าสำเร็จ</span>
            <span class="lang-en">Track production from raw material to finished goods.</span>', 'smart-factory'); ?></p>
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
          <p data-editable="factory-capabilities-p-8" <?php echo synergy_style('factory-capabilities-p-8', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[220px]"><?php echo synergy_content('factory-capabilities-p-8', '<span class="lang-th">แดชบอร์ด KPI แบบรวมศูนย์</span>
            <span class="lang-en">Centralized KPI dashboard.</span>', 'smart-factory'); ?></p>
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
          <p data-editable="factory-capabilities-p-10" <?php echo synergy_style('factory-capabilities-p-10', 'smart-factory'); ?> class="text-xs sm:text-sm text-slate-500 font-300 leading-relaxed max-w-[220px]"><?php echo synergy_content('factory-capabilities-p-10', '<span class="lang-th">โครงสร้างพื้นฐานคลาวด์ที่ขยายได้</span>
            <span class="lang-en">Scalable cloud infrastructure.</span>', 'smart-factory'); ?></p>
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
            <span class="lang-en">Enterprise private infrastructure.</span>', 'smart-factory'); ?></p>
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
        <span class="text-emerald-700 text-xs font-800 tracking-[0.25em] uppercase block mb-3">INDUSTRIES</span>
        <h2 class="font-display font-black text-3xl sm:text-4xl text-ink tracking-tight"><span class="lang-th">อุตสาหกรรมที่เราให้บริการ</span><span class="lang-en">Industries We Serve</span></h2>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="rounded-2xl border border-slate-100 bg-white p-6 text-center hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col items-center justify-center group"><div class="w-16 h-16 sm:w-20 sm:h-20 mb-2 flex items-center justify-center group-hover:scale-105 transition-transform duration-300"><img src="<?php echo get_template_directory_uri(); ?>/image/ind_automotive_arm.png" alt="Automotive" class="w-full h-full object-contain"></div><p data-editable="factory-industries-p-1" <?php echo synergy_style('factory-industries-p-1', 'smart-factory'); ?> class="font-700 text-sm text-ink"><?php echo synergy_content('factory-industries-p-1', '<span class="lang-th">ยานยนต์</span><span class="lang-en">Automotive</span>', 'smart-factory'); ?></p></div>
        <div class="rounded-2xl border border-slate-100 bg-white p-6 text-center hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col items-center justify-center group"><div class="w-16 h-16 sm:w-20 sm:h-20 mb-2 flex items-center justify-center group-hover:scale-105 transition-transform duration-300"><img src="<?php echo get_template_directory_uri(); ?>/image/ind_electronics_chip.png" alt="Electronics" class="w-full h-full object-contain"></div><p data-editable="factory-industries-p-2" <?php echo synergy_style('factory-industries-p-2', 'smart-factory'); ?> class="font-700 text-sm text-ink"><?php echo synergy_content('factory-industries-p-2', '<span class="lang-th">อิเล็กทรอนิกส์</span><span class="lang-en">Electronics</span>', 'smart-factory'); ?></p></div>
        <div class="rounded-2xl border border-slate-100 bg-white p-6 text-center hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col items-center justify-center group"><div class="w-16 h-16 sm:w-20 sm:h-20 mb-2 flex items-center justify-center group-hover:scale-105 transition-transform duration-300"><img src="<?php echo get_template_directory_uri(); ?>/image/ind_food_bottles.png" alt="Food" class="w-full h-full object-contain"></div><p data-editable="factory-industries-p-3" <?php echo synergy_style('factory-industries-p-3', 'smart-factory'); ?> class="font-700 text-sm text-ink"><?php echo synergy_content('factory-industries-p-3', '<span class="lang-th">อาหารและเครื่องดื่ม</span><span class="lang-en">Food</span>', 'smart-factory'); ?></p></div>
        <div class="rounded-2xl border border-slate-100 bg-white p-6 text-center hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col items-center justify-center group"><div class="w-16 h-16 sm:w-20 sm:h-20 mb-2 flex items-center justify-center group-hover:scale-105 transition-transform duration-300"><img src="<?php echo get_template_directory_uri(); ?>/image/ind_pharma_medicine.png" alt="Pharmaceutical" class="w-full h-full object-contain"></div><p data-editable="factory-industries-p-4" <?php echo synergy_style('factory-industries-p-4', 'smart-factory'); ?> class="font-700 text-sm text-ink"><?php echo synergy_content('factory-industries-p-4', '<span class="lang-th">เวชภัณฑ์และยา</span><span class="lang-en">Pharmaceutical</span>', 'smart-factory'); ?></p></div>
        <div class="rounded-2xl border border-slate-100 bg-white p-6 text-center hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col items-center justify-center group"><div class="w-16 h-16 sm:w-20 sm:h-20 mb-2 flex items-center justify-center group-hover:scale-105 transition-transform duration-300"><img src="<?php echo get_template_directory_uri(); ?>/image/ind_packaging_box.png" alt="Packaging" class="w-full h-full object-contain"></div><p data-editable="factory-industries-p-5" <?php echo synergy_style('factory-industries-p-5', 'smart-factory'); ?> class="font-700 text-sm text-ink"><?php echo synergy_content('factory-industries-p-5', '<span class="lang-th">บรรจุภัณฑ์</span><span class="lang-en">Packaging</span>', 'smart-factory'); ?></p></div>
        <div class="rounded-2xl border border-slate-100 bg-white p-6 text-center hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col items-center justify-center group"><div class="w-16 h-16 sm:w-20 sm:h-20 mb-2 flex items-center justify-center group-hover:scale-105 transition-transform duration-300"><img src="<?php echo get_template_directory_uri(); ?>/image/ind_energy_solar.png" alt="Energy" class="w-full h-full object-contain"></div><p data-editable="factory-industries-p-6" <?php echo synergy_style('factory-industries-p-6', 'smart-factory'); ?> class="font-700 text-sm text-ink"><?php echo synergy_content('factory-industries-p-6', '<span class="lang-th">พลังงาน</span><span class="lang-en">Energy</span>', 'smart-factory'); ?></p></div>
        <div class="rounded-2xl border border-slate-100 bg-white p-6 text-center hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col items-center justify-center group"><div class="w-16 h-16 sm:w-20 sm:h-20 mb-2 flex items-center justify-center group-hover:scale-105 transition-transform duration-300"><img src="<?php echo get_template_directory_uri(); ?>/image/ind_metal_furnace.png" alt="Metal" class="w-full h-full object-contain"></div><p data-editable="factory-industries-p-7" <?php echo synergy_style('factory-industries-p-7', 'smart-factory'); ?> class="font-700 text-sm text-ink"><?php echo synergy_content('factory-industries-p-7', '<span class="lang-th">โลหะและเหล็ก</span><span class="lang-en">Metal</span>', 'smart-factory'); ?></p></div>
        <div class="rounded-2xl border border-slate-100 bg-white p-6 text-center hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 flex flex-col items-center justify-center group"><div class="w-16 h-16 sm:w-20 sm:h-20 mb-2 flex items-center justify-center group-hover:scale-105 transition-transform duration-300"><img src="<?php echo get_template_directory_uri(); ?>/image/ind_other_globe.png" alt="Other Industries" class="w-full h-full object-contain"></div><p data-editable="factory-industries-p-8" <?php echo synergy_style('factory-industries-p-8', 'smart-factory'); ?> class="font-700 text-sm text-ink"><?php echo synergy_content('factory-industries-p-8', '<span class="lang-th">อุตสาหกรรมอื่น ๆ</span><span class="lang-en">Other Industries</span>', 'smart-factory'); ?></p></div>
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
              <span class="lang-en">Elevate Your Plant to a <span class="text-brand-bright">Smart Factory</span></span>', 'smart-factory'); ?></h2>
            <p data-editable="factory-cta-p" <?php echo synergy_style('factory-cta-p', 'smart-factory'); ?> class="sf-cta-lede text-slate-200 mt-5 max-w-2xl"><?php echo synergy_content('factory-cta-p', '<span class="lang-th">ทีมวิศวกรพร้อมสำรวจหน้างานและออกแบบระบบที่เหมาะสมกับกระบวนการผลิตของคุณ</span>
              <span class="lang-en">Our engineers are ready to survey your site and design a system that fits your production process.</span>', 'smart-factory'); ?></p>
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
