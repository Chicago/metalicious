<?php
include 'classes/keyword.php';

Keyword::remove_keyword($_POST['Keyword'],
                        $_POST['Element_Type'],
                        $_POST['Element_ID']);

?>