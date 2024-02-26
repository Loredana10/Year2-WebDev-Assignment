<!--Web Development 2 Assignment-->
<!--Author: Loredana Bura -->
<!--Student number: C22370523-->

<!--start of php-->
<?php
    session_start();

    //checks if session variable named "username" is set. 
    //if "username" is not set, then user is redirected to login.php
    if (!isset($_SESSION["username"])) {
        header('Location: login.php');
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your account</title>
    <link rel="stylesheet" type = "text/css" href="style.css">
</head>
<body>
    <!-- linking the common header-->
    <?php
        include 'header.php';
    ?>
    <!-- user's account -->
    <div class = "account_page">
        <div>
            <!-- displays a welcome back message to the users -->
            <h2>Welcome back, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
            <label>Click here to reserve a book: </label>
            <a href="reserve_book.php">Reserve book</a>
            <br><br>
            <label>Click here to search a book: </label>
            <a href="search_book.php">Search book</a>
            <br><br>
            <label>Click here to view your books: </label>
            <a href="view_books.php">View books</a>
            <br><br>

            <!--logout button that destroys session-->
            <a href="logout.php"><button type="button">Logout</button></a>
            <br><br><br><br><br><br><br><br><br><br><br>
        </div>
    </div>

    <!-- linking the common footer-->
    <?php
        include 'footer.php';
    ?>

</body>
</html>