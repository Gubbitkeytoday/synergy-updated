/* ==========================================================================
   Syntech — interactive behaviour

   No dependencies, no build step. Every feature is additive: with JS blocked
   the page still renders fully, and every lookup below is null-guarded so one
   missing node can never take the rest of the script down with it.
   ========================================================================== */
(() => {
  'use strict';

  const $ = (sel, ctx = document) => ctx.querySelector(sel);
  const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
  const prefersInstant = () => reduceMotion.matches;

  /* ------------------------------------------------------------------
     1. Reveal on scroll (staggered via --reveal-delay in the markup)
     ------------------------------------------------------------------ */
  (() => {
    const revealables = $$('[data-reveal]');
    if (!revealables.length) return;

    const revealAll = () =>
      revealables.forEach((el) => el.classList.add('is-revealed'));

    if (prefersInstant() || !('IntersectionObserver' in window)) {
      revealAll();
      return;
    }

    const observer = new IntersectionObserver(
      (entries, obs) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          entry.target.classList.add('is-revealed');
          obs.unobserve(entry.target);
        });
      },
      { threshold: 0.12, rootMargin: '0px 0px -8% 0px' }
    );

    revealables.forEach((el) => observer.observe(el));

    // Safety net: if the observer never fires (background tab, odd embedding,
    // zero-height compositing viewport) show everything rather than leave a
    // blank page behind.
    window.setTimeout(revealAll, 2500);
  })();

  /* ------------------------------------------------------------------
     2. Back to top — shown past a screenful of scrolling
     ------------------------------------------------------------------ */
  (() => {
    const toTop = $('#toTop');
    if (!toTop) return;

    let queued = false;

    const sync = () => {
      queued = false;
      toTop.classList.toggle('is-shown', window.scrollY > window.innerHeight * 0.9);
    };

    // Coalesce scroll events into one write per frame — the listener itself
    // stays passive so it never blocks scrolling.
    const onScroll = () => {
      if (queued) return;
      queued = true;
      window.requestAnimationFrame(sync);
    };

    toTop.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: prefersInstant() ? 'auto' : 'smooth' });
    });

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
    sync();
  })();

  /* ------------------------------------------------------------------
     3. Contact modal — focus trap, Escape, focus restore, scroll lock
     ------------------------------------------------------------------ */
  const modal = $('#contactModal');

  const FOCUSABLE = [
    'a[href]',
    'button:not([disabled])',
    'input:not([disabled])',
    'select:not([disabled])',
    'textarea:not([disabled])',
    '[tabindex]:not([tabindex="-1"])'
  ].join(', ');

  let lastFocused = null;
  let closeTimer = null;

  function openModal() {
    if (!modal) return;

    lastFocused = document.activeElement;
    window.clearTimeout(closeTimer);

    modal.hidden = false;
    // Flush layout so the opening transition still runs, without depending on
    // requestAnimationFrame (throttled to zero in a hidden tab).
    void modal.offsetWidth;
    modal.classList.add('is-open');
    document.body.classList.add('is-locked');

    // Focus only once `is-open` has lifted the hidden state — otherwise the
    // element is not focusable and focus silently stays on the trigger.
    const first = $('#fullName', modal);
    if (first) first.focus({ preventScroll: true });
  }

  function closeModal() {
    if (!modal || modal.hidden) return;

    modal.classList.remove('is-open');
    document.body.classList.remove('is-locked');

    // Time-based rather than `transitionend`, which never fires when the
    // transition is skipped (reduced motion, hidden tab).
    window.clearTimeout(closeTimer);
    closeTimer = window.setTimeout(
      () => { modal.hidden = true; },
      prefersInstant() ? 0 : 300
    );

    if (lastFocused && document.contains(lastFocused)) {
      lastFocused.focus({ preventScroll: true });
    }
  }

  $$('[data-modal-open]').forEach((btn) =>
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      openModal();
    })
  );

  if (modal) {
    $$('[data-modal-close]', modal).forEach((btn) =>
      btn.addEventListener('click', closeModal)
    );

    // Click the backdrop (never the panel) to dismiss.
    modal.addEventListener('click', (e) => {
      if (e.target === modal) closeModal();
    });

    modal.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        e.preventDefault();
        closeModal();
        return;
      }
      if (e.key !== 'Tab') return;

      // Recomputed per keypress: which controls are focusable changes as the
      // form's own state does (disabled submit button, hidden honeypot).
      const items = $$(FOCUSABLE, modal).filter(
        (el) => el.offsetWidth > 0 || el.offsetHeight > 0
      );
      if (!items.length) return;

      const first = items[0];
      const last = items[items.length - 1];

      if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
      } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    });
  }

  /* ------------------------------------------------------------------
     4. Contact form — validation + submit
     ------------------------------------------------------------------ */
  (() => {
    const form = $('#contactForm');
    const status = $('#formStatus');
    const statusText = $('#formStatusText');
    const statusIcon = $('#formStatusIcon use');
    const trap = $('#company_url');
    if (!form) return;

    // Deliberately permissive: real addresses fail strict patterns far more
    // often than typos slip through this one. The server is the real gate.
    const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    const required = [
      { input: $('#fullName'), test: (v) => v.trim().length >= 2 },
      { input: $('#email'), test: (v) => EMAIL_RE.test(v.trim()) }
    ].filter((rule) => rule.input);

    function setFieldError(input, hasError) {
      const field = input.closest('.field');
      if (field) field.classList.toggle('has-error', hasError);
      input.setAttribute('aria-invalid', String(hasError));
    }

    function validate() {
      return required.reduce((problems, { input, test }) => {
        const bad = !test(input.value);
        setFieldError(input, bad);
        if (bad) problems.push(input);
        return problems;
      }, []);
    }

    // Clear a field's error as soon as the user starts fixing it — but never
    // flag a field the user has not finished typing into yet.
    required.forEach(({ input, test }) => {
      input.addEventListener('input', () => {
        const field = input.closest('.field');
        if (field && field.classList.contains('has-error')) {
          setFieldError(input, !test(input.value));
        }
      });
      input.addEventListener('blur', () => {
        if (input.value.trim() !== '') setFieldError(input, !test(input.value));
      });
    });

    function showStatus(kind, text) {
      if (!status || !statusText) return;
      status.className = `form-status is-shown form-status--${kind}`;
      statusText.textContent = text;
      if (statusIcon) {
        statusIcon.setAttribute(
          'href',
          kind === 'ok' ? '#ic-check-circle' : '#ic-alert'
        );
      }
    }

    form.addEventListener('submit', (e) => {
      e.preventDefault();

      // Honeypot tripped → drop it silently, submit nothing.
      if (trap && trap.value !== '') return;

      const problems = validate();
      if (problems.length) {
        showStatus('err', 'กรุณาตรวจสอบข้อมูลที่ทำเครื่องหมายไว้อีกครั้ง');
        problems[0].focus();
        return;
      }

      const submit = form.querySelector('button[type="submit"]');
      const label = submit ? submit.querySelector('span') : null;
      const originalLabel = label ? label.textContent : '';

      if (submit) submit.disabled = true;
      if (label) label.textContent = 'กำลังส่ง...';

      // No backend is wired up yet. Replace this block with the real call:
      //   const res = await fetch('/api/contact', {
      //     method: 'POST', body: new FormData(form)
      //   });
      // and branch on `res.ok` for the ok/err status below.
      window.setTimeout(() => {
        if (submit) submit.disabled = false;
        if (label) label.textContent = originalLabel;
        form.reset();
        required.forEach(({ input }) => setFieldError(input, false));
        showStatus(
          'ok',
          'ขอบคุณครับ เราได้รับข้อมูลของคุณแล้ว ทีมวิศวกรจะติดต่อกลับภายใน 1 วันทำการ'
        );
        if (status) status.scrollIntoView({ block: 'nearest' });
      }, 900);
    });
  })();
})();
