<?php
/* Template Name: About Us */
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
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us · Engineering Intelligence Since 2008 | Synergy Group</title>
  <meta name="description" content="For more than 18 years, Synergy Group has evolved into an Engineering Intelligence Company — integrating hardware, embedded systems, AI, and digital platforms to build intelligent solutions with lasting business impact.">
  
  <link rel="canonical" href="<?php echo home_url('/about/'); ?>">
  <meta name="robots" content="index,follow">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Synergy Technology">
  <meta property="og:title" content="About Us · Engineering Intelligence Since 2008 | Synergy Group">
  <meta property="og:description" content="For more than 18 years, Synergy Group has evolved into an Engineering Intelligence Company — integrating hardware, embedded systems, AI, and digital platforms.">
  <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/image/about-hero-bg.png">
  <meta property="og:url" content="<?php echo home_url('/about/'); ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="About Us · Engineering Intelligence Since 2008 | Synergy Group">
  <meta name="twitter:description" content="18+ years from electronics engineering to the SynExta Intelligence Engine.">
  <meta name="twitter:image" content="<?php echo get_template_directory_uri(); ?>/image/about-hero-bg.png">

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
    /* Glow Animations */
    @keyframes pulse-glow {
      0%, 100% { transform: scale(1); opacity: 0.8; }
      50% { transform: scale(1.05); opacity: 1; filter: drop-shadow(0 0 25px rgba(35, 134, 45, 0.8)); }
    }
    .animate-pulse-glow {
      animation: pulse-glow 4s ease-in-out infinite;
    }
    @media (prefers-reduced-motion: reduce) {
      html { scroll-behavior: auto; }
      .animate-pulse-glow { animation: none; }
      #synexta-engine svg animate,
      #synexta-engine svg animateMotion,
      #synexta-engine svg animateTransform { display: none; }
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

  <style>
    /* Fluid heading sizes for this page.
       components/style.css sizes type with attribute selectors like [class*="text-4xl"]
       plus !important, and those also match the responsive variants (sm:text-4xl,
       lg:text-6xl). The largest declared step therefore wins at EVERY breakpoint, which
       left section headings at 47-60px on a 390px phone. These clamps restore a real
       fluid scale without touching the shared stylesheet. */
    #about-hero h1{font-size:clamp(30px,5.6vw,60px) !important;line-height:1.15 !important}
    #dna h2,
    #what-we-build h2,
    #why-trust h2{font-size:clamp(22px,2.78vw,44px) !important;line-height:1.2 !important}

    /* ---- Edit-mode reveals ----
       Two things on this page are hidden at any given moment by design, and both
       hold editable copy. contentEditable cannot reach a display:none node, so
       edit mode un-hides them; normal visitors are unaffected. */

    /* The inactive language. scripts.js hides it with
       `html[lang="th"] .lang-en{display:none!important}`, so this needs both the
       higher specificity and !important to win. */
    html body.is-live-editing [data-editable] .lang-th,
    html body.is-live-editing [data-editable] .lang-en{display:inline !important}

    /* The chip stack, which is the source of the SynExta diagram's labels. It is
       display:none above 1180px, i.e. exactly where the diagram is on screen. */
    body.is-live-editing .synexta-stack{display:block !important;width:100%}
  </style>

  <!-- HERO SECTION: About SynTech / Engineering Intelligence Since 2008 -->
  <section id="about-hero" class="relative pt-4 pb-8 sm:pt-6 sm:pb-12 lg:pt-8 lg:pb-16 text-slate-900 overflow-hidden bg-slate-50 min-h-[560px] sm:min-h-[640px] lg:min-h-[720px] flex items-start justify-center">
    <!-- Background Image Layer (พื้นหลังabout.png) - No dark filter overlay -->
    <div class="absolute inset-0 z-0 overflow-hidden hero-bg-layer">
      <!-- Focal point moves with the breakpoint. The photo is 1920x691 (2.78:1); a phone
           only ever shows ~26% of its width, so the desktop 92% anchor would crop the
           SYNERGY building out of frame entirely and leave nothing but the far-right trees. -->
      <img id="about-hero-bg-img" data-editable-img="hero_bg" loading="eager" fetchpriority="high" decoding="async" class="w-full h-full object-cover object-[30%_center] sm:object-[55%_center] lg:object-[92%_center] scale-100 transition-transform duration-700" src="<?php echo synergy_content('hero_bg_img', get_template_directory_uri() . '/พื้นหลังabout.png', 'about'); ?>" alt="Engineering Intelligence Ecosystem Journey Background">
    </div>

    <!-- Legibility scrim (below lg only). On desktop the copy lands on open sky, but the
         tighter mobile/tablet crop puts the dark paragraph over the building, where the
         measured backdrop drops to ~12% luminance. -->
    <div class="absolute inset-0 z-[1] pointer-events-none lg:hidden bg-gradient-to-b from-white/85 via-white/65 to-white/15"></div>

    <!-- Grid Overlay Effect -->
    <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#23862D_1px,transparent_1px)] [background-size:32px_32px] pointer-events-none z-0"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10 w-full text-center">
      <div class="max-w-6xl mx-auto space-y-4 flex flex-col items-center justify-center">

        <h1 data-editable="hero-title" <?php echo synergy_style('hero-title', 'about'); ?> class="font-display font-extrabold text-2xl sm:text-4xl lg:text-[44px] tracking-tight leading-none text-[#F2C72E] drop-shadow-[0_2px_10px_rgba(0,0,0,0.15)] text-center sm:whitespace-nowrap w-full mx-auto">
          <?php echo synergy_content('hero-title', 'Engineering Intelligence <span class="text-brand-bright drop-shadow-[0_2px_15px_rgba(35,134,45,0.4)]">Since 2008</span>', 'about'); ?>
        </h1>

        <p data-editable="hero-desc" <?php echo synergy_style('hero-desc', 'about'); ?> class="text-sm sm:text-base text-slate-900 font-medium leading-relaxed max-w-4xl text-center mx-auto">
          <?php echo synergy_content('hero-desc', '<span class="lang-th">กว่า 18 ปีที่เราพัฒนาจากงานวิศวกรรมอิเล็กทรอนิกส์ สู่บริษัทด้าน Engineering Intelligence<br>ผสานฮาร์ดแวร์ ระบบสมองกลฝังตัว AI และดิจิทัลแพลตฟอร์ม เพื่อสร้างโซลูชันอัจฉริยะที่ส่งมอบผลลัพธ์ยั่งยืน</span><span class="lang-en">For more than 18 years, we&#39;ve evolved from electronics engineering into an Engineering Intelligence Company<br>integrating hardware, embedded systems, AI, and digital platforms to build intelligent solutions.</span>', 'about'); ?>
        </p>

        <!-- Buttons Row (Placed further down near bottom center) -->
        <div class="flex flex-wrap items-center justify-center gap-4 pt-24 sm:pt-36 lg:pt-48 w-full">
          <a data-editable="hero-btn1" <?php echo synergy_style('hero-btn1', 'about'); ?> href="<?php echo home_url('/'); ?>#solutions" class="inline-flex items-center gap-2.5 bg-brand-bright text-white px-7 py-3.5 rounded-xl font-extrabold text-sm uppercase tracking-wider hover:bg-emerald-600 transition-all duration-200 shadow-lg shadow-brand-bright/30 hover:-translate-y-0.5">
            <?php echo synergy_content('hero-btn1', '<span class="lang-th">สำรวจโซลูชันของเรา</span><span class="lang-en">Explore Our Solutions</span><i class="fa-solid fa-arrow-right text-xs ml-1"></i>', 'about'); ?>
          </a>
          <a data-editable="hero-btn2" <?php echo synergy_style('hero-btn2', 'about'); ?> href="<?php echo home_url('/'); ?>#contact" class="inline-flex items-center gap-2.5 bg-slate-900 hover:bg-slate-800 text-white border border-slate-900 px-7 py-3.5 rounded-xl font-extrabold text-sm uppercase tracking-wider transition-all duration-200 hover:-translate-y-0.5 shadow-md">
            <?php echo synergy_content('hero-btn2', '<i class="fa-regular fa-bookmark text-xs text-gold-bright mr-1"></i><span class="lang-th">พูดคุยกับทีมผู้เชี่ยวชาญ</span><span class="lang-en">Talk to Our Experts</span>', 'about'); ?>
          </a>
        </div>

      </div>
    </div>
  </section>

  <!-- SECTION: OUR FOUNDATION (FOUNDATIONAL PRINCIPLES & OUR DNA) -->
  <section id="principles" class="py-14 sm:py-20 bg-[#f8faf9] relative border-b border-slate-100 overflow-hidden" style="scroll-margin-top: 96px;">
    <!-- Decorative top curve cutout matching reference image top-left -->
    <div class="absolute top-0 left-0 w-24 h-8 bg-white rounded-br-2xl hidden sm:block"></div>
    
    <!-- Background image container for top section header (Solar panels/turbines on left, high-tech factory on right) -->
    <div class="absolute inset-x-0 top-0 h-96 opacity-20 pointer-events-none overflow-hidden">
      <img src="<?php echo get_template_directory_uri(); ?>/image/foundation_header_bg.png" alt="Foundation background" class="w-full h-full object-cover object-center">
      <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#f8faf9]/80 to-[#f8faf9]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
      
      <!-- Section Header -->
      <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-14">
        <!-- Eyebrow + Green dash line -->
        <span class="text-xs sm:text-sm font-extrabold text-[#0d5c3a] uppercase tracking-widest block mb-1">
          <span class="lang-th">OUR FOUNDATION</span>
          <span class="lang-en">OUR FOUNDATION</span>
        </span>
        <div class="w-8 h-1 bg-[#0d5c3a] rounded-full mx-auto mb-5"></div>

        <!-- Main Title -->
        <h2 class="font-display font-extrabold text-2xl sm:text-3xl lg:text-[36px] leading-tight text-slate-900 tracking-tight whitespace-nowrap">
          Engineering Intelligence <span class="text-[#0d5c3a]">Starts with Strong Principles</span>
        </h2>
      </div>

      <!-- TOP ROW: VISION & MISSION CARDS (2-Column Grid) -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 items-stretch mb-6 sm:mb-8">

        <!-- CARD 1: VISION -->
        <div class="relative bg-white rounded-[28px] overflow-hidden border border-slate-200/80 shadow-lg shadow-slate-200/40 flex flex-col justify-between group min-h-[320px] sm:min-h-[340px] transition-all duration-300 hover:shadow-xl hover:border-emerald-300">
          <!-- Card Background Image -->
          <div class="absolute inset-0 z-0">
            <img src="<?php echo get_template_directory_uri(); ?>/image/2026-syngroup-company-profile.png" alt="Vision Background" class="w-full h-full object-fill transition-transform duration-700 group-hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/80 to-white/30 sm:to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-white via-white/50 to-transparent sm:hidden"></div>
          </div>

          <!-- Card Content -->
          <div class="relative z-10 p-6 sm:p-8 flex flex-col justify-between h-full">
            <div>
              <!-- Header Row (Icon + Tag) -->
              <div class="flex items-center gap-3.5 mb-5">
                <div class="w-12 h-12 rounded-full bg-emerald-50 text-[#0d5c3a] border border-emerald-100/80 flex items-center justify-center shrink-0 shadow-xs">
                  <i class="fa-solid fa-bullseye text-xl"></i>
                </div>
                <span class="font-extrabold text-[#0d5c3a] text-xl sm:text-2xl uppercase tracking-wider">VISION</span>
              </div>

              <!-- Description -->
              <p class="text-slate-600 text-sm sm:text-base font-normal leading-relaxed max-w-md">
                <span class="lang-th">มุ่งสู่การเป็นผู้นำด้านการพัฒนา <span class="text-[#0d5c3a] font-bold">Smart Electronics และ AIoT Solutions</span> แบบครบวงจร เพื่อสร้างผลลัพธ์ทางธุรกิจ ที่เติบโตอย่างยั่งยืน</span>
                <span class="lang-en">To be a leading innovator in end-to-end <span class="text-[#0d5c3a] font-bold">Smart Electronics and AIoT Solutions</span> for sustainable business impact.</span>
              </p>
            </div>
          </div>
        </div>

        <!-- CARD 2: MISSION -->
        <div class="relative bg-white rounded-[28px] overflow-hidden border border-slate-200/80 shadow-lg shadow-slate-200/40 flex flex-col justify-between group min-h-[320px] sm:min-h-[340px] transition-all duration-300 hover:shadow-xl hover:border-emerald-300">
          <!-- Card Background Image -->
          <div class="absolute inset-0 z-0">
            <img src="<?php echo get_template_directory_uri(); ?>/image/mission_bg_engineer.png" alt="Mission Background" class="w-full h-full object-cover object-right-bottom transition-transform duration-700 group-hover:scale-105">
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/90 to-white/30 sm:to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-white via-white/40 to-transparent sm:hidden"></div>
          </div>

          <!-- Card Content -->
          <div class="relative z-10 p-6 sm:p-8 flex flex-col justify-between h-full">
            <div>
              <!-- Header Row (Icon + Tag) -->
              <div class="flex items-center gap-3.5 mb-5">
                <div class="w-12 h-12 rounded-full bg-[#0d5c3a] text-white flex items-center justify-center shrink-0 shadow-md shadow-[#0d5c3a]/20">
                  <i class="fa-solid fa-bullseye text-xl"></i>
                </div>
                <span class="font-extrabold text-[#0d5c3a] text-xl sm:text-2xl uppercase tracking-wider">MISSION</span>
              </div>

              <!-- Description -->
              <p class="text-slate-600 text-sm sm:text-base font-normal leading-relaxed max-w-md">
                <span class="lang-th">มุ่งมั่นเป็น พาร์ทเนอร์ด้านวิศวกรรมครบวงจร ให้บริการตั้งแต่การสร้างนวัตกรรม การออกแบบ การพัฒนาต้นแบบ (NPI) การผลิต และบริการหลังการขาย พร้อมส่งมอบ Smart Electronics และ AIoT Solutions ที่เชื่อถือได้ เพื่อสร้างคุณค่าและการเติบโตอย่างยั่งยืน ให้กับทั้งภาครัฐและภาคเอกชน</span>
                <span class="lang-en">To serve as a trusted end-to-end engineering partner from innovation, design, NPI to manufacturing and after-sales service, delivering reliable Smart Electronics and AIoT Solutions that create lasting value and sustainable growth for public and private sectors.</span>
              </p>
            </div>
          </div>
        </div>

      </div>

      <!-- MIDDLE ROW: CORE VALUES & OUR DNA CARDS (2-Column Grid) -->
      <div id="foundation-values" class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 items-stretch mt-8" style="scroll-margin-top: 96px;">

        <!-- CARD 3: CORE VALUES -->
        <div class="bg-white rounded-[28px] p-6 sm:p-8 border border-slate-200/80 shadow-lg shadow-slate-200/40 flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:border-emerald-300">
          <div>
            <!-- Header -->
            <div class="text-center mb-6 sm:mb-8">
              <h3 class="font-extrabold text-xl sm:text-2xl text-[#0d5c3a] uppercase tracking-wider mb-1">CORE VALUES</h3>
              <p class="text-slate-500 text-xs sm:text-sm font-medium">
                <span class="lang-th">คุณค่าที่เราเชื่อและยึดถือในการทำงาน</span>
                <span class="lang-en">Values we believe in and hold firmly in our work</span>
              </p>
            </div>

            <!-- 8 Values Grid (2 rows x 4 cols on desktop, 2 cols on mobile) -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 text-center">
              
              <!-- 1. Possibility -->
              <div class="flex flex-col items-center p-2 rounded-xl transition-colors hover:bg-slate-50">
                <div class="w-11 h-11 rounded-full bg-emerald-50 text-[#0d5c3a] border border-emerald-100/80 flex items-center justify-center mb-2 shadow-xs">
                  <i class="fa-solid fa-mountain text-lg"></i>
                </div>
                <h5 class="font-bold text-xs sm:text-sm text-slate-800 mb-0.5">Possibility</h5>
                <p class="text-[11px] leading-tight text-slate-500 max-w-[125px]">
                  <span class="lang-th">เชื่อว่าทุกความท้าทายมีทางออก</span>
                  <span class="lang-en">Believe every challenge has a solution.</span>
                </p>
              </div>

              <!-- 2. Ownership -->
              <div class="flex flex-col items-center p-2 rounded-xl transition-colors hover:bg-slate-50">
                <div class="w-11 h-11 rounded-full bg-emerald-50 text-[#0d5c3a] border border-emerald-100/80 flex items-center justify-center mb-2 shadow-xs">
                  <i class="fa-regular fa-user text-lg"></i>
                </div>
                <h5 class="font-bold text-xs sm:text-sm text-slate-800 mb-0.5">Ownership</h5>
                <p class="text-[11px] leading-tight text-slate-500 max-w-[125px]">
                  <span class="lang-th">รับผิดชอบในงานเสมือนเป็นเจ้าของธุรกิจ</span>
                  <span class="lang-en">Take responsibility like an owner.</span>
                </p>
              </div>

              <!-- 3. Successor -->
              <div class="flex flex-col items-center p-2 rounded-xl transition-colors hover:bg-slate-50">
                <div class="w-11 h-11 rounded-full bg-emerald-50 text-[#0d5c3a] border border-emerald-100/80 flex items-center justify-center mb-2 shadow-xs">
                  <i class="fa-solid fa-users text-lg"></i>
                </div>
                <h5 class="font-bold text-xs sm:text-sm text-slate-800 mb-0.5">Successor</h5>
                <p class="text-[11px] leading-tight text-slate-500 max-w-[125px]">
                  <span class="lang-th">ส่งต่อความรู้และสร้างคนรุ่นใหม่</span>
                  <span class="lang-en">Grow the next generation.</span>
                </p>
              </div>

              <!-- 4. Sincere -->
              <div class="flex flex-col items-center p-2 rounded-xl transition-colors hover:bg-slate-50">
                <div class="w-11 h-11 rounded-full bg-emerald-50 text-[#0d5c3a] border border-emerald-100/80 flex items-center justify-center mb-2 shadow-xs">
                  <i class="fa-regular fa-handshake text-lg"></i>
                </div>
                <h5 class="font-bold text-xs sm:text-sm text-slate-800 mb-0.5">Sincere</h5>
                <p class="text-[11px] leading-tight text-slate-500 max-w-[125px]">
                  <span class="lang-th">จริงใจ ซื่อสัตย์ และสร้างความไว้วางใจ</span>
                  <span class="lang-en">Build trust through honesty.</span>
                </p>
              </div>

              <!-- 5. Ideation -->
              <div class="flex flex-col items-center p-2 rounded-xl transition-colors hover:bg-slate-50">
                <div class="w-11 h-11 rounded-full bg-emerald-50 text-[#0d5c3a] border border-emerald-100/80 flex items-center justify-center mb-2 shadow-xs">
                  <i class="fa-regular fa-lightbulb text-lg"></i>
                </div>
                <h5 class="font-bold text-xs sm:text-sm text-slate-800 mb-0.5">Ideation</h5>
                <p class="text-[11px] leading-tight text-slate-500 max-w-[125px]">
                  <span class="lang-th">กล้าคิด กล้าสร้างสรรค์นวัตกรรม</span>
                  <span class="lang-en">Think differently and create.</span>
                </p>
              </div>

              <!-- 6. Be Better -->
              <div class="flex flex-col items-center p-2 rounded-xl transition-colors hover:bg-slate-50">
                <div class="w-11 h-11 rounded-full bg-emerald-50 text-[#0d5c3a] border border-emerald-100/80 flex items-center justify-center mb-2 shadow-xs">
                  <i class="fa-solid fa-chart-line text-lg"></i>
                </div>
                <h5 class="font-bold text-xs sm:text-sm text-slate-800 mb-0.5">Be Better</h5>
                <p class="text-[11px] leading-tight text-slate-500 max-w-[125px]">
                  <span class="lang-th">พัฒนาและปรับปรุงอย่างต่อเนื่อง</span>
                  <span class="lang-en">Improve every day.</span>
                </p>
              </div>

              <!-- 7. Learner -->
              <div class="flex flex-col items-center p-2 rounded-xl transition-colors hover:bg-slate-50">
                <div class="w-11 h-11 rounded-full bg-emerald-50 text-[#0d5c3a] border border-emerald-100/80 flex items-center justify-center mb-2 shadow-xs">
                  <i class="fa-solid fa-graduation-cap text-lg"></i>
                </div>
                <h5 class="font-bold text-xs sm:text-sm text-slate-800 mb-0.5">Learner</h5>
                <p class="text-[11px] leading-tight text-slate-500 max-w-[125px]">
                  <span class="lang-th">เรียนรู้สิ่งใหม่อยู่เสมอ</span>
                  <span class="lang-en">Never stop learning.</span>
                </p>
              </div>

              <!-- 8. Empathy -->
              <div class="flex flex-col items-center p-2 rounded-xl transition-colors hover:bg-slate-50">
                <div class="w-11 h-11 rounded-full bg-emerald-50 text-[#0d5c3a] border border-emerald-100/80 flex items-center justify-center mb-2 shadow-xs">
                  <i class="fa-regular fa-user text-lg"></i>
                </div>
                <h5 class="font-bold text-xs sm:text-sm text-slate-800 mb-0.5">Empathy</h5>
                <p class="text-[11px] leading-tight text-slate-500 max-w-[125px]">
                  <span class="lang-th">เข้าใจลูกค้าและเพื่อนร่วมงาน</span>
                  <span class="lang-en">Understand people before solving problems.</span>
                </p>
              </div>

            </div>
          </div>
        </div>

        <!-- CARD 4: OUR DNA -->
        <div id="dna" class="bg-white rounded-[28px] p-6 sm:p-8 border border-slate-200/80 shadow-lg shadow-slate-200/40 flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:border-emerald-300" style="scroll-margin-top: 96px;">
          <div>
            <!-- Header -->
            <div class="text-center mb-6">
              <h3 class="font-extrabold text-xl sm:text-2xl text-[#0d5c3a] uppercase tracking-wider mb-1">OUR DNA</h3>
              <p class="text-slate-500 text-xs sm:text-sm font-medium">
                The Principles That Drive Every Solution
              </p>
            </div>

            <!-- 3 DNA Items Stack -->
            <div class="space-y-4">
              
              <!-- Item 1: INNOVATIVE -->
              <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-start gap-3.5 transition-colors hover:bg-emerald-50/50">
                <div class="w-10 h-10 rounded-xl bg-emerald-100/80 text-[#0d5c3a] flex items-center justify-center shrink-0 mt-0.5">
                  <i class="fa-regular fa-lightbulb text-base"></i>
                </div>
                <div>
                  <div class="flex items-center gap-2 mb-1">
                    <span class="text-[11px] font-extrabold text-[#0d5c3a] uppercase tracking-wider">INNOVATIVE</span>
                    <span class="text-slate-300">•</span>
                    <h5 class="font-bold text-xs sm:text-sm text-slate-900">We Never Stop Innovating</h5>
                  </div>
                  <p class="text-xs text-slate-600 leading-relaxed">
                    <span class="lang-th">เราพัฒนาเทคโนโลยีอย่างต่อเนื่อง ตั้งแต่อุปกรณ์อิเล็กทรอนิกส์ไปจนถึงแพลตฟอร์ม AI เพื่อสร้างนวัตกรรมที่ตอบโจทย์อนาคตของธุรกิจ</span>
                    <span class="lang-en">From electronics engineering to AI-powered platforms, we continuously create technologies that solve tomorrow's challenges.</span>
                  </p>
                </div>
              </div>

              <!-- Item 2: TRUSTED -->
              <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-start gap-3.5 transition-colors hover:bg-emerald-50/50">
                <div class="w-10 h-10 rounded-xl bg-emerald-100/80 text-[#0d5c3a] flex items-center justify-center shrink-0 mt-0.5">
                  <i class="fa-solid fa-shield-halved text-base"></i>
                </div>
                <div>
                  <div class="flex items-center gap-2 mb-1">
                    <span class="text-[11px] font-extrabold text-[#0d5c3a] uppercase tracking-wider">TRUSTED</span>
                    <span class="text-slate-300">•</span>
                    <h5 class="font-bold text-xs sm:text-sm text-slate-900">Built on Engineering Excellence</h5>
                  </div>
                  <p class="text-xs text-slate-600 leading-relaxed">
                    <span class="lang-th">ทุกโซลูชันถูกสร้างขึ้นบนพื้นฐานของวิศวกรรมที่เชื่อถือได้ คุณภาพที่พิสูจน์ได้ และความมุ่งมั่นในการเป็นพันธมิตรระยะยาว</span>
                    <span class="lang-en">Our customers trust us because every solution is backed by proven engineering, quality, and long-term commitment.</span>
                  </p>
                </div>
              </div>

              <!-- Item 3: IMPACTFUL -->
              <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-start gap-3.5 transition-colors hover:bg-emerald-50/50">
                <div class="w-10 h-10 rounded-xl bg-emerald-100/80 text-[#0d5c3a] flex items-center justify-center shrink-0 mt-0.5">
                  <i class="fa-solid fa-chart-line text-base"></i>
                </div>
                <div>
                  <div class="flex items-center gap-2 mb-1">
                    <span class="text-[11px] font-extrabold text-[#0d5c3a] uppercase tracking-wider">IMPACTFUL</span>
                    <span class="text-slate-300">•</span>
                    <h5 class="font-bold text-xs sm:text-sm text-slate-900">Technology That Creates Business Impact</h5>
                  </div>
                  <p class="text-xs text-slate-600 leading-relaxed">
                    <span class="lang-th">เราไม่ได้สร้างเทคโนโลยีเพื่อเทคโนโลยี แต่สร้างผลลัพธ์ที่ช่วยเพิ่มประสิทธิภาพ ลดต้นทุน และสร้างการเติบโตอย่างยั่งยืน</span>
                    <span class="lang-en">We don't build technology for technology's sake. We engineer solutions that improve productivity, reduce costs, and enable sustainable growth.</span>
                  </p>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>

      <!-- FULL-WIDTH ROW: COMMITMENT BANNER CARD -->
      <div id="commitment" class="mt-6 lg:mt-8 bg-white rounded-[28px] p-6 sm:p-8 border border-slate-200/80 shadow-lg shadow-slate-200/40 text-center transition-all duration-300 hover:shadow-xl hover:border-emerald-300" style="scroll-margin-top: 96px;">
        <div class="max-w-4xl mx-auto">
          <div class="w-12 h-12 rounded-full bg-[#0d5c3a] text-white flex items-center justify-center mx-auto mb-4 shadow-md shadow-[#0d5c3a]/20">
            <i class="fa-solid fa-handshake-angle text-xl"></i>
          </div>
          <h3 class="font-extrabold text-xl sm:text-2xl text-[#0d5c3a] uppercase tracking-wider mb-3">COMMITMENT</h3>
          <p class="text-slate-600 text-sm sm:text-base font-normal leading-relaxed">
            <span class="lang-th">เรามุ่งมั่นส่งมอบผลิตภัณฑ์และบริการที่ดีที่สุด สร้างความร่วมมือระยะยาวกับลูกค้า และสร้างผลลัพธ์ที่ยั่งยืนให้กับธุรกิจ บุคลากร และสังคม ด้วยคุณภาพ นวัตกรรม และการพัฒนาอย่างต่อเนื่อง</span>
            <span class="lang-en">We are committed to delivering the best products and services, building long-term partnerships with customers, and creating sustainable value for business, people, and society through quality, innovation, and continuous improvement.</span>
          </p>
        </div>
      </div>

    </div>
  </section>

  <!-- SECTION 3: OUR JOURNEY (rebuilt to match the SynExta Canva reference: glow cards + overlapping badge icons) -->
  <section id="journey" class="py-10 sm:py-14 bg-white relative overflow-hidden" style="scroll-margin-top: 96px;">
    <style>
      .journey-timeline-wrap{
        --green:#187b4a;
        --green-dark:#146237;
        --green-line:#4f9d70;
        --ink:#0b2127;
        --body:#6b7280;
        --bub:clamp(72px,7vw,104px);   /* badge size; the rail position and card padding derive from it */
        --gap:clamp(10px,1.5vw,22px);  /* grid gap; the rail maths needs it as a value, not a literal */
        position:relative;z-index:2;
      }
      .journey-timeline-wrap .eyebrow{
        text-align:center;margin:0 0 14px;
        font-size:clamp(12.5px,1.1vw,15px);font-weight:700;letter-spacing:.14em;text-transform:uppercase;
        color:var(--green);
      }
      .journey-timeline-wrap h2{
        text-align:center;margin:0 0 22px;
        /* สูตรเดียวกับ h2 ของทุก section ทั้งไซต์: 22px @390 / 40px @1440 / 44px @1920 */
        font-size:clamp(22px,2.78vw,44px);font-weight:800;letter-spacing:-.02em;line-height:1.2;color:var(--ink);
      }
      /* Heading ornament: two rails fading outward, each capped with a dot */
      .journey-timeline-wrap .head-rail{
        display:flex;align-items:center;justify-content:center;
        margin:0 0 clamp(50px,5.4vw,84px);
      }
      .journey-timeline-wrap .head-rail i{display:block;height:2px;width:min(33%,428px);border-radius:2px}
      .journey-timeline-wrap .head-rail i:first-of-type{background:linear-gradient(90deg,rgba(24,123,74,0),var(--green))}
      .journey-timeline-wrap .head-rail i:last-of-type{background:linear-gradient(270deg,rgba(24,123,74,0),var(--green))}
      .journey-timeline-wrap .head-rail b{width:9px;height:9px;border-radius:50%;background:var(--green);flex:none}
      .journey-timeline-wrap .head-rail s{display:block;width:clamp(80px,12vw,165px);flex:none}

      /* --steps is set inline from count($journey_steps), so the column count and the
         rail inset follow the data instead of being hard-coded to a milestone count. */
      .journey-timeline-wrap .timeline{
        display:grid;
        grid-template-columns:repeat(var(--steps,6),1fr);
        gap:var(--gap);
        align-items:stretch;
        position:relative;
      }
      /* One grid column, as a length. Both the rail line and the rail dots are
         positioned from this; a plain percentage of the track is NOT the same thing
         once the gaps are taken out, which is what left the dots a few px off the
         mid-point between badges. */
      .journey-timeline-wrap .timeline{
        --col:calc((100% - (var(--steps,6) - 1) * var(--gap)) / var(--steps,6));
      }
      /* Dashed rail sits at badge-centre height; the opaque badges cover its ends.
         It starts and ends at the centre of the first/last column, i.e. half a
         column (50/--steps %) in from each edge. */
      .journey-timeline-wrap .rail{
        position:absolute;left:0;right:0;top:calc(var(--bub) / 2);height:0;
        pointer-events:none;z-index:1;
      }
      /* Runs from the centre of the first column to the centre of the last. */
      .journey-timeline-wrap .rail::before{
        content:"";position:absolute;top:-1px;height:2px;
        left:calc(var(--col) / 2);right:calc(var(--col) / 2);
        background:repeating-linear-gradient(90deg,var(--green-line) 0 5px,transparent 5px 10px);
        opacity:.9;
      }
      /* Dot k sits in the middle of the gap that follows column k, i.e. exactly
         halfway between badge k and badge k+1. */
      .journey-timeline-wrap .rail .dot{
        position:absolute;top:0;width:9px;height:9px;border-radius:50%;
        background:var(--green);transform:translate(-50%,-50%);
        left:calc(var(--k) * var(--col) + (var(--k) - 1) * var(--gap) + var(--gap) / 2);
      }

      .journey-timeline-wrap .step{position:relative;z-index:2;padding-top:calc(var(--bub) / 2)}
      .journey-timeline-wrap .card{
        height:100%;text-align:center;background:#fff;
        border:1px solid rgba(24,123,74,.10);
        border-radius:clamp(16px,1.7vw,24px);
        box-shadow:0 10px 34px rgba(24,123,74,.13), 0 2px 8px rgba(11,33,39,.05);
        padding:calc(var(--bub) / 2 + 16px) clamp(9px,1.1vw,17px) clamp(20px,2.2vw,30px);
        transition:transform .25s, box-shadow .25s;
      }
      .journey-timeline-wrap .step:hover .card{
        transform:translateY(-5px);
        box-shadow:0 16px 44px rgba(24,123,74,.20), 0 3px 10px rgba(11,33,39,.06);
      }
      .journey-timeline-wrap .badge{
        position:absolute;top:0;left:50%;transform:translateX(-50%);
        width:var(--bub);height:var(--bub);border-radius:50%;
        background:#fff;border:1px solid rgba(24,123,74,.12);
        box-shadow:0 6px 18px rgba(11,33,39,.10);
        display:flex;align-items:center;justify-content:center;
        z-index:3;transition:transform .25s;
      }
      .journey-timeline-wrap .badge::after{
        content:"";position:absolute;inset:7px;border-radius:50%;
        border:1.5px solid rgba(79,157,112,.30);
      }
      .journey-timeline-wrap .badge img{width:52%;height:52%;object-fit:contain;display:block;position:relative;z-index:1}
      .journey-timeline-wrap .step:hover .badge{transform:translateX(-50%) translateY(-4px)}

      /* highlighted "Today" node */
      .journey-timeline-wrap .step.is-now .card{
        border-color:rgba(24,123,74,.20);
        box-shadow:0 16px 44px rgba(24,123,74,.22), 0 3px 10px rgba(11,33,39,.06);
      }
      .journey-timeline-wrap .step.is-now .badge{
        background:linear-gradient(160deg,#2f9560 0%,#12673c 100%);
        border:5px solid #fff;
        box-shadow:0 8px 24px rgba(20,98,55,.34);
      }
      .journey-timeline-wrap .step.is-now .badge::after{inset:4px;border-color:rgba(255,255,255,.30)}
      .journey-timeline-wrap .step.is-now .year{color:var(--green-dark)}

      /* !important is required: components/style.css sets `p{font-size:1.075rem!important}`
         globally, which otherwise flattens year/name/desc to one identical size. */
      /* Sizes for the seven-across row only; the media queries below restate them
         for the wider columns of the wrapped layouts. */
      .journey-timeline-wrap .year{
        font-size:clamp(16px,1.45vw,21px) !important;line-height:1.2 !important;
        font-weight:700;color:var(--green);margin:0 0 6px;letter-spacing:.01em;
      }
      .journey-timeline-wrap .name{
        font-size:clamp(13.5px,1.18vw,17px) !important;line-height:1.3 !important;
        font-weight:600;margin:0 0 10px;color:var(--ink);
      }
      .journey-timeline-wrap .desc{
        font-size:clamp(12px,.95vw,13.5px) !important;line-height:1.5 !important;
        color:var(--body);margin:0;
      }

      /* soft green wave along the bottom of the section */
      .journey-wave{
        position:absolute;left:0;right:0;bottom:0;width:100%;height:auto;
        pointer-events:none;z-index:1;opacity:.9;
      }

      /* All seven on one row, then 4 / 2 / 1. The rail is only meaningful while the
         whole sequence sits on a single row, so it is hidden below that.
         The single-row threshold is 1320px: with seven columns inside a 1440px
         container each card is ~180px, and below that the milestone titles
         ("Expanded R&D & Manufacturing") stop fitting in a sensible number of lines.
         Type is re-stated per breakpoint on purpose: fewer columns means WIDER
         columns, so a viewport-based clamp would shrink the text exactly when
         there is more room for it. */
      @media(max-width:1320px){
        .journey-timeline-wrap .timeline{grid-template-columns:repeat(4,1fr);row-gap:calc(var(--bub) / 2 + 26px)}
        .journey-timeline-wrap .rail{display:none}
        .journey-timeline-wrap .year{font-size:22px !important}
        .journey-timeline-wrap .name{font-size:18px !important}
        .journey-timeline-wrap .desc{font-size:15px !important}
      }
      @media(max-width:900px){
        .journey-timeline-wrap .timeline{grid-template-columns:repeat(2,1fr)}
        .journey-timeline-wrap .year{font-size:22px !important}
        .journey-timeline-wrap .name{font-size:18.5px !important}
        .journey-timeline-wrap .desc{font-size:15px !important}
      }
      @media(max-width:560px){
        .journey-timeline-wrap .timeline{grid-template-columns:1fr}
        .journey-timeline-wrap .head-rail s{width:56px}
        .journey-timeline-wrap .year{font-size:21px !important}
        .journey-timeline-wrap .name{font-size:18px !important}
        .journey-timeline-wrap .desc{font-size:14.5px !important}
        .journey-timeline-wrap .card{padding-left:18px;padding-right:18px}
      }
    </style>

    <img class="journey-wave" src="<?php echo get_template_directory_uri(); ?>/image/journey/journey-wave.png" alt="" aria-hidden="true" loading="lazy" decoding="async">

    <!-- Wider than the 1240px used elsewhere on the page: seven cards on one row
         need the extra width to keep each column at the ~180px the design assumes. -->
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 journey-timeline-wrap">
      <p data-editable="journey-eyebrow" <?php echo synergy_style('journey-eyebrow', 'about'); ?> class="eyebrow"><?php echo synergy_content('journey-eyebrow', '<span class="lang-th">เส้นทางความสำเร็จของเรา</span><span class="lang-en">Our Journey</span>', 'about'); ?></p>
      <h2 data-editable="journey-title" <?php echo synergy_style('journey-title', 'about'); ?> class="font-display"><?php echo synergy_content('journey-title', '<span class="lang-th">จากงานวิศวกรรมสู่โซลูชันอัจฉริยะ</span><span class="lang-en">From Engineering to Smart Solutions</span>', 'about'); ?></h2>
      <div class="head-rail" aria-hidden="true"><i></i><b></b><s></s><b></b><i></i></div>

<?php
/* One row per milestone. The rail dots and the grid column count are both derived
   from this array, so adding or removing a milestone cannot leave them out of sync.
   'icon' is only the default - every badge is swappable from the live editor. */
$journey_steps = array(
  array(
    'icon' => 'journey-2008',
    'year' => '2008',
    'name_th' => 'ก่อตั้งบริษัท',
    'name_en' => 'Founded Synergy Technology',
    'desc_th' => 'ก่อตั้งบริษัท ซินเนอร์ยี่ เทคโนโลยี จำกัด',
    'desc_en' => 'Established Synergy Technology Co., Ltd. as an engineering and electronics company.',
  ),
  array(
    'icon' => 'journey-2012',
    'year' => '2010',
    'name_th' => 'ก้าวสู่อุตสาหกรรมยานยนต์',
    'name_en' => 'Entered Automotive Industry',
    'desc_th' => 'ขยายธุรกิจสู่อุตสาหกรรมยานยนต์ และได้รับการรับรองมาตรฐาน ISO 9001',
    'desc_en' => 'Expanded into automotive electronics and achieved ISO 9001 certification.',
  ),
  array(
    'icon' => 'journey-2014',
    'year' => '2014',
    'name_th' => 'ขยายศักยภาพด้าน R&amp;D และการผลิต',
    'name_en' => 'Expanded R&amp;D &amp; Manufacturing',
    'desc_th' => 'พัฒนาศักยภาพด้านวิจัย พัฒนา และการผลิต พร้อมยกระดับสู่มาตรฐาน IATF 16949',
    'desc_en' => 'Strengthened R&amp;D and mass production capabilities for the automotive industry, aligned with IATF 16949 standards.',
  ),
  array(
    'icon' => 'journey-2016',
    'year' => '2018',
    'name_th' => 'ขยายสู่ IoT Smart Solutions',
    'name_en' => 'Launched IoT Smart Solutions',
    'desc_th' => 'พัฒนาโซลูชัน IoT และ AIoT สำหรับภาคอุตสาหกรรมและธุรกิจ',
    'desc_en' => 'Expanded into IoT, AIoT, and smart solutions for industrial applications.',
  ),
  array(
    'icon' => 'journey-2022',
    'year' => '2022',
    'name_th' => 'Smart Industry Solutions',
    'name_en' => 'Smart Industry Solutions',
    'desc_th' => 'ขยายธุรกิจสู่โซลูชันอัจฉริยะสำหรับโรงงาน พลังงาน และการเกษตร',
    'desc_en' => 'Expanded into smart solutions for manufacturing, energy, and agriculture.',
  ),
  array(
    'icon' => 'journey-today',
    'year' => 'Today',
    'is_now' => true,
    'name_th' => 'SynExta Intelligence Engine',
    'name_en' => 'SynExta Intelligence Engine',
    'desc_th' => 'แพลตฟอร์มอัจฉริยะ เชื่อมต่ออุปกรณ์ ข้อมูล และ AI เพื่อขับเคลื่อน Smart Solutions',
    'desc_en' => 'Connecting devices, data, and AI to power intelligent solutions.',
  ),
  array(
    'icon' => 'journey-tomorrow',
    'year' => 'Tomorrow',
    'name_th' => 'Engineering Intelligence Company',
    'name_en' => 'Engineering Intelligence Company',
    'desc_th' => 'ผสานวิศวกรรม ข้อมูล และ AI เพื่อสร้างผลลัพธ์ทางธุรกิจที่ยั่งยืน',
    'desc_en' => 'Integrating engineering, data, and AI for sustainable business impact.',
  ),
);
$journey_count = count($journey_steps);
?>
      <div class="timeline" style="--steps:<?php echo $journey_count; ?>">
        <div class="rail" aria-hidden="true">
<?php for ($i = 1; $i < $journey_count; $i++): ?>
          <span class="dot" style="--k:<?php echo $i; ?>"></span>
<?php endfor; ?>
        </div>

<?php foreach ($journey_steps as $j => $step): $n = $j + 1; ?>
        <div class="step<?php echo !empty($step['is_now']) ? ' is-now' : ''; ?>">
          <div class="badge"><img data-editable-img="journey_img<?php echo $n; ?>" src="<?php echo synergy_content('journey_img' . $n . '_img', function_exists('synergy_asset') ? synergy_asset('image/journey/' . $step['icon'] . '.png') : get_template_directory_uri() . '/image/journey/' . $step['icon'] . '.png', 'about'); ?>" alt="<?php echo htmlspecialchars($step['year'], ENT_QUOTES); ?>" loading="lazy" decoding="async"></div>
          <div class="card">
            <p data-editable="journey-year<?php echo $n; ?>" <?php echo synergy_style('journey-year' . $n, 'about'); ?> class="year"><?php echo synergy_content('journey-year' . $n, $step['year'], 'about'); ?></p>
            <p data-editable="journey-name<?php echo $n; ?>" <?php echo synergy_style('journey-name' . $n, 'about'); ?> class="name"><?php echo synergy_content('journey-name' . $n, '<span class="lang-th">' . $step['name_th'] . '</span><span class="lang-en">' . $step['name_en'] . '</span>', 'about'); ?></p>
            <p data-editable="journey-desc<?php echo $n; ?>" <?php echo synergy_style('journey-desc' . $n, 'about'); ?> class="desc"><?php echo synergy_content('journey-desc' . $n, '<span class="lang-th">' . $step['desc_th'] . '</span><span class="lang-en">' . $step['desc_en'] . '</span>', 'about'); ?></p>
          </div>
        </div>
<?php endforeach; ?>

      </div>
    </div>
  </section>

  <!-- SECTION 4: THE INTELLIGENCE ENGINE (Interactive Animated SVG Circuit Diagram - 100% Full Viewport Width) -->
  <section id="synexta-engine" class="w-full py-10 sm:py-14 text-white relative overflow-hidden" style="scroll-margin-top: 96px; background: radial-gradient(65% 100% at 50% 50%, rgba(20, 100, 60, 0.65) 0%, rgba(10, 45, 28, 0.90) 60%, #071710 100%), linear-gradient(180deg, #0a2419 0%, #06160f 100%);">
    <style>
      #synexta-engine{
        --bg0:#050b09;
        --bg1:#08150f;
        --ink:#ffffff;
        --ink-dim:#b9c9c0;
        --neon:#4ef08e;
        --neon-lime:#8ef060;
        --card:#1a231f;
        --stroke:rgba(140,220,175,.16);
        --wire:#5fd45f;
      }
      .synexta-full-grid{
        width: 100%;
        max-width: 1240px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 32px;
        padding: 0 clamp(18px, 4vw, 44px);
      }
      .synexta-copy {
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
      }
      .synexta-copy .eyebrow{
        font-size:13px;font-weight:700;letter-spacing:.16em;text-transform:uppercase;
        color:var(--neon);margin:0 0 12px;
      }
      .synexta-copy h2{
        font-size:clamp(26px, 3.2vw, 44px);line-height:1.2;margin:0 0 14px;
        font-weight:800;letter-spacing:-.02em;color:#fff;
      }
      .synexta-copy .lede{
        font-size:clamp(14px, 1.2vw, 18px);line-height:1.6;color:var(--ink-dim);
        margin:0 auto;max-width:48ch;
      }
      .synexta-btn{
        display:none;
      }

      .synexta-diagram{width:100%; overflow:hidden;}
      .synexta-diagram svg{display:block;width:100%;height:auto; max-height: 720px;}
      .synexta-diagram text{fill:var(--ink);font-family:inherit}
      /* 24 not 19: the 1560-unit viewBox is scaled down to fit, so in-SVG type shrinks
         with it (at a 1440px window the diagram renders at ~0.63x). */
      .synexta-diagram .lbl{font-size:24px;font-weight:500;dominant-baseline:middle}
      .synexta-diagram .card{fill:url(#sxCardG);stroke:var(--stroke);stroke-width:1.4}
      .synexta-diagram g.item{cursor:default}
      .synexta-diagram g.item:hover .card{stroke:rgba(78,240,142,.7); fill:#24332b;}
      .synexta-diagram .ico, .synexta-diagram use{fill:none !important; stroke:#4ef08e !important; stroke-width:1.8 !important;}
      .synexta-diagram g.item:hover .ico{stroke:#ffffff !important; filter:drop-shadow(0 0 6px #4ef08e);}
      .synexta-diagram .wire{fill:none;stroke:var(--wire);stroke-width:1.8;stroke-dasharray:6 6;opacity:.95;filter:url(#sxGs)}
      /* A perfectly horizontal path has a zero-height bounding box, which makes the
         objectBoundingBox filter region collapse and the path disappear entirely.
         Flat wires therefore render without the glow filter. */
      .synexta-diagram .wire.flat{filter:none}
      .synexta-diagram .nd{fill:#8bf07a;filter:url(#sxGs)}
      .synexta-diagram .brand{font-size:46px;font-weight:800;text-anchor:middle;letter-spacing:.03em}
      .synexta-diagram .sub{font-size:26px;font-weight:600;text-anchor:middle;fill:#f0fff6}

      /* ---- Small-screen fallback: real HTML text instead of the scaled-down SVG ---- */
      .synexta-stack{display:none}
      .synexta-stack .grp + .grp{margin-top:26px}
      .synexta-stack .grp-title{
        display:flex;align-items:center;gap:10px;margin:0 0 12px;
        font-size:12px !important;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:var(--neon);
      }
      .synexta-stack .grp-title::after{content:"";flex:1;height:1px;background:linear-gradient(90deg,rgba(78,240,142,.45),transparent)}
      .synexta-stack .chips{display:grid;grid-template-columns:repeat(auto-fit,minmax(185px,1fr));gap:10px}
      .synexta-stack .chip{
        display:flex;align-items:center;gap:10px;
        background:linear-gradient(180deg,#1e2a24,#121b17);
        border:1px solid var(--stroke);border-radius:12px;padding:12px 14px;
      }
      .synexta-stack .chip svg{width:22px;height:22px;flex:none}
      .synexta-stack .chip use{fill:none !important;stroke:#4ef08e !important;stroke-width:1.8 !important}
      .synexta-stack .chip span{font-size:14.5px !important;line-height:1.35 !important;font-weight:500;color:var(--ink)}
      .synexta-stack .hub{
        display:flex;flex-direction:column;align-items:center;gap:2px;
        margin:22px auto;padding:16px 22px;border-radius:16px;text-align:center;
        background:radial-gradient(120% 120% at 50% 0,rgba(60,200,130,.22),rgba(10,45,28,.5));
        border:1px solid rgba(78,240,142,.35);
      }
      .synexta-stack .hub b{font-size:22px !important;font-weight:800;letter-spacing:.03em;color:#fff}
      .synexta-stack .hub i{font-size:13px !important;font-style:normal;font-weight:600;color:#dffbe9;margin-top:8px}

      @media(max-width:1180px){
        .synexta-diagram{display:none}
        .synexta-stack{display:block; width: 100%;}
      }
    </style>

    <div class="synexta-full-grid">

        <!-- ============ TOP COPY ============ -->
        <div class="synexta-copy">
          <p data-editable="sx-eyebrow" <?php echo synergy_style('sx-eyebrow', 'about'); ?> class="eyebrow"><?php echo synergy_content('sx-eyebrow', 'The Intelligence Engine', 'about'); ?></p>
          <h2 data-editable="sx-title" <?php echo synergy_style('sx-title', 'about'); ?> class="font-display"><?php echo synergy_content('sx-title', 'One Engine. Endless Possibilities.', 'about'); ?></h2>
          <p data-editable="sx-lede" <?php echo synergy_style('sx-lede', 'about'); ?> class="lede"><?php echo synergy_content('sx-lede', '<span class="lang-th">SynExta เปลี่ยนผ่านงานวิศวกรรมสู่โซลูชันธุรกิจอัจฉริยะแบบครบวงจร</span><span class="lang-en">SynExta transforms engineering into intelligent business solutions.</span>', 'about'); ?></p>
        </div>

        <!-- ============ DIAGRAM ============ -->
        <div class="synexta-diagram">
          <svg viewBox="0 0 1560 640" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="sxCardG" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0" stop-color="#1e2a24"/><stop offset="1" stop-color="#121b17"/>
            </linearGradient>
            <linearGradient id="sxBrandG" x1="0" y1="0" x2="1" y2="0">
              <stop offset="0" stop-color="#ffffff"/><stop offset=".46" stop-color="#ffffff"/>
              <stop offset=".52" stop-color="#8ef060"/><stop offset="1" stop-color="#3fe58f"/>
            </linearGradient>
            <linearGradient id="sxSlabTop" x1=".1" y1="0" x2=".9" y2="1">
              <stop offset="0" stop-color="#2fe08c"/><stop offset=".55" stop-color="#124d36"/><stop offset="1" stop-color="#0b3325"/>
            </linearGradient>
            <linearGradient id="sxSlabSide" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0" stop-color="#175539"/><stop offset="1" stop-color="#06180f"/>
            </linearGradient>
            <linearGradient id="sxEdgeL" x1="0" y1="0" x2="1" y2="0">
              <stop offset="0" stop-color="#a6ffcd"/><stop offset="1" stop-color="#33ea8c"/>
            </linearGradient>
            <!-- Darkens the middle of the ring and fades out before the rim, so the
                 disc never shows a visible edge against the surrounding glow. -->
            <radialGradient id="sxLens" cx="50%" cy="50%" r="50%">
              <stop offset="0" stop-color="#04120b" stop-opacity=".82"/>
              <stop offset=".62" stop-color="#04120b" stop-opacity=".72"/>
              <stop offset=".88" stop-color="#04120b" stop-opacity=".34"/>
              <stop offset="1" stop-color="#04120b" stop-opacity="0"/>
            </radialGradient>
            <filter id="sxGs" x="-400%" y="-400%" width="900%" height="900%">
              <feGaussianBlur stdDeviation="2.4" result="b"/>
              <feMerge><feMergeNode in="b"/><feMergeNode in="SourceGraphic"/></feMerge>
            </filter>
            <filter id="sxGl" x="-200%" y="-200%" width="500%" height="500%">
              <feGaussianBlur stdDeviation="10" result="b"/>
              <feMerge><feMergeNode in="b"/><feMergeNode in="SourceGraphic"/></feMerge>
            </filter>
            <filter id="sxBb" x="-100%" y="-100%" width="300%" height="300%">
              <feGaussianBlur stdDeviation="26"/>
            </filter>

            <!-- 24x24 icon glyphs (explicit fill="none" and stroke="#4ef08e") -->
            <g id="ic-chip"><rect fill="none" stroke="#4ef08e" stroke-width="1.8" x="4" y="4" width="16" height="16" rx="3"/><circle fill="none" stroke="#4ef08e" stroke-width="1.8" cx="12" cy="12" r="4"/><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M8 1v3M16 1v3M8 20v3M16 20v3M1 8h3M1 16h3M20 8h3M20 16h3"/></g>
            <g id="ic-board"><circle fill="none" stroke="#4ef08e" stroke-width="1.8" cx="12" cy="12" r="4.2"/><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M12 2v5.5M12 16.5V22M2 12h5.5M16.5 12H22M5 5l4 4M15 15l4 4M19 5l-4 4M9 15l-4 4"/><circle fill="none" stroke="#4ef08e" stroke-width="1.8" cx="12" cy="2" r="1.5"/><circle fill="none" stroke="#4ef08e" stroke-width="1.8" cx="12" cy="22" r="1.5"/><circle fill="none" stroke="#4ef08e" stroke-width="1.8" cx="2" cy="12" r="1.5"/><circle fill="none" stroke="#4ef08e" stroke-width="1.8" cx="22" cy="12" r="1.5"/></g>
            <g id="ic-iot"><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M12 3c4.6 2.7 7 6.4 7 10.4 0 3.7-3.1 6.6-7 6.6s-7-2.9-7-6.6C5 9.4 7.4 5.7 12 3z"/><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M8.4 10.5c1.6 1.5 5.6 1.5 7.2 0M9.8 15.6c1.1 1 3.3 1 4.4 0"/></g>
            <g id="ic-fw"><rect fill="none" stroke="#4ef08e" stroke-width="1.8" x="2.5" y="4" width="19" height="16" rx="3"/><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M9 9.5L6 12l3 2.5M15 9.5L18 12l-3 2.5"/><circle fill="none" stroke="#4ef08e" stroke-width="1.8" cx="12" cy="12" r="1.2"/></g>
            <g id="ic-sensor"><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M12 2.5c4.2 3.2 6.8 6.9 6.8 10.5A6.8 6.8 0 0 1 5.2 13C5.2 9.4 7.8 5.7 12 2.5z"/><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M12 7v9M12 11.5l3.4-2.4M12 14.6L8.6 12.2"/></g>
            <g id="ic-machine"><rect fill="none" stroke="#4ef08e" stroke-width="1.8" x="1.5" y="11" width="11" height="8" rx="1.6"/><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M12.5 15h4l4.5-7M16.5 8h5v5"/><circle fill="none" stroke="#4ef08e" stroke-width="1.8" cx="5" cy="20.5" r="2"/><circle fill="none" stroke="#4ef08e" stroke-width="1.8" cx="10.5" cy="20.5" r="2"/></g>
            <g id="ic-factory"><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M2 21V11l6 4V11l6 4V6.5h8V21z"/><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M17 10h2M17 14h2M6 17h3M12 17h3M20 6.5V3h-2"/></g>
            <g id="ic-energy"><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M6.5 21V8.5M6.5 8.5l-3 3M6.5 8.5l3 3M3.5 21h6"/><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M16 21V6M13 9l3-3 3 3M12.5 21h7"/><circle fill="none" stroke="#4ef08e" stroke-width="1.8" cx="16" cy="3" r="1.6"/></g>
            <g id="ic-agri"><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M2 21h20M4 21V11h16v10"/><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M3 11L12 4l9 7"/><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M8 21v-6h3v6M13 15h3v6"/></g>
            <g id="ic-health"><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M12 2l8.5 3v7c0 6-4.5 9.5-8.5 11-4-1.5-8.5-5-8.5-11V5z"/><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M12 7.5v8M8 11.5h8"/></g>
            <g id="ic-ai"><rect fill="none" stroke="#4ef08e" stroke-width="1.8" x="5.5" y="5.5" width="13" height="13" rx="3"/><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M10 10h4v4h-4z"/><path fill="none" stroke="#4ef08e" stroke-width="1.8" stroke-linecap="round" d="M9 1.5v4M15 1.5v4M9 18.5v4M15 18.5v4M1.5 9h4M1.5 15h4M18.5 9h4M18.5 15h4"/></g>
          </defs>

          <!-- ambient glow -->
          <ellipse cx="800" cy="470" rx="400" ry="150" fill="rgba(40,215,125,.28)" filter="url(#sxBb)"/>
          <ellipse cx="800" cy="290" rx="210" ry="210" fill="rgba(30,175,105,.14)" filter="url(#sxBb)"/>

          <g id="sx-wires"></g>
          <g id="sx-flows"></g>

          <!-- ===== CENTER ===== -->
          <g>
            <!-- halo -->
            <circle cx="800" cy="272" r="150" fill="none" stroke="rgba(78,240,142,.30)" stroke-width="18"
                    stroke-dasharray="760 943" transform="rotate(102 800 272)" filter="url(#sxBb)"/>
            <!-- Lens: the ambient glow peaks exactly where the wordmark sits, which is
                 what made the logo sink into the background. This disc pulls the inside
                 of the ring back down to a controlled base so the wordmark and the
                 subtitle both keep their contrast, and it makes the white ring read as
                 a rim rather than dissolving into the glow. -->
            <circle cx="800" cy="272" r="148" fill="url(#sxLens)"/>
            <!-- soft white bloom (closed, so the ring glows evenly all the way round) -->
            <circle cx="800" cy="272" r="150" fill="none" stroke="rgba(235,255,245,.55)" stroke-width="9"
                    filter="url(#sxGl)"/>
            <!-- crisp white ring (closed circle - the glow layers above provide the falloff) -->
            <circle cx="800" cy="272" r="150" fill="none" stroke="#ffffff" stroke-width="3.4"/>
            <circle cx="800" cy="272" r="165" fill="none" stroke="rgba(120,255,175,.35)" stroke-width="2"
                    stroke-dasharray="34 900" stroke-linecap="round" filter="url(#sxGs)">
              <animateTransform attributeName="transform" type="rotate" from="0 800 272" to="360 800 272" dur="8s" repeatCount="indefinite"/>
            </circle>

            <!-- Reverse (knockout) wordmark. The primary logo is dark green + gold and
                 is drawn for white backgrounds; on this field its green measured 1.21:1
                 contrast, so only "EXTA" was visible. This variant swaps the green for
                 white and keeps the gold, taking it to ~8:1.
                 The box keeps the artwork's own 1997:227 ratio so xMidYMid meet has no
                 slack to letterbox, and is 264 wide rather than the full 292 that fits
                 across the ring at this height - that leaves ~14 units of clearance so
                 the "S" and the final "A" do not run into the rim. -->
            <image href="<?php echo get_template_directory_uri(); ?>/image/synexta-logo-on-dark.png"
                   x="668" y="239" width="264" height="30" preserveAspectRatio="xMidYMid meet"/>
            <!-- Subtitle, kept in sync with the editable hub block by the script below -->
            <text class="sub" x="800" y="305">Intelligence Engine</text>

            <!-- platform -->
            <g transform="translate(800,400)">
              <path d="M0 84 L-200 22 L0 -40 L200 22 Z" fill="url(#sxSlabTop)" opacity=".55"/>
              <path d="M-200 22 v24 L0 108 v-24 Z" fill="url(#sxSlabSide)"/>
              <path d="M200 22 v24 L0 108 v-24 Z" fill="url(#sxSlabSide)" opacity=".85"/>
              <path d="M0 84 L-200 22 M0 84 L200 22" stroke="url(#sxEdgeL)" stroke-width="3" fill="none" filter="url(#sxGl)"/>
              <g stroke="rgba(150,255,200,.3)" stroke-width="1.3" fill="none">
                <path d="M-104 40 l34 10 l22-7"/><path d="M66 54 l34-10 l28 8"/>
                <rect x="-142" y="52" width="20" height="9" transform="skewY(17)"/>
                <rect x="100" y="16" width="20" height="9" transform="skewY(-17)"/>
              </g>

              <path d="M0 32 L-138 -10 L0 -52 L138 -10 Z" fill="url(#sxSlabTop)" opacity=".8"/>
              <path d="M-138 -10 v15 L0 47 v-15 Z" fill="url(#sxSlabSide)"/>
              <path d="M138 -10 v15 L0 47 v-15 Z" fill="url(#sxSlabSide)" opacity=".85"/>
              <path d="M0 32 L-138 -10 M0 32 L138 -10" stroke="url(#sxEdgeL)" stroke-width="2.4" fill="none" filter="url(#sxGs)"/>

              <path d="M0 -8 L-82 -32 L0 -56 L82 -32 Z" fill="#0e2b21" stroke="rgba(165,255,212,.75)" stroke-width="1.5"/>
              <path d="M-82 -32 v11 L0 3 v-11 Z" fill="#0a1f18" stroke="rgba(120,220,170,.45)" stroke-width="1.2"/>
              <path d="M82 -32 v11 L0 3 v-11 Z" fill="#08180f" stroke="rgba(120,220,170,.45)" stroke-width="1.2"/>
              <path d="M0 -16 L-50 -32 L0 -48 L50 -32 Z" fill="none" stroke="rgba(120,240,180,.4)" stroke-width="1.2"/>

              <g filter="url(#sxGl)">
                <circle cx="0" cy="-32" r="3.6" fill="#e2ffee"/>
                <path d="M-24 -32h48M0 -44v24" stroke="#bfffdb" stroke-width="1.6" opacity=".85"/>
              </g>
              <ellipse cx="0" cy="-32" rx="0" ry="0" fill="none" stroke="#7dffbb" stroke-width="2">
                <animate attributeName="rx" values="6;190" dur="3.4s" repeatCount="indefinite"/>
                <animate attributeName="ry" values="2;58" dur="3.4s" repeatCount="indefinite"/>
                <animate attributeName="opacity" values=".7;0" dur="3.4s" repeatCount="indefinite"/>
              </ellipse>
            </g>
          </g>

          <g id="sx-left"></g>
          <g id="sx-right"></g>
          </svg>
        </div>

        <!-- Small-screen equivalent of the diagram.
             This is also the single source of truth for the diagram's labels: the
             script below reads these chips to build the SVG cards, so an edit here
             shows up in both representations. -->
        <div class="synexta-stack" id="sx-stack">
          <div class="grp">
            <p data-editable="sx-inputs-title" <?php echo synergy_style('sx-inputs-title', 'about'); ?> class="grp-title"><?php echo synergy_content('sx-inputs-title', 'Inputs', 'about'); ?></p>
            <div class="chips" id="sx-chips-in">
<?php
$sx_inputs = array(
  array('1', 'ic-chip',    'Hardware'),
  array('2', 'ic-board',   'Embedded<br>Systems'),
  array('3', 'ic-iot',     'IoT Devices'),
  array('4', 'ic-fw',      'Firmware'),
  array('5', 'ic-sensor',  'Sensors'),
  array('6', 'ic-machine', 'Machines'),
);
foreach ($sx_inputs as $sx) {
  list($sx_n, $sx_icon, $sx_label) = $sx;
  echo '              <div class="chip" data-icon="' . $sx_icon . '"><svg viewBox="0 0 24 24" aria-hidden="true"><use href="#' . $sx_icon . '"></use></svg>'
     . '<span data-editable="sx-in' . $sx_n . '" ' . synergy_style('sx-in' . $sx_n, 'about') . '>'
     . synergy_content('sx-in' . $sx_n, $sx_label, 'about') . '</span></div>' . "\n";
}
?>
            </div>
          </div>
          <!-- Same reverse wordmark as the diagram: this block also sits on the dark
               green field, so the primary dark-green logo sank here too. The subtitle
               is the editable source the SVG's <text class="sub"> mirrors. -->
          <div class="hub">
            <img data-editable-img="sx_hub_logo" src="<?php echo synergy_content('sx_hub_logo_img', get_template_directory_uri() . '/image/synexta-logo-on-dark.png', 'about'); ?>" alt="SYNEXTA" class="h-9 w-auto max-w-full object-contain" />
            <i data-editable="sx-hub-sub" <?php echo synergy_style('sx-hub-sub', 'about'); ?>><?php echo synergy_content('sx-hub-sub', 'Intelligence Engine', 'about'); ?></i>
          </div>
          <div class="grp">
            <p data-editable="sx-outcomes-title" <?php echo synergy_style('sx-outcomes-title', 'about'); ?> class="grp-title"><?php echo synergy_content('sx-outcomes-title', 'Outcomes', 'about'); ?></p>
            <div class="chips" id="sx-chips-out">
<?php
$sx_outcomes = array(
  array('1', 'ic-factory', 'Smart Factory'),
  array('2', 'ic-energy',  'Smart Energy'),
  array('3', 'ic-agri',    'Smart Agriculture'),
);
foreach ($sx_outcomes as $sx) {
  list($sx_n, $sx_icon, $sx_label) = $sx;
  echo '              <div class="chip" data-icon="' . $sx_icon . '"><svg viewBox="0 0 24 24" aria-hidden="true"><use href="#' . $sx_icon . '"></use></svg>'
     . '<span data-editable="sx-out' . $sx_n . '" ' . synergy_style('sx-out' . $sx_n, 'about') . '>'
     . synergy_content('sx-out' . $sx_n, $sx_label, 'about') . '</span></div>' . "\n";
}
?>
            </div>
          </div>
        </div>

    </div>

    <script>
    (function(){
      const NS="http://www.w3.org/2000/svg";
      const el=(n,a={})=>{const e=document.createElementNS(NS,n);for(const k in a)e.setAttribute(k,a[k]);return e;};

      /* Labels come from the #sx-stack markup, which is the editable copy. innerHTML
         is parsed rather than innerText because the stack is display:none at the
         widths where the SVG is the visible representation, and innerText collapses
         to nothing for hidden nodes. */
      const chipText = el => el.innerHTML
        .replace(/<br\s*\/?>/gi, "\n")
        .replace(/<[^>]*>/g, "")
        .replace(/&nbsp;/g, " ").replace(/&amp;/g, "&")
        .replace(/[ \t]+/g, " ").trim();

      const readChips = id => Array.from(document.querySelectorAll("#" + id + " .chip"))
        .map(c => {
          const span = c.querySelector("span");
          return span ? [chipText(span), c.dataset.icon] : null;
        })
        .filter(Boolean);

      /* Cards are 290 wide (not 254) so the larger 24px labels still fit inside them.
         Right column starts at 1250 to keep its 290px card inside the 1560 viewBox. */
      const L={x:20,w:290,h:62,y0:22,gap:12};
      const R={x:1250,w:290,h:76,y0:56,gap:42};
      const HUBL=650, HUBR=950;

      const gL=document.getElementById("sx-left"),gR=document.getElementById("sx-right"),
            gW=document.getElementById("sx-wires"),gF=document.getElementById("sx-flows");

      if(!gL || !gR || !gW || !gF) return;

      function label(g,text,x,y,size){
        const lines=text.split("\n");
        const t=el("text",{class:"lbl",x,y:y-(lines.length-1)*(size*.58),style:`font-size:${size}px`});
        lines.forEach((ln,i)=>{const s=el("tspan",{x,dy:i?size*1.15:0});s.textContent=ln;t.appendChild(s);});
        g.appendChild(t);
      }
      function card(parent,{x,y,w,h,text,icon,sc=1.05}){
        const g=el("g",{class:"item"});
        g.appendChild(el("rect",{class:"card",x,y,width:w,height:h,rx:11}));
        g.appendChild(el("rect",{x:x+.8,y:y+.8,width:w-1.6,height:h/2,rx:10.5,fill:"rgba(255,255,255,.03)"}));
        g.appendChild(el("use",{href:"#"+icon,transform:`translate(${x+16},${y+h/2-12*sc}) scale(${sc})`}));
        label(g,text,x+56,y+h/2,24);
        parent.appendChild(g);
      }
      function node(x,y){gW.appendChild(el("circle",{class:"nd",cx:x,cy:y,r:4}));}
      function wire(d,flat){
        gW.appendChild(el("path",{class:flat?"wire flat":"wire",d}));
        const dot=el("circle",{r:3.5,fill:"#e6fff1",filter:"url(#sxGs)"});
        dot.appendChild(el("animateMotion",{dur:(2.6+Math.random()*1.8).toFixed(2)+"s",
          repeatCount:"indefinite",path:d,begin:(Math.random()*2.5).toFixed(2)+"s"}));
        gF.appendChild(dot);
      }
      const isFlat=(y1,y2)=>Math.abs(y2-y1)<4;
      function smoothWire(x1,y1,x2,y2){
        if(isFlat(y1,y2)) return `M${x1},${y1} H${x2}`;
        const midX=(x1+x2)/2;
        return `M${x1},${y1} C${midX},${y1} ${midX},${y2} ${x2},${y2}`;
      }

      const LT=[135, 190, 245, 275, 335, 390];
      const RT=[160, 235, 310];

      function render(){
        [gL,gR,gW,gF].forEach(g=>{ while(g.firstChild) g.removeChild(g.firstChild); });

        readChips("sx-chips-in").slice(0,LT.length).forEach(([t,ic],i)=>{
          const y=L.y0+i*(L.h+L.gap), cy=y+L.h/2;
          const x1=L.x+L.w;
          card(gL,{x:L.x,y,w:L.w,h:L.h,text:t,icon:ic});
          node(x1, cy);
          node(HUBL, LT[i]);
          wire(smoothWire(x1, cy, HUBL, LT[i]), isFlat(cy, LT[i]));
        });

        readChips("sx-chips-out").slice(0,RT.length).forEach(([t,ic],i)=>{
          const y=R.y0+i*(R.h+R.gap), cy=y+R.h/2;
          const x2=R.x;
          card(gR,{x:R.x,y,w:R.w,h:R.h,text:t,icon:ic,sc:1.15});
          node(HUBR, RT[i]);
          node(x2, cy);
          wire(smoothWire(HUBR, RT[i], x2, cy), isFlat(RT[i], cy));
        });

        // The ring labels mirror the editable hub block.
        const hubName=document.querySelector('#sx-stack .hub b'),
              hubSub =document.querySelector('#sx-stack .hub i'),
              svgName=document.querySelector('.synexta-diagram text.brand'),
              svgSub =document.querySelector('.synexta-diagram text.sub');
        if(hubName && svgName) svgName.textContent=chipText(hubName);
        if(hubSub && svgSub)  svgSub.textContent =chipText(hubSub);
      }

      render();

      /* Re-draw when the live editor rewrites a label (either by the admin typing,
         or by loadSavedData() replacing innerHTML on page load). */
      const stack=document.getElementById("sx-stack");
      if(stack && window.MutationObserver){
        let pending=null;
        new MutationObserver(()=>{ clearTimeout(pending); pending=setTimeout(render,150); })
          .observe(stack,{subtree:true,childList:true,characterData:true});
      }
    })();
    </script>
  </section>

  <!-- SECTION 5: WHAT WE BUILD (own full-width block)
       Was the left half of a lg:grid-cols-2 pair, which squeezed four image cards into
       half the page. Now a section of its own, four across, with the icon badge tucked
       into the corner of each image. -->
  <section id="what-we-build" class="py-12 sm:py-16 bg-white relative" style="scroll-margin-top: 96px;">
    <style>
      .build-wrap{
        --bd:#e8ecea;
        --ink:#0b2127;
        --muted:#6b7280;
      }
      .build-card{background:#fff;border-radius:18px;overflow:hidden}
      /* no frame: the reference puts the content straight on the page background */
      .build-shell{background:transparent;border:0;border-radius:0;padding:0;box-shadow:none}
      .build-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:clamp(16px,2vw,28px)}
      /* .media does NOT clip - it only provides the positioning context, so the badge
         can hang past the image edge. Only .shot clips, to round the photo corners. */
      .build-item .media{position:relative}
      .build-item .shot{
        border-radius:18px;overflow:hidden;
        aspect-ratio:16/11;background:#eef1ef;
      }
      .build-item .shot img{width:100%;height:100%;object-fit:cover;display:block}
      .build-item .badge{
        position:absolute;left:14px;bottom:-20px;z-index:2;
        width:clamp(38px,3.2vw,46px);height:clamp(38px,3.2vw,46px);border-radius:50%;
        background:var(--brand-green,#1e7a45);
        display:flex;align-items:center;justify-content:center;
        box-shadow:0 6px 18px rgba(11,33,39,.18);border:3px solid #fff;
      }
      .build-item .badge i{color:#fff;font-size:clamp(15px,1.3vw,19px)}
      .build-item .cap{padding-top:30px}
      /* DNA tag: the spec asks for the DNA to run through every solution */
      .dna-tag{
        display:inline-flex;align-items:center;gap:6px;margin:0 0 8px;
        font-size:clamp(11px,.78vw,11.5px) !important;font-weight:800;
        letter-spacing:.13em;text-transform:uppercase;color:var(--brand-green,#1e7a45);
      }
      .dna-tag .dot{width:7px;height:7px;border-radius:50%;background:#23862D;display:inline-block;flex:none}
      .build-item h3{
        font-size:clamp(16px,1.35vw,20px) !important;font-weight:800;color:var(--ink);
        margin:0 0 6px;line-height:1.3 !important;
      }
      .build-item p{
        font-size:clamp(13px,1.02vw,15px) !important;line-height:1.6 !important;
        color:var(--muted);margin:0;font-weight:400;
      }
      @media(max-width:1024px){
        .build-grid{grid-template-columns:repeat(2,1fr)}
      }
      @media(max-width:560px){
        .build-grid{grid-template-columns:1fr}
      }
    </style>

    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 build-wrap">
      <div class="build-shell text-center mb-10">
        <h2 data-editable="build-title" <?php echo synergy_style('build-title', 'about'); ?> class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-ink">
          <?php echo synergy_content('build-title', 'What We Build', 'about'); ?>
        </h2>
      </div>

      <div class="build-grid">

          <!-- 1. Custom Engineering -->
          <div class="build-item">
            <div class="media">
              <div class="shot">
                <img data-editable-img="build_img1" loading="lazy" decoding="async" src="<?php echo synergy_content('build_img1_img', get_template_directory_uri() . '/image/about/pcb-design-prototyping.png', 'about'); ?>" alt="Custom Engineering">
              </div>
              <span class="badge"><i class="fa-solid fa-microchip" aria-hidden="true"></i></span>
            </div>
            <div class="cap">
              <span data-editable="build-tag1" <?php echo synergy_style('build-tag1', 'about'); ?> class="dna-tag"><?php echo synergy_content('build-tag1', '<span class="dot"></span>INNOVATIVE', 'about'); ?></span>
              <h3 data-editable="build-item-title1" <?php echo synergy_style('build-item-title1', 'about'); ?>><?php echo synergy_content('build-item-title1', 'Custom Engineering', 'about'); ?></h3>
              <p data-editable="build-item-desc1" <?php echo synergy_style('build-item-desc1', 'about'); ?>><?php echo synergy_content('build-item-desc1', '<span class="lang-th">พัฒนา Hardware, Embedded, AI และ Platform ตามความต้องการของธุรกิจ</span><span class="lang-en">Hardware, embedded, AI, and platform development tailored to your business needs.</span>', 'about'); ?></p>
            </div>
          </div>

          <!-- 2. Smart Agriculture -->
          <div class="build-item">
            <div class="media">
              <div class="shot">
                <img data-editable-img="build_img2" loading="lazy" decoding="async" src="<?php echo synergy_content('build_img2_img', get_template_directory_uri() . '/image/about/smart-agriculture.png', 'about'); ?>" alt="Smart Agriculture">
              </div>
              <span class="badge"><i class="fa-solid fa-seedling" aria-hidden="true"></i></span>
            </div>
            <div class="cap">
              <span data-editable="build-tag2" <?php echo synergy_style('build-tag2', 'about'); ?> class="dna-tag"><?php echo synergy_content('build-tag2', '<span class="dot"></span>INNOVATIVE', 'about'); ?></span>
              <h3 data-editable="build-item-title2" <?php echo synergy_style('build-item-title2', 'about'); ?>><?php echo synergy_content('build-item-title2', 'Smart Agriculture', 'about'); ?></h3>
              <p data-editable="build-item-desc2" <?php echo synergy_style('build-item-desc2', 'about'); ?>><?php echo synergy_content('build-item-desc2', '<span class="lang-th">บริหารจัดการการเกษตรด้วยข้อมูล เพื่อเพิ่มผลผลิตและใช้ทรัพยากรอย่างคุ้มค่า</span><span class="lang-en">Data-driven precision agriculture and environmental monitoring for better yield and resource efficiency.</span>', 'about'); ?></p>
            </div>
          </div>

          <!-- 3. Smart Energy -->
          <div class="build-item">
            <div class="media">
              <div class="shot">
                <img data-editable-img="build_img3" loading="lazy" decoding="async" src="<?php echo synergy_content('build_img3_img', get_template_directory_uri() . '/image/about/smart-energy-hero.png', 'about'); ?>" alt="Smart Energy">
              </div>
              <span class="badge"><i class="fa-solid fa-bolt" aria-hidden="true"></i></span>
            </div>
            <div class="cap">
              <span data-editable="build-tag3" <?php echo synergy_style('build-tag3', 'about'); ?> class="dna-tag"><?php echo synergy_content('build-tag3', '<span class="dot"></span>IMPACTFUL', 'about'); ?></span>
              <h3 data-editable="build-item-title3" <?php echo synergy_style('build-item-title3', 'about'); ?>><?php echo synergy_content('build-item-title3', 'Smart Energy', 'about'); ?></h3>
              <p data-editable="build-item-desc3" <?php echo synergy_style('build-item-desc3', 'about'); ?>><?php echo synergy_content('build-item-desc3', '<span class="lang-th">บริหารจัดการพลังงานแบบ Real-time เพื่อประหยัดพลังงานและเพิ่มประสิทธิภาพ</span><span class="lang-en">Real-time energy monitoring and automation to optimize power consumption and efficiency.</span>', 'about'); ?></p>
            </div>
          </div>

          <!-- 4. Smart Factory -->
          <div class="build-item">
            <div class="media">
              <div class="shot">
                <img data-editable-img="build_img4" loading="lazy" decoding="async" src="<?php echo synergy_content('build_img4_img', get_template_directory_uri() . '/image/about/smart-factory.jpg', 'about'); ?>" alt="Smart Factory">
              </div>
              <span class="badge"><i class="fa-solid fa-industry" aria-hidden="true"></i></span>
            </div>
            <div class="cap">
              <span data-editable="build-tag4" <?php echo synergy_style('build-tag4', 'about'); ?> class="dna-tag"><?php echo synergy_content('build-tag4', '<span class="dot"></span>IMPACTFUL', 'about'); ?></span>
              <h3 data-editable="build-item-title4" <?php echo synergy_style('build-item-title4', 'about'); ?>><?php echo synergy_content('build-item-title4', 'Smart Factory', 'about'); ?></h3>
              <p data-editable="build-item-desc4" <?php echo synergy_style('build-item-desc4', 'about'); ?>><?php echo synergy_content('build-item-desc4', '<span class="lang-th">เชื่อมต่อข้อมูลและเครื่องจักร เพื่อยกระดับประสิทธิภาพการผลิตด้วย Smart Factory</span><span class="lang-en">Connecting data and machinery to elevate manufacturing productivity with Smart Factory.</span>', 'about'); ?></p>
            </div>
          </div>

        </div>
      </div>
  </section>

  <!-- SECTION 6: WHY BUSINESSES TRUST SYNERGY (own full-width block)
       Six reasons on one row, separated by hairlines, on its own tinted panel. -->
  <section id="why-trust" class="py-12 sm:py-16 bg-[#f6f8f7] border-t border-slate-100 relative" style="scroll-margin-top: 96px;">
    <style>
      .trust6-wrap{--bd:#dde5e0;--ink:#0b2127;--muted:#6b7280}
      /* no frame here either - separation comes from the section background alone */
      .trust6-shell{background:transparent;border:0;border-radius:0;padding:0}
      .trust6-grid{
        display:grid;grid-template-columns:repeat(6,1fr);
        margin-top:clamp(22px,3vw,40px);
      }
      .trust6-item{
        display:flex;flex-direction:column;align-items:center;text-align:center;
        padding:0 clamp(8px,1vw,18px);min-width:0;
      }
      .trust6-item .ic{
        width:clamp(52px,4.6vw,66px);height:clamp(52px,4.6vw,66px);border-radius:50%;
        background:#fff;display:flex;align-items:center;justify-content:center;
        margin-bottom:clamp(12px,1.4vw,18px);flex:none;
        box-shadow:0 3px 12px rgba(11,33,39,.07);
      }
      .trust6-item .ic i{color:var(--brand-green,#1e7a45);font-size:clamp(20px,1.9vw,27px)}
      .trust6-item h4{
        font-size:clamp(14px,1.15vw,17px) !important;font-weight:800;color:var(--ink);
        margin:0 0 6px;line-height:1.3 !important;
      }
      .trust6-item .dna{
        display:block;margin-top:7px;
        /* floor is 11px, not 9px: the vw-based minimum only ever applies on phones,
           which is exactly where 9px stops being legible. */
        font-size:clamp(11px,.72vw,11.5px) !important;font-weight:800;
        letter-spacing:.12em;text-transform:uppercase;color:var(--brand-green,#1e7a45);
      }
      .trust6-item p{
        font-size:clamp(12px,.95vw,14px) !important;line-height:1.55 !important;
        color:var(--muted);margin:0;font-weight:400;
        overflow-wrap:normal;word-break:keep-all;hyphens:none;
      }
      /* hairlines only while all six share one row */
      @media(min-width:1181px){
        .trust6-item + .trust6-item{border-left:1px solid var(--bd)}
      }
      @media(max-width:1180px){
        .trust6-grid{grid-template-columns:repeat(3,1fr);gap:clamp(22px,3vw,34px) 12px}
      }
      @media(max-width:640px){
        .trust6-grid{grid-template-columns:repeat(2,1fr)}
      }
    </style>

    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 trust6-wrap">
      <div class="trust6-shell">
        <div class="text-center max-w-3xl mx-auto mb-8">
          <h2 data-editable="trust-title" <?php echo synergy_style('trust-title', 'about'); ?> class="font-display font-extrabold text-3xl sm:text-4xl lg:text-5xl text-ink"><?php echo synergy_content('trust-title', 'Why Businesses Trust Synergy', 'about'); ?></h2>
        </div>

        <div class="trust6-grid">

          <div class="trust6-item">
            <span data-editable="trust-icon1" <?php echo synergy_style('trust-icon1', 'about'); ?> class="ic"><?php echo synergy_content('trust-icon1', '<i class="fa-solid fa-compass-drafting" aria-hidden="true"></i>', 'about'); ?></span>
            <h4 data-editable="trust-h1" <?php echo synergy_style('trust-h1', 'about'); ?>><?php echo synergy_content('trust-h1', 'Engineering First', 'about'); ?></h4>
            <p data-editable="trust-desc1" <?php echo synergy_style('trust-desc1', 'about'); ?>><?php echo synergy_content('trust-desc1', 'We solve engineering challenges before building solutions.', 'about'); ?></p>
            <span data-editable="trust-dna1" <?php echo synergy_style('trust-dna1', 'about'); ?> class="dna"><?php echo synergy_content('trust-dna1', 'TRUSTED', 'about'); ?></span>
          </div>

          <div class="trust6-item">
            <span data-editable="trust-icon2" <?php echo synergy_style('trust-icon2', 'about'); ?> class="ic"><?php echo synergy_content('trust-icon2', '<i class="fa-solid fa-gears" aria-hidden="true"></i>', 'about'); ?></span>
            <h4 data-editable="trust-h2" <?php echo synergy_style('trust-h2', 'about'); ?>><?php echo synergy_content('trust-h2', 'End-to-End Development', 'about'); ?></h4>
            <p data-editable="trust-desc2" <?php echo synergy_style('trust-desc2', 'about'); ?>><?php echo synergy_content('trust-desc2', 'From hardware design to AI platform and deployment.', 'about'); ?></p>
            <span data-editable="trust-dna2" <?php echo synergy_style('trust-dna2', 'about'); ?> class="dna"><?php echo synergy_content('trust-dna2', 'IMPACTFUL', 'about'); ?></span>
          </div>

          <div class="trust6-item">
            <span data-editable="trust-icon3" <?php echo synergy_style('trust-icon3', 'about'); ?> class="ic"><?php echo synergy_content('trust-icon3', '<i class="fa-solid fa-screwdriver-wrench" aria-hidden="true"></i>', 'about'); ?></span>
            <h4 data-editable="trust-h3" <?php echo synergy_style('trust-h3', 'about'); ?>><?php echo synergy_content('trust-h3', 'Custom Innovation', 'about'); ?></h4>
            <p data-editable="trust-desc3" <?php echo synergy_style('trust-desc3', 'about'); ?>><?php echo synergy_content('trust-desc3', 'We design and develop solutions around your unique business needs.', 'about'); ?></p>
            <span data-editable="trust-dna3" <?php echo synergy_style('trust-dna3', 'about'); ?> class="dna"><?php echo synergy_content('trust-dna3', 'INNOVATIVE', 'about'); ?></span>
          </div>

          <div class="trust6-item">
            <span data-editable="trust-icon4" <?php echo synergy_style('trust-icon4', 'about'); ?> class="ic"><?php echo synergy_content('trust-icon4', '<i class="fa-solid fa-microchip" aria-hidden="true"></i>', 'about'); ?></span>
            <h4 data-editable="trust-h4" <?php echo synergy_style('trust-h4', 'about'); ?>><?php echo synergy_content('trust-h4', 'Manufacturing Expertise', 'about'); ?></h4>
            <p data-editable="trust-desc4" <?php echo synergy_style('trust-desc4', 'about'); ?>><?php echo synergy_content('trust-desc4', 'In-house PCB assembly, testing, and quality control.', 'about'); ?></p>
            <span data-editable="trust-dna4" <?php echo synergy_style('trust-dna4', 'about'); ?> class="dna"><?php echo synergy_content('trust-dna4', 'TRUSTED', 'about'); ?></span>
          </div>

          <div class="trust6-item">
            <span data-editable="trust-icon5" <?php echo synergy_style('trust-icon5', 'about'); ?> class="ic"><?php echo synergy_content('trust-icon5', '<i class="fa-solid fa-brain" aria-hidden="true"></i>', 'about'); ?></span>
            <h4 data-editable="trust-h5" <?php echo synergy_style('trust-h5', 'about'); ?>><?php echo synergy_content('trust-h5', 'AI-Driven Intelligence', 'about'); ?></h4>
            <p data-editable="trust-desc5" <?php echo synergy_style('trust-desc5', 'about'); ?>><?php echo synergy_content('trust-desc5', 'AI and analytics turn data into actionable insights.', 'about'); ?></p>
            <span data-editable="trust-dna5" <?php echo synergy_style('trust-dna5', 'about'); ?> class="dna"><?php echo synergy_content('trust-dna5', 'INNOVATIVE', 'about'); ?></span>
          </div>

          <div class="trust6-item">
            <span data-editable="trust-icon6" <?php echo synergy_style('trust-icon6', 'about'); ?> class="ic"><?php echo synergy_content('trust-icon6', '<i class="fa-solid fa-handshake" aria-hidden="true"></i>', 'about'); ?></span>
            <h4 data-editable="trust-h6" <?php echo synergy_style('trust-h6', 'about'); ?>><?php echo synergy_content('trust-h6', 'Long-term Partnership', 'about'); ?></h4>
            <p data-editable="trust-desc6" <?php echo synergy_style('trust-desc6', 'about'); ?>><?php echo synergy_content('trust-desc6', 'We stay with you to ensure continuous success.', 'about'); ?></p>
            <span data-editable="trust-dna6" <?php echo synergy_style('trust-dna6', 'about'); ?> class="dna"><?php echo synergy_content('trust-dna6', 'IMPACTFUL', 'about'); ?></span>
          </div>

        </div>
      </div>
    </div>

  </section>



  <!-- SECTION 6B: TRUST & RECOGNITION (Infinite Single-Row Marquee Slider) -->
  <section id="certifications" class="py-16 sm:py-20 bg-white border-t border-slate-100 relative overflow-hidden">
    <style>
      .trust-wrap{
        --tr-green:#006633;
        --tr-rule:#e3e8e5;
        width: 100%;
        overflow: hidden;
      }
      .trust-head{display:flex;align-items:center;justify-content:center;margin:0 0 clamp(26px,3vw,42px)}
      .trust-head .ln{flex:0 1 auto;width:28.75vw;min-width:0;max-width:427px;height:2px;border-radius:2px}
      .trust-head .ln.l{background:linear-gradient(90deg,rgba(0,102,51,0),var(--tr-green))}
      .trust-head .ln.r{background:linear-gradient(270deg,rgba(0,102,51,0),var(--tr-green))}
      .trust-head .dt{width:9px;height:9px;border-radius:50%;background:var(--tr-green);flex:none}
      .trust-head .tt{
        flex:none;padding:0 clamp(14px,1.9vw,28px);text-align:center;white-space:nowrap;
        font-size:clamp(18px,2.4vw,32px);font-weight:700;letter-spacing:.06em;
        text-transform:uppercase;color:var(--tr-green);line-height:1.2;
      }

      /* Single-Row Infinite Marquee Slider */
      @keyframes trustMarquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
      }
      .trust-marquee {
        overflow: hidden;
        position: relative;
        width: 100%;
        mask-image: linear-gradient(to right, transparent, black 6%, black 94%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 6%, black 94%, transparent);
        padding: 10px 0;
      }
      .trust-track {
        display: flex;
        align-items: center;
        gap: 20px;
        width: max-content;
        animation: trustMarquee 26s linear infinite;
      }
      .trust-track:hover {
        animation-play-state: paused;
      }
      .trust-cell {
        flex: 0 0 auto;
        width: 195px;
        height: 112px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 12px 14px;
        text-align: center;
        border: 1px solid var(--tr-rule);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(11, 33, 39, .04);
        transition: transform .25s, box-shadow .25s;
      }
      .trust-cell:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 22px rgba(11, 33, 39, .10);
      }
      .trust-logo {
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .trust-logo img {
        display: block;
        max-height: 100%;
        width: auto;
        max-width: 100%;
        object-fit: contain;
      }
      .trust-cap {
        font-size: 11.5px;
        font-weight: 600;
        line-height: 1.2;
        color: #004aad;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
      }
    </style>

    <div class="w-full trust-wrap">
      <div class="trust-head">
        <span class="ln l" aria-hidden="true"></span>
        <span class="dt" aria-hidden="true"></span>
        <span data-editable="cert-title" <?php echo synergy_style('cert-title', 'about'); ?> class="tt"><?php echo synergy_content('cert-title', 'Trust &amp; Recognition', 'about'); ?></span>
        <span class="dt" aria-hidden="true"></span>
        <span class="ln r" aria-hidden="true"></span>
      </div>

      <div class="trust-marquee">
        <div class="trust-track">

          <!-- Source set. The seamless second half is cloned at runtime by the
               script below, so each logo exists exactly once as editable markup. -->
          <div class="trust-cell">
            <span class="trust-logo">
              <img data-editable-img="cert_img1" src="<?php echo synergy_content('cert_img1_img', get_template_directory_uri() . '/image/trust/iso-9001.png', 'about'); ?>" alt="ISO 9001:2015" loading="lazy" decoding="async">
            </span>
          </div>

          <div class="trust-cell">
            <span class="trust-logo">
              <img data-editable-img="cert_img2" src="<?php echo synergy_content('cert_img2_img', get_template_directory_uri() . '/image/trust/iso-14001.png', 'about'); ?>" alt="ISO 14001:2015" loading="lazy" decoding="async">
            </span>
          </div>

          <div class="trust-cell">
            <span class="trust-logo">
              <img data-editable-img="cert_img3" src="<?php echo synergy_content('cert_img3_img', get_template_directory_uri() . '/image/trust/iso-45001.png', 'about'); ?>" alt="ISO 45001:2018" loading="lazy" decoding="async">
            </span>
          </div>

          <div class="trust-cell">
            <span class="trust-logo">
              <img data-editable-img="cert_img4" src="<?php echo synergy_content('cert_img4_img', get_template_directory_uri() . '/image/trust/nia.png', 'about'); ?>" alt="NIA" loading="lazy" decoding="async">
            </span>
            <span data-editable="cert-cap4" <?php echo synergy_style('cert-cap4', 'about'); ?> class="trust-cap"><?php echo synergy_content('cert-cap4', 'National Innovation Agency', 'about'); ?></span>
          </div>

          <div class="trust-cell">
            <span class="trust-logo">
              <img data-editable-img="cert_img5" src="<?php echo synergy_content('cert_img5_img', get_template_directory_uri() . '/image/trust/21st-tcc-best-awards.png', 'about'); ?>" alt="21st TCC Best Awards" loading="lazy" decoding="async">
            </span>
            <span data-editable="cert-cap5" <?php echo synergy_style('cert-cap5', 'about'); ?> class="trust-cap"><?php echo synergy_content('cert-cap5', '21st TCC Best Awards', 'about'); ?></span>
          </div>

          <div class="trust-cell">
            <span class="trust-logo">
              <img data-editable-img="cert_img6" src="<?php echo synergy_content('cert_img6_img', get_template_directory_uri() . '/image/trust/22st-tcc-best-awards.png', 'about'); ?>" alt="22nd TCC Best Awards" loading="lazy" decoding="async">
            </span>
            <span data-editable="cert-cap6" <?php echo synergy_style('cert-cap6', 'about'); ?> class="trust-cap"><?php echo synergy_content('cert-cap6', '22nd TCC Best Awards', 'about'); ?></span>
          </div>

          <div class="trust-cell">
            <span class="trust-logo">
              <img data-editable-img="cert_img7" src="<?php echo synergy_content('cert_img7_img', get_template_directory_uri() . '/image/trust/iatf-16949.png', 'about'); ?>" alt="IATF 16949" loading="lazy" decoding="async">
            </span>
            <span data-editable="cert-cap7" <?php echo synergy_style('cert-cap7', 'about'); ?> class="trust-cap"><?php echo synergy_content('cert-cap7', 'IATF 16949', 'about'); ?></span>
          </div>

          <div class="trust-cell">
            <span class="trust-logo">
              <img data-editable-img="cert_img8" src="<?php echo synergy_content('cert_img8_img', get_template_directory_uri() . '/image/trust/ipc-a610f.jpg', 'about'); ?>" alt="IPC-A-610F Class 2" loading="lazy" decoding="async">
            </span>
            <span data-editable="cert-cap8" <?php echo synergy_style('cert-cap8', 'about'); ?> class="trust-cap"><?php echo synergy_content('cert-cap8', 'IPC-A-610F Class 2', 'about'); ?></span>
          </div>

        </div>
      </div>
    </div>

    <script>
    /* The marquee animates to translateX(-50%), so the track has to hold the logo
       set twice. Duplicating it in markup meant every logo had two copies to keep
       in sync - and two conflicting data-editable keys. The copy is built here
       instead, with editor attributes stripped so only the source set is editable.
       A MutationObserver rebuilds it whenever the editor swaps a logo. */
    (function(){
      const track = document.querySelector('#certifications .trust-track');
      if (!track) return;

      const source = Array.from(track.children).filter(el => !el.dataset.marqueeClone);
      if (!source.length) return;

      function build(){
        track.querySelectorAll('[data-marquee-clone]').forEach(el => el.remove());
        const frag = document.createDocumentFragment();
        source.forEach(cell => {
          const copy = cell.cloneNode(true);
          copy.dataset.marqueeClone = '1';
          copy.setAttribute('aria-hidden', 'true');
          copy.querySelectorAll('[data-editable], [data-editable-img]').forEach(n => {
            n.removeAttribute('data-editable');
            n.removeAttribute('data-editable-img');
            n.removeAttribute('contenteditable');
          });
          frag.appendChild(copy);
        });
        track.appendChild(frag);
      }
      build();

      if (window.MutationObserver) {
        let pending = null;
        const observer = new MutationObserver(() => {
          clearTimeout(pending);
          pending = setTimeout(build, 150);
        });
        source.forEach(cell => observer.observe(cell, {
          subtree: true, childList: true, characterData: true,
          attributes: true, attributeFilter: ['src']
        }));
      }
    })();
    </script>
  </section>



  <!-- FOOTER CONTAINER -->
  <div id="footer-container" class="bg-ink w-full block"></div>

  <!-- Scripts -->
  <script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/scripts.js') : './components/scripts.js'; ?>"></script>
  <script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/live-editor.js') : './components/live-editor.js'; ?>"></script>
  <?php wp_footer(); ?>
</body>

</html>
