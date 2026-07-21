<?php require_once __DIR__ . '/includes/data.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Kanto Eat — Discover the best Filipino karinderyas, eateries, and lutong bahay near you. Browse menus, check prices, and support local food businesses.">
  <title>Kanto Eat | Discover Filipino Karinderyas Near You</title>
  <link rel="stylesheet" href="finalprojectkantoeat/css/style.css">
</head>
<body class="page-body">

<?php include __DIR__ . '/includes/header.php'; ?>

<main>

  <!-- ===== HERO SECTION ===== -->
  <section class="hero" aria-label="Hero">
    <div class="hero-bg"></div>
    <div class="sun-rays"></div>

    <div class="container">
      <div class="hero-content">

        <!-- Left: Text -->
        <div class="hero-text">
          <div class="kicker reveal">🌿 FEU-Inspired Filipino Karinderya Platform</div>
          <h1 class="reveal">
            Discover the Best<br>
            <em id="hero-typing">Karinderya</em><br>
            Near You.
          </h1>
          <p class="reveal">
            Kanto Eat helps you find nearby Filipino karinderyas, eateries, and food stalls. Browse menus, check prices, see ratings, and support your local lutong bahay.
          </p>

          <!-- Search Bar -->
          <form class="hero-search reveal" id="hero-search-form" role="search" aria-label="Search food">
            <span class="hero-search-icon" aria-hidden="true">🔍</span>
            <input
              type="text"
              placeholder="Search meals, eateries, ulam..."
              aria-label="Search meals or restaurants"
              id="hero-search-input"
            >
            <button type="submit" class="hero-search-btn">Search</button>
          </form>

          <!-- Category Pills -->
          <div class="hero-cats reveal" role="navigation" aria-label="Food categories">
            <a class="hero-cat-pill" href="dashboard.php?cat=Meals">🍛 Meals</a>
            <a class="hero-cat-pill" href="dashboard.php?cat=Snacks">🍢 Street Food</a>
            <a class="hero-cat-pill" href="dashboard.php">🥘 Lutong Bahay</a>
            <a class="hero-cat-pill" href="dashboard.php?cat=Lunch">🍜 Noodles</a>
            <a class="hero-cat-pill" href="dashboard.php?cat=Desserts">🍧 Desserts</a>
            <a class="hero-cat-pill" href="dashboard.php?cat=Drinks">☕ Drinks</a>
          </div>

          <!-- CTA Buttons -->
          <div class="hero-actions reveal">
            <a class="btn btn-primary btn-lg btn-bounce" href="dashboard.php">🍽️ Browse Menu</a>
            <a class="btn btn-ghost btn-lg" href="signup.php">📝 Register Free</a>
          </div>

          <!-- Stats -->
          <div class="hero-stats reveal">
            <div class="stat-box">
              <strong>100+</strong>
              <span>Karinderyas</span>
            </div>
            <div class="stat-box">
              <strong>5,000+</strong>
              <span>Happy Customers</span>
            </div>
            <div class="stat-box">
              <strong>Daily</strong>
              <span>Menu Updates</span>
            </div>
            <div class="stat-box">
              <strong>Free</strong>
              <span>To Register</span>
            </div>
          </div>
        </div>

        <!-- Right: Mini menu preview panel -->
        <div class="hero-visual reveal-right">
          <div class="visual-frame">
            <div class="side-tabs">
              <div class="side-tab active">🌟 Popular</div>
              <div class="side-tab">🌅 Breakfast</div>
              <div class="side-tab">☀️ Lunch</div>
              <div class="side-tab">🧃 Drinks</div>
              <div class="side-tab">🍮 Desserts</div>
            </div>
            <div class="feature-grid">
              <?php foreach (array_slice(kantoeat_menu_items(), 0, 4) as $item): ?>
              <div class="menu-card">
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" loading="lazy">
                <div class="pad">
                  <h3><?= htmlspecialchars($item['name']) ?></h3>
                  <div class="meta">
                    <span><?= htmlspecialchars($item['category']) ?></span>
                    <span style="font-weight:700;color:var(--gold-dark)"><?= kantoeat_price($item['price']) ?></span>
                  </div>
                  <span class="badge <?= $item['sold_out'] ? 'red' : ($item['badge'] === "Today's Special" ? 'gold' : 'green') ?>">
                    <?= htmlspecialchars($item['badge']) ?>
                  </span>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <!-- Steam decoration -->
            <div style="display:flex;gap:20px;padding:14px 4px 0;justify-content:center;" aria-hidden="true">
              <?php for($i=0;$i<3;$i++): ?>
              <div style="position:relative;width:20px;height:30px;">
                <div class="steam-particle" style="width:9px;height:9px;position:absolute;bottom:0;left:5px;animation-delay:<?= $i*0.5 ?>s;"></div>
              </div>
              <?php endfor; ?>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ===== STATS BANNER ===== -->
  <section class="stats-section" aria-label="Platform statistics">
    <div class="container">
      <div class="stats-grid">
        <div class="stat-item reveal">
          <span class="stat-icon" aria-hidden="true">🏘️</span>
          <span class="stat-number" data-count="100">0</span>
          <span class="stat-label">+ Karinderyas</span>
        </div>
        <div class="stat-item reveal">
          <span class="stat-icon" aria-hidden="true">👥</span>
          <span class="stat-number" data-count="5000">0</span>
          <span class="stat-label">+ Happy Customers</span>
        </div>
        <div class="stat-item reveal">
          <span class="stat-icon" aria-hidden="true">🍽️</span>
          <span class="stat-number" data-count="20000">0</span>
          <span class="stat-label">+ Orders Served</span>
        </div>
        <div class="stat-item reveal">
          <span class="stat-icon" aria-hidden="true">⭐</span>
          <span class="stat-number">4.9</span>
          <span class="stat-label">Average Rating</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== FEATURED MEALS ===== -->
  <section class="section" id="featured" aria-label="Featured meals">
    <div class="container">
      <div class="section-head reveal">
        <div>
          <div class="kicker">🍽️ Today's Menu</div>
          <h2 class="section-title">Featured Meals</h2>
          <p class="section-subtitle">A fresh preview of today's karinderya menu. Hot, affordable, and made with love.</p>
        </div>
        <a class="btn btn-ghost" href="dashboard.php">See All →</a>
      </div>
      <div class="grid-cards">
        <?php
        $featured = array_filter(kantoeat_menu_items(), fn($i) => !empty($i['featured']));
        foreach ($featured as $item):
        ?>
        <a class="card-link reveal" href="food.php?id=<?= $item['id'] ?>" aria-label="View <?= htmlspecialchars($item['name']) ?>">
          <article class="food-card glass-panel">
            <div class="food-img-wrap">
              <span class="price-tag"><?= kantoeat_price($item['price']) ?></span>
              <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" loading="lazy">
            </div>
            <div class="content">
              <div class="meta">
                <span><?= htmlspecialchars($item['category']) ?></span>
                <span class="badge <?= $item['sold_out'] ? 'red' : ($item['badge'] === "Today's Special" ? 'gold' : 'green') ?>">
                  <?= htmlspecialchars($item['badge']) ?>
                </span>
              </div>
              <h3><?= htmlspecialchars($item['name']) ?></h3>
              <p class="muted"><?= htmlspecialchars($item['description']) ?></p>
              <div class="rating-row" aria-label="Rating">
                <span class="stars" aria-hidden="true">★★★★★</span>
                <span class="rating-text">(4.8)</span>
              </div>
            </div>
          </article>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ===== HOW IT WORKS ===== -->
  <section class="section how-section" id="how" aria-label="How Kanto Eat works">
    <div class="container">
      <div class="section-head reveal">
        <div>
          <div class="kicker kicker-green">🗺️ How It Works</div>
          <h2 class="section-title">Simple as 1, 2, 3</h2>
          <p class="section-subtitle">Finding and enjoying your next Filipino meal has never been easier.</p>
        </div>
      </div>
      <div class="how-grid">
        <div class="how-step reveal">
          <div class="how-step-num" aria-hidden="true">1</div>
          <span class="how-step-icon" role="img" aria-label="search">🔍</span>
          <h3>Browse Eateries</h3>
          <p>Search nearby karinderyas, filter by category — lutong bahay, noodles, desserts, drinks, and more.</p>
        </div>
        <div class="how-step reveal">
          <div class="how-step-num" aria-hidden="true">2</div>
          <span class="how-step-icon" role="img" aria-label="menu">🍽️</span>
          <h3>Check the Menu</h3>
          <p>See today's offerings, check prices, read descriptions, and add your favorites to your food tray.</p>
        </div>
        <div class="how-step reveal">
          <div class="how-step-num" aria-hidden="true">3</div>
          <span class="how-step-icon" role="img" aria-label="enjoy">🥰</span>
          <h3>Enjoy & Repeat</h3>
          <p>Place your order, pick it up, and enjoy authentic Filipino food. Kumain na tayo!</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== TESTIMONIALS ===== -->
  <section class="section testimonials-section" id="reviews" aria-label="Customer reviews">
    <div class="container">
      <div class="section-head reveal">
        <div>
          <div class="kicker">💬 What They Say</div>
          <h2 class="section-title">Happy Customers</h2>
          <p class="section-subtitle">Real students and faculty sharing their Kanto Eat experience.</p>
        </div>
      </div>
      <div class="testimonials-grid">
        <div class="testimonial-card reveal">
          <div class="testimonial-stars" aria-label="5 stars">★★★★★</div>
          <p class="testimonial-text">"Finally, I can check the menu before heading to the canteen! No more guessing what ulam is available. Kanto Eat changed my lunch break!"</p>
          <div class="testimonial-author">
            <div class="testimonial-avatar" aria-hidden="true">JD</div>
            <div>
              <div class="testimonial-name">Juan dela Cruz</div>
              <div class="testimonial-sub">FEU Student, BS IT</div>
            </div>
          </div>
        </div>
        <div class="testimonial-card reveal">
          <div class="testimonial-stars" aria-label="5 stars">★★★★★</div>
          <p class="testimonial-text">"As a faculty member, I love that I can see which eateries have adobo available. The student discount feature is a great touch for our students!"</p>
          <div class="testimonial-author">
            <div class="testimonial-avatar" aria-hidden="true">MS</div>
            <div>
              <div class="testimonial-name">Maria Santos</div>
              <div class="testimonial-sub">Faculty, Engineering</div>
            </div>
          </div>
        </div>
        <div class="testimonial-card reveal">
          <div class="testimonial-stars" aria-label="4 stars">★★★★☆</div>
          <p class="testimonial-text">"My eatery got so many more customers after listing on Kanto Eat. Mga estudyante nagsimulang pumunta nang may kaalaman sa aming menu!"</p>
          <div class="testimonial-author">
            <div class="testimonial-avatar" aria-hidden="true">AT</div>
            <div>
              <div class="testimonial-name">Aling Tessie</div>
              <div class="testimonial-sub">Karinderya Owner</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== ABOUT SECTION ===== -->
  <section class="section" id="about" aria-label="About Kanto Eat">
    <div class="container">
      <div class="about-section reveal">
        <div style="position:relative;">
          <div class="kicker" style="color:var(--gold-light);">🏘️ About Us</div>
          <h2 style="font-size:clamp(1.6rem,3vw,2.4rem);font-weight:800;color:var(--gold-light);margin-bottom:18px;line-height:1.2;">
            About Kanto Eat
          </h2>
          <p style="max-width:620px;margin-bottom:15px;color:rgba(255,253,245,0.80);font-size:1rem;line-height:1.75;">
            Kanto Eat is an FEU-inspired school karinderya web application that celebrates Filipino food culture and neighborhood carinderias through modern, clean design. We help small businesses that cannot afford expensive websites by giving them an affordable, modern online presence.
          </p>
          <p style="max-width:620px;margin-bottom:40px;color:rgba(255,253,245,0.80);font-size:1rem;line-height:1.75;">
            <strong>Our Main Goal:</strong> To bridge the gap between hungry students and local food vendors by providing a centralized platform where customers can easily browse daily menus, and karinderya owners can showcase their lutong bahay to a wider digital audience.
          </p>
          <div class="about-grid">
            <div class="about-feature">
              <span class="icon" role="img" aria-label="leaf">🌿</span>
              <h4>FEU Identity</h4>
              <p>FEU green and gold color palette throughout every page, celebrating school spirit and Filipino heritage.</p>
            </div>
            <div class="about-feature">
              <span class="icon" role="img" aria-label="design">✨</span>
              <h4>Modern Design</h4>
              <p>Clean, accessible, and elegant interface with glassmorphism and micro-animations for premium UX.</p>
            </div>
            <div class="about-feature">
              <span class="icon" role="img" aria-label="rice bowl">🍚</span>
              <h4>Lutong Bahay</h4>
              <p>Daily updated menu featuring authentic Filipino comfort food categories — from rice meals to desserts.</p>
            </div>
            <div class="about-feature">
              <span class="icon" role="img" aria-label="settings">⚙️</span>
              <h4>Owner Dashboard</h4>
              <p>Full CRUD management for menu items — add, edit, delete, and manage from any device, anywhere.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== CTA SECTION ===== -->
  <section class="section cta-section">
    <div class="container" style="position:relative;z-index:1;">
      <div class="reveal" style="text-align:center;">
        <div class="kicker" style="margin-bottom:20px;">🌟 Ready to Start?</div>
        <h2 class="section-title" style="margin-bottom:16px;">
          Your Next Favorite Ulam<br>Is Just a Click Away
        </h2>
        <p class="section-subtitle" style="margin: 0 auto 36px;">
          Create your free account and start browsing today's karinderya menu. Students get a ₱20 discount on every meal!
        </p>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
          <a class="btn btn-primary btn-xl btn-bounce" href="signup.php">🌿 Get Started Free</a>
          <a class="btn btn-outline-gold btn-xl" href="login.php">🔑 Sign In</a>
        </div>
      </div>
    </div>
  </section>

</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
