<?php
include_once dirname(__FILE__) . '/../classes/table.php';

if (isset($_POST['Table_ID'])) {
    $table_id = $_POST['Table_ID'];
} else {
    $table_id = $_GET['table_id'];
}

//show parent databases
$parent_databases = Table::get_parent_databases($table_id);

while ($parent_database = mysqli_fetch_assoc($parent_databases)) {
    ?>
    <div id="parent_database_<?php echo $parent_database['Database_ID']; ?>" class="btn btn-mini btn-warning">
        <a href="javascript:;" title="Remove This Database" onclick="
                            if (confirm('Are you sure you want to delete this relationship?')) {
                                $.post(
                                    'ajax/delete_database_table_relationship.php',
                                    {
                                        Database_Table_ID: <?php echo $parent_database['Database_Table_ID']; ?>
                                    },
                                    function (response){
                                        if (response == '') {
                                            document.getElementById('table_message_box').innerHTML = '<i class=\'icon-ok\'></i> Removed relationship successfully';
                                            $('#table_message_box').attr('class', 'alert alert-success');
                                            $('#table_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                        } else {
                                            document.getElementById('table_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while deleting relationship: ' + response;
                                            $('#table_message_box').attr('class', 'alert alert-error');
                                            $('#table_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                        }
                                    }
                                );
                                $('#parent_database_<?php echo $parent_database['Database_ID']; ?>').slideUp('slow');
                            }"><i class="icon-remove-circle"></i></a>
        <?php echo $parent_database['Database_Name']; ?>
    </div>
    <?php
}
?>
