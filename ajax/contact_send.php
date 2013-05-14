<?php
//email to support
$to = "\"Metalicious Support\" <metalicious@example.com>";
$subject = "City Data Dictionary: Online Comment / Question / Suggestion";

date_default_timezone_set('America/Chicago');

$body = "Message from: \r\n\r\n"
        . "Date Received: " . date(DATE_RFC822) . "\r\n"
        . "First Name: " . $_POST['First_Name'] . "\r\n"
        . "Last Name: " . $_POST['Last_Name'] . "\r\n"
        . "Email: " . $_POST['Email'] . "\r\n"
        . "Comment / Question: " . $_POST['Comment_Question'] . "\r\n\r\n";

$headers = "From: \"Commenter\" <" . $_POST['Email'] . ">";

if (!mail($to, $subject, $body, $headers, "Commenter <" . $_POST['Email'] . ">")) {
    echo "An error occurred while sending an email.";
}
?>
