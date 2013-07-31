<?php
include_once dirname(__FILE__) . '/../classes/variable.php';

if (isset($_POST['Variable_ID'])) {
    $table_id = $_POST['Variable_ID'];
} else {
    $table_id = $_GET['variable_id'];
}

//show parent tables
$parent_tables = Variable::get_parent_tables($table_id);

while ($parent_table = mysqli_fetch_assoc($parent_tables)) {
    ?>
    <div id="parent_table_<?php echo $parent_table['Table_ID']; ?>" class="btn btn-mini btn-warning">
        <a href="javascript:;" onclick="
                            if (confirm('Are you sure you want to delete this relationship?')) {
                                $.post(
                                    'ajax/delete_table_variable_relationship.php',
                                    {
                                        Table_Variable_ID: <?php echo $parent_table['Table_Variable_ID']; ?>
                                    },
                                    function (response){
                                        if (response == '') {
                                            document.getElementById('variable_message_box').innerHTML = '<i class=\'icon-ok\'></i> Removed parent table successfully';
                                            $('#variable_message_box').attr('class', 'alert alert-success');
                                            $('#variable_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                       } else {
                                            document.getElementById('variable_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while deleting relationship: ' + response;
                                            $('#variable_message_box').attr('class', 'alert alert-error');
                                            $('#variable_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                        }
                                    }
                                );
                                $('#parent_table_<?php echo $parent_table['Table_ID']; ?>').slideUp('slow');
                            }"><i class="icon-remove-circle"></i></a>
            <?php echo $parent_table['Table_Name']; ?>
    </div>
    <?php
}
?>