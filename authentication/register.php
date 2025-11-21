<?php
// File: register.php
// Simple PHP-only registration form with server-side validation (no JS, no DB)

session_start();

$errors = [];
$values = [
    'first_name' => '',
    'last_name' => '',
    'email' => '',
    'gender' => ''
];

function clean($v) {
    return htmlspecialchars(trim($v), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect raw inputs
    $values['first_name'] = $_POST['first_name'] ?? '';
    $values['last_name']  = $_POST['last_name']  ?? '';
    $values['email']      = $_POST['email']      ?? '';
    $password             = $_POST['password']   ?? '';
    $confirm              = $_POST['confirm']    ?? '';
    $values['gender']     = $_POST['gender']     ?? '';

    // Validate first name
    if ($values['first_name'] === '') {
        $errors['first_name'] = 'First name is required.';
    } elseif (!preg_match("/^[a-zA-Z-' ]+$/", $values['first_name'])) {
        $errors['first_name'] = 'First name may contain letters, spaces, hyphens and apostrophes only.';
    }

    // Validate last name
    if ($values['last_name'] === '') {
        $errors['last_name'] = 'Last name is required.';
    } elseif (!preg_match("/^[a-zA-Z-' ]+$/", $values['last_name'])) {
        $errors['last_name'] = 'Last name may contain letters, spaces, hyphens and apostrophes only.';
    }

    // Validate email
    if ($values['email'] === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }

    // Validate password
    if ($password === '') {
        $errors['password'] = 'Password is required.';
    } else {
        if (strlen($password) < 8) {
            $errors['password'] = 'Password must be at least 8 characters.';
        } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
            $errors['password'] = 'Password must contain at least one letter and one number.';
        }
    }

    // Confirm password
    if ($confirm === '') {
        $errors['confirm'] = 'Please confirm your password.';
    } elseif ($password !== $confirm) {
        $errors['confirm'] = 'Passwords do not match.';
    }

    // Validate gender
    $allowedGenders = ['male','female','other'];
    if ($values['gender'] === '') {
        $errors['gender'] = 'Please select your gender.';
    } elseif (!in_array($values['gender'], $allowedGenders, true)) {
        $errors['gender'] = 'Invalid gender selection.';
    }

    // If no errors, consider registration successful (no DB in this example)
    if (empty($errors)) {
        // Normally you'd hash the password and save the user. Here we only show success.
        $safeFirst = clean($values['first_name']);
        $safeLast  = clean($values['last_name']);
        $safeEmail = clean($values['email']);
        // clear sensitive fields
        $values['first_name'] = $values['last_name'] = $values['email'] = $values['gender'] = '';
        $success = "Registration successful. Welcome, {$safeFirst} {$safeLast} ({$safeEmail}).";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Register</title>
<style>
    body { font-family: Arial, sans-serif; background:#f7f7f7; padding:20px; }
    .card { max-width:480px; margin:20px auto; background:#fff; padding:20px; border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,.1); }
    .field { margin-bottom:12px; }
    label { display:block; font-weight:600; margin-bottom:6px; }
    input[type="text"], input[type="email"], input[type="password"] { width:100%; padding:8px; box-sizing:border-box; border:1px solid #ccc; border-radius:4px; }
    .error { color:#b00020; font-size:0.9em; margin-top:6px; }
    .success { background:#e6ffed; border:1px solid #8fd19e; padding:10px; color:#0a6b2e; margin-bottom:12px; border-radius:4px; }
    .radios label { display:inline-block; margin-right:12px; font-weight:normal; }
    button { background:#007bff; color:#fff; border:none; padding:10px 14px; border-radius:4px; cursor:pointer; }
    button:hover { background:#0069d9; }
    a { color:black; text-decoration:none; }
</style>
</head>
<body>
<div class="card" style="position:relative;">
    <h2>Register</h2>
     <button style="position:absolute; padding:14px;border:none; border-radius:4px; cursor:pointer; text-decoration:none; color:black;background:#e6f0ff; 
            right:16px;bottom:56px;"class="btn-primary"><a href="../home.php">Back</a></button>

    <?php if (!empty($success)): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post" action="regsubmit.php">
        <div class="field">
            <label for="first_name">First name</label>
            <input id="first_name" name="first_name" type="text" value="<?php echo clean($values['first_name']); ?>" required>
            <?php if (!empty($errors['first_name'])): ?><div class="error"><?php echo $errors['first_name']; ?></div><?php endif; ?>
        </div>

        <div class="field">
            <label for="last_name">Last name</label>
            <input id="last_name" name="last_name" type="text" value="<?php echo clean($values['last_name']); ?>" required>
            <?php if (!empty($errors['last_name'])): ?><div class="error"><?php echo $errors['last_name']; ?></div><?php endif; ?>
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="<?php echo clean($values['email']); ?>" required>
            <?php if (!empty($errors['email'])): ?><div class="error"><?php echo $errors['email']; ?></div><?php endif; ?>
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
            <?php if (!empty($errors['password'])): ?><div class="error"><?php echo $errors['password']; ?></div><?php endif; ?>
        </div>

        <div class="field">
            <label for="confirm">Confirm password</label>
            <input id="confirm" name="confirm" type="password" required>
            <?php if (!empty($errors['confirm'])): ?><div class="error"><?php echo $errors['confirm']; ?></div><?php endif; ?>
        </div>

        <div class="field">
            <label>Gender</label>
            <div class="radios">
                <label><input type="radio" name="gender" value="male" <?php echo ($values['gender']==='male') ? 'checked' : ''; ?>> Male</label>
                <label><input type="radio" name="gender" value="female" <?php echo ($values['gender']==='female') ? 'checked' : ''; ?>> Female</label>
                <label><input type="radio" name="gender" value="other" <?php echo ($values['gender']==='other') ? 'checked' : ''; ?>> Other</label>
            </div>
            <?php if (!empty($errors['gender'])): ?><div class="error"><?php echo $errors['gender']; ?></div><?php endif; ?>
        </div>

        <div>
            <button type="submit">Register</button>
        </div>
    </form>
    <p>already have an account ? <a href="login.php">login</a></p>
</div>
</body>
</html>