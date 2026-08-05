document.addEventListener('DOMContentLoaded', () => {
  const savedLang = localStorage.getItem('preferred-language') || 'th';
  document.documentElement.setAttribute('lang', savedLang);
  const isWordPress = typeof window.wpThemeUri !== 'undefined' || typeof window.wpThemeUrl !== 'undefined';
  const cleanPath = window.location.pathname.replace(/^\/|\/$/g, '');
  const pathParts = cleanPath.split('/');
  const pageSlug = pathParts[pathParts.length - 1] || 'index';
  
  const pageName = isWordPress ? (pageSlug === 'index' ? 'index.php' : pageSlug + '.php') : (window.location.pathname.split('/').pop() || 'index.php').toLowerCase();
  const isHomePage = isWordPress ? (cleanPath === '' || cleanPath === 'home') : (pageName === '' || pageName === 'index.php' || pageName === 'index.html' || pageName === 'syntech.html');
  const isInSolutionsFolder = window.location.pathname.includes('/solutions/');
  // depth below /solutions/ (e.g. /solutions/smart-agriculture/rice-awd.html → 1 extra level)
  const solutionsSubDepth = isInSolutionsFolder
    ? Math.max(0, window.location.pathname.split('/solutions/')[1].split('/').length - 1)
    : 0;
  const upPrefix = isInSolutionsFolder ? '../'.repeat(1 + solutionsSubDepth) : '';
  const navbarOffset = 96;

  const getAssetPath = (relativeSubPath) => {
    if (isWordPress && (window.wpThemeUri || window.wpThemeUrl)) {
      const baseUri = window.wpThemeUri || window.wpThemeUrl;
      return baseUri.replace(/\/$/, '') + '/' + relativeSubPath.replace(/^\//, '');
    }
    const rawPath = window.location.pathname;
    if (rawPath.includes('/solutions/')) {
      return upPrefix + relativeSubPath.replace(/^\//, '');
    }
    if (rawPath.endsWith('/') && rawPath !== '/') {
      return '../' + relativeSubPath.replace(/^\//, '');
    }
    return relativeSubPath.replace(/^\//, '');
  };

  // ===== DYNAMIC CMS DATA LOADER =====
  fetch(getAssetPath('content/site_data.json'))
    .then(res => res.json())
    .then(data => {
      if (!data) return;
      document.querySelectorAll('[data-cms]').forEach(el => {
        const key = el.getAttribute('data-cms');
        if (data[key]) {
          el.innerHTML = data[key];
        }
      });
    })
    .catch(() => {});

  // ===== SUKHUMVIT SET FONT INJECTION =====
  const fontPrefix = getAssetPath('fonts/');
  const sukhumvitStyle = document.createElement('style');
  sukhumvitStyle.textContent = `
    @font-face {
      font-family: 'SukhumvitSet';
      font-family: 'SukhumvitSet';
      src: url('${fontPrefix}SukhumvitSet-Light.ttf') format('truetype');
      font-weight: 300;
      font-style: normal;
      font-display: swap;
    }
    @font-face {
      font-family: 'SukhumvitSet';
      src: url('${fontPrefix}SukhumvitSet-Text.ttf') format('truetype');
      font-weight: 400;
      font-style: normal;
      font-display: swap;
    }
    @font-face {
      font-family: 'SukhumvitSet';
      src: url('${fontPrefix}SukhumvitSet-Medium.ttf') format('truetype');
      font-weight: 500;
      font-style: normal;
      font-display: swap;
    }
    @font-face {
      font-family: 'SukhumvitSet';
      src: url('${fontPrefix}SukhumvitSet-SemiBold.ttf') format('truetype');
      font-weight: 600;
      font-style: normal;
      font-display: swap;
    }
    @font-face {
      font-family: 'SukhumvitSet';
      src: url('${fontPrefix}SukhumvitSet-Bold.ttf') format('truetype');
      font-weight: 700;
      font-style: normal;
      font-display: swap;
    }
    @font-face {
      font-family: 'SukhumvitSet';
      src: url('${fontPrefix}SukhumvitSet-Bold.ttf') format('truetype');
      font-weight: 800;
      font-style: normal;
      font-display: swap;
    }
    @font-face {
      font-family: 'SukhumvitSet';
      src: url('${fontPrefix}SukhumvitSet-Bold.ttf') format('truetype');
      font-weight: 900;
      font-style: normal;
      font-display: swap;
    }

    /* Apply SukhumvitSet to entire navbar and footer */
    nav,
    nav *,
    #mobileMenu,
    #mobileMenu *,
    footer,
    footer * {
      font-family: 'SukhumvitSet', sans-serif !important;
    }

    /* ===== APPLY TO ENTIRE WEBSITE ===== */
    body, html {
      font-family: 'SukhumvitSet', sans-serif !important;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      text-rendering: optimizeLegibility;
    }

    h1, h2, h3, h4, h5, h6,
    p, span, a, li, td, th,
    button, input, select, textarea, label,
    div, section, article, aside, header, main, footer, nav {
      font-family: 'SukhumvitSet', sans-serif !important;
    }

    /* TYPOGRAPHY FINE-TUNING FOR AESTHETICS */
    h1, h2, h3, h4, h5, h6 {
      letter-spacing: -0.015em !important;
      line-height: 1.25 !important;
    }

    p {
      line-height: 1.625 !important;
      letter-spacing: -0.005em !important;
    }

    /* .font-display ใช้ SukhumvitSet แทน */
    .font-display,
    [class*="font-display"] {
      font-family: 'SukhumvitSet', sans-serif !important;
    }

    /* EXCLUDE Font Awesome icons — ต้องยกเว้นไม่งั้น icon หาย */
    i, .fa, .fas, .far, .fab,
    .fa-solid, .fa-regular, .fa-brands,
    [class^="fa-"], [class*=" fa-"] {
      font-family: 'Font Awesome 6 Free', 'Font Awesome 6 Brands' !important;
    }

    /* EXCLUDE code/mono blocks */
    code, pre, kbd, samp, .font-mono {
      font-family: 'Courier New', Courier, monospace !important;
    }
    
    
    /* ===== WORDPRESS ADMIN BAR OVERLAPPING FIX ===== */
    body.admin-bar nav.fixed,
    .admin-bar nav.fixed,
    #wpadminbar ~ nav.fixed {
      top: 32px !important;
    }
    @media screen and (max-width: 782px) {
      body.admin-bar nav.fixed,
      .admin-bar nav.fixed,
      #wpadminbar ~ nav.fixed {
        top: 46px !important;
      }
    }

    /* ===== LANGUAGE TOGGLE TRANSITIONS & VISIBILITY ===== */
    html[lang="th"] .lang-en { display: none !important; }
    html[lang="en"] .lang-th { display: none !important; }
    /* ===================================== */
  `;
  document.head.appendChild(sukhumvitStyle);
  // ========================================

  // prefix to reach root from any depth (in WordPress mode, use theme URI)
  const rootPrefix = (typeof window.wpThemeUrl !== 'undefined' ? window.wpThemeUrl : (typeof window.wpThemeUri !== 'undefined' ? window.wpThemeUri : upPrefix));

  const homeHref = (hash = '') => {
    if (isWordPress) {
      if (window.location.pathname.endsWith('.php') || window.location.pathname.includes('.php/')) {
        return `index.php${hash}`;
      }
      return `/${hash}`;
    }
    if (isHomePage) return hash || '#top';
    return `${rootPrefix}index.php${hash}`;
  };

  const pageHref = (file) => {
    const cleanFile = file.replace('.html', '').replace('.php', '');
    if (isWordPress) {
      if (cleanFile === 'index') return '/';
      if (window.location.pathname.endsWith('.php') || window.location.pathname.includes('.php/')) {
        return `${rootPrefix}${cleanFile}.php`;
      }
      return `/${cleanFile}`;
    }
    return `${rootPrefix}${file}`;
  };
  const solutionHref = (file) => `${rootPrefix}solutions/${file}`;

  // ─── NAV STRUCTURE ───────────────────────────────────────────
  const navItems = [
    { label: '<span class="lang-th">หน้าแรก</span><span class="lang-en">Home</span>', href: homeHref('#top'), page: 'index.html', section: 'top' },
    {
      label: '<span class="lang-th">โซลูชัน</span><span class="lang-en">Solutions</span>',
      href: homeHref('#solutions'),
      page: 'index.html',
      section: 'solutions',
      megaCol: [
        {
          heading: 'Smart Solutions',
          icon: 'fa-solid fa-layer-group',
          items: [
            { label: '<span class="lang-th">1. Smart Factory</span><span class="lang-en">1. Smart Factory</span>', href: homeHref('#solutions') },
            { label: '<span class="lang-th">2. Smart Energy</span><span class="lang-en">2. Smart Energy</span>', href: pageHref('smart-energy.php') },
            { label: '<span class="lang-th">3. Smart Agriculture</span><span class="lang-en">3. Smart Agriculture</span>', href: homeHref('#solutions') }
          ]
        }
      ]
    },
    {
      label: '<span class="lang-th">บริการ</span><span class="lang-en">Services</span>',
      href: pageHref('service.php'),
      page: 'service.php',
      megaCol: [
        {
          heading: 'Engineering & Manufacturing Services',
          icon: 'fa-solid fa-microchip',
          items: [
            {
              label: '<span class="lang-th">1. R&D & Hardware Engineering</span><span class="lang-en">1. R&D & Hardware Engineering</span>',
              href: `${pageHref('service.php')}#capabilities`
            },
            {
              label: '<span class="lang-th">2. Turnkey Manufacturing (OEM/ODM)</span><span class="lang-en">2. Turnkey Manufacturing (OEM/ODM)</span>',
              href: `${pageHref('service.php')}#process`
            },
            {
              label: '<span class="lang-th">3. Quality & Standards Certification</span><span class="lang-en">3. Quality & Standards Certification</span>',
              href: `${pageHref('service.php')}#why-us`
            },
            {
              label: '<span class="lang-th">4. Smart Solution Integration</span><span class="lang-en">4. Smart Solution Integration</span>',
              href: `${pageHref('service.php')}#capabilities`
            }
          ]
        }
      ]
    },
    { label: '<span class="lang-th">ผลงานจริง</span><span class="lang-en">Case Studies</span>', href: homeHref('#success-stories'), page: 'index.html', section: 'success-stories' },
    { label: '<span class="lang-th">เกี่ยวกับเรา</span><span class="lang-en">About Us</span>', href: pageHref('about.php'), page: 'about.php' }
  ];


  // ─── RENDER mega-menu (desktop) ─────────────────────────────
  const renderMegaMenu = (item) => {
    const cols = item.megaCol.map(col => `
      <div class="min-w-[200px] flex-1">
        <div class="flex items-center gap-2 mb-3 pb-2.5 border-b border-slate-100/80">
          <div class="w-6 h-6 rounded-lg bg-brand/5 border border-brand/10 flex items-center justify-center shrink-0">
            <i class="${col.icon} text-brand text-xs"></i>
          </div>
          <span class="text-xs font-800 text-brand uppercase tracking-wider">${col.heading}</span>
        </div>
        <div class="space-y-1">
          ${col.items.map(sub => `
            <a href="${sub.href}" data-nav-link class="flex items-center px-3 py-2.5 rounded-xl hover:bg-slate-50 hover:border-slate-100 border border-transparent transition duration-200 group">
              <span class="text-[13px] font-700 text-ink group-hover:text-brand leading-snug transition-colors">${sub.label}</span>
            </a>`).join('')}
        </div>
      </div>`).join('');
    const n = item.megaCol.length;
    // Premium layouts based on columns count
    const w = n === 1 ? 'w-[310px]' : n === 2 ? 'w-[520px]' : 'w-[760px]';
    return `
      <div class="nav-dropdown-wrap relative group py-2">
        <a href="${item.href}" data-nav-link data-page="${item.page || ''}" data-section="${item.section || ''}" data-sol-tab="${item.isSolTab || ''}"
          class="nav-link text-ink hover:text-brand transition-colors duration-200 flex items-center gap-1.5 font-bold tracking-wide">
          ${item.label}
          <i class="fa-solid fa-chevron-down text-[8px] text-muted group-hover:text-brand transition-transform duration-300 group-hover:rotate-180"></i>
        </a>
        <div class="nav-dropdown absolute top-full left-1/2 -translate-x-1/2 mt-2 ${w} bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.08)] border border-slate-100/80 p-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50">
          <div class="absolute -top-1.5 left-1/2 -translate-x-1/2 w-3.5 h-3.5 bg-white border-l border-t border-slate-100/80 rotate-45 rounded-tl-sm"></div>
          <div class="flex gap-6 relative z-10">${cols}</div>
        </div>
      </div>`;
  };

  // ─── RENDER mobile flat menu ─────────────────────────────────
  const renderMobileMenu = (item) => {
    const subLinks = item.megaCol.flatMap(col =>
      col.items.map(sub => `
        <a href="${sub.href}" class="py-2 pl-4 border-l-2 border-slate-100 text-body hover:text-brand hover:border-brand transition-all text-xs flex gap-2.5 items-center">
          <i class="${col.icon} text-brand text-[10px] w-3"></i>
          <span class="font-bold text-[12.5px]">${sub.label}</span>
        </a>`)
    ).join('');
    return `
      <div class="flex flex-col gap-1 border-b border-slate-100/60 pb-2">
        <a href="${item.href}" data-nav-link data-page="${item.page || ''}" data-section="${item.section || ''}" data-sol-tab="${item.isSolTab || ''}" class="nav-link text-ink hover:text-brand transition py-2 font-800 text-xs">${item.label}</a>
        <div class="flex flex-col gap-1.5 pl-2">${subLinks}</div>
      </div>`;
  };

  const renderNavLinks = (mobile = false) =>
    navItems.map(item => {
      if (!mobile && item.megaCol) return renderMegaMenu(item);
      if (mobile && item.megaCol) return renderMobileMenu(item);
      const active = item.page && item.page === pageName && !item.section ? ' text-brand !font-900 border-b-2 border-brand' : '';
      return `<a href="${item.href}" data-nav-link data-page="${item.page || ''}" data-section="${item.section || ''}" data-sol-tab="${item.isSolTab || ''}" class="nav-link text-ink hover:text-brand transition-colors duration-200 py-2 ${mobile ? 'border-b border-slate-100/60 font-800 text-xs pb-3' : 'font-bold tracking-wide'}${active}">${item.label}</a>`;
    }).join('');

  const navbarContainer = document.getElementById('navbar-container');
  if (navbarContainer) {
    navbarContainer.innerHTML = `
      <nav class="fixed top-0 left-0 right-0 z-[9999] bg-white/95 backdrop-blur-md border-b border-slate-100/80 shadow-[0_2px_15px_rgba(0,0,0,0.015)] transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
          <a href="${homeHref('#top')}" class="flex items-center group">
            <img src="data:image/png;base64,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" alt="SYNTECH" class="h-9 sm:h-11 w-auto object-contain transition-transform group-hover:scale-105 duration-300" />
          </a>
          <div class="hidden xl:flex items-center gap-8 text-sm sm:text-base font-800 uppercase tracking-wider text-ink">
            ${renderNavLinks()}
            <button id="langToggleBtn" class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg border border-slate-200 text-ink hover:text-brand hover:border-brand transition duration-200 text-sm font-extrabold tracking-wider">
              <span class="lang-en inline-flex items-center gap-1.5"><svg viewBox="0 0 60 30" class="w-5 h-3 rounded-[2px] shrink-0" aria-hidden="true"><rect width="60" height="30" fill="#012169"/><path d="M0 0L60 30M60 0L0 30" stroke="#fff" stroke-width="6"/><path d="M0 0L60 30M60 0L0 30" stroke="#C8102E" stroke-width="4"/><rect x="25" width="10" height="30" fill="#fff"/><rect y="10" width="60" height="10" fill="#fff"/><rect x="27" width="6" height="30" fill="#C8102E"/><rect y="12" width="60" height="6" fill="#C8102E"/></svg>EN</span>
              <span class="lang-th inline-flex items-center gap-1.5"><svg viewBox="0 0 30 20" class="w-5 h-3 rounded-[2px] shrink-0" aria-hidden="true"><rect width="30" height="20" fill="#F4F5F8"/><rect width="30" height="3.4" fill="#A51931"/><rect y="16.6" width="30" height="3.4" fill="#A51931"/><rect y="7" width="30" height="6" fill="#2D2A4A"/></svg>TH</span>
            </button>
            <a href="${pageHref('contact.html')}" data-contact-link class="bg-brand text-white px-6 py-3 rounded-xl hover:bg-brand-deep transition-all shadow-md shadow-brand/5 font-extrabold text-sm uppercase tracking-wider hover:-translate-y-0.5 duration-200">ติดต่อเรา</a>
          </div>
          <button id="mobileMenuBtn" class="xl:hidden w-11 h-11 flex items-center justify-center rounded-xl hover:bg-slate-50 border border-slate-100 transition duration-200" aria-label="Toggle mobile menu">
            <i class="fa-solid fa-bars text-xl text-ink"></i>
          </button>
        </div>
        <div id="mobileMenu" class="hidden xl:hidden bg-white border-t border-slate-100/80 shadow-2xl max-h-[85vh] overflow-y-auto">
          <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col gap-5 text-sm sm:text-base font-800 uppercase tracking-wider text-ink">
            ${renderNavLinks(true)}
            <div class="flex items-center justify-between border-t border-slate-100/60 pt-4 mt-2">
              <span class="text-sm text-muted font-bold normal-case">ภาษา / Language</span>
              <button id="langToggleBtn" class="flex items-center gap-1 px-3.5 py-2 rounded-lg border border-slate-200 text-ink hover:text-brand hover:border-brand transition duration-200 text-sm font-extrabold tracking-wider">
                <span class="lang-en inline-flex items-center gap-2"><svg viewBox="0 0 60 30" class="w-5 h-3 rounded-[2px] shrink-0" aria-hidden="true"><rect width="60" height="30" fill="#012169"/><path d="M0 0L60 30M60 0L0 30" stroke="#fff" stroke-width="6"/><path d="M0 0L60 30M60 0L0 30" stroke="#C8102E" stroke-width="4"/><rect x="25" width="10" height="30" fill="#fff"/><rect y="10" width="60" height="10" fill="#fff"/><rect x="27" width="6" height="30" fill="#C8102E"/><rect y="12" width="60" height="6" fill="#C8102E"/></svg>ENGLISH (EN)</span>
                <span class="lang-th inline-flex items-center gap-2"><svg viewBox="0 0 30 20" class="w-5 h-3 rounded-[2px] shrink-0" aria-hidden="true"><rect width="30" height="20" fill="#F4F5F8"/><rect width="30" height="3.4" fill="#A51931"/><rect y="16.6" width="30" height="3.4" fill="#A51931"/><rect y="7" width="30" height="6" fill="#2D2A4A"/></svg>ไทย (TH)</span>
              </button>
            </div>
            <a href="${pageHref('contact.html')}" data-contact-link class="bg-brand text-white text-center py-4 rounded-xl hover:bg-brand-deep shadow-md font-extrabold text-sm uppercase tracking-wider transition duration-200 mt-2">ติดต่อเรา</a>
          </div>
        </div>
      </nav>
    `;
  }

  const footerContainer = document.getElementById('footer-container');
  if (footerContainer) {
    footerContainer.className = 'bg-ink w-full block';
    footerContainer.innerHTML = `
      <footer id="footer" class="bg-ink text-white relative overflow-hidden w-full">
        <!-- Brand accent line -->
        <div class="h-1 w-full bg-gradient-to-r from-brand via-gold-bright to-brand opacity-80"></div>

        <div class="w-full max-w-[1700px] mx-auto px-6 sm:px-10 lg:px-16 pt-14 pb-8">
          <!-- 4-Column Grid -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12 mb-12">

            <!-- Col 1: Brand & Info (lg:col-span-4) -->
            <div class="lg:col-span-4 space-y-4">
              <div class="inline-flex">
                <img src="data:image/png;base64,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" alt="SYNTECH" class="h-9 w-auto object-contain" />
              </div>
              <div>
                <h3 class="text-sm font-bold text-white tracking-wide">
                  <span class="lang-th">บริษัท ซีนเนอร์ยี่ เทคโนโลยี จำกัด</span>
                  <span class="lang-en">Synergy Technology Co., Ltd.</span>
                </h3>
              </div>
              <p class="text-xs text-white/60 leading-relaxed max-w-md">
                <span class="lang-th">We Integrate Engineering and Intelligence — วิศวกรรม AIoT ครบวงจร ตั้งแต่ออกแบบ ผลิต จนถึงแพลตฟอร์มอัจฉริยะเพื่อธุรกิจ</span>
                <span class="lang-en">We Integrate Engineering and Intelligence — end-to-end AIoT engineering, from design and manufacturing to intelligent business platforms.</span>
              </p>

              <!-- Social links -->
              <div class="flex items-center gap-2 pt-1">
                <a href="https://lin.ee/5n3UprV" target="_blank" rel="noopener" aria-label="LINE" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white/80 hover:bg-brand hover:text-white transition-colors" title="LINE Official Account"><i class="fa-brands fa-line text-base"></i></a>
                <a href="https://www.facebook.com/SynergyTechnology" target="_blank" rel="noopener" aria-label="Facebook" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white/80 hover:bg-brand hover:text-white transition-colors" title="Facebook"><i class="fa-brands fa-facebook-f text-xs"></i></a>
                <a href="https://www.youtube.com/@syntechofficial" target="_blank" rel="noopener" aria-label="YouTube" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white/80 hover:bg-brand hover:text-white transition-colors" title="YouTube"><i class="fa-brands fa-youtube text-xs"></i></a>
                <a href="https://www.linkedin.com/company/syntechnology" target="_blank" rel="noopener" aria-label="LinkedIn" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white/80 hover:bg-brand hover:text-white transition-colors" title="LinkedIn"><i class="fa-brands fa-linkedin-in text-xs"></i></a>
                <a href="https://maps.app.goo.gl/ktsFRToQJE7mXfyS7" target="_blank" rel="noopener" aria-label="Google Maps" class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white/80 hover:bg-brand hover:text-white transition-colors" title="Google Maps"><i class="fa-solid fa-map-location-dot text-xs"></i></a>
              </div>


            </div>

            <!-- Col 2: Solutions (lg:col-span-3) -->
            <div class="lg:col-span-3">
              <h4 class="font-bold text-xs uppercase tracking-wider text-white mb-4">
                <span class="lang-th">โซลูชัน</span>
                <span class="lang-en">Solutions</span>
              </h4>
              <ul class="space-y-2.5 text-xs text-white/60">
                <li><a href="${homeHref('#solutions')}" class="hover:text-white transition-colors"><span class="lang-th">Smart Factory (โรงงานอัจฉริยะ)</span><span class="lang-en">Smart Factory</span></a></li>
                <li><a href="${homeHref('#solutions')}" class="hover:text-white transition-colors"><span class="lang-th">Smart Energy (พลังงานอัจฉริยะ)</span><span class="lang-en">Smart Energy</span></a></li>
                <li><a href="${homeHref('#solutions')}" class="hover:text-white transition-colors"><span class="lang-th">Smart Agriculture (เกษตรอัจฉริยะ)</span><span class="lang-en">Smart Agriculture</span></a></li>
                <li><a href="${homeHref('#end-to-end')}" class="hover:text-white transition-colors"><span class="lang-th">บริการ OEM / ODM Manufacturing</span><span class="lang-en">OEM / ODM Manufacturing</span></a></li>
                <li><a href="${homeHref('#end-to-end')}" class="hover:text-white transition-colors"><span class="lang-th">บริการวิศวกรรม R&D</span><span class="lang-en">R&D Engineering Services</span></a></li>
              </ul>
            </div>

            <!-- Col 3: Quick Links & Insights (lg:col-span-2) -->
            <div class="lg:col-span-2">
              <h4 class="font-bold text-xs uppercase tracking-wider text-white mb-4">
                <span class="lang-th">ลิงก์ด่วน</span>
                <span class="lang-en">Quick Links</span>
              </h4>
              <ul class="space-y-2.5 text-xs text-white/60">
                <li><a href="${homeHref('#top')}" class="hover:text-white transition-colors"><span class="lang-th">หน้าแรก</span><span class="lang-en">Home</span></a></li>
                <li><a href="${homeHref('#success-stories')}" class="hover:text-white transition-colors"><span class="lang-th">ผลงานจริง</span><span class="lang-en">Case Studies</span></a></li>
                <li><a href="${pageHref('about.html')}" class="hover:text-white transition-colors"><span class="lang-th">เกี่ยวกับเรา</span><span class="lang-en">About Us</span></a></li>
                <li><a href="${pageHref('knowledge.html')}" class="hover:text-white transition-colors"><span class="lang-th">คลังความรู้</span><span class="lang-en">Insights & News</span></a></li>
                <li><a href="${pageHref('contact.html')}" class="hover:text-white transition-colors"><span class="lang-th">ติดต่อเรา</span><span class="lang-en">Contact Us</span></a></li>
              </ul>
            </div>

            <!-- Col 4: Contact Info & CTA (lg:col-span-3) -->
            <div class="lg:col-span-3">
              <h4 class="font-bold text-xs uppercase tracking-wider text-white mb-4">
                <span class="lang-th">ติดต่อเรา</span>
                <span class="lang-en">Contact Us</span>
              </h4>
              <ul class="space-y-3 text-xs text-white/60">
                <li>
                  <a href="https://maps.app.goo.gl/ktsFRToQJE7mXfyS7" target="_blank" rel="noopener" class="flex gap-2.5 hover:text-white transition-colors" title="Google Maps">
                    <i class="fa-solid fa-location-dot text-brand-soft text-xs mt-0.5 shrink-0"></i>
                    <span><span class="lang-th">96 หมู่ 1 ต.คลองหนึ่ง อ.คลองหลวง ปทุมธานี 12120</span><span class="lang-en">96 Moo 1, Khlong Nueng, Khlong Luang, Pathum Thani 12120</span></span>
                  </a>
                </li>
                <li>
                  <a href="tel:025161594" class="flex items-center gap-2.5 hover:text-white transition-colors">
                    <i class="fa-solid fa-phone-volume text-brand-soft text-xs shrink-0"></i>
                    <span>02 516 1594</span>
                  </a>
                </li>
                <li>
                  <a href="tel:0818499937" class="flex items-center gap-2.5 hover:text-white transition-colors">
                    <i class="fa-solid fa-phone text-brand-soft text-xs shrink-0"></i>
                    <span>081 849 9937</span>
                  </a>
                </li>
                <li>
                  <a href="mailto:sales@syntechnology.com" class="flex items-center gap-2.5 hover:text-white transition-colors min-w-0">
                    <i class="fa-solid fa-envelope text-brand-soft text-xs shrink-0"></i>
                    <span class="min-w-0 break-all">sales@syntechnology.com</span>
                  </a>
                </li>
              </ul>

              <!-- CTA Button -->
              <div class="pt-4">
                <a href="${pageHref('contact.html')}" class="inline-flex items-center gap-2 bg-brand hover:bg-brand-deep text-white text-xs font-700 uppercase tracking-wider px-4 py-2.5 rounded-lg transition-colors shadow-sm">
                  <i class="fa-solid fa-paper-plane text-[11px]"></i>
                  <span class="lang-th">ปรึกษาทีมวิศวกร</span>
                  <span class="lang-en">Talk to Our Engineers</span>
                </a>
              </div>
            </div>

          </div>

          <!-- Bottom Bar -->
          <div class="border-t border-white/10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-white/40">
            <span><span class="lang-th">© 2026 บริษัท ซีนเนอร์ยี่ เทคโนโลยี จำกัด สงวนลิขสิทธิ์</span><span class="lang-en">© 2026 Synergy Technology Co., Ltd. All rights reserved.</span></span>
            <div class="flex items-center gap-6">
              <a href="${pageHref('privacy-policy.php')}" class="hover:text-white/70 transition-colors"><span class="lang-th">นโยบายความเป็นส่วนตัว</span><span class="lang-en">Privacy Policy</span></a>
              <a href="${pageHref('privacy-policy.php#cookies')}" class="hover:text-white/70 transition-colors"><span class="lang-th">นโยบายคุกกี้</span><span class="lang-en">Cookie Policy</span></a>
              <a href="#" onclick="event.preventDefault();window.synergyConsent&&window.synergyConsent.open()" class="hover:text-white/70 transition-colors"><span class="lang-th">ตั้งค่าคุกกี้</span><span class="lang-en">Cookie Settings</span></a>
            </div>
          </div>

        </div>
      </footer>
      <!-- Floating Action Buttons Container -->
      <div class="fixed bottom-8 right-8 flex flex-col gap-2 z-[9999] items-center">
        <!-- Collapse/Expand Toggle Button (Always Visible) -->
        <button id="contactToggleBtn" class="w-11 h-11 bg-brand text-white rounded-full flex items-center justify-center shadow-lg hover:scale-105 active:scale-95 transition-all duration-200 z-[10000]" title="ช่องทางติดต่อ">
          <i class="fa-solid fa-comments text-lg transition-transform duration-300" id="contactToggleIcon"></i>
        </button>

        <!-- Collapsible Content Wrapper (collapsed by default) -->
        <div id="contactCollapsibleWrap" class="flex flex-col gap-2 items-center transition-all duration-300 origin-bottom scale-0 opacity-0 pointer-events-none h-0">
          <!-- LINE -->
          <a href="https://lin.ee/5n3UprV" target="_blank" rel="noopener" class="w-11 h-11 bg-[#06C755] text-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition group relative" title="LINE">
            <i class="fa-brands fa-line text-2xl"></i>
            <span class="absolute right-full mr-3 bg-ink/95 border border-white/10 text-white text-[10px] px-2 py-1 rounded shadow-xl opacity-0 group-hover:opacity-100 transition whitespace-nowrap">LINE @syntech</span>
          </a>
          <!-- Facebook -->
          <a href="https://www.facebook.com/SynergyTechnology" target="_blank" rel="noopener" class="w-11 h-11 bg-[#1877F2] text-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition group relative" title="Facebook">
            <i class="fa-brands fa-facebook-f text-lg"></i>
            <span class="absolute right-full mr-3 bg-ink/95 border border-white/10 text-white text-[10px] px-2 py-1 rounded shadow-xl opacity-0 group-hover:opacity-100 transition whitespace-nowrap">Facebook</span>
          </a>
          <!-- Phone -->
          <a href="tel:+66818499937" class="w-11 h-11 bg-[#D4AF37] text-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition group relative" title="Call">
            <i class="fa-solid fa-phone text-base"></i>
            <span class="absolute right-full mr-3 bg-ink/95 border border-white/10 text-white text-[10px] px-2 py-1 rounded shadow-xl opacity-0 group-hover:opacity-100 transition whitespace-nowrap">081-849-9937</span>
          </a>
          <!-- Email -->
          <a href="mailto:sales@syntechnology.com" class="w-11 h-11 bg-indigo-600 text-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition group relative" title="Email">
            <i class="fa-solid fa-envelope text-base"></i>
            <span class="absolute right-full mr-3 bg-ink/95 border border-white/10 text-white text-[10px] px-2 py-1 rounded shadow-xl opacity-0 group-hover:opacity-100 transition whitespace-nowrap">sales@syntechnology.com</span>
          </a>
        </div>

        <!-- Back to Top Button -->
        <button id="backToTop" class="w-11 h-11 bg-ink border border-white/10 text-white rounded-full shadow-lg flex items-center justify-center hover:bg-black transition opacity-0 invisible transform hover:scale-110 mt-1" aria-label="Back to top">
          <i class="fa-solid fa-arrow-up text-sm"></i>
        </button>
      </div>
    `;
  }

  const getNavLinks = () => document.querySelectorAll('[data-nav-link]');

  const setLinkActiveState = (link, isActive) => {
    link.classList.toggle('text-brand', isActive);
    link.classList.toggle('border-b-2', isActive);
    link.classList.toggle('border-brand', isActive);
    link.classList.toggle('!font-900', isActive);
    link.classList.toggle('font-800', isActive);
    link.classList.toggle('text-ink', !isActive);
  };

  const updateActiveNav = (activeSection = '') => {
    const solutionsSection = document.getElementById('solutions');
    let activeSolTab = '';
    if (solutionsSection && isHomePage) {
      const rect = solutionsSection.getBoundingClientRect();
      const inSolutions = (rect.top <= navbarOffset + 24) && (rect.bottom >= navbarOffset);
      if (inSolutions) {
        const activeCard = document.querySelector('.sol-detail-card:not(.hidden)');
        if (activeCard) {
          activeSolTab = activeCard.id.replace('sol-card-', '');
        }
      }
    }

    getNavLinks().forEach((link) => {
      const linkPage = link.dataset.page;
      const linkSection = link.dataset.section;
      const solTab = link.dataset.solTab;

      let isActive = false;
      if (isHomePage && (linkPage === 'syntech.html' || linkPage === 'index.html')) {
        isActive = linkSection === activeSection;
      } else if (!isHomePage) {
        isActive = linkPage === pageName;
      }

      link.style.opacity = '';
      if (activeSolTab) {
        if (solTab) {
          setLinkActiveState(link, solTab === activeSolTab);
        } else {
          setLinkActiveState(link, false);
        }
      } else {
        if (solTab) {
          setLinkActiveState(link, false);
        } else {
          setLinkActiveState(link, isActive);
        }
      }
    });

    document.querySelectorAll('[data-contact-link]').forEach((link) => {
      const isContactPage = pageName === 'contact.html';
      link.classList.toggle('ring-2', isContactPage);
      link.classList.toggle('ring-white/40', isContactPage);
    });
  };

  const getActiveHomeSection = () => {
    let activeSection = 'top';
    navItems.forEach((item) => {
      if (!item.section) {
        return;
      }

      const section = document.getElementById(item.section);
      if (!section) {
        return;
      }

      if (section.offsetTop <= window.scrollY + navbarOffset + 24) {
        activeSection = item.section;
      }
    });
    return activeSection;
  };

  const scrollToTarget = (target, behavior = 'smooth') => {
    // Subtract 40px instead of 24px to give more breathing room at the top
    const targetTop = target.getBoundingClientRect().top + window.scrollY - navbarOffset - 40;
    window.scrollTo({
      top: Math.max(targetTop, 0),
      behavior
    });
  };

  const syncHashScroll = (behavior = 'auto') => {
    if (!isHomePage || !window.location.hash) {
      return;
    }

    const target = document.querySelector(window.location.hash);
    if (target) {
      scrollToTarget(target, behavior);
      updateActiveNav(target.id || 'top');
    }
  };

  document.querySelectorAll('[id]').forEach((element) => {
    element.style.scrollMarginTop = `${navbarOffset}px`;
  });

  document.body.style.paddingTop = '80px';

  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  if (mobileMenuBtn && mobileMenu) {
    mobileMenuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
      const icon = mobileMenuBtn.querySelector('i');
      if (!icon) {
        return;
      }
      icon.className = mobileMenu.classList.contains('hidden')
        ? 'fa-solid fa-bars text-xl text-ink'
        : 'fa-solid fa-xmark text-xl text-ink';
    });

    document.querySelectorAll('#mobileMenu a').forEach((link) => {
      link.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
        const icon = mobileMenuBtn.querySelector('i');
        if (icon) {
          icon.className = 'fa-solid fa-bars text-xl text-ink';
        }
      });
    });
  }

  getNavLinks().forEach((link) => {
    link.addEventListener('click', (event) => {
      const href = link.getAttribute('href');
      if (!href) {
        return;
      }

      // Check if this is a shortcut to a specific solution tab
      if (href.includes('#sol-card-')) {
        const hash = href.substring(href.indexOf('#sol-card-'));
        const type = hash.replace('#sol-card-', '');
        
        if (isHomePage) {
          event.preventDefault();
          if (typeof window.switchSolTab === 'function') {
            window.switchSolTab(type);
          }
          // Scroll directly to the active solution detail card for precise positioning
          const target = document.getElementById(`sol-card-${type}`);
          if (target) {
            scrollToTarget(target, 'smooth');
          }
          history.replaceState(null, '', hash);
          return;
        }
      }

      if (!href.includes('#')) {
        return;
      }

      const url = new URL(href, window.location.href);
      const isSamePage = url.pathname === window.location.pathname;
      if (!isSamePage || !url.hash) {
        return;
      }

      const target = document.querySelector(url.hash);
      if (!target) {
        return;
      }

      event.preventDefault();
      history.replaceState(null, '', url.hash);
      scrollToTarget(target, 'smooth');
      updateActiveNav(target.id || 'top');
    });
  });

  const backToTopBtn = document.getElementById('backToTop');
  if (backToTopBtn) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 400) {
        backToTopBtn.classList.remove('opacity-0', 'invisible');
        backToTopBtn.classList.add('opacity-100', 'visible');
      } else {
        backToTopBtn.classList.add('opacity-0', 'invisible');
        backToTopBtn.classList.remove('opacity-100', 'visible');
      }
    });

    backToTopBtn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }



  if (isHomePage) {
    window.addEventListener('scroll', () => {
      updateActiveNav(getActiveHomeSection());
    });
  } else {
    updateActiveNav();
  }

  window.addEventListener('load', () => {
    syncHashScroll('auto');
    if (isHomePage && !window.location.hash) {
      updateActiveNav(getActiveHomeSection());
    }
  });

  document.querySelectorAll('.tab-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
      const tabGroup = btn.closest('[data-tab-group]');
      const tabId = btn.dataset.tab;
      if (!tabGroup || !tabId) {
        return;
      }

      tabGroup.querySelectorAll('.tab-btn').forEach((button) => {
        button.classList.remove('bg-brand', 'text-white', 'shadow-lg', 'shadow-brand/20');
        button.classList.add('bg-surface', 'text-body');
      });

      btn.classList.add('bg-brand', 'text-white', 'shadow-lg', 'shadow-brand/20');
      btn.classList.remove('bg-surface', 'text-body');

      tabGroup.querySelectorAll('.tab-content').forEach((content) => content.classList.remove('active'));

      const activeContent = document.getElementById(tabId);
      if (activeContent) {
        activeContent.classList.add('active');
      }
    });
  });

  document.querySelectorAll('.accordion-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
      const content = btn.nextElementSibling;
      const icon = btn.querySelector('.accordion-icon');
      if (!content) {
        return;
      }

      content.classList.toggle('open');
      if (icon) {
        icon.style.transform = content.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
      }
    });
  });

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.scroll-reveal').forEach((element) => observer.observe(element));
  }

  // Target industries tab switching logic
  window.switchSolTab = function(type) {
    // Hide all sol-detail-cards
    document.querySelectorAll('.sol-detail-card').forEach(card => {
      card.classList.add('hidden');
      card.classList.remove('block');
    });
    // Show targeted card
    const targetCard = document.getElementById(`sol-card-${type}`);
    if (targetCard) {
      targetCard.classList.remove('hidden');
      targetCard.classList.add('block');

      // Smooth scroll to the solution detail content when user clicks on a solution tab card
      if (window.event && (window.event.type === 'click' || window.event.type === 'touchend')) {
        setTimeout(() => {
          targetCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 50);
      }
    }
    
    // Update card-trigger styles
    document.querySelectorAll('.sol-card-trigger').forEach(card => {
      // Inactive card classes
      card.classList.remove('border-brand', 'ring-2', 'ring-brand', 'shadow-lg', 'shadow-brand/5');
      card.classList.add('border-slate-100', 'hover:-translate-y-1', 'hover:shadow-md');
      
      const iconCircle = card.querySelector('.icon-circle');
      if (iconCircle) {
        iconCircle.classList.remove('bg-brand', 'text-white');
        iconCircle.classList.add('bg-slate-100', 'text-brand');
      }
    });

    const activeCard = document.getElementById(`btn-card-${type}`);
    if (activeCard) {
      // Active card classes
      activeCard.classList.add('border-brand', 'ring-2', 'ring-brand', 'shadow-lg', 'shadow-brand/5');
      activeCard.classList.remove('border-slate-100', 'hover:-translate-y-1', 'hover:shadow-md');
      
      const iconCircle = activeCard.querySelector('.icon-circle');
      if (iconCircle) {
        iconCircle.classList.add('bg-brand', 'text-white');
        iconCircle.classList.remove('bg-slate-100', 'text-brand');
      }
    }

    // Update active nav highlights and opacities immediately
    updateActiveNav(getActiveHomeSection());
  };

  // Dynamic calculation for Success Stories project count
  const updateStoriesCount = () => {
    const storyCards = document.querySelectorAll('#stories-slider .story-card');
    if (storyCards.length > 0) {
      const thCount = document.getElementById('stories-count-th');
      const enCount = document.getElementById('stories-count-en');
      if (thCount) thCount.textContent = storyCards.length;
      if (enCount) enCount.textContent = storyCards.length;
    }
  };
  updateStoriesCount();

  // On page load and hash change, check if hash points to a tab
  const handleHashTab = () => {
    const hash = window.location.hash;
    if (hash.startsWith('#sol-card-')) {
      const tabType = hash.replace('#sol-card-', '');
      if (typeof window.switchSolTab === 'function') {
        window.switchSolTab(tabType);
        const solutionsSection = document.getElementById('solutions');
        if (solutionsSection) {
          solutionsSection.scrollIntoView({ behavior: 'smooth' });
        }
      }
    } else {
      if (isHomePage && typeof window.switchSolTab === 'function') {
        window.switchSolTab('smart-factory');
      }
    }
  };

  window.addEventListener('hashchange', handleHashTab);
  setTimeout(handleHashTab, 300);

  // Floating Contact Toggle Logic
  const contactToggleBtn = document.getElementById('contactToggleBtn');
  const contactCollapsibleWrap = document.getElementById('contactCollapsibleWrap');
  const contactToggleIcon = document.getElementById('contactToggleIcon');

  if (contactToggleBtn && contactCollapsibleWrap && contactToggleIcon) {
    let isOpen = false; // default state is collapsed
    contactToggleBtn.addEventListener('click', () => {
      isOpen = !isOpen;
      if (isOpen) {
        contactCollapsibleWrap.classList.remove('scale-0', 'opacity-0', 'pointer-events-none', 'h-0');
        contactCollapsibleWrap.classList.add('scale-100', 'opacity-100');
        contactToggleIcon.className = 'fa-solid fa-xmark text-lg transition-transform duration-300';
      } else {
        contactCollapsibleWrap.classList.remove('scale-100', 'opacity-100');
        contactCollapsibleWrap.classList.add('scale-0', 'opacity-0', 'pointer-events-none', 'h-0');
        contactToggleIcon.className = 'fa-solid fa-comments text-lg transition-transform duration-300';
      }
    });
  }

  // Language Toggle Button Click Handler — instant swap without white flash
  const langToggleBtns = document.querySelectorAll('#langToggleBtn');
  langToggleBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const currentLang = document.documentElement.getAttribute('lang') || 'th';
      const newLang = currentLang === 'th' ? 'en' : 'th';
      document.documentElement.setAttribute('lang', newLang);
      localStorage.setItem('preferred-language', newLang);
    });
  });

  // Contact Form Solution Chip Selection
  document.addEventListener('click', (e) => {
    const chip = e.target.closest('.solution-chip');
    if (!chip) return;
    const parent = chip.parentElement;
    parent.querySelectorAll('.solution-chip').forEach(c => {
      c.classList.remove('bg-brand', 'text-white', 'border-brand', 'shadow-sm', 'font-700');
      c.classList.add('bg-slate-50', 'text-slate-700', 'border-slate-200', 'font-600');
    });
    chip.classList.remove('bg-slate-50', 'text-slate-700', 'border-slate-200', 'font-600');
    chip.classList.add('bg-brand', 'text-white', 'border-brand', 'shadow-sm', 'font-700');
    const interestInput = document.getElementById('interestInput');
    if (interestInput) interestInput.value = chip.textContent.trim();
  });

  // Dynamic Stats Counter Animation
  const counterElements = document.querySelectorAll('.stat-number[data-target]');
  const animateCounter = (element) => {
    const target = parseInt(element.getAttribute('data-target'), 10);
    const suffixTH = element.getAttribute('data-suffix-th') || '';
    const suffixEN = element.getAttribute('data-suffix-en') || '';
    const duration = 2000;
    const startTime = performance.now();
    
    const update = (now) => {
      const elapsed = now - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const easeProgress = 1 - Math.pow(1 - progress, 3);
      const currentValue = Math.floor(easeProgress * target);
      
      const currentLang = document.documentElement.getAttribute('lang') || 'th';
      const suffix = currentLang === 'th' ? suffixTH : suffixEN;
      element.textContent = currentValue + suffix;
      
      if (progress < 1) {
        requestAnimationFrame(update);
      } else {
        element.textContent = target + suffix;
      }
    };
    
    requestAnimationFrame(update);
  };

  const observerOptions = {
    threshold: 0.2,
    rootMargin: '0px 0px -50px 0px'
  };

  const statsObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  counterElements.forEach(counter => {
    statsObserver.observe(counter);
  });

  // World-Class Interactive Success Stories Slider UX
  const storiesSlider = document.getElementById('stories-slider');
  const prevBtn = document.getElementById('slider-prev');
  const nextBtn = document.getElementById('slider-next');
  const progressBar = document.getElementById('slider-progress');
  const dotsContainer = document.getElementById('slider-dots');

  if (storiesSlider) {
    let isDown = false;
    let startX = 0;
    let scrollLeft = 0;
    let hasDragged = false;
    let dragThreshold = 5;

    // Get cards
    const cards = Array.from(storiesSlider.children);
    const totalCards = cards.length;

    // Create pagination dots dynamically if container exists
    if (dotsContainer && totalCards > 0) {
      dotsContainer.innerHTML = cards.map((_, index) => `
        <button data-index="${index}" aria-label="Go to slide ${index + 1}" class="slider-dot w-2.5 h-2.5 rounded-full bg-slate-300 hover:bg-brand transition-all duration-300 cursor-pointer ${index === 0 ? '!w-8 !bg-brand' : ''}"></button>
      `).join('');

      dotsContainer.querySelectorAll('.slider-dot').forEach(dot => {
        dot.addEventListener('click', (e) => {
          const idx = parseInt(e.currentTarget.dataset.index, 10);
          if (!isNaN(idx) && cards[idx]) {
            const targetLeft = cards[idx].offsetLeft - storiesSlider.offsetLeft;
            storiesSlider.scrollTo({ left: targetLeft, behavior: 'smooth' });
          }
        });
      });
    }

    // Function to update UX indicators (Progress Bar, Arrow state, Active Dot)
    const updateSliderUX = () => {
      const maxScroll = storiesSlider.scrollWidth - storiesSlider.clientWidth;
      const currentScroll = Math.max(0, storiesSlider.scrollLeft);

      // Update Progress Bar %
      if (progressBar && maxScroll > 0) {
        const progress = Math.min(100, Math.max(0, (currentScroll / maxScroll) * 100));
        progressBar.style.width = `${progress}%`;
      }

      // Update Arrow Buttons disabled states
      if (prevBtn) {
        if (currentScroll <= 10) {
          prevBtn.classList.add('opacity-40', 'cursor-not-allowed', 'pointer-events-none');
          prevBtn.classList.remove('hover:bg-brand', 'hover:text-white', 'hover:border-brand');
        } else {
          prevBtn.classList.remove('opacity-40', 'cursor-not-allowed', 'pointer-events-none');
          prevBtn.classList.add('hover:bg-brand', 'hover:text-white', 'hover:border-brand');
        }
      }

      if (nextBtn) {
        if (currentScroll >= maxScroll - 10) {
          nextBtn.classList.add('opacity-40', 'cursor-not-allowed', 'pointer-events-none');
          nextBtn.classList.remove('hover:bg-brand', 'hover:text-white', 'hover:border-brand');
        } else {
          nextBtn.classList.remove('opacity-40', 'cursor-not-allowed', 'pointer-events-none');
          nextBtn.classList.add('hover:bg-brand', 'hover:text-white', 'hover:border-brand');
        }
      }

      // Update Active Dot
      if (dotsContainer && cards.length > 0) {
        let activeIdx = 0;
        let minDiff = Infinity;
        cards.forEach((card, i) => {
          const cardLeft = card.offsetLeft - storiesSlider.offsetLeft;
          const diff = Math.abs(cardLeft - currentScroll);
          if (diff < minDiff) {
            minDiff = diff;
            activeIdx = i;
          }
        });

        dotsContainer.querySelectorAll('.slider-dot').forEach((dot, i) => {
          if (i === activeIdx) {
            dot.classList.add('!w-8', '!bg-brand');
            dot.classList.remove('bg-slate-300');
          } else {
            dot.classList.remove('!w-8', '!bg-brand');
            dot.classList.add('bg-slate-300');
          }
        });
      }
    };

    // Listen to scroll events with animation frame for performance
    let isTicking = false;
    storiesSlider.addEventListener('scroll', () => {
      if (!isTicking) {
        window.requestAnimationFrame(() => {
          updateSliderUX();
          isTicking = false;
        });
        isTicking = true;
      }
    }, { passive: true });

    // Initial UX calculation
    setTimeout(updateSliderUX, 150);
    window.addEventListener('resize', updateSliderUX);

    // Mouse Dragging Logic with Snap-toggle and Click Protection
    storiesSlider.addEventListener('mousedown', (e) => {
      isDown = true;
      hasDragged = false;
      storiesSlider.style.scrollSnapType = 'none'; // Temp disable snap during drag for fluidity
      storiesSlider.classList.add('cursor-grabbing');
      storiesSlider.classList.remove('cursor-grab');
      startX = e.pageX - storiesSlider.offsetLeft;
      scrollLeft = storiesSlider.scrollLeft;
    });

    const stopDragging = () => {
      if (!isDown) return;
      isDown = false;
      storiesSlider.style.scrollSnapType = 'x mandatory'; // Re-enable snap after drop
      storiesSlider.classList.remove('cursor-grabbing');
      storiesSlider.classList.add('cursor-grab');
    };

    storiesSlider.addEventListener('mouseleave', stopDragging);
    storiesSlider.addEventListener('mouseup', stopDragging);

    storiesSlider.addEventListener('mousemove', (e) => {
      if (!isDown) return;
      const x = e.pageX - storiesSlider.offsetLeft;
      const walk = (x - startX) * 1.5;
      if (Math.abs(walk) > dragThreshold) {
        hasDragged = true;
      }
      storiesSlider.scrollLeft = scrollLeft - walk;
    });

    // Prevent accidental link clicks when dragging cards
    storiesSlider.addEventListener('click', (e) => {
      if (hasDragged) {
        e.preventDefault();
        e.stopPropagation();
      }
    }, true);

    // Navigation buttons handler (Scroll by 1 card exact width + gap)
    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        const firstCard = storiesSlider.firstElementChild;
        const scrollAmount = firstCard ? firstCard.getBoundingClientRect().width + 32 : 360;
        storiesSlider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        const firstCard = storiesSlider.firstElementChild;
        const scrollAmount = firstCard ? firstCard.getBoundingClientRect().width + 32 : 360;
        storiesSlider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
      });
    }
  }
});




