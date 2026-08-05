<?php
/**
 * Cookie consent banner + preference centre  (PDPA / พ.ร.บ.คุ้มครองข้อมูลส่วนบุคคล 2562)
 *
 * WHY IT IS A PARTIAL
 * Written as a standalone include so the move to WordPress is a one-line change: drop
 * this file into the theme and call it from footer.php with
 *     get_template_part( 'components/cookie-consent' );
 * Nothing in here depends on the plain-PHP router — it only uses home_url(), which the
 * page templates already shim when running outside WordPress.
 *
 * HOW CONSENT IS STORED
 * A single first-party cookie, synergy_cookie_consent, holding a JSON record:
 *     { "v":1, "ts":"2026-08-04T…Z", "analytics":true, "preferences":true }
 * A cookie rather than localStorage on purpose:
 *   · PHP (and later WordPress/Complianz) can read it server-side to decide what to emit
 *   · the timestamp + version is the evidence PDPA expects you to be able to produce
 *   · the cookie itself is strictly necessary, so it needs no consent of its own
 *
 * HOW SCRIPTS GET GATED  (this is the part most banners get wrong)
 * PDPA s.19 requires consent BEFORE processing, so a non-essential script must not run
 * until the visitor agrees. Add future tags like this — note type="text/plain":
 *     <script type="text/plain" data-consent="analytics" data-src="https://…"></script>
 *     <script type="text/plain" data-consent="analytics">gtag('config','G-XXXX');</script>
 * They stay inert until the matching category is granted, then are activated here without
 * a page reload. Nothing is gated today because the site currently loads no analytics.
 */
