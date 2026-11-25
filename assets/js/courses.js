/* courses.js — دوره‌ها page: fetch courses from WP REST, render cards, registration modal. */
/* page.js — full-page «دوره‌های بلدرلند» template behaviour:
   reveal-on-scroll, stat count-up, testimonials carousel, and the status filter
   (which shows/hides the plugin's .blc-course cards by data-status). */
(function () {
	'use strict';

	var faDigits = '۰۱۲۳۴۵۶۷۸۹';
	function faNum(n) { return String(n).replace(/\d/g, function (d) { return faDigits[d]; }); }

	// ---- reveal + stat count-up ----
	var io = new IntersectionObserver(function (es) {
		es.forEach(function (e) {
			if (!e.isIntersecting) return;
			e.target.classList.add('in');
			e.target.querySelectorAll && e.target.querySelectorAll('.count').forEach(countUp);
			io.unobserve(e.target);
		});
	}, { threshold: 0.14, rootMargin: '0px 0px -50px 0px' });
	document.querySelectorAll('.blc-page .reveal').forEach(function (el, i) {
		el.style.transitionDelay = (i % 3 * 0.06) + 's';
		io.observe(el);
	});

	function countUp(el) {
		if (el.dataset.done) return;
		el.dataset.done = '1';
		var target = +el.dataset.target, dur = 1400, t0 = performance.now();
		(function frame(now) {
			var p = Math.min(1, (now - t0) / dur), e = 1 - Math.pow(1 - p, 3);
			el.textContent = faNum(Math.round(target * e));
			if (p < 1) requestAnimationFrame(frame);
		})(t0);
	}

	// ---- status filter (operates on the plugin's .blc-course cards) ----
	var filter = document.getElementById('statusFilter');
	if (filter) {
		filter.addEventListener('change', function (e) {
			var v = e.target.value;
			document.querySelectorAll('.blc-course').forEach(function (card) {
				card.classList.toggle('is-hidden', v !== 'all' && card.getAttribute('data-status') !== v);
			});
		});
	}

	// ---- testimonials carousel (robust across RTL/LTR scroll models) ----
	(function () {
		var g = document.getElementById('tstGrid');
		var prev = document.getElementById('tstPrev'), next = document.getElementById('tstNext');
		if (!g || !prev || !next) return;
		var gap = 24;
		var step = function () { var c = g.querySelector('.tst'); return (c ? c.offsetWidth : 320) + gap; };
		function bounds() {
			var snap = g.style.scrollSnapType; g.style.scrollSnapType = 'none';
			var o = g.scrollLeft; g.scrollLeft = -1e6; var min = g.scrollLeft;
			g.scrollLeft = 1e6; var max = g.scrollLeft; g.scrollLeft = o; g.style.scrollSnapType = snap;
			return { min: min, max: max };
		}
		var B = bounds(), animating = false;
		var dir = B.min < 0 ? -1 : 1;
		var clamp = function (v) { return Math.max(B.min, Math.min(B.max, v)); };
		function animateTo(tgt) {
			tgt = clamp(tgt); var s = g.scrollLeft, d = tgt - s;
			if (Math.abs(d) < 1) { update(); return; }
			var dur = 420, t0 = performance.now(); animating = true; g.style.scrollSnapType = 'none';
			(function f(now) {
				var p = Math.min(1, (now - t0) / dur), e = 1 - Math.pow(1 - p, 3);
				g.scrollLeft = s + d * e;
				if (p < 1) requestAnimationFrame(f);
				else { g.style.scrollSnapType = ''; setTimeout(function () { animating = false; update(); }, 60); }
			})(t0);
		}
		next.onclick = function () { animateTo(g.scrollLeft + dir * step()); };
		prev.onclick = function () { animateTo(g.scrollLeft - dir * step()); };
		function update() {
			if (animating) return;
			var start = dir < 0 ? B.max : B.min, end = dir < 0 ? B.min : B.max;
			prev.disabled = Math.abs(g.scrollLeft - start) <= 2;
			next.disabled = Math.abs(g.scrollLeft - end) <= 2;
		}
		g.addEventListener('scroll', update, { passive: true });
		addEventListener('resize', function () { B = bounds(); update(); });
		update();
	})();
})();

