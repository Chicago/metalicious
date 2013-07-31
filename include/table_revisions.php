<?php
include_once dirname(__FILE__) . '/../classes/table.php';

//set DB ID
if (isset($_POST['Table_ID'])) {
    $table_id = $_POST['Table_ID'];
} else {
    $table_id = $table_info['Table_ID'];
}
?>
<table border="1" style="width: 90%; margin-left: auto; margin-right: auto;"
        class="table table-bordered">
    <thead>
        <tr>
            <td>
                Revision
            </td>
            <td>
                Table Name
            </td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <?php
        //show revisions
        $table_revisions = Table::get_table_revisions($table_id);

        while ($table_revision = mysqli_fetch_assoc($table_revisions)) {
            ?>
            <tr>
                <td>
                    <a href="#table_revision_<?php echo $table_revision['Table_Revision_ID']; ?>" role="button" data-toggle="modal" title="View This Revision"><?php echo $table_revision['Date_Created']; ?></a>

                    <div id="table_revision_<?php echo $table_revision['Table_Revision_ID']; ?>"
                         class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Revision: <?php echo $table_revision['Date_Created']; ?></h3>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td>
                                        <div class="span2">Table Name:</div>
                                    </td>
                                    <td>
                                        <?php echo $table_revision['Table_Name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Description:</div>
                                    </td>
                                    <td>
                                        <?php echo $table_revision['Table_Description']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Comments:</div>
                                    </td>
                                    <td>
                                        <?php echo $table_revision['Table_Comments']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Record Created:</div>
                                    </td>
                                    <td>
                                        <?php echo $table_revision['Date_Created']; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                            <button class="btn btn-primary"
                                        onclick="
                                                $.post(
                                                    '/ajax/activate_revision.php',
                                                    {
                                                        element_type: 'table',
                                                        revision_id: <?php echo $table_revision['Table_Revision_ID']; ?>
                                                    },
                                                    function (response){
                                                        if (response == '') {
                                                            document.location.href = '../table_info.php?table_id=<?php echo $table_id; ?>';

                                                            //document.getElementById('message_box').innerHTML = 'Added new revision successfully';
                                                            //$('#table_message_box').slideDown('slow').delay(3000).slideUp('slow');

                                                        } else {
                                                            document.getElementById('message_box').innerHTML = 'An error occurred while saving the revision: ' + response;
                                                            $('#table_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                                        }
                                                    }
                                                );">Load This Revision</button>
                        </div>
                    </div>
                </td>
                <td>
                    <?php echo $table_revision['Table_Name']; ?>
                </td>
                <td>
                    <a href="javascript:;"
                       onclick="
                               $.post(
                                    '../ajax/activate_revision.php',
                                    {
                                        element_type: 'table',
                                        revision_id: <?php echo $table_revision['Table_Revision_ID']; ?>
                                    },
                                    function (response){
                                        if (response == '') {
                                            document.location.href = '../table_info.php?table_id=<?php echo $table_id; ?>';

                                            //document.getElementById('message_box').innerHTML = 'Added new revision successfully';
                                            //$('#table_message_box').slideDown('slow').delay(3000).slideUp('slow');

                                        } else {
                                            document.getElementById('table_message_box').innerHTML = 'An error occurred while saving the revision: ' + response;
                                            $('#table_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                        }
                                    }
                                );">Load This Revision</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