?>
<style>
  /* Scoped, rem-based sizes. components/style.css forces the Tailwind steps with
     !important and its selectors also match the responsive variants, so utility text
     classes are unreliable here — these are set directly instead. */
  .sc-cc, .sc-cc * { box-sizing: border-box; }
  .sc-cc {
    position: fixed; left: 0; right: 0; bottom: 0; z-index: 100000;
    padding: clamp(12px, 2vw, 24px);
    display: none;
  }
  .sc-cc[data-open="1"] { display: block; }
  .sc-cc-card {
    width: 100%; max-width: 1180px; margin-inline: auto;
    background: #fff; border: 1px solid #e3e9e5; border-radius: 20px;
    box-shadow: 0 18px 50px rgba(11, 31, 22, .18);
    padding: clamp(16px, 2.2vw, 30px);
  }
  .sc-cc-t {
    font-size: 1.075rem !important; font-weight: 800; color: #0B1F16;
    line-height: 1.35 !important; margin: 0 0 8px;
  }
  .sc-cc-p {
    font-size: 0.975rem !important; color: #3A4A41; line-height: 1.8 !important; margin: 0;
    overflow-wrap: break-word;
  }
  .sc-cc-p a { color: #1F6B43; font-weight: 700; text-decoration: underline; }
  .sc-cc-row { display: flex; flex-direction: column; gap: clamp(14px, 1.6vw, 26px); }
  @media (min-width: 900px) { .sc-cc-row { flex-direction: row; align-items: center; } }
  .sc-cc-actions { display: grid; gap: 10px; flex: none; }
  @media (min-width: 560px) { .sc-cc-actions { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
  @media (min-width: 900px) { .sc-cc-actions { grid-template-columns: 1fr; min-width: 210px; } }
  .sc-btn {
    font-size: 0.975rem !important; font-weight: 800; line-height: 1.2 !important;
    padding: 13px 20px; border-radius: 12px; border: 1px solid transparent;
    cursor: pointer; text-align: center; transition: all .2s ease; white-space: nowrap;
  }
  .sc-btn--accept { background: #1F6B43; color: #fff; }
  .sc-btn--accept:hover { background: #14572f; }
  .sc-btn--reject { background: #f3f6f4; color: #0B1F16; border-color: #e3e9e5; }
  .sc-btn--reject:hover { background: #e9efeb; }
  .sc-btn--settings { background: #fff; color: #1F6B43; border-color: #1F6B43; }
  .sc-btn--settings:hover { background: #f3f8f5; }

  /* preference centre */
  .sc-cc-panel { display: none; margin-top: clamp(14px, 1.8vw, 24px); border-top: 1px solid #eef2f0; padding-top: clamp(14px, 1.8vw, 22px); }
  .sc-cc[data-panel="1"] .sc-cc-panel { display: block; }
  .sc-cat { display: flex; gap: 14px; align-items: flex-start; padding: 12px 0; border-bottom: 1px solid #f2f5f3; }
  .sc-cat:last-of-type { border-bottom: 0; }
  .sc-cat-body { min-width: 0; }
  .sc-cat-t { font-size: 0.975rem !important; font-weight: 800; color: #0B1F16; line-height: 1.35 !important; }
  .sc-cat-p { font-size: 0.875rem !important; color: #5C6E65; line-height: 1.7 !important; margin: 3px 0 0; }
  .sc-sw { flex: none; margin-top: 2px; }
  .sc-sw input { width: 20px; height: 20px; accent-color: #1F6B43; cursor: pointer; }
  .sc-sw input:disabled { cursor: not-allowed; opacity: .55; }
  .sc-cc-save { margin-top: 14px; display: flex; justify-content: flex-end; }

  /* the re-open handle: PDPA wants withdrawing consent to be as easy as giving it */
  .sc-cc-reopen {
    position: fixed; left: 16px; bottom: 16px; z-index: 99998;
    display: none; align-items: center; gap: 8px;
    background: #fff; border: 1px solid #e3e9e5; border-radius: 999px;
    padding: 9px 15px; cursor: pointer;
    box-shadow: 0 6px 18px rgba(11, 31, 22, .12);
    font-size: 0.875rem !important; font-weight: 700; color: #1F6B43; line-height: 1.2 !important;
  }
  .sc-cc-reopen[data-show="1"] { display: inline-flex; }
  .sc-cc-reopen:hover { background: #f3f8f5; }
</style>

<!-- ===================== BANNER ===================== -->
<div class="sc-cc" id="scCookieConsent" role="dialog" aria-modal="false"
     aria-labelledby="scCcTitle" aria-describedby="scCcDesc">
  <div class="sc-cc-card">
    <div class="sc-cc-row">
      <div style="min-width:0">
        <p class="sc-cc-t" id="scCcTitle">
          <span class="lang-th">เว็บไซต์นี้ใช้คุกกี้</span>
          <span class="lang-en">This website uses cookies</span>
        </p>
        <p class="sc-cc-p" id="scCcDesc">
          <span class="lang-th">เว็บไซต์นี้ใช้คุกกี้เพื่อให้เว็บไซต์ทำงานได้อย่างถูกต้อง วิเคราะห์การใช้งาน และพัฒนาประสบการณ์การใช้งานของท่าน โปรดศึกษารายละเอียดเพิ่มเติมใน<a href="<?php echo home_url('/privacy-policy/'); ?>">นโยบายความเป็นส่วนตัว</a>และ<a href="<?php echo home_url('/privacy-policy/#cookies'); ?>">นโยบายคุกกี้</a></span>
          <span class="lang-en">This website uses cookies to make the site work correctly, to analyse usage and to improve your experience. Please see our <a href="<?php echo home_url('/privacy-policy/'); ?>">Privacy Policy</a> and <a href="<?php echo home_url('/privacy-policy/#cookies'); ?>">Cookie Policy</a> for details.</span>
        </p>
      </div>

      <div class="sc-cc-actions">
        <button type="button" class="sc-btn sc-btn--accept" data-cc="accept-all">
          <span class="lang-th">ยอมรับทั้งหมด</span><span class="lang-en">Accept all</span>
        </button>
        <button type="button" class="sc-btn sc-btn--reject" data-cc="reject-all">
          <span class="lang-th">ใช้เฉพาะที่จำเป็น</span><span class="lang-en">Necessary only</span>
        </button>
        <button type="button" class="sc-btn sc-btn--settings" data-cc="toggle-panel" aria-expanded="false">
          <span class="lang-th">ตั้งค่าคุกกี้</span><span class="lang-en">Cookie settings</span>
        </button>
      </div>
    </div>

    <!-- ===================== PREFERENCE CENTRE ===================== -->
    <div class="sc-cc-panel">
      <div class="sc-cat">
        <label class="sc-sw"><input type="checkbox" checked disabled aria-label="Necessary cookies (always on)"></label>
        <div class="sc-cat-body">
          <div class="sc-cat-t">
            <span class="lang-th">คุกกี้ที่จำเป็น (เปิดใช้งานตลอด)</span>
            <span class="lang-en">Necessary (always on)</span>
          </div>
          <p class="sc-cat-p">
            <span class="lang-th">จำเป็นต่อการทำงานพื้นฐานของเว็บไซต์ เช่น การจดจำภาษาที่เลือก และการบันทึกการตั้งค่าคุกกี้ของท่าน ไม่สามารถปิดได้ และไม่ต้องขอความยินยอมตามกฎหมาย</span>
            <span class="lang-en">Required for basic site functions such as remembering your language choice and storing your cookie preferences. These cannot be switched off and do not require consent.</span>
          </p>
        </div>
      </div>

      <div class="sc-cat">
        <label class="sc-sw"><input type="checkbox" id="scCatAnalytics" aria-label="Analytics cookies"></label>
        <div class="sc-cat-body">
          <div class="sc-cat-t">
            <span class="lang-th">คุกกี้เพื่อการวิเคราะห์</span>
            <span class="lang-en">Analytics</span>
          </div>
          <p class="sc-cat-p">
            <span class="lang-th">ช่วยให้เราเข้าใจว่าผู้ใช้งานเข้าชมหน้าใดและใช้งานอย่างไร เพื่อนำไปปรับปรุงเว็บไซต์ ข้อมูลถูกใช้ในลักษณะภาพรวม</span>
            <span class="lang-en">Helps us understand which pages are visited and how the site is used, so we can improve it. Data is used in aggregate.</span>
          </p>
        </div>
      </div>

      <div class="sc-cat">
        <label class="sc-sw"><input type="checkbox" id="scCatPreferences" aria-label="Experience cookies"></label>
        <div class="sc-cat-body">
          <div class="sc-cat-t">
            <span class="lang-th">คุกกี้เพื่อพัฒนาประสบการณ์การใช้งาน</span>
            <span class="lang-en">Experience</span>
          </div>
          <p class="sc-cat-p">
            <span class="lang-th">ใช้จดจำการตั้งค่าเพิ่มเติมและเนื้อหาที่เกี่ยวข้องกับท่าน เพื่อให้การใช้งานครั้งถัดไปสะดวกขึ้น</span>
            <span class="lang-en">Remembers additional settings and relevant content so your next visit is smoother.</span>
          </p>
        </div>
      </div>

      <div class="sc-cc-save">
        <button type="button" class="sc-btn sc-btn--accept" data-cc="save">
          <span class="lang-th">บันทึกการตั้งค่า</span><span class="lang-en">Save preferences</span>
        </button>
      </div>
    </div>
  </div>
</div>

<button type="button" class="sc-cc-reopen" id="scCookieReopen">
  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
    <circle cx="12" cy="12" r="9"/><circle cx="9" cy="10" r="1.1" fill="currentColor" stroke="none"/>
    <circle cx="14.5" cy="9" r="1.1" fill="currentColor" stroke="none"/><circle cx="12" cy="15" r="1.1" fill="currentColor" stroke="none"/>
  </svg>
  <span class="lang-th">ตั้งค่าคุกกี้</span><span class="lang-en">Cookie settings</span>
</button>

<script>
(function () {
  'use strict';

  var NAME    = 'synergy_cookie_consent';
  var VERSION = 1;                 // bump this when the policy changes to re-ask
  var DAYS    = 365;               // PDPA has no fixed term; a year is the common practice

  var box    = document.getElementById('scCookieConsent');
  var reopen = document.getElementById('scCookieReopen');
  if (!box) return;

  var elAnalytics   = document.getElementById('scCatAnalytics');
  var elPreferences = document.getElementById('scCatPreferences');

  /* The record is kept in a cookie so PHP (and later WordPress) can read it server-side.
     Some browsers refuse cookies outright, and a file:// preview cannot set them at all —
     without a fallback the banner would reappear on every page load and the visitor could
     never make it stop. localStorage mirrors the record in that case. The record itself is
     strictly necessary, so storing it needs no consent either way. */
  function readCookie() {
    var m = document.cookie.match(new RegExp('(?:^|; )' + NAME + '=([^;]*)'));
    if (m) {
      try { return JSON.parse(decodeURIComponent(m[1])); } catch (e) { /* fall through */ }
    }
    try {
      var ls = window.localStorage.getItem(NAME);
      if (ls) return JSON.parse(ls);
    } catch (e) { /* storage disabled too */ }
    return null;
  }

  function writeCookie(state) {
    var payload = JSON.stringify(state);
    var exp = new Date(Date.now() + DAYS * 864e5).toUTCString();
    // SameSite=Lax keeps it first-party only; Secure is added when served over https
    var secure = location.protocol === 'https:' ? '; Secure' : '';
    try {
      document.cookie = NAME + '=' + encodeURIComponent(payload) +
        '; Expires=' + exp + '; Path=/; SameSite=Lax' + secure;
    } catch (e) { /* handled by the verify below */ }

    // verify the write actually landed; mirror to localStorage when it did not
    var stored = document.cookie.indexOf(NAME + '=') !== -1;
    try {
      if (!stored) { window.localStorage.setItem(NAME, payload); }
      else { window.localStorage.removeItem(NAME); }
    } catch (e) { /* nothing else we can do; the banner stays dismissed for this session */ }
  }

  /* Activate the scripts that were parked for a category that has just been granted.
     A <script type="text/plain"> is never executed by the browser, so cloning it with a
     real type is what turns it on — no reload needed. */
  function releaseScripts(state) {
    document.querySelectorAll('script[type="text/plain"][data-consent]').forEach(function (node) {
      var cat = node.getAttribute('data-consent');
      if (!state[cat]) return;
      var s = document.createElement('script');
      for (var i = 0; i < node.attributes.length; i++) {
        var a = node.attributes[i];
        if (a.name === 'type' || a.name === 'data-consent' || a.name === 'data-src') continue;
        s.setAttribute(a.name, a.value);
      }
      if (node.getAttribute('data-src')) { s.src = node.getAttribute('data-src'); }
      else { s.textContent = node.textContent; }
      node.parentNode.replaceChild(s, node);
    });
  }

  function apply(state) {
    writeCookie(state);
    box.setAttribute('data-open', '0');
    box.removeAttribute('data-panel');
    reopen.setAttribute('data-show', '1');
    releaseScripts(state);
    // Anything added later can listen instead of polling the cookie.
    document.dispatchEvent(new CustomEvent('synergy:consent', { detail: state }));
  }

  function decide(analytics, preferences) {
    return {
      v: VERSION,
      ts: new Date().toISOString(),
      analytics: !!analytics,
      preferences: !!preferences
    };
  }

  function openBanner(showPanel) {
    box.setAttribute('data-open', '1');
    if (showPanel) box.setAttribute('data-panel', '1');
    reopen.setAttribute('data-show', '0');
  }

  box.addEventListener('click', function (e) {
    var btn = e.target.closest('[data-cc]');
    if (!btn) return;
    var act = btn.getAttribute('data-cc');
    if (act === 'accept-all') return apply(decide(true, true));
    if (act === 'reject-all') return apply(decide(false, false));
    if (act === 'save')       return apply(decide(elAnalytics.checked, elPreferences.checked));
    if (act === 'toggle-panel') {
      var open = box.getAttribute('data-panel') === '1';
      if (open) { box.removeAttribute('data-panel'); } else { box.setAttribute('data-panel', '1'); }
      btn.setAttribute('aria-expanded', String(!open));
    }
  });

  reopen.addEventListener('click', function () {
    var saved = readCookie();
    if (saved) {
      elAnalytics.checked   = !!saved.analytics;
      elPreferences.checked = !!saved.preferences;
    }
    openBanner(true);
  });

  // ── boot ──────────────────────────────────────────────────────────────────────
  var saved = readCookie();
  if (!saved || saved.v !== VERSION) {
    // No valid record: ask, and grant nothing in the meantime.
    openBanner(false);
  } else {
    reopen.setAttribute('data-show', '1');
    releaseScripts(saved);
    document.dispatchEvent(new CustomEvent('synergy:consent', { detail: saved }));
  }

  // Small read-only helper for anything that needs to check before acting.
  window.synergyConsent = {
    get: readCookie,
    has: function (cat) { var s = readCookie(); return !!(s && s[cat]); },
    open: function () { reopen.click(); }
  };
})();
</script>
