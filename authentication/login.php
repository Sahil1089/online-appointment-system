<?php
// /c:/xampp/htdocs/hospital/authentication/login.php
session_start();

// Simple CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}

$errors = [];
$success = '';
$action = $_GET['action'] ?? 'login';
$email = '';

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic CSRF check
    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $errors[] = 'Invalid request. Please try again.';
    } else {
        $postedAction = $_POST['form_action'] ?? 'login';

        if ($postedAction === 'login') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validation
            if ($email === '') {
                $errors[] = 'Email is required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address.';
            }

            if ($password === '') {
                $errors[] = 'Password is required.';
            } elseif (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters.';
            }

            // If no validation errors, simulate successful login (replace with real auth)
            if (empty($errors)) {
                // NOTE: Here you'd normally verify the password against a database.
                $success = 'Login successful. (This is a frontend-only demo — replace with real authentication.)';
                // Optionally set a session user
                $_SESSION['user'] = $email;
            }
        } elseif ($postedAction === 'forgot') {
            $email = trim($_POST['email'] ?? '');
            if ($email === '') {
                $errors[] = 'Email is required for password reset.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address.';
            } else {
                // Simulate sending reset email
                $success = 'If that email exists in our system, a password reset link has been sent.';
            }
            // Show the forgot form again if errors occurred
            if (empty($errors)) {
                $action = 'login';
            } else {
                $action = 'forgot';
            }
        } else {
            $errors[] = 'Unknown form action.';
        }
    }
}

// Helper to escape output
function e($v) {
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; background:#f5f7fb; color:#222; padding:40px; }
        .card { max-width:420px; margin:0 auto; background:#fff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,.1); padding:24px; }
        h2 { margin-top:0; }
        .field { margin-bottom:12px; }
        label { display:block; font-size:14px; margin-bottom:6px; }
        input[type="email"], input[type="password"] { width:100%; padding:10px; border:1px solid #ccd6e3; border-radius:4px; box-sizing:border-box; }
        .btn { display:inline-block; padding:10px 14px; background:#0b74de; color:#fff; border:none; border-radius:4px; cursor:pointer; text-decoration:none; }
        .muted { color:#6b7280; font-size:13px; }
        .errors { background:#fff4f4; border:1px solid #f1c0c0; color:#9d2b2b; padding:10px; margin-bottom:12px; border-radius:4px; }
        .success { background:#f2fff4; border:1px solid #b9e6bd; color:#26723a; padding:10px; margin-bottom:12px; border-radius:4px; }
        .footer-links { margin-top:12px; display:flex; justify-content:space-between; align-items:center; }
        a { color:#0b74de; text-decoration:none; }
    </style>
</head>
<body>
    <div class="card"  style="position:relative;">
        <?php if ($action === 'login'): ?>
            <h2>Login</h2>  
            <button style="position:absolute; padding:12px;border:none; border-radius:4px; cursor:pointer; text-decoration:none; color:black;
            right:16px;top:16px;"class="btn-primary"><a href="../home.php">Back</a></button>
        <?php else: ?>
            <h2>Forgot Password</h2>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $err): ?>
                    <div><?php echo e($err); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?php echo e($success); ?></div>
        <?php endif; ?>

        <?php if ($action === 'login'): ?>
            <form method="post" action="login.php">
                <input type="hidden" name="csrf_token" value="<?php echo e($_SESSION['csrf_token']); ?>">
                <input type="hidden" name="form_action" value="login">
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="<?php echo e($email); ?>" required>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                    <div class="muted" style="margin-top:6px;">Minimum 6 characters</div>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <button type="submit" class="btn">Login</button>
                    <div class="footer-links">
                        <a href="login.php?action=forgot">Forgot password?</a>
                    </div>
                </div>
            </form>
        <?php else: /* forgot password form */ ?>
            <form method="post" action="login.php?action=forgot">
                <input type="hidden" name="csrf_token" value="<?php echo e($_SESSION['csrf_token']); ?>">
                <input type="hidden" name="form_action" value="forgot">
                <div class="field">
                    <label for="fp-email">Enter your email to reset password</label>
                    <input id="fp-email" type="email" name="email" value="<?php echo e($email); ?>" required>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <button type="submit" class="btn">Send reset link</button>
                    <a href="login.php">Back to login</a>
                </div>
            </form>
            
        <?php endif; ?>
        <p>don't have an account ? <a href="register.php">signup</a></p>
    </div>
</body>
</html>