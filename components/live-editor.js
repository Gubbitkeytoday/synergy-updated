(function () {
  let isEditing = false;
  let isLoggedIn = localStorage.getItem('synergy_admin_auth') === '1';
  let pageName = window.location.pathname.includes('about') ? 'about' : 'index';
  let activeDragEl = null;
  let activeResizeEl = null;
  let resizeDir = '';
  let selectedEls = [];
  let isMarquee = false;
  let marqueeStartX = 0, marqueeStartY = 0;

  // Toolbar drag variables
  let isDraggingToolbar = false;
  let toolbarStartX = 0, toolbarStartY = 0;
  let toolbarInitialX = 0, toolbarInitialY = 0;
  let isToolbarMinimized = false;

  let startX = 0, startY = 0;
  let initialPositions = [];
  let startW = 0, startH = 0;
  const positions = {};
  const sizes = {};
  const imagesData = {};

  const themeUri = window.wpThemeUri || './';

  // Inject styles
  const style = document.createElement('style');
  style.textContent = `
    .live-edit-btn {
      position: fixed;
      bottom: 24px;
      right: 24px;
      z-index: 99999;
      background: linear-gradient(135deg, #16A34A, #15803D);
      color: #fff;
      border: 2px solid #4ADE80;
      padding: 14px 24px;
      border-radius: 999px;
      font-weight: 800;
      font-size: 15px;
      cursor: pointer;
      box-shadow: 0 12px 36px rgba(22, 163, 74, 0.4);
      display: ${isLoggedIn ? 'flex' : 'none'};
      align-items: center;
      gap: 10px;
      transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      font-family: sans-serif;
    }
    .live-edit-btn:hover {
      transform: translateY(-4px) scale(1.04);
      background: linear-gradient(135deg, #22C55E, #16A34A);
      box-shadow: 0 16px 42px rgba(34, 197, 94, 0.5);
    }
    
    /* Professional Floating Toolbar */
    .live-edit-toolbar {
      position: fixed;
      bottom: 24px;
      /* Centred by auto margins inside a full-width band rather than
         left:50% + translateX(-50%): the translate variant resolved to 0 in
         practice and pushed the ~900px bar off the right edge, and it also gave
         the bar no upper bound, so it overflowed every viewport under ~950px. */
      left: 0;
      right: 0;
      margin: 0 auto;
      width: max-content;
      max-width: calc(100vw - 24px);
      transform: translateY(200px);
      z-index: 99999;
      background: rgba(9, 30, 19, 0.92);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1.5px solid #22C55E;
      color: #fff;
      padding: 12px 22px;
      border-radius: 24px;
      display: flex;
      align-items: center;
      gap: 12px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.65), 0 0 20px rgba(34, 197, 94, 0.2);
      transition: transform 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.25s;
      font-family: system-ui, -apple-system, sans-serif;
      user-select: none;
    }
    .live-edit-toolbar.active {
      transform: translateY(0);
    }
    .live-edit-toolbar.is-minimized {
      padding: 8px 16px;
      gap: 8px;
    }
    .live-edit-toolbar.is-minimized .toolbar-hideable {
      display: none !important;
    }

    .toolbar-drag-handle {
      cursor: move !important;
      padding: 8px 12px;
      background: rgba(242, 199, 46, 0.15);
      border: 1px solid rgba(242, 199, 46, 0.4);
      border-radius: 12px;
      font-size: 16px;
      color: #F2C72E;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s;
    }
    .toolbar-drag-handle:hover {
      background: rgba(242, 199, 46, 0.3);
      transform: scale(1.05);
    }

    .live-edit-toolbar-btn {
      padding: 10px 18px;
      border-radius: 14px;
      font-weight: 800;
      font-size: 13.5px;
      cursor: pointer;
      border: none;
      transition: all 0.25s ease;
      white-space: nowrap;
      display: inline-flex;
      align-items: center;
      gap: 7px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.25);
      letter-spacing: 0.2px;
    }
    .btn-save-edit {
      background: linear-gradient(135deg, #16A34A, #15803D);
      color: #ffffff;
      border: 1px solid #4ADE80;
    }
    .btn-save-edit:hover {
      background: linear-gradient(135deg, #22C55E, #16A34A);
      transform: translateY(-2px) scale(1.03);
      box-shadow: 0 6px 18px rgba(34, 197, 94, 0.4);
    }
    
    .btn-align-center {
      background: linear-gradient(135deg, #F59E0B, #D97706);
      color: #ffffff;
      border: 1px solid #FCD34D;
    }
    .btn-align-center:hover {
      background: linear-gradient(135deg, #FBBF24, #F59E0B);
      transform: translateY(-2px) scale(1.03);
      box-shadow: 0 6px 18px rgba(245, 158, 11, 0.4);
    }

    .btn-reset-pos {
      background: linear-gradient(135deg, #DC2626, #B91C1C);
      color: #ffffff;
      border: 1px solid #F87171;
    }
    .btn-reset-pos:hover {
      background: linear-gradient(135deg, #EF4444, #DC2626);
      transform: translateY(-2px) scale(1.03);
      box-shadow: 0 6px 18px rgba(239, 68, 68, 0.4);
    }

    .btn-minimize {
      background: rgba(255, 255, 255, 0.12);
      color: #8EF060;
      border: 1px solid rgba(142, 240, 96, 0.3);
    }
    .btn-minimize:hover {
      background: rgba(255, 255, 255, 0.22);
      color: #ffffff;
    }

    .btn-logout {
      background: #334155;
      color: #F8FAFC;
      border: 1px solid #64748B;
    }
    .btn-logout:hover {
      background: #475569;
    }

    .btn-cancel-edit {
      background: rgba(255,255,255,0.1);
      color: #94A3B8;
      border: 1px solid rgba(255,255,255,0.15);
    }
    .btn-cancel-edit:hover {
      background: rgba(255,255,255,0.2);
      color: #ffffff;
    }

    /* The toolbar is a single nowrap row of ~900px. Below that it has to wrap into a
       panel, otherwise the outermost buttons sit past the edge and are unreachable. */
    @media (max-width: 950px) {
      .live-edit-toolbar {
        left: 12px;
        right: 12px;
        bottom: 12px;
        width: auto;
        max-width: none;
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
        padding: 12px 14px;
        border-radius: 18px;
      }
      .live-edit-toolbar-btn {
        flex: 1 1 auto;
        justify-content: center;
        padding: 10px 12px;
        font-size: 12.5px;
      }
      .live-edit-btn { bottom: 16px; right: 16px; padding: 12px 18px; font-size: 14px; }
    }

    /* Elementor/Framer Style Smart Hover & Selection Controls */
    [data-editable] {
      position: relative !important;
      transition: outline 0.15s, background 0.15s, box-shadow 0.15s;
    }
    body.is-live-editing [data-editable] {
      outline: 1px dashed rgba(34, 197, 94, 0.35) !important;
      outline-offset: 3px;
    }
    body.is-live-editing [data-editable]:hover {
      outline: 2px solid #3B82F6 !important;
      background: rgba(59, 130, 246, 0.06) !important;
    }
    body.is-live-editing [data-editable].is-selected {
      outline: 2.5px solid #22C55E !important;
      background: rgba(34, 197, 94, 0.1) !important;
      box-shadow: 0 0 16px rgba(34, 197, 94, 0.25) !important;
    }

    body.is-live-editing img:not(.hero-bg-layer img) {
      cursor: pointer !important;
      transition: outline 0.2s, transform 0.2s;
    }
    body.is-live-editing img:not(.hero-bg-layer img):hover {
      outline: 3.5px solid #F97316 !important;
      outline-offset: 2px;
    }

    /* Hero background image remains static and untouchable */
    .hero-bg-layer, .hero-bg-layer img {
      pointer-events: none !important;
    }

    /* Image Swap Comparison Modal */
    .img-modal-overlay {
      position: fixed; inset: 0; background: rgba(9, 30, 19, 0.9);
      backdrop-filter: blur(12px); z-index: 1000001; display: none;
      align-items: center; justify-content: center; font-family: sans-serif;
    }
    .img-modal-card {
      background: #0B1F16; border: 1.5px solid #22C55E; border-radius: 26px;
      padding: 30px; width: 92%; max-width: 500px; color: #fff;
      box-shadow: 0 25px 60px rgba(0,0,0,0.75); position: relative;
    }
    .img-modal-title { font-size: 20px; font-weight: 800; color: #fff; margin: 0 0 4px; text-align: center; }
    .img-modal-subtitle { font-size: 13px; color: #b9c9c0; text-align: center; margin-bottom: 22px; }
    
    .img-compare-container {
      display: flex; align-items: center; justify-content: space-between;
      gap: 12px; margin: 18px 0 22px;
    }
    .img-compare-box {
      flex: 1; background: #fff; border-radius: 18px; padding: 12px; text-align: center; color: #0F172A;
      box-shadow: 0 4px 16px rgba(0,0,0,0.25); border: 2.5px solid #E2E8F0;
    }
    .img-compare-box.is-new { border-color: #EA580C; background: #FFF7ED; }
    .img-compare-label { font-size: 13px; font-weight: 800; margin-bottom: 8px; color: #334155; }
    .img-compare-box.is-new .img-compare-label { color: #C2410C; }
    .img-preview-frame {
      width: 100%; height: 140px; border-radius: 12px; overflow: hidden; background: #F1F5F9;
      display: flex; align-items: center; justify-content: center; border: 1px solid #CBD5E1;
    }
    .img-preview-frame img { width: 100%; height: 100%; object-fit: contain; }
    .img-compare-sub { font-size: 12px; font-weight: 700; color: #64748B; margin-top: 6px; }

    .img-compare-arrow {
      width: 42px; height: 42px; background: linear-gradient(135deg, #EA580C, #C2410C);
      border-radius: 50%; color: #FFF; display: flex; align-items: center; justify-content: center;
      font-size: 20px; font-weight: 900; box-shadow: 0 4px 14px rgba(234, 88, 12, 0.4); flex-shrink: 0;
    }

    .img-file-select-zone {
      background: rgba(34, 197, 94, 0.15); border: 2px dashed #22C55E; border-radius: 16px;
      padding: 14px; text-align: center; margin-bottom: 18px; cursor: pointer; transition: all 0.2s;
    }
    .img-file-select-zone:hover { background: rgba(34, 197, 94, 0.25); border-color: #4ADE80; transform: scale(1.01); }
    .img-file-select-zone span { font-size: 13px; font-weight: 800; color: #8EF060; display: block; }

    .img-confirm-btn {
      width: 100%; padding: 14px; background: linear-gradient(135deg, #EA580C, #C2410C);
      color: #FFF; border: none; border-radius: 16px; font-weight: 800; font-size: 15px;
      cursor: pointer; transition: all 0.2s; box-shadow: 0 8px 24px rgba(234,88,12,0.4);
      display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .img-confirm-btn:hover { transform: translateY(-2px); background: linear-gradient(135deg, #F97316, #EA580C); }
    .img-cancel-btn {
      width: 100%; padding: 12px; background: transparent; color: #b9c9c0;
      border: 1px solid rgba(255,255,255,0.2); border-radius: 16px; font-weight: 700; font-size: 14px;
      cursor: pointer; margin-top: 10px; transition: all 0.2s; text-align: center;
    }
    .img-cancel-btn:hover { background: rgba(255,255,255,0.1); color: #fff; }

    /* Drag Handle Bar - Shows on Hover & Selection Only */
    .canva-drag-handle {
      display: none;
      position: absolute;
      top: -30px;
      left: 50%;
      transform: translateX(-50%);
      background: linear-gradient(135deg, #16A34A, #15803D);
      color: #ffffff;
      font-size: 11px;
      font-weight: 800;
      padding: 3px 10px;
      border-radius: 8px;
      border: 1px solid #4ADE80;
      cursor: grab !important;
      user-select: none;
      z-index: 10002;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      font-family: system-ui, -apple-system, sans-serif;
      align-items: center;
      gap: 4px;
      white-space: nowrap;
      opacity: 0;
      transition: opacity 0.15s ease;
    }
    .canva-drag-handle:active {
      cursor: grabbing !important;
      background: #15803D;
    }
    body.is-live-editing [data-editable]:hover .canva-drag-handle,
    body.is-live-editing [data-editable].is-selected .canva-drag-handle {
      display: flex !important;
      opacity: 1 !important;
    }

    /* Canva Corner Anchor Dots */
    .canva-anchor-dot {
      display: none;
      position: absolute;
      width: 10px;
      height: 10px;
      background: #fff;
      border: 2px solid #22C55E;
      border-radius: 50%;
      z-index: 10001;
      pointer-events: none;
    }
    body.is-live-editing [data-editable].is-selected .canva-anchor-dot {
      display: block !important;
    }
    .canva-dot-tl { top: -8px; left: -8px; }
    .canva-dot-tr { top: -8px; right: -8px; }
    .canva-dot-bl { bottom: -8px; left: -8px; }

    /* Edge Resizer Handles - Shows on Hover & Selection Only */
    .canva-edge-resize {
      display: none;
      position: absolute;
      background: linear-gradient(135deg, #F59E0B, #D97706);
      border: 1px solid #FCD34D;
      z-index: 10003;
      border-radius: 6px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.3);
      opacity: 0;
      transition: opacity 0.15s, transform 0.15s;
    }
    .canva-edge-resize:hover {
      background: linear-gradient(135deg, #FBBF24, #F59E0B);
      transform: scale(1.2);
    }
    body.is-live-editing [data-editable]:hover .canva-edge-resize,
    body.is-live-editing [data-editable].is-selected .canva-edge-resize {
      display: block !important;
      opacity: 1 !important;
    }
    .canva-resize-e { right: -10px; top: 30%; bottom: 30%; width: 10px; cursor: ew-resize !important; }
    .canva-resize-w { left: -10px; top: 30%; bottom: 30%; width: 10px; cursor: ew-resize !important; }
    .canva-resize-s { bottom: -10px; left: 30%; right: 30%; height: 10px; cursor: ns-resize !important; }
    .canva-resize-se { right: -10px; bottom: -10px; width: 16px; height: 16px; border-radius: 50%; border: 1.5px solid #FFFFFF; cursor: nwse-resize !important; background: linear-gradient(135deg, #EA580C, #C2410C); }

    /* Live Coordinates Tooltip Badge */
    .live-coord-badge {
      position: fixed;
      z-index: 100005;
      background: #0B1F16;
      border: 1.5px solid #F2C72E;
      color: #F2C72E;
      padding: 6px 12px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 800;
      box-shadow: 0 8px 24px rgba(0,0,0,0.45);
      display: none;
      font-family: monospace;
      pointer-events: none;
    }

    /* Snap Alignment Lines */
    .snap-line-v {
      position: fixed;
      top: 0; bottom: 0; left: 50%; width: 2px;
      background: #F2C72E; z-index: 100004; display: none;
      pointer-events: none; box-shadow: 0 0 10px #F2C72E;
    }

    /* Marquee Box Selection */
    .live-selection-marquee {
      position: absolute;
      border: 2px solid #22C55E;
      background: rgba(34, 197, 94, 0.18);
      z-index: 99998;
      pointer-events: none;
      display: none;
      border-radius: 8px;
    }

    /* Floating Alignment Bubble */
    .element-align-bubble {
      display: none;
      position: absolute;
      z-index: 100003;
      background: #0B1F16;
      border: 1.5px solid #F2C72E;
      border-radius: 12px;
      padding: 6px 10px;
      gap: 8px;
      box-shadow: 0 10px 28px rgba(0,0,0,0.5);
      font-family: sans-serif;
    }
    .element-align-bubble button {
      background: rgba(255,255,255,0.12);
      color: #fff; border: none; padding: 6px 10px;
      border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer;
    }
    .element-align-bubble button:hover { background: #22C55E; color: #fff; }

    /* Admin Login Modal */
    .admin-login-overlay {
      position: fixed; inset: 0; background: rgba(9, 30, 19, 0.88);
      backdrop-filter: blur(10px); z-index: 1000000; display: none;
      align-items: center; justify-content: center; font-family: sans-serif;
    }
    .admin-login-modal {
      background: #0B1F16; border: 1.5px solid #22C55E; border-radius: 26px;
      padding: 36px; width: 100%; max-width: 420px;
      box-shadow: 0 25px 60px rgba(0,0,0,0.7); color: #fff;
    }
    .admin-login-modal h3 { font-size: 22px; font-weight: 800; margin: 0 0 8px; color: #F2C72E; }
    .admin-login-modal p { font-size: 14px; color: #b9c9c0; margin: 0 0 22px; }
    .admin-input-group { margin-bottom: 18px; }
    .admin-input-group label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px; color: #8EF060; }
    .admin-input-group input {
      width: 100%; padding: 14px 16px; background: #1e2a24;
      border: 1.5px solid rgba(140,220,175,.3); border-radius: 14px;
      color: #fff; font-size: 15px; outline: none; box-sizing: border-box;
    }
    .admin-input-group input:focus { border-color: #22C55E; box-shadow: 0 0 14px rgba(34,197,94,0.45); }
    .admin-login-btn {
      width: 100%; padding: 14px; background: linear-gradient(135deg, #16A34A, #15803D); color: #fff;
      border: none; border-radius: 14px; font-weight: 800; font-size: 15px; cursor: pointer; margin-top: 10px;
      box-shadow: 0 6px 20px rgba(22,163,74,0.4);
    }
    .admin-login-btn:hover { background: linear-gradient(135deg, #22C55E, #16A34A); }
    .admin-login-close {
      position: absolute; top: 18px; right: 18px; background: transparent;
      border: none; color: #8EF060; font-size: 20px; cursor: pointer;
    }

    .live-edit-toast {
      position: fixed; top: 80px; left: 50%; transform: translateX(-50%);
      background: #22C55E; color: #fff; padding: 14px 28px; border-radius: 14px;
      font-weight: 800; font-size: 15px; z-index: 100000;
      box-shadow: 0 12px 36px rgba(0,0,0,0.35); display: none;
    }
  `;
  document.head.appendChild(style);

  // Trigger button
  const triggerBtn = document.createElement('button');
  triggerBtn.className = 'live-edit-btn';
  triggerBtn.innerHTML = '✏️ โหมด Canva Drag & Live Editor';
  document.body.appendChild(triggerBtn);

  // Clean High-Contrast Professional Toolbar
  const toolbar = document.createElement('div');
  toolbar.className = 'live-edit-toolbar';
  toolbar.id = 'live-main-toolbar';
  toolbar.innerHTML = `
    <span class="toolbar-drag-handle" id="toolbar-handle" title="คลิกค้างเพื่อลากย้ายแถบเครื่องมือไปมุมอื่น">⠿</span>
    <button class="live-edit-toolbar-btn btn-align-center toolbar-hideable" id="live-center-all-btn">
      <span style="font-size: 16px;">🎯</span> จัดตรงกลางทั้งหมด
    </button>
    <button class="live-edit-toolbar-btn btn-save-edit toolbar-hideable" id="live-save-btn">
      <span style="font-size: 16px;">💾</span> บันทึกทั้งหมด (Save)
    </button>
    <button class="live-edit-toolbar-btn btn-reset-pos toolbar-hideable" id="live-reset-btn">
      <span style="font-size: 16px;">🔄</span> รีเซ็ต
    </button>
    <button class="live-edit-toolbar-btn btn-minimize" id="live-min-btn" title="ย่อ/ขยายแถบเครื่องมือ">
      <span style="font-size: 16px;">👁️</span> ย่อแถบ
    </button>
    <button class="live-edit-toolbar-btn btn-logout toolbar-hideable" id="live-logout-btn">
      <span style="font-size: 16px;">🚪</span> ออกจากระบบ
    </button>
    <button class="live-edit-toolbar-btn btn-cancel-edit toolbar-hideable" id="live-cancel-btn">
      <span style="font-size: 16px;">❌</span> ปิด (Close)
    </button>
  `;
  document.body.appendChild(toolbar);

  // Toolbar Dragging logic
  const handle = toolbar.querySelector('#toolbar-handle');
  handle.addEventListener('mousedown', (e) => {
    isDraggingToolbar = true;
    toolbarStartX = e.clientX;
    toolbarStartY = e.clientY;

    const rect = toolbar.getBoundingClientRect();
    toolbarInitialX = rect.left;
    toolbarInitialY = rect.top;

    toolbar.style.transition = 'none';
    toolbar.style.bottom = 'auto';
    toolbar.style.transform = 'none';

    document.addEventListener('mousemove', handleToolbarMove);
    document.addEventListener('mouseup', handleToolbarUp);
  });

  function handleToolbarMove(e) {
    if (!isDraggingToolbar) return;
    const dx = e.clientX - toolbarStartX;
    const dy = e.clientY - toolbarStartY;

    toolbar.style.left = (toolbarInitialX + dx) + 'px';
    toolbar.style.top = (toolbarInitialY + dy) + 'px';
  }

  function handleToolbarUp() {
    if (isDraggingToolbar) {
      isDraggingToolbar = false;
      toolbar.style.transition = '';
      document.removeEventListener('mousemove', handleToolbarMove);
      document.removeEventListener('mouseup', handleToolbarUp);
    }
  }

  // Minimize Toggle
  document.getElementById('live-min-btn').addEventListener('click', () => {
    isToolbarMinimized = !isToolbarMinimized;
    const minBtn = document.getElementById('live-min-btn');
    if (isToolbarMinimized) {
      toolbar.classList.add('is-minimized');
      minBtn.innerHTML = '<span style="font-size:16px;">👁️</span> แสดงแถบเครื่องมือ';
    } else {
      toolbar.classList.remove('is-minimized');
      minBtn.innerHTML = '<span style="font-size:16px;">👁️</span> ย่อแถบ';
    }
  });

  // Align Bubble & Badges
  const alignBubble = document.createElement('div');
  alignBubble.className = 'element-align-bubble';
  alignBubble.innerHTML = `
    <button id="bubble-align-left" title="จัดชิดซ้าย">⬅️ ชิดซ้าย</button>
    <button id="bubble-align-center" title="จัดตรงกลาง">🎯 ตรงกลาง</button>
    <button id="bubble-align-right" title="จัดชิดขวา">➡️ ชิดขวา</button>
    <button id="bubble-center-pos" title="ล้างพิกัดเอียงให้ตรงกลาง">📍 จัดสมมาตรกลาง</button>
  `;
  document.body.appendChild(alignBubble);

  const coordBadge = document.createElement('div');
  coordBadge.className = 'live-coord-badge';
  document.body.appendChild(coordBadge);

  const snapLineV = document.createElement('div');
  snapLineV.className = 'snap-line-v';
  document.body.appendChild(snapLineV);

  const marqueeBox = document.createElement('div');
  marqueeBox.className = 'live-selection-marquee';
  document.body.appendChild(marqueeBox);

  // Hidden File Input
  const hiddenFileInput = document.createElement('input');
  hiddenFileInput.type = 'file';
  hiddenFileInput.accept = 'image/*';
  hiddenFileInput.style.display = 'none';
  document.body.appendChild(hiddenFileInput);

  // Image Compare Modal
  const imgModalOverlay = document.createElement('div');
  imgModalOverlay.className = 'img-modal-overlay';
  imgModalOverlay.innerHTML = `
    <div class="img-modal-card">
      <button class="admin-login-close" id="img-modal-close">✕</button>
      <div class="img-modal-title">Confirm Profile Image Update</div>
      <div class="img-modal-subtitle">Confirm Your New Image<br><span style="font-size:11px; opacity:0.8;">ในหัวข้อ: โปรดยืนยันการเปลี่ยนแปลงรูปภาพ</span></div>
      
      <div class="img-file-select-zone" id="img-select-trigger">
        <span>📁 คลิกที่นี่เพื่อเลือกรูปภาพใหม่ (Choose File)</span>
      </div>

      <div class="img-compare-container">
        <!-- Old Image Box -->
        <div class="img-compare-box">
          <div class="img-compare-label">ของเก่า (Current)</div>
          <div class="img-preview-frame">
            <img id="img-old-preview" src="" alt="ของเก่า">
          </div>
          <div class="img-compare-sub">ของเก่า<br>Current Photo</div>
        </div>

        <!-- Arrow Indicator -->
        <div class="img-compare-arrow">➔</div>

        <!-- New Image Box -->
        <div class="img-compare-box is-new">
          <div class="img-compare-label">ของใหม่ (New Upload)</div>
          <div class="img-preview-frame">
            <img id="img-new-preview" src="" alt="ของใหม่">
          </div>
          <div class="img-compare-sub">ของใหม่<br>New Upload</div>
        </div>
      </div>

      <div style="font-size: 12px; text-align: center; color: #b9c9c0; margin-bottom: 18px;">
        คุณกำลังจะเปลี่ยนรูปภาพจาก <b style="color:#fff;">ของเก่า</b> เป็น <b style="color:#F97316;">ของใหม่</b> โปรดตรวจสอบก่อนกดยืนยัน
      </div>

      <button class="img-confirm-btn" id="img-submit-confirm">
        <span style="font-size:18px;">☑️</span> กดยืนยันอีกครั้ง
      </button>
      <button class="img-cancel-btn" id="img-cancel-btn">ยกเลิก</button>
    </div>
  `;
  document.body.appendChild(imgModalOverlay);

  let currentImgTargetEl = null;
  let selectedNewFile = null;

  function openImageSwapModalForElement(img) {
    if (!img) return;
    currentImgTargetEl = img;
    selectedNewFile = null;

    document.getElementById('img-old-preview').src = img.src;
    document.getElementById('img-new-preview').src = img.src;

    imgModalOverlay.style.display = 'flex';
  }

  // Open Image Swap Modal on image click in editor mode (excluding hero background layer)
  document.addEventListener('click', (e) => {
    if (!isEditing) return;
    const img = e.target.closest('img');
    if (img && !img.closest('.img-modal-card') && !img.closest('.hero-bg-layer')) {
      e.preventDefault();
      e.stopPropagation();
      openImageSwapModalForElement(img);
    }
  });

  document.getElementById('img-select-trigger').addEventListener('click', () => {
    hiddenFileInput.click();
  });

  hiddenFileInput.addEventListener('change', () => {
    if (hiddenFileInput.files && hiddenFileInput.files[0]) {
      selectedNewFile = hiddenFileInput.files[0];
      const reader = new FileReader();
      reader.onload = (e) => {
        document.getElementById('img-new-preview').src = e.target.result;
      };
      reader.readAsDataURL(selectedNewFile);
    }
  });

  function closeImgModal() {
    imgModalOverlay.style.display = 'none';
    selectedNewFile = null;
    currentImgTargetEl = null;
  }

  document.getElementById('img-modal-close').addEventListener('click', closeImgModal);
  document.getElementById('img-cancel-btn').addEventListener('click', closeImgModal);

  // Confirm image upload & replacement
  document.getElementById('img-submit-confirm').addEventListener('click', async () => {
    if (!currentImgTargetEl) return;
    if (!selectedNewFile) {
      showToast('⚠️ กรุณาคลิกเลือกรูปภาพใหม่ก่อนกดยืนยัน');
      hiddenFileInput.click();
      return;
    }

    const confirmBtn = document.getElementById('img-submit-confirm');
    confirmBtn.innerHTML = '⏳ กำลังอัปโหลด...';
    confirmBtn.disabled = true;

    const formData = new FormData();
    formData.append('image_file', selectedNewFile);

    try {
      const res = await fetch(themeUri + 'save_content.php?action=upload_image', {
        method: 'POST',
        body: formData
      });
      const json = await res.json();
      if (json.success) {
        currentImgTargetEl.src = json.url;

        let imgKey = currentImgTargetEl.getAttribute('data-editable-img');
        if (!imgKey) {
          imgKey = currentImgTargetEl.getAttribute('data-editable') || ('site_img_' + Date.now());
          currentImgTargetEl.setAttribute('data-editable-img', imgKey);
        }
        imagesData[imgKey + '_img'] = json.url;

        // Auto save to content json
        const saveFields = {};
        saveFields[imgKey + '_img'] = json.url;

        await fetch(themeUri + 'save_content.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ page: pageName, fields: saveFields })
        });

        showToast('🎉 เปลี่ยนแปลงรูปภาพเรียบร้อยแล้ว!');
        closeImgModal();
      } else {
        alert('เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ: ' + (json.error || 'Unknown error'));
      }
    } catch (e) {
      alert('เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์');
    } finally {
      confirmBtn.innerHTML = '<span style="font-size:18px;">☑️</span> กดยืนยันอีกครั้ง';
      confirmBtn.disabled = false;
    }
  });

  // Login Modal Overlay
  const loginOverlay = document.createElement('div');
  loginOverlay.className = 'admin-login-overlay';
  loginOverlay.innerHTML = `
    <div class="admin-login-modal" style="position:relative;">
      <button class="admin-login-close" id="admin-close-modal">✕</button>
      <h3>🔒 เข้าสู่ระบบผู้ดูแล (Admin Login)</h3>
      <p>กรุณากรอกชื่อผู้ใช้และรหัสผ่านเพื่อเข้าสู่โหมดแก้ไข</p>
      <div class="admin-input-group">
        <label>ชื่อผู้ใช้ (Username):</label>
        <input type="text" id="admin-user-input" value="admin" placeholder="admin">
      </div>
      <div class="admin-input-group">
        <label>รหัสผ่าน (Password):</label>
        <input type="password" id="admin-pass-input" placeholder="รหัสผ่านผู้ดูแลระบบ">
      </div>
      <div id="admin-login-error" style="color:#ff6b6b; font-size:12px; margin-bottom:12px; display:none;"></div>
      <button class="admin-login-btn" id="admin-submit-login">เข้าสู่ระบบ (Login)</button>
    </div>
  `;
  document.body.appendChild(loginOverlay);

  const toast = document.createElement('div');
  toast.className = 'live-edit-toast';
  toast.id = 'live-edit-toast';
  document.body.appendChild(toast);

  function showToast(msg) {
    toast.textContent = msg;
    toast.style.display = 'block';
    setTimeout(() => { toast.style.display = 'none'; }, 3000);
  }

  function applyPosition(el, pos) {
    if (!el || !pos) return;
    el.style.position = 'relative';
    el.style.left = (pos.x || 0) + 'px';
    el.style.top = (pos.y || 0) + 'px';
  }

  // Load saved data
  async function loadSavedData() {
    try {
      const res = await fetch(themeUri + 'data/content_' + pageName + '.json?v=' + Date.now());
      if (res.ok) {
        const json = await res.json();
        Object.keys(json).forEach(key => {
          if (key.endsWith('_pos')) {
            const baseKey = key.slice(0, -4);
            const el = document.querySelector(`[data-editable="${baseKey}"]`);
            const pos = json[key];
            if (el && pos && typeof pos.x === 'number' && typeof pos.y === 'number') {
              applyPosition(el, pos);
              positions[key] = pos;
            }
          } else if (key.endsWith('_size')) {
            const baseKey = key.slice(0, -5);
            const el = document.querySelector(`[data-editable="${baseKey}"]`);
            const size = json[key];
            if (el && size && typeof size.w === 'number') {
              el.style.width = size.w + 'px';
              el.style.maxWidth = 'none';
              el.style.minWidth = '0px';
              if (typeof size.h === 'number') el.style.height = size.h + 'px';
              sizes[key] = size;
            }
          } else if (key.endsWith('_img')) {
            const baseKey = key.slice(0, -4);
            const img = document.querySelector(`img[data-editable-img="${baseKey}"]`) || document.querySelector(`img[data-editable="${baseKey}"]`);
            if (img && json[key]) {
              img.src = json[key];
              imagesData[key] = json[key];
            }
          } else {
            const el = document.querySelector(`[data-editable="${key}"]`);
            if (el && json[key]) {
              el.innerHTML = json[key];
            }
          }
        });

        // RE-INITIALIZE CANVA CONTROLS AFTER APPLYING SAVED INNERHTML!
        if (isEditing) {
          setupCanvaControls();
        }
      }
    } catch (e) { }
  }
  loadSavedData();

  // Check Login Status
  async function checkAuth() {
    /* The server is the only authority here. localStorage used to short-circuit
       this check, which let the UI open a full edit session that every save would
       then be refused for. */
    try {
      const res = await fetch(themeUri + 'save_content.php?action=check');
      if (res.ok) {
        const json = await res.json();
        if (json.isLoggedIn) {
          isLoggedIn = true;
          localStorage.setItem('synergy_admin_auth', '1');
          triggerBtn.style.display = 'flex';
          if (window.location.search.includes('edit=true')) {
            enableEditing();
          }
          return;
        }
      }
    } catch (e) { }
    localStorage.removeItem('synergy_admin_auth');
    isLoggedIn = false;
    triggerBtn.style.display = 'none';
  }
  checkAuth();

  function setSelected(el, append = false) {
    if (!append) {
      document.querySelectorAll('[data-editable].is-selected').forEach(item => item.classList.remove('is-selected'));
      selectedEls = [];
    }
    if (el && !selectedEls.includes(el)) {
      el.classList.add('is-selected');
      selectedEls.push(el);
    }
    if (selectedEls.length === 1) showAlignBubble(selectedEls[0]);
    else hideAlignBubble();
  }

  function showAlignBubble(el) {
    const rect = el.getBoundingClientRect();
    alignBubble.style.top = (window.scrollY + rect.top - 42) + 'px';
    alignBubble.style.left = Math.max(10, window.scrollX + rect.left + (rect.width / 2) - 130) + 'px';
    alignBubble.style.display = 'flex';
  }

  function hideAlignBubble() {
    alignBubble.style.display = 'none';
  }

  // Setup Controls (Smart Elementor-style hover/selection triggers)
  function setupCanvaControls() {
    document.querySelectorAll('[data-editable]').forEach(el => {
      // Ensure relative positioning
      el.style.position = 'relative';

      // Drag handle bar at top center
      let handle = el.querySelector('.canva-drag-handle');
      if (!handle) {
        handle = document.createElement('div');
        handle.className = 'canva-drag-handle';
        handle.innerHTML = '⠿ คลิก/ลากย้าย';
        handle.title = 'คลิกค้างเพื่อลากย้ายองค์ประกอบแบบ Elementor';
        handle.addEventListener('mousedown', (e) => {
          e.stopPropagation();
          e.preventDefault();
          startDraggingElements(el, e);
        });
        el.appendChild(handle);
      }

      // Corner Dots
      if (!el.querySelector('.canva-dot-tl')) {
        ['tl', 'tr', 'bl'].forEach(pos => {
          const dot = document.createElement('div');
          dot.className = `canva-anchor-dot canva-dot-${pos}`;
          el.appendChild(dot);
        });
      }

      // High-Contrast Edge Resizer Handles (Amber Gold Pills)
      const edgeTypes = [
        { type: 'e', title: 'ลากขอบขวา หุบ/ขยายความกว้าง' },
        { type: 'w', title: 'ลากขอบซ้าย หุบ/ขยายความกว้าง' },
        { type: 's', title: 'ลากขอบล่าง หุบ/ขยายความสูง' },
        { type: 'se', title: 'ดึงมุมขวาขยายทั้งกว้างและสูง' }
      ];

      edgeTypes.forEach(edge => {
        const cls = `canva-resize-${edge.type}`;
        let resizeBtn = el.querySelector('.' + cls);
        if (!resizeBtn) {
          resizeBtn = document.createElement('div');
          resizeBtn.className = `canva-edge-resize ${cls}`;
          resizeBtn.title = edge.title;
          resizeBtn.addEventListener('mousedown', (e) => {
            e.stopPropagation();
            e.preventDefault();
            activeResizeEl = el;
            resizeDir = edge.type;
            startX = e.clientX;
            startY = e.clientY;
            startW = el.offsetWidth;
            startH = el.offsetHeight;

            document.addEventListener('mousemove', handleResizeMove);
            document.addEventListener('mouseup', handleResizeUp);
          });
          el.appendChild(resizeBtn);
        }
      });

      el.addEventListener('click', (e) => {
        if (isEditing) {
          e.stopPropagation();
          setSelected(el, e.shiftKey);
        }
      });
    });
  }

  function startDraggingElements(targetEl, e) {
    if (!selectedEls.includes(targetEl)) {
      setSelected(targetEl);
    }

    activeDragEl = targetEl;
    startX = e.clientX;
    startY = e.clientY;

    initialPositions = selectedEls.map(el => {
      const key = el.getAttribute('data-editable') + '_pos';
      const pos = positions[key] || { x: 0, y: 0 };
      return { el: el, key: key, startX: pos.x, startY: pos.y };
    });

    document.addEventListener('mousemove', handleMultiMouseMove);
    document.addEventListener('mouseup', handleMultiMouseUp);
  }

  function handleMultiMouseMove(e) {
    if (!activeDragEl) return;
    e.preventDefault();
    const dx = e.clientX - startX;
    const dy = e.clientY - startY;

    let snapX = false;

    initialPositions.forEach(item => {
      let newX = item.startX + dx;
      let newY = item.startY + dy;

      if (Math.abs(newX) < 8) {
        newX = 0;
        snapX = true;
      }

      applyPosition(item.el, { x: newX, y: newY });
      positions[item.key] = { x: newX, y: newY };
    });

    if (snapX) snapLineV.style.display = 'block';
    else snapLineV.style.display = 'none';

    const targetKey = activeDragEl.getAttribute('data-editable') + '_pos';
    const curPos = positions[targetKey] || { x: 0, y: 0 };
    coordBadge.innerHTML = `📍 X: ${curPos.x > 0 ? '+' + curPos.x : curPos.x}px | Y: ${curPos.y > 0 ? '+' + curPos.y : curPos.y}px`;
    coordBadge.style.top = (e.clientY + 18) + 'px';
    coordBadge.style.left = (e.clientX + 18) + 'px';
    coordBadge.style.display = 'block';

    if (selectedEls.length === 1) showAlignBubble(activeDragEl);
  }

  function handleMultiMouseUp() {
    if (activeDragEl) {
      document.removeEventListener('mousemove', handleMultiMouseMove);
      document.removeEventListener('mouseup', handleMultiMouseUp);
      coordBadge.style.display = 'none';
      snapLineV.style.display = 'none';
      activeDragEl = null;
    }
  }

  function handleResizeMove(e) {
    if (!activeResizeEl) return;
    e.preventDefault();
    const dx = e.clientX - startX;
    const dy = e.clientY - startY;

    activeResizeEl.style.maxWidth = 'none';
    activeResizeEl.style.minWidth = '0px';

    let newW = startW;
    let newH = startH;

    if (resizeDir === 'e') {
      newW = Math.max(30, startW + dx);
    } else if (resizeDir === 'w') {
      newW = Math.max(30, startW - dx);
    } else if (resizeDir === 's') {
      newH = Math.max(20, startH + dy);
    } else if (resizeDir === 'se') {
      newW = Math.max(30, startW + dx);
      newH = Math.max(20, startH + dy);
    }

    activeResizeEl.style.width = newW + 'px';
    if (resizeDir === 's' || resizeDir === 'se') {
      activeResizeEl.style.height = newH + 'px';
    }

    const sizeKey = activeResizeEl.getAttribute('data-editable') + '_size';
    sizes[sizeKey] = { w: newW, h: newH };

    coordBadge.innerHTML = `📐 ขนาด: ${newW}px × ${newH}px`;
    coordBadge.style.top = (e.clientY + 18) + 'px';
    coordBadge.style.left = (e.clientX + 18) + 'px';
    coordBadge.style.display = 'block';
  }

  function handleResizeUp() {
    if (activeResizeEl) {
      document.removeEventListener('mousemove', handleResizeMove);
      document.removeEventListener('mouseup', handleResizeUp);
      coordBadge.style.display = 'none';
      activeResizeEl = null;
    }
  }

  // Marquee Selection
  document.addEventListener('mousedown', (e) => {
    if (!isEditing) return;
    if (e.target.closest('[data-editable]') || e.target.closest('.live-edit-toolbar') || e.target.closest('.element-align-bubble') || e.target.closest('.canva-edge-resize') || e.target.closest('.img-modal-card')) {
      return;
    }

    isMarquee = true;
    marqueeStartX = e.pageX;
    marqueeStartY = e.pageY;

    marqueeBox.style.left = marqueeStartX + 'px';
    marqueeBox.style.top = marqueeStartY + 'px';
    marqueeBox.style.width = '0px';
    marqueeBox.style.height = '0px';
    marqueeBox.style.display = 'block';

    document.addEventListener('mousemove', handleMarqueeMove);
    document.addEventListener('mouseup', handleMarqueeUp);
  });

  function handleMarqueeMove(e) {
    if (!isMarquee) return;
    const curX = e.pageX;
    const curY = e.pageY;

    const left = Math.min(marqueeStartX, curX);
    const top = Math.min(marqueeStartY, curY);
    const width = Math.abs(curX - marqueeStartX);
    const height = Math.abs(curY - marqueeStartY);

    marqueeBox.style.left = left + 'px';
    marqueeBox.style.top = top + 'px';
    marqueeBox.style.width = width + 'px';
    marqueeBox.style.height = height + 'px';

    const marqueeRect = { left: left, top: top, right: left + width, bottom: top + height };
    document.querySelectorAll('[data-editable]').forEach(el => {
      const rect = el.getBoundingClientRect();
      const pageRect = { left: rect.left + window.scrollX, top: rect.top + window.scrollY, right: rect.right + window.scrollX, bottom: rect.bottom + window.scrollY };

      if (pageRect.left < marqueeRect.right && pageRect.right > marqueeRect.left &&
        pageRect.top < marqueeRect.bottom && pageRect.bottom > marqueeRect.top) {
        setSelected(el, true);
      }
    });
  }

  function handleMarqueeUp() {
    if (isMarquee) {
      isMarquee = false;
      marqueeBox.style.display = 'none';
      document.removeEventListener('mousemove', handleMarqueeMove);
      document.removeEventListener('mouseup', handleMarqueeUp);
    }
  }

  // Alignment Bubble actions
  document.getElementById('bubble-align-left').addEventListener('click', () => {
    selectedEls.forEach(el => el.style.textAlign = 'left');
    showToast('⬅️ จัดชิดซ้ายเรียบร้อย');
  });

  document.getElementById('bubble-align-center').addEventListener('click', () => {
    selectedEls.forEach(el => {
      el.style.textAlign = 'center';
      el.style.marginLeft = 'auto';
      el.style.marginRight = 'auto';
    });
    showToast('🎯 จัดข้อความตรงกลางเรียบร้อย');
  });

  document.getElementById('bubble-align-right').addEventListener('click', () => {
    selectedEls.forEach(el => el.style.textAlign = 'right');
    showToast('➡️ จัดชิดขวาเรียบร้อย');
  });

  document.getElementById('bubble-center-pos').addEventListener('click', () => {
    selectedEls.forEach(el => {
      el.style.left = '0px';
      const key = el.getAttribute('data-editable') + '_pos';
      if (positions[key]) positions[key].x = 0;
    });
    showToast('📍 ล้างพิกัดเอียง จัดให้อยู่กึ่งกลางสมมาตรเรียบร้อย');
  });

  document.getElementById('live-center-all-btn').addEventListener('click', () => {
    document.querySelectorAll('[data-editable]').forEach(el => {
      el.style.left = '0px';
      el.style.textAlign = 'center';
      el.style.marginLeft = 'auto';
      el.style.marginRight = 'auto';
      const key = el.getAttribute('data-editable') + '_pos';
      if (positions[key]) positions[key].x = 0;
    });
    showToast('🎯 จัดองค์ประกอบทั้งหมดให้อยู่กึ่งกลางสมบูรณ์เรียบร้อยแล้ว!');
  });

  function enableEditing() {
    if (!isLoggedIn) {
      openLoginModal();
      return;
    }

    isEditing = true;
    document.body.classList.add('is-live-editing');
    toolbar.classList.add('active');
    triggerBtn.style.display = 'none';

    setupCanvaControls();

    document.querySelectorAll('[data-editable]').forEach(el => {
      el.contentEditable = 'true';
    });
  }

  function disableEditing() {
    isEditing = false;
    document.body.classList.remove('is-live-editing');
    toolbar.classList.remove('active');
    hideAlignBubble();
    coordBadge.style.display = 'none';
    snapLineV.style.display = 'none';
    if (isLoggedIn) {
      triggerBtn.style.display = 'flex';
    }

    document.querySelectorAll('[data-editable]').forEach(el => {
      el.contentEditable = 'false';
      el.classList.remove('is-selected');
    });
  }

  triggerBtn.addEventListener('click', enableEditing);
  document.getElementById('live-cancel-btn').addEventListener('click', disableEditing);

  document.getElementById('live-logout-btn').addEventListener('click', async () => {
    localStorage.removeItem('synergy_admin_auth');
    await fetch(themeUri + 'save_content.php?action=logout');
    isLoggedIn = false;
    disableEditing();
    triggerBtn.style.display = 'none';
    showToast('🚪 ออกจากระบบเรียบร้อยแล้ว');
  });

  // Permanently Reset All Positions & Sizes
  document.getElementById('live-reset-btn').addEventListener('click', async () => {
    document.querySelectorAll('[data-editable]').forEach(el => {
      el.style.position = '';
      el.style.left = '';
      el.style.top = '';
      el.style.width = '';
      el.style.height = '';
      el.style.maxWidth = '';
      el.style.minWidth = '';
      el.style.textAlign = '';
      const key = el.getAttribute('data-editable');
      positions[key + '_pos'] = { x: 0, y: 0 };
      sizes[key + '_size'] = null;
    });

    const resetFields = {};
    document.querySelectorAll('[data-editable]').forEach(el => {
      const key = el.getAttribute('data-editable');
      if (key) {
        resetFields[key + '_pos'] = { x: 0, y: 0 };
        resetFields[key + '_size'] = null;
      }
    });

    try {
      await fetch(themeUri + 'save_content.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ page: pageName, fields: resetFields })
      });
    } catch (e) { }

    hideAlignBubble();
    showToast('🔄 รีเซ็ตกลับตำแหน่งตั้งต้นสมบูรณ์เรียบร้อยแล้ว!');
  });

  document.getElementById('live-save-btn').addEventListener('click', async () => {
    const fields = {};
    document.querySelectorAll('[data-editable]').forEach(el => {
      const key = el.getAttribute('data-editable');
      if (key) {
        const clone = el.cloneNode(true);
        clone.querySelectorAll('.canva-drag-handle, .canva-anchor-dot, .live-resize-handle, .canva-edge-resize').forEach(child => child.remove());

        fields[key] = clone.innerHTML.trim();

        const posKey = key + '_pos';
        fields[posKey] = positions[posKey] || { x: 0, y: 0 };

        const sizeKey = key + '_size';
        if (sizes[sizeKey]) {
          fields[sizeKey] = sizes[sizeKey];
        }
      }
    });

    Object.keys(imagesData).forEach(imgKey => {
      fields[imgKey] = imagesData[imgKey];
    });

    const saveBtn = document.getElementById('live-save-btn');
    saveBtn.innerHTML = '<span style="font-size:16px;">⏳</span> กำลังบันทึก...';
    saveBtn.disabled = true;

    try {
      const res = await fetch(themeUri + 'save_content.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ page: pageName, fields: fields })
      });
      const json = await res.json();
      if (json.success) {
        showToast('🎉 บันทึกเนื้อหาและตำแหน่งเรียบร้อยแล้ว!');
        disableEditing();
      } else {
        alert('เกิดข้อผิดพลาดในการบันทึก: ' + (json.error || 'Unknown error'));
      }
    } catch (e) {
      alert('เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์');
    } finally {
      saveBtn.innerHTML = '<span style="font-size:16px;">💾</span> บันทึกทั้งหมด (Save)';
      saveBtn.disabled = false;
    }
  });

  // Login Modal
  function openLoginModal() {
    loginOverlay.style.display = 'flex';
    document.getElementById('admin-pass-input').focus();
  }

  function closeLoginModal() {
    loginOverlay.style.display = 'none';
  }

  document.getElementById('admin-close-modal').addEventListener('click', closeLoginModal);

  document.getElementById('admin-submit-login').addEventListener('click', async () => {
    const user = document.getElementById('admin-user-input').value.trim();
    const pass = document.getElementById('admin-pass-input').value.trim();
    const errDiv = document.getElementById('admin-login-error');

    errDiv.style.display = 'none';

    try {
      const res = await fetch(themeUri + 'save_content.php?action=login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username: user, password: pass })
      });
      const json = await res.json();
      if (json.success) {
        isLoggedIn = true;
        localStorage.setItem('synergy_admin_auth', '1');
        closeLoginModal();
        showToast('🎉 เข้าสู่ระบบสำเร็จ (จำข้อมูลไว้ 1 ปี)!');
        triggerBtn.style.display = 'flex';
        enableEditing();
      } else {
        errDiv.textContent = json.error || 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
        errDiv.style.display = 'block';
      }
    } catch (e) {
      errDiv.textContent = 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์';
      errDiv.style.display = 'block';
    }
  });

  // Secret Shortcut: Ctrl + Shift + E
  document.addEventListener('keydown', (e) => {
    if (e.ctrlKey && e.shiftKey && e.code === 'KeyE') {
      e.preventDefault();
      if (isLoggedIn) {
        if (isEditing) disableEditing();
        else enableEditing();
      } else {
        openLoginModal();
      }
    }
  });

  if ((window.location.search.includes('edit=true') || window.location.search.includes('login=true')) && !isLoggedIn) {
    setTimeout(openLoginModal, 500);
  }
})();
