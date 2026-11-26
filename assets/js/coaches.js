/* coaches.js — مربیان بلدرلند page: fetch coaches from the WP REST API and render the cards. */
(function () {
  'use strict';

  // same domain as WordPress → leave ''. If elsewhere, set e.g. 'https://boulderland.ir'.
  var BLCC_WP = '';
  var API = BLCC_WP + '/wp-json/blc-coaches/v1';

  var ICONS = {
    certs: '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="9" r="6"/><path d="M8.5 13.5 7 22l5-3 5 3-1.5-8.5"/></svg>',
    education: '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 9l9-4 9 4-9 4z"/><path d="M7 11v4.5c0 1.2 2.5 2.5 5 2.5s5-1.3 5-2.5V11"/><path d="M21 9v4"/></svg>',
    schedule: '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg>'
  };

  function esc(s) {
    return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c];
    });
  }
  // multi-line text may contain <br> (from ACF) AND a trailing newline — collapse any run
  // of breaks/newlines into a SINGLE <br> so lines aren't double-spaced.
  function multiline(s) {
    return esc(s)
      .replace(/&lt;br\s*\/?&gt;/gi, '\n')
      .replace(/\r/g, '')
      .replace(/\n+/g, '<br>')
      .replace(/^<br>|<br>$/g, '');
  }
  // one info row; returns '' when the value is empty so nothing shows on the card
  function row(key, label, value, allowBr) {
    var plain = String(value == null ? '' : value).replace(/<[^>]*>/g, '').trim();
    if (!plain) return '';
    var val = allowBr ? multiline(value) : esc(value);
    return '<div class="blcc-row">'
      + '<span class="blcc-ico">' + (ICONS[key] || '') + '</span>'
      + '<div class="blcc-rt"><span class="k">' + esc(label) + '</span><span class="v">' + val + '</span></div>'
      + '</div>';
  }

  function cardHTML(c) {
    var photo = c.photo
      ? '<img src="' + esc(c.photo) + '" alt="' + esc(c.name) + '" loading="lazy">'
      : '<div class="blcc-noimg"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1"/></svg></div>';
    var spec = String(c.specialty || '').trim()
      ? '<span class="blcc-spec">' + esc(c.specialty) + '</span>' : '';
    var rows = row('certs', 'گواهینامه‌ها', c.certs, true)
      + row('education', 'تحصیلات', c.education)
      + row('schedule', 'زمان حضور', c.schedule, true);
    var rowsWrap = rows ? '<div class="blcc-rows">' + rows + '</div>' : '';
    return '<article class="blcc-card">'
      + '<div class="blcc-photo">' + photo + '</div>'
      + '<div class="blcc-info">'
        + '<div class="blcc-head"><h3 class="blcc-name">' + esc(c.name) + '</h3>' + spec + '</div>'
        + rowsWrap
      + '</div>'
      + '</article>';
  }

  var grid = document.getElementById('coachGrid');
  if (!grid) return;
  fetch(API + '/coaches', { credentials: 'same-origin' })
    .then(function (r) { return r.json(); })
    .then(function (list) {
      if (!Array.isArray(list) || !list.length) { grid.innerHTML = '<p class="co-loading">هنوز مربی‌ای ثبت نشده است.</p>'; return; }
      grid.innerHTML = list.map(cardHTML).join('');
    })
    .catch(function () { grid.innerHTML = '<p class="co-loading">دریافت مربیان ممکن نشد.</p>'; });
})();
