<?php
/* Template Name: Privacy Policy */
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
if (!function_exists('wp_head')) { function wp_head() {} }
if (!function_exists('wp_footer')) { function wp_footer() {} }
if (!function_exists('wp_enqueue_style')) { function wp_enqueue_style() {} }
if (!function_exists('add_action')) { function add_action() {} }
if (!function_exists('add_theme_support')) { function add_theme_support() {} }
if (!function_exists('language_attributes')) { function language_attributes() { echo 'lang="th"'; } }
if (!function_exists('bloginfo')) { function bloginfo($show = '') { echo ''; } }
if (!function_exists('is_front_page')) { function is_front_page() { return false; } }
if (!function_exists('is_home')) { function is_home() { return false; } }
if (file_exists(__DIR__ . '/functions.php')) {
    require_once __DIR__ . '/functions.php';
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>นโยบายความเป็นส่วนตัว | Privacy Policy — Synergy Technology</title>

<meta name="description" content="นโยบายความเป็นส่วนตัวของบริษัท ซีนเนอร์ยี่ เทคโนโลยี จำกัด จัดทำตามพระราชบัญญัติคุ้มครองข้อมูลส่วนบุคคล พ.ศ. 2562 (PDPA)">
<meta name="theme-color" content="#1F6B43">
<meta name="color-scheme" content="light">
<!-- A legal notice should be indexable but carries no SEO value as a preview target. -->
<meta name="robots" content="index, follow">
<link rel="canonical" href="<?php echo home_url('/privacy-policy/'); ?>">

<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/image/s-logo.png">
<link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/image/s-logo.png">
<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/image/s-logo.png">

<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            ink: "#0B1F16", body: "#3A4A41", muted: "#6E8076",
            brand: { DEFAULT: "#1F6B43", deep: "#0E3B2E", soft: "#E9F2EC", bright: "#23862D" },
            gold: { DEFAULT: "#C99700", bright: "#F2C72E" },
            surface: "#F6FAF7"
          },
          fontFamily: { display: ['"Space Grotesk"', 'sans-serif'] }
        }
      }
    }
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Sarabun:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?php echo function_exists('synergy_asset') ? synergy_asset('components/style.css') : './components/style.css'; ?>">

