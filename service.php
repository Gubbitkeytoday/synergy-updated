<?php
/* Template Name: Services Page */
if (isset($_SERVER['REQUEST_URI']) && preg_match('/\.php\/+$/i', $_SERVER['REQUEST_URI'])) {
    $clean_uri = preg_replace('/\.php\/+$/i', '.php', $_SERVER['REQUEST_URI']);
    header("Location: " . $clean_uri, true, 301);
    exit();
}
if (!function_exists('get_template_directory_uri')) {
    // Return direct path on local server to load assets
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
<meta name="theme-color" content="#1F6B43">
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

<!-- Global Theme Stylesheet -->
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
    p, span, a {
      overflow-wrap: break-word;
    }
    
    /* Animation helper for the scroll-reveal */
    .js-reveal [data-reveal] {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.6s cubic-bezier(0.22, 1, 0.36, 1), transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .js-reveal [data-reveal].is-revealed {
      opacity: 1;
      transform: translateY(0);
    }
    
    [style*="--reveal-delay:60ms"] { transition-delay: 60ms; }
    [style*="--reveal-delay:120ms"] { transition-delay: 120ms; }
    [style*="--reveal-delay:180ms"] { transition-delay: 180ms; }
    [style*="--reveal-delay:240ms"] { transition-delay: 240ms; }

    /* Fluid heading scale to match about.php exactly */
    #services-hero h1 {
      font-size: clamp(32px, 5.2vw, 56px) !important;
      line-height: 1.12 !important;
    }
</style>

<script>
    window.wpThemeUrl = "<?php echo get_template_directory_uri(); ?>/";
    window.wpThemeUri = "<?php echo get_template_directory_uri(); ?>/";
</script>
<?php wp_head(); ?>
</head>
<body <?php body_class("bg-white text-body antialiased"); ?>>

<a class="skip-link fixed top-3 left-3 z-[99999] bg-brand text-white px-5 py-2.5 rounded-full font-bold text-sm -translate-y-24 focus:translate-y-0 transition duration-200" href="#main">ข้ามไปยังเนื้อหาหลัก</a>

<!-- NAVBAR CONTAINER -->
<div id="navbar-container"></div>

<main id="main" class="overflow-x-hidden pt-20">

<!-- ==========================================================================
     HERO SECTION (Exact two-column split layout, matching design image perfectly)
     ========================================================================== -->
<section id="services-hero" class="relative py-14 sm:py-20 lg:py-24 text-slate-900 bg-white">
  <!-- Dot Grid Overlay Effect for depth -->
  <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#1F6B43_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none z-0"></div>

  <div class="max-w-7xl mx-auto px-6 relative z-10 w-full">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
      
      <!-- Left side details (7 columns) -->
      <div class="space-y-6 lg:col-span-7">
        <!-- Eyebrow Pill -->
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#f0f9f5] text-brand text-xs font-bold border border-[#d7efe6] uppercase" data-reveal>
          <span class="w-1.5 h-1.5 rounded-full bg-brand-bright animate-pulse"></span>
          Our Service
        </span>

        <!-- Title -->
        <h1 class="font-display font-extrabold text-brand tracking-tight" data-reveal style="--reveal-delay:60ms">
          End-to-End<br>Product Development
        </h1>

        <!-- Subtitle (Thai lede) -->
        <p class="text-base sm:text-xl font-bold text-brand leading-relaxed" data-reveal style="--reveal-delay:120ms">
          พัฒนาผลิตภัณฑ์ครบวงจร ตั้งแต่แนวคิดจนพร้อมออกสู่ตลาด
        </p>

        <!-- Description (English copy) -->
        <p class="text-slate-500 text-sm sm:text-base leading-relaxed max-w-xl font-normal" data-reveal style="--reveal-delay:180ms">
          We are your trusted engineering partner. From product design and prototyping to manufacturing and after-sales support, we deliver innovative, reliable, and market-ready solutions.
        </p>

        <!-- Props Row -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 pt-4" data-reveal style="--reveal-delay:240ms">
          <div class="flex flex-col items-start text-left space-y-1.5">
            <span class="text-brand text-2xl">
              <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path stroke-linecap="round" stroke-linejoin="round" d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </span>
            <b class="text-brand-deep text-xs sm:text-sm font-extrabold">One Partner</b>
            <p class="text-[10px] text-slate-500 leading-tight">ดูแลครบทุกขั้นตอน ในที่เดียว</p>
          </div>
          <div class="flex flex-col items-start text-left space-y-1.5">
            <span class="text-brand text-2xl">
              <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path></svg>
            </span>
            <b class="text-brand-deep text-xs sm:text-sm font-extrabold">Faster to Market</b>
            <p class="text-[10px] text-slate-500 leading-tight">ลดเวลาในการพัฒนา และเปิดตัวสินค้า</p>
          </div>
          <div class="flex flex-col items-start text-left space-y-1.5">
            <span class="text-brand text-2xl">
              <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><circle cx="12" cy="12" r="5"></circle><circle cx="12" cy="12" r="1.2"></circle></svg>
            </span>
            <b class="text-brand-deep text-xs sm:text-sm font-extrabold">Quality &amp; Compliance</b>
            <p class="text-[10px] text-slate-500 leading-tight">มาตรฐานสากล เชื่อถือได้</p>
          </div>
          <div class="flex flex-col items-start text-left space-y-1.5">
            <span class="text-brand text-2xl">
              <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M22 7l-8.5 8.5-5-5L2 17M16 7h6v6"></path></svg>
            </span>
            <b class="text-brand-deep text-xs sm:text-sm font-extrabold">Business Impact</b>
            <p class="text-[10px] text-slate-500 leading-tight">สร้างคุณค่าและความได้เปรียบ ในการแข่งขัน</p>
          </div>
        </div>
      </div>

      <!-- Right side media (5 columns) -->
      <div class="flex justify-center items-center w-full lg:col-span-5" data-reveal style="--reveal-delay:120ms">
        <img src="<?php echo get_template_directory_uri(); ?>/Home.png" alt="ภาพรวมบริการพัฒนาผลิตภัณฑ์ครบวงจรของ Syntech"
             class="w-full h-auto max-h-[500px] object-contain">
      </div>

    </div>
  </div>
</section>

<!-- ==========================================================================
     WHY CHOOSE SECTION (No outer card wrappers, clean fluid grid)
     ========================================================================== -->
<section id="why-us" class="py-16 bg-[#f8faf9] border-b border-slate-100 overflow-hidden">
  <div class="max-w-7xl mx-auto px-6 relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_2.5fr] gap-8 items-center" data-reveal>
      
      <div class="lg:pr-8 lg:border-r lg:border-[#004d3a]/10">
        <h2 class="font-display font-extrabold text-brand text-2xl lg:text-3xl leading-tight">
          Why Choose Syntech for Your Product Development?
        </h2>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-5 gap-6">
        <div class="flex flex-col items-center text-center space-y-2">
          <span class="w-12 h-12 flex items-center justify-center text-brand text-3xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path stroke-linecap="round" stroke-linejoin="round" d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
          </span>
          <b class="text-brand text-xs sm:text-sm font-extrabold">Engineering Excellence</b>
          <p class="text-[10px] text-slate-500 leading-tight">ทีมวิศวกรผู้เชี่ยวชาญ และมีประสบการณ์</p>
        </div>
        <div class="flex flex-col items-center text-center space-y-2">
          <span class="w-12 h-12 flex items-center justify-center text-brand text-3xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10l9-5 9 5-9 5-9-5z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M3 14l9 5 9-5"></path><path stroke-linecap="round" stroke-linejoin="round" d="M3 18l9 5 9-5"></path></svg>
          </span>
          <b class="text-brand text-xs sm:text-sm font-extrabold">End-to-End Solutions</b>
          <p class="text-[10px] text-slate-500 leading-tight">ครบทุกขั้นตอนตั้งแต่ ออกแบบจนส่งมอบ</p>
        </div>
        <div class="flex flex-col items-center text-center space-y-2">
          <span class="w-12 h-12 flex items-center justify-center text-brand text-3xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2" stroke-linecap="round" stroke-linejoin="round"></rect><path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8M12 17v4"></path></svg>
          </span>
          <b class="text-brand text-xs sm:text-sm font-extrabold">Scalable Production</b>
          <p class="text-[10px] text-slate-500 leading-tight">รองรับการผลิตตั้งแต่ ต้นแบบถึงจำนวนมาก</p>
        </div>
        <div class="flex flex-col items-center text-center space-y-2">
          <span class="w-12 h-12 flex items-center justify-center text-brand text-3xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h8m-4-8a15.3 15.3 0 0 1 4 8 15.3 15.3 0 0 1-4 8 15.3 15.3 0 0 1-4-8 15.3 15.3 0 0 1 4-8z"></path></svg>
          </span>
          <b class="text-brand text-xs sm:text-sm font-extrabold">Global Standards</b>
          <p class="text-[10px] text-slate-500 leading-tight">มาตรฐานการผลิตและ คุณภาพระดับสากล</p>
        </div>
        <div class="flex flex-col items-center text-center space-y-2">
          <span class="w-12 h-12 flex items-center justify-center text-brand text-3xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="8.5" cy="12" r="5"></circle><circle cx="15.5" cy="12" r="5"></circle></svg>
          </span>
          <b class="text-brand text-xs sm:text-sm font-extrabold">Long-term Partnership</b>
          <p class="text-[10px] text-slate-500 leading-tight">เป็นพาร์ทเนอร์ระยะยาว ที่ธุรกิจไว้วางใจ</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ==========================================================================
     Process Section
     ========================================================================== -->
<section id="process" class="py-16 bg-white relative">
  <div class="max-w-7xl mx-auto px-6 relative">
    
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="font-display font-extrabold text-brand text-3xl tracking-tight" data-reveal>
        Our End-to-End Process
      </h2>
      <div class="w-12 h-0.5 bg-brand mx-auto mt-4" data-reveal style="--reveal-delay:60ms"></div>
    </div>

    <!-- Dashed Rail (Large screens) -->
    <div class="hidden lg:block absolute top-[182px] left-[6%] right-[6%] border-t-2 border-dashed border-[#b5d8cc] z-0"></div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 relative z-10" data-reveal style="--reveal-delay:120ms">
      
      <!-- Step 1 -->
      <div class="flex flex-col items-center text-center">
        <span class="w-6 h-6 rounded-full bg-brand text-white flex items-center justify-center font-bold text-xs mb-2">1</span>
        <span class="w-12 h-12 rounded-full bg-[#e6f3ee] border border-[#d0e7de] text-brand flex items-center justify-center text-xl mb-3">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 1 1 7.072 0l-.548.547A3.374 3.374 0 0 0 14 18.469V19a2 2 0 1 1-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
        </span>
        <h3 class="font-extrabold text-brand text-xs leading-tight min-h-[36px] flex items-center justify-center">Concept &amp;<br>Requirement</h3>
        <ul class="text-[10px] text-slate-500 text-left space-y-1 mt-2 list-disc pl-3">
          <li>วิเคราะห์ความต้องการ</li>
          <li>ศึกษาความเป็นไปได้</li>
          <li>วางแผนโครงการ</li>
        </ul>
      </div>

      <!-- Step 2 -->
      <div class="flex flex-col items-center text-center">
        <span class="w-6 h-6 rounded-full bg-brand text-white flex items-center justify-center font-bold text-xs mb-2">2</span>
        <span class="w-12 h-12 rounded-full bg-[#e6f3ee] border border-[#d0e7de] text-brand flex items-center justify-center text-xl mb-3">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 1 1 3.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
        </span>
        <h3 class="font-extrabold text-brand text-xs leading-tight min-h-[36px] flex items-center justify-center">Product Design<br>&amp; Engineering</h3>
        <ul class="text-[10px] text-slate-500 text-left space-y-1 mt-2 list-disc pl-3">
          <li>ออกแบบฮาร์ดแวร์/ซอฟต์แวร์</li>
          <li>PCB &amp; Mechanical Design</li>
          <li>Simulation &amp; Review</li>
        </ul>
      </div>

      <!-- Step 3 -->
      <div class="flex flex-col items-center text-center">
        <span class="w-6 h-6 rounded-full bg-brand text-white flex items-center justify-center font-bold text-xs mb-2">3</span>
        <span class="w-12 h-12 rounded-full bg-[#e6f3ee] border border-[#d0e7de] text-brand flex items-center justify-center text-xl mb-3">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
        </span>
        <h3 class="font-extrabold text-brand text-xs leading-tight min-h-[36px] flex items-center justify-center">Prototype<br>Development</h3>
        <ul class="text-[10px] text-slate-500 text-left space-y-1 mt-2 list-disc pl-3">
          <li>สร้างต้นแบบ</li>
          <li>ทดสอบการทำงาน</li>
          <li>ปรับปรุงและยืนยันแบบ</li>
        </ul>
      </div>

      <!-- Step 4 -->
      <div class="flex flex-col items-center text-center">
        <span class="w-6 h-6 rounded-full bg-brand text-white flex items-center justify-center font-bold text-xs mb-2">4</span>
        <span class="w-12 h-12 rounded-full bg-[#e6f3ee] border border-[#d0e7de] text-brand flex items-center justify-center text-xl mb-3">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path></svg>
        </span>
        <h3 class="font-extrabold text-brand text-xs leading-tight min-h-[36px] flex items-center justify-center">Verification &amp;<br>Validation</h3>
        <ul class="text-[10px] text-slate-500 text-left space-y-1 mt-2 list-disc pl-3">
          <li>ทดสอบตามมาตรฐาน</li>
          <li>ตรวจสอบความปลอดภัย</li>
          <li>รับรองประสิทธิภาพ</li>
        </ul>
      </div>

      <!-- Step 5 -->
      <div class="flex flex-col items-center text-center">
        <span class="w-6 h-6 rounded-full bg-brand text-white flex items-center justify-center font-bold text-xs mb-2">5</span>
        <span class="w-12 h-12 rounded-full bg-[#e6f3ee] border border-[#d0e7de] text-brand flex items-center justify-center text-xl mb-3">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2 20h20M4 20V10l5 3V10l5 3V7l6 4v9M8 20v-4h3v4"></path></svg>
        </span>
        <h3 class="font-extrabold text-brand text-xs leading-tight min-h-[36px] flex items-center justify-center">Manufacturing<br>(NPI)</h3>
        <ul class="text-[10px] text-slate-500 text-left space-y-1 mt-2 list-disc pl-3">
          <li>วางแผนการผลิต (NPI)</li>
          <li>จัดหาและควบคุมคุณภาพ</li>
          <li>เตรียมสายการผลิต</li>
        </ul>
      </div>

      <!-- Step 6 -->
      <div class="flex flex-col items-center text-center">
        <span class="w-6 h-6 rounded-full bg-brand text-white flex items-center justify-center font-bold text-xs mb-2">6</span>
        <span class="w-12 h-12 rounded-full bg-[#e6f3ee] border border-[#d0e7de] text-brand flex items-center justify-center text-xl mb-3">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="5" width="14" height="14" rx="2" stroke-linecap="round" stroke-linejoin="round"></rect><path stroke-linecap="round" stroke-linejoin="round" d="M9 1v4M15 1v4M9 19v4M15 19v4M1 9h4M1 15h4M19 9h4M19 15h4M9 9h6v6H9z"></path></svg>
        </span>
        <h3 class="font-extrabold text-brand text-xs leading-tight min-h-[36px] flex items-center justify-center">Mass<br>Production</h3>
        <ul class="text-[10px] text-slate-500 text-left space-y-1 mt-2 list-disc pl-3">
          <li>ผลิตด้วยมาตรฐานสากล</li>
          <li>ควบคุมคุณภาพทุกขั้นตอน</li>
          <li>ตรวจสอบย้อนกลับได้</li>
        </ul>
      </div>

      <!-- Step 7 -->
      <div class="flex flex-col items-center text-center">
        <span class="w-6 h-6 rounded-full bg-brand text-white flex items-center justify-center font-bold text-xs mb-2">7</span>
        <span class="w-12 h-12 rounded-full bg-[#e6f3ee] border border-[#d0e7de] text-brand flex items-center justify-center text-xl mb-3">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14v4m0 0L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </span>
        <h3 class="font-extrabold text-brand text-xs leading-tight min-h-[36px] flex items-center justify-center">Delivery &amp;<br>Deployment</h3>
        <ul class="text-[10px] text-slate-500 text-left space-y-1 mt-2 list-disc pl-3">
          <li>จัดส่งตรงเวลา</li>
          <li>สนับสนุนการติดตั้ง</li>
          <li>เอกสารและการรับรอง</li>
        </ul>
      </div>

      <!-- Step 8 -->
      <div class="flex flex-col items-center text-center">
        <span class="w-6 h-6 rounded-full bg-brand text-white flex items-center justify-center font-bold text-xs mb-2">8</span>
        <span class="w-12 h-12 rounded-full bg-[#e6f3ee] border border-[#d0e7de] text-brand flex items-center justify-center text-xl mb-3">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 0 0 2-2V9a6 6 0 1 0-12 0v10a2 2 0 0 0 2 2z"></path></svg>
        </span>
        <h3 class="font-extrabold text-brand text-xs leading-tight min-h-[36px] flex items-center justify-center">After-sales<br>Support</h3>
        <ul class="text-[10px] text-slate-500 text-left space-y-1 mt-2 list-disc pl-3">
          <li>บริการหลังการขาย</li>
          <li>บำรุงรักษาและซ่อมบำรุง</li>
          <li>อัปเดตและพัฒนาต่อเนื่อง</li>
        </ul>
      </div>

    </div>
  </div>
</section>

<!-- ==========================================================================
     CAPABILITIES SECTION (No outer cards, unified style)
     ========================================================================== -->
<section id="capabilities" class="py-16 bg-[#f8faf9] border-t border-b border-slate-100">
  <div class="max-w-7xl mx-auto px-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-stretch">
      
      <div class="flex flex-col justify-center" data-reveal>
        <h2 class="font-display font-extrabold text-brand text-3xl">Our Capabilities</h2>
        <div class="w-12 h-0.5 bg-brand mt-3 mb-8"></div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div class="flex items-start gap-3">
            <span class="text-brand text-2xl mt-1">
              <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 0 0-1.022-.547l-2.387-.477a6 6 0 0 0-3.86.517l-.318.158a6 6 0 0 1-3.86.517L6.05 15.23a2 2 0 0 0-1.806.547M8 4h8l-1 1v5.242a2 2 0 0 0 .586 1.414l3.828 3.828A2 2 0 0 1 18.005 20H5.995a2 2 0 0 1-1.414-3.414l3.828-3.828A2 2 0 0 0 9 11.342V5L8 4z"></path></svg>
            </span>
            <div>
              <b class="text-brand text-sm sm:text-base font-extrabold">R&amp;D and Product Innovation</b>
              <p class="text-xs text-slate-500 mt-1">วิจัยและพัฒนาผลิตภัณฑ์ นวัตกรรม</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <span class="text-brand text-2xl mt-1">
              <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 1 1 3.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </span>
            <div>
              <b class="text-brand text-sm sm:text-base font-extrabold">Mechanical Design &amp; Simulation</b>
              <p class="text-xs text-slate-500 mt-1">ออกแบบโครงสร้างและจำลองการทำงาน</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <span class="text-brand text-2xl mt-1">
              <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
            </span>
            <div>
              <b class="text-brand text-sm sm:text-base font-extrabold">Hardware &amp; Software Development</b>
              <p class="text-xs text-slate-500 mt-1">พัฒนาฮาร์ดแวร์และซอฟต์แวร์</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <span class="text-brand text-2xl mt-1">
              <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 2v10m-6-6v-6m0 6a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 2v4m12-4v-10m0 10a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 2v4"></path></svg>
            </span>
            <div>
              <b class="text-brand text-sm sm:text-base font-extrabold">Box Build &amp; System Integration</b>
              <p class="text-xs text-slate-500 mt-1">ประกอบและรวมระบบ</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <span class="text-brand text-2xl mt-1">
              <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="5" width="14" height="14" rx="2" stroke-linecap="round" stroke-linejoin="round"></rect><path stroke-linecap="round" stroke-linejoin="round" d="M9 1v4M15 1v4M9 19v4M15 19v4M1 9h4M1 15h4M19 9h4M19 15h4M9 9h6v6H9z"></path></svg>
            </span>
            <div>
              <b class="text-brand text-sm sm:text-base font-extrabold">PCB Design &amp; PCBA Manufacturing</b>
              <p class="text-xs text-slate-500 mt-1">ออกแบบและผลิตแผงวงจรอิเล็กทรอนิกส์</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <span class="text-brand text-2xl mt-1">
              <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2m-6 9l2 2 4-4"></path></svg>
            </span>
            <div>
              <b class="text-brand text-sm sm:text-base font-extrabold">Certification &amp; Compliance</b>
              <p class="text-xs text-slate-500 mt-1">มาตรฐานและการรับรองผลิตภัณฑ์</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <span class="text-brand text-2xl mt-1">
              <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </span>
            <div>
              <b class="text-brand text-sm sm:text-base font-extrabold">Testing &amp; Quality Assurance</b>
              <p class="text-xs text-slate-500 mt-1">ทดสอบและควบคุมคุณภาพ</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <span class="text-brand text-2xl mt-1">
              <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM19 17a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v10M13 16h6m-6 0H9m10 0v-4a1 1 0 0 0-1-1h-3M19 16a2 2 0 0 0 2-2V8a1 1 0 0 0-1-1h-2v9"></path></svg>
            </span>
            <div>
              <b class="text-brand text-sm sm:text-base font-extrabold">Supply Chain Management</b>
              <p class="text-xs text-slate-500 mt-1">บริหารจัดการซัพพลายเชน</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Right image + cert overlays -->
      <div class="relative overflow-hidden rounded-3xl shadow-xl min-h-[380px]" data-reveal style="--reveal-delay:120ms">
        <img src="<?php echo get_template_directory_uri(); ?>/images/capabilities-image.png"
             alt="การตรวจสอบและทดสอบคุณภาพในสายการผลิตของ Syntech"
             class="absolute inset-0 w-full h-full object-cover">
        
        <!-- Overlay panel -->
        <div class="absolute inset-0 p-8 flex items-center bg-gradient-to-t lg:bg-gradient-to-r from-transparent via-[#0d3026]/90 to-[#09261e]/98 text-white lg:justify-end">
          <div class="space-y-6 w-full lg:max-w-[50%]">
            <div class="flex items-center gap-3">
              <span class="w-10 h-10 rounded-full border border-white/20 bg-white/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path></svg>
              </span>
              <div>
                <b class="block text-sm font-extrabold">ISO 9001</b>
                <span class="text-[10px] text-white/70">Quality Management</span>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <span class="w-10 h-10 rounded-full border border-white/20 bg-white/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l1.6-4.5A2 2 0 0 1 8.5 7h7a2 2 0 0 1 1.9 1.5L19 13M4 13h16a1 1 0 0 1 1 1v3H3v-3a1 1 0 0 1 1-1z"></path><circle cx="7" cy="17.5" r="1.5"></circle><circle cx="17" cy="17.5" r="1.5"></circle></svg>
              </span>
              <div>
                <b class="block text-sm font-extrabold">IATF 16949</b>
                <span class="text-[10px] text-white/70">Automotive Quality</span>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <span class="w-10 h-10 rounded-full border border-white/20 bg-white/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="5" width="14" height="14" rx="2" stroke-linecap="round" stroke-linejoin="round"></rect><path stroke-linecap="round" stroke-linejoin="round" d="M9 1v4M15 1v4M9 19v4M15 19v4M1 9h4M1 15h4M19 9h4M19 15h4M9 9h6v6H9z"></path></svg>
              </span>
              <div>
                <b class="block text-sm font-extrabold">IPC-A-610</b>
                <span class="text-[10px] text-white/70">Acceptability of Electronic Assemblies</span>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <span class="w-10 h-10 rounded-full border border-white/20 bg-white/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 20.5A7.5 7.5 0 0 1 3.5 13C3.5 7 10.5 3.5 20.5 3.5c0 10-3.5 17-9.5 17z"></path></svg>
              </span>
              <div>
                <b class="block text-sm font-extrabold">RoHS / REACH</b>
                <span class="text-[10px] text-white/70">Compliance</span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ==========================================================================
     CTA Section
     ========================================================================== -->
<section id="contact" class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-6">
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#093427] via-[#0d4636] to-[#06261c] p-8 lg:p-12 text-white shadow-2xl" data-reveal>
      <!-- Circuit Grid Texture Overlay -->
      <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none z-0"></div>

      <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        <div class="lg:col-span-7">
          <h2 class="font-display font-extrabold text-2xl lg:text-4xl leading-tight">
            Let's Build Your Next<br>
            <span class="text-gold-bright font-extrabold">Successful Product</span> Together
          </h2>
          <p class="text-sm lg:text-base text-slate-200 mt-4 max-w-lg leading-relaxed">
            ให้เราเป็นพาร์ทเนอร์ในการพัฒนาผลิตภัณฑ์ของคุณ ตั้งแต่แนวคิดจนพร้อมออกสู่ตลาด
          </p>
          <a href="<?php echo home_url('/'); ?>#contact" class="bg-gold-bright hover:bg-[#C99700] active:scale-95 text-slate-900 font-extrabold text-sm uppercase px-8 py-3.5 rounded-xl shadow-lg shadow-gold-bright/20 inline-flex items-center gap-2 mt-8 transition duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            Talk to Our Experts
          </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 lg:col-span-5">
          <div class="flex gap-3">
            <span class="text-gold-bright text-xl mt-1">
              <svg class="w-6 h-6 text-gold-bright" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path stroke-linecap="round" stroke-linejoin="round" d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </span>
            <div>
              <b class="block text-sm font-extrabold">Expert Team</b>
              <p class="text-xs text-slate-300 mt-1">ทีมวิศวกรผู้เชี่ยวชาญพร้อมเคียงข้างคุณ</p>
            </div>
          </div>
          <div class="flex gap-3">
            <span class="text-gold-bright text-xl mt-1">
              <svg class="w-6 h-6 text-gold-bright" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 2v10m-6-6v-6m0 6a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 2v4m12-4v-10m0 10a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 2v4"></path></svg>
            </span>
            <div>
              <b class="block text-sm font-extrabold">Tailored Solutions</b>
              <p class="text-xs text-slate-300 mt-1">ออกแบบโซลูชันตรงเป้าหมายของคุณ</p>
            </div>
          </div>
          <div class="flex gap-3">
            <span class="text-gold-bright text-xl mt-1">
              <svg class="w-6 h-6 text-gold-bright" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path></svg>
            </span>
            <div>
              <b class="block text-sm font-extrabold">On-time Delivery</b>
              <p class="text-xs text-slate-300 mt-1">ผลิตและส่งมอบตรงเวลาตามกำหนด</p>
            </div>
          </div>
          <div class="flex gap-3">
            <span class="text-gold-bright text-xl mt-1">
              <svg class="w-6 h-6 text-gold-bright" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </span>
            <div>
              <b class="block text-sm font-extrabold">Trusted Partner</b>
              <p class="text-xs text-slate-300 mt-1">ธุรกิจไว้วางใจได้ยาวนาน</p>
            </div>
          </div>
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
    /* Injected native script directly to handle scroll-reveal so no extra file is needed */
    (() => {
      'use strict';
      const $ = (sel) => document.querySelector(sel);
      const $$ = (sel) => Array.from(document.querySelectorAll(sel));
      
      // Scroll Reveal
      const revealables = $$('[data-reveal]');
      if (revealables.length) {
        const observer = new IntersectionObserver((entries, obs) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add('is-revealed');
              obs.unobserve(entry.target);
            }
          });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        
        revealables.forEach(el => observer.observe(el));
      }
    })();
</script>

<?php wp_footer(); ?>
</body>
</html>
