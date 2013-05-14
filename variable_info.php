<?php
include 'classes/database.php';
include 'classes/table.php';
include 'classes/variable.php';
include 'classes/keyword.php';

$variable_info = Variable::get_variable_info($_GET['variable_id']);

//if the user is not logged in and the item isn't public
if (!isset($_COOKIE['user_id']) && ($variable_info['Public'] == '0')) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

//add a single view
Variable::add_view($_GET['variable_id']);

//recently viewed link
$recently_viewed_link = '<li><a href="variable_info.php?variable_id=' . $variable_info['Variable_ID'] . '"><i class="icon-asterisk"></i> ' . $variable_info['Variable_Name'] . '</a> (variable)</li>';

if (stripslashes($_COOKIE['recently_viewed'][0]) != $recently_viewed_link) {
    //add item to recently viewed
    setcookie("recently_viewed[4]", stripslashes($_COOKIE['recently_viewed'][3]));
    setcookie("recently_viewed[3]", stripslashes($_COOKIE['recently_viewed'][2]));
    setcookie("recently_viewed[2]", stripslashes($_COOKIE['recently_viewed'][1]));
    setcookie("recently_viewed[1]", stripslashes($_COOKIE['recently_viewed'][0]));
    setcookie("recently_viewed[0]", $recently_viewed_link);
}

include 'include/header.php';
?>
<br />
<div style="font-weight: bold; font-size: 20px; font-family: arial;">
    Variable Detail
</div>
<br />
<div id="variable_info_static">
    <table class="table table-striped table-bordered">
        <tr>
            <td>
                <div class="span2">Name:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes($variable_info['Variable_Name']); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Description:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes(nl2br($variable_info['Variable_Description'])); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Type / Format:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes($variable_info['Variable_Type_Format']); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Length:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes($variable_info['Variable_Length']); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Values:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes(nl2br($variable_info['Variable_Values'])); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Example:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes(nl2br($variable_info['Variable_Example'])); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Comments:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes(nl2br($variable_info['Variable_Comments'])); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Last Updated:</div>
            </td>
            <td>
                <div class="span6"><?php echo ($variable_info['Last_Updated'] == '') ? $variable_info['Date_Created'] : $variable_info['Last_Updated']; ?></div>
            </td>
        </tr>
    </table>
