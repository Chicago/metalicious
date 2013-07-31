<?php
include dirname(__FILE__) . '/classes/business_function.php';
include dirname(__FILE__) . '/classes/database.php';
include dirname(__FILE__) . '/classes/table.php';
include dirname(__FILE__) . '/classes/variable.php';

include dirname(__FILE__) . '/include/header.php';

?>

    <script>
        $(document).ready(function() {
            document.getElementsByName('search_criteria')[1].focus();
        });
    </script>

    <div class="row-fluid">
        <h1>Search</h1>
        <form action="search.php" method="post">
            <input type="text" id="search_criteria" class="main-search span5" name="search_criteria" style="margin: 0px;" value="<?php echo (isset($_POST['search_criteria'])) ? $_POST['search_criteria'] : ''; ?>" />
            <input type="submit" class="btn btn-primary" value="Search" />
        </form>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <h1>Explore the Dictionary</h1>
            <h3>Most Viewed Items</h3>
            <ul>
                <?php
                //open DB
                include dirname(__FILE__) . '/include/dbconnopen.php';
                $most_viewed_results = mysqli_query($cnnCDD, "Call Main_Most_Viewed()");

                //close DB
                include dirname(__FILE__) . '/include/dbconnclose.php';
                ?>
               <?php
                while ($result_element = mysqli_fetch_assoc($most_viewed_results)) {
                    //if element is a database
                    if ($result_element['Element_Type'] == 'Database') {
                        $database = Database::get_database_info($result_element['Element_ID']);
                        ?>
                        <li><a href="database_info.php?database_id=<?php echo $database['Database_ID']; ?>"><i class="icon-th-large"></i> <?php echo $database['Database_Name']; ?></a> (database)</li>
                        <?php
                    } else if ($result_element['Element_Type'] == 'Table') {
                        $table = Table::get_table_info($result_element['Element_ID']);
                        ?>
                        <li><a href="table_info.php?table_id=<?php echo $table['Table_ID']; ?>"><i class="icon-th"></i> <?php echo $table['Table_Name']; ?></a> (table)</li>
                        <?php
                    } else if ($result_element['Element_Type'] == 'Variable') {
                        $variable = Variable::get_variable_info($result_element['Element_ID']);
                        ?>
                        <li><a href="variable_info.php?variable_id=<?php echo $variable['Variable_ID']; ?>"><i class="icon-asterisk"></i> <?php echo $variable['Variable_Name']; ?></a> (variable)</li>
                        <?php
                    }
                }
                ?>
            </ul>
            <?
            //print recent items
            if (isset($_COOKIE['recently_viewed'])) {
                ?>
                <h3>Recent Items</h3>
                <ul>
                    <?php
                    for ($i = 0; $i <= (sizeof($_COOKIE['recently_viewed']) - 1); $i++) {
                        echo stripslashes($_COOKIE['recently_viewed'][$i]);
                    }
                    ?>
                </ul>
                <?php
            }
            ?>
            <h3>Business Functions</h3>
            <ul>
                <?php
                //get all databases
                $all_business_functions = Business_Function::get_all_business_functions();

                while ($business_function = mysqli_fetch_assoc($all_business_functions)) {
                    ?>
                    <li><a href="business_functions.php?business_function_id=<?php echo $business_function['Business_Function_ID']; ?>"><?php echo $business_function['Business_Function_Name']; ?></a><br />
                    <?php
                }
                ?>
            </ul>
        </div>
        <div class="span6">
            <h1>About Metalicious</h1>
            <p>
                Metalicious is an open-source, web-based data dictionary that is designed to capture and display metadata from databases, tables, and fields for platforms with one or more datbases. Users may customize and deploy Metalicious as an internal or public data dictionary website. 
            </p>
	    <p>
		This project is a generic release of the City of Chicago's <a href="http://datadictionary.cityofchicago.org">data dictionary</a>.
	   </p>
        </div>
    </div> <!-- /row -->

<?php include dirname(__FILE__) . '/include/footer.php'; ?>
