<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>دوره‌های بلدرلند | ثبت‌نام دوره‌های سنگ‌نوردی</title>
<meta name="description" content="دوره‌های آموزشی سنگ‌نوردی باشگاه بلدرلند — از مقدماتی تا پیشرفته و مربیگری." />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;300;400;500;600;700;800;900&family=Anton&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="/assets/css/global.css" />
<link rel="stylesheet" href="/assets/css/header.css" />
<link rel="stylesheet" href="/assets/css/footer.css" />
<link rel="stylesheet" href="/assets/css/courses.css" />
</head>
<body class="blc-page-body">

<?php $PAGE = 'courses'; include $_SERVER['DOCUMENT_ROOT'] . '/components/header.php'; ?>

<div class="blc-page">

  <!-- ============ HERO ============ -->
  <section class="hero">
    <div class="wrap">
      <span class="eyebrow"><span class="dot"></span> آموزش سنگ‌نوردی در بلدرلند</span>
      <h1>دوره‌های <span class="accent">بلدرلند</span></h1>
      <p>از نخستین صعود تا مربیگری حرفه‌ای؛ دوره‌هایی ساخته‌شده برای هر سطح، زیر نظر بهترین مربیان باشگاه. دوره‌ی خود را انتخاب کن و همین امروز ثبت‌نام کن.</p>
    </div>
  </section>

  <!-- ============ STATS ============ -->
  <section class="stats">
    <div class="wrap">
      <div class="stat-grid">
        <div class="stat reveal">
          <span class="ic"><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.42A12 12 0 0 1 12 20a12 12 0 0 1-6.16-9.42L12 14z"/></svg></span>
          <span class="num display"><span class="count" data-target="20">۰</span><span class="plus">+</span></span>
          <span class="lbl">دوره برگزار شده</span>
        </div>
        <div class="stat reveal">
          <span class="ic"><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="6"/><path d="M8.5 14.5 7 22l5-3 5 3-1.5-7.5"/></svg></span>
          <span class="num display"><span class="count" data-target="150">۰</span><span class="plus">+</span></span>
          <span class="lbl">سرتیفیکیت اهدا شده</span>
        </div>
        <div class="stat reveal">
          <span class="ic"><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
          <span class="num display"><span class="count" data-target="200">۰</span><span class="plus">+</span></span>
          <span class="lbl">ورزشکار در دوره‌ها شرکت کرده‌اند</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ COURSES ============ -->
  <section class="block forest" id="courses">
    <div class="wrap">
      <div class="sec-head reveal">
        <div class="sh-l">
          <span class="sec-tag">دوره‌ها</span>
          <h2>دوره های بلدرلند</h2>
        </div>
        <div class="filter-bar">
          <label for="statusFilter">فیلتر وضعیت:</label>
          <span class="sel">
            <select id="statusFilter" aria-label="فیلتر بر اساس وضعیت دوره">
              <option value="all">همه‌ی دوره‌ها</option>
              <option value="open">در حال ثبت‌نام</option>
              <option value="live">در حال برگزاری</option>
              <option value="soon">به‌زودی</option>
              <option value="done">برگزار شده</option>
            </select>
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
          </span>
        </div>
      </div>

      <!-- plugin courses are loaded into this container from the WordPress REST API -->
      <div class="blc-grid" id="courseGrid">
        <p style="color:rgba(246,237,225,.6)">در حال بارگذاری دوره‌ها…</p>
      </div>
    </div>
  </section>

  <!-- ============ TESTIMONIALS ============ -->
  <section class="block tsts" id="testimonials">
    <div class="wrap">
      <div class="sec-head reveal">
        <div class="sh-l">
          <span class="sec-tag">نظر ورزشکاران</span>
          <h2>از زبان کسانی که دوره را گذرانده‌اند</h2>
        </div>
        <div class="tst-nav">
          <button class="tst-arrow" id="tstNext" aria-label="بعدی"><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg></button>
          <button class="tst-arrow" id="tstPrev" aria-label="قبلی"><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg></button>
        </div>
      </div>
      <div class="tst-grid" id="tstGrid">
        <article class="tst reveal">
          <span class="quote-ic"><svg viewBox="0 0 24 24"><path d="M7 7h5v5a5 5 0 0 1-5 5V7zm9 0h5v5a5 5 0 0 1-5 5V7z" transform="scale(1,-1) translate(0,-24)"/></svg></span>
          <div class="stars" aria-label="5 از ۵ ستاره"><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
          <p class="body">قبل از دوره فکر می‌کردم سنگ‌نوردی فقط زور بازوست. مربی نشانم داد همه‌چیز درباره‌ی تکنیک و تعادل است. حالا با اعتمادبه‌نفس لید می‌زنم.</p>
          <div class="who"><span class="avatar">س</span><div><div class="name">سارا احمدی</div><div class="course-of">دوره مقدماتی سنگ‌نوردی</div></div></div>
        </article>
        <article class="tst reveal">
          <span class="quote-ic"><svg viewBox="0 0 24 24"><path d="M7 7h5v5a5 5 0 0 1-5 5V7zm9 0h5v5a5 5 0 0 1-5 5V7z" transform="scale(1,-1) translate(0,-24)"/></svg></span>
          <div class="stars" aria-label="5 از ۵ ستاره"><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
          <p class="body">فضای تمرین حرفه‌ای، برنامه‌ی منظم و مربی‌ای که واقعاً پیگیر پیشرفتت است. ارزشش را چند برابر داشت.</p>
          <div class="who"><span class="avatar">ر</span><div><div class="name">رضا موسوی</div><div class="course-of">دوره پیشرفته‌ی لید</div></div></div>
        </article>
        <article class="tst reveal">
          <span class="quote-ic"><svg viewBox="0 0 24 24"><path d="M7 7h5v5a5 5 0 0 1-5 5V7zm9 0h5v5a5 5 0 0 1-5 5V7z" transform="scale(1,-1) translate(0,-24)"/></svg></span>
          <div class="stars" aria-label="4 از ۵ ستاره"><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="off" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
          <p class="body">دوره‌ی بولدرینگ کاملاً سبک حرکتم را عوض کرد. حرکت‌هایی که فکر می‌کردم غیرممکن‌اند حالا برایم عادی شده‌اند.</p>
          <div class="who"><span class="avatar">ن</span><div><div class="name">نیلوفر کریمی</div><div class="course-of">دوره بولدرینگ و تکنیک</div></div></div>
        </article>
        <article class="tst reveal">
          <span class="quote-ic"><svg viewBox="0 0 24 24"><path d="M7 7h5v5a5 5 0 0 1-5 5V7zm9 0h5v5a5 5 0 0 1-5 5V7z" transform="scale(1,-1) translate(0,-24)"/></svg></span>
          <div class="stars" aria-label="5 از ۵ ستاره"><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
          <p class="body">دخترم عاشق جلسات شده و هر هفته بی‌صبرانه منتظر دوره است. محیط امن و مربیان صبور، دقیقاً همان چیزی که می‌خواستم.</p>
          <div class="who"><span class="avatar">م</span><div><div class="name">محمد رادمنش</div><div class="course-of">دوره کودکان و نونهالان</div></div></div>
        </article>
        <article class="tst reveal">
          <span class="quote-ic"><svg viewBox="0 0 24 24"><path d="M7 7h5v5a5 5 0 0 1-5 5V7zm9 0h5v5a5 5 0 0 1-5 5V7z" transform="scale(1,-1) translate(0,-24)"/></svg></span>
          <div class="stars" aria-label="5 از ۵ ستاره"><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg><svg class="on" viewBox="0 0 24 24" stroke-linejoin="round" stroke-width="1.6"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
          <p class="body">بخش ایمنی و کار با طناب را هر سنگ‌نوردی باید بگذراند. بعد از این دوره دیگر هیچ‌وقت سر دیواره استرس ندارم.</p>
          <div class="who"><span class="avatar">ا</span><div><div class="name">الهام حسینی</div><div class="course-of">دوره ایمنی و کار با طناب</div></div></div>
        </article>
      </div>
    </div>
  </section>

  <!-- ============ REGISTRATION MODAL ============ -->
  <div class="blc-modal-overlay" id="blc-modal" aria-hidden="true">
    <div class="blc-modal" role="dialog" aria-modal="true" aria-labelledby="blc-m-title">
      <button type="button" class="blc-m-close" aria-label="بستن"><svg viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg></button>
      <div class="blc-m-head"><span class="blc-m-kicker">ثبت‌نام دوره</span><h3 class="blc-m-title" id="blc-m-title"></h3></div>
      <form class="blc-form" novalidate enctype="multipart/form-data">
        <input type="hidden" name="course_id" value="">
        <input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;width:1px;height:1px;opacity:0" aria-hidden="true">
        <div class="blc-field"><label>نام و نام خانوادگی</label><input type="text" name="full_name" data-required autocomplete="name"><span class="blc-err">این فیلد الزامی است</span></div>
        <div class="blc-field"><label>شماره تماس</label><input type="tel" name="phone" data-required inputmode="numeric" placeholder="۰۹۱۲۳۴۵۶۷۸۹" autocomplete="tel"><span class="blc-err">شماره تماس معتبر وارد کنید</span></div>
        <div class="blc-field"><label>تاریخ انقضای بیمه ورزشی</label><input type="text" name="insurance_expiry" data-required placeholder="مثال: ۱۴۰۵/۰۹/۰۱"><span class="blc-err">این فیلد الزامی است</span></div>
        <div class="blc-field"><label>کد ملی</label><input type="text" name="national_id" data-required inputmode="numeric" maxlength="10"><span class="blc-err">کد ملی باید ۱۰ رقم باشد</span></div>
        <div class="blc-field blc-file"><label>بارگذاری فیش واریزی</label>
          <div class="blc-file-box">
            <input type="file" name="receipt" accept="image/*" data-required id="blc-receipt">
            <label for="blc-receipt" class="blc-file-btn"><svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M17 8l-5-5-5 5"/><path d="M12 3v12"/></svg> انتخاب تصویر</label>
            <span class="blc-file-name">فایلی انتخاب نشده</span>
          </div>
          <span class="blc-err">بارگذاری فیش واریزی الزامی است</span>
        </div>
        <div class="blc-msg" role="status" aria-live="polite"></div>
        <button type="submit" class="blc-submit"><span class="blc-submit-txt">ثبت‌نام</span><span class="blc-spinner"></span></button>
      </form>
    </div>
  </div>

</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'; ?>

<script src="/assets/js/main.js" defer></script>
<script src="/assets/js/courses.js" defer></script>
</body>
</html>
