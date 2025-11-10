<!DOCTYPE html>
<html>

<head>
    <title>What's the Weather</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main id="signin-body">
        <div class="header">
            <h1 id="wtw-title">What's the Weather</h1>
            <a href="index.php">Home</a>
            <a href="signin.php">Sign In</a>
            <a href="signup.php">Sign Up</a>
        </div>
        <form action="" method="post" class="signin-fields" id="signin-form">
            <div class="input-field">
                <label>Username</label>
                <input type="text" id="username" name="username" />
                <p id="error-text-username" class="error-text hidden">Username is invalid</p>
            </div>
            <div class="input-field">
                <label>Password</label>
                <input type="password" id="password" name="password" />
                <p id="error-text-password" class="error-text hidden">Password is invalid, too short</p>
            </div>
            <div>
                <input type="submit" class="signin-form" value="Sign in" />
            </div><br>
        </form>
        <div class="signin-note">
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </main>
    <script src = "js/signinHandlers.js"></script>
</body>

</html>