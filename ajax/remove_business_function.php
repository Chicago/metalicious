<?php
include dirname(__FILE__) . '/../classes/business_function.php';

Business_Function::remove_business_function($_POST['Business_Function_ID'],
                                            $_POST['Database_ID']);

?>
