<?php

//production database connection
$cnnCDD = mysqli_connect("yourlocaldatabase", "db-user", "db-password", "datadictionary")
                    or die ("Error Connecting To The Database Because: " . mysqli_connect_error());

?>
