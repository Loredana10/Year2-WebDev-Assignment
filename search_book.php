<!--Web Development 2 Assignment-->
<!--Author: Loredana Bura -->
<!--Student number: C22370523-->

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

    //initialisng an empty array to store category information
    $categories = array();
    //selecting all records from the "category" table
    $sql = "SELECT * FROM category";
    $result = $conn->query($sql);

    //if statement is executed if there are rows returned from the query
    if($result->num_rows > 0)
    {
        //iterating through each row (category)
        while($category = $result->fetch_assoc())
        {
            //associative array created using the CategoryID as the key and CategoryDescription as the value. 
            //this builds a mapping of CategoryID to CategoryDescription
            $categories[$category['CategoryID']] = $category['CategoryDescription'];
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Book</title>
    <link rel="stylesheet" type = "text/css" href="style.css">
</head>
<body>

    <!-- linking the common header-->
    <?php
    include 'header.php';
    ?>

    <!--form to search for a book-->
    <div class = "container">
        <h2> Search for a book </h2>
        <p> Please fil in at least one option </p>
        <p> Copy the ISBN code to reserve book </p>
        <form action = "search_book.php" method ="GET">
            <label>Book Title</label><br>
            <input type="text" name="BookTitle"><br><br>

            <label>Author</label><br>
            <input type="text" name="Author"><br><br>

            <h4>OR</h4>
            <label>Category</label><br>
            <select class = "category" name = "CategoryID">
            <option value="">Select a category</option>
                <?php
                    //iterate through each element in the $categories array
                    foreach ($categories as $catId => $catDes) 
                    {
                        //$catId represents the key (CategoryID) of the current array element
                        //$catName represents the value (CategoryDescription) pf the current array element
                        echo "<option value=".$catId.">$catDes</option>";
                    }
                ?>
            </select>   
            <button type = "submit" name = "search"> Search </button>
        </form>

        <?php   
            //check if parameters are in the database, and retrieve the value 
            if (isset($_GET['BookTitle']) || isset($_GET['Author']) || isset($_GET['CategoryID']) ) {
                $title = isset($_GET['BookTitle']) ? $_GET['BookTitle'] : "";
                $author = isset($_GET['Author']) ? $_GET['Author'] : "";
                $category = isset($_GET['CategoryID']) ? $_GET['CategoryID'] : "";

                //SQL query to search for books based on the provided parameters.
                //using LIKE clause to preform case-sensitive partial matching
                $query = "SELECT * FROM books WHERE (LOWER(BookTitle) LIKE LOWER('%".$title."%') AND LOWER(Author) LIKE LOWER('%".$author."%'))";

                //if cateogry is provided it is appended to the $query
                if (!empty($category)) 
                {
                    $query .= " AND CategoryID = $category";
                }

                $result = $conn ->query($query);

                if ($result ->num_rows > 0) {
                    //displaying the shared result as a list

                    echo "<h3>Search Results:</h3>";
                    echo "<ul>";

                    while ($row = $result -> fetch_assoc()) {
                        echo "<li>{$row['ISBN']}: {$row['BookTitle']} by {$row['Author']} -<a href = 'reserve_book.php?book_id={$row['ISBN']}'>Reserve</a></li>";
                    }
                    echo "</ul>";

                }

                else {
                    echo "<p>No results found.</p>";
                }

                // Close connection
                $conn->close();

            }
            ?>

            



    </div>

    <!-- linking the common footer-->
    <?php
        include 'footer.php';
    ?>
    
</body>
</html>