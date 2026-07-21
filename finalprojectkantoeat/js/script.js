/* ===== KANTO EAT JS — Premium Microinteractions & Animations v2.0 ===== */

document.addEventListener('DOMContentLoaded', () => {

  /* ======================== PAGE REVEAL ======================== */
  function triggerPageReveal() {
    document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach((el, i) => {
      setTimeout(() => el.classList.add('visible'), 80 + i * 80);
    });
    initCountUp();
  }

  /* ======================== SCROLL REVEAL (IntersectionObserver) ======================== */
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.10, rootMargin: '0px 0px -30px 0px' });

  document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => {
    revealObserver.observe(el);
  });

  triggerPageReveal();

  /* ======================== NIGHT / DAY TOGGLE ======================== */
  const nightBtn = document.getElementById('night-btn');
  const stored = localStorage.getItem('ke-theme');
  if (stored) document.documentElement.setAttribute('data-theme', stored);
  if (nightBtn) {
    const updateIcon = () => {
      nightBtn.textContent = document.documentElement.getAttribute('data-theme') === 'night' ? '☀️' : '🌙';
    };
    updateIcon();
    nightBtn.addEventListener('click', () => {
      const curr = document.documentElement.getAttribute('data-theme');
      const next = curr === 'night' ? 'day' : 'night';
      document.documentElement.setAttribute('data-theme', next);
      localStorage.setItem('ke-theme', next);
      updateIcon();
      if (next === 'night') spawnFireflies();
      else removeFireflies();
    });
  }

  /* ======================== HEADER SHRINK ON SCROLL ======================== */
  const header = document.querySelector('.site-header');
  if (header) {
    const onScroll = () => {
      if (window.scrollY > 60) {
        header.classList.add('shrunk');
      } else {
        header.classList.remove('shrunk');
      }
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ======================== ACTIVE NAV LINK ======================== */
  const currentPage = window.location.pathname.split('/').pop() || 'index.php';
  document.querySelectorAll('.site-nav a').forEach(a => {
    const href = a.getAttribute('href') || '';
    if (href.includes(currentPage) && !href.includes('#')) {
      a.classList.add('active');
    }
  });

  /* ======================== FIREFLIES ======================== */
  function spawnFireflies() {
    for (let i = 0; i < 14; i++) {
      setTimeout(() => {
        const ff = document.createElement('div');
        ff.className = 'firefly';
        ff.style.cssText = `
          position:fixed; pointer-events:none; z-index:1;
          width:5px; height:5px; border-radius:50%;
          background:rgba(255,230,80,0.9);
          box-shadow: 0 0 8px 3px rgba(255,230,80,0.6);
          left:${Math.random()*100}vw; top:${Math.random()*80+10}vh;
          animation: fireflyFloat ${4+Math.random()*4}s ease-in-out infinite;
          animation-delay: ${Math.random()*3}s;
        `;
        document.body.appendChild(ff);
      }, i * 200);
    }
    if (!document.getElementById('ff-style')) {
      const s = document.createElement('style');
      s.id = 'ff-style';
      const r = () => ((Math.random()-0.5)*60).toFixed(0);
      s.textContent = `@keyframes fireflyFloat {
        0%,100%{transform:translate(0,0) scale(1);opacity:0.9;}
        25%{transform:translate(${r()}px,${r()}px) scale(0.6);opacity:0.3;}
        50%{transform:translate(${r()}px,${r()}px) scale(1);opacity:1;}
        75%{transform:translate(${r()}px,${r()}px) scale(0.8);opacity:0.5;}
      }`;
      document.head.appendChild(s);
    }
  }
  function removeFireflies() { document.querySelectorAll('.firefly').forEach(f => f.remove()); }
  if (document.documentElement.getAttribute('data-theme') === 'night') spawnFireflies();

  /* ======================== RIPPLE EFFECT ON BUTTONS ======================== */
  document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      const r = document.createElement('span');
      r.className = 'ripple';
      const rect = this.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height) * 2;
      r.style.cssText = `
        width:${size}px; height:${size}px;
        left:${e.clientX - rect.left - size/2}px;
        top:${e.clientY - rect.top - size/2}px;
      `;
      this.appendChild(r);
      setTimeout(() => r.remove(), 700);
    });
  });

  /* ======================== CURSOR PARALLAX LEAVES ======================== */
  const leaves = [];
  const leafCount = 5;
  for (let i = 0; i < leafCount; i++) {
    const leaf = document.createElement('div');
    leaf.className = 'cursor-leaf';
    leaf.style.cssText = `
      width:${7+i*3}px; height:${7+i*3}px;
      opacity: ${0.35 + i*0.07};
      transition-duration: ${0.45+i*0.14}s;
    `;
    document.body.appendChild(leaf);
    leaves.push({ el: leaf });
  }
  let mouseX = 0, mouseY = 0;
  document.addEventListener('mousemove', e => { mouseX = e.clientX; mouseY = e.clientY; });
  function animateLeaves() {
    leaves.forEach((lf, i) => {
      lf.el.style.left = (mouseX + Math.sin(Date.now()/1000 + i)*18) + 'px';
      lf.el.style.top  = (mouseY + Math.cos(Date.now()/1200 + i)*14 + i*13) + 'px';
    });
    requestAnimationFrame(animateLeaves);
  }
  animateLeaves();

  /* ======================== TOAST NOTIFICATION SYSTEM ======================== */
  let toastContainer = document.querySelector('.toast-container');
  if (!toastContainer) {
    toastContainer = document.createElement('div');
    toastContainer.className = 'toast-container';
    document.body.appendChild(toastContainer);
  }

  function showToast(message, icon = '✅', duration = 2800) {
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `<span class="toast-icon">${icon}</span><span>${message}</span>`;
    toastContainer.appendChild(toast);
    setTimeout(() => {
      toast.classList.add('hide');
      setTimeout(() => toast.remove(), 400);
    }, duration);
    return toast;
  }
  window.kantoEatToast = showToast;

  /* ======================== LOGIN FORM ======================== */
  const loginForm = document.getElementById('login-form');
  const loginCard = document.getElementById('login-card');
  const loginBtn  = document.getElementById('login-submit');
  if (loginForm && loginCard) {
    loginForm.addEventListener('submit', function() {
      if (loginBtn) {
        loginBtn.disabled  = true;
        loginBtn.innerHTML = '<span style="display:inline-block;animation:spin 0.8s linear infinite">🍽️</span> Signing in...';
      }
    });
    const errEl = document.querySelector('.alert.error, .alert-error');
    if (errEl) {
      loginCard.classList.add('shake');
      setTimeout(() => loginCard.classList.remove('shake'), 600);
    }
    loginForm.querySelectorAll('input').forEach(inp => {
      inp.addEventListener('focus', () => { inp.style.boxShadow = '0 0 0 4px rgba(212,175,55,0.18), 0 0 22px rgba(212,175,55,0.35)'; });
      inp.addEventListener('blur',  () => { inp.style.boxShadow = ''; });
    });
  }

  /* ======================== PASSWORD VISIBILITY TOGGLE ======================== */
  document.querySelectorAll('.pw-toggle').forEach(btn => {
    btn.addEventListener('click', function() {
      const wrap = this.closest('.pw-wrap');
      const inp  = wrap ? wrap.querySelector('input') : null;
      if (!inp) return;
      if (inp.type === 'password') {
        inp.type = 'text';
        this.textContent = '🙈';
        this.title = 'Hide password';
      } else {
        inp.type = 'password';
        this.textContent = '👁️';
        this.title = 'Show password';
      }
    });
  });

  /* ======================== FOOD TRAY ======================== */
  const trayBtn     = document.getElementById('tray-btn');
  const trayPanel   = document.getElementById('tray-panel');
  const trayBg      = document.getElementById('tray-backdrop');
  const trayClose   = document.getElementById('tray-close');
  const trayCount   = document.getElementById('tray-count');
  const trayItemsEl = document.getElementById('tray-items');
  const trayEmptyEl = document.getElementById('tray-empty');
  const trayTotal   = document.getElementById('tray-total');
  let tray = [];

  function openTray()  { trayPanel?.classList.add('open'); trayBg?.classList.add('show'); }
  function closeTray() { trayPanel?.classList.remove('open'); trayBg?.classList.remove('show'); }
  trayBtn?.addEventListener('click', openTray);
  trayClose?.addEventListener('click', closeTray);
  trayBg?.addEventListener('click', closeTray);

  function updateTrayUI() {
    if (!trayItemsEl) return;
    const total = tray.reduce((s, i) => s + i.price * i.qty, 0);
    const count = tray.reduce((s, i) => s + i.qty, 0);
    if (trayCount) {
      trayCount.textContent = count;
      if (count > 0) {
        trayCount.classList.add('show');
        trayCount.classList.add('pop');
        setTimeout(() => trayCount.classList.remove('pop'), 400);
      } else {
        trayCount.classList.remove('show');
      }
    }
    if (trayTotal) animatePrice(trayTotal, total);
    if (tray.length === 0) {
      trayItemsEl.innerHTML = '';
      trayEmptyEl?.classList.remove('hidden');
    } else {
      trayEmptyEl?.classList.add('hidden');
      renderTrayItems();
    }
  }

  function animatePrice(el, target) {
    el.classList.add('counting');
    el.textContent = '₱' + target.toFixed(2);
    setTimeout(() => el.classList.remove('counting'), 300);
  }

  function renderTrayItems() {
    if (!trayItemsEl) return;
    trayItemsEl.innerHTML = '';
    tray.forEach((item, idx) => {
      const div = document.createElement('div');
      div.className = 'tray-item';
      div.innerHTML = `
        <img src="${item.image}" alt="${item.name}">
        <div class="tray-item-info">
          <h4>${item.name}</h4>
          <p>${item.category}</p>
        </div>
        <div class="tray-qty">
          <button class="qty-btn minus" data-idx="${idx}" aria-label="Remove one">−</button>
          <span class="qty-num">${item.qty}</span>
          <button class="qty-btn plus" data-idx="${idx}" aria-label="Add one">+</button>
        </div>
        <span class="tray-item-price">₱${(item.price * item.qty).toFixed(2)}</span>
      `;
      trayItemsEl.appendChild(div);
    });
    trayItemsEl.querySelectorAll('.qty-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const idx = parseInt(this.dataset.idx);
        this.classList.add('pop');
        setTimeout(() => this.classList.remove('pop'), 300);
        if (this.classList.contains('plus')) {
          tray[idx].qty++;
        } else {
          tray[idx].qty--;
          if (tray[idx].qty <= 0) {
            const row = this.closest('.tray-item');
            row.classList.add('removing');
            setTimeout(() => { tray.splice(idx, 1); updateTrayUI(); }, 300);
            return;
          }
        }
        updateTrayUI();
      });
    });
  }

  /* Add to tray buttons */
  document.querySelectorAll('.add-tray-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault(); e.stopPropagation();
      const card = this.closest('[data-food-card], .food-card');
      if (!card) return;
      const id       = parseInt(card.dataset.id || 0);
      const name     = card.dataset.name || '';
      const price    = parseFloat(card.dataset.price || 0);
      const category = card.dataset.category || '';
      const imgEl    = card.querySelector('.food-img-wrap img');
      const imgSrc   = imgEl ? imgEl.src : '';

      this.classList.add('adding');
      setTimeout(() => this.classList.remove('adding'), 400);

      spawnSparkles(e.clientX, e.clientY);
      if (imgEl && trayBtn) flyFoodToTray(imgEl, trayBtn);

      const existing = tray.find(t => t.id === id);
      if (existing) existing.qty++;
      else tray.push({ id, name, price, category, image: imgSrc, qty: 1 });

      setTimeout(() => {
        trayBtn?.classList.add('shake');
        setTimeout(() => trayBtn?.classList.remove('shake'), 500);
        updateTrayUI();
        showToast(`${name} added to tray!`, '🍽️');
      }, 400);
    });
  });

  function spawnSparkles(cx, cy) {
    const colors = ['#D4AF37','#6AA84F','#D87D3E','#FFF8E7','#1E5631'];
    for (let i = 0; i < 8; i++) {
      const sp = document.createElement('div');
      sp.className = 'sparkle';
      const angle = (i / 8) * Math.PI * 2;
      const dist  = 28 + Math.random() * 42;
      const tx    = Math.cos(angle) * dist;
      const ty    = Math.sin(angle) * dist;
      sp.style.cssText = `
        left:${cx}px; top:${cy}px;
        background:${colors[i % colors.length]};
        width:${5+Math.random()*6}px; height:${5+Math.random()*6}px;
        --burst-xy: translate(${tx.toFixed(0)}px,${ty.toFixed(0)}px);
      `;
      document.body.appendChild(sp);
      setTimeout(() => sp.remove(), 700);
    }
  }

  function flyFoodToTray(imgEl, trayBtnEl) {
    const imgRect  = imgEl.getBoundingClientRect();
    const trayRect = trayBtnEl.getBoundingClientRect();
    const fly = document.createElement('img');
    fly.src = imgEl.src;
    fly.className = 'flying-food';
    const tx = trayRect.left + trayRect.width/2  - imgRect.left  - imgRect.width/2;
    const ty = trayRect.top  + trayRect.height/2 - imgRect.top   - imgRect.height/2;
    fly.style.cssText = `
      left:${imgRect.left}px; top:${imgRect.top}px;
      --fly-x:${tx.toFixed(0)}px; --fly-y:${ty.toFixed(0)}px;
    `;
    document.body.appendChild(fly);
    setTimeout(() => fly.remove(), 700);
  }

  /* Checkout */
  const checkoutBtn = document.getElementById('checkout-btn');
  checkoutBtn?.addEventListener('click', () => {
    if (tray.length === 0) {
      showToast('Your tray is empty! Add some ulam first.', '🍽️');
      return;
    }
    closeTray();
    showSuccess();
    confettiPetals();
    tray = [];
    setTimeout(() => updateTrayUI(), 500);
  });

  function showSuccess() {
    const overlay = document.getElementById('success-overlay');
    if (!overlay) return;
    overlay.classList.add('show');
    setTimeout(() => overlay.classList.remove('show'), 4500);
  }

  function confettiPetals() {
    for (let i = 0; i < 48; i++) {
      setTimeout(() => {
        const petal = document.createElement('div');
        petal.className = 'petal';
        const colors = ['#fff8e8','#f9d2a0','#a8d8a0','#d4af37','#6aa84f','#fce8d8'];
        petal.style.cssText = `
          left:${Math.random()*100}vw; top:-20px;
          background:${colors[Math.floor(Math.random()*colors.length)]};
          width:${8+Math.random()*10}px; height:${8+Math.random()*10}px;
          animation-duration:${1.2+Math.random()*1.2}s;
          animation-delay:${Math.random()*0.6}s;
          border-radius:${Math.random()>0.5?'50%':'4px'};
        `;
        document.body.appendChild(petal);
        setTimeout(() => petal.remove(), 2800);
      }, i * 60);
    }
  }

  /* ======================== COUNT-UP ======================== */
  function initCountUp() {
    document.querySelectorAll('[data-count]').forEach(el => {
      const target = parseInt(el.dataset.count);
      if (isNaN(target)) return;
      const dur   = 1400;
      const start = performance.now();
      const tick  = (now) => {
        const p    = Math.min((now - start) / dur, 1);
        const ease = 1 - Math.pow(1 - p, 3);
        el.textContent = Math.round(ease * target).toLocaleString();
        if (p < 1) requestAnimationFrame(tick);
      };
      requestAnimationFrame(tick);
    });
  }

  /* Count-up on scroll for stats section */
  const statsSection = document.querySelector('.stats-section');
  if (statsSection) {
    let fired = false;
    const statsObserver = new IntersectionObserver(entries => {
      if (entries[0].isIntersecting && !fired) {
        fired = true;
        initCountUp();
      }
    }, { threshold: 0.3 });
    statsObserver.observe(statsSection);
  }

  /* ======================== CATEGORY FILTER ======================== */
  const catBtns    = document.querySelectorAll('[data-category-filter]');
  const foodCards  = document.querySelectorAll('[data-food-card]');
  const searchInput = document.querySelector('[data-food-search]');

  function applyFilter() {
    const activeBtn = document.querySelector('[data-category-filter].active');
    const cat  = activeBtn ? activeBtn.dataset.categoryFilter : 'all';
    const term = searchInput ? searchInput.value.trim().toLowerCase() : '';
    let visible = 0;
    foodCards.forEach(card => {
      const cardCat  = card.dataset.category || '';
      const cardText = card.textContent.toLowerCase();
      const catOk    = cat === 'all' || cardCat === cat;
      const termOk   = !term || cardText.includes(term);
      const show     = catOk && termOk;
      card.style.display = show ? '' : 'none';
      if (show) {
        visible++;
        card.style.animation = 'none';
        void card.offsetWidth;
        card.style.animation = '';
      }
    });
    const emptyEl = document.getElementById('empty-search');
    if (emptyEl) emptyEl.style.display = visible === 0 ? 'block' : 'none';
  }

  catBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      catBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      applyFilter();
    });
  });
  searchInput?.addEventListener('input', applyFilter);

  /* Sidebar + chip sync */
  document.querySelectorAll('.sidebar .item[data-category-filter]').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.sidebar .item').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      const cat = this.dataset.categoryFilter;
      document.querySelectorAll('.category-chip').forEach(chip => {
        chip.classList.toggle('active', chip.dataset.categoryFilter === cat);
      });
    });
  });

  /* ======================== HERO SEARCH (index.php) ======================== */
  const heroSearchForm = document.getElementById('hero-search-form');
  if (heroSearchForm) {
    heroSearchForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const q = this.querySelector('input').value.trim();
      if (q) {
        window.location.href = `dashboard.php?search=${encodeURIComponent(q)}`;
      } else {
        window.location.href = 'dashboard.php';
      }
    });
  }

  /* Pre-fill search from URL on dashboard */
  const urlSearch = new URLSearchParams(window.location.search).get('search');
  if (urlSearch && searchInput) {
    searchInput.value = urlSearch;
    setTimeout(applyFilter, 100);
  }

  /* ======================== MOBILE NAV ======================== */
  const navToggle = document.querySelector('[data-nav-toggle]');
  const siteNav   = document.querySelector('[data-site-nav]');
  navToggle?.addEventListener('click', () => {
    navToggle.classList.toggle('open');
    siteNav?.classList.toggle('open');
  });
  // Close nav when clicking outside
  document.addEventListener('click', (e) => {
    if (siteNav?.classList.contains('open') && !navToggle?.contains(e.target) && !siteNav?.contains(e.target)) {
      navToggle?.classList.remove('open');
      siteNav?.classList.remove('open');
    }
  });

  /* ======================== SIGNUP PAGE ======================== */
  const studentInputs = document.querySelectorAll('[name="student_status"]');
  const studentField  = document.querySelector('[data-student-field]');
  const studentNumEl  = document.querySelector('[data-student-number]');
  const updateStudentField = () => {
    if (!studentField || !studentNumEl) return;
    const sel = document.querySelector('[name="student_status"]:checked');
    const yes = sel && sel.value === 'yes';
    studentField.classList.toggle('hidden', !yes);
    studentNumEl.required = yes;
  };
  if (studentInputs.length) {
    studentInputs.forEach(inp => inp.addEventListener('change', updateStudentField));
    updateStudentField();
  }

  /* Password strength indicator */
  const pwInput = document.getElementById('password');
  const strengthBar = document.getElementById('pw-strength');
  if (pwInput && strengthBar) {
    pwInput.addEventListener('input', function() {
      const v = this.value;
      let score = 0;
      if (v.length >= 8) score++;
      if (/[A-Z]/.test(v)) score++;
      if (/[0-9]/.test(v)) score++;
      if (/[^A-Za-z0-9]/.test(v)) score++;
      const colors = ['#C44536','#D87D3E','#D4AF37','#6AA84F'];
      const labels = ['Weak','Fair','Good','Strong'];
      const w = score * 25;
      strengthBar.style.width = w + '%';
      strengthBar.style.background = colors[score-1] || '#e0e0e0';
      const lbl = document.getElementById('pw-strength-label');
      if (lbl) lbl.textContent = score > 0 ? labels[score-1] : '';
    });
  }

  /* ======================== ROLE SELECT (LOGIN) ======================== */
  const roleSelect = document.querySelector('[data-role-select]');
  const adminNote  = document.querySelector('[data-admin-note]');
  if (roleSelect && adminNote) {
    const sync = () => { adminNote.style.display = roleSelect.value === 'admin' ? 'block' : 'none'; };
    roleSelect.addEventListener('change', sync);
    sync();
  }

  /* ======================== INGREDIENT REVEAL ======================== */
  const listItems = document.querySelectorAll('.list li');
  if (listItems.length) {
    listItems.forEach((li, i) => {
      setTimeout(() => li.classList.add('revealed'), 280 + i * 140);
    });
  }

  /* ======================== ADMIN IMAGE PREVIEW ======================== */
  const imgPathInput = document.querySelector('[name="image"]');
  const imgPreview   = document.getElementById('img-preview');
  if (imgPathInput && imgPreview) {
    const updatePreview = () => {
      const path = imgPathInput.value.trim();
      if (path) {
        imgPreview.src = path.startsWith('../') ? path : '../' + path;
        imgPreview.style.display = 'block';
        imgPreview.onerror = () => { imgPreview.style.display = 'none'; };
      } else {
        imgPreview.style.display = 'none';
      }
    };
    imgPathInput.addEventListener('input', updatePreview);
    updatePreview();
  }

  /* ======================== HERO TYPING EFFECT ======================== */
  const typingTarget = document.getElementById('hero-typing');
  if (typingTarget) {
    const words = ['Karinderya', 'Lutong Bahay', 'Ulam ng Bayan', 'Pagkain'];
    let wi = 0, ci = 0, deleting = false;
    const cursor = document.createElement('span');
    cursor.className = 'typing-cursor';
    typingTarget.after(cursor);

    function typeLoop() {
      const word = words[wi];
      if (!deleting) {
        typingTarget.textContent = word.slice(0, ci + 1);
        ci++;
        if (ci === word.length) { deleting = true; setTimeout(typeLoop, 1800); return; }
      } else {
        typingTarget.textContent = word.slice(0, ci - 1);
        ci--;
        if (ci === 0) { deleting = false; wi = (wi + 1) % words.length; }
      }
      setTimeout(typeLoop, deleting ? 60 : 110);
    }
    setTimeout(typeLoop, 600);
  }

  /* ======================== PARALLAX HERO ======================== */
  const heroSection = document.querySelector('.hero');
  if (heroSection) {
    window.addEventListener('scroll', () => {
      const y = window.scrollY;
      const bg = heroSection.querySelector('.hero-bg');
      const sr = heroSection.querySelector('.sun-rays');
      if (bg) bg.style.transform = `translateY(${y * 0.3}px)`;
      if (sr) sr.style.transform = `translateY(${y * 0.15}px) scale(${1 + y * 0.0002})`;
    }, { passive: true });
  }

  /* ======================== SMOOTH PAGE TRANSITIONS ======================== */
  const pageTransition = document.getElementById('page-transition');
  document.querySelectorAll('a[href]').forEach(a => {
    const href = a.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('http') || href.startsWith('mailto') || a.target === '_blank') return;
    a.addEventListener('click', function(e) {
      if (e.ctrlKey || e.metaKey || e.shiftKey) return;
      e.preventDefault();
      if (pageTransition) {
        pageTransition.classList.add('fade-in');
        setTimeout(() => { window.location.href = href; }, 380);
      } else {
        window.location.href = href;
      }
    });
  });
  if (pageTransition) {
    window.addEventListener('pageshow', () => pageTransition.classList.remove('fade-in'));
  }

});