/* ===== Boulderland courses: fetch from the WordPress REST API + registration ===== */
(function () {
  'use strict';
  // If this file is on the SAME domain as WordPress, leave BLC_WP = ''.
  // If WordPress lives elsewhere, set e.g. BLC_WP = 'https://boulderland.ir'.
  var BLC_WP = '';
  var API = BLC_WP + '/wp-json/blc/v1';

  var faDigits = '۰۱۲۳۴۵۶۷۸۹';
  function toFa(n){ return String(n).replace(/\d/g, function(d){ return faDigits[d]; }); }
  function toEn(s){ return String(s||'').replace(/[۰-۹]/g,function(d){return '۰۱۲۳۴۵۶۷۸۹'.indexOf(d);}).replace(/[٠-٩]/g,function(d){return '٠١٢٣٤٥٦٧٨٩'.indexOf(d);}).replace(/\D/g,''); }
  function faPrice(n){ n=String(n).replace(/\D/g,''); if(!n) return ''; return toFa(n.replace(/\B(?=(\d{3})+(?!\d))/g,'٬')); }
  function esc(s){ return String(s==null?'':s).replace(/[&<>"]/g,function(c){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c];}); }

  var STATUS = {
    open:{label:'در حال ثبت‌نام',cls:'open',cta:'ثبت‌نام',enabled:true,acc:'var(--sand)'},
    live:{label:'در حال برگزاری',cls:'live',cta:'در حال برگزاری',enabled:false,acc:'rgba(226,194,161,.55)'},
    soon:{label:'به‌زودی',cls:'soon',cta:'به‌زودی',enabled:false,acc:'rgba(231,173,114,.45)'},
    done:{label:'برگزار شده',cls:'done',cta:'برگزار شده',enabled:false,acc:'rgba(246,237,225,.2)'}
  };
  var chevron = '<svg viewBox="0 0 24 24"><path d="M19 12H5"/><path d="m12 5-7 7 7 7"/></svg>';
  var peopleIc = '<svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/></svg>';

  function spec(k,v){ return '<div class="blc-spec"><span class="k">'+esc(k)+'</span><span class="v">'+esc(v)+'</span></div>'; }
  function hasValue(v){
    return v!=null && !/^(?:-|—|–)$/.test(String(v).replace(/[\u200B-\u200D\u200E\u200F\u202A-\u202E\u2060\uFEFF]/g,'').trim())
      && String(v).replace(/[\u200B-\u200D\u200E\u200F\u202A-\u202E\u2060\uFEFF]/g,'').trim()!=='';
  }
  function specsHTML(c){
    var items=[['تاریخ شروع',c.start],['پیش‌نیاز',c.prereq]];
    if (hasValue(c.instructor)) items.push(['مدرس',c.instructor]);
    items.push(['جنسیت',hasValue(c.gender) ? c.gender : '—']);
    var rows=items.filter(function(it){return hasValue(it[1]) || it[0]==='جنسیت';}).map(function(it){return spec(it[0],it[1]);}).join('');
    return rows ? '<div class="blc-specs">'+rows+'</div>' : '';
  }
  function paymentHTML(raw){
    var value=hasValue(raw) ? raw : '—';
    return '<div class="blc-payment"><span class="k">نحوه پرداخت</span><span class="v">'+esc(value)+'</span></div>';
  }
  function priceHTML(raw){
    raw=(raw==null?'':String(raw)).trim();
    if(raw==='') return '';
    var digits=raw.replace(/\D/g,'');
    var inner=(digits===''||digits==='0') ? '<span class="blc-free">رایگان</span>' : '<span class="amt">'+faPrice(raw)+' <small>تومان</small></span>';
    return '<div class="blc-price"><span class="k">شهریه دوره</span>'+inner+'</div>';
  }

  function cardHTML(c,i){
    var st = STATUS[c.status] || STATUS.open;
    var idx = toFa(('0'+(i+1)).slice(-2));
    var btn = st.enabled
      ? '<button type="button" class="blc-buy" data-blc-buy data-course-id="'+c.id+'" data-course-name="'+esc(c.name)+'">'+st.cta+' '+chevron+'</button>'
      : '<button type="button" class="blc-buy" disabled>'+st.cta+'</button>';
    return '<article class="blc-course" data-status="'+esc(c.status)+'" style="--acc:'+st.acc+'">'
      + '<div class="blc-top"><span class="blc-index">'+idx+'</span><span class="blc-badge '+st.cls+'"><span class="bdot"></span>'+st.label+'</span></div>'
      + '<h3 class="blc-name">'+esc(c.name)+'</h3>'
      + specsHTML(c)
      + '<div class="blc-count" data-course-id="'+c.id+'">'+peopleIc+'<span class="blc-count-n">'+toFa(c.registered)+'</span> نفر ثبت‌نام کرده‌اند</div>'
      + '<div class="blc-foot"><div class="blc-pricing">'+priceHTML(c.price)+paymentHTML(c.payment_method)+'</div>'+btn+'</div>'
      + '</article>';
  }

  var grid = document.getElementById('courseGrid');
  function loadCourses(){
    fetch(API + '/courses', { credentials:'same-origin' })
      .then(function(r){ return r.json(); })
      .then(function(list){
        if (!Array.isArray(list) || !list.length) { grid.innerHTML = '<p style="color:rgba(246,237,225,.7)">هنوز دوره‌ای ثبت نشده است.</p>'; return; }
        grid.innerHTML = list.map(cardHTML).join('');
        wireBuyButtons();
      })
      .catch(function(){ grid.innerHTML = '<p style="color:rgba(246,237,225,.7)">دریافت دوره‌ها ممکن نشد.</p>'; });
  }

  /* ---- modal ---- */
  var overlay = document.getElementById('blc-modal');
  var form = overlay.querySelector('.blc-form');
  var titleEl = overlay.querySelector('.blc-m-title');
  var courseInput = form.querySelector('input[name="course_id"]');
  var msgEl = form.querySelector('.blc-msg');
  var submitBtn = form.querySelector('.blc-submit');
  var fileInput = form.querySelector('input[type="file"]');
  var fileName = form.querySelector('.blc-file-name');

  function resetFileName(){ if (fileName) fileName.textContent = 'فایلی انتخاب نشده'; }
  function clearErrors(){ form.querySelectorAll('.blc-field.error').forEach(function(f){ f.classList.remove('error'); }); }
  function clearMsg(){ msgEl.className = 'blc-msg'; msgEl.textContent = ''; }

  function openModal(id,name){
    courseInput.value = id; titleEl.textContent = name || '';
    form.reset(); clearErrors(); clearMsg(); resetFileName();
    overlay.classList.add('open'); overlay.setAttribute('aria-hidden','false'); document.body.style.overflow='hidden';
    var first = form.querySelector('input[name="full_name"]'); if (first) setTimeout(function(){ first.focus(); }, 60);
  }
  function closeModal(){ overlay.classList.remove('open'); overlay.setAttribute('aria-hidden','true'); document.body.style.overflow=''; }

  function wireBuyButtons(){
    document.querySelectorAll('[data-blc-buy]').forEach(function(b){
      b.onclick = function(e){ e.preventDefault(); openModal(b.getAttribute('data-course-id'), b.getAttribute('data-course-name')); };
    });
  }

  overlay.querySelector('.blc-m-close').addEventListener('click', closeModal);
  overlay.addEventListener('click', function(e){ if (e.target === overlay) closeModal(); });
  document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && overlay.classList.contains('open')) closeModal(); });

  if (fileInput) fileInput.addEventListener('change', function(){
    if (fileInput.files && fileInput.files[0]) { fileName.textContent = fileInput.files[0].name; fileInput.closest('.blc-field').classList.remove('error'); }
    else resetFileName();
  });
  form.querySelectorAll('[data-required]').forEach(function(inp){ inp.addEventListener('input', function(){ inp.closest('.blc-field').classList.remove('error'); }); });

  function validate(){
    var ok = true, firstBad = null;
    form.querySelectorAll('[data-required]').forEach(function(inp){
      var field = inp.closest('.blc-field'), bad = false;
      if (inp.type === 'file') { bad = !(inp.files && inp.files.length); }
      else { var v = inp.value.trim(); bad = !v;
        if (!bad && inp.name === 'phone') bad = !/^09\d{9}$/.test(toEn(v));
        if (!bad && inp.name === 'national_id') bad = !/^\d{10}$/.test(toEn(v));
      }
      field.classList.toggle('error', bad);
      if (bad) { ok = false; if (!firstBad) firstBad = inp; }
    });
    if (firstBad && firstBad.focus) firstBad.focus();
    return ok;
  }

  form.addEventListener('submit', function(e){
    e.preventDefault(); clearMsg();
    if (!validate()) return;
    var fd = new FormData(form); // includes course_id, fields, receipt, honeypot(website)
    submitBtn.disabled = true; submitBtn.classList.add('loading');
    fetch(API + '/register', { method:'POST', body:fd, credentials:'same-origin' })
      .then(function(r){ return r.json(); })
      .then(function(res){
        submitBtn.disabled = false; submitBtn.classList.remove('loading');
        if (res && res.ok) {
          msgEl.className = 'blc-msg ok'; msgEl.textContent = res.message || 'ثبت نام با موفقیت انجام شد';
          var counter = document.querySelector('.blc-count[data-course-id="'+courseInput.value+'"] .blc-count-n');
          if (counter && typeof res.registered !== 'undefined') counter.textContent = toFa(res.registered);
          form.reset(); resetFileName(); clearErrors();
          setTimeout(closeModal, 2200);
        } else {
          msgEl.className = 'blc-msg err'; msgEl.textContent = (res && res.message) || 'ثبت نام انجام نشد';
        }
      })
      .catch(function(){ submitBtn.disabled = false; submitBtn.classList.remove('loading'); msgEl.className='blc-msg err'; msgEl.textContent='ثبت نام انجام نشد'; });
  });

  loadCourses();
})();
