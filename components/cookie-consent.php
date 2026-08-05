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
  /* ==========================================================================
     THE CARD MUST NEVER OUTGROW THE SCREEN

     Measured on a 375x812 phone with the settings panel open: the card came to 971px
     tall inside an 812px viewport. Because .sc-cc is position:fixed to the BOTTOM, the
     overflow went off the TOP — 171px cut away, taking the heading and the whole
     "คุกกี้ที่จำเป็น" row with it — and since the card itself did not scroll there was
     no way to reach them. A visitor on a phone who tapped "ตั้งค่าคุกกี้" could not read
     or reach the first thing the panel wanted to tell them.

     dvh, not vh: on mobile Safari/Chrome vh is the tallest viewport (toolbars hidden),
     so 100vh is taller than what is actually on screen and would leave the same clipping
     when the toolbars are up. The vh line is the fallback for browsers without dvh.
     ========================================================================== */
  .sc-cc-card {
    width: 100%; max-width: 1180px; margin-inline: auto;
    background: #fff; border: 1px solid #e3e9e5; border-radius: 20px;
    box-shadow: 0 18px 50px rgba(11, 31, 22, .18);
    padding: clamp(16px, 2.2vw, 30px);
    max-height: calc(100vh - clamp(24px, 4vw, 48px));
    max-height: calc(100dvh - clamp(24px, 4vw, 48px));
    overflow-y: auto;
    overscroll-behavior: contain;   /* scrolling the panel must not scroll the page behind */
    -webkit-overflow-scrolling: touch;
  }
  .sc-cc-t {
    font-size: 1.075rem !important; font-weight: 800; color: #0B1F16;
    line-height: 1.35 !important; margin: 0 0 8px;
  }
  .sc-cc-p {
    font-size: 0.975rem !important; color: #3A4A41; line-height: 1.8 !important; margin: 0;
    overflow-wrap: break-word; word-break: normal; text-wrap: pretty;
  }
  .sc-cc-p a { color: #1F6B43; font-weight: 700; text-decoration: underline; }

  /* ==========================================================================
     THE COOKIE MARK  (why an inline SVG and not an illustration)

     The banner opened as an unbroken block of Thai text, so nothing identified it
     until you had read a line of it — even though the RE-OPEN pill in the corner
     already had a cookie icon. A single recognisable mark is what makes the panel
     legible before it is read.

     Inline SVG rather than a PNG/illustration on purpose:
       · no extra HTTP request on a banner that is on the critical path of every
         first page view, and no layout shift while it loads
       · currentColor, so it inherits the brand green and needs no dark/light variant
       · decorative, so aria-hidden and NO alt text — a raster image would either
         need alt text repeating the heading or an empty alt anyway
       · a bigger illustration would only push the actual choice further down; the
         mark earns its space at 44px, a hero graphic would not.
     ========================================================================== */
  .sc-cc-mark {
    flex: none; width: 44px; height: 44px; border-radius: 14px;
    background: #eef7f2; border: 1px solid #d2ebd9; color: #1F6B43;
    display: flex; align-items: center; justify-content: center;
  }
  .sc-cc-mark svg { width: 28px; height: 28px; }
  .sc-cc-head { display: flex; gap: 14px; align-items: flex-start; }

  /* "you can change this any time" — removes the sense that this is a one-shot,
     irreversible decision, which is what makes people click the biggest button
     just to get rid of the thing. */
  .sc-cc-note {
    display: flex; align-items: center; gap: 6px; margin: 10px 0 0;
    font-size: 0.875rem !important; line-height: 1.5 !important;
    color: #5C6E65; font-weight: 500;
  }
  .sc-cc-note svg { flex: none; }

  .sc-cc-row { display: flex; flex-direction: column; gap: clamp(14px, 1.6vw, 26px); }
  @media (min-width: 900px) { .sc-cc-row { flex-direction: row; align-items: center; } }
  .sc-cc-actions { display: grid; gap: 10px; flex: none; }
  @media (min-width: 560px) { .sc-cc-actions { grid-template-columns: 1fr 1fr; } }
  @media (min-width: 900px) { .sc-cc-actions { grid-template-columns: 1fr; min-width: 232px; } }
  .sc-btn {
    font-size: 0.975rem !important; font-weight: 800; line-height: 1.25 !important;
    padding: 13px 18px; border-radius: 12px; border: 1px solid transparent;
    cursor: pointer; text-align: center; transition: all .2s ease;
    /* was white-space: nowrap. Between 560px and 899px the actions grid was three
       columns of ~170px while "ใช้เฉพาะที่จำเป็น" needs ~190px at this size, so the
       label pushed straight out of its own button. It wraps now, and min-height keeps
       a wrapped button the same height as its neighbour. */
    min-height: 48px;
  }
  /* ==========================================================================
     BUTTON HIERARCHY  (this was the real problem, not the missing icon)

     Before: accept = solid green, reject = FILLED GREY on a grey border, settings =
     white with a full green outline. So the ranking a visitor actually read was
     accept > settings > reject, and grey-on-grey is the exact styling this site uses
     for a disabled control — the one button that declines was the one that looked
     switched off. Whether or not it was intended, that is a consent dark pattern:
     PDPA s.19 wants consent freely given, and both the Thai PDPC guidance and the
     EDPB's cookie-banner report treat "accept is prominent, reject is faint" as
     consent that was not.

     After: accept and reject are a MATCHED PAIR — same size, same weight, same
     border, one filled and one outlined — and "ตั้งค่าคุกกี้" drops to a text button,
     because it is the path for the small minority who want the detail, not a rival
     to the two real answers.
     ========================================================================== */
  .sc-btn--accept { background: #1F6B43; color: #fff; border-color: #1F6B43; }
  .sc-btn--accept:hover { background: #14572f; border-color: #14572f; }
  .sc-btn--reject { background: #fff; color: #1F6B43; border-color: #1F6B43; }
  .sc-btn--reject:hover { background: #f3f8f5; }
  .sc-btn--settings {
    background: transparent; color: #3A4A41; border-color: transparent;
    font-weight: 700; text-decoration: underline; text-underline-offset: 3px;
    min-height: 40px; padding: 8px 12px;
  }
  .sc-btn--settings:hover { color: #1F6B43; background: #f3f8f5; }

  /* Keyboard users got nothing but the UA default outline, which on a green button is
     nearly invisible. This is the only way to operate the banner without a mouse. */
  .sc-cc :focus-visible, .sc-cc-reopen:focus-visible {
    outline: 3px solid #1F6B43; outline-offset: 2px; border-radius: 12px;
  }

  /* preference centre */
  .sc-cc-panel { display: none; margin-top: clamp(14px, 1.8vw, 24px); border-top: 1px solid #eef2f0; padding-top: clamp(14px, 1.8vw, 22px); }
  .sc-cc[data-panel="1"] .sc-cc-panel { display: block; }
  /* ==========================================================================
     CATEGORY ROWS

     Before: a 20px bare checkbox in its own <label> that wrapped nothing but the
     input, so the only place you could click to grant or refuse a whole category of
     processing was a 20x20px square — under the 24px WCAG 2.2 target minimum and
     well under the 44px everyone actually recommends on touch. The title next to it
     was not clickable at all.

     Now the whole row is the <label>: click anywhere on the text and it toggles, and
     the checkbox is drawn as a switch so its state reads at a glance instead of
     looking like part of a form the visitor still has to submit.
     ========================================================================== */
  .sc-cat {
    display: flex; gap: 12px; align-items: flex-start;
    padding: 12px 10px; margin: 0 -10px; border-bottom: 1px solid #f2f5f3;
    border-radius: 12px; cursor: pointer;
  }
  .sc-cat:last-of-type { border-bottom: 0; }
  .sc-cat:hover { background: #f7faf8; }
  .sc-cat--locked { cursor: default; }
  .sc-cat--locked:hover { background: transparent; }
  .sc-cat-ico { flex: none; width: 30px; height: 30px; color: #1F6B43; display: flex; align-items: center; justify-content: center; margin-top: 1px; }
  /* These three are <span>, not <div>/<p>: a <label> may only contain phrasing content,
     and the row is now the label. display:block gives back the stacking they had. */
  .sc-cat-body { display: block; min-width: 0; flex: 1 1 auto; }
  .sc-cat-t { display: block; font-size: 0.975rem !important; font-weight: 800; color: #0B1F16; line-height: 1.35 !important; }
  .sc-cat-p { display: block; font-size: 0.875rem !important; color: #5C6E65; line-height: 1.7 !important; margin: 3px 0 0; word-break: normal; text-wrap: pretty; }

  /* Switch. The checkbox stays a real checkbox (keyboard, forms, screen readers all
     keep working) and is only repainted. */
  .sc-sw { flex: none; margin-top: 2px; }
  .sc-sw input {
    appearance: none; -webkit-appearance: none;
    width: 44px; height: 26px; border-radius: 999px;
    background: #d8e0db; border: 1px solid #cbd5d0; cursor: pointer;
    position: relative; transition: background .2s ease, border-color .2s ease;
  }
  .sc-sw input::after {
    content: ''; position: absolute; top: 2px; left: 2px;
    width: 20px; height: 20px; border-radius: 999px; background: #fff;
    box-shadow: 0 1px 3px rgba(11, 31, 22, .25);
    transition: transform .2s ease;
  }
  .sc-sw input:checked { background: #1F6B43; border-color: #1F6B43; }
  .sc-sw input:checked::after { transform: translateX(18px); }
  .sc-sw input:disabled { cursor: not-allowed; opacity: .6; }
  .sc-cc-save { margin-top: 14px; display: flex; justify-content: flex-end; }

  /* ==========================================================================
     THE RE-OPEN HANDLE  (PDPA wants withdrawing consent as easy as giving it)

     Now icon only. The label was doing no work a recognisable cookie does not do
     already, and it made the control a 150px-wide pill parked over the bottom-left of
     every page — on a phone that is a real chunk of the content area.

     DROPPING THE VISIBLE LABEL DOES NOT MEAN DROPPING THE NAME. An icon-only button
     with no text has no accessible name at all: a screen reader would announce it as
     just "button". The label is still in the markup, moved into .sc-sr — clipped to
     1px so it is invisible but still read out, and still inside the lang-th/lang-en
     pair so it switches language. That is why this is NOT an aria-label: an aria-label
     is a single fixed string and could only ever be one of the two languages.

     Sighted users get the same words back on hover/focus via .sc-cc-tip.
     ========================================================================== */
  .sc-cc-reopen {
    position: fixed; left: 16px; bottom: 16px; z-index: 99998;
    display: none; align-items: center; justify-content: center;
    width: 38px; height: 38px; padding: 0;     /* 38px compact size */
    background: #fff; border: 1px solid #e3e9e5; border-radius: 999px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(11, 31, 22, .14);
    transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
  }
  .sc-cc-reopen[data-show="1"] { display: inline-flex; }
  .sc-cc-reopen:hover {
    transform: translateY(-2px); border-color: #d2ebd9;
    box-shadow: 0 8px 18px rgba(11, 31, 22, .2);
  }
  .sc-cc-reopen:active { transform: translateY(0); }
  .sc-cc-reopen svg { width: 20px; height: 20px; display: block; }
  @media (prefers-reduced-motion: reduce) {
    .sc-cc-reopen, .sc-cc-reopen:hover { transition: none; transform: none; }
  }

  /* Visually hidden but still announced — the accessible name of the icon button. */
  .sc-sr {
    position: absolute !important; width: 1px; height: 1px;
    padding: 0; margin: -1px; border: 0; overflow: hidden;
    clip: rect(0 0 0 0); clip-path: inset(50%); white-space: nowrap;
  }

  /* Hover/focus tooltip: gives the words back to sighted mouse and keyboard users
     without keeping a permanent pill on screen. */
  .sc-cc-tip {
    position: absolute; left: calc(100% + 10px); top: 50%; transform: translateY(-50%);
    background: #0B1F16; color: #fff; padding: 7px 11px; border-radius: 9px;
    font-size: 0.875rem !important; font-weight: 700; line-height: 1.2 !important;
    white-space: nowrap; opacity: 0; pointer-events: none;
    transition: opacity .18s ease;
    box-shadow: 0 6px 16px rgba(11, 31, 22, .22);
  }
  .sc-cc-reopen:hover .sc-cc-tip,
  .sc-cc-reopen:focus-visible .sc-cc-tip { opacity: 1; }
</style>

<!-- ===================== BANNER ===================== -->
<div class="sc-cc" id="scCookieConsent" role="dialog" aria-modal="false"
     aria-labelledby="scCcTitle" aria-describedby="scCcDesc">
  <div class="sc-cc-card">
    <div class="sc-cc-row">
      <div style="min-width:0">
        <div class="sc-cc-head">
          <!-- Decorative: the heading right beside it already carries the meaning. -->
          <!-- Same cookie as the corner handle, at 28px. Deliberately identical: the
               visitor meets it here first, then has to recognise it in the corner later
               as the way back in — two different marks for one feature would break that. -->
          <span class="sc-cc-mark" aria-hidden="true">
            <svg width="28" height="28" viewBox="0 0 24 24">
              <defs>
                <mask id="scCookieBiteLg">
                  <rect width="24" height="24" fill="#fff"/>
                  <circle cx="20.6" cy="5.6" r="3.1" fill="#000"/>
                  <circle cx="17.3" cy="3.3" r="1.9" fill="#000"/>
                </mask>
              </defs>
              <g mask="url(#scCookieBiteLg)">
                <circle cx="12" cy="12" r="9.5" fill="#E0A75F"/>
                <circle cx="12" cy="12" r="9.5" fill="none" stroke="#B87B3C" stroke-width="1.2"/>
                <circle cx="8.4" cy="8.8"  r="1.55" fill="#6B3F1D"/>
                <circle cx="15.2" cy="9.7" r="1.15" fill="#6B3F1D"/>
                <circle cx="11.9" cy="13.4" r="1.4" fill="#6B3F1D"/>
                <circle cx="7.9" cy="14.7" r="1.05" fill="#6B3F1D"/>
                <circle cx="15.5" cy="15.2" r="1.25" fill="#6B3F1D"/>
                <circle cx="12.3" cy="6.7" r="0.55" fill="#C6884A"/>
                <circle cx="9.5" cy="17.2" r="0.5" fill="#C6884A"/>
                <circle cx="18.3" cy="12.3" r="0.5" fill="#C6884A"/>
              </g>
            </svg>
          </span>
          <div style="min-width:0">
            <p class="sc-cc-t" id="scCcTitle" tabindex="-1">
              <span class="lang-th">เว็บไซต์นี้ใช้คุกกี้</span>
              <span class="lang-en">This website uses cookies</span>
            </p>
            <p class="sc-cc-p" id="scCcDesc">
              <!-- The two policy links used to sit either side of a bare "และ" with no
                   spacing, so three underlined Thai words ran together as one blob.
                   The &#8203;+space pair keeps "และ" legible as a separate word without
                   introducing a Latin-style gap that Thai does not use. -->
              <span class="lang-th">เว็บไซต์นี้ใช้คุกกี้เพื่อให้เว็บไซต์ทำงานได้อย่างถูกต้อง วิเคราะห์การใช้งาน และพัฒนาประสบการณ์การใช้งานของท่าน อ่านรายละเอียดได้ใน <a href="<?php echo home_url('/privacy-policy/'); ?>">นโยบายความเป็นส่วนตัว</a> และ <a href="<?php echo home_url('/privacy-policy/#cookies'); ?>">นโยบายคุกกี้</a></span>
              <span class="lang-en">This website uses cookies to make the site work correctly, to analyse usage and to improve your experience. Please see our <a href="<?php echo home_url('/privacy-policy/'); ?>">Privacy Policy</a> and <a href="<?php echo home_url('/privacy-policy/#cookies'); ?>">Cookie Policy</a> for details.</span>
            </p>
            <p class="sc-cc-note">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12a9 9 0 1 0 3-6.7M3 4v4h4"/>
              </svg>
              <!-- Names the handle by its APPEARANCE, not by a label it no longer shows.
                   It used to read 'the "ตั้งค่าคุกกี้" button', which stopped being true the
                   moment that button became icon-only. -->
              <span class="lang-th">เปลี่ยนการตั้งค่านี้ได้ทุกเมื่อ จากไอคอนรูปคุกกี้ที่มุมล่างซ้ายของหน้าจอ</span>
              <span class="lang-en">You can change this at any time from the cookie icon in the bottom-left corner.</span>
            </p>
          </div>
        </div>
      </div>

      <div class="sc-cc-actions">
        <button type="button" class="sc-btn sc-btn--accept" data-cc="accept-all">
          <span class="lang-th">ยอมรับทั้งหมด</span><span class="lang-en">Accept all</span>
        </button>
        <button type="button" class="sc-btn sc-btn--reject" data-cc="reject-all">
          <span class="lang-th">ใช้เฉพาะที่จำเป็น</span><span class="lang-en">Necessary only</span>
        </button>
        <button type="button" class="sc-btn sc-btn--settings" data-cc="toggle-panel"
                aria-expanded="false" aria-controls="scCcPanel" style="grid-column:1/-1">
          <span class="lang-th">ตั้งค่าคุกกี้</span><span class="lang-en">Cookie settings</span>
        </button>
      </div>
    </div>

    <!-- ===================== PREFERENCE CENTRE ===================== -->
    <div class="sc-cc-panel" id="scCcPanel">
      <label class="sc-cat sc-cat--locked" for="scCatNecessary">
        <span class="sc-cat-ico" aria-hidden="true">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l8 4v5c0 4.5-3.5 8.5-8 10-4.5-1.5-8-5.5-8-10V7l8-4z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.5 12l1.8 1.8L15 10"/>
          </svg>
        </span>
        <span class="sc-cat-body">
          <span class="sc-cat-t">
            <span class="lang-th">คุกกี้ที่จำเป็น (เปิดใช้งานตลอด)</span>
            <span class="lang-en">Necessary (always on)</span>
          </span>
          <span class="sc-cat-p">
            <span class="lang-th">จำเป็นต่อการทำงานพื้นฐานของเว็บไซต์ เช่น การจดจำภาษาที่เลือก และการบันทึกการตั้งค่าคุกกี้ของท่าน ไม่สามารถปิดได้ และไม่ต้องขอความยินยอมตามกฎหมาย</span>
            <span class="lang-en">Required for basic site functions such as remembering your language choice and storing your cookie preferences. These cannot be switched off and do not require consent.</span>
          </span>
        </span>
        <span class="sc-sw"><input type="checkbox" id="scCatNecessary" checked disabled aria-label="Necessary cookies (always on)"></span>
      </label>

      <label class="sc-cat" for="scCatAnalytics">
        <span class="sc-cat-ico" aria-hidden="true">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 19h16M7 19v-6M12 19V8M17 19v-9"/>
          </svg>
        </span>
        <span class="sc-cat-body">
          <span class="sc-cat-t">
            <span class="lang-th">คุกกี้เพื่อการวิเคราะห์</span>
            <span class="lang-en">Analytics</span>
          </span>
          <span class="sc-cat-p">
            <span class="lang-th">ช่วยให้เราเข้าใจว่าผู้ใช้งานเข้าชมหน้าใดและใช้งานอย่างไร เพื่อนำไปปรับปรุงเว็บไซต์ ข้อมูลถูกใช้ในลักษณะภาพรวม</span>
            <span class="lang-en">Helps us understand which pages are visited and how the site is used, so we can improve it. Data is used in aggregate.</span>
          </span>
        </span>
        <span class="sc-sw"><input type="checkbox" id="scCatAnalytics" aria-label="Analytics cookies"></span>
      </label>

      <label class="sc-cat" for="scCatPreferences">
        <span class="sc-cat-ico" aria-hidden="true">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4l1.4 3.4 3.6.3-2.7 2.4.8 3.5L12 11.8 8.9 13.6l.8-3.5L7 7.7l3.6-.3L12 4zM6 18h12M8 21h8"/>
          </svg>
        </span>
        <span class="sc-cat-body">
          <span class="sc-cat-t">
            <span class="lang-th">คุกกี้เพื่อพัฒนาประสบการณ์การใช้งาน</span>
            <span class="lang-en">Experience</span>
          </span>
          <span class="sc-cat-p">
            <span class="lang-th">ใช้จดจำการตั้งค่าเพิ่มเติมและเนื้อหาที่เกี่ยวข้องกับท่าน เพื่อให้การใช้งานครั้งถัดไปสะดวกขึ้น</span>
            <span class="lang-en">Remembers additional settings and relevant content so your next visit is smoother.</span>
          </span>
        </span>
        <span class="sc-sw"><input type="checkbox" id="scCatPreferences" aria-label="Experience cookies"></span>
      </label>

      <div class="sc-cc-save">
        <button type="button" class="sc-btn sc-btn--accept" data-cc="save">
          <span class="lang-th">บันทึกการตั้งค่า</span><span class="lang-en">Save preferences</span>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ============================================================================
     Icon-only handle. See .sc-cc-reopen in the stylesheet for why the label moved into
     .sc-sr rather than being deleted or turned into an aria-label.

     THE COOKIE ITSELF
     The old mark was a stroked circle with three dots in it, which at 16px read as a
     face, not a biscuit. This one is a filled cookie: warm dough, a bitten edge and
     chocolate chips of unequal size, scattered off-centre.

     · WARM COLOURS, NOT BRAND GREEN. Everywhere else on this component the icons are
       currentColor green, but a green disc is not a cookie — the whole point of this
       button is to be recognised in a corner at a glance, and the biscuit colour is
       what does the recognising. The white pill and green focus ring keep it framed in
       the brand; the cookie is the one deliberate exception.
     · THE BITE is carved with a mask (two overlapping circles) rather than drawn as an
       outline path, so the dough fill, the rim stroke and the chips are all cut by the
       same shape and the notch stays clean at any size.
     · Still inline SVG, still no HTTP request, and geometry-only so it stays crisp on
       a 3x screen where a 30px PNG would not.
     ============================================================================ -->
<button type="button" class="sc-cc-reopen" id="scCookieReopen">
  <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
    <defs>
      <mask id="scCookieBite">
        <rect width="24" height="24" fill="#fff"/>
        <circle cx="20.6" cy="5.6" r="3.1" fill="#000"/>
        <circle cx="17.3" cy="3.3" r="1.9" fill="#000"/>
      </mask>
    </defs>
    <g mask="url(#scCookieBite)">
      <circle cx="12" cy="12" r="9.5" fill="#E0A75F"/>
      <circle cx="12" cy="12" r="9.5" fill="none" stroke="#B87B3C" stroke-width="1.2"/>
      <!-- chips: uneven radii and an off-centre scatter; a symmetrical set reads as a dial -->
      <circle cx="8.4" cy="8.8"  r="1.55" fill="#6B3F1D"/>
      <circle cx="15.2" cy="9.7" r="1.15" fill="#6B3F1D"/>
      <circle cx="11.9" cy="13.4" r="1.4" fill="#6B3F1D"/>
      <circle cx="7.9" cy="14.7" r="1.05" fill="#6B3F1D"/>
      <circle cx="15.5" cy="15.2" r="1.25" fill="#6B3F1D"/>
      <!-- speckles: keep the dough from looking like flat paper -->
      <circle cx="12.3" cy="6.7" r="0.55" fill="#C6884A"/>
      <circle cx="9.5" cy="17.2" r="0.5" fill="#C6884A"/>
      <circle cx="18.3" cy="12.3" r="0.5" fill="#C6884A"/>
    </g>
  </svg>
  <span class="sc-cc-tip" aria-hidden="true">
    <span class="lang-th">ตั้งค่าคุกกี้</span><span class="lang-en">Cookie settings</span>
  </span>
  <span class="sc-sr">
    <span class="lang-th">ตั้งค่าคุกกี้</span><span class="lang-en">Cookie settings</span>
  </span>
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
    var hadFocus = box.contains(document.activeElement);
    writeCookie(state);
    box.setAttribute('data-open', '0');
    box.removeAttribute('data-panel');
    reopen.setAttribute('data-show', '1');
    /* The button that was just pressed is now display:none, which drops focus back to
       the document root and sends the next Tab to the top of the page. Hand focus to the
       control that replaces it — the standard return-focus-to-trigger behaviour. */
    if (hadFocus) { try { reopen.focus({ preventScroll: true }); } catch (e) { reopen.focus(); } }
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

  /* KEYBOARD / SCREEN-READER REACH
     This partial is included from the footer, so the banner was the very LAST thing in
     the body: a keyboard or screen-reader user had to tab through the whole navbar and
     page to reach the dialog that was covering the page. Moving the element to the front
     of <body> makes it the first tab stop instead. It is position:fixed, so nothing about
     how it looks changes.

     This is preferred over stealing focus on page load, which the GOV.UK and W3C cookie
     patterns both avoid — an unannounced focus jump skips the skip-link and disorients
     anyone who was already reading. Focus is only moved when the visitor opens the
     banner themselves, below. */
  if (box.parentNode !== document.body || document.body.firstChild !== box) {
    document.body.insertBefore(box, document.body.firstChild);
  }

  function openBanner(showPanel, moveFocus) {
    box.setAttribute('data-open', '1');
    if (showPanel) box.setAttribute('data-panel', '1');
    reopen.setAttribute('data-show', '0');
    if (!moveFocus) return;
    /* The title takes focus rather than a button, so nothing is pre-selected and a
       stray Enter cannot consent on the visitor's behalf. */
    var t = document.getElementById('scCcTitle');
    if (t) { try { t.focus({ preventScroll: true }); } catch (e) { t.focus(); } }
  }

  /* Escape collapses the detail panel — it must NOT dismiss the banner, because closing
     it without an answer would either lose the choice or bank it as an implied consent,
     and PDPA s.19 has no such thing. */
  box.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape' || box.getAttribute('data-panel') !== '1') return;
    box.removeAttribute('data-panel');
    var toggle = box.querySelector('[data-cc="toggle-panel"]');
    if (toggle) { toggle.setAttribute('aria-expanded', 'false'); toggle.focus(); }
  });

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
    openBanner(true, true);
  });

  // ── boot ──────────────────────────────────────────────────────────────────────
  var saved = readCookie();
  if (!saved || saved.v !== VERSION) {
    // No valid record: ask, and grant nothing in the meantime.
    openBanner(false, false);
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
