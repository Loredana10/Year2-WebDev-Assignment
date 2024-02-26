<!--Web Development 2 Assignment-->
<!--Author: Loredana Bura -->
<!--Student number: C22370523-->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
    <link rel="stylesheet" type = "text/css" href="style.css">
</head>
<body>
    <!--linking the common header-->
    <?php
    include 'header.php';
    ?>
        <!--list to view users reserved books-->
        <div class = "container">
            <h2> View your books </h2>

            <!--start of php-->
            <?php

            //creating the connection between the MySQL database and the website, and checks for any connection errors
            session_start();
            $hostName = "localhost";
            $dbUser = "root";
            $dbPassword = "";
            $dbName = "library_system";

            $conn = new mysqli($hostName, $dbUser, $dbPassword, $dbName);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve reserved books from the reserved_books table
            $reservedQuery = "SELECT * FROM reserved_books WHERE Username = ?";
            $stmtReserved = $conn->prepare($reservedQuery);
            //prevents SQL injection
            //'s' specifies that the parameter is a string
            $stmtReserved->bind_param("s", $_SESSION['username']);
            $stmtReserved->execute();
            $resultReserved = $stmtReserved->get_result();

            //check if there are reserved books in the result set
            if ($resultReserved->num_rows > 0) {
                echo "<ul>";
                
                //loop through each reserved book in the result set
                while ($row = $resultReserved->fetch_assoc()) {
                    //display details in a list
                    //link to unreserve book
                    echo "<li>{$row['ISBN']} - Reserved on {$row['ReservedDate']} - <a href='unreserve_book.php?isbn={$row['ISBN']}'>Unreserve</a></li>";
                }
                echo "</ul>";
            } 
            
            else {
                echo "<p>No reserved books.</p>";
            }

            // Close connection
            $stmtReserved->close();
            $conn->close();
            ?>
        </div>
    
    <!--linking the common footer-->
    <?php
    include 'footer.php';
    ?>
    
</body>
</html>