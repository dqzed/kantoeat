<?php
require_once __DIR__ . '/../includes/data.php';
kantoeat_require_admin();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$item = kantoeat_get_item($id);
if (!$item) { header('Location: view_food.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item['name'] = trim($_POST['name'] ?? $item['name']);
    $item['category'] = trim($_POST['category'] ?? $item['category']);
    $item['price'] = (float)($_POST['price'] ?? $item['price']);
    $item['badge'] = trim($_POST['badge'] ?? $item['badge']);
    $item['description'] = trim($_POST['description'] ?? $item['description']);
    $item['ingredients'] = trim($_POST['ingredients'] ?? $item['ingredients']);
    $item['image'] = trim($_POST['image'] ?? $item['image']);
    $item['featured'] = isset($_POST['featured']);
    $item['sold_out'] = isset($_POST['sold_out']);
    kantoeat_save_item($item);
    header('Location: view_food.php?updated=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Food | Kanto Eat</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>
<main class="page-wrap">
  <div class="container">
    <section class="auth-card" style="width:min(100%,780px);">
      <span class="kicker">Admin</span>
      <h2>Edit food item</h2>
      <form class="form-grid" method="post">
        <div class="field"><label>Name</label><input name="name" value="<?php echo htmlspecialchars($item['name']); ?>" required></div>
        <div class="field"><label>Category</label>
          <select name="category">
            <?php foreach (['Breakfast','Lunch','Dinner','Snacks','Drinks','Desserts'] as $cat): ?>
              <option <?php echo $item['category'] === $cat ? 'selected' : ''; ?>><?php echo $cat; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field"><label>Price</label><input name="price" type="number" step="0.01" value="<?php echo htmlspecialchars($item['price']); ?>" required></div>
        <div class="field"><label>Badge</label>
          <select name="badge">
            <?php foreach (["Available","Today's Special","Sold Out"] as $badge): ?>
              <option <?php echo $item['badge'] === $badge ? 'selected' : ''; ?>><?php echo $badge; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field"><label>Image path</label><input name="image" value="<?php echo htmlspecialchars($item['image']); ?>"></div>
        <div class="field"><label>Description</label><textarea name="description" required><?php echo htmlspecialchars($item['description']); ?></textarea></div>
        <div class="field"><label>Ingredients</label><textarea name="ingredients" required><?php echo htmlspecialchars($item['ingredients']); ?></textarea></div>
        <div class="field"><label><input type="checkbox" name="featured" <?php echo !empty($item['featured']) ? 'checked' : ''; ?>> Featured meal</label></div>
        <div class="field"><label><input type="checkbox" name="sold_out" <?php echo !empty($item['sold_out']) ? 'checked' : ''; ?>> Sold out</label></div>
        <button class="btn btn-primary" type="submit">Update Food</button>
        <a class="btn btn-ghost" href="view_food.php">Back to Menu</a>
      </form>
    </section>
  </div>
</main>
<script src="../js/script.js"></script>
</body>
</html>
