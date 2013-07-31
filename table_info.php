<?php
include 'classes/database.php';
include 'classes/table.php';
include 'classes/keyword.php';

$table_info = Table::get_table_info($_GET['table_id']);

//if the user is not logged in and the item isn't public
if (!isset($_COOKIE['user_id']) && ($table_info['Public'] == '0')) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

Table::add_view($_GET['table_id']);

//recently viewed link
$recently_viewed_link = '<li><a href="table_info.php?table_id=' . $table_info['Table_ID'] . '"><i class="icon-th"></i> ' . $table_info['Table_Name'] . '</a> (table)</li>';

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
    Table Detail
</div>
<br />
<div id="table_info_static">
    <table class="table table-striped table-bordered">
        <tr>
            <td>
                <div class="span2">Table Name:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes($table_info['Table_Name']); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Description:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes(nl2br($table_info['Table_Description'])); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Comments:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes(nl2br($table_info['Table_Comments'])); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Last Updated:</div>
            </td>
            <td>
                <div class="span6"><?php echo ($table_info['Last_Updated'] == '') ? $table_info['Date_Created'] : $table_info['Last_Updated']; ?></div>
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
        <div id="table_info_entry" style="display: none;">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>
                        Table Name:
                    </td>
                    <td>
                        <input type="hidden" name="Table_ID" id="Table_ID" value="<?php echo $table_info['Table_ID']; ?>" />
                        <input type="text" name="Table_Name" id="Table_Name" value="<?php echo stripslashes($table_info['Table_Name']); ?>" class="span6" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Description:
                    </td>
                    <td>
                        <textarea name="Table_Description" id="Table_Description" rows="5" class="span6"><?php echo stripslashes($table_info['Table_Description']); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Comments:
                    </td>
                    <td>
                        <textarea name="Table_Comments" id="Table_Comments" rows="5" class="span6"><?php echo stripslashes($table_info['Table_Comments']); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Revision:
                    </td>
                    <td>
                        <?php echo ($table_info['Last_Updated'] == '') ? $table_info['Date_Created'] : $table_info['Last_Updated']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Record Created:
                    </td>
                    <td>
                        <?php echo $table_info['Date_Created']; ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href="javascript:;" class="btn btn-primary"
                               onclick="
                                    $.post(
                                        'ajax/create_new_table_revision.php',
                                        {
                                            Table_ID: document.getElementById('Table_ID').value,
                                            Table_Name: document.getElementById('Table_Name').value,
                                            Table_Description: document.getElementById('Table_Description').value,
                                            Table_Comments: document.getElementById('Table_Comments').value,
                                            Creator: <?php echo $_COOKIE['user_id']; ?>,
                                            Database_ID: ''
                                        },
                                        function (response){
                                            if (response != '') {
                                                $('#table_info_entry').slideToggle('slow');
                                                $('#table_info_static').slideToggle('slow');
                                                document.getElementById('table_revisions').innerHTML = response;
                                                document.getElementById('table_message_box').innerHTML = '<i class=\'icon-ok\'></i> Added new revision successfully';
                                                $('#table_message_box').attr('class', 'alert alert-success');
                                                $('#table_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('table_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the revision: '+response;
                                                $('#table_message_box').attr('class', 'alert alert-error');
                                                $('#table_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >Save Revision</a>
                        &nbsp; &nbsp; &nbsp;
                        <a href="javascript:;" class="btn"
                               onclick="$('#table_info_entry').slideToggle('slow');
                                        $('#table_info_static').slideToggle('slow');">Cancel</a>
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
                        <a href="javascript:;" id="public_button" class="btn<?php echo ($table_info['Public'] == '1') ? ' btn-success' : ' btn-mini'; ?>" style="vertical-align: top;"
                               onclick="
                                    $.post(
                                        'ajax/toggle_public_element.php',
                                        {
                                            Table_ID: <?php echo $table_info['Table_ID']; ?>,
                                            Public: 1
                                        },
                                        function (response){
                                            if (response == '') {
                                                //switch buttons
                                                $('#public_button').attr('class', 'btn btn-success');
                                                $('#non_public_button').attr('class', 'btn btn-mini');
                                                document.getElementById('table_message_box').innerHTML = '<i class=\'icon-ok\'></i> Successfully made public';
                                                $('#table_message_box').attr('class', 'alert alert-success');
                                                $('#table_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('table_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while publishing';
                                                $('#table_message_box').attr('class', 'alert alert-error');
                                                $('#table_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >Public</a>
                        &nbsp; &nbsp; &nbsp;
                        <a href="javascript:;" id="non_public_button" class="btn<?php echo ($table_info['Public'] == '0') ? ' btn-primary' : ' btn-mini'; ?>" style="vertical-align: top;"
                               onclick="
                                    $.post(
                                        'ajax/toggle_public_element.php',
                                        {
                                            Table_ID: <?php echo $table_info['Table_ID']; ?>,
                                            Public: 0
                                        },
                                        function (response){
                                            if (response == '') {
                                                //switch buttons
                                                $('#public_button').attr('class', 'btn btn-mini');
                                                $('#non_public_button').attr('class', 'btn btn-primary');
                                                document.getElementById('table_message_box').innerHTML = '<i class=\'icon-ok\'></i> Successfully made non-public';
                                                $('#table_message_box').attr('class', 'alert alert-success');
                                                $('#table_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('table_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while unpublishing';
                                                $('#table_message_box').attr('class', 'alert alert-error');
                                                $('#table_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >NOT Public</a>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        Parent Database(s):
                    </td>
                    <td>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#Database_Name').autocomplete({
                                        source: [<?php
                                            //show all databases
                                            $all_databases = Database::get_all_databases();

                                            $all_databases_names = "";

                                            while ($database = mysqli_fetch_assoc($all_databases)) {
                                                $all_databases_names = $all_databases_names . "'" . addslashes($database['Database_Name']) . "',";
                                            }

                                            echo substr($all_databases_names, 0, (strlen($all_databases_names) - 1));
                                            ?>]
                                });
                            });
                        </script>
                        <input type="text" name="Database_Name" id="Database_Name" class="span4" />

                        <a href="javascript:;" class="btn btn-primary" style="vertical-align: top;"
                               onclick="
                                    $.post(
                                        'ajax/create_database_table_relationship.php',
                                        {
                                            Database_Name: document.getElementById('Database_Name').value,
                                            Table_ID: <?php echo $table_info['Table_ID']; ?>
                                        },
                                        function (response){
                                            if (response != '') {
                                                document.getElementById('Database_Name').value = '';
                                                document.getElementById('table_databases').innerHTML = response;
                                                document.getElementById('table_message_box').innerHTML = '<i class=\'icon-ok\'></i> Added new relationship successfully';
                                                $('#table_message_box').attr('class', 'alert alert-success');
                                                $('#table_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('table_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the relationship: ' + response;
                                                $('#table_message_box').attr('class', 'alert alert-error');
                                                $('#table_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >Add Database</a>
                        <br />
                        <div id="table_databases">
                            <?php include 'include/table_databases.php'; ?>
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
                                            Element_Type: 'table',
                                            Element_ID: <?php echo $table_info['Table_ID']; ?>
                                        },
                                        function (response){
                                            if (response != '') {
                                                document.getElementById('Keyword').value = '';
                                                document.getElementById('table_keywords').innerHTML = response;
                                                document.getElementById('table_message_box').innerHTML = '<i class=\'icon-ok\'></i> Added new keyword successfully';
                                                $('#table_message_box').attr('class', 'alert alert-success');
                                                $('#table_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('table_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the keyword: ' + response;
                                                $('#table_message_box').attr('class', 'alert alert-error');
                                                $('#table_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >Add Keyword</a>
                        <br />
                        <div id="table_keywords">
                            <?php include 'include/element_keywords.php'; ?>
                        </div>
                        <br />
                        <br />
                    </td>
                </tr>
            </table>
        </div>
        <div id="table_create_new" style="display: none;">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>
                        Table Name:
                    </td>
                    <td>
                        <input type="text" name="Table_Name_New" id="Table_Name_New" value="" class="span6" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Description:
                    </td>
                    <td>
                        <textarea name="Table_Description_New" id="Table_Description_New" rows="5" class="span6"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Comments:
                    </td>
                    <td>
                        <textarea name="Table_Comments_New" id="Table_Comments_New" rows="5" class="span6"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Parent (Database):
                    </td>
                    <td>
                        <select name="Database_ID_New" id="Database_ID_New">
                            <?php
                            //show all databases
                            $all_databases = Database::get_all_databases();
                            
                            while ($database = mysqli_fetch_assoc($all_databases)) {
                                ?>
                                <option value="<?php echo $database['Database_ID']; ?>"><?php echo $database['Database_Name']; ?></option>
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
                                        'ajax/create_new_table_revision.php',
                                        {
                                            Table_ID: 'NULL',
                                            Table_Name: document.getElementById('Table_Name_New').value,
                                            Table_Description: document.getElementById('Table_Description_New').value,
                                            Table_Comments: document.getElementById('Table_Comments_New').value,
                                            Creator: <?php echo $_COOKIE['user_id']; ?>,
                                            Database_ID: document.getElementById('Database_ID_New').options[document.getElementById('Database_ID_New').selectedIndex].value
                                        },
                                        function (response){
                                            if (response != '') {
                                                $('#table_create_new').slideToggle('slow');
                                                $('#table_info_static').slideToggle('slow');
                                                document.getElementById('table_revisions').innerHTML = response;
                                                document.getElementById('table_message_box').innerHTML = '<i class=\'icon-ok\'></i> Added new revision successfully';
                                                $('#table_message_box').attr('class', 'alert alert-success');
                                                $('#table_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('table_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the revision: ' + response;
                                                $('#table_message_box').attr('class', 'alert alert-error');
                                                $('#table_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >Create New Table</a>
                        &nbsp; &nbsp; &nbsp;
                        <a href="javascript:;" class="btn"
                               onclick="$('#table_create_new').slideToggle('slow');
                                        $('#table_info_static').slideToggle('slow');">Cancel</a>
                    </td>
                </tr>
            </table>
        </div>
        <div id="table_message_box" class="alert alert-block" style="display: none;"></div>
        <br />
        <a href="javascript:;" onclick="$('#table_info_entry').slideUp('slow');
                                        $('#table_info_static').slideUp('slow');
                                        $('#table_create_new').slideDown('slow');
                                        $('#Table_Name_New').focus();">
                                        <i class="icon-plus"></i> Create New Table</a>
        |
        <a href="javascript:;" onclick="$('#table_info_entry').slideDown('slow');
                                        $('#table_info_static').slideUp('slow');
                                        $('#table_create_new').slideUp('slow');
                                        $('#Table_Name').focus();">
                                        <i class="icon-pencil"></i> Change Info</a>
        |
        <a href="javascript:;" onclick="$('#table_revisions').slideToggle('slow');">
            <i class="icon-th"></i> Table Revisions</a>
        |
        <a href="export_info.php?table_id=<?php echo $table_info['Table_ID']; ?>">
            <i class="icon-download-alt"></i> Export</a>
        
        <br />
        <div id="table_revisions" style="display: none;">
            <?php include 'include/table_revisions.php'; ?>
        </div>
        <?php
    }
}
?>

<br />
Variables:<br />
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
            <td>
                Type / Format
            </td>
            <td>
                Length
            </td>
            <td>
                Values
            </td>
        </tr>
    </thead>
    <tbody>
        <?php
        //show table variables
        $table_variables = Table::get_table_variables($table_info['Table_ID']);

        while ($variable = mysqli_fetch_assoc($table_variables)) {
            ?>
            <tr>
                <td>
                    <a href="variable_info.php?variable_id=<?php echo $variable['Variable_ID']; ?>"><?php echo stripslashes($variable['Variable_Name']); ?></a>
                </td>
                <td>
                    <?php echo stripslashes($variable['Variable_Description']); ?>
                </td>
                <td>
                    <?php echo stripslashes($variable['Variable_Type_Format']); ?>
                </td>
                <td>
                    <?php echo stripslashes($variable['Variable_Length']); ?>
                </td>
                <td>
                    <?php echo stripslashes($variable['Variable_Values']); ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>

<br />
Parent Database(s):<br />
<table border="1" style="width: 90%; margin-left: auto; margin-right: auto;"
       class="table table-striped table-bordered table-hover">
    <tbody>
        <?php
        //show parent databases
        $parent_databases = Table::get_parent_databases($table_info['Table_ID']);

        while ($parent_database = mysqli_fetch_assoc($parent_databases)) {
            ?>
            <tr>
                <td>
                    <a href="database_info.php?database_id=<?php echo $parent_database['Database_ID']; ?>"><?php echo stripslashes($parent_database['Database_Name']); ?></a>
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