</div>
<?php
if (isset($users_user_types)) {
    //permissions test
    if (in_array('Administrator', $users_user_types))
    {
        ?>
        <div id="variable_info_entry" style="display: none;">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>
                        Name:
                    </td>
                    <td>
                        <input type="hidden" name="Variable_ID" id="Variable_ID" value="<?php echo $variable_info['Variable_ID']; ?>" />
                        <input type="text" name="Variable_Name" id="Variable_Name" value="<?php echo stripslashes($variable_info['Variable_Name']); ?>" class="span6" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Description:
                    </td>
                    <td>
                        <textarea name="Variable_Description" id="Variable_Description" rows="5" class="span6"><?php echo stripslashes($variable_info['Variable_Description']); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Type / Format:
                    </td>
                    <td>
                        <input type="text" name="Variable_Type_Format" id="Variable_Type_Format" value="<?php echo stripslashes($variable_info['Variable_Type_Format']); ?>" class="span6" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Length:
                    </td>
                    <td>
                        <input type="text" name="Variable_Length" id="Variable_Length" value="<?php echo stripslashes($variable_info['Variable_Length']); ?>" class="span6" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Values:
                    </td>
                    <td>
                        <textarea name="Variable_Values" id="Variable_Values" rows="5" class="span6"><?php echo stripslashes($variable_info['Variable_Values']); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Example:
                    </td>
                    <td>
                        <input type="text" name="Variable_Example" id="Variable_Example" value="<?php echo stripslashes($variable_info['Variable_Example']); ?>" class="span6" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Comments:
                    </td>
                    <td>
                        <input type="text" name="Variable_Comments" id="Variable_Comments" value="<?php echo stripslashes($variable_info['Variable_Comments']); ?>" class="span6" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Data Portal:
                    </td>
                    <td>
                        <select name="Data_Portal" id="Data_Portal">
                            <option value="Y">Y</option>
                            <option value="N"<?php echo ($variable_info['Data_Portal'] == 'N') ? ' selected="selected"' : ''; ?>>N</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Revision:
                    </td>
                    <td>
                        <?php echo ($variable_info['Last_Updated'] == '') ? $variable_info['Date_Created'] : $variable_info['Last_Updated']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Record Created:
                    </td>
                    <td>
                        <?php echo $variable_info['Date_Created']; ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href="javascript:;" class="btn btn-primary"
                               onclick="
                                    $.post(
                                        'ajax/create_new_variable_revision.php',
                                        {
                                            Variable_ID: document.getElementById('Variable_ID').value,
                                            Variable_Name: document.getElementById('Variable_Name').value,
                                            Variable_Description: document.getElementById('Variable_Description').value,
                                            Variable_Type_Format: document.getElementById('Variable_Type_Format').value,
                                            Variable_Length: document.getElementById('Variable_Length').value,
                                            Variable_Values: document.getElementById('Variable_Values').value,
                                            Variable_Example: document.getElementById('Variable_Example').value,
                                            Variable_Comments: document.getElementById('Variable_Comments').value,
                                            Data_Portal: document.getElementById('Data_Portal').options[document.getElementById('Data_Portal').selectedIndex].value,
                                            Creator: <?php echo $_COOKIE['user_id']; ?>,
                                            Table_ID: 'NULL'
                                        },
                                        function (response){
                                            if (response != '') {
                                                $('#variable_info_entry').slideToggle('slow');
                                                $('#variable_info_static').slideToggle('slow');
                                                document.getElementById('variable_revisions').innerHTML = response;
                                                document.getElementById('variable_message_box').innerHTML = '<i class=\'icon-ok\'></i> Added new revision successfully';
                                                $('#variable_message_box').attr('class', 'alert alert-success');
                                                $('#variable_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('variable_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the revision: '+response;
                                                $('#variable_message_box').attr('class', 'alert alert-error');
                                                $('#variable_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >Save Revision</a>
                        &nbsp; &nbsp; &nbsp;
                        <a href="javascript:;" class="btn"
                               onclick="$('#variable_info_entry').slideToggle('slow');
                                        $('#variable_info_static').slideToggle('slow');">Cancel</a>
                    </td>
                </tr>
            </table>

            <h4>Live Items</h4>
            
            <table class="table table-striped table-bordered">            
                <tr>
                    <td valign="top">
                        Public / Not Public:
                    </td>
                    <td>
                        <a href="javascript:;" id="public_button" class="btn<?php echo ($variable_info['Public'] == '1') ? ' btn-success' : ' btn-mini'; ?>" style="vertical-align: top;"
                               onclick="
                                    $.post(
                                        'ajax/toggle_public_element.php',
                                        {
                                            Variable_ID: <?php echo $variable_info['Variable_ID']; ?>,
                                            Public: 1
                                        },
                                        function (response){
                                            if (response == '') {
                                                //switch buttons
                                                $('#public_button').attr('class', 'btn btn-success');
                                                $('#non_public_button').attr('class', 'btn btn-mini');
                                                document.getElementById('variable_message_box').innerHTML = '<i class=\'icon-ok\'></i> Successfully made public';
                                                $('#variable_message_box').attr('class', 'alert alert-success');
                                                $('#variable_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('variable_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while publishing';
                                                $('#variable_message_box').attr('class', 'alert alert-error');
                                                $('#variable_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >Public</a>
                        &nbsp; &nbsp; &nbsp;
                        <a href="javascript:;" id="non_public_button" class="btn<?php echo ($variable_info['Public'] == '0') ? ' btn-primary' : ' btn-mini'; ?>" style="vertical-align: top;"
                               onclick="
                                    $.post(
                                        'ajax/toggle_public_element.php',
                                        {
                                            Variable_ID: <?php echo $variable_info['Variable_ID']; ?>,
                                            Public: 0
                                        },
                                        function (response){
                                            if (response == '') {
                                                //switch buttons
                                                $('#public_button').attr('class', 'btn btn-mini');
                                                $('#non_public_button').attr('class', 'btn btn-primary');
                                                document.getElementById('variable_message_box').innerHTML = '<i class=\'icon-ok\'></i> Successfully made non-public';
                                                $('#variable_message_box').attr('class', 'alert alert-success');
                                                $('#variable_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('variable_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while unpublishing';
                                                $('#variable_message_box').attr('class', 'alert alert-error');
                                                $('#variable_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >NOT Public</a>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        Parent (Table):
                    </td>
                    <td>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#Table_Name').autocomplete({
                                        source: [<?php
                                            //show all databases
                                            $all_tables = Table::get_all_tables();

                                            $all_tables_names = "";

                                            while ($table = mysqli_fetch_assoc($all_tables)) {
                                                $all_tables_names = $all_tables_names . "'" . addslashes($table['Table_Name']) . "',";
                                            }

                                            echo substr($all_tables_names, 0, (strlen($all_tables_names) - 1));
                                            ?>]
                                });
                            });
                        </script>
                        <input type="text" name="Table_Name" id="Table_Name" />

                        <a href="javascript:;" class="btn btn-primary" style="vertical-align: top;"
                               onclick="
                                    $.post(
                                        'ajax/create_table_variable_relationship.php',
                                        {
                                            Table_Name: document.getElementById('Table_Name').value,
                                            Variable_ID: <?php echo $variable_info['Variable_ID']; ?>
                                        },
                                        function (response){
                                            if (response != '') {
                                                document.getElementById('Table_Name').value = '';
                                                document.getElementById('variable_tables').innerHTML = response;
                                                document.getElementById('variable_message_box').innerHTML = '<i class=\'icon-ok\'></i> Added new relationship successfully';
                                                $('#variable_message_box').attr('class', 'alert alert-success');
                                                $('#variable_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('variable_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the relationship: ' + response;
                                                $('#variable_message_box').attr('class', 'alert alert-error');
                                                $('#variable_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >Add Parent Table</a>
                        <br />
                        <div id="variable_tables">
                            <?php include 'include/variable_tables.php'; ?>
                        </div>
                        <br />
                        <br />
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        Keyword(s):
                    </td>
                    <td>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#Keyword').autocomplete({
                                        source: [<?php
                                            //show all databases
                                            $all_keywords = Keyword::get_all_keywords();

                                            $keywords = "";

                                            while ($keyword = mysqli_fetch_assoc($all_keywords)) {
                                                $keywords = $keywords . "'" . addslashes($keyword['Keyword']) . "',";
                                            }

                                            echo substr($keywords, 0, (strlen($keywords) - 1));
                                            ?>]
                                });
                            });
                        </script>
                        <input type="text" name="Keyword" id="Keyword" class="span4" />
                        
                        <a href="javascript:;" class="btn btn-primary" style="vertical-align: top;"
                               onclick="
                                    $.post(
                                        'ajax/add_keyword.php',
                                        {
                                            Keyword: document.getElementById('Keyword').value,
                                            Element_Type: 'variable',
                                            Element_ID: <?php echo $variable_info['Variable_ID']; ?>
                                        },
                                        function (response){
                                            if (response != '') {
                                                document.getElementById('Keyword').value = '';
                                                document.getElementById('variable_keywords').innerHTML = response;
                                                document.getElementById('variable_message_box').innerHTML = '<i class=\'icon-ok\'></i> Added new keyword successfully';
                                                $('#variable_message_box').attr('class', 'alert alert-success');
                                                $('#variable_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('variable_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the keyword: ' + response;
                                                $('#variable_message_box').attr('class', 'alert alert-error');
                                                $('#variable_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >Add Keyword</a>
                        <br />
                        <div id="variable_keywords">
                            <?php include 'include/element_keywords.php'; ?>
                        </div>
                        <br />
                        <br />
                    </td>
                </tr>
            </table>
        </div>
        <div id="variable_create_new" style="display: none;">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>
                        Name:
                    </td>
                    <td>
                        <input type="text" name="Variable_Name_New" id="Variable_Name_New" value="" class="span6" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Description:
                    </td>
                    <td>
                        <textarea name="Variable_Description_New" id="Variable_Description_New" rows="5" class="span6"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Type / Format:
                    </td>
                    <td>
                        <input type="text" name="Variable_Type_Format_New" id="Variable_Type_Format_New" value="" class="span6" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Length:
                    </td>
                    <td>
                        <input type="text" name="Variable_Length_New" id="Variable_Length_New" value="" class="span6" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Values:
                    </td>
                    <td>
                        <textarea name="Variable_Values_New" id="Variable_Values_New" rows="5" class="span6"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Example:
                    </td>
                    <td>
                        <input type="text" name="Variable_Example_New" id="Variable_Example_New" value="" class="span6" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Comments:
                    </td>
                    <td>
                        <input type="text" name="Variable_Comments_New" id="Variable_Comments_New" value="" class="span6" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Data Portal:
                    </td>
                    <td>
                        <select name="Data_Portal_New" id="Data_Portal_New">
                            <option value="Y">Y</option>
                            <option value="N">N</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Parent (Table):
                    </td>
                    <td>
                        <select name="Table_ID_New" id="Table_ID_New">
                            <?php
                            //show all databases
                            $all_tables = Table::get_all_tables();
                            
                            while ($table = mysqli_fetch_assoc($all_tables)) {
                                ?>
                                <option value="<?php echo $table['Table_ID']; ?>"><?php echo $table['Table_Name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href="javascript:;" class="btn btn-primary"
                               onclick="
                                    $.post(
                                        'ajax/create_new_variable_revision.php',
                                        {
                                            Variable_ID: 'NULL',
                                            Variable_Name: document.getElementById('Variable_Name_New').value,
                                            Variable_Description: document.getElementById('Variable_Description_New').value,
                                            Variable_Type_Format: document.getElementById('Variable_Type_Format_New').value,
                                            Variable_Length: document.getElementById('Variable_Length_New').value,
                                            Variable_Values: document.getElementById('Variable_Values_New').value,
                                            Variable_Example: document.getElementById('Variable_Example_New').value,
                                            Variable_Comments: document.getElementById('Variable_Comments_New').value,
                                            Data_Portal: document.getElementById('Data_Portal_New').options[document.getElementById('Data_Portal_New').selectedIndex].value,
                                            Creator: <?php echo $_COOKIE['user_id']; ?>,
                                            Table_ID: document.getElementById('Table_ID_New').options[document.getElementById('Table_ID_New').selectedIndex].value
                                        },
                                        function (response){
                                            if (response != '') {
                                                $('#variable_create_new').slideToggle('slow');
                                                $('#variable_info_static').slideToggle('slow');
                                                document.getElementById('variable_revisions').innerHTML = response;
                                                document.getElementById('variable_message_box').innerHTML = '<i class=\'icon-ok\'></i> Added new revision successfully';
                                                $('#variable_message_box').attr('class', 'alert alert-success');
                                                $('#variable_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('variable_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the revision: ' + response;
                                                $('#variable_message_box').attr('class', 'alert alert-error');
                                                $('#variable_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >Create New Variable</a>
                        &nbsp; &nbsp; &nbsp;
                        <a href="javascript:;" class="btn"
                               onclick="$('#variable_create_new').slideToggle('slow');
                                        $('#variable_info_static').slideToggle('slow');">Cancel</a>
                    </td>
                </tr>
            </table>
        </div>
        <div id="variable_message_box" class="alert alert-block" style="display: none;"></div>
        <br />
        <a href="javascript:;" onclick="$('#variable_info_entry').slideUp('slow');
                                        $('#variable_info_static').slideUp('slow');
                                        $('#variable_create_new').slideDown('slow');
                                        $('#Variable_Name_New').focus();">
                                        <i class="icon-plus"></i> Create New Variable</a>
        |
        <a href="javascript:;" onclick="$('#variable_info_entry').slideDown('slow');
                                        $('#variable_info_static').slideUp('slow');
                                        $('#variable_create_new').slideUp('slow');
                                        $('#Variable_Name').focus();">
                                        <i class="icon-pencil"></i> Change Info</a>
        |
        <a href="javascript:;" onclick="$('#variable_revisions').slideToggle('slow');">
            <i class="icon-th"></i> Variable Revisions</a>
        |
        <a href="export_info.php?variable_id=<?php echo $variable_info['Variable_ID']; ?>">
            <i class="icon-download-alt"></i> Export</a>
        
        <br />
        <div id="variable_revisions" style="display: none;">
            <?php include 'include/variable_revisions.php'; ?>
        </div>
        <?php
    }
}
?>

<br />
Parent Table(s):<br />
<table border="1" style="width: 90%; margin-left: auto; margin-right: auto;"
    class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <td>
                Name
            </td>
            <td>
                Description
            </td>
        </tr>
    </thead>
    <tbody>
        <?php
        //show table variables
        $variable_tables = Variable::get_variable_tables($variable_info['Variable_ID']);

        while ($table = mysqli_fetch_assoc($variable_tables)) {
            ?>
            <tr>
                <td>
                    <a href="table_info.php?table_id=<?php echo $table['Table_ID']; ?>"><?php echo $table['Table_Name']; ?></a>
                </td>
                <td>
                    <?php echo $table['Table_Description']; ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>


<?php
include 'include/footer.php';
?>