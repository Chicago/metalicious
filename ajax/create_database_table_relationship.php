<?php
include '../classes/database.php';

$error = Database::create_database_table_relationship($_POST['Database_Name'],
                                            $_POST['Table_ID']);

//if error (return nothing)
if ($error != '1') {
    exit;
}

include '../include/table_databases.php';
?>
