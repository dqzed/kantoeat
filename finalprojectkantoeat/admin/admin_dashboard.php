<?php
require_once __DIR__ . '/../includes/data.php';

if (!kantoeat_is_logged_in() || !kantoeat_is_admin()) {
    header('Location: ../login.php');
    exit;
}

$user = kantoeat_current_user();
$items = kantoeat_menu_items();

// Count stats
$totalItems = count($items);
$soldOut = 0;
$specials = 0;
foreach ($items as $it) {
    if ($it['sold_out']) $soldOut++;
    if ($it['badge'] === "Today's Special") $specials++;
}
$available = $totalItems - $soldOut;

?>
<!DOCTYPE html>
<html lang="en" data-theme="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Kanto Eat</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="dashboard">

<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container shell">

  <!-- ADMIN SIDEBAR -->
  <aside class="sidebar">
    <h3>Admin Menu</h3>
    <nav>
      <a class="item active" href="admin_dashboard.php">📊 Dashboard</a>
      <a class="item" href="view_food.php">🍔 View Menu Items</a>
      <a class="item" href="add_food.php">➕ Add New Item</a>
    </nav>
    <div class="notice">
      💡 <strong>Admin Tip:</strong><br>
      Changes made here are applied instantly to the customer's menu.
    </div>
  </aside>

  <!-- MAIN ADMIN PANEL -->
  <section class="main-panel">
    
    <div class="admin-top reveal">
      <div>
        <h2 style="font-size:2rem; color:var(--green-dark); margin-bottom:6px; line-height:1.2;">Admin Dashboard</h2>
        <p class="muted" style="margin-bottom:0;">Manage your karinderya menu, check availability, and add specials.</p>
      </div>
      <div class="user-pill" style="align-self:flex-start;">
        <?= htmlspecialchars($user['name']) ?> (Admin)
      </div>
    </div>

    <!-- Stats Grid -->
    <div class="admin-grid reveal" style="animation-delay: 0.1s;">
      <div class="stat-card">
        <span class="stat-card-icon" aria-hidden="true">📋</span>
        <span>Total Items</span>
        <strong><?= $totalItems ?></strong>
      </div>
      <div class="stat-card">
        <span class="stat-card-icon" aria-hidden="true">✅</span>
        <span>Available Now</span>
        <strong><?= $available ?></strong>
      </div>
      <div class="stat-card">
        <span class="stat-card-icon" aria-hidden="true">🔴</span>
        <span>Sold Out</span>
        <strong><?= $soldOut ?></strong>
      </div>
      <div class="stat-card">
        <span class="stat-card-icon" aria-hidden="true">⭐</span>
        <span>Today's Specials</span>
        <strong><?= $specials ?></strong>
      </div>
    </div>

    <div class="reveal" style="animation-delay: 0.2s;">
      <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:20px;">
        <h3 style="font-size:1.2rem; color:var(--green-dark);">Recent Menu Items</h3>
        <a class="btn btn-gold btn-sm btn-bounce" href="add_food.php">➕ Add New</a>
      </div>

      <div class="table-list">
        <?php 
        // Show last 5 items
        $recent = array_slice(array_reverse($items), 0, 5);
        if (empty($recent)): ?>
          <div class="notice" style="text-align:center; padding:30px;">No items found. Add some!</div>
        <?php else: ?>
          <?php foreach ($recent as $idx => $it): ?>
          <div class="row-item" style="animation-delay: <?= $idx * 0.05 ?>s;">
            <img src="<?= htmlspecialchars($it['image']) ?>" alt="<?= htmlspecialchars($it['name']) ?>">
            <div>
              <strong><?= htmlspecialchars($it['name']) ?></strong>
              <small><?= htmlspecialchars($it['category']) ?> • <?= htmlspecialchars($it['description']) ?></small>
            </div>
            <div class="item-price"><?= kantoeat_price($it['price']) ?></div>
            <div>
              <span class="badge <?= $it['sold_out'] ? 'red' : 'green' ?>">
                <?= $it['sold_out'] ? 'Sold Out' : 'Available' ?>
              </span>
            </div>
            <div class="actions">
              <a class="btn btn-ghost btn-sm" href="edit_food.php?id=<?= $it['id'] ?>">Edit</a>
            </div>
          </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      
      <div style="margin-top:24px; text-align:center;">
        <a href="view_food.php" class="btn btn-ghost">View Full Menu →</a>
      </div>
    </div>

  </section>
</main>

<script src="../js/script.js"></script>
</body>
</html>
