<?php
include '../classes/variable.php';

Variable::create_revision($_POST['Variable_ID'],
                          $_POST['Variable_Name'],
                          $_POST['Variable_Description'],
                          $_POST['Variable_Type_Format'],
                          $_POST['Variable_Length'],
                          $_POST['Variable_Values'],
                          $_POST['Variable_Example'],
                          $_POST['Variable_Comments'],
                          $_POST['Data_Portal'],
                          $_POST['Creator'],
                          $_POST['Table_ID']);

//show revisions
include '../include/variable_revisions.php';
?>
