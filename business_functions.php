<?php
include dirname(__FILE__) . '/classes/business_function.php';

include dirname(__FILE__) . '/include/header.php';
?>
<script>
    $(document).ready(function() {
        document.getElementsByName('search_criteria')[1].focus();
    });
</script>

<div class="row">
    <?php
    if (isset($_GET['business_function_id'])) {
        //get business function DBs
        $business_function_info = Business_Function::get_business_function_info($_GET['business_function_id']);
        ?>
        <div class="span6" style="margin-right: 20px;">
            <h1><?php echo $business_function_info['Business_Function_Name']; ?></h1>
            <?php echo $business_function_info['Business_Function_Description']; ?>
        </div>
        <div class="span5">
            <div class="span5">
                <h3>Search</h3>
                <form action="search.php" method="post" class="span4" style="margin-left: 0px;">
                    <input type="text" id="search_criteria" class="main-search span3" name="search_criteria" style="margin: 0px;" value="<?php echo (isset($_POST['search_criteria'])) ? $_POST['search_criteria'] : ''; ?>" />
                    <input type="submit" class="btn btn-primary" value="Search" />
                </form>
            </div>
            <hr />
            <div class="span5">

                <?php
                //get business function databases
                $all_business_function_databases = Business_Function::get_business_function_databases($business_function_info['Business_Function_ID']);

                while ($business_function_database = mysqli_fetch_assoc($all_business_function_databases)) {
                    ?>
                    <a href="database_info.php?database_id=<?php echo $business_function_database['Database_ID']; ?>"><i class="icon-th-large"></i> <?php echo $business_function_database['Database_Name']; ?></a> (database)<br />
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    } else {
        //open ul
        echo "<ul>";

        //get all business functions
        $all_business_functions = Business_Function::get_all_business_functions();

        while ($business_function = mysqli_fetch_assoc($all_business_functions)) {
            ?>
            <li><a href="business_functions.php?business_function_id=<?php echo $business_function['Business_Function_ID']; ?>"><?php echo $business_function['Business_Function_Name']; ?></a><br />
            <?php
        }
        echo "</ul>";
    }
    ?>
</div>

<?php include dirname(__FILE__) . '/include/footer.php'; ?>
