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
        <a href="#overview" class="border border-white/20 hover:bg-white/10 text-white font-700 text-xs tracking-wider uppercase px-8 py-4 rounded-xl transition">
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

  <!-- SYNEXTA INTELLIGENCE ARCHITECTURE -->
  <section id="factory-architecture" class="py-20 sm:py-24 bg-slate-50/70 border-b border-slate-200/80 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
      <!-- Pitch across the top, the same arrangement smart-energy.php uses
           for the equivalent block (its class name is literally
           "top-pitch-layout"). This lived in lg:col-span-3 - a quarter of a
           twelve-column grid - which left the headline wrapping over three
           lines and every feature description over four. Full width lets the
           four points sit in one row and gives the diagram the whole grid. -->
      <div class="max-w-3xl mx-auto text-center mb-8 sm:mb-10">
        <!-- The SynExta mark replaces the "SYNEXTA INTELLIGENCE ARCHITECTURE"
             eyebrow, the same way smart-energy.php opens its platform block.
             Sized by height so the 1997x227 source scales to the row rather
             than being letterboxed; width/height keep the heading from jumping
             while it loads. -->
        <div class="mb-4 flex justify-center">
          <img src="<?php echo get_template_directory_uri(); ?>/image/LOGO%20SYNEXTA.png" alt="SynExta" width="1997" height="227" loading="lazy" decoding="async" class="h-8 sm:h-10 w-auto object-contain drop-shadow-sm">
        </div>
        <h2 class="font-display font-black text-2xl sm:text-3xl lg:text-4xl text-slate-900 tracking-tight leading-tight">
          <span class="lang-th">แพลตฟอร์มเดียว<br><span class="text-emerald-700">ควบคุมทุกระบบของโรงงาน</span></span>
          <span class="lang-en">One Platform.<br><span class="text-emerald-700">Complete Control.</span></span>
        </h2>
      </div>

      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 mb-12 sm:mb-14">
              <!-- 1. SynExta Intelligence Engine -->
              <div class="flex gap-4 items-start">
                <span class="w-11 h-11 rounded-2xl bg-emerald-100/80 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0 shadow-xs"><i class="fa-solid fa-layer-group text-lg"></i></span>
                <div>
                  <h3 class="font-800 text-sm sm:text-base text-slate-900 mb-0.5">SynExta Intelligence Engine</h3>
                  <p class="text-xs text-slate-500 font-400 leading-relaxed"><span class="lang-th">สมองกลที่เชื่อม วิเคราะห์ และประสานข้อมูลอุตสาหกรรมทั้งหมด</span><span class="lang-en">The brain that connects, analyzes and orchestrates all industrial data.</span></p>
                </div>
              </div>
              <!-- 2. Flexible Deployment -->
              <div class="flex gap-4 items-start">
                <span class="w-11 h-11 rounded-2xl bg-emerald-100/80 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0 shadow-xs"><i class="fa-solid fa-server text-lg"></i></span>
                <div>
                  <h3 class="font-800 text-sm sm:text-base text-slate-900 mb-0.5"><span class="lang-th">รองรับการติดตั้งได้อย่างยืดหยุ่น</span><span class="lang-en">Flexible Deployment</span></h3>
                  <p class="text-xs text-slate-500 font-400 leading-relaxed"><span class="lang-th">Cloud, On-Premise หรือ Hybrid</span><span class="lang-en">Cloud, On-Premise or Hybrid Architecture.</span></p>
                </div>
              </div>
              <!-- 3. Open & Scalable -->
              <div class="flex gap-4 items-start">
                <span class="w-11 h-11 rounded-2xl bg-emerald-100/80 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0 shadow-xs"><i class="fa-solid fa-cubes text-lg"></i></span>
                <div>
                  <h3 class="font-800 text-sm sm:text-base text-slate-900 mb-0.5"><span class="lang-th">เชื่อมต่อได้อย่างอิสระ</span><span class="lang-en">Open &amp; Scalable</span></h3>
                  <p class="text-xs text-slate-500 font-400 leading-relaxed"><span class="lang-th">รองรับ Open API และการเชื่อมต่อกับระบบภายนอก</span><span class="lang-en">Open API and modular architecture.</span></p>
                </div>
              </div>
              <!-- 4. Secure by Design -->
              <div class="flex gap-4 items-start">
                <span class="w-11 h-11 rounded-2xl bg-emerald-100/80 border border-emerald-200 text-emerald-700 flex items-center justify-center shrink-0 shadow-xs"><i class="fa-solid fa-shield-halved text-lg"></i></span>
                <div>
                  <h3 class="font-800 text-sm sm:text-base text-slate-900 mb-0.5"><span class="lang-th">ออกแบบโดยคำนึงถึงความปลอดภัย</span><span class="lang-en">Secure by Design</span></h3>
                  <p class="text-xs text-slate-500 font-400 leading-relaxed"><span class="lang-th">รองรับมาตรฐาน Cybersecurity สำหรับภาคอุตสาหกรรม</span><span class="lang-en">Enterprise-grade cybersecurity and industrial security.</span></p>
                </div>
              </div>
      </div>

      <div class="grid lg:grid-cols-12 gap-8 lg:gap-6 items-center">
        <!-- Center: layered diagram -->
        <div class="lg:col-span-9 space-y-2.5">
          <!-- Business Applications -->
          <div class="rounded-2xl border border-slate-200/90 bg-white px-5 py-4 shadow-sm">
            <p class="text-[10px] font-800 text-emerald-700 uppercase tracking-[0.2em] text-center mb-3">BUSINESS APPLICATIONS</p>
            <div class="grid grid-cols-3 sm:grid-cols-6 gap-2.5 text-center">
              <!-- ERP -->
              <div class="flex flex-col items-center gap-2 py-3 px-2 rounded-xl border border-slate-100 bg-slate-50/80 text-slate-700 hover:border-emerald-200 transition-colors">
                <img src="<?php echo get_template_directory_uri(); ?>/image/icons/app_erp.png" alt="ERP" class="w-8 h-8 object-contain">
                <span class="text-xs font-700">ERP</span>
              </div>
              <!-- MES -->
              <div class="flex flex-col items-center gap-2 py-3 px-2 rounded-xl border border-slate-100 bg-slate-50/80 text-slate-700 hover:border-emerald-200 transition-colors">
                <img src="<?php echo get_template_directory_uri(); ?>/image/icons/app_mes.png" alt="MES" class="w-8 h-8 object-contain">
                <span class="text-xs font-700">MES</span>
              </div>
              <!-- SCADA -->
              <div class="flex flex-col items-center gap-2 py-3 px-2 rounded-xl border border-slate-100 bg-slate-50/80 text-slate-700 hover:border-emerald-200 transition-colors">
                <img src="<?php echo get_template_directory_uri(); ?>/image/icons/app_scada.png" alt="SCADA" class="w-8 h-8 object-contain">
                <span class="text-xs font-700">SCADA</span>
              </div>
              <!-- CRM -->
              <div class="flex flex-col items-center gap-2 py-3 px-2 rounded-xl border border-slate-100 bg-slate-50/80 text-slate-700 hover:border-emerald-200 transition-colors">
                <img src="<?php echo get_template_directory_uri(); ?>/image/icons/app_crm.png" alt="CRM" class="w-8 h-8 object-contain">
                <span class="text-xs font-700">CRM</span>
              </div>
              <!-- CMMS -->
              <div class="flex flex-col items-center gap-2 py-3 px-2 rounded-xl border border-slate-100 bg-slate-50/80 text-slate-700 hover:border-emerald-200 transition-colors">
                <img src="<?php echo get_template_directory_uri(); ?>/image/icons/app_cmms.png" alt="CMMS" class="w-8 h-8 object-contain">
                <span class="text-xs font-700">CMMS</span>
              </div>
              <!-- Other -->
              <div class="flex flex-col items-center gap-2 py-3 px-2 rounded-xl border border-slate-100 bg-slate-50/80 text-slate-700 hover:border-emerald-200 transition-colors">
                <i class="fa-solid fa-table-cells text-emerald-600 text-xl"></i>
                <span class="text-xs font-700">Other</span>
              </div>
            </div>
          </div>

          <!-- Arrow Down -->
          <div class="flex justify-center"><svg class="w-4 h-4 text-emerald-600 fill-current" viewBox="0 0 24 24"><path d="M12 16l-6-6h12l-6 6z"/></svg></div>

          <!-- SynExta Engine (HERO) -->
          <div class="rounded-2xl bg-gradient-to-r from-emerald-950 via-emerald-900 to-emerald-950 p-5 shadow-lg border border-emerald-800/50 relative overflow-hidden">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mb-3">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-800/50 border border-emerald-500/30 flex items-center justify-center text-emerald-300 shrink-0">
                  <i class="fa-solid fa-brain text-xl"></i>
                </div>
                <h3 class="font-display font-800 text-base sm:text-lg text-white tracking-wide">
                  SynExta Intelligence Engine
                </h3>
              </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-2 text-center">
              <div class="py-2.5 px-2 rounded-xl bg-emerald-800/40 border border-emerald-600/30 text-xs font-600 text-emerald-100 flex items-center justify-center gap-2">
                <i class="fa-solid fa-chart-simple text-emerald-400 text-base"></i>
                <span>AI Analytics</span>
              </div>
              <div class="py-2.5 px-2 rounded-xl bg-emerald-800/40 border border-emerald-600/30 text-xs font-600 text-emerald-100 flex items-center justify-center gap-2">
                <i class="fa-solid fa-sliders text-emerald-400 text-base"></i>
                <span>Rule Engine</span>
              </div>
              <div class="py-2.5 px-2 rounded-xl bg-emerald-800/40 border border-emerald-600/30 text-xs font-600 text-emerald-100 flex items-center justify-center gap-2">
                <i class="fa-solid fa-database text-emerald-400 text-base"></i>
                <span>Data Lake</span>
              </div>
              <div class="py-2.5 px-2 rounded-xl bg-emerald-800/40 border border-emerald-600/30 text-xs font-600 text-emerald-100 flex items-center justify-center gap-2">
                <i class="fa-solid fa-link text-emerald-400 text-base"></i>
                <span>API &amp; Integration</span>
              </div>
              <div class="py-2.5 px-2 rounded-xl bg-emerald-800/40 border border-emerald-600/30 text-xs font-600 text-emerald-100 flex items-center justify-center gap-2">
                <i class="fa-solid fa-chart-pie text-emerald-400 text-base"></i>
                <span>Dashboard &amp; Insights</span>
              </div>
            </div>
          </div>

          <!-- Arrow Down -->
          <div class="flex justify-center"><svg class="w-4 h-4 text-emerald-600 fill-current" viewBox="0 0 24 24"><path d="M12 16l-6-6h12l-6 6z"/></svg></div>

          <!-- Industrial IoT Platform -->
          <div class="rounded-2xl border border-slate-200/90 bg-white px-5 py-4 shadow-sm">
            <p class="text-[10px] font-800 text-emerald-700 uppercase tracking-[0.2em] text-center mb-3">INDUSTRIAL IOT PLATFORM</p>
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-2 text-center">
              <div class="py-2.5 px-2 rounded-xl border border-slate-100 bg-slate-50/80 text-xs font-600 text-slate-700 flex items-center justify-center gap-2">
                <img src="<?php echo get_template_directory_uri(); ?>/image/icons/iot_device.png" alt="Device Mgmt" class="w-6 h-6 object-contain">
                <span>Device Mgmt</span>
              </div>
              <div class="py-2.5 px-2 rounded-xl border border-slate-100 bg-slate-50/80 text-xs font-600 text-slate-700 flex items-center justify-center gap-2">
                <img src="<?php echo get_template_directory_uri(); ?>/image/icons/iot_data.png" alt="Data Mgmt" class="w-6 h-6 object-contain">
                <span>Data Mgmt</span>
              </div>
              <div class="py-2.5 px-2 rounded-xl border border-slate-100 bg-slate-50/80 text-xs font-600 text-slate-700 flex items-center justify-center gap-2">
                <img src="<?php echo get_template_directory_uri(); ?>/image/icons/iot_alarm.png" alt="Alarm Mgmt" class="w-6 h-6 object-contain">
                <span>Alarm Mgmt</span>
              </div>
              <div class="py-2.5 px-2 rounded-xl border border-slate-100 bg-slate-50/80 text-xs font-600 text-slate-700 flex items-center justify-center gap-2">
                <img src="<?php echo get_template_directory_uri(); ?>/image/icons/iot_workflow.png" alt="Workflow" class="w-6 h-6 object-contain">
                <span>Workflow</span>
              </div>
              <div class="py-2.5 px-2 rounded-xl border border-slate-100 bg-slate-50/80 text-xs font-600 text-slate-700 flex items-center justify-center gap-2">
                <img src="<?php echo get_template_directory_uri(); ?>/image/icons/iot_security.png" alt="Security" class="w-6 h-6 object-contain">
                <span>Security</span>
              </div>
            </div>
          </div>

          <!-- Arrow Down -->
          <div class="flex justify-center"><svg class="w-4 h-4 text-emerald-600 fill-current" viewBox="0 0 24 24"><path d="M12 16l-6-6h12l-6 6z"/></svg></div>

          <!-- Edge Layer -->
          <div class="rounded-2xl border border-slate-200/90 bg-white px-5 py-4 shadow-sm">
            <p class="text-[10px] font-800 text-emerald-700 uppercase tracking-[0.2em] text-center mb-3">EDGE LAYER</p>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-center">
              <div class="py-2.5 px-2 rounded-xl border border-slate-100 bg-slate-50/80 text-xs font-600 text-slate-700 flex items-center justify-center gap-2">
                <img src="<?php echo get_template_directory_uri(); ?>/image/icons/edge_gateway.png" alt="Edge Gateway" class="w-6 h-6 object-contain">
                <span>Edge Gateway</span>
              </div>
              <div class="py-2.5 px-2 rounded-xl border border-slate-100 bg-slate-50/80 text-xs font-600 text-slate-700 flex items-center justify-center gap-2">
                <img src="<?php echo get_template_directory_uri(); ?>/image/icons/edge_controller.png" alt="Edge Controller" class="w-6 h-6 object-contain">
                <span>Edge Controller</span>
              </div>
              <div class="py-2.5 px-2 rounded-xl border border-slate-100 bg-slate-50/80 text-xs font-600 text-slate-700 flex items-center justify-center gap-2">
                <i class="fa-solid fa-right-left text-emerald-600 text-base"></i>
                <span>Protocol Conversion</span>
              </div>
              <div class="py-2.5 px-2 rounded-xl border border-slate-100 bg-slate-50/80 text-xs font-600 text-slate-700 flex items-center justify-center gap-2">
                <img src="<?php echo get_template_directory_uri(); ?>/image/icons/edge_local.png" alt="Local Processing" class="w-6 h-6 object-contain">
                <span>Local Processing</span>
              </div>
            </div>
          </div>

          <!-- Arrow Down -->
          <div class="flex justify-center"><svg class="w-4 h-4 text-emerald-600 fill-current" viewBox="0 0 24 24"><path d="M12 16l-6-6h12l-6 6z"/></svg></div>

          <!-- Field Devices & Shopfloor -->
          <div class="rounded-2xl border border-slate-200/90 bg-white px-5 py-4 shadow-sm">
            <p class="text-[10px] font-800 text-emerald-700 uppercase tracking-[0.2em] text-center mb-3">FIELD DEVICES &amp; SHOPFLOOR</p>
            <div class="grid grid-cols-4 sm:grid-cols-8 gap-2 text-center">
              <div class="flex flex-col items-center gap-1.5 py-1.5 group">
                <span class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center p-2 group-hover:scale-105 transition-transform"><img src="<?php echo get_template_directory_uri(); ?>/image/icons/field_plc.png" alt="PLC / Controller" class="w-full h-full object-contain"></span>
                <span class="text-[11px] font-600 text-slate-700 leading-tight">PLC / Controller</span>
              </div>
              <div class="flex flex-col items-center gap-1.5 py-1.5 group">
                <span class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center p-2 group-hover:scale-105 transition-transform"><img src="<?php echo get_template_directory_uri(); ?>/image/icons/field_machine.png" alt="Machines" class="w-full h-full object-contain"></span>
                <span class="text-[11px] font-600 text-slate-700 leading-tight">Machines</span>
              </div>
              <div class="flex flex-col items-center gap-1.5 py-1.5 group">
                <span class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center p-2 group-hover:scale-105 transition-transform"><img src="<?php echo get_template_directory_uri(); ?>/image/icons/field_sensor.png" alt="Sensors" class="w-full h-full object-contain"></span>
                <span class="text-[11px] font-600 text-slate-700 leading-tight">Sensors</span>
              </div>
              <div class="flex flex-col items-center gap-1.5 py-1.5 group">
                <span class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center p-2 group-hover:scale-105 transition-transform"><img src="<?php echo get_template_directory_uri(); ?>/image/icons/field_energy.png" alt="Energy Meters" class="w-full h-full object-contain"></span>
                <span class="text-[11px] font-600 text-slate-700 leading-tight">Energy Meters</span>
              </div>
              <div class="flex flex-col items-center gap-1.5 py-1.5 group">
                <span class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center p-2 group-hover:scale-105 transition-transform"><img src="<?php echo get_template_directory_uri(); ?>/image/icons/field_vision.png" alt="Vision Systems" class="w-full h-full object-contain"></span>
                <span class="text-[11px] font-600 text-slate-700 leading-tight">Vision Systems</span>
              </div>
              <div class="flex flex-col items-center gap-1.5 py-1.5 group">
                <span class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center p-2 group-hover:scale-105 transition-transform"><img src="<?php echo get_template_directory_uri(); ?>/image/icons/field_robot.png" alt="Robots" class="w-full h-full object-contain"></span>
                <span class="text-[11px] font-600 text-slate-700 leading-tight">Robots</span>
              </div>
              <div class="flex flex-col items-center gap-1.5 py-1.5 group">
                <span class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center p-2 group-hover:scale-105 transition-transform"><img src="<?php echo get_template_directory_uri(); ?>/image/icons/field_iot.png" alt="IoT Devices" class="w-full h-full object-contain"></span>
                <span class="text-[11px] font-600 text-slate-700 leading-tight">IoT Devices</span>
              </div>
              <div class="flex flex-col items-center gap-1.5 py-1.5">
                <span class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl"><i class="fa-solid fa-ellipsis"></i></span>
                <span class="text-[11px] font-600 text-slate-700 leading-tight">More</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Right: deployment branch -->
        <div class="lg:col-span-3 relative flex flex-col items-center justify-center gap-2.5 max-w-[140px] mx-auto lg:max-w-none">
          <!-- vertical dashed spine connecting Cloud -> OR -> On-Premise (lg) -->
          <span class="hidden lg:block absolute left-1/2 -translate-x-1/2 top-6 bottom-6 border-l border-dashed border-slate-300 pointer-events-none z-0"></span>
          
          <!-- horizontal dashed line connecting Center Diagram -> OR circle (lg) -->
          <span class="hidden lg:block absolute top-1/2 -translate-y-1/2 right-1/2 w-[calc(50%+0.75rem)] border-t border-dashed border-slate-300 pointer-events-none z-0"></span>

          <!-- CLOUD Card -->
          <div class="w-full rounded-xl border border-slate-200/90 bg-white p-3 shadow-2xs hover:shadow-sm hover:border-emerald-200 transition-all duration-300 text-center relative z-10 flex flex-col items-center group">
            <div class="w-12 h-12 mb-1.5 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
              <img src="<?php echo get_template_directory_uri(); ?>/image/icons/cloud-deployment.png" alt="Cloud" class="w-full h-full object-contain">
            </div>
            <h4 class="font-display font-800 text-xs text-ink uppercase tracking-wider mb-0.5">
              CLOUD
            </h4>
            <p data-editable="factory-architecture-p-1" <?php echo synergy_style('factory-architecture-p-1', 'smart-factory'); ?> class="text-[10px] text-slate-500 font-400 leading-tight"><?php echo synergy_content('factory-architecture-p-1', '<span class="lang-th">ยืดหยุ่น ปลอดภัย</span>
              <span class="lang-en">Scalable &amp; Secure</span>', 'smart-factory'); ?></p>
          </div>

          <!-- OR Divider -->
          <span class="w-6 h-6 rounded-full bg-white border border-slate-200 shadow-2xs flex items-center justify-center text-[9.5px] font-800 text-slate-400 uppercase shrink-0 relative z-10">
            OR
          </span>

          <!-- ON-PREMISE Card -->
          <div class="w-full rounded-xl border border-slate-200/90 bg-white p-3 shadow-2xs hover:shadow-sm hover:border-emerald-200 transition-all duration-300 text-center relative z-10 flex flex-col items-center group">
            <div class="w-12 h-12 mb-1.5 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
              <img src="<?php echo get_template_directory_uri(); ?>/image/icons/on-premise-deployment.png" alt="On-Premise" class="w-full h-full object-contain">
            </div>
            <h4 class="font-display font-800 text-xs text-ink uppercase tracking-wider mb-0.5">
              ON-PREMISE
            </h4>
            <p data-editable="factory-architecture-p-2" <?php echo synergy_style('factory-architecture-p-2', 'smart-factory'); ?> class="text-[10px] text-slate-500 font-400 leading-tight"><?php echo synergy_content('factory-architecture-p-2', '<span class="lang-th">เสถียร เป็นส่วนตัว</span>
              <span class="lang-en">Reliable &amp; Private</span>', 'smart-factory'); ?></p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- SMART FACTORY CAPABILITIES -->
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
            <img src="<?php echo get_template_directory_uri(); ?>/image/icons/iiot.png" alt="Industrial IoT (IIoT)" class="w-full h-full object-contain">
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
            <img src="<?php echo get_template_directory_uri(); ?>/image/icons/machine-monitoring.png" alt="Machine Monitoring" class="w-full h-full object-contain">
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
            <img src="<?php echo get_template_directory_uri(); ?>/image/icons/oee-analytics.png" alt="OEE Analytics" class="w-full h-full object-contain">
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
            <img src="<?php echo get_template_directory_uri(); ?>/image/icons/predictive-maintenance.png" alt="Predictive Maintenance" class="w-full h-full object-contain">
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
            <img src="<?php echo get_template_directory_uri(); ?>/image/icons/ai-analytics.png" alt="AI Analytics" class="w-full h-full object-contain">
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
            <img src="<?php echo get_template_directory_uri(); ?>/image/icons/production-traceability.png" alt="Production Traceability" class="w-full h-full object-contain">
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
            <img src="<?php echo get_template_directory_uri(); ?>/image/icons/energy-monitoring.png" alt="Energy Monitoring" class="w-full h-full object-contain">
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
            <img src="<?php echo get_template_directory_uri(); ?>/image/icons/industrial-dashboard.png" alt="Industrial Dashboard" class="w-full h-full object-contain">
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
            <img src="<?php echo get_template_directory_uri(); ?>/image/icons/edge-computing.png" alt="Edge Computing" class="w-full h-full object-contain">
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
            <img src="<?php echo get_template_directory_uri(); ?>/image/icons/cloud-platform.png" alt="Cloud Platform" class="w-full h-full object-contain">
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
            <img src="<?php echo get_template_directory_uri(); ?>/image/icons/on-premise-deployment.png" alt="On-Premise Deployment" class="w-full h-full object-contain">
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
            <img src="<?php echo get_template_directory_uri(); ?>/image/icons/erp-mes-integration.png" alt="ERP / MES Integration" class="w-full h-full object-contain">
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

  <!-- OVERVIEW -->
  <section id="overview" class="py-24 bg-surface">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid lg:grid-cols-2 gap-16 items-start">
        <div class="space-y-6">
          <span class="bg-brand/10 text-brand text-xs font-700 uppercase tracking-widest px-3 py-1 rounded-full inline-block">OT/IT Integration</span>
          <h2 class="font-display font-800 text-3xl sm:text-4xl text-ink leading-snug">
            <span class="lang-th">โรงงานอัจฉริยะ<br>ที่เห็นทุกอย่างแบบเรียลไทม์</span>
            <span class="lang-en">A Smart Factory<br>That Sees Everything in Real Time</span>
          </h2>
          <p class="text-sm text-body font-300 leading-relaxed">
            <span class="lang-th">เชื่อมต่อเซนเซอร์ความร้อน (Thermocouple Type K), อัตราการไหล (Flow rate sensor) และ Load cell เข้ากับบอร์ดเกตเวย์ HandySense ส่งข้อมูลขึ้นคลาวด์ ThingBoard เพื่อประเมินค่า OEE แบบ Real-time</span>
            <span class="lang-en">Connect thermocouple (Type K), flow rate, and load cell sensors to the HandySense gateway, streaming data to ThingBoard Cloud for real-time OEE analysis.</span>
          </p>
          <!-- Sensor list -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white border border-gray-100 rounded-xl p-4 flex items-start gap-3">
              <span class="w-8 h-8 rounded-lg bg-brand-soft text-brand flex items-center justify-center shrink-0"><i class="fa-solid fa-temperature-high text-sm"></i></span>
              <div><p class="text-xs font-700 text-ink">Thermocouple Type K</p><p class="text-[11px] text-muted font-300"><span class="lang-th">วัดอุณหภูมิเครื่องจักรแบบ Real-time</span><span class="lang-en">Real-time machine temperature</span></p></div>
            </div>
            <div class="bg-white border border-gray-100 rounded-xl p-4 flex items-start gap-3">
              <span class="w-8 h-8 rounded-lg bg-brand-soft text-brand flex items-center justify-center shrink-0"><i class="fa-solid fa-water text-sm"></i></span>
              <div><p class="text-xs font-700 text-ink">Flow Rate Sensor</p><p class="text-[11px] text-muted font-300"><span class="lang-th">อัตราการไหลของของเหลวในกระบวนการ</span><span class="lang-en">Process fluid flow rate</span></p></div>
            </div>
            <div class="bg-white border border-gray-100 rounded-xl p-4 flex items-start gap-3">
              <span class="w-8 h-8 rounded-lg bg-brand-soft text-brand flex items-center justify-center shrink-0"><i class="fa-solid fa-weight-hanging text-sm"></i></span>
              <div><p class="text-xs font-700 text-ink">Load Cell</p><p class="text-[11px] text-muted font-300"><span class="lang-th">สถิติแรงกดรับน้ำหนักแม่นยำสูง</span><span class="lang-en">High-precision load measurement</span></p></div>
            </div>
            <div class="bg-white border border-gray-100 rounded-xl p-4 flex items-start gap-3">
              <span class="w-8 h-8 rounded-lg bg-brand-soft text-brand flex items-center justify-center shrink-0"><i class="fa-solid fa-microchip text-sm"></i></span>
              <div><p class="text-xs font-700 text-ink">HandySense Gateway</p><p class="text-[11px] text-muted font-300"><span class="lang-th">บอร์ดรวบรวมข้อมูลสู่คลาวด์</span><span class="lang-en">Edge gateway to the cloud</span></p></div>
            </div>
          </div>
        </div>
        <!-- SynWISEMove Card (High-Contrast Refined Design) -->
        <div class="bg-[#0B2E1E] text-white rounded-3xl overflow-hidden shadow-xl border border-white/5 relative group hover:-translate-y-1.5 spring-duration">
          <div class="absolute inset-0 opacity-20 pointer-events-none bg-mesh-dark"></div>
          <div class="w-full h-56 overflow-hidden border-b border-slate-100">
            <img loading="lazy" decoding="async" src="<?php echo get_template_directory_uri(); ?>/image/solutions/factory-warehouse-automation.png" alt="SynWISEMove Warehouse Automation — AGV robot in facility" class="w-full h-full object-cover" />
          </div>
          <div class="p-8 relative z-10">
            <span class="text-gold-bright text-xs font-bold uppercase tracking-wider block mb-3">SynWISEMove</span>
            <h3 class="font-display font-bold text-xl text-white mb-4">Warehouse Automation</h3>
            <p class="text-sm text-white/70 font-light leading-relaxed mb-6">
              <span class="lang-th">ระบบสมองกลควบคุมประสานงานหุ่นยนต์ลากจูงคลังสินค้าอัตโนมัติ (AGVs, AMRs, Autonomous Forklifts) ควบคุมการเคลื่อนย้ายและป้องกันการชนอย่างมีเสถียรภาพ</span>
              <span class="lang-en">An orchestration brain coordinating automated fleet robots (AGVs, AMRs, autonomous forklifts) — managing movement and preventing collisions with stability.</span>
            </p>
            <div class="space-y-3">
              <div class="flex items-center gap-3 text-xs sm:text-sm"><i class="fa-solid fa-circle-check text-emerald-400 text-sm"></i><span class="text-white/80 font-light"><span class="lang-th">เพิ่มประสิทธิภาพการสัญจรในคลัง</span><span class="lang-en">Increase productivity</span></span></div>
              <div class="flex items-center gap-3 text-xs sm:text-sm"><i class="fa-solid fa-circle-check text-emerald-400 text-sm"></i><span class="text-white/80 font-light"><span class="lang-th">ลดอุบัติเหตุจากคนและเครื่องจักร</span><span class="lang-en">Improve safety</span></span></div>
              <div class="flex items-center gap-3 text-xs sm:text-sm"><i class="fa-solid fa-circle-check text-emerald-400 text-sm"></i><span class="text-white/80 font-light"><span class="lang-th">ขยายขีดความสามารถได้อย่างมั่นใจ</span><span class="lang-en">Scale with confidence</span></span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- OTHER SOLUTIONS -->
  <section id="factory-related" class="py-16 bg-surface border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6">
      <p class="text-center text-xs text-muted uppercase tracking-wider mb-8 font-700"><span class="lang-th">โซลูชันอื่นๆ</span><span class="lang-en">Other Solutions</span></p>
      <div class="grid sm:grid-cols-2 gap-4 max-w-2xl mx-auto">
        <a href="<?php echo home_url('/smart-energy/'); ?>" class="bg-white border border-gray-100 rounded-2xl p-5 flex items-center gap-4 hover:shadow-md hover:border-brand/20 transition group">
          <span class="w-10 h-10 rounded-xl bg-brand-soft text-brand flex items-center justify-center group-hover:bg-brand group-hover:text-white transition"><i class="fa-solid fa-bolt"></i></span>
          <div><p class="font-700 text-sm text-ink">Smart Energy</p><p class="text-xs text-muted font-300"><span class="lang-th">บริหารพลังงานอัจฉริยะ</span><span class="lang-en">Intelligent energy management</span></p></div>
        </a>
        <a href="<?php echo home_url('/'); ?>#solutions" class="bg-white border border-gray-100 rounded-2xl p-5 flex items-center gap-4 hover:shadow-md hover:border-brand/20 transition group">
          <span class="w-10 h-10 rounded-xl bg-brand-soft text-brand flex items-center justify-center group-hover:bg-brand group-hover:text-white transition"><i class="fa-solid fa-seedling"></i></span>
          <div><p class="font-700 text-sm text-ink">Smart Agriculture</p><p class="text-xs text-muted font-300"><span class="lang-th">เกษตรอัจฉริยะ & Carbon Credit</span><span class="lang-en">Smart farming & carbon credit</span></p></div>
        </a>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <!-- CLOSING CTA
       Same treatment as the closing CTA on smart-energy.php: gradient card on a
       white section, eyebrow over the headline, copy on the left and the action
       held in its own column on the right so it does not get lost under a wide
       paragraph. The wording is this page's own. -->
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

<?php include __DIR__ . '/components/cookie-consent.php'; ?>
  <?php wp_footer(); ?>
</body>

</html>
