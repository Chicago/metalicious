<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
Proof of Concept - POC
<hr />
<form action="index.php" method="post">
    Search: <input type="text" id="search_criteria" name="search_criteria" value="<?php echo $_POST['search_criteria']; ?>" />
    <input type="submit" value="Submit" /><br />
    <a href="index.php">Clear Search</a>
</form>
<hr />

<?php
//open db
include 'include/dbconnopen.php';

//get all element info
$data_element_info = mysqli_query($cnnCDD, "Call Get_Data_Element_Info('" . $_GET['data_element_id'] . "')");

//close DB
include 'include/dbconnclose.php';

//parent info
//open db
include 'include/dbconnopen.php';

//get all element info
$parent_data_element_info = mysqli_query($cnnCDD, "Call Get_Data_Element_Parent_Info('" . $_GET['data_element_id'] . "')");

//close DB
include 'include/dbconnclose.php';

//children info
//open db
include 'include/dbconnopen.php';

//get all element info
$children = mysqli_query($cnnCDD, "Call Get_Data_Element_Children('" . $_GET['data_element_id'] . "')");

//close DB
include 'include/dbconnclose.php';

?>
DATA ELEMENT INFO:
<hr />
<br />
Parent:
<?php
if ($parent_data_element_info->num_rows > 0) {
    ?>
    <?php
    //show children
    while ($parent_info = mysqli_fetch_assoc($parent_data_element_info)) {
        echo "<pre><a href=\"./data_element_info.php?data_element_id=" . $parent_info['Element_ID'] . "\">";
        print_r($parent_info);
        echo "</pre></a><br />";
    }
} else {
    echo "No Parent";
}
?>


<hr />
<br />
Element Info:
<?php
if ($data_element_info->num_rows > 0) {
    ?>
    <?php
    //show children
    while ($element_info = mysqli_fetch_assoc($data_element_info)) {
        echo "<pre>";
        print_r($element_info);
        echo "</pre><br />";
    }
} else {
    echo "No Element Found With Element_ID #" . $_GET['data_element_id'];
}
?>


<hr />
<br />
Children:
<?php
if ($children->num_rows > 0) {
    ?>
    <a href="javascript:;" onclick="$('#children_<?php echo $db_info['Element_ID']; ?>').slideToggle('slow');">Children</a>
    <?php
    echo "<hr /><div id=\"children_" . $db_info['Element_ID'] . "\" style=\"display: none;\">";

    //show children
    while ($child_info = mysqli_fetch_assoc($children)) {
        echo "<pre><a href=\"data_element_info.php?data_element_id=" . $child_info['Element_ID'] . "\">";
        print_r($child_info);
        echo "</pre></a><br />";
    }
    echo "</div>";
} else {
    echo "No Children";
}

echo "<hr />";
?>

<a href="export_info.php?data_element_id=<?php echo $_GET['data_element_id']; ?>">Export Info</a>