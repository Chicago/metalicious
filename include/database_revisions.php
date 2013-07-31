<?php
include_once dirname(__FILE__) . '/../classes/database.php';

//set DB ID
if (isset($_POST['Database_ID'])) {
    $database_id = $_POST['Database_ID'];
} else {
    $database_id = $database_info['Database_ID'];
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
                Database Name
            </td>
            <td>

            </td>
        </tr>
    </thead>
    <tbody>
        <?php
        //show revisions
        $database_revisions = Database::get_database_revisions($database_id);

        while ($database_revision = mysqli_fetch_assoc($database_revisions)) {
            ?>
            <tr>
                <td>
                    <a href="#database_revision_<?php echo $database_revision['Database_Revision_ID']; ?>" role="button" data-toggle="modal" title="View This Revision"><?php echo $database_revision['Date_Created']; ?></a>

                    <div id="database_revision_<?php echo $database_revision['Database_Revision_ID']; ?>"
                         class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Revision: <?php echo $database_revision['Date_Created']; ?></h3>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td>
                                        <div class="span2">Database Name:</div>
                                    </td>
                                    <td>
                                        <?php echo stripslashes($database_revision['Database_Name']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Description:</div>
                                    </td>
                                    <td>
                                        <?php echo stripslashes(nl2br($database_revision['Description'])); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Business Owner:</div>
                                    </td>
                                    <td>
                                        <?php echo stripslashes(nl2br($database_revision['Business_Owner'])); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Contact Information:</div>
                                    </td>
                                    <td>
                                        <?php echo stripslashes(nl2br($database_revision['Contact_Information'])); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Data Period:</div>
                                    </td>
                                    <td>
                                        <?php echo stripslashes(nl2br($database_revision['Data_Period'])); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Software Platform:</div>
                                    </td>
                                    <td>
                                        <?php echo stripslashes(nl2br($database_revision['Software_Platform'])); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">General Accuracy, Completeness, Limitations:</div>
                                    </td>
                                    <td>
                                        <?php echo stripslashes(nl2br($database_revision['General_Accuracy'])); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Comments:</div>
                                    </td>
                                    <td>
                                        <?php echo stripslashes(nl2br($database_revision['Comments'])); ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                            <button class="btn btn-primary"
                                        onclick="
                                                $.post(
                                                    'ajax/activate_revision.php',
                                                    {
                                                        element_type: 'database',
                                                        revision_id: <?php echo $database_revision['Database_Revision_ID']; ?>
                                                    },
                                                    function (response){
                                                        if (response == '') {
                                                            document.location.href = 'database_info.php?database_id=<?php echo $database_id; ?>';

                                                            //document.getElementById('message_box').innerHTML = 'Added new revision successfully';
                                                            //$('#message_box').slideDown('slow').delay(3000).slideUp('slow');

                                                        } else {
                                                            document.getElementById('message_box').innerHTML = 'An error occurred while saving the revision: ' + response;
                                                            $('#message_box').slideDown('slow').delay(8000).slideUp('slow');
                                                        }
                                                    }
                                                );">Load This Revision</button>
                        </div>
                    </div>
                </td>
                <td>
                    <?php echo $database_revision['Database_Name']; ?>
                </td>
                <td>
                    <a href="javascript:;"
                       onclick="
                            $.post(
                                'ajax/activate_revision.php',
                                {
                                    element_type: 'database',
                                    revision_id: <?php echo $database_revision['Database_Revision_ID']; ?>
                                },
                                function (response){
                                    if (response == '') {
                                        document.location.href = 'database_info.php?database_id=<?php echo $database_id; ?>';

                                        //document.getElementById('message_box').innerHTML = 'Added new revision successfully';
                                        //$('#message_box').slideDown('slow').delay(3000).slideUp('slow');

                                    } else {
                                        document.getElementById('database_message_box').innerHTML = 'An error occurred while saving the revision: ' + response;
                                        $('#database_message_box').slideDown('slow').delay(8000).slideUp('slow');
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