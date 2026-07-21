<?php
require_once __DIR__ . '/../includes/data.php';
kantoeat_require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item = [
        'id' => kantoeat_next_id(),
        'name' => trim($_POST['name'] ?? ''),
        'category' => trim($_POST['category'] ?? 'Lunch'),
        'price' => (float)($_POST['price'] ?? 0),
        'badge' => trim($_POST['badge'] ?? 'Available'),
        'description' => trim($_POST['description'] ?? ''),
        'ingredients' => trim($_POST['ingredients'] ?? ''),
        'image' => trim($_POST['image'] ?? '../images/food-rice.svg'),
        'featured' => isset($_POST['featured']),
        'sold_out' => isset($_POST['sold_out']),
    ];
    if ($item['name'] !== '') {
        kantoeat_save_item($item);
        header('Location: view_food.php?added=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Food | Kanto Eat</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>
<main class="page-wrap">
  <div class="container">
    <section class="auth-card" style="width:min(100%,780px);">
      <span class="kicker">Admin</span>
      <h2>Add a food item</h2>
      <form class="form-grid" method="post">
        <div class="field"><label>Name</label><input name="name" required></div>
        <div class="field"><label>Category</label>
          <select name="category">
            <option>Breakfast</option><option>Lunch</option><option>Dinner</option><option>Snacks</option><option>Drinks</option><option>Desserts</option>
          </select>
        </div>
        <div class="field"><label>Price</label><input name="price" type="number" step="0.01" required></div>
        <div class="field"><label>Badge</label>
          <select name="badge"><option>Available</option><option>Today's Special</option><option>Sold Out</option></select>
        </div>
        <div class="field"><label>Image path</label><input name="image" value="../images/food-rice.svg"></div>
        <div class="field"><label>Description</label><textarea name="description" required></textarea></div>
        <div class="field"><label>Ingredients</label><textarea name="ingredients" required></textarea></div>
        <div class="field"><label><input type="checkbox" name="featured"> Featured meal</label></div>
        <div class="field"><label><input type="checkbox" name="sold_out"> Sold out</label></div>
        <button class="btn btn-primary" type="submit">Save Food</button>
        <a class="btn btn-ghost" href="admin_dashboard.php">Back to Dashboard</a>
      </form>
    </section>
  </div>
</main>
<script src="../js/script.js"></script>
</body>
</html>
