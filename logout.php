<!--Web Development 2 Assignment-->
<!--Author: Loredana Bura -->
<!--Student number: C22370523-->

<!--start of php-->
<?php
    //php code to destroy session, i.e. logout user and redirect to index.php
    session_start();
    session_destroy();
    header("Location: index.php");
?>