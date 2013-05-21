<?php
include '../classes/business_function.php';

$error = Business_Function::add_business_function($_POST['Business_Function_Name'],
                                                  $_POST['Database_ID']);

//if error (return nothing)
if ($error != '1') {
    exit;
}

include '../include/database_business_functions.php';
?>
