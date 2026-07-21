<?php
require_once __DIR__ . '/../includes/data.php';

if (!kantoeat_is_logged_in() || !kantoeat_is_admin()) {
    header('Location: ../login.php');
    exit;
}

$id   = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$item = kantoeat_get_item($id);

if (!$item) {
    header('Location: view_food.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    kantoeat_delete_item($id);
    header('Location: view_food.php?deleted=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Food | Admin | Kanto Eat</title>
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

  <section class="main-panel" style="max-width:700px;">
    
    <div class="admin-top reveal">
      <div>
        <span class="kicker" style="color:var(--chili); background:rgba(196,69,54,0.10); border-color:rgba(196,69,54,0.25);">⚠️ Danger Zone</span>
        <h2 style="font-size:2rem; color:var(--chili); margin-bottom:8px; line-height:1.2;">Delete Food Item</h2>
      </div>
      <a class="btn btn-ghost btn-sm" href="view_food.php">← Back</a>
    </div>

    <!-- Item preview -->
    <div class="reveal" style="display:flex; gap:20px; align-items:center; padding:24px; background:var(--cream); border-radius:var(--radius-lg); border:1px solid rgba(139,94,60,0.12); margin-bottom:24px; animation-delay:0.1s;">
      <img src="../<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>"
           style="width:80px;height:80px;object-fit:contain;background:linear-gradient(135deg, var(--cream), #EDE8D3);border-radius:12px;padding:8px;border:1px solid rgba(139,94,60,0.08);box-shadow:var(--shadow-sm);">
      <div>
        <strong style="font-size:1.1rem; color:var(--green-dark); display:block; margin-bottom:4px;"><?= htmlspecialchars($item['name']) ?></strong>
        <span class="muted" style="font-size:0.85rem;"><?= htmlspecialchars($item['category']) ?> &nbsp;·&nbsp; <?= kantoeat_price($item['price']) ?></span>
        <div style="margin-top:8px;">
          <span class="badge <?= $item['sold_out'] ? 'red' : 'green' ?>"><?= $item['sold_out'] ? 'Sold Out' : 'Available' ?></span>
        </div>
      </div>
    </div>

    <div class="reveal" style="background:rgba(196,69,54,0.06); border:1px solid rgba(196,69,54,0.25); border-radius:var(--radius-sm); padding:18px 24px; margin-bottom:28px; color:#8B2A20; font-size:0.95rem; line-height:1.6; animation-delay:0.2s;">
      ⚠️ Are you sure you want to delete <strong><?= htmlspecialchars($item['name']) ?></strong>?<br>
      This action will remove it from the karinderya menu immediately.
    </div>

    <form method="post" style="display:flex; gap:16px; flex-wrap:wrap;" class="reveal" style="animation-delay:0.3s;">
      <button class="btn btn-danger btn-lg btn-bounce" type="submit">🗑️ Yes, Delete It</button>
      <a class="btn btn-ghost btn-lg" href="view_food.php">No, Cancel</a>
    </form>

  </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<script src="../js/script.js"></script>
</body>
</html>
