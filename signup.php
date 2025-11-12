<?php
require_once("db.php");

//removes special characters from user input
function test_input($data) {
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
    
    $unameRegex = "/^[a-zA-Z0-9_]+$/"; //tester for username input

    if (!preg_match($unameRegex, $username)) {//if username doesn't follow regex
        $errors["username"] = "Invalid Username";
    }
    if ($password < 7) { // if password isn't long enough
        $errors["password"] = "Invalid Password";
    }

    try { // data base connection
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
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
        }
        else {
            $role = "Player";
        }
        
        // insert account into database
        $result = $db->exec("INSERT INTO accounts (username, password, role) VALUES ('$username', '$password', '$role')");
    } 
    
    //print if any errors 
    if (!empty($errors)) {
        foreach($errors as $type => $message) {
            print("$type: $message \n<br />");
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
    <main id="signup-body">
        <div class="header">
            <h1 id="wtw-title">What's the Weather</h1>
            <a href="index.php">Home</a>
            <a href="signin.php">Sign In</a>
            <a href="signup.php">Sign Up</a>
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