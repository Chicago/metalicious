<?php
include '../classes/table.php';

Table::create_revision($_POST['Table_ID'],
                       $_POST['Table_Name'],
                       $_POST['Table_Description'],
                       $_POST['Table_Comments'],
                       $_POST['Creator'],
                       $_POST['Database_ID']);

//show revisions
include '../include/table_revisions.php';
?>
