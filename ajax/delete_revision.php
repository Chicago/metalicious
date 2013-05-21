<?php
include '../classes/database.php';
include '../classes/table.php';
include '../classes/variable.php';

//revision id
$revision_id = $_POST['revision_id'];

if ($_POST['element_type'] == 'database') {
    //activate revision
    Database::delete_revision($revision_id);
} else if ($_POST['element_type'] == 'table') {
    //activate revision
    Table::delete_revision($revision_id);
} else if ($_POST['element_type'] == 'variable') {
    //activate revision
    Variable::delete_revision($revision_id);
}
?>
