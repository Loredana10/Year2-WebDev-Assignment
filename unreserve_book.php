<!--Web Development 2 Assignment-->
<!--Author: Loredana Bura -->
<!--Student number: C22370523-->

<!--start of php-->
<?php
session_start();

//creating the connection between the MySQL database and the website, and checks for any connection errors 
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['isbn'])) {
    $hostName = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "library_system";

    $conn = new mysqli($hostName, $dbUser, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $isbn = $_GET['isbn'];

    // Check if the book is reserved 
    $checkReservedQuery = "SELECT * FROM books WHERE ISBN = ? AND Reservation = 'Y'";
    $stmtCheckReserved = $conn->prepare($checkReservedQuery);
    $stmtCheckReserved->bind_param("s", $isbn);
    $stmtCheckReserved->execute();
    $resultCheckReserved = $stmtCheckReserved->get_result();

    if ($resultCheckReserved->num_rows > 0) {
        // Update the book to not reserved ('N')
        $updateQuery = "UPDATE books SET Reservation = 'N' WHERE ISBN = ?";
        $stmtUpdate = $conn->prepare($updateQuery);
        //prevents SQL injection
        //'s' specifies that the parameter is a string
        $stmtUpdate->bind_param("s", $isbn);
        $stmtUpdate->execute();
        $stmtUpdate->close();

        // Unreserve the book by deleting the entry from reserved_books table
        $unreserveQuery = "DELETE FROM reserved_books WHERE ISBN = ? AND Username = ?";
        $stmtUnreserve = $conn->prepare($unreserveQuery);
        //prevents SQL injection
        //'ss' specifies that the two parameters are strings
        $stmtUnreserve->bind_param("ss", $isbn, $_SESSION['username']);
        $stmtUnreserve->execute();
        $stmtUnreserve->close();

        // Redirect back to view_books.php
        header("Location: view_books.php");
        exit();
    } 
    
    else {
        echo "The book with ISBN $isbn is not reserved.";
    }

    // Close connection
    $stmtCheckReserved->close();
    $conn->close();
} 

else {
    echo "Invalid request.";
}
?>



