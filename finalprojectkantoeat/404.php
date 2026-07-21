<?php
// Simple 404 page for Kanto Eat
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en" data-theme="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Page Not Found | Kanto Eat</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="page-body">

<?php 
// Include header (we need to make sure paths are correct, assuming this is in root)
require_once __DIR__ . '/includes/data.php'; 
include __DIR__ . '/includes/header.php'; 
?>

<main class="error-page">
  <div class="error-content reveal">
    <div class="error-code">404</div>
    <span class="error-emoji" role="img" aria-label="empty plate">🍽️</span>
    <h2>Naku! Nasan na yung page?</h2>
    <p>We couldn't find the page you're looking for. It might have been moved, deleted, or you just took a wrong turn at the kanto.</p>
    
    <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
      <a href="index.php" class="btn btn-primary btn-lg btn-bounce">🏠 Back to Home</a>
      <?php if (kantoeat_is_logged_in() && !kantoeat_is_admin()): ?>
        <a href="dashboard.php" class="btn btn-gold btn-lg">🍛 Browse Menu</a>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
