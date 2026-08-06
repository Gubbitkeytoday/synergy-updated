/**
 * SYNEXTA ENERGY PLATFORM - interactive section on smart-energy.php
 *
 * Adapted from the standalone prototype's app.js. What changed and why:
 *
 * 1. SCOPED. The prototype ran `document.querySelectorAll('img')` and
 *    `.nav-tab` / `.device-card` against the whole document. On this site that
 *    reaches the navbar logo, the client logo marquee and the footer. Every
 *    query below is rooted at #energy-platform.
 *
 * 2. THE 3D MODEL IS LAZY. model-viewer is a ~300 KB module and the building
 *    is a 1.9 MB .glb. Loading both on page load costs every visitor that
 *    weight for a section most never scroll to. Both are fetched only when the
 *    section is about to enter the viewport.
 *
 * 3. THE BACKGROUND STRIPPER DOWNSCALES. The prototype painted each source
 *    photo to a canvas at natural size (~2000px) and wrote it back as a PNG
 *    data URL - for images displayed at 60px. That is tens of MB of string in
 *    memory for thumbnails. It now renders into a canvas sized to the display
 *    box, so the result is a few KB.
 *
 * 4. BILINGUAL. Copy injected at runtime is emitted as lang-th + lang-en pairs
 *    like the rest of the site, otherwise the dialog would stay Thai when the
 *    visitor switches to English (rule 4 in AGENTS.md).
 */
