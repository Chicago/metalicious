<?php
include_once dirname(__FILE__) . '/../classes/database.php';

if (isset($_POST['Database_ID'])) {
    $database_id = $_POST['Database_ID'];
} else {
    $database_id = $_GET['database_id'];
}

//show business functions
$database_business_functions = Database::get_business_functions($database_id);

while ($database_business_function = mysqli_fetch_assoc($database_business_functions)) {
    ?>
    <div id="database_business_function_<?php echo $database_business_function['Business_Function_ID']; ?>" class="btn btn-mini btn-warning">
        <a href="javascript:;" title="Remove This Business Function" onclick="
                            if (confirm('Are you sure you want to remove this business function?')) {
                                $.post(
                                    'ajax/remove_business_function.php',
                                    {
                                        Business_Function_ID: '<?php echo $database_business_function['Business_Function_ID']; ?>',
                                        Database_ID: <?php echo $database_id; ?>
                                    },
                                    function (response){
                                        if (response == '') {
                                            document.getElementById('database_message_box').innerHTML = '<i class=\'icon-ok\'></i> Removed busines function successfully';
                                            $('#database_message_box').attr('class', 'alert alert-success');
                                            $('#database_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                        } else {
                                            document.getElementById('database_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while removing keyword: ' + response;
                                            $('#database_message_box').attr('class', 'alert alert-error');
                                            $('#database_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                        }
                                    }
                                );
                                $('#database_business_function_<?php echo $database_business_function['Business_Function_ID']; ?>').slideUp('slow');
                            }"><i class="icon-remove-circle"></i></a>
        <?php echo $database_business_function['Business_Function_Name']; ?>
    </div>
    <?php
}
?>