<?php
include '../classes/table.php';

$error = Table::create_table_variable_relationship($_POST['Table_Name'],
                                                   $_POST['Variable_ID']);

//if error (return nothing)
if ($error != '1') {
    exit;
}

include '../include/variable_tables.php';
?>