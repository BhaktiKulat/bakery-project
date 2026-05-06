<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sweet Crumbs</title>
    <link rel="stylesheet" href="css/style.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="index.html" class="logo">
            <span>🍰</span> Sweet Crumbs
        </a>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="customize.html">Customize</a></li>
            <li><a href="signup.php" class="btn btn-outline">Sign Up</a></li>
        </ul>
    </nav>

    <!-- LOGIN FORM -->
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Welcome Back!</h2>
                <p>Login to see your saved customized desserts and bakery cash.</p>
            </div>
            
            <?php if (isset($_GET['error'])): ?>
                <p style="color:red; text-align:center; margin-bottom:15px;">Invalid email or password.</p>
            <?php endif; ?>

            <?php if (isset($_GET['signup']) && $_GET['signup'] == 'success'): ?>
                <p style="color:green; text-align:center; margin-bottom:15px;">Account created! Please login.</p>
            <?php endif; ?>

            <form action="php/login-handler.php" method="POST">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required placeholder="example@email.com">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="********">
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <div class="auth-footer">
                Don't have an account? <a href="signup.php">Create one</a>
            </div>
        </div>
    </div>

</body>
</html>
