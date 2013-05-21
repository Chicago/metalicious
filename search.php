<?php
include 'classes/database.php';
include 'classes/table.php';
include 'classes/variable.php';

include 'include/header.php';

//open DB
include 'include/dbconnopen.php';
$search_results = mysqli_query($cnnCDD, "Call Main_Search('" . $_POST['search_criteria'] . "')");

//close DB
include ('include/dbconnclose.php');
?>
<script>
    $(document).ready(function() {
        document.getElementsByName('search_criteria')[1].focus();
    });
</script>

<h3>Search Results:</h3>
<form action="search.php" method="post">
    <input type="text" id="search_criteria" class="main-search span5" name="search_criteria" style="margin: 0px;" value="<?php echo (isset($_POST['search_criteria'])) ? $_POST['search_criteria'] : ''; ?>" />
    <input type="submit" class="btn btn-primary" value="Search" />
</form>

<div style="margin-left: 20px;">
    <?php
    while ($result_element = mysqli_fetch_assoc($search_results)) {
        //if element is a database
        if ($result_element['Element_Type'] == 'Database') {
            $database = Database::get_database_info($result_element['Element_ID']);
            ?>
            <a href="database_info.php?database_id=<?php echo $database['Database_ID']; ?>"><i class="icon-th-large"></i> <?php echo $database['Database_Name']; ?></a> (database)<br />
            <?php
        } else if ($result_element['Element_Type'] == 'Table') {
            $table = Table::get_table_info($result_element['Element_ID']);
            ?>
            <a href="table_info.php?table_id=<?php echo $table['Table_ID']; ?>"><i class="icon-th"></i> <?php echo $table['Table_Name']; ?></a> (table)<br />
            <?php
        } else if ($result_element['Element_Type'] == 'Variable') {
            $variable = Variable::get_variable_info($result_element['Element_ID']);
            ?>
            <a href="variable_info.php?variable_id=<?php echo $variable['Variable_ID']; ?>"><i class="icon-asterisk"></i> <?php echo $variable['Variable_Name']; ?></a> (variable)<br />
            <?php
        }
    }
    ?>
</div>

<?php include 'include/footer.php'; ?>
