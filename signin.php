<?php
require_once("db.php");

if (isset($_SESSION["account_id"])) {
  
  try { // data base connection
    $db = new PDO($attr, $db_user, $db_pwd, $options);
       // Checks for banned user and redirects if found
    $playerAccount = $_SESSION['account_id'];
    $result = $db->query("SELECT banned from accounts WHERE account_id = '$playerAccount'");
    $row = $result->fetch();
    if ($row['banned'] == 1)
    {
        header("Location: banned.php");
        exit();
    }
  } catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int) $e->getCode());
  }
    $db = null;
}
//removes special characters from user input
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); //encodes
    return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") { //post form from sign in 

    $errors = array(); //any errors 
    $dataOK = TRUE; //data check variable

    //clean user input
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);

    $unameRegex = "/^[a-zA-Z]+$/"; //tester for username input

    if (!preg_match($unameRegex, $username) || $password < 7) { //if user input doesn't follow regex
        $errors["Login Failed"] = "Invalid username or password";
        $dataOK = FALSE;
    }

    if ($dataOK) {

        try { // database connection
            $db = new PDO($attr, $db_user, $db_pwd, $options);
            $result = $db->query("SELECT account_id, role, username, display_name, banned FROM accounts WHERE username = '$username' AND password = '$password'"); //look for account with that username and password

            if (!$result) { //database fail
                $errors["Database Error"] = "Could not retrieve user information";
            } else if ($row = $result->fetch()) { //if data exists

                session_start();

                $_SESSION["account_id"] = $row["account_id"];
                $_SESSION["role"] = $row["role"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["display_name"] = $row["display_name"];

                //send to index signed in
                header("Location: index.php");
                exit();
            } else { //username doesn't exist
                $errors["Login Failed"] = "That username/password combination does not exist.";
            }
            $db = null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
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
    <main id="signin-body">
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
          if (isset($_SESSION["account"])){
            if (isset($_SESSION["role"]) && $_SESSION["role"] === "Moderator"){
              echo '<li><a href="mod.php">Mod Panel</a></li>';
            }
            echo '<li><a href="stats.php">Player Stats</a></li>';
            echo '<li><a href="credits.php">Source Credits</a></li>';
            echo '<li><a href="logout.php">Log Out</a></li>';
          }
          else{
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
                <h2 id="create-account-title">Sign In to Your Account</h2>
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
                        <button type="submit" class="signup-in-button">Sign in</button>
                    </div><br>
                </form>
                <p class="signin-note">Don't have an account? <a href="signup.php">Sign up</a></p>
                <div>
                    <?php
                    //print if any errors 
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
    <script src="js/signinHandlers.js"></script>
</body>

</html>
