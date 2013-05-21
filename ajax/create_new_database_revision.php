<?php
include '../classes/database.php';

Database::create_revision(
                $_POST['Database_ID'],
                $_POST['Database_Name'],
                $_POST['Description'],
                $_POST['Business_Owner'],
                $_POST['Contact_Information'],
                $_POST['Data_Period'],
                $_POST['Software_Platform'],
                $_POST['General_Accuracy'],
                $_POST['Comments'],
                $_POST['Creator']);

//show revisions
include '../include/database_revisions.php';
?>
