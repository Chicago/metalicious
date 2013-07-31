<?php
include_once dirname(__FILE__) . '/../classes/variable.php';

//set DB ID
if (isset($_POST['Variable_ID'])) {
    $variable_id = $_POST['Variable_ID'];
} else {
    $variable_id = $variable_info['Variable_ID'];
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
                Variable Name
            </td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <?php
        //show revisions
        $variable_revisions = Variable::get_variable_revisions($variable_id);

        while ($variable_revision = mysqli_fetch_assoc($variable_revisions)) {
            ?>
            <tr>
                <td>
                    <a href="#variable_revision_<?php echo $variable_revision['Variable_Revision_ID']; ?>" role="button" data-toggle="modal" title="View This Revision"><?php echo $variable_revision['Date_Created']; ?></a>

                    <div id="variable_revision_<?php echo $variable_revision['Variable_Revision_ID']; ?>"
                         class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Revision: <?php echo $variable_revision['Date_Created']; ?></h3>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td>
                                        <div class="span2">Name:</div>
                                    </td>
                                    <td>
                                        <?php echo $variable_revision['Variable_Name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Description:</div>
                                    </td>
                                    <td>
                                        <?php echo $variable_revision['Variable_Description']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Type / Format:</div>
                                    </td>
                                    <td>
                                        <?php echo $variable_revision['Variable_Type_Format']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Length:</div>
                                    </td>
                                    <td>
                                        <?php echo $variable_revision['Variable_Length']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Values:</div>
                                    </td>
                                    <td>
                                        <?php echo $variable_revision['Variable_Values']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Example:</div>
                                    </td>
                                    <td>
                                        <?php echo $variable_revision['Variable_Example']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Comments:</div>
                                    </td>
                                    <td>
                                        <?php echo $variable_revision['Variable_Comments']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Data Portal:</div>
                                    </td>
                                    <td>
                                        <?php echo $variable_revision['Data_Portal']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="span2">Record Created:</div>
                                    </td>
                                    <td>
                                        <?php echo $variable_revision['Date_Created']; ?>
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
                                                    element_type: 'variable',
                                                    revision_id: <?php echo $variable_revision['Variable_Revision_ID']; ?>
                                                },
                                                function (response){
                                                    if (response == '') {
                                                        document.location.href = '/variable_info.php?variable_id=<?php echo $variable_id; ?>';

                                                        //document.getElementById('message_box').innerHTML = 'Added new revision successfully';
                                                        //$('#variable_message_box').slideDown('slow').delay(3000).slideUp('slow');

                                                    } else {
                                                        document.getElementById('variable_message_box').innerHTML = 'An error occurred while saving the revision: ' + response;
                                                        $('#variable_message_box').attr('class', 'alert alert-error');
                                                        $('#variable_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                                    }
                                                }
                                            );">Load This Revision</button>
                        </div>
                    </div>
                </td>
                <td>
                    <?php echo $variable_revision['Variable_Name']; ?>
                </td>
                <td>
                    <a href="javascript:;"
                       onclick="
                            $.post(
                                '/ajax/activate_revision.php',
                                {
                                    element_type: 'variable',
                                    revision_id: <?php echo $variable_revision['Variable_Revision_ID']; ?>
                                },
                                function (response){
                                    if (response == '') {
                                        document.location.href = '/variable_info.php?variable_id=<?php echo $variable_id; ?>';

                                        //document.getElementById('message_box').innerHTML = 'Added new revision successfully';
                                        //$('#variable_message_box').slideDown('slow').delay(3000).slideUp('slow');

                                    } else {
                                        document.getElementById('variable_message_box').innerHTML = 'An error occurred while saving the revision: ' + response;
                                        $('#variable_message_box').attr('class', 'alert alert-error');
                                        $('#variable_message_box').slideDown('slow').delay(8000).slideUp('slow');
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
