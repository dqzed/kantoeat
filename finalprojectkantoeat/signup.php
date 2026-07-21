<?php
require_once __DIR__ . '/includes/data.php';

if (kantoeat_is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']     ?? '');
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Student specifics
    $is_student = ($_POST['student_status'] ?? 'no') === 'yes';
    $student_no = trim($_POST['student_number'] ?? '');

    if ($name === '' || $email === '' || $password === '') {
        $error = '⚠️ Name, email, and password are required.';
    } elseif ($is_student && $student_no === '') {
        $error = '⚠️ Please enter your FEU Student Number.';
    } else {
        // In this demo, just set the session
        kantoeat_set_user([
            'name'       => $name,
            'email'      => $email,
            'role'       => 'customer',
            'student'    => $is_student,
            'student_no' => $student_no
        ]);
        // Instead of instant redirect, we can show a success message or just redirect to dashboard
        header('Location: dashboard.php?welcome=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sign up for Kanto Eat — Create an account to browse local Filipino karinderyas.">
  <title>Sign Up | Kanto Eat</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include __DIR__ . '/includes/header.php'; ?>

<div class="login-split" style="padding-top:var(--header-h);">

  <!-- ===== LEFT: Illustration Panel (Flipped colors for variation) ===== -->
  <div class="login-left" style="background: linear-gradient(135deg, var(--gold-dark) 0%, var(--gold) 60%, var(--gold-light) 100%);" role="complementary" aria-label="Join Kanto Eat">
    <div class="login-left-content">
      <div class="login-brand-big" style="color:var(--green-dark);">Kanto Eat</div>
      <div class="login-brand-sub" style="color:rgba(30,86,49,0.8);">🍽️ Join the Karinderya Community</div>

      <!-- Animated food -->
      <span class="login-food-float" role="img" aria-label="dessert">🍧</span>

      <!-- Floating ingredients -->
      <div class="login-floating-ingredients" aria-hidden="true">
        <span class="float-item" style="animation-duration:3.2s;animation-delay:0.2s;">☕</span>
        <span class="float-item" style="animation-duration:4.1s;animation-delay:0.7s;">🍮</span>
        <span class="float-item" style="animation-duration:3.4s;animation-delay:0s;">🥚</span>
        <span class="float-item" style="animation-duration:4.5s;animation-delay:0.5s;">🍡</span>
        <span class="float-item" style="animation-duration:3.7s;animation-delay:0.9s;">🍗</span>
      </div>

      <blockquote class="login-quote" style="background:rgba(30,86,49,0.06); border-color:rgba(30,86,49,0.15); color:var(--green-dark);">
        "Tamang tama para sa pananghalian! Register to get access to today's best lutong bahay."
        <br><br>
        <strong style="font-size:0.9rem;">— Students get ₱20 OFF on specific meals!</strong>
      </blockquote>
      
      <div style="margin-top:32px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap;" aria-hidden="true">
        <span style="color:rgba(30,86,49,0.7);font-size:0.78rem;">🎓 Student Discounts</span>
        <span style="color:rgba(30,86,49,0.5);">·</span>
        <span style="color:rgba(30,86,49,0.7);font-size:0.78rem;">📲 Easy Ordering</span>
        <span style="color:rgba(30,86,49,0.5);">·</span>
        <span style="color:rgba(30,86,49,0.7);font-size:0.78rem;">🍲 Fresh Daily Menu</span>
      </div>
    </div>
  </div>

  <!-- ===== RIGHT: Signup Card ===== -->
  <div class="login-right">
    <div class="login-card-wrap">

      <div class="auth-card" id="login-card">
        <span class="kicker">✨ Create Account</span>
        <h2>Join Kanto Eat</h2>
        <p class="muted">Fill in your details to start browsing local karinderya menus.</p>

        <?php if ($error): ?>
          <div class="alert error" role="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
          <div class="alert success" role="alert"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form class="form-grid" method="post" id="signup-form" novalidate>

          <div class="field">
            <label for="name">Full Name</label>
            <input 
              id="name" name="name" type="text" 
              placeholder="e.g., Juan dela Cruz" 
              required
              autocomplete="name"
              aria-required="true"
            >
          </div>

          <div class="field">
            <label for="email">Email Address</label>
            <input 
              id="email" name="email" type="email" 
              placeholder="e.g., juan@example.com" 
              required
              autocomplete="email"
              aria-required="true"
            >
          </div>

          <div class="field">
            <label for="password">Create Password</label>
            <div class="pw-wrap">
              <input 
                id="password" name="password" type="password" 
                placeholder="At least 8 characters" 
                required
                autocomplete="new-password"
                aria-required="true"
              >
              <button type="button" class="pw-toggle" title="Show password" aria-label="Toggle password visibility">👁️</button>
            </div>
            <!-- Password strength meter -->
            <div style="margin-top:6px; display:flex; align-items:center; gap:10px;">
              <div style="flex:1; height:6px; background:#e0e0e0; border-radius:3px; overflow:hidden;">
                <div id="pw-strength" style="height:100%; width:0%; background:#C44536; transition:width 0.3s, background 0.3s;"></div>
              </div>
              <span id="pw-strength-label" style="font-size:0.7rem; font-weight:600; width:45px; text-align:right; color:var(--text-secondary);"></span>
            </div>
          </div>

          <fieldset class="field" style="border:none; padding:10px 0 0; margin-top:5px;">
            <legend style="font-size:0.85rem; font-weight:600; color:var(--green-dark); margin-bottom:8px;">Are you an FEU Student?</legend>
            <div style="display:flex; gap:20px;">
              <label style="display:flex; align-items:center; gap:6px; font-weight:500; cursor:pointer;">
                <input type="radio" name="student_status" value="yes" style="width:auto; margin:0;" checked> Yes, I am
              </label>
              <label style="display:flex; align-items:center; gap:6px; font-weight:500; cursor:pointer;">
                <input type="radio" name="student_status" value="no" style="width:auto; margin:0;"> No, I'm not
              </label>
            </div>
          </fieldset>

          <div class="field" id="student-field" data-student-field>
            <label for="student_number">FEU Student Number <span style="color:var(--text-muted);font-weight:400;">(for ₱20 discount)</span></label>
            <input 
              id="student_number" name="student_number" type="text" 
              placeholder="e.g., 2024-123456"
              data-student-number
            >
          </div>

          <button class="btn btn-gold btn-lg btn-bounce" type="submit" style="width:100%;justify-content:center;margin-top:10px;">
            🎉 Register Now
          </button>

          <div class="divider"></div>

          <div style="display:flex; gap:10px; flex-wrap:wrap; justify-content:center;">
            <a class="btn btn-ghost btn-sm" href="login.php">🔑 Sign In instead</a>
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
