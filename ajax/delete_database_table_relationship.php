<?php
include '../classes/database.php';

Database::delete_database_table_relationship($_POST['Database_Table_ID']);

?>
