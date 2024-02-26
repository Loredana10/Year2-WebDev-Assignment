<!--Web Development 2 Assignment-->
<!--Author: Loredana Bura -->
<!--Student number: C22370523-->


<!-- start of php-->
<?php
session_start();

//creating the connection between the MySQL database and the website, and checks for any connection errors 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hostName = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "library_system";

    $conn = new mysqli($hostName, $dbUser, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $isbn = $_POST['name'];

    // Check if the book with a given ISBN exists in the "books" table
    $checkQuery = "SELECT * FROM books WHERE ISBN = ?";
    $stmtCheck = $conn->prepare($checkQuery);
    //prevents SQL injection
    //'s' specifies that the parameter is a string
    $stmtCheck->bind_param("s", $isbn);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    //if statement is executed if book exists
    if ($resultCheck->num_rows > 0) {
        $row = $resultCheck->fetch_assoc();

        // Check if the book is already reserved
        if ($row['Reservation'] === 'N') {
            // Update the book to reserved ('Y')
            $reserveQuery = "UPDATE books SET Reservation = 'Y' WHERE ISBN = ?";
            $stmtReserve = $conn->prepare($reserveQuery);
            //prevents SQL injection
            //'s' specifies that the parameter is a string
            $stmtReserve->bind_param("s", $isbn);
            $stmtReserve->execute();
            $stmtReserve->close(); 

            // Inserts a record of the ISBN, username, and date into the "reserved_books" table
            //the date is retrieved using the now() function
            $reservedBooksQuery = "INSERT INTO reserved_books (ISBN, Username, ReservedDate) VALUES (?, ?, NOW())";
            $stmtInsertReserved = $conn->prepare($reservedBooksQuery);
            $stmtInsertReserved->bind_param("ss", $isbn, $_SESSION['username']);
            $stmtInsertReserved->execute();
            $stmtInsertReserved->close(); 

            // Redirect user to view_books.php
            header("Location: view_books.php");
            exit();
        } 
        
        //else statement executed if the book is already reserved
        else {
            echo "The book with ISBN $isbn is already reserved.";
        }
    } 
    
    //else statement executed if ISBN is not found in the database
    else {
        echo "Book with ISBN $isbn does not exist.";
    }

    // Close connection
    $stmtCheck->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Book</title>
    <link rel="stylesheet" type = "text/css" href="style.css">
</head>
<body>
    <!-- linking the common header-->
    <?php
    include 'header.php';
    ?>

    <!--form to reserve book using ISBN-->
    <div class ="container">
        <h2> Reserve Book </h2>
            <p> Reserve a book here</p>
            <form action = "reserve_book.php" method = "POST">
                <label>ISBN</label><br>
                <input type="text" name="name" required><br><br> 

                <input type = "submit" value="Reserve">
            </form>
    </div>

    <!--linking the common footer-->
    <?php
    include 'footer.php';
    ?>
    
</body>
</html>