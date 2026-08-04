<?php
/* Template Name: Services Page */
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
if (!function_exists('wp_enqueue_style')) {
    function wp_enqueue_style() {}
}
if (!function_exists('add_action')) {
    function add_action() {}
}
if (!function_exists('add_theme_support')) {
    function add_theme_support() {}
}
if (!function_exists('language_attributes')) {
    function language_attributes() { echo 'lang="th"'; }
}
if (!function_exists('bloginfo')) {
    function bloginfo($show = '') { echo ''; }
}
if (!function_exists('is_front_page')) {
    function is_front_page() { return false; }
}
if (!function_exists('is_home')) {
    function is_home() { return false; }
}
if (file_exists(__DIR__ . '/functions.php')) {
    require_once __DIR__ . '/functions.php';
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Services — End-to-End Product Development | พัฒนาผลิตภัณฑ์ครบวงจร</title>

<meta name="description" content="Syntech is your trusted engineering partner for end-to-end product development — from design and prototyping to manufacturing, certification and after-sales support. พัฒนาผลิตภัณฑ์ครบวงจร ตั้งแต่แนวคิดจนพร้อมออกสู่ตลาด">
<meta name="theme-color" content="#004d3a">
<meta name="color-scheme" content="light">
<meta name="robots" content="index, follow, max-image-preview:large">
<link rel="canonical" href="<?php echo home_url('/service/'); ?>">

<!-- Open Graph / Twitter -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="Syntech">
<meta property="og:url" content="<?php echo home_url('/service/'); ?>">
<meta property="og:title" content="Services — End-to-End Product Development">
<meta property="og:description" content="From product design and prototyping to manufacturing and after-sales support, we deliver innovative, reliable, and market-ready solutions.">
<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/Home.png">
<meta property="og:image:width" content="611">
<meta property="og:image:height" content="480">
<meta property="og:locale" content="th_TH">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Services — End-to-End Product Development">
<meta name="twitter:description" content="พัฒนาผลิตภัณฑ์ครบวงจร ตั้งแต่แนวคิดจนพร้อมออกสู่ตลาด">
<meta name="twitter:image" content="<?php echo get_template_directory_uri(); ?>/Home.png">

<!-- Browser Tab Icon (Favicon) -->
<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/image/s-logo.png">
<link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/image/s-logo.png">
<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/image/s-logo.png">

<!-- Tailwind CSS CDN (For Header/Footer and Global Styles compatibility) -->
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

<!-- Fonts: IBM Plex Sans Thai carries both Thai + Latin; Jakarta for display. -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Original stylesheet from wise-bohr for exact visual match -->
<link rel="stylesheet" href="<?php echo function_exists('synergy_asset') ? synergy_asset('components/wise-bohr-style.css') : './components/wise-bohr-style.css'; ?>">

<!-- Global Theme Overrides -->
<link rel="stylesheet" href="<?php echo function_exists('synergy_asset') ? synergy_asset('components/style.css') : './components/style.css'; ?>">

<style>
    /* Specific adjustments to ensure wise-bohr styles do not clash with tailwind navbar/footer */
    nav, nav *, footer, footer * {
      box-sizing: border-box !important;
    }
    
    /* Ensure the padding matches standard layout spacing under the fixed header */
    .hero {
      padding-top: 130px !important;
    }
    @media (max-width: 1024px) {
      .hero {
        padding-top: 100px !important;
      }
    }
</style>

<!-- Opt into scroll-reveal only when scripting is live, before first paint. -->
<script>document.documentElement.classList.add('js-reveal');</script>
<script>
    window.wpThemeUrl = "<?php echo get_template_directory_uri(); ?>/";
    window.wpThemeUri = "<?php echo get_template_directory_uri(); ?>/";
</script>
<?php wp_head(); ?>
</head>
<body <?php body_class("bg-white text-body antialiased"); ?>>

<a class="skip-link" href="#main">ข้ามไปยังเนื้อหาหลัก</a>

<!-- NAVBAR CONTAINER -->
<div id="navbar-container"></div>

<!-- ==========================================================================
     Icon sprite — inline so the page needs no external icon font/CDN
     ========================================================================== -->
<svg width="0" height="0" hidden aria-hidden="true" focusable="false" style="position:absolute">
  <defs>
    <symbol id="ic-x" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6 6 18"/></symbol>
    <symbol id="ic-arrow-up" viewBox="0 0 24 24"><path d="M12 20V5"/><path d="m6 11 6-6 6 6"/></symbol>
    <symbol id="ic-send" viewBox="0 0 24 24"><path d="M22 2 11 13"/><path d="M22 2 15 22l-4-9-9-4z"/></symbol>
    <symbol id="ic-chat" viewBox="0 0 24 24"><path d="M21 12a8 8 0 0 1-8 8H8l-5 3 1.4-4.5A8 8 0 1 1 21 12z"/></symbol>
    <symbol id="ic-check-circle" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m8.5 12.5 2.5 2.5 5-5"/></symbol>
    <symbol id="ic-alert" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16.4v.2"/></symbol>
    <symbol id="ic-users" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.9"/><path d="M16 3.1a4 4 0 0 1 0 7.8"/></symbol>
    <symbol id="ic-shield" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></symbol>
    <symbol id="ic-trending" viewBox="0 0 24 24"><path d="M22 7 13.5 15.5 8.5 10.5 2 17"/><path d="M16 7h6v6"/></symbol>
    <symbol id="ic-layers" viewBox="0 0 24 24"><path d="m12 2 9 5-9 5-9-5 9-5z"/><path d="m3 12 9 5 9-5"/><path d="m3 17 9 5 9-5"/></symbol>
    <symbol id="ic-factory" viewBox="0 0 24 24"><path d="M2 20h20"/><path d="M4 20V10l5 3V10l5 3V7l6 4v9"/><path d="M8 20v-4h3v4"/></symbol>
    <symbol id="ic-globe" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18z"/></symbol>
    <symbol id="ic-partners" viewBox="0 0 24 24"><circle cx="8.5" cy="12" r="5"/><circle cx="15.5" cy="12" r="5"/></symbol>
    <symbol id="ic-bulb" viewBox="0 0 24 24"><path d="M9 18h6"/><path d="M10 21.5h4"/><path d="M12 2a7 7 0 0 0-4 12.7V18h8v-3.3A7 7 0 0 0 12 2z"/></symbol>
    <symbol id="ic-ruler" viewBox="0 0 24 24"><path d="M3 17 17 3l4 4L7 21z"/><path d="m7.5 11.5 2 2"/><path d="m11.5 7.5 2 2"/></symbol>
    <symbol id="ic-code" viewBox="0 0 24 24"><path d="m16 18 6-6-6-6"/><path d="m8 6-6 6 6 6"/></symbol>
    <symbol id="ic-clipboard" viewBox="0 0 24 24"><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></symbol>
    <symbol id="ic-cpu" viewBox="0 0 24 24"><rect x="6" y="6" width="12" height="12" rx="2"/><rect x="10" y="10" width="4" height="4"/><path d="M9 2.5V6M15 2.5V6M9 18v3.5M15 18v3.5M2.5 9H6M2.5 15H6M18 9h3.5M18 15h3.5"/></symbol>
    <symbol id="ic-package" viewBox="0 0 24 24"><path d="m12 2.5 9 5v9l-9 5-9-5v-9z"/><path d="m3 7.5 9 5 9-5"/><path d="M12 12.5v9"/></symbol>
    <symbol id="ic-headset" viewBox="0 0 24 24"><path d="M4 15v-3a8 8 0 0 1 16 0v3"/><rect x="2" y="14" width="5" height="7" rx="2"/><rect x="17" y="14" width="5" height="7" rx="2"/></symbol>
    <symbol id="ic-beaker" viewBox="0 0 24 24"><path d="M9 2.5h6"/><path d="M10 2.5v6L5.2 19a2 2 0 0 0 1.8 2.9h10a2 2 0 0 0 1.8-2.9L14 8.5v-6"/><path d="M7.2 15h9.6"/></symbol>
    <symbol id="ic-sliders" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/><circle cx="9" cy="6" r="2"/><circle cx="15" cy="12" r="2"/><circle cx="8" cy="18" r="2"/></symbol>
    <symbol id="ic-award" viewBox="0 0 24 24"><circle cx="12" cy="9" r="6"/><path d="m8.6 14-1.6 8 5-3 5 3-1.6-8"/></symbol>
    <symbol id="ic-listcheck" viewBox="0 0 24 24"><path d="M11 6h10M11 12h10M11 18h10"/><path d="m3 6 1.5 1.5L7.5 4.5"/><path d="m3 12 1.5 1.5L7.5 10.5"/><path d="m3 18 1.5 1.5L7.5 16.5"/></symbol>
    <symbol id="ic-truck" viewBox="0 0 24 24"><rect x="1.5" y="7" width="13.5" height="9" rx="1.5"/><path d="M15 10h4l3 3.2V16h-7z"/><circle cx="6" cy="18" r="2"/><circle cx="18" cy="18" r="2"/></symbol>
    <symbol id="ic-target" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1.2"/></symbol>
    <symbol id="ic-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5.2l3 1.8"/></symbol>
    <symbol id="ic-car" viewBox="0 0 24 24"><path d="M5 13l1.6-4.5A2 2 0 0 1 8.5 7h7a2 2 0 0 1 1.9 1.5L19 13"/><path d="M4 13h16a1 1 0 0 1 1 1v3H3v-3a1 1 0 0 1 1-1z"/><circle cx="7" cy="17.5" r="1.6"/><circle cx="17" cy="17.5" r="1.6"/></symbol>
    <symbol id="ic-leaf" viewBox="0 0 24 24"><path d="M11 20.5A7.5 7.5 0 0 1 3.5 13C3.5 7 10.5 3.5 20.5 3.5c0 10-3.5 17-9.5 17z"/><path d="M4 21c4-8.5 8.5-11.5 13.5-13.5"/></symbol>
  </defs>
</svg>

<main id="main">

<!-- ==========================================================================
     Hero
     ========================================================================== -->
<section class="hero" id="services" aria-labelledby="hero-title">
  <div class="shell">
    <div class="hero__grid">

      <div class="hero__intro">
        <p class="eyebrow" data-reveal>Our Service</p>

        <h1 class="hero__title" id="hero-title" lang="en" data-reveal style="--reveal-delay:60ms">
          End-to-End<span class="br"> </span>Product Development
        </h1>

        <p class="hero__lede" data-reveal style="--reveal-delay:120ms">
          พัฒนาผลิตภัณฑ์ครบวงจร ตั้งแต่แนวคิดจนพร้อมออกสู่ตลาด
        </p>

        <p class="hero__copy" lang="en" data-reveal style="--reveal-delay:180ms">
          We are your trusted engineering partner. From product design and prototyping
          to manufacturing and after-sales support, we deliver innovative, reliable,
          and market-ready solutions.
        </p>

        <ul class="props" data-reveal style="--reveal-delay:240ms">
          <li class="prop">
            <span class="prop__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-users"></use></svg></span>
            <b lang="en">One Partner</b>
            <p>ดูแลครบทุกขั้นตอน ในที่เดียว</p>
          </li>
          <li class="prop">
            <span class="prop__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-check-circle"></use></svg></span>
            <b lang="en">Faster to Market</b>
            <p>ลดเวลาในการพัฒนา และเปิดตัวสินค้า</p>
          </li>
          <li class="prop">
            <span class="prop__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-target"></use></svg></span>
            <b lang="en">Quality &amp; Compliance</b>
            <p>มาตรฐานสากล เชื่อถือได้</p>
          </li>
          <li class="prop">
            <span class="prop__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-trending"></use></svg></span>
            <b lang="en">Business Impact</b>
            <p>สร้างคุณค่าและความได้เปรียบ ในการแข่งขัน</p>
          </li>
        </ul>
      </div>

      <div class="hero__media" data-reveal style="--reveal-delay:120ms">
        <img src="<?php echo get_template_directory_uri(); ?>/Home.png" alt="ภาพรวมบริการพัฒนาผลิตภัณฑ์ครบวงจรของ Syntech"
             class="hero__img" width="611" height="480"
             fetchpriority="high" decoding="async">
      </div>

    </div>
  </div>
</section>


<!-- ==========================================================================
     Why choose Syntech
     ========================================================================== -->
<section class="section" id="why-us" aria-labelledby="why-title">
  <div class="shell">
    <div class="why__box" data-reveal>
      <div class="why__intro">
        <h2 class="why__title" id="why-title" lang="en">
          Why Choose Syntech<span class="br"> </span>for Your Product Development?
        </h2>
      </div>

      <ul class="why__features">
        <li class="why-feat">
          <span class="why-feat__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-users"></use></svg></span>
          <b lang="en">Engineering Excellence</b>
          <p>ทีมวิศวกรผู้เชี่ยวชาญ และมีประสบการณ์</p>
        </li>
        <li class="why-feat">
          <span class="why-feat__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-layers"></use></svg></span>
          <b lang="en">End-to-End Solutions</b>
          <p>ครบทุกขั้นตอนตั้งแต่ ออกแบบจนส่งมอบ</p>
        </li>
        <li class="why-feat">
          <span class="why-feat__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-factory"></use></svg></span>
          <b lang="en">Scalable Production</b>
          <p>รองรับการผลิตตั้งแต่ ต้นแบบถึงจำนวนมาก</p>
        </li>
        <li class="why-feat">
          <span class="why-feat__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-globe"></use></svg></span>
          <b lang="en">Global Standards</b>
          <p>มาตรฐานการผลิตและ คุณภาพระดับสากล</p>
        </li>
        <li class="why-feat">
          <span class="why-feat__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-partners"></use></svg></span>
          <b lang="en">Long-term Partnership</b>
          <p>เป็นพาร์ทเนอร์ระยะยาว ที่ธุรกิจไว้วางใจ</p>
        </li>
      </ul>
    </div>
  </div>
</section>


<!-- ==========================================================================
     Process — an ordered list, because the order carries meaning
     ========================================================================== -->
<section class="section" id="process" aria-labelledby="process-title">
  <div class="shell">

    <div class="section-head section-head--center">
      <h2 class="section-title" id="process-title" lang="en" data-reveal>
        Our End-to-End Process
      </h2>
      <div class="title-bar" data-reveal aria-hidden="true"></div>
    </div>

    <ol class="process__steps" data-reveal>
      <li class="p-step">
        <span class="p-step__badge" aria-hidden="true">1</span>
        <span class="p-step__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-bulb"></use></svg></span>
        <h3 class="p-step__title" lang="en">Concept &amp;<span class="br"> </span>Requirement</h3>
        <ul class="p-step__list">
          <li>วิเคราะห์ความต้องการ</li>
          <li>ศึกษาความเป็นไปได้</li>
          <li>วางแผนโครงการ</li>
        </ul>
      </li>

      <li class="p-step">
        <span class="p-step__badge" aria-hidden="true">2</span>
        <span class="p-step__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-ruler"></use></svg></span>
        <h3 class="p-step__title" lang="en">Product Design<span class="br"> </span>&amp; Engineering</h3>
        <ul class="p-step__list">
          <li>ออกแบบฮาร์ดแวร์/ซอฟต์แวร์</li>
          <li lang="en">PCB &amp; Mechanical Design</li>
          <li lang="en">Simulation &amp; Review</li>
        </ul>
      </li>

      <li class="p-step">
        <span class="p-step__badge" aria-hidden="true">3</span>
        <span class="p-step__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-code"></use></svg></span>
        <h3 class="p-step__title" lang="en">Prototype<span class="br"> </span>Development</h3>
        <ul class="p-step__list">
          <li>สร้างต้นแบบ</li>
          <li>ทดสอบการทำงาน</li>
          <li>ปรับปรุงและยืนยันแบบ</li>
        </ul>
      </li>

      <li class="p-step">
        <span class="p-step__badge" aria-hidden="true">4</span>
        <span class="p-step__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-clipboard"></use></svg></span>
        <h3 class="p-step__title" lang="en">Verification &amp;<span class="br"> </span>Validation</h3>
        <ul class="p-step__list">
          <li>ทดสอบตามมาตรฐาน</li>
          <li>ตรวจสอบความปลอดภัย</li>
          <li>รับรองประสิทธิภาพ</li>
        </ul>
      </li>

      <li class="p-step">
        <span class="p-step__badge" aria-hidden="true">5</span>
        <span class="p-step__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-factory"></use></svg></span>
        <h3 class="p-step__title" lang="en">Manufacturing<span class="br"> </span>(NPI)</h3>
        <ul class="p-step__list">
          <li>วางแผนการผลิต (NPI)</li>
          <li>จัดหาและควบคุมคุณภาพ</li>
          <li>เตรียมสายการผลิต</li>
        </ul>
      </li>

      <li class="p-step">
        <span class="p-step__badge" aria-hidden="true">6</span>
        <span class="p-step__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-cpu"></use></svg></span>
        <h3 class="p-step__title" lang="en">Mass<span class="br"> </span>Production</h3>
        <ul class="p-step__list">
          <li>ผลิตด้วยมาตรฐานสากล</li>
          <li>ควบคุมคุณภาพทุกขั้นตอน</li>
          <li>ตรวจสอบย้อนกลับได้</li>
        </ul>
      </li>

      <li class="p-step">
        <span class="p-step__badge" aria-hidden="true">7</span>
        <span class="p-step__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-package"></use></svg></span>
        <h3 class="p-step__title" lang="en">Delivery &amp;<span class="br"> </span>Deployment</h3>
        <ul class="p-step__list">
          <li>จัดส่งตรงเวลา</li>
          <li>สนับสนุนการติดตั้ง</li>
          <li>เอกสารและการรับรอง</li>
        </ul>
      </li>

      <li class="p-step">
        <span class="p-step__badge" aria-hidden="true">8</span>
        <span class="p-step__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-headset"></use></svg></span>
        <h3 class="p-step__title" lang="en">After-sales<span class="br"> </span>Support</h3>
        <ul class="p-step__list">
          <li>บริการหลังการขาย</li>
          <li>บำรุงรักษาและซ่อมบำรุง</li>
          <li>อัปเดตและพัฒนาต่อเนื่อง</li>
        </ul>
      </li>
    </ol>

  </div>
</section>


<!-- ==========================================================================
     Capabilities
     ========================================================================== -->
<section class="section" id="capabilities" aria-labelledby="cap-title">
  <div class="shell">

    <div class="cap__grid">

      <div class="cap__left" data-reveal>
        <h2 class="cap__title" id="cap-title" lang="en">Our Capabilities</h2>
        <div class="title-bar" aria-hidden="true"></div>

        <ul class="cap__items">
          <li class="cap-item">
            <span class="cap-item__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-beaker"></use></svg></span>
            <div class="cap-item__content">
              <b lang="en">R&amp;D and Product Innovation</b>
              <p>วิจัยและพัฒนาผลิตภัณฑ์ นวัตกรรม</p>
            </div>
          </li>

          <li class="cap-item">
            <span class="cap-item__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-ruler"></use></svg></span>
            <div class="cap-item__content">
              <b lang="en">Mechanical Design &amp; Simulation</b>
              <p>ออกแบบโครงสร้างและจำลองการทำงาน</p>
            </div>
          </li>

          <li class="cap-item">
            <span class="cap-item__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-code"></use></svg></span>
            <div class="cap-item__content">
              <b lang="en">Hardware &amp; Software Development</b>
              <p>พัฒนาฮาร์ดแวร์และซอฟต์แวร์</p>
            </div>
          </li>

          <li class="cap-item">
            <span class="cap-item__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-sliders"></use></svg></span>
            <div class="cap-item__content">
              <b lang="en">Box Build &amp; System Integration</b>
              <p>ประกอบและรวมระบบ</p>
            </div>
          </li>

          <li class="cap-item">
            <span class="cap-item__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-cpu"></use></svg></span>
            <div class="cap-item__content">
              <b lang="en">PCB Design &amp; PCBA Manufacturing</b>
              <p>ออกแบบและผลิตแผงวงจรอิเล็กทรอนิกส์</p>
            </div>
          </li>

          <li class="cap-item">
            <span class="cap-item__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-award"></use></svg></span>
            <div class="cap-item__content">
              <b lang="en">Certification &amp; Compliance</b>
              <p>มาตรฐานและการรับรองผลิตภัณฑ์</p>
            </div>
          </li>

          <li class="cap-item">
            <span class="cap-item__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-listcheck"></use></svg></span>
            <div class="cap-item__content">
              <b lang="en">Testing &amp; Quality Assurance</b>
              <p>ทดสอบและควบคุมคุณภาพ</p>
            </div>
          </li>

          <li class="cap-item">
            <span class="cap-item__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-truck"></use></svg></span>
            <div class="cap-item__content">
              <b lang="en">Supply Chain Management</b>
              <p>บริหารจัดการซัพพลายเชน</p>
            </div>
          </li>
        </ul>
      </div>

      <div class="cap__right" data-reveal style="--reveal-delay:120ms">
        <figure class="cap-banner">
          <img src="<?php echo get_template_directory_uri(); ?>/images/capabilities-image.png"
               alt="การตรวจสอบและทดสอบคุณภาพในสายการผลิตของ Syntech"
               class="cap-banner__img" width="721" height="428"
               loading="lazy" decoding="async">

          <figcaption class="cap-banner__overlay">
            <ul class="cap-certs">
              <li class="cap-cert">
                <span class="cap-cert__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-check-circle"></use></svg></span>
                <span class="cap-cert__text">
                  <b lang="en">ISO 9001</b>
                  <span lang="en">Quality Management</span>
                </span>
              </li>

              <li class="cap-cert">
                <span class="cap-cert__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-car"></use></svg></span>
                <span class="cap-cert__text">
                  <b lang="en">IATF 16949</b>
                  <span lang="en">Automotive Quality</span>
                </span>
              </li>

              <li class="cap-cert">
                <span class="cap-cert__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-cpu"></use></svg></span>
                <span class="cap-cert__text">
                  <b lang="en">IPC-A-610</b>
                  <span lang="en">Acceptability of Electronic Assemblies</span>
                </span>
              </li>

              <li class="cap-cert">
                <span class="cap-cert__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-leaf"></use></svg></span>
                <span class="cap-cert__text">
                  <b lang="en">RoHS / REACH</b>
                  <span lang="en">Compliance</span>
                </span>
              </li>
            </ul>
          </figcaption>
        </figure>
      </div>

    </div>

  </div>
</section>


<!-- ==========================================================================
     CTA
     ========================================================================== -->
<section class="cta" id="contact" aria-labelledby="cta-title">
  <div class="shell">
    <div class="cta__box">
      <div class="cta__grid">

        <div class="cta__left">
          <h2 class="cta__title" id="cta-title" lang="en" data-reveal>
            Let's Build Your Next<span class="br"> </span>
            <span class="cta__title-row"><span class="cta__accent">Successful Product</span> Together</span>
          </h2>
          <p class="cta__sub" data-reveal style="--reveal-delay:80ms">
            ให้เราเป็นพาร์ทเนอร์ในการพัฒนาผลิตภัณฑ์ของคุณ<span class="br"> </span>
            ตั้งแต่แนวคิดจนพร้อมออกสู่ตลาด
          </p>
          <div class="cta__actions" data-reveal style="--reveal-delay:160ms">
            <a href="<?php echo home_url('/'); ?>#contact" class="btn btn--gold">
              <svg class="i" aria-hidden="true" focusable="false"><use href="#ic-chat"></use></svg>
              <span lang="en">Talk to Our Experts</span>
            </a>
          </div>
        </div>

        <div class="cta__right">
          <ul class="cta__features">
            <li class="cta-feat" data-reveal>
              <span class="cta-feat__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-users"></use></svg></span>
              <div class="cta-feat__content">
                <b lang="en">Expert Team</b>
                <p>ทีมวิศวกรและผู้เชี่ยวชาญ พร้อมดูแลคุณ</p>
              </div>
            </li>
            <li class="cta-feat" data-reveal style="--reveal-delay:80ms">
              <span class="cta-feat__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-target"></use></svg></span>
              <div class="cta-feat__content">
                <b lang="en">Tailored Solutions</b>
                <p>ออกแบบโซลูชันที่เหมาะสม กับความต้องการของคุณ</p>
              </div>
            </li>
            <li class="cta-feat" data-reveal style="--reveal-delay:160ms">
              <span class="cta-feat__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-clock"></use></svg></span>
              <div class="cta-feat__content">
                <b lang="en">On-time Delivery</b>
                <p>ส่งมอบตรงเวลา ตามเป้าหมาย</p>
              </div>
            </li>
            <li class="cta-feat" data-reveal style="--reveal-delay:240ms">
              <span class="cta-feat__icon"><svg class="i" aria-hidden="true" focusable="false"><use href="#ic-shield"></use></svg></span>
              <div class="cta-feat__content">
                <b lang="en">Trusted Partner</b>
                <p>พาร์ทเนอร์ธุรกิจ ที่ไว้วางใจ</p>
              </div>
            </li>
          </ul>
        </div>

      </div>
    </div>
  </div>
</section>

</main>

<button class="to-top" type="button" id="toTop" aria-label="กลับไปด้านบนของหน้า">
  <svg class="i" aria-hidden="true" focusable="false"><use href="#ic-arrow-up"></use></svg>
</button>

<!-- FOOTER CONTAINER -->
<div id="footer-container" class="bg-ink w-full block"></div>

<!-- Scripts -->
<script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/scripts.js') : './components/scripts.js'; ?>"></script>
<script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/wise-bohr-script.js') : './components/wise-bohr-script.js'; ?>" defer></script>
<script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/live-editor.js') : './components/live-editor.js'; ?>"></script>

<?php wp_footer(); ?>
</body>
</html>