<style>
    body { font-family: 'SukhumvitSet', 'Inter', 'Sarabun', sans-serif; scroll-behavior: smooth; }

    /* ==========================================================================
       LEGAL DOCUMENT TYPE SCALE

       Same reasoning as the other templates: components/style.css pins every Tailwind
       step with !important and its selectors also catch the responsive variants, so
       utility classes cannot be trusted for size here. These are rem values taken from
       the site's own scale (root 17px / 18.5px from 1024px up):
         0.875rem = text-xs 14.9-16.2   0.975rem = text-sm 16.6-18.0
         1.075rem = text-base 18.3-19.9 1.25rem  = text-lg 21.2-23.1
       Body copy sits on text-base and the Thai leading is 1.9 — legal text is read
       closely and in long stretches, so it gets more room than marketing copy.
       ========================================================================== */
    .pp-h1 { font-size: clamp(28px, 3.4vw, 46px) !important; line-height: 1.18 !important; font-weight: 800; letter-spacing: -.02em; }
    .pp-h2 { font-size: 1.25rem !important; line-height: 1.35 !important; font-weight: 800; }
    .pp-p  { font-size: 1.075rem !important; line-height: 1.9 !important; }
    .pp-sm { font-size: 0.975rem !important; line-height: 1.8 !important; }
    .pp-xs { font-size: 0.875rem !important; line-height: 1.7 !important; }

    .pp-shell { width: 100%; max-width: 980px; margin-inline: auto; padding-inline: clamp(20px, 4vw, 40px); }

    .pp-sec { padding-top: clamp(26px, 3vw, 42px); }
    .pp-sec + .pp-sec { border-top: 1px solid #eef2f0; margin-top: clamp(26px, 3vw, 42px); }
    .pp-num {
      display: inline-flex; align-items: center; justify-content: center;
      width: 2em; height: 2em; flex: none; border-radius: 10px;
      background: #E9F2EC; color: #1F6B43; font-weight: 800;
      font-size: 0.975rem !important; line-height: 1 !important;
    }
    .pp-list { list-style: none; margin: 14px 0 0; padding: 0; display: grid; gap: 10px; }
    .pp-list li { display: flex; gap: 11px; align-items: flex-start; }
    .pp-list li::before {
      content: ''; flex: none; width: 7px; height: 7px; margin-top: .62em;
      border-radius: 50%; background: #23862D;
    }

    /* the cookie table has to stay readable on a phone without shrinking the type */
    .pp-tablewrap { overflow-x: auto; margin-top: 16px; border: 1px solid #e6ece8; border-radius: 14px; }
    .pp-table { width: 100%; border-collapse: collapse; min-width: 620px; }
    .pp-table th, .pp-table td {
      text-align: left; padding: 12px 14px; border-bottom: 1px solid #eef2f0; vertical-align: top;
      font-size: 0.875rem !important; line-height: 1.65 !important;
    }
    .pp-table th { background: #f6f8f7; font-weight: 800; color: #0B1F16; white-space: nowrap; }
    .pp-table tr:last-child td { border-bottom: 0; }
    .pp-table code { font-family: 'Courier New', monospace; background: #f3f6f4; padding: 2px 6px; border-radius: 5px; }
</style>

<script>
    window.wpThemeUrl = "<?php echo get_template_directory_uri(); ?>/";
    window.wpThemeUri = "<?php echo get_template_directory_uri(); ?>/";
</script>
<?php wp_head(); ?>
</head>
<body <?php body_class("bg-white text-body antialiased"); ?>>

<a class="skip-link fixed top-3 left-3 z-[99999] bg-brand text-white px-5 py-2.5 rounded-full font-bold -translate-y-24 focus:translate-y-0 transition duration-200" href="#main" style="font-size:0.975rem">ข้ามไปยังเนื้อหาหลัก</a>

<div id="navbar-container"></div>

<main id="main">

  <!-- ================= HEADER ================= -->
  <section class="bg-surface border-b border-slate-100 py-10 sm:py-14">
    <div class="pp-shell">
      <p class="text-brand font-extrabold uppercase mb-3" style="font-size:0.875rem;letter-spacing:.16em">
        <span class="lang-th">ข้อมูลทางกฎหมาย</span>
        <span class="lang-en">LEGAL</span>
      </p>
      <h1 class="pp-h1 font-display text-ink">
        <span class="lang-th">นโยบายความเป็นส่วนตัว</span>
        <span class="lang-en">Privacy Policy</span>
      </h1>
      <p class="pp-p text-body mt-4">
        สำหรับเว็บไซต์บริษัท ซีนเนอร์ยี่ เทคโนโลยี จำกัด (Synergy Technology Co., Ltd.)
      </p>
      <p class="pp-sm text-muted mt-2">
        <span class="lang-th">มีผลบังคับใช้: 24 กรกฎาคม 2569</span>
        <span class="lang-en">Effective: 24 July 2026</span>
      </p>
    </div>
  </section>

  <!-- ================= BODY ================= -->
  <section class="py-8 sm:py-12">
    <div class="pp-shell">

      <p class="pp-p text-body">
        บริษัท ซีนเนอร์ยี่ เทคโนโลยี จำกัด (&ldquo;บริษัท&rdquo;, &ldquo;เรา&rdquo;) ให้ความสำคัญกับการคุ้มครองข้อมูลส่วนบุคคลของลูกค้า คู่ค้า ผู้เยี่ยมชมเว็บไซต์ ผู้สมัครงาน และผู้ติดต่อทุกท่าน นโยบายฉบับนี้จัดทำขึ้นเพื่ออธิบายแนวทางการเก็บรวบรวม ใช้ เปิดเผย และเก็บรักษาข้อมูลส่วนบุคคลของท่านเมื่อเข้าใช้งานเว็บไซต์หรือใช้บริการของบริษัท ให้เป็นไปตามพระราชบัญญัติคุ้มครองข้อมูลส่วนบุคคล พ.ศ. 2562 (PDPA)
      </p>

      <!-- 1 -->
      <div class="pp-sec">
        <div class="flex items-center gap-3">
          <span class="pp-num">1</span>
          <h2 class="pp-h2 font-display text-ink">ข้อมูลส่วนบุคคลที่เราเก็บรวบรวม</h2>
        </div>
        <ul class="pp-list pp-p text-body">
          <li>ชื่อ-นามสกุล</li>
          <li>ชื่อบริษัทหรือองค์กร</li>
          <li>ตำแหน่งงาน</li>
          <li>อีเมล</li>
          <li>หมายเลขโทรศัพท์</li>
          <li>รายละเอียดโครงการหรือความต้องการ</li>
          <li>ข้อมูลการใช้งานเว็บไซต์ เช่น IP Address, Browser, Device, Cookies และ Log</li>
        </ul>
      </div>

      <!-- 2 -->
      <div class="pp-sec">
        <div class="flex items-center gap-3">
          <span class="pp-num">2</span>
          <h2 class="pp-h2 font-display text-ink">ช่องทางการเก็บข้อมูล</h2>
        </div>
        <ul class="pp-list pp-p text-body">
          <li>แบบฟอร์ม Contact Us</li>
          <li>Request Demo</li>
          <li>Request Quotation</li>
          <li>ดาวน์โหลด Brochure หรือ Company Profile</li>
          <li>อีเมล โทรศัพท์ หรือช่องทางติดต่ออื่น</li>
          <li>การใช้งานเว็บไซต์</li>
        </ul>
      </div>

      <!-- 3 -->
      <div class="pp-sec">
        <div class="flex items-center gap-3">
          <span class="pp-num">3</span>
          <h2 class="pp-h2 font-display text-ink">วัตถุประสงค์ในการประมวลผลข้อมูล</h2>
        </div>
        <ul class="pp-list pp-p text-body">
          <li>ติดต่อกลับตามคำขอ</li>
          <li>จัดทำใบเสนอราคา</li>
          <li>นำเสนอสินค้าและบริการ</li>
          <li>นัดหมายการประชุมหรือสาธิตระบบ</li>
          <li>บริการหลังการขาย</li>
          <li>ปรับปรุงเว็บไซต์และประสบการณ์ผู้ใช้งาน</li>
          <li>ส่งข่าวสารเมื่อได้รับความยินยอม</li>
        </ul>
      </div>

      <!-- 4 -->
      <div class="pp-sec">
        <div class="flex items-center gap-3">
          <span class="pp-num">4</span>
          <h2 class="pp-h2 font-display text-ink">ฐานกฎหมาย</h2>
        </div>
        <ul class="pp-list pp-p text-body">
          <li>ความยินยอม</li>
          <li>การปฏิบัติตามสัญญา</li>
          <li>ประโยชน์โดยชอบด้วยกฎหมาย</li>
          <li>การปฏิบัติตามกฎหมาย</li>
        </ul>
      </div>

      <!-- 5 -->
      <div class="pp-sec">
        <div class="flex items-center gap-3">
          <span class="pp-num">5</span>
          <h2 class="pp-h2 font-display text-ink">การเปิดเผยข้อมูล</h2>
        </div>
        <ul class="pp-list pp-p text-body">
          <li>บริษัทจะไม่ขายข้อมูลส่วนบุคคล</li>
          <li>อาจเปิดเผยแก่ผู้ให้บริการระบบ Cloud, CRM, Email, Website Analytics หรือหน่วยงานรัฐตามกฎหมาย โดยเปิดเผยเฉพาะเท่าที่จำเป็น</li>
        </ul>
      </div>

      <!-- 6 -->
      <div class="pp-sec">
        <div class="flex items-center gap-3">
          <span class="pp-num">6</span>
          <h2 class="pp-h2 font-display text-ink">ระยะเวลาการเก็บรักษา</h2>
        </div>
        <ul class="pp-list pp-p text-body">
          <li>บริษัทจะเก็บรักษาข้อมูลเท่าที่จำเป็นต่อวัตถุประสงค์ทางธุรกิจ หรือเป็นไปตามระยะเวลาที่กฎหมายกำหนด ก่อนลบหรือทำให้ไม่สามารถระบุตัวบุคคลได้</li>
        </ul>
      </div>

      <!-- 7 -->
      <div class="pp-sec">
        <div class="flex items-center gap-3">
          <span class="pp-num">7</span>
          <h2 class="pp-h2 font-display text-ink">การรักษาความมั่นคงปลอดภัย</h2>
        </div>
        <ul class="pp-list pp-p text-body">
          <li>ใช้มาตรการควบคุมสิทธิ์การเข้าถึง การเข้ารหัสข้อมูลตามความเหมาะสม การสำรองข้อมูล และมาตรการป้องกันระบบสารสนเทศ</li>
        </ul>
      </div>

      <!-- 8 — cookies -->
      <div class="pp-sec" id="cookies" style="scroll-margin-top:110px">
        <div class="flex items-center gap-3">
          <span class="pp-num">8</span>
          <h2 class="pp-h2 font-display text-ink">คุกกี้</h2>
        </div>
        <ul class="pp-list pp-p text-body">
          <li>เว็บไซต์ใช้คุกกี้ที่จำเป็น คุกกี้เพื่อการวิเคราะห์ และคุกกี้เพื่อพัฒนาประสบการณ์การใช้งาน ผู้ใช้งานสามารถจัดการการตั้งค่าคุกกี้ผ่าน Browser หรือ Cookie Settings</li>
        </ul>

        <p class="pp-sm text-body mt-6 font-bold">
          <span class="lang-th">รายการคุกกี้และข้อมูลที่จัดเก็บบนเบราว์เซอร์ของท่าน</span>
          <span class="lang-en">Cookies and browser storage used on this site</span>
        </p>

        <!-- This table lists what the site actually stores today, verified in the source.
             When analytics or marketing tags are added, add their rows here as well. -->
        <div class="pp-tablewrap">
          <table class="pp-table">
            <thead>
              <tr>
                <th>ชื่อ</th>
                <th>ประเภท</th>
                <th>วัตถุประสงค์</th>
                <th>อายุ</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><code>synergy_cookie_consent</code></td>
                <td>จำเป็น</td>
                <td>บันทึกการตั้งค่าคุกกี้และวันเวลาที่ท่านให้ความยินยอม เพื่อไม่ต้องสอบถามซ้ำและใช้เป็นหลักฐานตาม PDPA</td>
                <td>1 ปี</td>
              </tr>
              <tr>
                <td><code>preferred-language</code></td>
                <td>จำเป็น</td>
                <td>จดจำภาษาที่ท่านเลือก (ไทย / อังกฤษ) จัดเก็บใน Local Storage ไม่ใช่คุกกี้ และไม่ถูกส่งไปยังเซิร์ฟเวอร์</td>
                <td>จนกว่าจะล้างข้อมูลเบราว์เซอร์</td>
              </tr>
              <tr>
                <td><code>synergy_admin_auth</code></td>
                <td>จำเป็น</td>
                <td>ใช้กับระบบแก้ไขเนื้อหาสำหรับผู้ดูแลเว็บไซต์เท่านั้น ไม่ถูกตั้งค่าให้ผู้เยี่ยมชมทั่วไป</td>
                <td>จนกว่าจะออกจากระบบ</td>
              </tr>
            </tbody>
          </table>
        </div>

        <p class="pp-xs text-muted mt-4">
          <span class="lang-th">ปัจจุบันเว็บไซต์ยังไม่ได้ติดตั้งคุกกี้เพื่อการวิเคราะห์หรือการตลาดจากผู้ให้บริการภายนอก หากมีการติดตั้งในอนาคต จะทำงานเฉพาะเมื่อท่านให้ความยินยอมผ่านแถบตั้งค่าคุกกี้เท่านั้น</span>
          <span class="lang-en">The site does not currently load third-party analytics or marketing cookies. If any are added, they will run only after you grant consent in the cookie settings.</span>
        </p>

        <button type="button" onclick="window.synergyConsent && window.synergyConsent.open()"
          class="mt-6 inline-flex items-center gap-2 bg-brand hover:bg-brand-deep text-white font-extrabold px-6 py-3 rounded-xl transition"
          style="font-size:0.975rem">
          <i class="fa-solid fa-sliders"></i>
          <span class="lang-th">เปิดการตั้งค่าคุกกี้</span>
          <span class="lang-en">Open cookie settings</span>
        </button>
      </div>

      <!-- 9 -->
      <div class="pp-sec">
        <div class="flex items-center gap-3">
          <span class="pp-num">9</span>
          <h2 class="pp-h2 font-display text-ink">สิทธิของเจ้าของข้อมูล</h2>
        </div>
        <ul class="pp-list pp-p text-body">
          <li>สิทธิขอเข้าถึง แก้ไข ลบ ระงับ คัดค้าน ถอนความยินยอม และขอรับหรือโอนย้ายข้อมูล ตามที่กฎหมายกำหนด</li>
        </ul>
      </div>

      <!-- 10 -->
      <div class="pp-sec">
        <div class="flex items-center gap-3">
          <span class="pp-num">10</span>
          <h2 class="pp-h2 font-display text-ink">การเปลี่ยนแปลงนโยบาย</h2>
        </div>
        <ul class="pp-list pp-p text-body">
          <li>บริษัทอาจปรับปรุงนโยบายนี้เป็นครั้งคราว โดยประกาศฉบับล่าสุดบนเว็บไซต์</li>
        </ul>
      </div>

      <!-- 11 -->
      <div class="pp-sec">
        <div class="flex items-center gap-3">
          <span class="pp-num">11</span>
          <h2 class="pp-h2 font-display text-ink">ติดต่อเรา</h2>
        </div>
        <div class="mt-4 bg-surface border border-slate-100 rounded-2xl p-6 sm:p-7">
          <ul class="pp-list pp-p text-body" style="margin-top:0">
            <li><strong>Synergy Technology Co., Ltd.</strong></li>
            <li>96 หมู่ 1 ต.คลองหนึ่ง อ.คลองหลวง จ.ปทุมธานี 12120</li>
            <li>โทรศัพท์: <a href="tel:+6625161594" class="text-brand font-bold hover:underline">+66 2 516 1594</a></li>
            <li>อีเมล: <a href="mailto:sales@syntechnology.com" class="text-brand font-bold hover:underline">sales@syntechnology.com</a></li>
          </ul>
        </div>
      </div>

    </div>
  </section>
</main>

<div id="footer-container" class="bg-ink w-full block"></div>

<script src="<?php echo function_exists('synergy_asset') ? synergy_asset('components/scripts.js') : './components/scripts.js'; ?>"></script>
<?php include __DIR__ . '/components/cookie-consent.php'; ?>
<?php wp_footer(); ?>
</body>
</html>
