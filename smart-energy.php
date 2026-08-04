<?php
/* Template Name: Smart Energy Solution */
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
  <title>Smart Energy Solution · ระบบจัดการพลังงานอัจฉริยะ โซลาร์เซลล์ & EV Charger | Synergy Group</title>
  <meta name="description" content="ยกระดับการบริหารจัดการพลังงานอัจฉริยะ โซลาร์เซลล์ สถานีชาร์จ EV และการเพิ่มประสิทธิภาพพลังงานโรงงานอุตสาหกรรม ด้วยแพลตฟอร์ม SynExta Energy Engine จาก Synergy Group">
  
  <link rel="canonical" href="<?php echo home_url('/smart-energy/'); ?>">
  <meta name="robots" content="index,follow">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Synergy Technology">
  <meta property="og:title" content="Smart Energy Solution · ระบบจัดการพลังงานอัจฉริยะ โซลาร์เซลล์ & EV Charger">
  <meta property="og:description" content="โซลูชันบริหารจัดการพลังงานอัจฉริยะ Solar Rooftop, EV Charging Station และ Microgrid มุ่งสู่พลังงานสะอาดยั่งยืน">
  <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/image/smart-energy.png">
  <meta property="og:url" content="<?php echo home_url('/smart-energy/'); ?>">
  <meta name="twitter:card" content="summary_large_image">

  <!-- Favicon -->
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

    .se-eyebrow {
      font-size: clamp(11.5px, .82vw, 15px) !important;
      font-weight: 800 !important;
      letter-spacing: .18em;
      text-transform: uppercase;
      color: #23862D;
    }
    #energy-hero .se-eyebrow { color: #4ade80; }
    /* สูตร h2 กลางของทั้งไซต์: 22px @390 / 40px @1440 / 44px @1920 (ตรงกับ index.php และ about.php) */
    .se-h2 { font-size: clamp(22px, 2.78vw, 44px) !important; line-height: 1.2 !important; font-weight: 800; }
    .se-lede { font-size: clamp(14px, 1.12vw, 20px) !important; line-height: 1.65 !important; }
    /* คำโปรยใน hero ใช้ขนาด/น้ำหนักเดียวกับ hero ของ about.php (20px / 500) */
    #energy-hero .se-lede { font-size: clamp(18px, 1.39vw, 20px) !important; font-weight: 500 !important; }
    .se-card-t { font-size: clamp(14.5px, 1.02vw, 19px) !important; line-height: 1.3 !important; font-weight: 800; }
    .se-card-p { font-size: clamp(12.5px, .88vw, 15.5px) !important; line-height: 1.55 !important; overflow-wrap: normal; word-break: keep-all; hyphens: none; }
    .se-grid { display: grid; grid-auto-rows: 1fr; }
    /* ===== Page shell =================================================
       Measured at 1920px: max-w-[1400px] filled only 73.5% of the viewport, leaving a
       253px gutter each side, while every type clamp had already topped out at ~1400px.
       A big monitor therefore showed small text in a narrow column. The shell grows to
       1760px with a fluid gutter, and the raised clamps above keep scaling into it. */
    .se-shell { width: 100%; max-width: 1760px; margin-inline: auto; padding-inline: clamp(16px, 3.2vw, 64px); }
    /* ===== SynExta architecture section - palette taken from the reference =====
       eyebrow rgb(0,98,82) | headline rgb(0,13,36) | accent word rgb(7,105,54)
       block title rgb(41,41,41) | block sub rgb(84,84,84) | tier label rgb(34,34,34)
       deployment label rgb(30,42,48) */
    #energy-platform .se-eyebrow { color: #006252; }
    #energy-platform .se-h2 { color: #000D24; }
    #energy-platform .se-accent { color: #076936; }
    #energy-platform .se-card-t { color: #292929; }
    #energy-platform .se-sub {
      color: #545454; margin: 2px 0 6px;
      font-size: clamp(11.5px, .82vw, 14px) !important; line-height: 1.5 !important;
      overflow-wrap: normal; word-break: keep-all;
    }
    #energy-platform .se-arch .tier-label { color: #222222; }
    #energy-platform .se-deploy .box { color: #1E2A30; }

    /* Smallest phones: two columns left 136px-wide cards 505px tall at 320px,
       so these two grids fall to a single column below 380px. */
    @media (max-width: 379px) { .se-tight { grid-template-columns: 1fr !important; } }



    /* Layout column responsiveness */
    .se-c3 { grid-template-columns: repeat(3, 1fr); }
    .se-c4 { grid-template-columns: repeat(4, 1fr); }
    .se-c5 { grid-template-columns: repeat(5, 1fr); }
    .se-c6 { grid-template-columns: repeat(6, 1fr); }
    .se-c8 { grid-template-columns: repeat(8, 1fr); }

    @media(max-width:1180px) {
      .se-c8 { grid-template-columns: repeat(4, 1fr); }
      .se-c6 { grid-template-columns: repeat(3, 1fr); }
      .se-c5 { grid-template-columns: repeat(3, 1fr); }
      .se-c4 { grid-template-columns: repeat(3, 1fr); }
    }
    @media(max-width:820px) {
      .se-c8 { grid-template-columns: repeat(3, 1fr); }
      .se-c6, .se-c5, .se-c4, .se-c3 { grid-template-columns: repeat(2, 1fr); }
    }
    @media(max-width:520px) {
      .se-c8 { grid-template-columns: repeat(2, 1fr); }
      .se-c6, .se-c5, .se-c4, .se-c3 { grid-template-columns: 1fr; }
      .se-arch .se-c6, .se-arch .se-c3 { grid-template-columns: repeat(2, 1fr); }
    }

    /* Logo flex row */
    .se-logos {
      display: flex; flex-wrap: wrap; align-items: center; justify-content: center;
      gap: clamp(20px, 3.4vw, 56px);
    }
    .se-logos img {
      height: clamp(34px, 3.9vw, 58px); width: auto; max-width: 100%;
      object-fit: contain; display: block;
      transition: transform .2s, opacity .2s;
    }
    .se-logos img:hover { transform: translateY(-2px); }

    /* Challenge cards */
    .se-chal {
      background: #fff; border: 1px solid #e8ecea; border-radius: 16px; padding: clamp(16px, 1.4vw, 22px);
      transition: transform .25s, box-shadow .25s, border-color .25s; display: flex; flex-direction: column;
    }
    .se-chal:hover { transform: translateY(-4px); box-shadow: 0 14px 32px rgba(11, 33, 39, 0.09); border-color: #23862D; }
    .se-chal-i {
      width: clamp(38px, 2.8vw, 46px); height: clamp(38px, 2.8vw, 46px); border-radius: 12px;
      background: rgba(31, 107, 67, 0.1); color: #1F6B43;
      display: flex; align-items: center; justify-content: center; margin-bottom: 14px; font-size: 1.25rem;
    }

    /* Step flow */
    .se-flow { list-style: none; margin: 0; padding: 0; }
    .se-step {
      position: relative; background: #fff; border: 1px solid #e3e9e5; border-radius: 16px;
      padding: clamp(16px, 1.8vw, 24px); transition: all 0.25s ease;
    }
    .se-step:hover { border-color: #23862D; box-shadow: 0 10px 25px rgba(31, 107, 67, 0.08); transform: translateY(-3px); }
    .se-step-n {
      display: inline-flex; align-items: center; justify-content: center;
      min-width: 38px; height: 38px; padding: 0 10px; border-radius: 10px; margin-bottom: 12px;
      background: linear-gradient(160deg, #2f9560, #12673c); color: #fff; font-weight: 800; letter-spacing: .04em;
      font-size: clamp(12px, 1vw, 14px) !important; line-height: 1 !important;
    }
    .se-step-list { list-style: none; margin: 0; padding: 0; display: flex; flex-wrap: wrap; gap: 6px; }
    .se-step-list li {
      background: #f1f5f2; border: 1px solid #e3e9e5; border-radius: 7px; padding: 4px 9px; color: #2A3831;
      font-size: clamp(9.5px, .78vw, 11.5px) !important; font-weight: 600; line-height: 1.2 !important;
      overflow-wrap: normal; word-break: keep-all;
    }

    /* Architecture diagram */
    .se-arch { background: #f6f8f7; border: 1px solid #e3e9e5; border-radius: 20px; padding: clamp(14px, 1.8vw, 26px); }
    .se-arch .tier { background: #fff; border: 1px solid #e3e9e5; border-radius: 14px; padding: clamp(10px, 1.2vw, 16px); }
    .se-arch .tier-label {
      font-size: clamp(8.5px, .72vw, 10.5px) !important; font-weight: 800; letter-spacing: .16em;
      text-transform: uppercase; color: #6b7280; text-align: center; margin-bottom: 8px;
    }
    .se-arch .chips { display: grid; grid-template-columns: repeat(auto-fit, minmax(85px, 1fr)); gap: 8px; }
    .se-arch .chip {
      background: #f3f6f4; border: 1px solid #e3e9e5; border-radius: 9px; padding: 8px 6px; text-align: center;
      font-size: clamp(9px, .78vw, 11.5px) !important; font-weight: 600; color: #2A3831; line-height: 1.25 !important;
    }
    .se-arch .engine { background: linear-gradient(180deg, #1f6b43, #12522f); border: 0; }
    .se-arch .engine .tier-label { color: rgba(255, 255, 255, .75); }
    .se-arch .engine .chip { background: rgba(255, 255, 255, .14); border-color: rgba(255, 255, 255, .22); color: #fff; }
    .se-arch .flow { display: flex; align-items: center; justify-content: center; color: #1F6B43; font-size: 14px; margin: 8px 0; }
    .se-deploy { display: flex; flex-direction: column; align-items: center; gap: 8px; }
    .se-deploy .box {
      width: 100%; background: #fff; border: 1px solid #e3e9e5; border-radius: 14px; padding: 14px 10px; text-align: center;
      font-size: clamp(10.5px, .9vw, 13px) !important; font-weight: 700; color: #2A3831; line-height: 1.3 !important;
    }
    .se-deploy .or {
      width: 42px; height: 42px; border-radius: 50%; background: #1f6b43; color: #fff;
      display: flex; align-items: center; justify-content: center; font-weight: 800;
      font-size: 12px !important; letter-spacing: .06em;
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

  <!-- ================= 1. ส่วน HERO (ภาพหลัก) ================= -->
  <section id="energy-hero" class="relative pt-12 pb-24 sm:pt-16 sm:pb-32 lg:pt-20 lg:pb-40 text-white overflow-hidden bg-[#0a1118] min-h-[720px] sm:min-h-[800px] lg:min-h-[860px] flex items-center">
    <!-- Background Image Layer - ไม่มีชั้นทำให้มืดทับ (ตัวรูปเข้มอยู่แล้ว ตัวอักษรขาวอ่านออก) -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
      <img loading="eager" fetchpriority="high" decoding="async" class="w-full h-full object-cover object-center" src="<?php echo get_template_directory_uri(); ?>/image/solutions/energy-hero-bg.png" alt="Smart Energy Management Background">
    </div>
    <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#23862D_1px,transparent_1px)] [background-size:32px_32px] pointer-events-none z-0"></div>

    <div class="se-shell relative z-10 w-full">
      <!-- คอลัมน์เดียว หลังเอาภาพ dashboard ออก จำกัดความกว้างที่ max-w-3xl เท่า hero ของ about.php -->
      <div class="max-w-3xl">
          <!-- Label -->
          <p class="se-eyebrow mb-3">
            <span class="lang-th">ENERGY INTELLIGENCE</span>
            <span class="lang-en">ENERGY INTELLIGENCE</span>
          </p>
          
          <!-- หัวข้อหลัก -->
          <h1 class="font-display font-extrabold text-white tracking-tight" style="font-size:clamp(30px,4.17vw,60px);line-height:1.15">
            <span class="lang-th">
              บริหารจัดการพลังงานอัจฉริยะ<br>
              <span class="text-brand-bright">เพื่อธุรกิจที่ใช้พลังงานอย่างมีประสิทธิภาพ</span>
            </span>
            <span class="lang-en">
              Power Your Business with<br>
              <span class="text-brand-bright">Smart Energy Management</span>
            </span>
          </h1>

          <div class="mt-2 text-emerald-400 font-semibold tracking-wide" style="font-size:clamp(13.5px,1.15vw,17px)">
            <span class="lang-th">แพลตฟอร์มเดียวสำหรับบริหารจัดการพลังงานและระบบ Solar ครบวงจร</span>
            <span class="lang-en">One Platform for Complete Energy Visibility</span>
          </div>

          <!-- คำอธิบาย -->
          <p class="se-lede text-slate-300 font-light mt-5 max-w-2xl">
            <span class="lang-th">
              SynExta คือแพลตฟอร์ม Smart Energy Management ที่ช่วยบริหารจัดการการใช้พลังงานและการผลิตไฟฟ้าจาก Solar Rooftop แบบ Real-time รองรับการเชื่อมต่อกับ Inverter ได้หลายแบรนด์ พร้อมควบคุมอุปกรณ์ไฟฟ้า กำหนดเวลาเปิด–ปิดอัตโนมัติ แจ้งเตือนเมื่ออุปกรณ์ผิดปกติ และเชื่อมโยงข้อมูลจากทุกไซต์งานไว้ในแพลตฟอร์มเดียว
            </span>
            <span class="lang-en">
              Monitor, control, and optimize your energy consumption and solar generation from a single intelligent platform. SynExta seamlessly integrates with multiple inverter brands, supports real-time monitoring, automated energy control, and enterprise-wide energy management across factories, commercial buildings, and multi-site businesses.
            </span>
          </p>

          <!-- ปุ่ม -->
          <div class="mt-8 flex flex-wrap gap-4">
            <a href="<?php echo home_url('/'); ?>#contact" class="inline-flex items-center gap-2.5 bg-brand-bright text-white px-8 py-4 rounded-xl font-extrabold uppercase tracking-wider hover:bg-emerald-600 transition-all shadow-lg shadow-brand-bright/30 hover:-translate-y-0.5" style="font-size:clamp(12px,1vw,14px)">
              <i class="fa-solid fa-paper-plane text-xs"></i>
              <span class="lang-th">ปรึกษาผู้เชี่ยวชาญ</span>
              <span class="lang-en">Talk to Our Experts</span>
            </a>
          </div>
      </div>
    </div>
  </section>

  <!-- ================= 2. ลูกค้าที่ไว้วางใจ ================= -->
  <section id="energy-leaders" class="py-10 sm:py-12 bg-white border-b border-slate-100">
    <div class="se-shell">
      <p class="se-eyebrow text-center mb-2">
        <span class="lang-th">ลูกค้าที่ไว้วางใจ</span>
        <span class="lang-en">TRUSTED FOR ENERGY MANAGEMENT</span>
      </p>
      <!-- หัวข้อ -->
      <h2 class="se-h2 font-display text-ink text-center mb-8">
        <span class="lang-th">โซลูชันที่ตอบโจทย์ธุรกิจด้านพลังงาน</span>
        <span class="lang-en">Trusted by Energy Leaders</span>
      </h2>
      <!-- โลโก้ลูกค้า -->
      <div class="se-logos">
        <img src="<?php echo get_template_directory_uri(); ?>/image/NIDA_WISDOM.png" alt="NIDA WISDOM for Change" title="NIDA" loading="lazy">
        <img src="<?php echo get_template_directory_uri(); ?>/image/SANSIRI.png" alt="SANSIRI" title="San Siri" loading="lazy">
        <img src="<?php echo get_template_directory_uri(); ?>/image/Valuation_Engineering.png" alt="Valuation Engineering" title="VALUATION ENGINEERING" loading="lazy">
      </div>
    </div>
  </section>

  <!-- ================= 3. ปัญหาที่เราช่วยแก้ไข ================= -->
  <section id="energy-challenges" class="py-12 sm:py-16 bg-slate-50/50" style="scroll-margin-top:96px">
    <div class="se-shell">
      <p class="se-eyebrow text-center mb-2">
        <span class="lang-th">ปัญหาที่เราช่วยแก้ไข</span>
        <span class="lang-en">ENERGY CHALLENGES WE SOLVE</span>
      </p>
      <!-- หัวข้อ -->
      <h2 class="se-h2 font-display text-ink text-center mb-9 sm:mb-12">
        <span class="lang-th">ปัญหาด้านพลังงานที่ธุรกิจส่วนใหญ่กำลังเผชิญ</span>
        <span class="lang-en">Challenges We Help You Solve</span>
      </h2>
      <!-- 6 Cards Grid (Exact match with reference image) -->
      <div class="se-tight grid auto-rows-fr grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4 sm:gap-5">

        <!-- Card 1: No Real-Time Energy Visibility -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col items-center text-center group">
          <div class="w-20 h-20 sm:w-24 sm:h-24 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/challenge_canva_1.png" alt="No Real-Time Energy Visibility" class="w-full h-full object-contain drop-shadow-sm">
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-2 leading-snug tracking-tight">
            <span class="lang-th">มองไม่เห็นข้อมูลการใช้พลังงานแบบ Real-time</span>
            <span class="lang-en">No Real-Time<br>Energy Visibility</span>
          </h3>
          <p class="text-[11px] sm:text-xs text-slate-500 font-normal leading-relaxed">
            <span class="lang-th">ไม่สามารถติดตามการใช้ไฟฟ้าและการผลิตไฟจาก Solar ได้ทันที ทำให้ตัดสินใจได้ช้า</span>
            <span class="lang-en">Unable to monitor electricity usage and solar production in real time.</span>
          </p>
        </div>

        <!-- Card 2: Multiple Inverter Brands -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col items-center text-center group">
          <div class="w-20 h-20 sm:w-24 sm:h-24 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/challenge_canva_2.png" alt="Multiple Inverter Brands" class="w-full h-full object-contain drop-shadow-sm">
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-2 leading-snug tracking-tight">
            <span class="lang-th">ใช้ Inverter หลายแบรนด์</span>
            <span class="lang-en">Multiple Inverter<br>Brands</span>
          </h3>
          <p class="text-[11px] sm:text-xs text-slate-500 font-normal leading-relaxed">
            <span class="lang-th">แต่ละแบรนด์มีระบบ Monitoring แยกกัน ทำให้บริหารจัดการข้อมูลได้ยาก</span>
            <span class="lang-en">Different monitoring systems make solar management complicated.</span>
          </p>
        </div>

        <!-- Card 3: Multiple Sites -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col items-center text-center group">
          <div class="w-20 h-20 sm:w-24 sm:h-24 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/challenge_canva_3.png" alt="Multiple Sites" class="w-full h-full object-contain drop-shadow-sm">
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-2 leading-snug tracking-tight">
            <span class="lang-th">มีหลายโรงงานหรือหลายสาขา</span>
            <span class="lang-en">Multiple Sites</span>
          </h3>
          <p class="text-[11px] sm:text-xs text-slate-500 font-normal leading-relaxed">
            <span class="lang-th">ต้องเปิดหลายระบบเพื่อดูข้อมูลของแต่ละไซต์ ทำให้เสียเวลาและควบคุมได้ยาก</span>
            <span class="lang-en">Managing dozens or hundreds of branches from different platforms.</span>
          </p>
        </div>

        <!-- Card 4: High Electricity Cost -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col items-center text-center group">
          <div class="w-20 h-20 sm:w-24 sm:h-24 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/challenge_canva_4.png" alt="High Electricity Cost" class="w-full h-full object-contain drop-shadow-sm">
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-2 leading-snug tracking-tight">
            <span class="lang-th">ค่าไฟฟ้าสูงขึ้นอย่างต่อเนื่อง</span>
            <span class="lang-en">High Electricity<br>Cost</span>
          </h3>
          <p class="text-[11px] sm:text-xs text-slate-500 font-normal leading-relaxed">
            <span class="lang-th">ไม่ทราบว่าพลังงานถูกใช้ในส่วนใดมากที่สุด จึงไม่สามารถลดต้นทุนได้อย่างมีประสิทธิภาพ</span>
            <span class="lang-en">Lack of insight into energy usage increases operating expenses.</span>
          </p>
        </div>

        <!-- Card 5: Late Equipment Failure Detection -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col items-center text-center group">
          <div class="w-20 h-20 sm:w-24 sm:h-24 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/challenge_canva_5.png" alt="Late Equipment Failure Detection" class="w-full h-full object-contain drop-shadow-sm">
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-2 leading-snug tracking-tight">
            <span class="lang-th">อุปกรณ์เสียแต่รู้ตัวช้า</span>
            <span class="lang-en">Late Equipment<br>Failure Detection</span>
          </h3>
          <p class="text-[11px] sm:text-xs text-slate-500 font-normal leading-relaxed">
            <span class="lang-th">Inverter หรืออุปกรณ์ไฟฟ้ามีปัญหา แต่ไม่มีระบบแจ้งเตือน ทำให้สูญเสียโอกาสในการผลิตไฟฟ้า</span>
            <span class="lang-en">Equipment problems are discovered after production losses occur.</span>
          </p>
        </div>

        <!-- Card 6: Limited User Management -->
        <div class="bg-white border border-slate-200/70 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col items-center text-center group">
          <div class="w-20 h-20 sm:w-24 sm:h-24 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
            <img src="<?php echo get_template_directory_uri(); ?>/image/challenge_canva_6.png" alt="Limited User Management" class="w-full h-full object-contain drop-shadow-sm">
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-2 leading-snug tracking-tight">
            <span class="lang-th">จัดการสิทธิ์ผู้ใช้งานได้ยาก</span>
            <span class="lang-en">Limited User<br>Management</span>
          </h3>
          <p class="text-[11px] sm:text-xs text-slate-500 font-normal leading-relaxed">
            <span class="lang-th">ไม่สามารถกำหนดสิทธิ์ให้เจ้าของกิจการ ผู้ติดตั้ง และผู้จัดการแต่ละสาขาเข้าถึงข้อมูลเฉพาะที่เกี่ยวข้องได้</span>
            <span class="lang-en">Difficult to control access for installers, owners and branch managers.</span>
          </p>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= 4. จากข้อมูลพลังงาน สู่การบริหารจัดการอัจฉริยะ ================= -->
  <section id="energy-flow" class="py-12 sm:py-16 bg-white border-y border-slate-100" style="scroll-margin-top:96px">
    <div class="se-shell">
      <p class="se-eyebrow text-center mb-2">
        <span class="lang-th">จากข้อมูลพลังงาน สู่การบริหารจัดการอัจฉริยะ</span>
        <span class="lang-en">END-TO-END ENERGY MANAGEMENT</span>
      </p>
      <!-- หัวข้อ -->
      <h2 class="se-h2 font-display text-ink text-center mb-10 sm:mb-12">
        <span class="lang-th">เปลี่ยนข้อมูลพลังงานให้เป็นการตัดสินใจที่มีประสิทธิภาพ</span>
        <span class="lang-en">From Energy Data to Intelligent Decisions</span>
      </h2>

      <!-- 6 Steps Grid (Exact match with reference image) -->
      <div class="grid auto-rows-fr grid-cols-1 sm:grid-cols-2 md:grid-cols-3 2xl:grid-cols-6 gap-4 sm:gap-5">
        
        <!-- Step 01: Connect -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group">
          <div>
            <!-- Top Step Badge -->
            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-extrabold flex items-center justify-center text-xs mb-4 shadow-sm">
              01
            </div>

            <!-- 3D Graphic Image -->
            <div class="w-full h-28 sm:h-32 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
              <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_canva/step_1.png" alt="01 Connect" class="max-w-full max-h-full object-contain drop-shadow-sm">
            </div>

            <!-- Title & Description -->
            <h3 class="font-extrabold text-slate-900 text-base mb-2 tracking-tight">
              <span class="lang-th">01 Connect</span>
              <span class="lang-en">01 Connect</span>
            </h3>
            <p class="text-xs text-slate-500 font-normal leading-relaxed">
              <span class="lang-th">เชื่อมต่อ Solar Inverter, Energy Meter, ระบบไฟฟ้า และอุปกรณ์ IoT Sensors</span>
              <span class="lang-en">Connect Solar Inverters, Energy Meters, Building Devices, and IoT Sensors.</span>
            </p>
          </div>

          <!-- Bottom Tags -->
          <div>
            <div class="w-12 h-0.5 bg-emerald-300 rounded-full my-3.5"></div>
            <div class="flex flex-col gap-2">
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-solar-panel text-emerald-600 text-xs"></i>
                <span>Solar Inverter</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-bolt text-emerald-600 text-xs"></i>
                <span>Energy Meter</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-plug text-emerald-600 text-xs"></i>
                <span class="lang-th">ระบบไฟฟ้า</span><span class="lang-en">Building System</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-wifi text-emerald-600 text-xs"></i>
                <span>IoT Sensors</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 02: Collect -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group">
          <div>
            <!-- Top Step Badge -->
            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-extrabold flex items-center justify-center text-xs mb-4 shadow-sm">
              02
            </div>

            <!-- 3D Graphic Image -->
            <div class="w-full h-28 sm:h-32 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
              <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_canva/step_2.png" alt="02 Collect" class="max-w-full max-h-full object-contain drop-shadow-sm">
            </div>

            <!-- Title & Description -->
            <h3 class="font-extrabold text-slate-900 text-base mb-2 tracking-tight">
              <span class="lang-th">02 Collect</span>
              <span class="lang-en">02 Collect</span>
            </h3>
            <p class="text-xs text-slate-500 font-normal leading-relaxed">
              <span class="lang-th">รวบรวมข้อมูลการผลิตไฟและการใช้พลังงานจากทุกไซต์เข้าสู่แพลตฟอร์มเดียว</span>
              <span class="lang-en">Collect real-time energy data from every site into one platform.</span>
            </p>
          </div>

          <!-- Bottom Tags -->
          <div>
            <div class="w-12 h-0.5 bg-emerald-300 rounded-full my-3.5"></div>
            <div class="flex flex-col gap-2">
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-regular fa-clock text-emerald-600 text-xs"></i>
                <span>Real-time Data</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-sitemap text-emerald-600 text-xs"></i>
                <span>Multi-site Aggregation</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 03: Visualize -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group">
          <div>
            <!-- Top Step Badge -->
            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-extrabold flex items-center justify-center text-xs mb-4 shadow-sm">
              03
            </div>

            <!-- 3D Graphic Image -->
            <div class="w-full h-28 sm:h-32 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
              <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_canva/step_3.png" alt="03 Visualize" class="max-w-full max-h-full object-contain drop-shadow-sm">
            </div>

            <!-- Title & Description -->
            <h3 class="font-extrabold text-slate-900 text-base mb-2 tracking-tight">
              <span class="lang-th">03 Visualize</span>
              <span class="lang-en">03 Visualize</span>
            </h3>
            <p class="text-xs text-slate-500 font-normal leading-relaxed">
              <span class="lang-th">Dashboard, รายงาน, Energy KPIs และระบบการแจ้งเตือนแบบ Real-time</span>
              <span class="lang-en">Dashboard, Reports, Alerts, Energy KPIs — all in real-time.</span>
            </p>
          </div>

          <!-- Bottom Tags -->
          <div>
            <div class="w-12 h-0.5 bg-emerald-300 rounded-full my-3.5"></div>
            <div class="flex flex-col gap-2">
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-table-cells-large text-emerald-600 text-xs"></i>
                <span>Dashboard</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-regular fa-file-lines text-emerald-600 text-xs"></i>
                <span class="lang-th">รายงาน</span><span class="lang-en">Reports</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-bullseye text-emerald-600 text-xs"></i>
                <span>KPI</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-regular fa-bell text-emerald-600 text-xs"></i>
                <span class="lang-th">แจ้งเตือน Real-time</span><span class="lang-en">Real-time Alerts</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 04: Optimize -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group">
          <div>
            <!-- Top Step Badge -->
            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-extrabold flex items-center justify-center text-xs mb-4 shadow-sm">
              04
            </div>

            <!-- 3D Graphic Image -->
            <div class="w-full h-28 sm:h-32 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
              <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_canva/step_4.png" alt="04 Optimize" class="max-w-full max-h-full object-contain drop-shadow-sm">
            </div>

            <!-- Title & Description -->
            <h3 class="font-extrabold text-slate-900 text-base mb-2 tracking-tight">
              <span class="lang-th">04 Optimize</span>
              <span class="lang-en">04 Optimize</span>
            </h3>
            <p class="text-xs text-slate-500 font-normal leading-relaxed">
              <span class="lang-th">สั่งเปิด–ปิดอุปกรณ์ไฟฟ้า กำหนดเวลาการทำงาน และบริหารโหลดไฟฟ้าอัตโนมัติ</span>
              <span class="lang-en">Lighting Automation, Schedule Control, and Load Management.</span>
            </p>
          </div>

          <!-- Bottom Tags -->
          <div>
            <div class="w-12 h-0.5 bg-emerald-300 rounded-full my-3.5"></div>
            <div class="flex flex-col gap-2">
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-power-off text-emerald-600 text-xs"></i>
                <span class="lang-th">เปิด-ปิดอุปกรณ์</span><span class="lang-en">Device Switch</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-regular fa-clock text-emerald-600 text-xs"></i>
                <span class="lang-th">กำหนดเวลาการทำงาน</span><span class="lang-en">Schedule Control</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-emerald-600 text-xs"></i>
                <span>Load Management</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 05: Integrate -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group">
          <div>
            <!-- Top Step Badge -->
            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-extrabold flex items-center justify-center text-xs mb-4 shadow-sm">
              05
            </div>

            <!-- 3D Graphic Image -->
            <div class="w-full h-28 sm:h-32 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
              <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_canva/step_5.png" alt="05 Integrate" class="max-w-full max-h-full object-contain drop-shadow-sm">
            </div>

            <!-- Title & Description -->
            <h3 class="font-extrabold text-slate-900 text-base mb-2 tracking-tight">
              <span class="lang-th">05 Integrate</span>
              <span class="lang-en">05 Integrate</span>
            </h3>
            <p class="text-xs text-slate-500 font-normal leading-relaxed">
              <span class="lang-th">เชื่อมต่อ ERP, BMS, SCADA และระบบภายนอกองค์กรผ่าน Open API</span>
              <span class="lang-en">Connect ERP, BMS, SCADA and external systems via API.</span>
            </p>
          </div>

          <!-- Bottom Tags -->
          <div>
            <div class="w-12 h-0.5 bg-emerald-300 rounded-full my-3.5"></div>
            <div class="flex flex-col gap-2">
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-regular fa-folder text-emerald-600 text-xs"></i>
                <span>ERP</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-building text-emerald-600 text-xs"></i>
                <span>BMS</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-desktop text-emerald-600 text-xs"></i>
                <span>SCADA</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-code text-emerald-600 text-xs"></i>
                <span>API</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 06: Grow with AI -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 sm:p-6 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:border-emerald-400 transition-all flex flex-col justify-between group">
          <div>
            <!-- Top Step Badge -->
            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-extrabold flex items-center justify-center text-xs mb-4 shadow-sm">
              06
            </div>

            <!-- 3D Graphic Image -->
            <div class="w-full h-28 sm:h-32 mb-4 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
              <img src="<?php echo get_template_directory_uri(); ?>/image/e2e_canva/step_6.png" alt="06 Grow with AI" class="max-w-full max-h-full object-contain drop-shadow-sm">
            </div>

            <!-- Title & Description -->
            <h3 class="font-extrabold text-slate-900 text-base mb-2 tracking-tight">
              <span class="lang-th">06 Grow with AI</span>
              <span class="lang-en">06 Grow with AI</span>
            </h3>
            <p class="text-xs text-slate-500 font-normal leading-relaxed">
              <span class="lang-th">คำแนะนำจาก AI ในการประหยัดพลังงาน และวิเคราะห์คาดการณ์ล่วงหน้า</span>
              <span class="lang-en">AI Recommendations, Energy Saving Suggestions, and Predictive Analytics.</span>
            </p>
          </div>

          <!-- Bottom Tags -->
          <div>
            <div class="w-12 h-0.5 bg-emerald-300 rounded-full my-3.5"></div>
            <div class="flex flex-col gap-2">
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-wand-magic-sparkles text-emerald-600 text-xs"></i>
                <span>AI Recommendations</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-leaf text-emerald-600 text-xs"></i>
                <span>Energy Saving Suggestions</span>
              </div>
              <div class="bg-emerald-50/80 text-slate-700 border border-emerald-100/80 rounded-lg px-2.5 py-1.5 text-[11px] font-medium flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-emerald-600 text-xs"></i>
                <span>Predictive Analytics</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= 5. สถาปัตยกรรมแพลตฟอร์ม SYNEXTA ENERGY ================= -->
  <section id="energy-platform" class="py-12 sm:py-16 bg-[#f6f8f7] border-y border-slate-100" style="scroll-margin-top:96px">
    <div class="se-shell">
      <div class="grid lg:grid-cols-[minmax(280px,32%)_1fr] gap-8 lg:gap-12 items-center">

        <!-- Left Features -->
        <div>
          <p class="se-eyebrow mb-3">
            <span class="lang-th">สถาปัตยกรรมแพลตฟอร์ม SynExta Energy</span>
            <span class="lang-en">SYNEXTA ENERGY PLATFORM ARCHITECTURE</span>
          </p>
          <!-- หัวข้อ -->
          <h2 class="se-h2 font-display text-ink mb-6">
            <span class="lang-th">แพลตฟอร์มเดียว<br>บริหารพลังงาน<span class="se-accent">ทุกไซต์งาน</span></span>
            <span class="lang-en">One Platform.<br><span class="se-accent">Every</span> Site.</span>
          </h2>
          
          <ul class="space-y-5">

            <!-- รองรับ Inverter ได้หลายแบรนด์ -->
            <li class="flex gap-3.5">
              <span class="w-10 h-10 rounded-xl bg-brand/10 flex items-center justify-center flex-none text-brand font-bold"><i class="fa-solid fa-plug text-base"></i></span>
              <div>
                <div class="se-card-t text-ink mb-1">
                  <span class="lang-th">รองรับ Inverter ได้หลายแบรนด์</span>
                  <span class="lang-en">Multi-Brand Inverter Integration</span>
                </div>
                <p class="se-sub"><span class="lang-th">รองรับอินเวอร์เตอร์หลากหลายแบรนด์</span><span class="lang-en">Works with a wide range of inverter brands.</span></p>
                <ul class="se-step-list mt-1.5">
                  <li>Huawei</li><li>Sungrow</li><li>GoodWe</li><li>Growatt</li>
                  <li>SMA</li><li>Fronius</li><li>Delta</li><li>Solis</li>
                  <li class="bg-emerald-100 text-brand-deep font-bold">และแบรนด์อื่น ๆ</li>
                </ul>
              </div>
            </li>

            <!-- บริหารจัดการได้หลายไซต์ -->
            <li class="flex gap-3.5">
              <span class="w-10 h-10 rounded-xl bg-brand/10 flex items-center justify-center flex-none text-brand font-bold"><i class="fa-solid fa-sitemap text-base"></i></span>
              <div>
                <div class="se-card-t text-ink mb-1">
                  <span class="lang-th">บริหารจัดการได้หลายไซต์ (ทั้งหมดในแพลตฟอร์มเดียว)</span>
                  <span class="lang-en">Multi-Site Management</span>
                </div>
                <p class="se-sub"><span class="lang-th">จัดการหลายไซต์ได้อย่างง่ายดาย</span><span class="lang-en">Manage many sites with ease.</span></p>
                <ul class="se-step-list mt-1.5">
                  <li>โรงงาน</li><li>อาคาร</li><li>สาขา</li><li>Solar Farm</li>
                </ul>
              </div>
            </li>

            <!-- รองรับ Cloud และ On-Premise -->
            <li class="flex gap-3.5">
              <span class="w-10 h-10 rounded-xl bg-brand/10 flex items-center justify-center flex-none text-brand font-bold"><i class="fa-solid fa-cloud text-base"></i></span>
              <div>
                <div class="se-card-t text-ink mb-1">
                  <span class="lang-th">รองรับ Cloud และ On-Premise</span>
                  <span class="lang-en">Flexible Deployment</span>
                </div>
                <p class="se-sub"><span class="lang-th">ติดตั้งได้ตามนโยบายความปลอดภัยขององค์กร</span><span class="lang-en">Deploy to match your security policy.</span></p>
                <ul class="se-step-list">
                  <li>Cloud</li><li>On-Premise</li><li>Hybrid</li>
                </ul>
              </div>
            </li>

            <!-- เชื่อมต่อกับระบบอื่นได้ -->
            <li class="flex gap-3.5">
              <span class="w-10 h-10 rounded-xl bg-brand/10 flex items-center justify-center flex-none text-brand font-bold"><i class="fa-solid fa-code text-base"></i></span>
              <div>
                <div class="se-card-t text-ink mb-1">
                  <span class="lang-th">เชื่อมต่อกับระบบอื่นได้</span>
                  <span class="lang-en">Open API Integration</span>
                </div>
                <p class="se-sub"><span class="lang-th">เชื่อมต่อกับระบบภายนอกได้อย่างอิสระ</span><span class="lang-en">Connect freely with external systems.</span></p>
                <ul class="se-step-list mt-1.5">
                  <li>ERP</li><li>BMS</li><li>CMMS</li><li>API</li>
                </ul>
              </div>
            </li>

          </ul>
        </div>

        <!-- Diagram Flow -->
        <div class="grid lg:grid-cols-[1fr_auto] gap-5 items-center">
          <div class="se-arch shadow-sm">

            <!-- Headquarters / สำนักงานใหญ่ -->
            <div class="tier">
              <div class="tier-label"><span class="lang-th">สำนักงานใหญ่ / Enterprise Dashboard</span><span class="lang-en">Headquarters / Enterprise Dashboard</span></div>
              <div class="chips">
                <div class="chip"><i class="fa-solid fa-building block mb-1 text-brand"></i>HQ Control</div>
                <div class="chip"><i class="fa-solid fa-location-dot block mb-1 text-brand"></i>Sites</div>
                <div class="chip"><i class="fa-solid fa-file-lines block mb-1 text-brand"></i>Reports</div>
                <div class="chip"><i class="fa-solid fa-bell block mb-1 text-brand"></i>Alerts</div>
                <div class="chip"><i class="fa-solid fa-chart-line block mb-1 text-brand"></i>Analytics</div>
                <div class="chip"><i class="fa-solid fa-users block mb-1 text-brand"></i>Users</div>
              </div>
            </div>

            <div class="flow"><i class="fa-solid fa-arrow-down"></i></div>

            <!-- SynExta Energy Engine -->
            <div class="tier engine">
              <div class="tier-label">SynExta Energy Engine</div>
              <div class="chips">
                <div class="chip">AI Analytics</div>
                <div class="chip">Rule Engine</div>
                <div class="chip">Alert Engine</div>
                <div class="chip">Energy Analytics</div>
              </div>
            </div>

            <div class="flow"><i class="fa-solid fa-arrow-down"></i></div>

            <!-- Energy Gateway -->
            <div class="tier">
              <div class="tier-label">Energy Gateway</div>
              <div class="chips se-c3">
                <div class="chip"><i class="fa-solid fa-server block mb-1 text-brand"></i>Gateway 1</div>
                <div class="chip"><i class="fa-solid fa-server block mb-1 text-brand"></i>Gateway 2</div>
                <div class="chip"><i class="fa-solid fa-server block mb-1 text-brand"></i>Gateway 3</div>
              </div>
            </div>

            <div class="flow"><i class="fa-solid fa-arrow-down"></i></div>

            <!-- Equipment Devices -->
            <div class="chips se-c6">
              <div class="chip"><i class="fa-solid fa-solar-panel block mb-1 text-brand"></i>Solar Inverter</div>
              <div class="chip"><i class="fa-solid fa-bolt block mb-1 text-brand"></i>Energy Meter</div>
              <div class="chip"><i class="fa-regular fa-lightbulb block mb-1 text-brand"></i>Lighting Controller</div>
              <div class="chip"><i class="fa-solid fa-fan block mb-1 text-brand"></i>HVAC</div>
              <div class="chip"><i class="fa-solid fa-charging-station block mb-1 text-brand"></i>EV Charger</div>
              <div class="chip"><i class="fa-solid fa-microchip block mb-1 text-brand"></i>IoT Sensor</div>
            </div>
          </div>

          <!-- Deployment Options -->
          <div class="se-deploy">
            <div class="box shadow-sm"><i class="fa-solid fa-cloud block mb-1.5 text-brand text-xl"></i>Cloud</div>
            <div class="or"><span class="lang-th">หรือ</span><span class="lang-en">OR</span></div>
            <div class="box shadow-sm"><i class="fa-solid fa-database block mb-1.5 text-brand text-xl"></i>On-Premise</div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= 6. ความสามารถของระบบ SMART ENERGY MANAGEMENT ================= -->
  <section id="energy-capabilities" class="py-14 sm:py-20 bg-white" style="scroll-margin-top:96px">
    <div class="se-shell">
      <div class="text-center max-w-3xl mx-auto mb-12">
        <p class="se-eyebrow mb-2">
          <span class="lang-th">ความสามารถของระบบ</span>
          <span class="lang-en">SMART ENERGY CAPABILITIES</span>
        </p>
        <!-- หัวข้อ -->
        <h2 class="se-h2 font-display text-ink">
          <span class="lang-th">ความสามารถของระบบ Smart Energy Management</span>
          <span class="lang-en">Smart Energy Management Capabilities</span>
        </h2>
      </div>

      <!-- 12 CARDS GRID -->
      <div class="se-tight grid auto-rows-fr grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-6 gap-4 sm:gap-6">

        <!-- 1. ติดตามการผลิตไฟ Solar -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-solar-panel"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">ระบบติดตามการผลิตไฟฟ้าจาก Solar Rooftop</span>
            <span class="lang-en">Solar Monitoring</span>
          </h3>
        </div>

        <!-- 2. รองรับ Inverter หลายแบรนด์ -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-plug"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">รองรับ Inverter หลายแบรนด์</span>
            <span class="lang-en">Multi-Brand Inverter</span>
          </h3>
        </div>

        <!-- 3. Dashboard พลังงานแบบ Real-time -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-chart-pie"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">Dashboard พลังงานแบบ Real-time</span>
            <span class="lang-en">Energy Dashboard</span>
          </h3>
        </div>

        <!-- 4. ระบบติดตามการใช้พลังงาน -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-gauge-high"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">ระบบติดตามการใช้พลังงาน</span>
            <span class="lang-en">Real-Time Monitoring</span>
          </h3>
        </div>

        <!-- 5. ระบบควบคุมเปิด-ปิดไฟอัตโนมัติ -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-regular fa-lightbulb"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">ระบบควบคุมการเปิด–ปิดไฟอัตโนมัติ</span>
            <span class="lang-en">Lighting Automation</span>
          </h3>
        </div>

        <!-- 6. ระบบกำหนดเวลาเปิด-ปิดอุปกรณ์ไฟฟ้า -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-clock"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">ระบบกำหนดเวลาเปิด–ปิดอุปกรณ์ไฟฟ้า</span>
            <span class="lang-en">Energy Scheduling</span>
          </h3>
        </div>

        <!-- 7. ระบบแจ้งเตือนเมื่ออุปกรณ์ผิดปกติ -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-bell"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">ระบบแจ้งเตือนเมื่ออุปกรณ์ผิดปกติ</span>
            <span class="lang-en">Alert Notification</span>
          </h3>
        </div>

        <!-- 8. วิเคราะห์ข้อมูลการใช้พลังงาน -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-chart-line"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">วิเคราะห์ข้อมูลการใช้พลังงาน</span>
            <span class="lang-en">Energy Analytics</span>
          </h3>
        </div>

        <!-- 9. บริหารจัดการหลายโรงงานหรือหลายสาขา -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-building-user"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">บริหารจัดการหลายโรงงานหรือหลายสาขา</span>
            <span class="lang-en">Multi-Site Management</span>
          </h3>
        </div>

        <!-- 10. กำหนดสิทธิ์ผู้ใช้งาน -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-user-shield"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">กำหนดสิทธิ์ผู้ใช้งาน (Role-Based Access Control)</span>
            <span class="lang-en">Role-Based Access Control</span>
          </h3>
        </div>

        <!-- 11. รองรับ Cloud และ On-Premise -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-cloud-sun"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">รองรับ Cloud และ On-Premise</span>
            <span class="lang-en">Cloud &amp; On-Premise</span>
          </h3>
        </div>

        <!-- 12. เชื่อมต่อระบบ ERP และ BMS ผ่าน API -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-brand flex items-center justify-center text-2xl mb-3.5 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-code"></i>
          </div>
          <h3 class="font-extrabold text-slate-900 text-sm sm:text-base mb-1">
            <span class="lang-th">เชื่อมต่อระบบ ERP และ BMS ผ่าน API</span>
            <span class="lang-en">Open API Integration</span>
          </h3>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= 7. ผลลัพธ์ที่ธุรกิจได้รับ ================= -->
  <section id="energy-outcomes" class="py-12 sm:py-16 bg-[#f6f8f7] border-y border-slate-100">
    <div class="se-shell">
      <p class="se-eyebrow text-center mb-2">
        <span class="lang-th">ผลลัพธ์ที่ธุรกิจได้รับ</span>
        <span class="lang-en">BUSINESS OUTCOMES</span>
      </p>
      <!-- หัวข้อ -->
      <h2 class="se-h2 font-display text-ink text-center mb-10">
        <span class="lang-th">ผลลัพธ์ที่วัดผลได้จริง</span>
        <span class="lang-en">Business Outcomes That Matter</span>
      </h2>

      <div class="se-grid se-c6" style="gap:clamp(12px,1.4vw,20px)">
        
        <!-- 1. ลดค่าไฟฟ้า -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 flex items-start gap-4 shadow-sm hover:border-brand transition-all">
          <span class="w-11 h-11 rounded-xl bg-brand/10 flex items-center justify-center flex-none text-brand font-bold text-lg"><i class="fa-solid fa-arrow-trend-down"></i></span>
          <div>
            <div class="se-card-t text-ink mb-1">
              <span class="lang-th">ลดค่าไฟฟ้า</span>
              <span class="lang-en">Reduce Electricity Cost</span>
            </div>
            <p class="se-card-p text-muted"><span class="lang-th">ลดค่าใช้จ่ายด้านพลังงานขององค์กรอย่างยั่งยืน</span><span class="lang-en">Lower overall operational energy costs.</span></p>
          </div>
        </div>

        <!-- 2. เพิ่มประสิทธิภาพการผลิตไฟจาก Solar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 flex items-start gap-4 shadow-sm hover:border-brand transition-all">
          <span class="w-11 h-11 rounded-xl bg-brand/10 flex items-center justify-center flex-none text-brand font-bold text-lg"><i class="fa-solid fa-solar-panel"></i></span>
          <div>
            <div class="se-card-t text-ink mb-1">
              <span class="lang-th">เพิ่มประสิทธิภาพการผลิตไฟจาก Solar</span>
              <span class="lang-en">Increase Solar Performance</span>
            </div>
            <p class="se-card-p text-muted"><span class="lang-th">เพิ่มประสิทธิภาพการผลิตและการใช้งานไฟฟ้าโซลาร์เซลล์สูงสุด</span><span class="lang-en">Maximize solar generation efficiency.</span></p>
          </div>
        </div>

        <!-- 3. ลดการสูญเสียพลังงาน -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 flex items-start gap-4 shadow-sm hover:border-brand transition-all">
          <span class="w-11 h-11 rounded-xl bg-brand/10 flex items-center justify-center flex-none text-brand font-bold text-lg"><i class="fa-solid fa-leaf"></i></span>
          <div>
            <div class="se-card-t text-ink mb-1">
              <span class="lang-th">ลดการสูญเสียพลังงาน</span>
              <span class="lang-en">Reduce Energy Waste</span>
            </div>
            <p class="se-card-p text-muted"><span class="lang-th">ควบคุมการใช้พลังงานเพื่อป้องกันการสูญเสียโดยไม่จำเป็น</span><span class="lang-en">Eliminate unnecessary power consumption.</span></p>
          </div>
        </div>

        <!-- 4. ติดตามข้อมูลแบบ Real-time -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 flex items-start gap-4 shadow-sm hover:border-brand transition-all">
          <span class="w-11 h-11 rounded-xl bg-brand/10 flex items-center justify-center flex-none text-brand font-bold text-lg"><i class="fa-solid fa-eye"></i></span>
          <div>
            <div class="se-card-t text-ink mb-1">
              <span class="lang-th">ติดตามข้อมูลแบบ Real-time</span>
              <span class="lang-en">Real-Time Visibility</span>
            </div>
            <p class="se-card-p text-muted"><span class="lang-th">มองเห็นสถานะการใช้ไฟฟ้าและการผลิตไฟได้ทันทีตลอด 24 ชม.</span><span class="lang-en">Complete instant clarity into energy metrics.</span></p>
          </div>
        </div>

        <!-- 5. บริหารจัดการทุกไซต์จากศูนย์กลาง -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 flex items-start gap-4 shadow-sm hover:border-brand transition-all">
          <span class="w-11 h-11 rounded-xl bg-brand/10 flex items-center justify-center flex-none text-brand font-bold text-lg"><i class="fa-solid fa-network-wired"></i></span>
          <div>
            <div class="se-card-t text-ink mb-1">
              <span class="lang-th">บริหารจัดการทุกไซต์จากศูนย์กลาง</span>
              <span class="lang-en">Manage Unlimited Sites</span>
            </div>
            <p class="se-card-p text-muted"><span class="lang-th">ควบคุมทุกโรงงานและทุกสาขาผ่านแดชบอร์ดเดียว</span><span class="lang-en">Scale management across all locations.</span></p>
          </div>
        </div>

        <!-- 6. แก้ไขปัญหาได้รวดเร็วยิ่งขึ้น -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 flex items-start gap-4 shadow-sm hover:border-brand transition-all">
          <span class="w-11 h-11 rounded-xl bg-brand/10 flex items-center justify-center flex-none text-brand font-bold text-lg"><i class="fa-solid fa-wrench"></i></span>
          <div>
            <div class="se-card-t text-ink mb-1">
              <span class="lang-th">แก้ไขปัญหาได้รวดเร็วยิ่งขึ้น</span>
              <span class="lang-en">Faster Issue Resolution</span>
            </div>
            <p class="se-card-p text-muted"><span class="lang-th">ระบบแจ้งเตือนความผิดปกติเพื่อการบำรุงรักษาอย่างทันท่วงที</span><span class="lang-en">Detect and fix anomalies quickly.</span></p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= 8. โซลูชันนี้เหมาะกับใคร ================= -->
  <section id="energy-audience" class="py-12 sm:py-16 bg-white" style="scroll-margin-top:96px">
    <div class="se-shell">
      <p class="se-eyebrow text-center mb-2">
        <span class="lang-th">โซลูชันนี้เหมาะกับใคร</span>
        <span class="lang-en">WHO IS THIS FOR?</span>
      </p>
      <!-- หัวข้อ -->
      <h2 class="se-h2 font-display text-ink text-center mb-10">
        <span class="lang-th">ออกแบบมาเพื่อธุรกิจที่ต้องการบริหารจัดการพลังงานอย่างมีประสิทธิภาพ</span>
        <span class="lang-en">Built for Businesses That Want Energy Under Control</span>
      </h2>

      <div class="se-grid se-c5" style="gap:clamp(14px,1.5vw,22px)">

        <!-- 1. บริษัทรับติดตั้ง Solar Rooftop -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden hover:border-brand hover:shadow-lg transition-all flex flex-col">
          <div class="w-full bg-slate-100 overflow-hidden" style="aspect-ratio:16/11">
            <img loading="lazy" decoding="async" class="w-full h-full object-cover" src="<?php echo get_template_directory_uri(); ?>/image/ind_energy_solar.png" alt="บริษัทรับติดตั้ง Solar Rooftop">
          </div>
          <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
              <div class="se-card-t text-ink mb-2">
                <span class="lang-th">บริษัทรับติดตั้ง Solar Rooftop</span>
                <span class="lang-en">Solar EPC</span>
              </div>
              <p class="se-card-p text-muted">
                <span class="lang-th">บริหารจัดการระบบ Solar ของลูกค้าทุกโครงการจากแพลตฟอร์มเดียว รองรับ Inverter หลายแบรนด์ พร้อมกำหนดสิทธิ์ให้เจ้าของโครงการเข้าถึงข้อมูลของตนเอง</span>
                <span class="lang-en">Provide one monitoring platform for every customer. Supports multi-brand inverters and customer permission management.</span>
              </p>
            </div>
          </div>
        </div>

        <!-- 2. โรงงานอุตสาหกรรม -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden hover:border-brand hover:shadow-lg transition-all flex flex-col">
          <div class="w-full bg-slate-100 overflow-hidden" style="aspect-ratio:16/11">
            <img loading="lazy" decoding="async" class="w-full h-full object-cover" src="<?php echo get_template_directory_uri(); ?>/image/ind_industrial_new.jpg" alt="โรงงานอุตสาหกรรม (โรงงานพร้อม Solar Roof)">
          </div>
          <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
              <div class="se-card-t text-ink mb-2">
                <span class="lang-th">โรงงานอุตสาหกรรม</span>
                <span class="lang-en">Manufacturing</span>
              </div>
              <p class="se-card-p text-muted">
                <span class="lang-th">ติดตามการใช้ไฟฟ้า การผลิตไฟจาก Solar และควบคุมอุปกรณ์ไฟฟ้าแบบ Real-time เพื่อช่วยลดต้นทุนด้านพลังงาน</span>
                <span class="lang-en">Monitor factory energy and solar generation in real time to reduce operational electricity expenses.</span>
              </p>
            </div>
          </div>
        </div>

        <!-- 3. อาคารสำนักงาน -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden hover:border-brand hover:shadow-lg transition-all flex flex-col">
          <div class="w-full bg-slate-100 overflow-hidden" style="aspect-ratio:16/11">
            <img loading="lazy" decoding="async" class="w-full h-full object-cover" src="<?php echo get_template_directory_uri(); ?>/image/ind_smart_building_new.jpg" alt="อาคารสำนักงาน">
          </div>
          <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
              <div class="se-card-t text-ink mb-2">
                <span class="lang-th">อาคารสำนักงาน</span>
                <span class="lang-en">Commercial Buildings</span>
              </div>
              <p class="se-card-p text-muted">
                <span class="lang-th">ควบคุมระบบแสงสว่างและอุปกรณ์ไฟฟ้า กำหนดเวลาเปิด–ปิดอัตโนมัติ และติดตามการใช้พลังงานของทั้งอาคาร</span>
                <span class="lang-en">Optimize electricity consumption automatically with smart lighting and automated schedule controls.</span>
              </p>
            </div>
          </div>
        </div>

        <!-- 4. ธุรกิจค้าปลีกและร้านแฟรนไชส์ -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden hover:border-brand hover:shadow-lg transition-all flex flex-col">
          <div class="w-full bg-slate-100 overflow-hidden" style="aspect-ratio:16/11">
            <img loading="lazy" decoding="async" class="w-full h-full object-cover" src="<?php echo get_template_directory_uri(); ?>/image/ind_smart_building.png" alt="ธุรกิจค้าปลีกและร้านแฟรนไชส์">
          </div>
          <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
              <div class="se-card-t text-ink mb-2">
                <span class="lang-th">ธุรกิจค้าปลีกและร้านแฟรนไชส์</span>
                <span class="lang-en">Retail &amp; Franchise</span>
              </div>
              <p class="se-card-p text-muted">
                <span class="lang-th">สำนักงานใหญ่สามารถติดตามข้อมูลการใช้พลังงานและการผลิตไฟฟ้าของทุกสาขาได้จากศูนย์กลาง พร้อมกำหนดสิทธิ์ให้ผู้จัดการแต่ละสาขาเข้าถึงเฉพาะข้อมูลของตนเอง</span>
                <span class="lang-en">Monitor all branches from headquarters while allowing branch managers to access only their own locations.</span>
              </p>
            </div>
          </div>
        </div>

        <!-- 5. เจ้าของโครงการอสังหาริมทรัพย์ -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden hover:border-brand hover:shadow-lg transition-all flex flex-col">
          <div class="w-full bg-slate-100 overflow-hidden" style="aspect-ratio:16/11">
            <img loading="lazy" decoding="async" class="w-full h-full object-cover" src="<?php echo get_template_directory_uri(); ?>/image/hero-mypv-building.jpg" alt="เจ้าของโครงการอสังหาริมทรัพย์">
          </div>
          <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
              <div class="se-card-t text-ink mb-2">
                <span class="lang-th">เจ้าของโครงการอสังหาริมทรัพย์</span>
                <span class="lang-en">Property Developers</span>
              </div>
              <p class="se-card-p text-muted">
                <span class="lang-th">บริหารจัดการพลังงานของหลายอาคาร หลายโครงการ และติดตามข้อมูลได้จากแพลตฟอร์มเดียว</span>
                <span class="lang-en">Centralized energy management for every building and property development project.</span>
              </p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- FOOTER CONTAINER -->
  <div id="footer-container" class="bg-ink w-full block"></div>

  <!-- Scripts -->
  <script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/scripts.js') : './components/scripts.js'; ?>"></script>

  <?php wp_footer(); ?>
</body>

</html>
