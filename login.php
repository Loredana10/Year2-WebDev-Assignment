<!--Web Development 2 Assignment-->
<!--Author: Loredana Bura -->
<!--Student number: C22370523-->


<!--start of php-->
<?php
session_start();

//linking to common header
include 'header.php';

//creating the connection between the MySQL database and the website, and checks for any connection errors 
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "library_system";

$conn = new mysqli($hostName, $dbUser, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Logout user if requested
if (isset($_POST["logout"])) {
    unset($_SESSION["username"]);
    header('Location: login.php');
    exit;
}

// Check if user has entered the required fields using POST
if (isset($_POST["username"]) && isset($_POST["password"])) {
    //retrieves a user from the database based on the username and password provided
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    //prevents SQL injection
    //"ss" measn there are two parameters and both are strings
    $stmt->bind_param("ss", $_POST['username'], $_POST['password']);
    $stmt->execute();
    $result = $stmt->get_result();


    //if query returns exactly 1 row, it means the user exists in the database
    if ($result->num_rows == 1) {
        //if true set username in the session and user is logged in
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["success"] = "Logged in.";
        header('Location: account.php');
        exit;
    } 
    
    //query does not return exactly one row, therefore login failed
    else {
        $_SESSION["error"] = "Incorrect username or password.";
        header('Location: login.php');
        exit;
    }
} 

elseif (count($_POST) > 0) {
    // Handle missing information, i.e. username and passowrd fields are empty
    $_SESSION["error"] = "Missing Required Information";
    header('Location: login.php');
    exit;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type = "text/css" href="style.css"> 
</head>
<body>
    <div class ="container">

        <!--login form -->
        <form method="post" action="login.php">

            <h3>Login Here</h3>

            <?php

            //checking if there is an error message stored in  the session
            if (isset($_SESSION["error"])) {

                //displays error message in red
                echo('<p style="color:red;">Error: ' . htmlspecialchars($_SESSION["error"]) . "</p>\n");
                //after message is displayed , it is unset to clear the error message
                unset($_SESSION["error"]);
            }
            ?>

            <label for="username">Username</label><br>
            <input type="text" name="username" placeholder="Username" id="username" required><br><br>

            <label for="password">Password</label><br>
            <input type="password" name="password" placeholder="Password" id="password" required><br>

            <button type="submit">Log In</button>


            <div><a href="register.php">Register</a></div>
        </form>


    </div>

    <!-- linking the common footer-->
    <?php
    include 'footer.php';
    ?>



    
</body>
</html>

