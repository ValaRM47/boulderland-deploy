/* coaches.js — مربیان بلدرلند page: fetch coaches from the WP REST API and render the cards. */
(function () {
  'use strict';

  // same domain as WordPress → leave ''. If elsewhere, set e.g. 'https://boulderland.ir'.
  var BLCC_WP = '';
  var API = BLCC_WP + '/wp-json/blc-coaches/v1';

  function esc(s) {
    return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c];
    });
  }
  // schedule may contain <br> (from ACF) or newlines — escape text, keep line breaks
  function sched(s) {
    return esc(s).replace(/&lt;br\s*\/?&gt;/gi, '<br>').replace(/\r?\n/g, '<br>');
  }
  function row(k, v, html) {
    var plain = String(v == null ? '' : v).replace(/<[^>]*>/g, '').trim();
    if (!plain) return '';
    return '<div class="blcc-row"><span class="k">' + esc(k) + '</span><span class="v">' + (html ? v : esc(v)) + '</span></div>';
  }
  function cardHTML(c) {
    var photo = c.photo
      ? '<img src="' + esc(c.photo) + '" alt="' + esc(c.name) + '" loading="lazy">'
      : '<div class="blcc-noimg"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1"/></svg></div>';
    var rows = row('تخصص', c.specialty) + row('تحصیلات', c.education) + row('زمان‌های حضور', sched(c.schedule), true);
    return '<article class="blcc-card">'
      + '<div class="blcc-photo">' + photo + '</div>'
      + '<div class="blcc-info"><h3 class="blcc-name">' + esc(c.name) + '</h3><div class="blcc-rows">' + rows + '</div></div>'
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
