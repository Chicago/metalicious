<?php
include '../classes/database.php';
include '../classes/table.php';
include '../classes/variable.php';

//revision id
$revision_id = $_POST['revision_id'];

if ($_POST['element_type'] == 'database') {
    //activate revision
    Database::activate_revision($revision_id);
} else if ($_POST['element_type'] == 'table') {
    //activate revision
    Table::activate_revision($revision_id);
} else if ($_POST['element_type'] == 'variable') {
    //activate revision
    Variable::activate_revision($revision_id);
}
?>
