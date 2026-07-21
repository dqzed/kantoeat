<?php
require_once __DIR__ . '/../includes/data.php';

if (!kantoeat_is_logged_in() || !kantoeat_is_admin()) {
    header('Location: ../login.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $price    = floatval($_POST['price'] ?? 0);
    $category = trim($_POST['category'] ?? '');
    $image    = trim($_POST['image'] ?? '');
    $desc     = trim($_POST['description'] ?? '');
    $badge    = trim($_POST['badge'] ?? '');
    
    // Handle Image Upload
    if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../images/';
        // Ensure unique filename
        $fileName = time() . '_' . basename($_FILES['image_upload']['name']);
        $targetFile = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $targetFile)) {
            $image = 'images/' . $fileName;
        } else {
            $error = '⚠️ Failed to move uploaded image.';
        }
    }

    if (!$error && ($name === '' || $price <= 0 || $category === '' || $image === '')) {
        $error = '⚠️ Please fill in all required fields (Name, Price, Category, and provide an Image).';
    } elseif (!$error) {
        $id = time(); // simple unique ID
        kantoeat_save_item([
            'id'          => $id,
            'name'        => $name,
            'price'       => $price,
            'category'    => $category,
            'image'       => $image,
            'description' => $desc,
            'badge'       => $badge,
            'featured'    => true, // Make new items featured by default
            'sold_out'    => false
        ]);
        $success = "✅ Added '$name' successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Food | Admin | Kanto Eat</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="dashboard">

<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container shell">

  <aside class="sidebar">
    <h3>Admin Menu</h3>
    <nav>
      <a class="item" href="admin_dashboard.php">📊 Dashboard</a>
      <a class="item" href="view_food.php">🍔 View Menu Items</a>
      <a class="item active" href="add_food.php">➕ Add New Item</a>
    </nav>
  </aside>

  <section class="main-panel">
    <div class="reveal">
      <h2 style="font-size:2rem; color:var(--green-dark); margin-bottom:8px;">Add New Menu Item</h2>
      <p class="muted" style="margin-bottom:28px;">Fill in the details to add a new dish to the karinderya menu.</p>
    </div>

    <?php if ($error): ?>
      <div class="alert error reveal" role="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="alert success reveal" role="alert"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <!-- Two-column form layout: Image Preview (Left) + Form (Right) -->
    <div style="display:grid; grid-template-columns: minmax(200px, 1fr) 2fr; gap:36px; align-items:start;" class="reveal">
      
      <!-- Left: Live Preview -->
      <div style="position:sticky; top:120px;">
        <h4 style="font-size:0.85rem; color:var(--text-muted); text-transform:uppercase; margin-bottom:12px; letter-spacing:0.05em;">Live Preview</h4>
        <div class="food-card" style="pointer-events:none; cursor:default;">
          <div class="food-img-wrap">
            <span class="price-tag">₱0.00</span>
            <img id="img-preview" src="" alt="Preview" style="display:none;">
          </div>
          <div class="content">
            <div class="meta">
              <span id="preview-cat">Category</span>
              <span class="badge green" id="preview-badge" style="display:none;"></span>
            </div>
            <h3 id="preview-name">Item Name</h3>
            <p class="muted" id="preview-desc" style="font-size:0.75rem;">Description will appear here...</p>
          </div>
        </div>
      </div>

      <!-- Right: Form -->
      <form class="form-grid" method="post" id="add-food-form" enctype="multipart/form-data">
        
        <div class="field">
          <label for="name">Item Name <span style="color:var(--chili);">*</span></label>
          <input type="text" id="name" name="name" required placeholder="e.g. Pork Adobo">
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
          <div class="field">
            <label for="price">Price (₱) <span style="color:var(--chili);">*</span></label>
            <input type="number" step="0.01" id="price" name="price" required placeholder="0.00">
          </div>
          <div class="field">
            <label for="category">Category <span style="color:var(--chili);">*</span></label>
            <select id="category" name="category" required>
              <option value="">-- Select --</option>
              <option value="Breakfast">Breakfast</option>
              <option value="Meals">Meals</option>
              <option value="Lunch">Lunch</option>
              <option value="Snacks">Snacks / Street Food</option>
              <option value="Desserts">Desserts</option>
              <option value="Drinks">Drinks</option>
            </select>
          </div>
        </div>

        <div class="field" style="grid-column: 1 / -1;">
          <label>Food Image <span style="color:var(--chili);">*</span></label>
          <div style="display:flex; gap: 15px; align-items:center;">
            <input type="file" id="image_upload" name="image_upload" accept="image/*" style="flex:1;">
            <span class="muted">OR select existing:</span>
            <select id="image" name="image" style="flex:1;">
              <option value="">-- No existing image --</option>
              <option value="images/food-breakfast.svg">Breakfast SVG</option>
              <option value="images/food-rice.svg">Rice Meal SVG</option>
              <option value="images/food-lunch.svg">Lunch Box SVG</option>
              <option value="images/food-snacks.svg">Snacks SVG</option>
              <option value="images/food-dessert.svg">Dessert SVG</option>
              <option value="images/food-drink.svg">Drinks SVG</option>
            </select>
          </div>
          <small class="muted" style="margin-top:5px; display:block;">Upload a picture from your computer. If you upload a file, it will override the dropdown selection.</small>
        </div>

        <div class="field">
          <label for="badge">Badge Label (Optional)</label>
          <input type="text" id="badge" name="badge" placeholder="e.g. Best Seller, Today's Special">
        </div>

        <div class="field">
          <label for="description">Description</label>
          <textarea id="description" name="description" placeholder="Short appetizing description..."></textarea>
        </div>

        <div style="display:flex; gap:16px; margin-top:12px;">
          <button type="submit" class="btn btn-primary btn-lg btn-bounce" style="flex:1;">
            ➕ Save Item
          </button>
          <button type="reset" class="btn btn-ghost btn-lg">Reset</button>
        </div>

      </form>
    </div>

  </section>
</main>

<script src="../js/script.js"></script>
<script>
  // Live preview JS for admin Add/Edit form
  document.addEventListener('DOMContentLoaded', () => {
    const fName = document.getElementById('name');
    const fPrice = document.getElementById('price');
    const fCat = document.getElementById('category');
    const fDesc = document.getElementById('description');
    const fBadge = document.getElementById('badge');

    const pName = document.getElementById('preview-name');
    const pPrice = document.querySelector('.price-tag');
    const pCat = document.getElementById('preview-cat');
    const pDesc = document.getElementById('preview-desc');
    const pBadge = document.getElementById('preview-badge');

    function sync() {
      pName.textContent = fName.value.trim() || 'Item Name';
      pPrice.textContent = '₱' + (parseFloat(fPrice.value) || 0).toFixed(2);
      pCat.textContent = fCat.value || 'Category';
      pDesc.textContent = fDesc.value.trim() || 'Description will appear here...';
      
      const badgeVal = fBadge.value.trim();
      if(badgeVal) {
        pBadge.textContent = badgeVal;
        pBadge.style.display = 'inline-block';
      } else {
        pBadge.style.display = 'none';
      }
    }

    [fName, fPrice, fCat, fDesc, fBadge].forEach(el => {
      if(el) el.addEventListener('input', sync);
    });
    // For selects
    fCat?.addEventListener('change', sync);
  });
</script>
</body>
</html>
