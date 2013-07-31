<?php
include_once dirname(__FILE__) . '/../classes/database.php';
include_once dirname(__FILE__) . '/../classes/table.php';
include_once dirname(__FILE__) . '/../classes/variable.php';

//if a new keyword is to be added
if (isset($_POST['Keyword'])) {
    $element_type = $_POST['Element_Type'];
    //if it's a database
    if ($element_type == 'database') {
        $element_id = $_POST['Element_ID'];
        $element_keywords = Database::get_keywords($element_id);
    } elseif ($element_type == 'table') {
        $element_id = $_POST['Element_ID'];
        $element_keywords = Table::get_keywords($element_id);
    } elseif ($element_type == 'variable') {
        $element_id = $_POST['Element_ID'];
        $element_keywords = Variable::get_keywords($element_id);
    }
//if no post
} else {
    //if database
    if (isset($_GET['database_id'])) {
        $element_type = 'database';
        $element_id = $_GET['database_id'];
        $element_keywords = Database::get_keywords($element_id);
    //if table
    } elseif (isset($_GET['table_id'])) {
        $element_type = 'table';
        $element_id = $_GET['table_id'];
        $element_keywords = Table::get_keywords($element_id);
    //if variable
    } elseif (isset($_GET['variable_id'])) {
        $element_type = 'variable';
        $element_id = $_GET['variable_id'];
        $element_keywords = Variable::get_keywords($element_id);
    }
}

//show keywords
while ($element_keyword = mysqli_fetch_assoc($element_keywords)) {
    ?>
    <div id="<?php echo $element_type; ?>_keyword_<?php echo $element_keyword['Keyword_ID']; ?>" class="btn btn-mini btn-warning">
        <a href="javascript:;" title="Remove This Keyword" onclick="
                            if (confirm('Are you sure you want to remove this keyword?')) {
                                $.post(
                                    'ajax/remove_keyword.php',
                                    {
                                        Keyword: '<?php echo addslashes($element_keyword['Keyword']); ?>',
                                        Element_Type: '<?php echo $element_type; ?>',
                                        Element_ID: <?php echo $element_id; ?>
                                    },
                                    function (response){
                                        if (response == '') {
                                            document.getElementById('<?php echo $element_type; ?>_message_box').innerHTML = '<i class=\'icon-ok\'></i> Removed keyword successfully';
                                            $('#<?php echo $element_type; ?>_message_box').attr('class', 'alert alert-success');
                                            $('#<?php echo $element_type; ?>_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                        } else {
                                            document.getElementById('<?php echo $element_type; ?>_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while removing keyword: ' + response;
                                            $('#<?php echo $element_type; ?>_message_box').attr('class', 'alert alert-error');
                                            $('#<?php echo $element_type; ?>_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                        }
                                    }
                                );
                                $('#<?php echo $element_type; ?>_keyword_<?php echo $element_keyword['Keyword_ID']; ?>').slideUp('slow');
                            }"><i class="icon-remove-circle"></i></a>
        <?php echo $element_keyword['Keyword']; ?>
    </div>
    <?php
}
?>