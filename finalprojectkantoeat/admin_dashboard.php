<?php require_once __DIR__ . '/../includes/data.php'; kantoeat_require_admin(); $items = kantoeat_menu_items(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Kanto Eat</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container header-inner">
    <a class="brand" href="../index.php"><img src="../images/logo.svg" alt="Kanto Eat"></a>
    <div class="header-actions" style="margin-left:auto;">
      <span class="user-pill">Admin Panel</span>
      <a class="btn btn-ghost" href="../logout.php">Logout</a>
    </div>
  </div>
</header>

<main class="dashboard">
  <div class="container shell">
    <aside class="sidebar glass-panel">
      <h3>Admin Menu</h3>
      <a class="active" href="admin_dashboard.php">Dashboard</a>
      <a href="view_food.php">Manage Menu</a>
      <a href="add_food.php">Add Food</a>
      <a href="view_food.php">Edit Food</a>
      <a href="view_food.php">Delete Food</a>
      <a href="view_food.php">Today's Menu</a>
      <a href="view_food.php">Orders</a>
      <a href="view_food.php">Users</a>
      <a href="../logout.php">Logout</a>
    </aside>

    <section class="main-panel glass-panel">
      <div class="admin-top">
        <div>
          <span class="kicker">Administrator</span>
          <h2 class="section-title">Kanto Eat Control Center</h2>
          <p class="section-subtitle">Manage the daily canteen menu from a simple FEU-inspired dashboard.</p>
        </div>
        <a class="btn btn-primary" href="add_food.php">Add Food</a>
      </div>

      <div class="admin-grid">
        <div class="stat-card"><span>Menu Items</span><strong><?php echo count($items); ?></strong></div>
        <div class="stat-card"><span>Available</span><strong><?php echo count(array_filter($items, fn($i) => empty($i['sold_out']))); ?></strong></div>
        <div class="stat-card"><span>Sold Out</span><strong><?php echo count(array_filter($items, fn($i) => !empty($i['sold_out']))); ?></strong></div>
        <div class="stat-card"><span>Categories</span><strong><?php echo count(array_unique(array_column($items, 'category'))); ?></strong></div>
      </div>

      <div class="table-list">
        <?php foreach ($items as $item): ?>
          <div class="row-item">
            <img src="../<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
            <div>
              <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
              <small class="muted"><?php echo htmlspecialchars($item['description']); ?></small>
            </div>
            <div><?php echo htmlspecialchars($item['category']); ?></div>
            <div><?php echo kantoeat_price($item['price']); ?></div>
            <div class="actions">
              <a class="btn btn-ghost" href="add_food.php">Add</a>
              <a class="btn btn-primary" href="edit_food.php?id=<?php echo $item['id']; ?>">Edit</a>
              <a class="btn btn-danger" href="delete_food.php?id=<?php echo $item['id']; ?>">Delete</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  </div>
</main>
<script src="../js/script.js"></script>
</body>
</html>
