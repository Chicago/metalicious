<?php
include '../classes/keyword.php';

$error = Keyword::add_keyword($_POST['Keyword'],
                                $_POST['Element_Type'],
                                $_POST['Element_ID']);

//if error (return nothing)
if ($error != '1') {
    exit;
}

include '../include/element_keywords.php';
?>
