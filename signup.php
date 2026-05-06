<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Sweet Crumbs</title>
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
            <li><a href="login.php" class="btn btn-outline">Login</a></li>
        </ul>
    </nav>

    <!-- SIGNUP FORM -->
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Create Account</h2>
                <p>Join us to start earning Bakery Cash with every order!</p>
            </div>
            
            <form action="php/signup-handler.php" method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" required placeholder="John Doe">
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required placeholder="example@email.com">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="********">
                </div>
                <div class="form-group">
                    <label>Delivery Address</label>
                    <input type="text" name="address" required placeholder="123 Baker St, City">
                </div>
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </form>
            <div class="auth-footer">
                Already have an account? <a href="login.php">Login here</a>
            </div>
        </div>
    </div>

</body>
</html>
