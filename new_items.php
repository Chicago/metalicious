<?php
include 'classes/database.php';
include 'classes/table.php';
include 'classes/variable.php';

include 'include/header.php';
?>

<br />
Databases:
<table>
    <?
    //show orphans

    //databases
    $orphan_database_revisions = Database::get_orphan_revisions();

    while ($orphan_database_revision = mysqli_fetch_assoc($orphan_database_revisions)) {
        ?>
        <tr>
            <td>
                <div id="orphan_database_revision_<?php echo $orphan_database_revision['Database_Revision_ID']; ?>_entry">
                    <a href="javascript:;" onclick="$('#orphan_database_revision_<?php echo $orphan_database_revision['Database_Revision_ID']; ?>').slideToggle('slow');">
                        <?php echo $orphan_database_revision['Database_Name']; ?></a>
                    <div id="orphan_database_revision_<?php echo $orphan_database_revision['Database_Revision_ID']; ?>" style="display: none;">
                        DB Info:
                        <?php echo $orphan_database_revision['Database_Name']; ?><br />
                        <a href="javascript:;" onclick="
                                                    $.post(
                                                        'ajax/activate_revision.php',
                                                        {
                                                            element_type: 'database',
                                                            revision_id: <?php echo $orphan_database_revision['Database_Revision_ID']; ?>
                                                        },
                                                        function (response){
                                                            if (response == '') {
                                                                $('#orphan_database_revision_<?php echo $orphan_database_revision['Database_Revision_ID']; ?>_entry').fadeOut('slow');
                                                                document.getElementById('message_box').innerHTML = 'Activated new revision successfully';
                                                                $('#message_box').slideDown('slow').delay(3000).slideUp('slow');
                                                            } else {
                                                                document.getElementById('message_box').innerHTML = 'An error occurred while saving the revision: ' + response;
                                                                $('#message_box').slideDown('slow').delay(8000).slideUp('slow');
                                                            }
                                                        }
                                                    );">Activate</a>
                    </div>
                </div>
            </td>
        </tr>
        <?php
    }
    ?>
</table>

<br />
Tables:
<table>
    <?
    //show orphans

    //tables
    $orphan_table_revisions = Table::get_orphan_revisions();

    while ($orphan_table_revision = mysqli_fetch_assoc($orphan_table_revisions)) {
        ?>
        <tr>
            <td>
                <div id="orphan_table_revision_<?php echo $orphan_table_revision['Table_Revision_ID']; ?>_entry">
                    <a href="javascript:;" onclick="$('#orphan_table_revision_<?php echo $orphan_table_revision['Table_Revision_ID']; ?>').slideToggle('slow');">
                        <?php echo $orphan_table_revision['Table_Name']; ?></a>
                    <div id="orphan_table_revision_<?php echo $orphan_table_revision['Table_Revision_ID']; ?>" style="display: none;">
                        DB Info:
                        <?php echo $orphan_table_revision['Table_Name']; ?><br />
                        <a href="javascript:;" onclick="
                                                    $.post(
                                                        'ajax/activate_revision.php',
                                                        {
                                                            element_type: 'table',
                                                            revision_id: <?php echo $orphan_table_revision['Table_Revision_ID']; ?>
                                                        },
                                                        function (response){
                                                            if (response == '') {
                                                                $('#orphan_table_revision_<?php echo $orphan_table_revision['Table_Revision_ID']; ?>_entry').fadeOut('slow');
                                                                document.getElementById('message_box').innerHTML = 'Activated new revision successfully';
                                                                $('#message_box').slideDown('slow').delay(3000).slideUp('slow');
                                                            } else {
                                                                document.getElementById('message_box').innerHTML = 'An error occurred while saving the revision: ' + response;
                                                                $('#message_box').slideDown('slow').delay(8000).slideUp('slow');
                                                            }
                                                        }
                                                    );">Activate</a>
                    </div>
                </div>
            </td>
        </tr>
        <?php
    }
    ?>
</table>

<br />
Variables:
<table>
    <?
    //show orphans

    //variables
    $orphan_variable_revisions = Variable::get_orphan_revisions();

    while ($orphan_variable_revision = mysqli_fetch_assoc($orphan_variable_revisions)) {
        ?>
        <tr>
            <td>
                <div id="orphan_variable_revision_<?php echo $orphan_variable_revision['Variable_Revision_ID']; ?>_entry">
                    <a href="javascript:;" onclick="$('#orphan_variable_revision_<?php echo $orphan_variable_revision['Variable_Revision_ID']; ?>').slideToggle('slow');">
                        <?php echo $orphan_variable_revision['Variable_Name']; ?></a>
                    <div id="orphan_variable_revision_<?php echo $orphan_variable_revision['Variable_Revision_ID']; ?>" style="display: none;">
                        DB Info:
                        <?php echo $orphan_variable_revision['Variable_Name']; ?><br />
                        <a href="javascript:;" onclick="
                                                    $.post(
                                                        'ajax/activate_revision.php',
                                                        {
                                                            element_type: 'variable',
                                                            revision_id: <?php echo $orphan_variable_revision['Variable_Revision_ID']; ?>
                                                        },
                                                        function (response){
                                                            if (response == '') {
                                                                $('#orphan_variable_revision_<?php echo $orphan_variable_revision['Variable_Revision_ID']; ?>_entry').fadeOut('slow');
                                                                document.getElementById('message_box').innerHTML = 'Activated new revision successfully';
                                                                $('#message_box').slideDown('slow').delay(3000).slideUp('slow');
                                                            } else {
                                                                document.getElementById('message_box').innerHTML = 'An error occurred while saving the revision: ' + response;
                                                                $('#message_box').slideDown('slow').delay(8000).slideUp('slow');
                                                            }
                                                        }
                                                    );">Activate</a>
                    </div>
                </div>
            </td>
        </tr>
        <?php
    }
    ?>
</table>

<?php include 'include/footer.php'; ?>
