<?php
session_start();
require_once("db.php");
require_once("accountFactory.php");

// If user is already logged in, redirect to index.php
if (isset($_SESSION["account"]->id)) {
    header("Location: index.php");
    exit();
}

//removes special characters from user input
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); //encodes
    return $data;
}

$errors = array(); //array for errors

//variables for input
$username = "";
$password = "";
$moderator_key = "";
$role = "";

$REAL_MOD_KEY = getenv('MODERATOR_KEY'); //variable for testing moderator_key input


if ($_SERVER["REQUEST_METHOD"] == "POST") { //post form from sign up

    //cleans user input
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);
    $moderator_key = test_input($_POST["moderator-key"]);

    $unameRegex = "/^[a-zA-Z]{1,20}$/"; //tester for username input, must be between 1-20 characters

    if (!preg_match($unameRegex, $username) && ($password < 7 && $password <= 64)) { //if user input doesn't follow regex AND invalid password
        $errors["Sign-Up Failed"] = "Invalid username and password. Usernames must be between 1 - 20 letters and passwords must be between 7 - 64 characters.";
        $dataOK = FALSE;
    } else if(!preg_match($unameRegex, $username)) { //if user input doesn't follow regex
        $errors["Sign-Up Failed"] = "Invalid username.  Must be between 1 - 20 letters.";
        $dataOK = FALSE;
    } else if($password < 7 && $password <= 64) { //if user input is invalid password
        $errors["Sign-Up Failed"] = "Invalid password.  Must be between 7 - 64 characters.";
        $dataOK = FALSE;
    }

    try { // data base connection
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }

    // look for if the username already exists
    $result = $db->query("SELECT username FROM accounts WHERE username='$username'");
    $match = $result->fetch();

    if ($match) {
        $errors["Account Taken"] = "A user with that username already exists.";
    }

    // if error free, decide if moderator key is correct
    if (empty($errors)) {
        if ($moderator_key == $REAL_MOD_KEY) {
            $role = "Moderator";
        } else {
            $role = "Player";
        }

        $lower_username = strtolower($username);
        // insert account into database
        $result = $db->exec("INSERT INTO accounts (username, password, role, display_name) VALUES ('$lower_username', '$password', '$role', '$username')");

        $db = null;

        header("Location: signin.php");
    }

}
?>


<!DOCTYPE html>
<html>

<head>
    <title>What's the Weather</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main id="signup-body">
        <header>
  <div class="header">
    <a href="index.php" class="logo-link">
      <h1 id="header-title">What's the Weather</h1>
    </a>

    <!-- Hamburger Button -->
    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="hamburger">
      <span></span>
      <span></span>
      <span></span>
    </label>

    <!-- Dropdown Menu -->
    <nav class="nav-menu">
      <ul>
        <li><a href="index.php">Home</a></li>
        <?php
                if (isset($_SESSION["account"])) {
                  if ($_SESSION["account"]->role === "Moderator") {
                    echo '<li><a href="mod.php">Mod Panel</a></li>';
                  }
                  echo '<li><a href="stats.php">Player Stats</a></li>';
                  echo '<li><a href="credits.php">Source Credits</a></li>';
                  echo '<li><a href="logout.php">Log Out</a></li>';
                } else {
                  echo '<li><a href="credits.php">Source Credits</a></li>';
                  echo '<li><a href="signin.php">Sign In</a></li>';
                  echo '<li><a href="signup.php">Sign Up</a></li>';
                }
                ?>
              </ul>
            </nav>
          </div>
        </header>


        <section class="signup-in-card-container">
            <div class="signup-in-card">
                <h2 id="create-account-title">Create an Account</h2>
                <form action="" method="post" class="signup-fields" id="signup-form">

                    <div class="input-field">
                        <label>Username</label>
                        <input type="text" id="username" name="username" />
                        <p id="error-text-username" class="error-text hidden">Invalid Username</p>
                    </div>

                    <div class="input-field">
                        <label>Password</label>
                        <input type="password" id="password" name="password" />
                        <p id="error-text-password" class="error-text hidden">Invalid Password, too short</p>
                    </div>

                    <div class="input-field">
                        <label>Re-enter Password</label>
                        <input type="password" id="re-password" name="re-password" />
                        <p id="error-text-re-password" class="error-text hidden">Passwords do not match</p>
                    </div>

                    <div class="input-field">
                        <label>Moderator Key (Not Required)</label>
                        <input type="password" id="moderator-key" name="moderator-key" />
                        <p id="error-text-moderator-key" class="error-text hidden">Incorrect Moderator Key</p>
                    </div>

                    <button type="submit" class="signup-in-button">Sign Up</button>
                </form>
                <p class="signup-note">Already have an account? <a href="signin.php">Sign in</a></p>
                <div>
                    <?php
                    //print if any errors while logging in
                    if (!empty($errors)) {
                        foreach ($errors as $type => $message) {
                            echo "<p class='messages'>{$type} : {$message}</p>";
                        }
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>
    <script src="js/signupHandlers.js"></script>
</body>

</html>
