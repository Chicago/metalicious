<?php
include '../classes/user.php';

User::add_user_user_type($_POST['User_ID'],
                        $_POST['User_Type_ID']);

?>
