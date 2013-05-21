<?php
include 'classes/database.php';
include 'classes/business_function.php';
include 'classes/keyword.php';

$database_info = Database::get_database_info($_GET['database_id']);

//if the user is not logged in and the item isn't public
if (!isset($_COOKIE['user_id']) && ($database_info['Public'] == '0')) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

Database::add_view($_GET['database_id']);

//recently viewed link
$recently_viewed_link = '<li><a href="database_info.php?database_id=' . $database_info['Database_ID'] . '"><i class="icon-th-large"></i> ' . $database_info['Database_Name'] . '</a> (database)</li>';

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
    Database Detail
</div>
<br />
<div id="database_info_static">
    <table class="table table-striped table-bordered">
        <tr>
            <td>
                <div class="span2">Database Name:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes($database_info['Database_Name']); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Description:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes(nl2br($database_info['Description'])); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Business Owner:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes(nl2br($database_info['Business_Owner'])); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Contact Information:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes(nl2br($database_info['Contact_Information'])); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Data Period:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes(nl2br($database_info['Data_Period'])); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Software Platform:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes(nl2br($database_info['Software_Platform'])); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">General Accuracy, Completeness, Limitations:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes(nl2br($database_info['General_Accuracy'])); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Comments:</div>
            </td>
            <td>
                <div class="span6"><?php echo stripslashes(nl2br($database_info['Comments'])); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="span2">Last Updated:</div>
            </td>
            <td>
                <div class="span6"><?php echo ($database_info['Last_Updated'] == '') ? $database_info['Date_Created'] : $database_info['Last_Updated']; ?></div>
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
        <div id="database_info_entry" style="display: none;">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>
                        Database Name:
                    </td>
                    <td>
                        <input type="hidden" name="Database_ID" id="Database_ID" value="<?php echo $database_info['Database_ID']; ?>" />
                        <input type="text" name="Database_Name" id="Database_Name" value="<?php echo stripslashes($database_info['Database_Name']); ?>" class="span4" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Description:
                    </td>
                    <td>
                        <textarea name="Description" id="Description" rows="5" class="span6"><?php echo stripslashes($database_info['Description']); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Business Owner:
                    </td>
                    <td>
                        <textarea name="Business_Owner" id="Business_Owner" rows="5" class="span6"><?php echo stripslashes($database_info['Business_Owner']); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Contact Information:
                    </td>
                    <td>
                        <textarea name="Contact_Information" id="Contact_Information" rows="5" class="span6"><?php echo stripslashes($database_info['Contact_Information']); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Data Period:
                    </td>
                    <td>
                        <textarea name="Data_Period" id="Data_Period" rows="5" class="span6"><?php echo stripslashes($database_info['Data_Period']); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Software Platform:
                    </td>
                    <td>
                        <textarea name="Software_Platform" id="Software_Platform" rows="5" class="span6"><?php echo stripslashes($database_info['Software_Platform']); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        General Accuracy, Completeness, Limitations:
                    </td>
                    <td>
                        <textarea name="General_Accuracy" id="General_Accuracy" rows="5" class="span6"><?php echo stripslashes($database_info['General_Accuracy']); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Comments:
                    </td>
                    <td>
                        <textarea name="Comments" id="Comments" rows="5" class="span6"><?php echo stripslashes($database_info['Comments']); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Revision:
                    </td>
                    <td>
                        <?php echo ($database_info['Last_Updated'] == '') ? $database_info['Date_Created'] : $database_info['Last_Updated']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Record Created:
                    </td>
                    <td>
                        <?php echo $database_info['Date_Created']; ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href="javascript:;" class="btn btn-primary"
                               onclick="
                                    $.post(
                                        'ajax/create_new_database_revision.php',
                                        {
                                            Database_ID: document.getElementById('Database_ID').value,
                                            Database_Name: document.getElementById('Database_Name').value,
                                            Description: document.getElementById('Description').value,
                                            Business_Owner: document.getElementById('Business_Owner').value,
                                            Contact_Information: document.getElementById('Contact_Information').value,
                                            Data_Period: document.getElementById('Data_Period').value,
                                            Software_Platform: document.getElementById('Software_Platform').value,
                                            General_Accuracy: document.getElementById('General_Accuracy').value,
                                            Comments: document.getElementById('Comments').value,
                                            Creator: <?php echo $_COOKIE['user_id']; ?>
                                        },
                                        function (response){
                                            if (response != '') {
                                                $('#database_info_entry').slideToggle('slow');
                                                $('#database_info_static').slideToggle('slow');
                                                document.getElementById('database_revisions').innerHTML = response;
                                                document.getElementById('database_message_box').innerHTML = '<i class=\'icon-ok\'></i> Added new revision successfully';
                                                $('#database_message_box').attr('class', 'alert alert-success');
                                                $('#database_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('database_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the revision: ' + response;
                                                $('#database_message_box').attr('class', 'alert alert-error');
                                                $('#database_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >Save Revision</a>
                        &nbsp; &nbsp; &nbsp;
                        <a href="javascript:;" class="btn"
                               onclick="$('#database_info_entry').slideToggle('slow');
                                        $('#database_info_static').slideToggle('slow');">Cancel</a>
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
                        <a href="javascript:;" id="public_button" class="btn<?php echo ($database_info['Public'] == '1') ? ' btn-success' : ' btn-mini'; ?>" style="vertical-align: top;"
                               onclick="
                                    $.post(
                                        'ajax/toggle_public_element.php',
                                        {
                                            Database_ID: <?php echo $database_info['Database_ID']; ?>,
                                            Public: 1
                                        },
                                        function (response){
                                            if (response == '') {
                                                //switch buttons
                                                $('#public_button').attr('class', 'btn btn-success');
                                                $('#non_public_button').attr('class', 'btn btn-mini');
                                                document.getElementById('database_message_box').innerHTML = '<i class=\'icon-ok\'></i> Successfully made public';
                                                $('#database_message_box').attr('class', 'alert alert-success');
                                                $('#database_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('database_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while publishing';
                                                $('#database_message_box').attr('class', 'alert alert-error');
                                                $('#database_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >Public</a>
                        &nbsp; &nbsp; &nbsp;
                        <a href="javascript:;" id="non_public_button" class="btn<?php echo ($database_info['Public'] == '0') ? ' btn-primary' : ' btn-mini'; ?>" style="vertical-align: top;"
                               onclick="
                                    $.post(
                                        'ajax/toggle_public_element.php',
                                        {
                                            Database_ID: <?php echo $database_info['Database_ID']; ?>,
                                            Public: 0
                                        },
                                        function (response){
                                            if (response == '') {
                                                //switch buttons
                                                $('#public_button').attr('class', 'btn btn-mini');
                                                $('#non_public_button').attr('class', 'btn btn-primary');
                                                document.getElementById('database_message_box').innerHTML = '<i class=\'icon-ok\'></i> Successfully made non-public';
                                                $('#database_message_box').attr('class', 'alert alert-success');
                                                $('#database_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('database_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while unpublishing';
                                                $('#database_message_box').attr('class', 'alert alert-error');
                                                $('#database_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >NOT Public</a>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        Business Function(s):
                    </td>
                    <td>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#business_functions').autocomplete({
                                        source: [<?php
                                            //show all databases
                                            $all_business_functions = Business_Function::get_all_business_functions();

                                            $business_functions = "";

                                            while ($business_function = mysqli_fetch_assoc($all_business_functions)) {
                                                $business_functions = $business_functions . "'" . addslashes($business_function['Business_Function_Name']) . "',";
                                            }

                                            echo substr($business_functions, 0, (strlen($business_functions) - 1));
                                            ?>]
                                });
                            });
                        </script>
                        <input type="text" name="business_functions" id="business_functions" class="span4" />
                        
                        <a href="javascript:;" class="btn btn-primary" style="vertical-align: top;"
                               onclick="
                                    $.post(
                                        'ajax/add_business_function.php',
                                        {
                                            Business_Function_Name: document.getElementById('business_functions').value,
                                            Database_ID: <?php echo $database_info['Database_ID']; ?>
                                        },
                                        function (response){
                                            if (response != '') {
                                                document.getElementById('business_functions').value = '';
                                                document.getElementById('database_business_functions').innerHTML = response;
                                                document.getElementById('database_message_box').innerHTML = '<i class=\'icon-ok\'></i> Added new keyword successfully';
                                                $('#database_message_box').attr('class', 'alert alert-success');
                                                $('#database_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('database_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while adding the business function (it may already be added)';
                                                $('#database_message_box').attr('class', 'alert alert-error');
                                                $('#database_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >Add Business Function</a>
                        <br />
                        <div id="database_business_functions">
                            <?php include 'include/database_business_functions.php'; ?>
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
                                            Element_Type: 'database',
                                            Element_ID: <?php echo $database_info['Database_ID']; ?>
                                        },
                                        function (response){
                                            if (response != '') {
                                                document.getElementById('Keyword').value = '';
                                                document.getElementById('database_keywords').innerHTML = response;
                                                document.getElementById('database_message_box').innerHTML = '<i class=\'icon-ok\'></i> Added new keyword successfully';
                                                $('#database_message_box').attr('class', 'alert alert-success');
                                                $('#database_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('database_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the keyword: ' + response;
                                                $('#database_message_box').attr('class', 'alert alert-error');
                                                $('#database_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >Add Keyword</a>
                        <br />
                        <div id="database_keywords">
                            <?php include 'include/element_keywords.php'; ?>
                        </div>
                        <br />
                        <br />
                    </td>
                </tr>
            </table>
        </div>
        <div id="database_create_new" style="display: none;">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>
                        Database Name:
                    </td>
                    <td>
                        <input type="text" name="Database_Name_New" id="Database_Name_New" value="" class="span4" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Description:
                    </td>
                    <td>
                        <textarea name="Description_New" id="Description_New" rows="5" class="span6"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Business Owner:
                    </td>
                    <td>
                        <textarea name="Business_Owner_New" id="Business_Owner_New" rows="5" class="span6"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Contact Information:
                    </td>
                    <td>
                        <textarea name="Contact_Information_New" id="Contact_Information_New" rows="5" class="span6"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Data Period:
                    </td>
                    <td>
                        <textarea name="Data_Period_New" id="Data_Period_New" rows="5" class="span6"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Software Platform:
                    </td>
                    <td>
                        <textarea name="Software_Platform_New" id="Software_Platform_New" rows="5" class="span6"></textarea>

                    </td>
                </tr>
                <tr>
                    <td>
                        General Accuracy, Completeness, Limitations:
                    </td>
                    <td>
                        <textarea name="General_Accuracy_New" id="General_Accuracy_New" rows="5" class="span6"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        Comments:
                    </td>
                    <td>
                        <textarea name="Comments_New" id="Comments_New" rows="5" class="span6"></textarea>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="button" value="Create New Database" class="btn btn-primary"
                               onclick="
                                    $.post(
                                        'ajax/create_new_database_revision.php',
                                        {
                                            Database_ID: 'NULL',
                                            Database_Name: document.getElementById('Database_Name_New').value,
                                            Description: document.getElementById('Description_New').value,
                                            Business_Owner: document.getElementById('Business_Owner_New').value,
                                            Contact_Information: document.getElementById('Contact_Information_New').value,
                                            Data_Period: document.getElementById('Data_Period_New').value,
                                            Software_Platform: document.getElementById('Software_Platform_New').value,
                                            General_Accuracy: document.getElementById('General_Accuracy_New').value,
                                            Comments: document.getElementById('Comments_New').value,
                                            Creator: <?php echo $_COOKIE['user_id']; ?>
                                        },
                                        function (response){
                                            if (response != '') {
                                                $('#database_create_new').slideToggle('slow');
                                                $('#database_info_static').slideToggle('slow');
                                                document.getElementById('database_revisions').innerHTML = response;
                                                document.getElementById('database_message_box').innerHTML = '<i class=\'icon-ok\'></i> Added new revision successfully';
                                                $('#database_message_box').attr('class', 'alert alert-success');
                                                $('#database_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('database_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while saving the revision: ' + response;
                                                $('#database_message_box').attr('class', 'alert alert-error');
                                                $('#database_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               />
                        &nbsp; &nbsp; &nbsp;
                        <input type="button" value="Cancel" class="btn"
                               onclick="$('#database_create_new').slideToggle('slow');
                                        $('#database_info_static').slideToggle('slow');" />
                    </td>
                </tr>
            </table>
        </div>
        <div id="database_message_box" class="alert alert-block" style="display: none;"></div>
        <br />
        <a href="javascript:;" onclick="$('#database_info_entry').slideUp('slow');
                                        $('#database_info_static').slideUp('slow');
                                        $('#database_create_new').slideDown('slow');
                                        $('#Database_Name_New').focus();">
                                        <i class="icon-plus"></i> Create New DB</a>
        |
        <a href="javascript:;" onclick="$('#database_info_entry').slideDown('slow');
                                        $('#database_info_static').slideUp('slow');
                                        $('#database_create_new').slideUp('slow');
                                        $('#Database_Name').focus();">
                                        <i class="icon-pencil"></i> Change Info</a>
        |
        <a href="javascript:;" onclick="$('#database_revisions').slideToggle('slow');">
            <i class="icon-th-large"></i> Database Revisions</a>
        |
        <a href="export_info.php?database_id=<?php echo $database_info['Database_ID']; ?>">
            <i class="icon-download-alt"></i> Export</a>
        <br />
        
        <div id="database_revisions" style="display: none;">
            <?php include 'include/database_revisions.php'; ?>
        </div>
        <?php
    }
}
?>

<br />
Tables / Datasets:<br />
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
        //show database tables
        $database_tables = Database::get_database_tables($database_info['Database_ID']);

        while ($table = mysqli_fetch_assoc($database_tables)) {
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

<br />
Business Functions:<br />
<table border="1" style="width: 90%; margin-left: auto; margin-right: auto;"
       class="table table-striped table-bordered table-hover">
    <tbody>
        <?php
        //show business functions
        $database_business_functions = Database::get_business_functions($database_info['Database_ID']);

        while ($database_business_function = mysqli_fetch_assoc($database_business_functions)) {
            ?>
            <tr>
                <td>
                    <a href="business_functions.php?business_function_id=<?php echo $database_business_function['Business_Function_ID']; ?>"><?php echo $database_business_function['Business_Function_Name']; ?></a>
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
