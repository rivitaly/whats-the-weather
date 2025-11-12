<?php
require_once("db.php");

//removes special characters from user input
function test_input($data) {
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

    $unameRegex = "/^[a-zA-Z0-9_]+$/"; //tester for username input

    if (!preg_match($unameRegex, $username)) { //if user input doesn't follow regex
        $errors["username"] = "Invalid Username";
        $dataOK = FALSE;
    }

    if ($password < 7) { //if password isnt long enough
        $errors["password"] = "Invalid Password";
        $dataOK = FALSE;
    }

    if ($dataOK) {

        try { // database connection
            $db = new PDO($attr, $db_user, $db_pwd, $options);
            $result = $db->query("SELECT account_id, role FROM accounts WHERE username = '$username' AND password = '$password'"); //look for account with that username and password

            if (!$result) { //database fail
                $errors["Database Error"] = "Could not retrieve user information";
            } 

            else if ($row = $result->fetch()) { //if data exists

                session_start(); 

                $_SESSION["account_id"] = $row["account_id"];
                $_SESSION["role"] = $row["role"];
                
                //send to index signed in
                header("Location: index.php");
                exit();   
            } 

            else { //username doesn't exist
                $errors["Login Failed"] = "That username/password combination does not exist.";
            }
            $db = null;
        } 
        catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
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