<?php
require_once __DIR__ . '/includes/data.php';

// Must be logged in
if (!kantoeat_is_logged_in()) {
    header('Location: login.php');
    exit;
}
// If admin, they shouldn't use the customer dashboard
if (kantoeat_is_admin()) {
    header('Location: admin/admin_dashboard.php');
    exit;
}

$user  = kantoeat_current_user();
$items = kantoeat_menu_items();

// Search via GET
$searchQuery = $_GET['search'] ?? '';
if ($searchQuery !== '') {
    $searchLower = strtolower($searchQuery);
    $items = array_filter($items, function($i) use ($searchLower) {
        return strpos(strtolower($i['name']), $searchLower) !== false
            || strpos(strtolower($i['description']), $searchLower) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Kanto Eat Dashboard - Browse the karinderya menu">
  <title>Dashboard | Kanto Eat</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="dashboard">

<?php include __DIR__ . '/includes/header.php'; ?>

<main class="container shell">

  <!-- ===== SIDEBAR ===== -->
  <aside class="sidebar" role="complementary" aria-label="Filters and menu">
    <h3>Categories</h3>
    <nav aria-label="Category filters">
      <button class="item active" data-category-filter="all">
        🍽️ All Items <span><?= count(kantoeat_menu_items()) ?></span>
      </button>
      <?php
      // Get unique categories and count them
      $cats = [];
      foreach (kantoeat_menu_items() as $i) {
          $c = $i['category'];
          if (!isset($cats[$c])) $cats[$c] = 0;
          $cats[$c]++;
      }
      ksort($cats);
      // Map icons to categories
      $catIcons = [
          'Meals'    => '🍛',
          'Snacks'   => '🍢',
          'Drinks'   => '🥤',
          'Desserts' => '🍧',
          'Breakfast'=> '🌅',
          'Lunch'    => '☀️'
      ];
      foreach ($cats as $cName => $cCount):
          $icon = $catIcons[$cName] ?? '🥘';
      ?>
      <button class="item" data-category-filter="<?= htmlspecialchars($cName) ?>">
        <?= $icon ?> <?= htmlspecialchars($cName) ?> <span><?= $cCount ?></span>
      </button>
      <?php endforeach; ?>
    </nav>

    <div class="notice">
      💡 <strong>Did you know?</strong><br>
      You can filter the menu easily using the categories above or search bar.
    </div>
  </aside>

  <!-- ===== MAIN PANEL ===== -->
  <section class="main-panel" aria-label="Menu listing">

    <!-- Topbar (Search & Avatar) -->
    <div class="topbar">
      <div class="search" role="search" aria-label="Search menu items">
        <input 
          type="text" 
          placeholder="Search ulam, drinks, desserts..." 
          data-food-search 
          aria-label="Search items"
          value="<?= htmlspecialchars($searchQuery) ?>"
        >
      </div>
      <div class="user-box" aria-label="User info">
        <div style="text-align:right;">
          <strong style="display:block; font-size:0.9rem; color:var(--green-dark);">
            <?= htmlspecialchars($user['name'] ?? 'User') ?>
          </strong>
          <span style="font-size:0.75rem; color:var(--text-muted);">Customer</span>
        </div>
        <div class="avatar" aria-hidden="true" title="<?= htmlspecialchars($user['name'] ?? 'User') ?>"></div>
      </div>
    </div>

    <!-- Welcome Banner -->
    <div class="welcome-banner reveal">
      <div class="banner-icon" aria-hidden="true">👋</div>
      <div class="banner-text">
        <h2>Kamusta, <?= htmlspecialchars(explode(' ', $user['name'] ?? 'User')[0]) ?>!</h2>
        <p>What are you craving today? Check out our freshly cooked lutong bahay.</p>
        <?php if (!empty($user['student'])): ?>
          <span class="student-badge">🎓 Student Verified • ₱20 Discount Applied</span>
        <?php endif; ?>
      </div>
    </div>

    <!-- Mobile Category Chips (mirrors sidebar) -->
    <div class="category-row reveal" style="animation-delay: 0.1s;" aria-label="Quick category filters">
      <button class="category-chip active" data-category-filter="all">All</button>
      <?php foreach (array_keys($cats) as $cName): ?>
      <button class="category-chip" data-category-filter="<?= htmlspecialchars($cName) ?>"><?= htmlspecialchars($cName) ?></button>
      <?php endforeach; ?>
    </div>

    <!-- Grid -->
    <div class="grid-cards" id="menu-grid" aria-live="polite">
      <?php if (empty($items)): ?>
        <div style="grid-column: 1 / -1; padding: 48px; text-align: center; color: var(--text-muted);">
          <span style="font-size:3rem;display:block;margin-bottom:16px;">🔍</span>
          <p>No items match your search. Try a different keyword!</p>
          <a href="dashboard.php" class="btn btn-ghost" style="margin-top:16px;">Clear Search</a>
        </div>
      <?php else: ?>
        <?php foreach ($items as $idx => $item): 
          // Delay reveal for the first few items
          $revealDelay = min($idx * 0.05, 0.5);
        ?>
        <article class="food-card reveal" style="animation-delay: <?= $revealDelay ?>s;"
                 data-food-card 
                 data-id="<?= $item['id'] ?>"
                 data-category="<?= htmlspecialchars($item['category']) ?>"
                 data-name="<?= htmlspecialchars($item['name']) ?>"
                 data-price="<?= $item['price'] ?>">
          
          <a href="food.php?id=<?= $item['id'] ?>" style="text-decoration:none; color:inherit; display:block; height:100%;">
            <div class="food-img-wrap">
              <span class="price-tag"><?= kantoeat_price($item['price']) ?></span>
              <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" loading="lazy">
            </div>
            <div class="content">
              <div class="meta">
                <span><?= htmlspecialchars($item['category']) ?></span>
                <?php if ($item['badge']): ?>
                  <span class="badge <?= $item['sold_out'] ? 'red' : ($item['badge'] === "Today's Special" ? 'gold' : 'green') ?>">
                    <?= htmlspecialchars($item['badge']) ?>
                  </span>
                <?php endif; ?>
              </div>
              <h3><?= htmlspecialchars($item['name']) ?></h3>
              <p class="muted"><?= htmlspecialchars($item['description']) ?></p>
              
              <div class="rating-row" aria-label="Rating">
                <span class="stars" aria-hidden="true">★★★★★</span>
                <span class="rating-text">(4.8)</span>
              </div>
            </div>
          </a>

          <!-- Floating Add to Tray Button -->
          <button class="add-tray-btn" <?= $item['sold_out'] ? 'disabled style="background:var(--text-muted);cursor:not-allowed;"' : '' ?> aria-label="Add <?= htmlspecialchars($item['name']) ?> to tray">
            <?= $item['sold_out'] ? 'Sold Out' : '➕ Add to Tray' ?>
          </button>
        </article>
        <?php endforeach; ?>
      <?php endif; ?>

      <!-- Empty state (handled by JS filter) -->
      <div id="empty-search" style="display:none; grid-column: 1 / -1; padding: 48px; text-align: center; color: var(--text-muted);">
        <span style="font-size:3rem;display:block;margin-bottom:16px;">🔍</span>
        <p>We couldn't find any items matching your filter.</p>
        <button class="btn btn-ghost" style="margin-top:16px;" onclick="document.querySelector('[data-category-filter=\'all\']').click()">Show All Items</button>
      </div>

    </div>

  </section>

</main>

<script src="js/script.js"></script>
</body>
</html>
