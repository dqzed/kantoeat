<?php require_once __DIR__ . '/../includes/data.php'; kantoeat_require_admin(); $items = kantoeat_menu_items(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Food | Kanto Eat</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>
<main class="page-wrap">
  <div class="container">
    <section class="main-panel glass-panel">
      <div class="admin-top">
        <div>
          <span class="kicker">Admin</span>
          <h2 class="section-title">Manage food items</h2>
          <p class="section-subtitle">Add, edit, or delete menu items before the database phase.</p>
        </div>
        <a class="btn btn-primary" href="add_food.php">Add Food</a>
      </div>

      <?php if (isset($_GET['added'])): ?><div class="alert">Food item added successfully.</div><?php endif; ?>
      <?php if (isset($_GET['updated'])): ?><div class="alert">Food item updated successfully.</div><?php endif; ?>
      <?php if (isset($_GET['deleted'])): ?><div class="alert">Food item deleted successfully.</div><?php endif; ?>

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
