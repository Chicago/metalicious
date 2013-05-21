<?php
include '../classes/database.php';
include '../classes/table.php';
include '../classes/variable.php';

//toggle element based on post info
if (isset($_POST['Database_ID'])) {
    Database::toggle_public($_POST['Database_ID'], $_POST['Public']);
} else if (isset($_POST['Table_ID'])) {
    Table::toggle_public($_POST['Table_ID'], $_POST['Public']);
} else if (isset($_POST['Variable_ID'])) {
    Variable::toggle_public($_POST['Variable_ID'], $_POST['Public']);
}
?>
