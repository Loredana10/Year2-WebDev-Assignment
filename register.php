<!--Web Development 2 Assignment-->
<!--Author: Loredana Bura -->
<!--Student number: C22370523-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form</title>
    <link rel="stylesheet" type = "text/css" href=" css/style.css">
</head>

<body>
    <!-- Linking the common header -->
    <?php
        include 'header.php';
    ?>

    <div class = "container">
     
   <!-- Start of php -->
    <?php
        //creating the connection between the MySQL database and the website, and checks for any connection errors 
        $hostName = "localhost";
        $dbUser = "root";
        $dbPassword = "";
        $dbName = "library_system";

        $conn = new mysqli($hostName, $dbUser, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die("Something went wrong;" .$conn->connect_error);
        }

        //checks if the user has entered the required form fields using POST
        if (isset($_POST['username']) && isset($_POST['password'])&& isset($_POST['confirmPassword']) && isset($_POST['firstName']) && isset($_POST['surname']) && isset($_POST['addressLine1']) && isset($_POST['addressLine2']) && isset($_POST['city']) && isset($_POST['telephone'])) 
        {
            $u = $_POST['username'];
            $p = $_POST['password'];
            $cp = $_POST['confirmPassword'];
            $f = $_POST['firstName'];
            $s = $_POST['surname'];
            $a1 = $_POST['addressLine1'];
            $a2 = $_POST['addressLine2'];
            $c = $_POST['city'];
            $t = $_POST['telephone'];

            //error checking
            //telephone number is numeric and 10 characters in length
            if(!is_numeric($t) || strlen($t) !== 10){
                echo "<script>alert('ERROR: Telephone should be numeric and 10 characters in length.');</script>";
                echo "<script>window.location.href = 'register.php';</script>";
        
            }

            //password is at least 6 characters in length
            elseif(strlen($p) !== 6){
                echo "<script>alert('ERROR: Password should be 6 characters in length.');</script>";
                echo "<script>window.location.href = 'register.php';</script>";
            }

            //verifying password
            elseif($p !== $cp){
                echo "<script>alert('ERROR: Password is not the same.');</script>";
                echo "<script>window.location.href = 'register.php';</script>";
            }

            else{
                // Check if username already exists in the database
                $checkUsernameQuery = "SELECT * FROM users WHERE username = '$u'";

                //if true, display error alert and redirect user back to register.php
                $result = $conn->query($checkUsernameQuery);
                if ($result->num_rows > 0) {
                    echo "<script>alert('ERROR: Username is already taken. Choose a different one.');</script>";
                    echo "<script>window.location.href = 'register.php';</script>";
                }

                //else statement is executed if the uaername does not already exists
                else{
                    //insert the information into the database
                    $sql = "INSERT INTO users (username, password, firstName, surname, addressLine1, addressLine2, city, telephone) VALUES ('$u','$p','$f','$s','$a1', '$a2', '$c', '$t')";
            
                    if($conn->query($sql) == TRUE)
                    {
                        echo "<h3>Data stored in a database successfully. Please login.</h3>"; 
            
                    } 
                    
                    else{
                        echo "ERROR:Sorry $sql. "
                        .mysqli_error($conn);
                    }
                }
            } 
            
            // Close connection
            $conn->close();
        }

        ?>
                
        <!-- registration form-->
        <div class = "container"> 
            <h2>Register</h2>     
            <form action="register.php" method="post">
                <div>
                    <label for ="username">Username:</label>
                    <input type = "text" name="username" placeholder="Username" required>
                </div>
            
                <div>
                    <lable for="password">Password(6 characters in length):</label>
                    <input type = "password" name="password" placeholder="password" required>
                </div>

                <div>
                    <lable for="confirmPassword">Re-enter Password:</label>
                    <input type = "password" name="confirmPassword" placeholder="Re-enter password" required>
                </div>
                
                <div>
                    <label for ="firstName">First Name:</label>
                    <input type = "text" name="firstName" placeholder="First Name" required>
                </div>
                
                <div>
                    <label for ="surname">Surname:</label>
                    <input type = "text" name="surname" placeholder="Surname" required>
                </div>
                
                <div>
                    <label for ="addressLine1">Address Line 1:</label>
                    <input type = "text" name="addressLine1" placeholder="Address Line 1" required>
                </div>
                
                <div>
                    <label for ="addressLine2">Address Line 2:</label>
                    <input type = "text" name="addressLine2" placeholder="Address Line 2" required>
                </div>
                
                <div>
                    <label for ="city">City:</label>
                    <input type = "text" name="city" placeholder="City" required>
                </div>
                
                <div>
                    <label for ="telephone">Telephone:</label>
                    <input type = "text" name="telephone" placeholder="Telephone" required>
                </div>
                <button>Register</button>
                <a href ="login.php"></a>
                <div><p>Already registered? <a href = "login.php">Login Here</a></p></div>

        </div>

        <!--linking the common footer-->
        <?php
        include 'footer.php';
        ?>

        
</body>
</html>