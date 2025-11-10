<!DOCTYPE html>
<html>

<head>
    <title>What's the Weather</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main id="signup-body">
        <div class="header">
            <h1 id="wtw-title">What's the Weather</h1>
            <a href="index.html">Home</a>
            <a href="signin.html">Sign In</a>
            <a href="signup.html">Sign Up</a>
        </div>
        <form action="" method="post" class="signup-fields" id="signup-form">
            <div class="input-field">
                <label>Username</label>
                <input type="text" id="username" name="username"/>
                <p id="error-text-username" class="error-text hidden">Invalid Username</p>
            </div>
            <div class="input-field">
                <label>Password</label>
                <input type="password" id="password" name="password"/>
                <p id="error-text-password" class="error-text hidden">Invalid Password, too short</p>
            </div>
            <div class="input-field">
                <label>Re-enter Password</label>
                <input type="password" id="re-password" name="re-password"/>
                <p id="error-text-re-password" class="error-text hidden">Passwords do not match</p>
            </div>
            <div class="input-field">
                <label>Moderator Key (Not Required)</label>
                <input type="password" id="moderator-key" name="moderator-key"/>
                <p id="error-text-moderator-key" class="error-text hidden">Incorrect Moderator Key</p>
            </div>
            <div>
                <input type="submit" class="signup-form" value="Sign up" />
            </div><br>
        </form>
        <div class="signup-note">
            <p>Already have an account? <a href="signin.php">Sign in</a></p>
        </div>
    </main>
    <script src="js/signupHandlers.js"></script>
</body>

</html>