<?php
require_once __DIR__ . '/includes/data.php';

if (kantoeat_is_logged_in()) {
    header(kantoeat_is_admin() ? 'Location: admin/admin_dashboard.php' : 'Location: dashboard.php');
    exit;
}

$error = '';
$role  = $_GET['role'] ?? 'customer';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role     = $_POST['role']     ?? 'customer';
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = '⚠️ Please fill in both email and password.';
    } else {
        if ($role === 'admin') {
            if ($email === 'admin@kantoeat.com' && $password === 'Admin123!') {
                kantoeat_set_user(['name' => 'Kanto Admin', 'email' => $email, 'role' => 'admin']);
                header('Location: admin/admin_dashboard.php');
                exit;
            }
            $error = '⚠️ Admin: use admin@kantoeat.com / Admin123!';
        } else {
            kantoeat_set_user(['name' => 'Guest Customer', 'email' => $email, 'role' => 'customer', 'student' => false]);
            header('Location: dashboard.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Login to Kanto Eat — Your gateway to the best Filipino karinderyas near you.">
  <title>Login | Kanto Eat</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include __DIR__ . '/includes/header.php'; ?>

<div class="login-split" style="padding-top:var(--header-h);">

  <!-- ===== LEFT: Illustration Panel ===== -->
  <div class="login-left" role="complementary" aria-label="Kanto Eat introduction">
    <div class="login-left-content">
      <div class="login-brand-big">Kanto Eat</div>
      <div class="login-brand-sub">🌿 FEU Karinderya Platform</div>

      <!-- Animated food -->
      <span class="login-food-float" role="img" aria-label="bowl of food">🍱</span>

      <!-- Floating ingredients -->
      <div class="login-floating-ingredients" aria-hidden="true">
        <span class="float-item" style="animation-duration:3s;animation-delay:0s;">🍚</span>
        <span class="float-item" style="animation-duration:4s;animation-delay:0.5s;">🥘</span>
        <span class="float-item" style="animation-duration:3.5s;animation-delay:1s;">🍜</span>
        <span class="float-item" style="animation-duration:5s;animation-delay:0.3s;">🥩</span>
        <span class="float-item" style="animation-duration:3.8s;animation-delay:0.8s;">🧃</span>
      </div>

      <blockquote class="login-quote">
        "Ang pagkain ay higit pa sa sustansiya — ito ay komunidad, kultura, at pamilya."
        <br><br>
        <em style="color:rgba(212,175,55,0.9);font-size:0.85rem;">Food is more than nourishment — it's community, culture, and family.</em>
      </blockquote>

      <div style="margin-top:32px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap;" aria-hidden="true">
        <span style="color:rgba(255,253,245,0.6);font-size:0.78rem;">🏘️ 100+ Karinderyas</span>
        <span style="color:rgba(255,253,245,0.4);">·</span>
        <span style="color:rgba(255,253,245,0.6);font-size:0.78rem;">👥 5,000+ Customers</span>
        <span style="color:rgba(255,253,245,0.4);">·</span>
        <span style="color:rgba(255,253,245,0.6);font-size:0.78rem;">🇵🇭 100% Filipino</span>
      </div>
    </div>
  </div>

  <!-- ===== RIGHT: Login Card ===== -->
  <div class="login-right">
    <div class="login-card-wrap">

      <div class="auth-card" id="login-card">
        <span class="kicker">🌿 Welcome Back</span>
        <h2>Login to<br>Kanto Eat</h2>
        <p class="muted">Use a customer login to browse the menu, or switch to admin for the management panel.</p>

        <?php if ($error): ?>
          <div class="alert error" role="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form class="form-grid" method="post" id="login-form" novalidate>

          <div class="field">
            <label for="role">Account Type</label>
            <select id="role" name="role" data-role-select aria-describedby="role-hint">
              <option value="customer" <?= $role==='customer' ? 'selected' : '' ?>>🧑 Customer</option>
              <option value="admin"    <?= $role==='admin'    ? 'selected' : '' ?>>⚙️ Administrator</option>
            </select>
          </div>

          <div class="notice" data-admin-note id="role-hint" style="<?= $role==='admin' ? '' : 'display:none;' ?>">
            Demo admin: <strong>admin@kantoeat.com</strong> / <strong>Admin123!</strong>
          </div>

          <div class="field">
            <label for="email">Email Address</label>
            <input
              id="email" name="email" type="email"
              placeholder="Enter your email"
              required
              autocomplete="email"
              aria-required="true"
            >
          </div>

          <div class="field">
            <label for="password">Password</label>
            <div class="pw-wrap">
              <input
                id="password" name="password" type="password"
                placeholder="Enter your password"
                required
                autocomplete="current-password"
                aria-required="true"
              >
              <button type="button" class="pw-toggle" title="Show password" aria-label="Toggle password visibility">👁️</button>
            </div>
          </div>

          <button id="login-submit" class="btn btn-primary btn-lg btn-bounce" type="submit" style="width:100%;justify-content:center;">
            🍚 Sign In
          </button>

          <div class="divider"></div>

          <div style="display:flex; gap:10px; flex-wrap:wrap; justify-content:center;">
            <a class="btn btn-ghost btn-sm" href="signup.php">📝 Create Account</a>
            <a class="btn btn-ghost btn-sm" href="index.php">🏠 Back to Home</a>
          </div>

        </form>
      </div>

    </div>
  </div>

</div>

<script src="js/script.js"></script>
</body>
</html>
