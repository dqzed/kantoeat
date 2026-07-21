<?php
require_once __DIR__ . '/../includes/data.php';
kantoeat_require_admin();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$item = kantoeat_get_item($id);
if (!$item) { header('Location: view_food.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    kantoeat_delete_item($id);
    header('Location: view_food.php?deleted=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Food | Kanto Eat</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>
<main class="page-wrap">
  <div class="container">
    <section class="auth-card">
      <span class="kicker">Admin</span>
      <h2>Delete food item</h2>
      <p class="muted">Are you sure you want to delete <strong><?php echo htmlspecialchars($item['name']); ?></strong>?</p>
      <div class="notice">This is a demo session-based delete action. The item will be removed from the current session menu list.</div>
      <form method="post" style="margin-top:18px; display:flex; gap:10px; flex-wrap:wrap;">
        <button class="btn btn-danger" type="submit">Yes, Delete</button>
        <a class="btn btn-ghost" href="view_food.php">Cancel</a>
      </form>
    </section>
  </div>
</main>
<script src="../js/script.js"></script>
</body>
</html>
