<?php
require_once __DIR__ . '/includes/data.php';
kantoeat_require_login();

$id       = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$item     = kantoeat_get_item($id);
if (!$item) {
    $all  = kantoeat_menu_items();
    $item = !empty($all) ? reset($all) : null;
}
if (!$item) { header('Location: dashboard.php'); exit; }
$user = kantoeat_current_user();
?>
<!DOCTYPE html>
<html lang="en" data-theme="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($item['name']) ?> — Kanto Eat karinderya menu.">
  <title><?= htmlspecialchars($item['name']) ?> | Kanto Eat</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="page-body">

<?php include __DIR__ . '/includes/header.php'; ?>

<main class="page-wrap">
  <div class="container" style="padding-top:20px;">

    <!-- Breadcrumb -->
    <nav style="margin-bottom:20px; font-size:0.82rem; color:var(--bamboo-light); display:flex; align-items:center; gap:6px;">
      <a href="index.php" style="color:var(--green);">Home</a> ›
      <a href="dashboard.php" style="color:var(--green);">Menu</a> ›
      <span><?= htmlspecialchars($item['name']) ?></span>
    </nav>

    <div class="detail-layout" data-food-card data-id="<?= $item['id'] ?>" data-name="<?= htmlspecialchars($item['name']) ?>" data-price="<?= $item['price'] ?>" data-category="<?= htmlspecialchars($item['category']) ?>">

      <!-- Food image card -->
      <div class="detail-card detail-image reveal-left">
        <!-- Steam -->
        <div class="detail-steam" style="bottom:30px;">
          <div class="steam-particle" style="width:12px;height:12px;position:relative;animation-delay:0s;"></div>
          <div class="steam-particle" style="width:10px;height:10px;position:relative;animation-delay:0.6s;"></div>
          <div class="steam-particle" style="width:8px;height:8px;position:relative;animation-delay:1.2s;"></div>
        </div>
        <img class="food-img" src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">

        <!-- Badge overlay -->
        <div style="position:absolute; top:16px; left:16px;">
          <span class="badge <?= $item['sold_out'] ? 'red' : ($item['badge'] === "Today's Special" ? 'gold' : 'green') ?>" style="font-size:0.72rem; padding:5px 12px;">
            <?= htmlspecialchars($item['badge']) ?>
          </span>
        </div>
      </div>

      <!-- Food details card -->
      <div class="detail-card detail-content reveal-right">

        <span class="kicker">🍽️ <?= htmlspecialchars($item['category']) ?></span>
        <h2><?= htmlspecialchars($item['name']) ?></h2>
        <p class="muted"><?= htmlspecialchars($item['description']) ?></p>

        <!-- Price -->
        <div style="display:flex; align-items:baseline; gap:12px; margin:16px 0;">
          <span class="price"><?= kantoeat_price($item['price']) ?></span>
          <?php if (!empty($user['student'])): ?>
            <span style="font-size:0.78rem; color:var(--leaf); background:rgba(106,168,79,0.10); padding:3px 10px; border-radius:10px; border:1px solid rgba(106,168,79,0.25);">
              🎓 ₱<?= number_format($item['price'] - 20, 2) ?> with student discount
            </span>
          <?php endif; ?>
        </div>

        <?php if (!empty($user['student'])): ?>
          <div class="notice">🎓 Student discount of ₱20 is applied at checkout!</div>
        <?php else: ?>
          <div class="notice">💡 Verified students receive a ₱20 discount. <a href="signup.php" style="color:var(--gold);">Register as student →</a></div>
        <?php endif; ?>

        <!-- Ingredients -->
        <h3 style="font-family:'Press Start 2P',monospace; font-size:0.52rem; color:var(--green); margin:20px 0 10px; line-height:1.8;">🌿 Ingredients</h3>
        <ul class="list">
          <?php foreach (explode(',', $item['ingredients']) as $ing): ?>
            <li><?= htmlspecialchars(trim($ing)) ?></li>
          <?php endforeach; ?>
        </ul>

        <!-- Status -->
        <div style="display:flex; align-items:center; gap:10px; margin-bottom:24px;">
          <span style="font-size:0.82rem; color:var(--bamboo);">Status:</span>
          <span class="badge <?= $item['sold_out'] ? 'red' : ($item['badge'] === "Today's Special" ? 'gold' : 'green') ?>">
            <?= htmlspecialchars($item['badge']) ?>
          </span>
        </div>

        <!-- Action buttons -->
        <div style="display:flex; gap:12px; flex-wrap:wrap;">
          <?php if (!$item['sold_out']): ?>
            <button class="btn btn-primary btn-lg add-tray-btn btn-bounce" style="--img:'<?= htmlspecialchars($item['image']) ?>';">
              🍽️ Add to Food Tray
            </button>
          <?php else: ?>
            <button class="btn btn-ghost btn-lg" disabled style="opacity:0.5;cursor:not-allowed;">❌ Sold Out</button>
          <?php endif; ?>
          <a class="btn btn-ghost btn-lg" href="dashboard.php" style="z-index: 10;">← Back to Menu</a>
        </div>

      </div>
    </div>

    <!-- Related meals -->
    <?php
    $related = array_filter(kantoeat_menu_items(), fn($i) => $i['category'] === $item['category'] && $i['id'] !== $item['id']);
    $related = array_slice($related, 0, 3);
    if (!empty($related)):
    ?>
    <div style="margin-top:48px;">
      <div class="section-head reveal">
        <div>
          <div class="kicker">🌿 More Like This</div>
          <h2 class="section-title">Other <?= htmlspecialchars($item['category']) ?> Items</h2>
        </div>
      </div>
      <div class="grid-cards">
        <?php foreach ($related as $rel): ?>
        <a class="card-link reveal" href="food.php?id=<?= $rel['id'] ?>">
          <article class="food-card">
            <div class="food-img-wrap">
              <span class="price-tag"><?= kantoeat_price($rel['price']) ?></span>
              <img src="<?= htmlspecialchars($rel['image']) ?>" alt="<?= htmlspecialchars($rel['name']) ?>">
            </div>
            <div class="content">
              <div class="meta">
                <span><?= htmlspecialchars($rel['category']) ?></span>
                <span class="badge <?= $rel['sold_out'] ? 'red' : 'green' ?>"><?= htmlspecialchars($rel['badge']) ?></span>
              </div>
              <h3><?= htmlspecialchars($rel['name']) ?></h3>
              <p class="muted"><?= htmlspecialchars($rel['description']) ?></p>
            </div>
          </article>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
