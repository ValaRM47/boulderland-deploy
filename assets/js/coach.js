/* coach.js — coach profile page interactions (reveal handled by main.js; accordion, video, visit modal here). */
// nav scroll state
const nav=document.getElementById('nav');
addEventListener('scroll',()=>nav.classList.toggle('scrolled',scrollY>40),{passive:true});

// mobile menu
(()=>{
  const mm=document.getElementById('mobileMenu');
  const t=document.getElementById('navToggle'), c=document.getElementById('mobileClose');
  if(!mm||!t||!c)return;
  t.onclick=()=>mm.classList.add('open');
  c.onclick=()=>mm.classList.remove('open');
  mm.querySelectorAll('a').forEach(a=>a.onclick=()=>mm.classList.remove('open'));
})();

// reveal on scroll — sequence hierarchy
const io=new IntersectionObserver((es)=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('in');io.unobserve(e.target)}}),{threshold:.12,rootMargin:'0px 0px -60px 0px'});
document.querySelectorAll('.reveal').forEach((el,i)=>{el.style.transitionDelay=(i%4*0.06)+'s';io.observe(el);});

// hero depth — subtle parallax of portrait + disc (motivated: depth on the focal figure)
(()=>{
  const portrait=document.getElementById('heroPortrait');
  const disc=document.getElementById('heroDisc');
  if(!portrait||matchMedia('(prefers-reduced-motion:reduce)').matches)return;
  let ticking=false;
  addEventListener('scroll',()=>{
    if(ticking)return;ticking=true;
    requestAnimationFrame(()=>{
      const y=Math.min(scrollY,700);
      portrait.style.transform='translateY('+(y*0.06)+'px)';
      if(disc)disc.style.transform='translate(-50%,-50%) translateY('+(y*-0.04)+'px)';
      ticking=false;
    });
  },{passive:true});
})();

// visit modal — opens on any [data-visit] trigger
(()=>{
  const modal=document.getElementById('visitModal');
  if(!modal)return;
  const open=()=>{modal.classList.add('open');modal.setAttribute('aria-hidden','false');document.body.style.overflow='hidden';};
  const close=()=>{modal.classList.remove('open');modal.setAttribute('aria-hidden','true');document.body.style.overflow='';};
  document.querySelectorAll('[data-visit]').forEach(b=>b.addEventListener('click',e=>{e.preventDefault();open();}));
  document.getElementById('visitClose').addEventListener('click',close);
  modal.addEventListener('click',e=>{if(e.target===modal)close();});
  addEventListener('keydown',e=>{if(e.key==='Escape'&&modal.classList.contains('open'))close();});
})();

// testimonial videos — play button starts the video and hides while playing
document.querySelectorAll('.tvid').forEach(tv=>{
  const v=tv.querySelector('video'), btn=tv.querySelector('.play');
  if(!v||!btn)return;
  btn.addEventListener('click',()=>{v.play().catch(()=>{});});
  v.addEventListener('play',()=>tv.classList.add('playing'));
  v.addEventListener('pause',()=>tv.classList.remove('playing'));
  v.addEventListener('ended',()=>tv.classList.remove('playing'));
});