(function () {
  'use strict';

  const root = document.getElementById('energy-platform');
  if (!root) return;

  const prefersReducedData =
    navigator.connection && (navigator.connection.saveData === true);

  /* ------------------------------------------------------------------
     1. Tabs
     ------------------------------------------------------------------ */
  const tabs = [...root.querySelectorAll('.nav-tab')];
  const views = [...root.querySelectorAll('.tab-view')];

  /* ------------------------------------------------------------------
     1b. Tab row scroll affordance

     The row scrolls horizontally on a phone - measured, two of seven tabs fit
     on a 375px screen. With the scrollbar hidden there was nothing to say so,
     and the tabs past the edge read as missing. This adds the two things that
     fix that: an edge fade with a chevron over it, and an active tab that
     scrolls itself into view instead of waiting to be found.
     ------------------------------------------------------------------ */
  const tabBar = root.querySelector('.nav-tabs');
  let tabWrap = null;

  if (tabBar) {
    // Built here rather than in the markup so the component stays self-contained
    // and any page that reuses .nav-tabs gets the behaviour for free.
    tabWrap = document.createElement('div');
    tabWrap.className = 'nav-tabs-wrap';
    tabBar.parentNode.insertBefore(tabWrap, tabBar);
    tabWrap.appendChild(tabBar);
    tabWrap.insertAdjacentHTML('beforeend',
      '<span class="nav-scroll-cue nav-scroll-cue--left" aria-hidden="true">‹</span>' +
      '<span class="nav-scroll-cue nav-scroll-cue--right" aria-hidden="true">›</span>');
  }

  function updateTabScrollCues() {
    if (!tabBar || !tabWrap) return;
    /* 8px of slack, not 1-2. The row has 5px of its own padding and the tabs
       snap to start, so its resting position at the far left is scrollLeft 5,
       not 0 - a tighter threshold left the "scroll left" chevron showing when
       there was nothing further left to reach. */
    const SLACK = 8;
    const canLeft = tabBar.scrollLeft > SLACK;
    const canRight = tabBar.scrollLeft + tabBar.clientWidth < tabBar.scrollWidth - SLACK;
    [tabBar, tabWrap].forEach(el => {
      el.classList.toggle('can-scroll-left', canLeft);
      el.classList.toggle('can-scroll-right', canRight);
    });
  }

  if (tabBar) {
    tabBar.addEventListener('scroll', updateTabScrollCues, { passive: true });
    window.addEventListener('resize', updateTabScrollCues);
    updateTabScrollCues();
    // Fonts land after first paint and change the row width, so measure again.
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(updateTabScrollCues);
    setTimeout(updateTabScrollCues, 400);
  }

  /* Keeps the selected tab on screen. scrollIntoView would also scroll the page
     vertically, so the offset is computed and applied to the row alone. */
  function revealTab(tab) {
    if (!tabBar || tabBar.scrollWidth <= tabBar.clientWidth) return;
    const barRect = tabBar.getBoundingClientRect();
    const tabRect = tab.getBoundingClientRect();
    const target = tabBar.scrollLeft + (tabRect.left - barRect.left)
      - (barRect.width / 2) + (tabRect.width / 2);
    tabBar.scrollTo({ left: Math.max(0, target), behavior: 'smooth' });
  }

  function selectTab(tab) {
    const target = tab.getAttribute('data-tab');
    if (!target) return;
    revealTab(tab);

    tabs.forEach(t => {
      const on = t === tab;
      t.classList.toggle('active', on);
      t.setAttribute('aria-selected', on ? 'true' : 'false');
      t.tabIndex = on ? 0 : -1;
      const ind = t.querySelector('.tab-indicator');
      if (on && !ind) {
        const d = document.createElement('div');
        d.className = 'tab-indicator';
        t.appendChild(d);
      } else if (!on && ind) {
        ind.remove();
      }
    });

    views.forEach(v => v.classList.toggle('active', v.id === 'view-' + target));
  }

  tabs.forEach(tab => {
    tab.addEventListener('click', () => selectTab(tab));
    // Arrow-key navigation is expected of a tablist and costs four lines.
    tab.addEventListener('keydown', e => {
      const i = tabs.indexOf(tab);
      let next = null;
      if (e.key === 'ArrowRight') next = tabs[(i + 1) % tabs.length];
      if (e.key === 'ArrowLeft') next = tabs[(i - 1 + tabs.length) % tabs.length];
      if (e.key === 'Home') next = tabs[0];
      if (e.key === 'End') next = tabs[tabs.length - 1];
      if (next) {
        e.preventDefault();
        selectTab(next);
        next.focus();
      }
    });
  });

  /* ------------------------------------------------------------------
     2. White-background removal for the device / deployment photos
     ------------------------------------------------------------------ */
  function stripWhite(img) {
    if (img.getAttribute('data-ep-processed') === 'true') return;
    if (!img.naturalWidth) return;

    try {
      // Render at roughly twice the display box so it stays crisp on retina
      // without carrying the full 2000px source into a data URL.
      const box = img.getBoundingClientRect();
      const target = Math.max(120, Math.round((box.width || 60) * 2));
      const scale = Math.min(1, target / img.naturalWidth);
      const w = Math.max(1, Math.round(img.naturalWidth * scale));
      const h = Math.max(1, Math.round(img.naturalHeight * scale));

      const canvas = document.createElement('canvas');
      canvas.width = w;
      canvas.height = h;
      const ctx = canvas.getContext('2d', { willReadFrequently: true });
      ctx.drawImage(img, 0, 0, w, h);

      const imageData = ctx.getImageData(0, 0, w, h);
      const d = imageData.data;
      for (let i = 0; i < d.length; i += 4) {
        const min = Math.min(d[i], d[i + 1], d[i + 2]);
        const max = Math.max(d[i], d[i + 1], d[i + 2]);
        // Near-white AND near-grey: a saturated light green must survive.
        if (min > 195 && max - min < 35) {
          d[i + 3] = min > 230
            ? 0
            : Math.max(0, Math.min(d[i + 3], Math.floor(255 * ((230 - min) / 35))));
        }
      }
      ctx.putImageData(imageData, 0, 0);

      img.src = canvas.toDataURL('image/png');
      img.setAttribute('data-ep-processed', 'true');
      img.style.filter = 'drop-shadow(0 6px 14px rgba(0, 168, 107, 0.2))';
    } catch (e) {
      // A tainted canvas or a missing 2d context is not worth breaking the
      // section over - the photo simply keeps its white background.
      img.setAttribute('data-ep-processed', 'true');
    }
  }

  function processImages() {
    root.querySelectorAll('.device-img, .deploy-img').forEach(img => {
      if (img.complete && img.naturalWidth) stripWhite(img);
      else img.addEventListener('load', () => stripWhite(img), { once: true });
    });
  }

  /* ------------------------------------------------------------------
     3. Lazy 3D model
     ------------------------------------------------------------------ */
  const stage = root.querySelector('.central-architecture-stage');

  function loadModel() {
    if (!stage || stage.getAttribute('data-ep-loaded') === 'true') return;
    stage.setAttribute('data-ep-loaded', 'true');

    const src = stage.getAttribute('data-model-src');
    const libSrc = stage.getAttribute('data-viewer-src');
    const poster = stage.querySelector('.stage-poster');
    if (!src || !libSrc) return;

    const viewer = document.createElement('model-viewer');
    viewer.className = 'custom-center-3d-model';
    viewer.setAttribute('src', src);
    viewer.setAttribute('alt', stage.getAttribute('data-model-alt') || '');
    viewer.setAttribute('camera-controls', '');
    viewer.setAttribute('auto-rotate', '');
    viewer.setAttribute('rotation-per-second', '25deg');
    viewer.setAttribute('shadow-intensity', '1.2');
    viewer.setAttribute('shadow-softness', '0.8');
    viewer.setAttribute('exposure', '1.15');
    /* Framing. The orbit radius is a percentage of the distance model-viewer
       picks to fit the whole model on screen, so smaller = closer = the building
       fills more of the stage. The prototype's 85% left a wide empty margin,
       which only got worse once the stage stopped being capped at 520px.
       Both values are overridable from the markup so this can be tuned without
       touching JS. */
    viewer.setAttribute('camera-orbit', stage.getAttribute('data-camera-orbit') || '0deg 76deg 55%');
    viewer.setAttribute('field-of-view', stage.getAttribute('data-fov') || '30deg');
    /* Keep the auto-frame as the zoom-out limit so a stray scroll cannot shrink
       the building to a dot in the middle of the section. */
    viewer.setAttribute('max-camera-orbit', 'auto auto 100%');
    viewer.setAttribute('min-camera-orbit', 'auto auto 35%');
    viewer.setAttribute('interaction-prompt', 'none');
    viewer.style.opacity = '0';
    viewer.style.transition = 'opacity .45s ease';

    viewer.addEventListener('load', () => {
      viewer.style.opacity = '1';
      if (poster) poster.remove();
      buildHotspots(viewer);
    });

    // If the module or the model fails, the poster stays rather than leaving a
    // 440px hole in the middle of the section.
    const lib = document.createElement('script');
    lib.type = 'module';
    lib.src = libSrc;
    lib.addEventListener('error', () => {
      if (poster) poster.setAttribute('data-ep-failed', 'true');
    });
    document.head.appendChild(lib);

    stage.appendChild(viewer);
  }

  /* ------------------------------------------------------------------
     3b. Hotspots on the building

     Clicking a pin opens the screen for that part of the platform.

     Positions are expressed as fractions of the model's own bounding box, not
     as absolute metres. The .glb ships quantised (glTF-Transform), so its raw
     vertex range says nothing about real scale - but model-viewer reports the
     decoded box at runtime, and a fraction of that lands on the building
     whatever units the author used.

     Those fractions are an educated placement, not a surveyed one. Append
     ?hotspots=edit to the URL and click the model: the exact data-position and
     data-normal under the cursor are printed in a box, ready to paste into
     ANCHORS below. That is the only reliable way to nail a pin to a specific
     rooftop panel.
     ------------------------------------------------------------------ */
  /* One anchor only: the rooftop solar array. Its readout card stays open
     rather than waiting for a hover or a click - on a marketing page the point
     is that a visitor sees the live figure without discovering an interaction
     first, and hover states do not exist on touch at all. */
  const SOLAR_ANCHOR = { key: 'solar', f: [0.00, 0.46, 0.02], n: [0, 1, 0] };

  const SOLAR_CARD = {
    title:  { th: 'อาคารซินเทค',            en: 'Syntech Building' },
    left:   { th: 'ไฟฟ้าที่ใช้ตอนนี้',        en: 'Current load',   value: '99.42', unit: 'kW' },
    right:  { th: 'โซลาร์ที่ใช้ตอนนี้',       en: 'Solar output',   value: '13.70', unit: 'kW' },
    stamp:  { th: 'อัปเดตล่าสุดเมื่อ 22 มิ.ย. 2569 16:26:25',
              en: 'Last updated 22 Jun 2026 16:26:25' }
  };

  function buildHotspots(viewer) {
    if (typeof viewer.getBoundingBoxCenter !== 'function') return;

    let c, d;
    try {
      c = viewer.getBoundingBoxCenter();
      d = viewer.getDimensions();
    } catch (e) {
      return;
    }
    if (!c || !d) return;

    const a = SOLAR_ANCHOR;
    const override = stage.getAttribute('data-hotspot-' + a.key);
    const pos = override
      ? override
      : (c.x + a.f[0] * d.x) + 'm ' + (c.y + a.f[1] * d.y) + 'm ' + (c.z + a.f[2] * d.z) + 'm';

    const anno = document.createElement('div');
    anno.className = 'ep-anno';
    anno.slot = 'hotspot-' + a.key;
    anno.setAttribute('data-position', pos);
    anno.setAttribute('data-normal', a.n.join(' '));
    /* No data-visibility-attribute on purpose: the card is meant to stay put.
       Letting model-viewer hide it when the anchor turns away would make it
       blink out every time the auto-rotation carried the roof to the back. */

    const m = (side, cfg) =>
      '<div class="ep-anno-metric ep-anno-metric--' + side + '">' +
        '<div class="ep-anno-metric-label">' + pair(cfg.th, cfg.en) + '</div>' +
        '<div class="ep-anno-metric-value">' + cfg.value +
          '<span class="ep-anno-metric-unit">' + cfg.unit + '</span></div>' +
      '</div>';

    anno.innerHTML =
      '<span class="ep-anno-dot" aria-hidden="true"></span>' +
      /* The elbow is drawn in SVG rather than with borders so the diagonal stays
         crisp. Its bottom-left corner is the anchor point, so the line always
         starts exactly on the panels. */
      '<svg class="ep-anno-line" viewBox="0 0 116 78" fill="none" aria-hidden="true">' +
        '<path d="M6 71 L40 71 L74 17 L114 17" stroke="var(--ep-anno-line)" ' +
          'stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>' +
      '</svg>' +
      '<div class="ep-anno-card">' +
        '<div class="ep-anno-head">' +
          '<span class="ep-anno-icon" aria-hidden="true">' +
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ' +
              'stroke-linecap="round" stroke-linejoin="round">' +
              '<path d="M4 21V5a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v16"/>' +
              '<path d="M12 10h7a1 1 0 0 1 1 1v10"/>' +
              '<path d="M7 8h2M7 12h2M7 16h2M15 14h2M15 18h2"/><path d="M3 21h18"/>' +
            '</svg>' +
          '</span>' +
          '<span class="ep-anno-title">' + pair(SOLAR_CARD.title.th, SOLAR_CARD.title.en) + '</span>' +
        '</div>' +
        '<div class="ep-anno-metrics">' + m('load', SOLAR_CARD.left) + m('solar', SOLAR_CARD.right) + '</div>' +
        '<div class="ep-anno-stamp">🕐 ' + pair(SOLAR_CARD.stamp.th, SOLAR_CARD.stamp.en) + '</div>' +
      '</div>';

    viewer.appendChild(anno);

    /* Added here rather than in the markup so it never promises interactivity
       that failed to load. */
    if (!stage.querySelector('.stage-hint')) {
      const hint = document.createElement('div');
      hint.className = 'stage-hint';
      hint.innerHTML = '✦ ' + pair(
        'ลากเพื่อหมุนอาคาร · เลื่อนเพื่อซูม',
        'Drag to rotate the building · scroll to zoom'
      );
      stage.appendChild(hint);
    }

    if (/[?&]hotspots=edit\b/.test(location.search)) enableHotspotPicker(viewer);
  }

  /* Placement helper. Not reachable without the query string, so it costs
     normal visitors nothing. */
  function enableHotspotPicker(viewer) {
    const box = document.createElement('div');
    box.className = 'ep-hotspot-devbox';
    box.textContent = 'hotspot picker: click the model';
    stage.appendChild(box);

    viewer.addEventListener('click', e => {
      if (typeof viewer.positionAndNormalFromPoint !== 'function') return;
      const hit = viewer.positionAndNormalFromPoint(e.clientX, e.clientY);
      if (!hit) { box.textContent = 'missed the model - click on the building'; return; }
      box.textContent =
        'data-position="' + hit.position.toString() + '"\n' +
        'data-normal="' + hit.normal.toString() + '"';
    });
  }

  /* ------------------------------------------------------------------
     4. Telemetry dialog
     ------------------------------------------------------------------ */
  const modal = root.querySelector('.modal-backdrop');
  const modalTitle = root.querySelector('#ep-modal-title');
  const modalBody = root.querySelector('#ep-modal-content');
  const closeBtn = root.querySelector('.close-btn');
  let lastFocused = null;

  const pair = (th, en) =>
    '<span class="lang-th">' + th + '</span><span class="lang-en">' + en + '</span>';

  const row = (icon, th, en, value) =>
    '<p>' + icon + ' ' + pair(th, en) + ': <strong>' + value + '</strong></p>';

  const DEVICES = {
    'solar-inverter': {
      title: pair('Solar Inverter (อินเวอร์เตอร์พลังงานแสงอาทิตย์)', 'Solar Inverter'),
      rows: [
        row('🟢', 'สถานะ', 'Status', 'Online (Normal)'),
        row('⚡', 'กำลังไฟขาออก', 'Current output', '1,450 kW (AC)'),
        row('☀️', 'ประสิทธิภาพ', 'Efficiency', '98.7%'),
        row('🌡️', 'อุณหภูมิภายใน', 'Internal temp', '42.5 °C'),
        '<p>' + pair('แบรนด์ที่เชื่อมต่อ', 'Supported brands') +
          ': <strong>Huawei Sun2000, Sungrow SG110CX, GoodWe, Growatt</strong></p>'
      ]
    },
    'energy-meter': {
      title: pair('Energy Meter (มิเตอร์วัดพลังงานดิจิทัล)', 'Energy Meter'),
      rows: [
        row('🟢', 'สถานะ', 'Status', 'Active telemetry'),
        row('📊', 'แรงดัน L1-L3', 'Voltage L1-L3', '380.4 V'),
        row('📈', 'ความถี่', 'Frequency', '50.02 Hz'),
        row('⚡', 'เพาเวอร์แฟกเตอร์', 'Power factor', '0.99 (Optimal)')
      ]
    },
    'lighting-controller': {
      title: pair('Lighting Controller (ระบบควบคุมแสงสว่างอัตโนมัติ)', 'Lighting Controller'),
      rows: [
        row('🟢', 'โหมดทำงาน', 'Mode', 'Smart auto schedule'),
        row('💡', 'โซนที่ทำงาน', 'Active zones', '24 / 24'),
        row('🌱', 'พลังงานที่ประหยัดวันนี้', 'Energy saved today', '185 kWh (-32%)')
      ]
    },
    'hvac': {
      title: pair('HVAC (ระบบปรับอากาศและระบายอากาศ)', 'HVAC System'),
      rows: [
        row('🟢', 'โหลดชิลเลอร์', 'Chiller load', '68% capacity'),
        row('❄️', 'อุณหภูมิที่ตั้งไว้', 'Set temperature', '24.0 °C'),
        row('🌬️', 'อัตราลม', 'Air flow rate', '12,400 CFM')
      ]
    },
    'ev-charger': {
      title: pair('EV Charger (เครื่องชาร์จรถยนต์ไฟฟ้า)', 'EV Charger'),
      rows: [
        row('🔌', 'ช่องชาร์จที่ใช้งาน', 'Active ports', '4 / 6 occupied'),
        row('⚡', 'โหลดปัจจุบัน', 'Current load', '120 kW fast charge'),
        row('🚗', 'รอบชาร์จวันนี้', 'Sessions today', '38 vehicles')
      ]
    },
    'iot-sensor': {
      title: pair('IoT Sensor (เซ็นเซอร์ตรวจวัดสิ่งแวดล้อม)', 'IoT Environment Sensor'),
      rows: [
        row('🟢', 'โปรโตคอล', 'Protocol', 'LoRaWAN / Modbus RTU'),
        row('🌡️', 'อุณหภูมิแวดล้อม', 'Ambient temp', '28.4 °C'),
        row('💧', 'ความชื้นสัมพัทธ์', 'Relative humidity', '55%')
      ]
    }
  };

  const DEMO_NOTE =
    '<p class="demo-note">ℹ️ ' +
    pair('ตัวเลขในหน้าตัวอย่างนี้เป็นข้อมูลจำลองเพื่อสาธิตการทำงาน',
         'Figures shown here are sample data for demonstration.') +
    '</p>';

  function openModal(key) {
    const info = DEVICES[key];
    if (!info || !modal) return;
    lastFocused = document.activeElement;
    modalTitle.innerHTML = info.title;
    modalBody.innerHTML =
      '<div class="telemetry-info">' + info.rows.join('') + '</div>' + DEMO_NOTE;
    modal.classList.add('show');
    if (closeBtn) closeBtn.focus();
  }

  function closeModal() {
    if (!modal) return;
    modal.classList.remove('show');
    if (lastFocused && lastFocused.focus) lastFocused.focus();
  }

  root.querySelectorAll('.device-card').forEach(card => {
    card.addEventListener('click', () => openModal(card.getAttribute('data-device')));
  });

  if (closeBtn) closeBtn.addEventListener('click', closeModal);
  if (modal) {
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
  }
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && modal && modal.classList.contains('show')) closeModal();
  });

  /* ------------------------------------------------------------------
     5. Screenshot lightbox

     The screens render at roughly half their native width inside the card, so
     the numbers and table rows are not readable on a laptop and unreadable on a
     phone. Clicking opens the full-resolution file.
     ------------------------------------------------------------------ */
  const lightbox = root.querySelector('.shot-lightbox');
  const lightboxImg = lightbox && lightbox.querySelector('img');
  const lightboxClose = lightbox && lightbox.querySelector('.shot-lightbox-close');
  let shotOpener = null;

  function openShot(btn) {
    const img = btn.querySelector('.screen-shot');
    if (!lightbox || !img) return;
    shotOpener = btn;
    /* getAttribute, not currentSrc: a hotspot can open the screen of a tab that
       is still display:none, where the lazy image has never been fetched and
       currentSrc is therefore empty. */
    lightboxImg.src = img.getAttribute('src');
    lightboxImg.alt = img.alt;
    lightbox.classList.add('show');
    if (lightboxClose) lightboxClose.focus();
  }

  function closeShot() {
    if (!lightbox) return;
    lightbox.classList.remove('show');
    // Drop the source so the decoded full-size bitmap is not held in memory
    // once the overlay is gone.
    lightboxImg.removeAttribute('src');
    if (shotOpener && shotOpener.focus) shotOpener.focus();
    shotOpener = null;
  }

  root.querySelectorAll('.screen-shot-btn').forEach(btn => {
    btn.addEventListener('click', () => openShot(btn));
  });

  if (lightboxClose) lightboxClose.addEventListener('click', closeShot);
  if (lightbox) {
    lightbox.addEventListener('click', e => {
      if (e.target === lightbox) closeShot();
    });
  }
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && lightbox && lightbox.classList.contains('show')) closeShot();
  });

  /* ------------------------------------------------------------------
     6. Kick off when the section is near the viewport
     ------------------------------------------------------------------ */
  function activate() {
    processImages();
    // Data Saver is an explicit request not to pull megabytes; honour it and
    // leave the poster in place.
    if (!prefersReducedData) loadModel();
  }

  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          activate();
          obs.disconnect();
        }
      });
    }, { rootMargin: '300px 0px' });
    io.observe(root);
  } else {
    activate();
  }
})();
