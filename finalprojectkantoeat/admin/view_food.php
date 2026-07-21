<?php
require_once __DIR__ . '/../includes/data.php';

if (!kantoeat_is_logged_in() || !kantoeat_is_admin()) {
    header('Location: ../login.php');
    exit;
}

$items = kantoeat_menu_items();

// Simple GET search filter
$search = $_GET['search'] ?? '';
if ($search !== '') {
    $searchLower = strtolower($search);
    $items = array_filter($items, function($i) use ($searchLower) {
        return strpos(strtolower($i['name']), $searchLower) !== false
            || strpos(strtolower($i['category']), $searchLower) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Food | Admin | Kanto Eat</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="dashboard">

<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container shell">

  <aside class="sidebar">
    <h3>Admin Menu</h3>
    <nav>
      <a class="item" href="admin_dashboard.php">📊 Dashboard</a>
      <a class="item active" href="view_food.php">🍔 View Menu Items</a>
      <a class="item" href="add_food.php">➕ Add New Item</a>
    </nav>
  </aside>

  <section class="main-panel">
    
    <div class="admin-top reveal">
      <div>
        <h2 style="font-size:2rem; color:var(--green-dark); margin-bottom:8px;">Menu Items</h2>
        <p class="muted" style="margin-bottom:0;">Manage all dishes available in the karinderya.</p>
      </div>
      <a class="btn btn-gold btn-bounce" href="add_food.php">➕ Add New Dish</a>
    </div>

    <!-- Search/Filter Bar -->
    <div class="topbar reveal" style="animation-delay: 0.1s; margin-bottom:24px;">
      <form method="get" class="search" style="max-width:400px; margin:0;" role="search">
        <input 
          type="text" 
          name="search" 
          placeholder="Search by name or category..." 
          value="<?= htmlspecialchars($search) ?>"
        >
      </form>
      <?php if ($search !== ''): ?>
        <a href="view_food.php" class="btn btn-ghost btn-sm">Clear Search</a>
      <?php endif; ?>
    </div>

    <div class="table-list reveal" style="animation-delay: 0.2s;">
      <?php if (empty($items)): ?>
        <div class="notice" style="text-align:center; padding:40px;">
          <span style="font-size:2rem; display:block; margin-bottom:10px;">🔍</span>
          No menu items found.
        </div>
      <?php else: ?>
        <?php foreach (array_reverse($items) as $idx => $it): ?>
        <div class="row-item" style="animation-delay: <?= $idx * 0.04 ?>s;">
          <img src="../<?= htmlspecialchars($it['image']) ?>" alt="<?= htmlspecialchars($it['name']) ?>">
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
            <a class="btn btn-danger btn-sm" href="delete_food.php?id=<?= $it['id'] ?>" onclick="return confirm('Delete <?= htmlspecialchars($it['name']) ?>?');">Delete</a>
          </div>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </section>
</main>

<script src="../js/script.js"></script>
</body>
</html>
