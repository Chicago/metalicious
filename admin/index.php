<?php
include '../classes/database.php';
include '../classes/table.php';
include '../classes/variable.php';
include '../classes/keyword.php';
include '../classes/user.php';
include 'include/header.php';
?>
<div>
    <br />
    <div class="container">
        <!-- Begin Dashboard for Administrators -->

        <div class="row-fluid" style="cursor: pointer;" onclick="$('.element-listings').slideToggle('slow');">
            <div class="span12">
                <h1 class="page-title">Elements <i class="icon-list-alt"></i></h1>
            </div>
        </div>

        <div class="row-fluid element-listings">

            <div class="span6">
                <div class="widget">
                    <div class="widget-header" style="cursor: pointer;" onclick="$('#database_listings').slideToggle('slow');">
                        <i class="icon-th-large"></i>
                        <h3>database</h3>
                    </div>
                    <div class="widget-content" id="database_listings">
                        <div id="database_listings_message_box" class="alert alert-block" style="display: none;"></div>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Content Author</td>
                                    <td>Date Created</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                //show orphans

                                //databases
                                $orphan_database_revisions = Database::get_orphan_revisions();

                                while ($orphan_database_revision = mysqli_fetch_assoc($orphan_database_revisions)) {
                                    ?>
                                    <tr id="orphan_database_revision_<?php echo $orphan_database_revision['Database_Revision_ID']; ?>_entry">
                                        <td>
                                            <a href="#database_revision_<?php echo $orphan_database_revision['Database_Revision_ID']; ?>" role="button" data-toggle="modal" title="View This Revision"><?php echo $orphan_database_revision['Database_Name']; ?></a>

                                            <div id="database_revision_<?php echo $orphan_database_revision['Database_Revision_ID']; ?>"
                                                 class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h3 id="myModalLabel">Revision: <?php echo $orphan_database_revision['Date_Created']; ?></h3>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped table-bordered">
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Database Name:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo stripslashes($orphan_database_revision['Database_Name']); ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Description:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo stripslashes(nl2br($orphan_database_revision['Description'])); ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Business Owner:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo stripslashes(nl2br($orphan_database_revision['Business_Owner'])); ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Contact Information:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo stripslashes(nl2br($orphan_database_revision['Contact_Information'])); ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Data Period:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo stripslashes(nl2br($orphan_database_revision['Data_Period'])); ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Software Platform:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo stripslashes(nl2br($orphan_database_revision['Software_Platform'])); ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">General Accuracy, Completeness, Limitations:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo stripslashes(nl2br($orphan_database_revision['General_Accuracy'])); ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Comments:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo stripslashes(nl2br($orphan_database_revision['Comments'])); ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                    <button class="btn btn-primary"
                                                                onclick="
                                                                        if (confirm('Are you sure you want to activate this entry?')) {
                                                                            $.post(
                                                                                '../ajax/activate_revision.php',
                                                                                {
                                                                                    element_type: 'database',
                                                                                    revision_id: <?php echo $orphan_database_revision['Database_Revision_ID']; ?>
                                                                                },
                                                                                function (response){
                                                                                    if (response == '') {
                                                                                        $('#database_revision_<?php echo $orphan_database_revision['Database_Revision_ID']; ?>').modal('hide');
                                                                                        $('#orphan_database_revision_<?php echo $orphan_database_revision['Database_Revision_ID']; ?>_entry').fadeOut('slow');
                                                                                        document.getElementById('database_listings_message_box').innerHTML = '<i class=\'icon-ok\'></i> Activated new revision successfully';
                                                                                        $('#database_listings_message_box').attr('class', 'alert alert-success');
                                                                                        $('#database_listings_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                                                                    } else {
                                                                                        document.getElementById('database_listings_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the revision: ' + response;
                                                                                        $('#database_listings_message_box').attr('class', 'alert alert-error');
                                                                                        $('#database_listings_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                                                                    }
                                                                                }
                                                                            );
                                                                         }">Activate Revision</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo $orphan_database_revision['User_Name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $orphan_database_revision['Date_Created']; ?>
                                        </td>
                                        <td class="action-td">
                                            <a href="javascript:;" class="btn btn-small btn-warning"
                                                   onclick="
                                                       if (confirm('Are you sure you want to activate this entry?')) {
                                                            $.post(
                                                                '../ajax/activate_revision.php',
                                                                {
                                                                    element_type: 'database',
                                                                    revision_id: <?php echo $orphan_database_revision['Database_Revision_ID']; ?>
                                                                },
                                                                function (response){
                                                                    if (response == '') {
                                                                        $('#orphan_database_revision_<?php echo $orphan_database_revision['Database_Revision_ID']; ?>_entry').fadeOut('slow');
                                                                        document.getElementById('database_listings_message_box').innerHTML = '<i class=\'icon-ok\'></i> Activated new revision successfully';
                                                                        $('#database_listings_message_box').attr('class', 'alert alert-success');
                                                                        $('#database_listings_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                                                    } else {
                                                                        document.getElementById('database_listings_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the revision: ' + response;
                                                                        $('#database_listings_message_box').attr('class', 'alert alert-error');
                                                                        $('#database_listings_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                                                    }
                                                                }
                                                            );
                                                         }"><i class="icon-ok"></i></a>
                                            <a href="javascript:;" onclick="if (confirm('Are you sure you want to delete this entry?')) {
                                                                                    $.post(
                                                                                        '../ajax/delete_revision.php',
                                                                                        {
                                                                                            element_type: 'database',
                                                                                            revision_id: <?php echo $orphan_database_revision['Database_Revision_ID']; ?>
                                                                                        },
                                                                                        function (response){
                                                                                            if (response == '') {
                                                                                                $('#orphan_database_revision_<?php echo $orphan_database_revision['Database_Revision_ID']; ?>_entry').fadeOut('slow');
                                                                                                document.getElementById('database_listings_message_box').innerHTML = '<i class=\'icon-ok\'></i> Removed new revision successfully';
                                                                                                $('#database_listings_message_box').attr('class', 'alert alert-success');
                                                                                                $('#database_listings_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                                                                            } else {
                                                                                                document.getElementById('database_listings_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the revision: ' + response;
                                                                                                $('#database_listings_message_box').attr('class', 'alert alert-error');
                                                                                                $('#database_listings_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                                                                            }
                                                                                        }
                                                                                    );
                                                                            }" class="btn btn-small">
                                                <i class="icon-remove"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>                                
                            </tbody>
                        </table>
                    </div>
                </div>	

            </div>
            <div class="span6">

                <div class="widget">
                    <div class="widget-header" style="cursor: pointer;" onclick="$('#table_listings').slideToggle('slow');">
                        <i class="icon-th"></i>
                        <h3>table</h3>
                    </div>
                    <div class="widget-content" id="table_listings">
                        <div id="table_listings_message_box" class="alert alert-block" style="display: none;"></div>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Content Author</td>
                                    <td>Date Created</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                //show orphans

                                //tables
                                $orphan_table_revisions = Table::get_orphan_revisions();

                                while ($orphan_table_revision = mysqli_fetch_assoc($orphan_table_revisions)) {
                                    ?>
                                    <tr id="orphan_table_revision_<?php echo $orphan_table_revision['Table_Revision_ID']; ?>_entry">
                                        <td>
                                            <a href="#table_revision_<?php echo $orphan_table_revision['Table_Revision_ID']; ?>" role="button" data-toggle="modal" title="View This Revision"><?php echo $orphan_table_revision['Table_Name']; ?></a>

                                            <div id="table_revision_<?php echo $orphan_table_revision['Table_Revision_ID']; ?>"
                                                 class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h3 id="myModalLabel">Revision: <?php echo $orphan_table_revision['Date_Created']; ?></h3>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped table-bordered">
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Table Name:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo $orphan_table_revision['Table_Name']; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Description:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo $orphan_table_revision['Table_Description']; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Comments:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo $orphan_table_revision['Table_Comments']; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Record Created:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo $orphan_table_revision['Date_Created']; ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                    <button class="btn btn-primary"
                                                                onclick="
                                                                    if (confirm('Are you sure you want to activate this entry?')) {
                                                                        $.post(
                                                                            '../ajax/activate_revision.php',
                                                                            {
                                                                                element_type: 'table',
                                                                                revision_id: <?php echo $orphan_table_revision['Table_Revision_ID']; ?>
                                                                            },
                                                                            function (response){
                                                                                if (response == '') {
                                                                                    $('#table_revision_<?php echo $orphan_table_revision['Table_Revision_ID']; ?>').modal('hide');
                                                                                    $('#orphan_table_revision_<?php echo $orphan_table_revision['Table_Revision_ID']; ?>_entry').fadeOut('slow');
                                                                                    document.getElementById('table_listings_message_box').innerHTML = '<i class=\'icon-ok\'></i> Activated new revision successfully';
                                                                                    $('#table_listings_message_box').attr('class', 'alert alert-success');
                                                                                    $('#table_listings_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                                                                } else {
                                                                                    document.getElementById('table_listings_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the revision: ' + response;
                                                                                    $('#table_listings_message_box').attr('class', 'alert alert-error');
                                                                                    $('#table_listings_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                                                                }
                                                                            }
                                                                        );
                                                                    }">Activate Revision</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo $orphan_table_revision['User_Name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $orphan_table_revision['Date_Created']; ?>
                                        </td>
                                        <td class="action-td">
                                            <a href="javascript:;" class="btn btn-small btn-warning"
                                                   onclick="
                                                        if (confirm('Are you sure you want to activate this entry?')) {
                                                            $.post(
                                                                '../ajax/activate_revision.php',
                                                                {
                                                                    element_type: 'table',
                                                                    revision_id: <?php echo $orphan_table_revision['Table_Revision_ID']; ?>
                                                                },
                                                                function (response){
                                                                    if (response == '') {
                                                                        $('#orphan_table_revision_<?php echo $orphan_table_revision['Table_Revision_ID']; ?>_entry').fadeOut('slow');
                                                                        document.getElementById('table_listings_message_box').innerHTML = '<i class=\'icon-ok\'></i> Activated new revision successfully';
                                                                        $('#table_listings_message_box').attr('class', 'alert alert-success');
                                                                        $('#table_listings_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                                                    } else {
                                                                        document.getElementById('table_listings_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the revision: ' + response;
                                                                        $('#table_listings_message_box').attr('class', 'alert alert-error');
                                                                        $('#table_listings_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                                                    }
                                                                }
                                                            );
                                                        }"><i class="icon-ok"></i></a>
                                            <a href="javascript:;" onclick="if (confirm('Are you sure you want to delete this entry?')) {
                                                                                    $.post(
                                                                                        '../ajax/delete_revision.php',
                                                                                        {
                                                                                            element_type: 'table',
                                                                                            revision_id: <?php echo $orphan_table_revision['Table_Revision_ID']; ?>
                                                                                        },
                                                                                        function (response){
                                                                                            if (response == '') {
                                                                                                $('#orphan_table_revision_<?php echo $orphan_table_revision['Table_Revision_ID']; ?>_entry').fadeOut('slow');
                                                                                                document.getElementById('table_listings_message_box').innerHTML = '<i class=\'icon-ok\'></i> Removed new revision successfully';
                                                                                                $('#table_listings_message_box').attr('class', 'alert alert-success');
                                                                                                $('#table_listings_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                                                                            } else {
                                                                                                document.getElementById('table_listings_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the revision: ' + response;
                                                                                                $('#table_listings_message_box').attr('class', 'alert alert-error');
                                                                                                $('#table_listings_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                                                                            }
                                                                                        }
                                                                                    );                                                                                
                                                                            }" class="btn btn-small">
                                                <i class="icon-remove"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>	
                </div>	

            </div>
        </div>
        
        <div class="row-fluid element-listings">

            <div class="span6">
                <div class="widget">
                    <div class="widget-header" style="cursor: pointer;" onclick="$('#variable_listings').slideToggle('slow');">
                        <i class="icon-asterisk"></i>
                        <h3>variable</h3>
                    </div>
                    <div class="widget-content" id="variable_listings">
                        <div id="variable_listings_message_box" class="alert alert-block" style="display: none;"></div>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Content Author</td>
                                    <td>Date Created</td>
                                    <td></td>
                                </tr>
                            </thead>

                            <tbody>
                                <?
                                //show orphans

                                //variables
                                $orphan_variable_revisions = Variable::get_orphan_revisions();

                                while ($orphan_variable_revision = mysqli_fetch_assoc($orphan_variable_revisions)) {
                                    ?>
                                    <tr id="orphan_variable_revision_<?php echo $orphan_variable_revision['Variable_Revision_ID']; ?>_entry">
                                        <td>
                                            <a href="#variable_revision_<?php echo $orphan_variable_revision['Variable_Revision_ID']; ?>" role="button" data-toggle="modal" title="View This Revision"><?php echo $orphan_variable_revision['Variable_Name']; ?></a>

                                            <div id="variable_revision_<?php echo $orphan_variable_revision['Variable_Revision_ID']; ?>"
                                                 class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h3 id="myModalLabel">Revision: <?php echo $orphan_variable_revision['Date_Created']; ?></h3>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped table-bordered">
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Name:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo $orphan_variable_revision['Variable_Name']; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Description:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo $orphan_variable_revision['Variable_Description']; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Type / Format:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo $orphan_variable_revision['Variable_Type_Format']; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Length:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo $orphan_variable_revision['Variable_Length']; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Values:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo $orphan_variable_revision['Variable_Values']; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Example:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo $orphan_variable_revision['Variable_Example']; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Comments:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo $orphan_variable_revision['Variable_Comments']; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Data Portal:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo $orphan_variable_revision['Data_Portal']; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="span2">Record Created:</div>
                                                            </td>
                                                            <td>
                                                                <?php echo $orphan_variable_revision['Date_Created']; ?>
                                                            </td>
                                                        </tr>
                                                    </table>                                        
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                    <button class="btn btn-primary"
                                                                onclick="
                                                                    if (confirm('Are you sure you want to activate this entry?')) {
                                                                        $.post(
                                                                            '../ajax/activate_revision.php',
                                                                            {
                                                                                element_type: 'variable',
                                                                                revision_id: <?php echo $orphan_variable_revision['Variable_Revision_ID']; ?>
                                                                            },
                                                                            function (response){
                                                                                if (response == '') {
                                                                                    $('#variable_revision_<?php echo $orphan_variable_revision['Variable_Revision_ID']; ?>').modal('hide');
                                                                                    $('#orphan_variable_revision_<?php echo $orphan_variable_revision['Variable_Revision_ID']; ?>_entry').fadeOut('slow');
                                                                                    document.getElementById('variable_listings_message_box').innerHTML = '<i class=\'icon-ok\'></i> Activated new revision successfully';
                                                                                    $('#variable_listings_message_box').attr('class', 'alert alert-success');
                                                                                    $('#variable_listings_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                                                                } else {
                                                                                    document.getElementById('variable_listings_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the revision: ' + response;
                                                                                    $('#variable_listings_message_box').attr('class', 'alert alert-error');
                                                                                    $('#variable_listings_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                                                                }
                                                                            }
                                                                        );
                                                                    }">Activate Revision</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo $orphan_variable_revision['User_Name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $orphan_variable_revision['Date_Created']; ?>
                                        </td>
                                        <td class="action-td">
                                            <a href="javascript:;" class="btn btn-small btn-warning"
                                                   onclick="
                                                        if (confirm('Are you sure you want to activate this entry?')) {
                                                            $.post(
                                                                '../ajax/activate_revision.php',
                                                                {
                                                                    element_type: 'variable',
                                                                    revision_id: <?php echo $orphan_variable_revision['Variable_Revision_ID']; ?>
                                                                },
                                                                function (response){
                                                                    if (response == '') {
                                                                        $('#orphan_variable_revision_<?php echo $orphan_variable_revision['Variable_Revision_ID']; ?>_entry').fadeOut('slow');
                                                                        document.getElementById('variable_listings_message_box').innerHTML = '<i class=\'icon-ok\'></i> Activated new revision successfully';
                                                                        $('#variable_listings_message_box').attr('class', 'alert alert-success');
                                                                        $('#variable_listings_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                                                    } else {
                                                                        document.getElementById('variable_listings_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the revision: ' + response;
                                                                        $('#variable_listings_message_box').attr('class', 'alert alert-error');
                                                                        $('#variable_listings_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                                                    }
                                                                }
                                                            );
                                                        }"><i class="icon-ok"></i></a>
                                            <a href="javascript:;" onclick="if (confirm('Are you sure you want to delete this entry?')) {
                                                                                $.post(
                                                                                    '../ajax/delete_revision.php',
                                                                                    {
                                                                                        element_type: 'variable',
                                                                                        revision_id: <?php echo $orphan_variable_revision['Variable_Revision_ID']; ?>
                                                                                    },
                                                                                    function (response){
                                                                                        if (response == '') {
                                                                                            $('#orphan_variable_revision_<?php echo $orphan_variable_revision['Variable_Revision_ID']; ?>_entry').fadeOut('slow');
                                                                                            document.getElementById('variable_listings_message_box').innerHTML = '<i class=\'icon-ok\'></i> Removed new revision successfully';
                                                                                            $('#variable_listings_message_box').attr('class', 'alert alert-success');
                                                                                            $('#variable_listings_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                                                                        } else {
                                                                                            document.getElementById('variable_listings_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the revision: ' + response;
                                                                                            $('#variable_listings_message_box').attr('class', 'alert alert-error');
                                                                                            $('#variable_listings_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                                                                        }
                                                                                    }
                                                                                );
                                                                            }" class="btn btn-small">
                                                <i class="icon-remove"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                            <!--
                            <thead>
                                <tr>
                                    <td colspan="4"><b>Updates</b></td>
                                </tr>
                            </thead>
                            -->
                        </table>
                    </div>	
                </div>	

            </div>

            <div class="span6">
                <!--
                <div class="widget">
                    <div class="widget-header">
                        <i class=""></i>
                        <h3>database</h3>
                    </div>
                    <div class="widget-content">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Content Author</td>
                                    <td>Date Created</td>
                                    <td></td>
                                </tr>
                            </thead>

                            <tbody>


                            </tbody>
                        </table>
                    </div>	
                </div>	
                -->
            </div>

        </div>

    </div> <!-- /container -->

    <!-- end Administrators' dashboard -->

    <div class="container">

        <div class="row-fluid" style="cursor: pointer;" onclick="$('.user-admin').slideToggle('slow');">
            <div class="span12">
                <h1 class="page-title">Users <i class="icon-user"></i></h1>
            </div>
            
        </div>

        <div class="row-fluid user-admin">

            <div class="span6">
                <div class="widget">
                    <div class="widget-header" style="cursor: pointer;" onclick="$('#add_user').slideToggle('slow');">
                        <i class="icon-user"></i>
                        <h3>users</h3>
                    </div>
                    <div class="widget-content" id="add_user">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>User</td>
                                    <td>Name</td>
                                    <td style="text-align: center;">Admin</td>
                                    <td style="text-align: center;">CM</td>
                                    <td style="text-align: center;">Viewer</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    //databases
                                    $all_users = User::get_all_users();

                                    while ($user = mysqli_fetch_assoc($all_users)) {
                                        $priv_users_user_types = User::get_users_user_types($user['User_ID']);
                                        ?>
                                        <tr>
                                            <td><?php echo $user['User_ID']; ?></td>
                                            <td><?php echo "<i>" . $user['User_Name'] . "</i>"; ?></td>
                                            <td><?php echo $user['First_Name'] . " " . $user['Last_Name']; ?></td>
                                            <td style="text-align: center;">
                                                <?php
                                                if (in_array('Administrator', $priv_users_user_types)) {
                                                    ?>
                                                    <i class="icon-ok"></i>
                                                    <?php
                                                }
                                                ?></td>
                                            <td style="text-align: center;"><?php echo (in_array('Content Manager', $priv_users_user_types)) ? '<i class="icon-ok"></i>' : ''; ?></td>
                                            <td style="text-align: center;"><?php echo (in_array('Viewer (Chicago Affiliation)', $priv_users_user_types)) ? '<i class="icon-ok"></i>' : ''; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>	
                </div>	
            </div>

            <div class="span6">
                <div class="widget">
                    <div class="widget-header" style="cursor: pointer;" onclick="$('#privileges_listings').slideToggle('slow');">
                        <i class="icon-lock"></i>
                        <h3>privileges</h3>
                    </div>
                    <div class="widget-content" id="privileges_listings">
                        <div id="privileges_listings_message_box" class="alert alert-block" style="display: none;"></div>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td>User</td>
                                    <td>
                                        <select name="User_ID" id="User_ID">
                                            <?php
                                            //databases
                                            $all_users = User::get_all_users();

                                            while ($user = mysqli_fetch_assoc($all_users)) {
                                                ?>
                                                <option value="<?php echo $user['User_ID']; ?>"><?php echo $user['User_Name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Privileges</td>
                                    <td>
                                        <select name="User_Type_ID" id="User_Type_ID">
                                            <?php
                                            //databases
                                            $all_user_types = User::get_all_user_types();

                                            while ($user_type = mysqli_fetch_assoc($all_user_types)) {
                                                ?>
                                                <option value="<?php echo $user_type['User_Type_ID']; ?>"><?php echo $user_type['User_Type_Name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type="button" name="add_user_privilege" id="add_user_privilege" value="Add Privilege" class="btn btn-primary pull-left"
                                               onclick="
                                                    $.post(
                                                        '../ajax/add_user_user_type.php',
                                                        {
                                                            User_ID: document.getElementById('User_ID').options[document.getElementById('User_ID').selectedIndex].value,
                                                            User_Type_ID: document.getElementById('User_Type_ID').options[document.getElementById('User_Type_ID').selectedIndex].value
                                                        },
                                                        function (response){
                                                            if (response == '') {
                                                                document.getElementById('privileges_listings_message_box').innerHTML = '<i class=\'icon-ok\'></i> Added new user type to user successfully';
                                                                $('#privileges_listings_message_box').attr('class', 'alert alert-success');
                                                                $('#privileges_listings_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                                            } else {
                                                                document.getElementById('privileges_listings_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while adding user type: ' + response;
                                                                $('#privileges_listings_message_box').attr('class', 'alert alert-error');
                                                                $('#privileges_listings_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                                            }
                                                        }
                                                    );" />                                    
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>	
                </div>	
            </div>
        </div>
    </div>
</div> <!-- /content -->

<?php
include 'include/footer.php';
?>
