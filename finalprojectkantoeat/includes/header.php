<?php require_once __DIR__ . '/data.php';
$scriptDir  = str_replace('\\', '/', dirname($_SERVER['SCRIPT_FILENAME']));
$projectDir = str_replace('\\', '/', dirname(__DIR__));
$isInAdmin  = (strpos($scriptDir, $projectDir . '/admin') !== false);
$r          = $isInAdmin ? '../' : '';
?>
<!-- PAGE TRANSITION -->
<div id="page-transition" class="page-transition"></div>

<!-- FOOD TRAY BACKDROP -->
<div id="tray-backdrop" class="tray-backdrop"></div>

<!-- FOOD TRAY PANEL -->
<div id="tray-panel" class="tray-panel" role="dialog" aria-label="Food Tray" aria-modal="true">
  <div class="tray-header">
    <h3>Food Tray</h3>
    <button id="tray-close" class="tray-close" title="Close tray" aria-label="Close tray">✕</button>
  </div>
  <div id="tray-items" class="tray-items"></div>
  <div id="tray-empty" class="tray-empty">
    <span class="empty-icon" role="img" aria-label="empty plate">🍽️</span>
    <p>Your tray is empty.<br><small>Browse the menu and add your ulam!</small></p>
  </div>
  <div class="tray-footer">
    <div class="tray-total">
      <span>Total</span>
      <span id="tray-total">₱0.00</span>
    </div>
    <button id="checkout-btn" class="btn btn-gold btn-lg" style="width:100%; justify-content:center; gap:10px;">
      🛒 Place Order
    </button>
  </div>
</div>

<!-- SUCCESS OVERLAY -->
<div id="success-overlay" class="success-overlay" role="dialog" aria-label="Order placed" aria-modal="true">
  <div class="success-card">
    <span class="icon" role="img" aria-label="food box">🍱</span>
    <h2>Salamat!</h2>
    <p>Your order has been placed.<br>Enjoy your meal! 🌿</p>
    <button class="btn btn-primary btn-lg" onclick="document.getElementById('success-overlay').classList.remove('show')">
      Close
    </button>
  </div>
</div>

<!-- MAIN HEADER -->
<header class="site-header" id="site-header">
  <div class="container header-inner">

    <a class="brand" href="<?= $r ?>index.php" aria-label="Kanto Eat Home">
      <img class="brand-logo" src="<?= $r ?>images/logo.svg" alt="Kanto Eat logo" width="42" height="42">
      <div class="brand-name">
        Kanto Eat
        <span>FEU Karinderya</span>
      </div>
    </a>

    <nav class="site-nav" data-site-nav aria-label="Main navigation">
      <a href="<?= $r ?>index.php">Home</a>
      <a href="<?= $r ?>index.php#featured">Menu</a>
      <a href="<?= $r ?>index.php#about">About</a>
      <a href="<?= $r ?>index.php#contact">Contact</a>
      <?php if (kantoeat_is_logged_in() && !kantoeat_is_admin()): ?>
        <a href="<?= $r ?>dashboard.php">Browse</a>
      <?php endif; ?>
      <?php if (kantoeat_is_admin()): ?>
        <a href="<?= $r ?>admin/admin_dashboard.php">⚙️ Admin</a>
      <?php endif; ?>
    </nav>

    <div class="header-actions">
      <!-- Night/Day toggle -->
      <button id="night-btn" class="night-btn" title="Toggle dark mode" aria-label="Toggle dark mode">🌙</button>

      <?php if (kantoeat_is_logged_in() && !kantoeat_is_admin()): ?>
        <!-- Food tray button -->
        <button id="tray-btn" class="tray-btn" title="Open food tray" aria-label="Open food tray">
          🍽️
          <span id="tray-count" class="tray-count" aria-live="polite">0</span>
        </button>
      <?php endif; ?>

      <?php if (!kantoeat_is_logged_in()): ?>
        <a class="btn btn-ghost btn-sm" href="<?= $r ?>login.php">Login</a>
        <a class="btn btn-primary btn-sm" href="<?= $r ?>signup.php">Sign Up</a>
      <?php else: ?>
        <span class="user-pill"><?= htmlspecialchars(kantoeat_current_user()['name'] ?? 'Guest') ?></span>
        <a class="btn btn-ghost btn-sm" href="<?= $r ?>logout.php">Logout</a>
      <?php endif; ?>
    </div>

    <button class="nav-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false" data-nav-toggle>
      <span></span><span></span><span></span>
    </button>

  </div>
</header>
