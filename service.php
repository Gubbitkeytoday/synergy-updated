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
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Sarabun:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700;800&family=IBM+Plex+Sans+Thai:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    
    /* Reveal Delays */
    [style*="--reveal-delay:60ms"] { transition-delay: 60ms !important; }
    [style*="--reveal-delay:120ms"] { transition-delay: 120ms !important; }
    [style*="--reveal-delay:180ms"] { transition-delay: 180ms !important; }
    [style*="--reveal-delay:240ms"] { transition-delay: 240ms !important; }
    
    /* Lock scroll when modal open */
    body.is-locked {
      overflow: hidden;
    }
    
    /* Modal show/hide states */
    .modal.is-open {
      opacity: 1 !important;
      pointer-events: auto !important;
    }
    .modal.is-open .modal__panel {
      transform: translateY(0) !important;
    }
    
    /* To-top button show/hide states */
    .to-top.is-shown {
      opacity: 1 !important;
      transform: translateY(0) !important;
      pointer-events: auto !important;
    }
    
    /* Field error highlighting */
    .field.has-error input,
    .field.has-error textarea,
    .field.has-error select {
      border-color: #ef4444 !important;
      background-color: #fef2f2 !important;
    }
    .field.has-error .error {
      display: block !important;
      color: #ef4444;
      font-size: 11px;
      margin-top: 4px;
    }
    .field .error {
      display: none;
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

<main id="main" class="overflow-x-hidden">

<!-- ==========================================================================
     Hero Section
     ========================================================================== -->
<section id="services" class="relative pt-28 pb-12 sm:pt-32 sm:pb-16 lg:pt-40 lg:pb-24 text-slate-900 bg-white">
  <div class="max-w-7xl mx-auto px-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
      
      <div class="space-y-6">
        <!-- Eyebrow -->
        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand-light text-brand text-xs font-bold tracking-widest uppercase" data-reveal>
          <span class="w-1.5 h-1.5 rounded-full bg-brand-bright animate-pulse"></span>
          Our Service
        </span>

        <h1 class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl tracking-tight leading-none text-brand" data-reveal style="--reveal-delay:60ms">
          End-to-End<br>Product Development
        </h1>

        <p class="text-base sm:text-lg font-bold text-brand-bright leading-relaxed" data-reveal style="--reveal-delay:120ms">
          พัฒนาผลิตภัณฑ์ครบวงจร ตั้งแต่แนวคิดจนพร้อมออกสู่ตลาด
        </p>

        <p class="text-slate-600 text-sm sm:text-base leading-relaxed max-w-xl" data-reveal style="--reveal-delay:180ms">
          We are your trusted engineering partner. From product design and prototyping to manufacturing and after-sales support, we deliver innovative, reliable, and market-ready solutions.
        </p>

        <!-- Props -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4" data-reveal style="--reveal-delay:240ms">
          <div class="flex flex-col items-center text-center p-3 bg-slate-50 rounded-xl border border-slate-100/80 shadow-sm">
            <span class="text-brand text-2xl mb-1.5"><i class="fa-solid fa-users"></i></span>
            <b class="text-brand text-xs sm:text-sm font-extrabold">One Partner</b>
            <p class="text-[10px] text-slate-500 mt-1 leading-tight">ดูแลครบทุกขั้นตอน ในที่เดียว</p>
          </div>
          <div class="flex flex-col items-center text-center p-3 bg-slate-50 rounded-xl border border-slate-100/80 shadow-sm">
            <span class="text-brand text-2xl mb-1.5"><i class="fa-solid fa-circle-check"></i></span>
            <b class="text-brand text-xs sm:text-sm font-extrabold">Faster to Market</b>
            <p class="text-[10px] text-slate-500 mt-1 leading-tight">ลดเวลาในการพัฒนา และเปิดตัวสินค้า</p>
          </div>
          <div class="flex flex-col items-center text-center p-3 bg-slate-50 rounded-xl border border-slate-100/80 shadow-sm">
            <span class="text-brand text-2xl mb-1.5"><i class="fa-solid fa-bullseye"></i></span>
            <b class="text-brand text-xs sm:text-sm font-extrabold">Quality</b>
            <p class="text-[10px] text-slate-500 mt-1 leading-tight">มาตรฐานสากล เชื่อถือได้</p>
          </div>
          <div class="flex flex-col items-center text-center p-3 bg-slate-50 rounded-xl border border-slate-100/80 shadow-sm">
            <span class="text-brand text-2xl mb-1.5"><i class="fa-solid fa-chart-line"></i></span>
            <b class="text-brand text-xs sm:text-sm font-extrabold">Impact</b>
            <p class="text-[10px] text-slate-500 mt-1 leading-tight">สร้างความได้เปรียบ ในการแข่งขัน</p>
          </div>
        </div>
      </div>

      <div class="flex justify-center items-center w-full" data-reveal style="--reveal-delay:120ms">
        <img src="<?php echo get_template_directory_uri(); ?>/Home.png" alt="ภาพรวมบริการพัฒนาผลิตภัณฑ์ครบวงจรของ Syntech"
             class="w-full h-auto max-h-[500px] object-contain rounded-2xl shadow-xl border border-slate-100/50">
      </div>

    </div>
  </div>
</section>

<!-- ==========================================================================
     Why Choose Section
     ========================================================================== -->
<section id="why-us" class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-6">
    <div class="bg-[#f4f8f6] border border-[#e1eee9] rounded-3xl p-8 lg:p-12 grid grid-cols-1 lg:grid-cols-[1.2fr_2.5fr] gap-8 items-center" data-reveal>
      
      <div class="lg:pr-8 lg:border-r lg:border-[#004d3a]/10">
        <h2 class="font-display font-extrabold text-brand text-2xl lg:text-3xl leading-tight">
          Why Choose Syntech for Your Product Development?
        </h2>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-5 gap-6">
        <div class="flex flex-col items-center text-center space-y-2">
          <span class="text-brand text-3xl"><i class="fa-solid fa-graduation-cap"></i></span>
          <b class="text-brand text-xs sm:text-sm font-extrabold">Engineering Excellence</b>
          <p class="text-[10px] text-slate-500 leading-tight">ทีมวิศวกรผู้เชี่ยวชาญ และมีประสบการณ์</p>
        </div>
        <div class="flex flex-col items-center text-center space-y-2">
          <span class="text-brand text-3xl"><i class="fa-solid fa-layer-group"></i></span>
          <b class="text-brand text-xs sm:text-sm font-extrabold">End-to-End Solutions</b>
          <p class="text-[10px] text-slate-500 leading-tight">ครบทุกขั้นตอนตั้งแต่ ออกแบบจนส่งมอบ</p>
        </div>
        <div class="flex flex-col items-center text-center space-y-2">
          <span class="text-brand text-3xl"><i class="fa-solid fa-industry"></i></span>
          <b class="text-brand text-xs sm:text-sm font-extrabold">Scalable Production</b>
          <p class="text-[10px] text-slate-500 leading-tight">รองรับการผลิตตั้งแต่ ต้นแบบถึงจำนวนมาก</p>
        </div>
        <div class="flex flex-col items-center text-center space-y-2">
          <span class="text-brand text-3xl"><i class="fa-solid fa-globe"></i></span>
          <b class="text-brand text-xs sm:text-sm font-extrabold">Global Standards</b>
          <p class="text-[10px] text-slate-500 leading-tight">มาตรฐานการผลิตและ คุณภาพระดับสากล</p>
        </div>
        <div class="flex flex-col items-center text-center space-y-2">
          <span class="text-brand text-3xl"><i class="fa-solid fa-handshake-angle"></i></span>
          <b class="text-brand text-xs sm:text-sm font-extrabold">Partnership</b>
          <p class="text-[10px] text-slate-500 leading-tight">เป็นพาร์ทเนอร์ระยะยาว ที่ธุรกิจไว้วางใจ</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ==========================================================================
     Process Section
     ========================================================================== -->
<section id="process" class="py-16 bg-[#f8faf9] relative">
  <div class="max-w-7xl mx-auto px-6 relative">
    
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="font-display font-extrabold text-brand text-3xl sm:text-4xl tracking-tight" data-reveal>
        Our End-to-End Process
      </h2>
      <div class="w-12 h-1 bg-brand mx-auto mt-4 rounded" data-reveal style="--reveal-delay:60ms"></div>
    </div>

    <!-- Dashed Rail (Large screens) -->
    <div class="hidden lg:block absolute top-[182px] left-[8%] right-[8%] border-t-2 border-dashed border-[#b5d8cc] z-0"></div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 relative z-10" data-reveal style="--reveal-delay:120ms">
      
      <!-- Step 1 -->
      <div class="flex flex-col items-center text-center bg-white p-4 rounded-2xl border border-slate-100/80 shadow-sm">
        <span class="w-6 h-6 rounded-full bg-brand text-white flex items-center justify-center font-bold text-xs mb-2">1</span>
        <span class="w-12 h-12 rounded-full bg-brand-light text-brand flex items-center justify-center text-xl mb-3"><i class="fa-regular fa-lightbulb"></i></span>
        <h3 class="font-extrabold text-brand text-xs sm:text-sm leading-tight min-h-[36px] flex items-center justify-center">Concept &amp; Req.</h3>
        <ul class="text-[10px] text-slate-500 text-left space-y-1 mt-2 list-disc pl-3">
          <li>วิเคราะห์ความต้องการ</li>
          <li>ศึกษาความเป็นไปได้</li>
          <li>วางแผนโครงการ</li>
        </ul>
      </div>

      <!-- Step 2 -->
      <div class="flex flex-col items-center text-center bg-white p-4 rounded-2xl border border-slate-100/80 shadow-sm">
        <span class="w-6 h-6 rounded-full bg-brand text-white flex items-center justify-center font-bold text-xs mb-2">2</span>
        <span class="w-12 h-12 rounded-full bg-brand-light text-brand flex items-center justify-center text-xl mb-3"><i class="fa-solid fa-ruler-combined"></i></span>
        <h3 class="font-extrabold text-brand text-xs sm:text-sm leading-tight min-h-[36px] flex items-center justify-center">Product Design</h3>
        <ul class="text-[10px] text-slate-500 text-left space-y-1 mt-2 list-disc pl-3">
          <li>ออกแบบ HW/SW</li>
          <li>PCB &amp; Mechanical</li>
          <li>Simulation</li>
        </ul>
      </div>

      <!-- Step 3 -->
      <div class="flex flex-col items-center text-center bg-white p-4 rounded-2xl border border-slate-100/80 shadow-sm">
        <span class="w-6 h-6 rounded-full bg-brand text-white flex items-center justify-center font-bold text-xs mb-2">3</span>
        <span class="w-12 h-12 rounded-full bg-brand-light text-brand flex items-center justify-center text-xl mb-3"><i class="fa-solid fa-code"></i></span>
        <h3 class="font-extrabold text-brand text-xs sm:text-sm leading-tight min-h-[36px] flex items-center justify-center">Prototype</h3>
        <ul class="text-[10px] text-slate-500 text-left space-y-1 mt-2 list-disc pl-3">
          <li>สร้างต้นแบบ</li>
          <li>ทดสอบการทำงาน</li>
          <li>ปรับปรุงแบบ</li>
        </ul>
      </div>

      <!-- Step 4 -->
      <div class="flex flex-col items-center text-center bg-white p-4 rounded-2xl border border-slate-100/80 shadow-sm">
        <span class="w-6 h-6 rounded-full bg-brand text-white flex items-center justify-center font-bold text-xs mb-2">4</span>
        <span class="w-12 h-12 rounded-full bg-brand-light text-brand flex items-center justify-center text-xl mb-3"><i class="fa-solid fa-clipboard-check"></i></span>
        <h3 class="font-extrabold text-brand text-xs sm:text-sm leading-tight min-h-[36px] flex items-center justify-center">Validation</h3>
        <ul class="text-[10px] text-slate-500 text-left space-y-1 mt-2 list-disc pl-3">
          <li>ทดสอบตามมาตรฐาน</li>
          <li>ตรวจสอบความปลอดภัย</li>
          <li>รับรองประสิทธิภาพ</li>
        </ul>
      </div>

      <!-- Step 5 -->
      <div class="flex flex-col items-center text-center bg-white p-4 rounded-2xl border border-slate-100/80 shadow-sm">
        <span class="w-6 h-6 rounded-full bg-brand text-white flex items-center justify-center font-bold text-xs mb-2">5</span>
        <span class="w-12 h-12 rounded-full bg-brand-light text-brand flex items-center justify-center text-xl mb-3"><i class="fa-solid fa-toolbox"></i></span>
        <h3 class="font-extrabold text-brand text-xs sm:text-sm leading-tight min-h-[36px] flex items-center justify-center">NPI</h3>
        <ul class="text-[10px] text-slate-500 text-left space-y-1 mt-2 list-disc pl-3">
          <li>วางแผนการผลิต (NPI)</li>
          <li>จัดหาวัตถุดิบ</li>
          <li>เตรียมสายผลิต</li>
        </ul>
      </div>

      <!-- Step 6 -->
      <div class="flex flex-col items-center text-center bg-white p-4 rounded-2xl border border-slate-100/80 shadow-sm">
        <span class="w-6 h-6 rounded-full bg-brand text-white flex items-center justify-center font-bold text-xs mb-2">6</span>
        <span class="w-12 h-12 rounded-full bg-brand-light text-brand flex items-center justify-center text-xl mb-3"><i class="fa-solid fa-microchip"></i></span>
        <h3 class="font-extrabold text-brand text-xs sm:text-sm leading-tight min-h-[36px] flex items-center justify-center">Mass Prod.</h3>
        <ul class="text-[10px] text-slate-500 text-left space-y-1 mt-2 list-disc pl-3">
          <li>ผลิตมาตรฐานสากล</li>
          <li>ควบคุมคุณภาพทุกขั้น</li>
          <li>ตรวจสอบย้อนกลับ</li>
        </ul>
      </div>

      <!-- Step 7 -->
      <div class="flex flex-col items-center text-center bg-white p-4 rounded-2xl border border-slate-100/80 shadow-sm">
        <span class="w-6 h-6 rounded-full bg-brand text-white flex items-center justify-center font-bold text-xs mb-2">7</span>
        <span class="w-12 h-12 rounded-full bg-brand-light text-brand flex items-center justify-center text-xl mb-3"><i class="fa-solid fa-truck"></i></span>
        <h3 class="font-extrabold text-brand text-xs sm:text-sm leading-tight min-h-[36px] flex items-center justify-center">Delivery</h3>
        <ul class="text-[10px] text-slate-500 text-left space-y-1 mt-2 list-disc pl-3">
          <li>จัดส่งตรงเวลา</li>
          <li>สนับสนุนการติดตั้ง</li>
          <li>เอกสารรับรองครบถ้วน</li>
        </ul>
      </div>

      <!-- Step 8 -->
      <div class="flex flex-col items-center text-center bg-white p-4 rounded-2xl border border-slate-100/80 shadow-sm">
        <span class="w-6 h-6 rounded-full bg-brand text-white flex items-center justify-center font-bold text-xs mb-2">8</span>
        <span class="w-12 h-12 rounded-full bg-brand-light text-brand flex items-center justify-center text-xl mb-3"><i class="fa-solid fa-headset"></i></span>
        <h3 class="font-extrabold text-brand text-xs sm:text-sm leading-tight min-h-[36px] flex items-center justify-center">Support</h3>
        <ul class="text-[10px] text-slate-500 text-left space-y-1 mt-2 list-disc pl-3">
          <li>บริการหลังการขาย</li>
          <li>บำรุงรักษาอย่างมีระบบ</li>
          <li>อัปเดตอย่างต่อเนื่อง</li>
        </ul>
      </div>

    </div>
  </div>
</section>

<!-- ==========================================================================
     Capabilities Section
     ========================================================================== -->
<section id="capabilities" class="py-16 bg-white">
  <div class="max-w-7xl mx-auto px-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-stretch">
      
      <div class="flex flex-col justify-center" data-reveal>
        <h2 class="font-display font-extrabold text-brand text-3xl">Our Capabilities</h2>
        <div class="w-12 h-1 bg-brand mt-3 mb-8 rounded"></div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div class="flex items-start gap-3">
            <span class="text-brand text-2xl mt-1"><i class="fa-solid fa-flask"></i></span>
            <div>
              <b class="text-brand text-sm sm:text-base font-extrabold">R&amp;D and Product Innovation</b>
              <p class="text-xs text-slate-500 mt-1">วิจัยและพัฒนาผลิตภัณฑ์ นวัตกรรม</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <span class="text-brand text-2xl mt-1"><i class="fa-solid fa-drafting-compass"></i></span>
            <div>
              <b class="text-brand text-sm sm:text-base font-extrabold">Mechanical &amp; Simulation</b>
              <p class="text-xs text-slate-500 mt-1">ออกแบบโครงสร้างและจำลองการทำงาน</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <span class="text-brand text-2xl mt-1"><i class="fa-solid fa-terminal"></i></span>
            <div>
              <b class="text-brand text-sm sm:text-base font-extrabold">HW &amp; SW Development</b>
              <p class="text-xs text-slate-500 mt-1">พัฒนาฮาร์ดแวร์และซอฟต์แวร์</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <span class="text-brand text-2xl mt-1"><i class="fa-solid fa-network-wired"></i></span>
            <div>
              <b class="text-brand text-sm sm:text-base font-extrabold">Box Build &amp; Integration</b>
              <p class="text-xs text-slate-500 mt-1">ประกอบและรวมระบบอย่างมืออาชีพ</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <span class="text-brand text-2xl mt-1"><i class="fa-solid fa-microchip"></i></span>
            <div>
              <b class="text-brand text-sm sm:text-base font-extrabold">PCB &amp; PCBA Manufacturing</b>
              <p class="text-xs text-slate-500 mt-1">ออกแบบและผลิตแผงวงจรอิเล็กทรอนิกส์</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <span class="text-brand text-2xl mt-1"><i class="fa-solid fa-certificate"></i></span>
            <div>
              <b class="text-brand text-sm sm:text-base font-extrabold">Certification &amp; Compliance</b>
              <p class="text-xs text-slate-500 mt-1">มาตรฐานและการรับรองระดับสากล</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <span class="text-brand text-2xl mt-1"><i class="fa-solid fa-clipboard-list"></i></span>
            <div>
              <b class="text-brand text-sm sm:text-base font-extrabold">Testing &amp; QA</b>
              <p class="text-xs text-slate-500 mt-1">ทดสอบและควบคุมคุณภาพเข้มงวด</p>
            </div>
          </div>
          <div class="flex items-start gap-3">
            <span class="text-brand text-2xl mt-1"><i class="fa-solid fa-truck-moving"></i></span>
            <div>
              <b class="text-brand text-sm sm:text-base font-extrabold">Supply Chain Management</b>
              <p class="text-xs text-slate-500 mt-1">บริหารจัดการซัพพลายเชนอย่างเป็นระบบ</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Right image banner + certs -->
      <div class="relative overflow-hidden rounded-3xl shadow-xl min-h-[380px]" data-reveal style="--reveal-delay:120ms">
        <img src="<?php echo get_template_directory_uri(); ?>/images/capabilities-image.png"
             alt="การตรวจสอบและทดสอบคุณภาพในสายการผลิตของ Syntech"
             class="absolute inset-0 w-full h-full object-cover">
        
        <!-- Overlay -->
        <div class="absolute inset-0 p-8 flex items-center bg-gradient-to-t lg:bg-gradient-to-r from-transparent via-[#0d3026]/90 to-[#09261e]/98 text-white lg:justify-end">
          <div class="space-y-6 w-full lg:max-w-[50%]">
            <div class="flex items-center gap-3">
              <span class="w-10 h-10 rounded-full border border-white/20 bg-white/10 flex items-center justify-center"><i class="fa-solid fa-award"></i></span>
              <div>
                <b class="block text-sm font-extrabold">ISO 9001</b>
                <span class="text-[10px] text-white/70">Quality Management System</span>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <span class="w-10 h-10 rounded-full border border-white/20 bg-white/10 flex items-center justify-center"><i class="fa-solid fa-car"></i></span>
              <div>
                <b class="block text-sm font-extrabold">IATF 16949</b>
                <span class="text-[10px] text-white/70">Automotive Quality Standard</span>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <span class="w-10 h-10 rounded-full border border-white/20 bg-white/10 flex items-center justify-center"><i class="fa-solid fa-microchip"></i></span>
              <div>
                <b class="block text-sm font-extrabold">IPC-A-610</b>
                <span class="text-[10px] text-white/70">Acceptability of Electronic Assemblies</span>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <span class="w-10 h-10 rounded-full border border-white/20 bg-white/10 flex items-center justify-center"><i class="fa-solid fa-leaf"></i></span>
              <div>
                <b class="block text-sm font-extrabold">RoHS / REACH</b>
                <span class="text-[10px] text-white/70">Environmental Compliance</span>
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

      <div class="relative z-10 grid grid-cols-1 lg:grid-cols-[1.3fr_1fr] gap-12 items-center">
        <div>
          <h2 class="font-display font-extrabold text-2xl lg:text-4xl leading-tight">
            Let's Build Your Next<br>
            <span class="text-gold-bright font-extrabold">Successful Product</span> Together
          </h2>
          <p class="text-sm lg:text-base text-slate-200 mt-4 max-w-lg leading-relaxed">
            ให้เราเป็นพาร์ทเนอร์ในการพัฒนาผลิตภัณฑ์ของคุณ ตั้งแต่แนวคิดจนพร้อมออกสู่ตลาด
          </p>
          <a href="<?php echo home_url('/'); ?>#contact" class="bg-gold-bright hover:bg-[#C99700] active:scale-95 text-slate-900 font-extrabold text-sm uppercase px-8 py-3.5 rounded-xl shadow-lg shadow-gold-bright/20 inline-flex items-center gap-2 mt-8 transition duration-200">
            <i class="fa-solid fa-comments"></i> Talk to Our Experts
          </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div class="flex gap-3">
            <span class="text-gold-bright text-xl mt-1"><i class="fa-solid fa-users-gear"></i></span>
            <div>
              <b class="block text-sm font-extrabold">Expert Team</b>
              <p class="text-xs text-slate-300 mt-1">ทีมวิศวกรผู้เชี่ยวชาญพร้อมเคียงข้างคุณ</p>
            </div>
          </div>
          <div class="flex gap-3">
            <span class="text-gold-bright text-xl mt-1"><i class="fa-solid fa-sliders"></i></span>
            <div>
              <b class="block text-sm font-extrabold">Tailored Solutions</b>
              <p class="text-xs text-slate-300 mt-1">ออกแบบโซลูชันตรงเป้าหมายของคุณ</p>
            </div>
          </div>
          <div class="flex gap-3">
            <span class="text-gold-bright text-xl mt-1"><i class="fa-solid fa-business-time"></i></span>
            <div>
              <b class="block text-sm font-extrabold">On-time Delivery</b>
              <p class="text-xs text-slate-300 mt-1">ผลิตและส่งมอบตรงเวลาตามกำหนด</p>
            </div>
          </div>
          <div class="flex gap-3">
            <span class="text-gold-bright text-xl mt-1"><i class="fa-solid fa-shield-halved"></i></span>
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

<button class="to-top fixed bottom-6 right-6 z-[9999] opacity-0 translate-y-12 transition-all duration-300 w-11 h-11 rounded-full bg-brand text-white flex items-center justify-center shadow-lg hover:bg-brand-deep" type="button" id="toTop" aria-label="กลับไปด้านบนของหน้า">
  <i class="fa-solid fa-arrow-up text-lg"></i>
</button>

<!-- FOOTER CONTAINER -->
<div id="footer-container" class="bg-ink w-full block"></div>

<!-- Scripts -->
<script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/scripts.js') : './components/scripts.js'; ?>"></script>
<script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/live-editor.js') : './components/live-editor.js'; ?>"></script>

<?php wp_footer(); ?>
</body>
</html>
