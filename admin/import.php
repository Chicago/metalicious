<?php
include dirname(__FILE__) . '/../classes/database.php';
include dirname(__FILE__) . '/../classes/table.php';
include dirname(__FILE__) . '/../classes/variable.php';

function convert_string($string) {
    //converts smart quotes / dashes to normal quotes / dashes.
    $search = array(chr(145), chr(146), chr(147), chr(148), chr(150), chr(151), chr(152));
    $replace = array("'", "'", '"', '"', '-', '-', '-');
    return str_replace($search, $replace, $string);
}

include dirname(__FILE__) . '/include/header.php';
?>
<script>
    $(document).ready(function() {
        document.getElementsByName('search_criteria')[1].focus();
    });
</script>

<h3>Import:</h3>

<?php
if (!isset($_POST['posted'])) {
    ?>
    Sample Files: <a href="./CSR_Meta.txt">CSR_Meta.txt</a> - <a href="./NSR_TBLS.txt">NSR_TBLS.txt</a><br />
    <br />
    Choose your Meta Data file and then click on the submit button.

    <form action="import.php" method="post" enctype="multipart/form-data">
        1. <input type="file" name="database_descriptions_file" /><br /><br />
            <input type="hidden" name="posted" />
        2. <input type="submit" value="submit" />
    </form>

    <hr />
    <br />
    Choose your Table Descriptions file and then click on the submit button.
    <form action="import.php" method="post" enctype="multipart/form-data">
        1. <input type="file" name="table_descriptions_file" /><br /><br />
        2. Select Overwrite / Skip Existing Items:<br />
            <select name="table_descriptions_overwrite_skip" id="table_descriptions_overwrite_skip">
                <option value="Overwrite">Overwrite</option>
                <option value="Skip">Skip</option>
            </select>
            <input type="hidden" name="posted" /><br /><br />
        3. <input type="submit" value="submit" />
    </form>

    <hr />
    <br />
    Choose your Variables .csv file and then click on the submit button.
    <form action="import.php" method="post" enctype="multipart/form-data">
        1. <input type="file" name="variable_descriptions_file" /><br /><br />
        2. Select Overwrite / Skip Existing Items:<br />
            <select name="variable_overwrite_skip" id="variable_overwrite_skip">
                <option value="Overwrite">Overwrite</option>
                <option value="Skip">Skip</option>
            </select>
            <input type="hidden" name="posted" /><br /><br />
        3. <input type="submit" value="submit" />
    </form>
    <?php
} else {
    if (isset($_FILES['database_descriptions_file'])) {
        ?>
        <?php // var_dump($_POST, $_FILES); ?>
        <?php
        //open uploaded file
        $handle = fopen($_FILES['database_descriptions_file']['tmp_name'], "r");

        //all imported elements
        $dbs = array();
        $tables = array();
        $variables = array();

        $parent = "";

        //parentheses
        $parentheses = 0;

        //$count = 500;
        echo "<pre>";
        //scroll through and parse
        while((!feof($handle))) {// && ($count > 0)) {
            //$count--;

            //get the line
            $line = fgets($handle);
            echo $line . "<br />";
            echo "1";

            //open table info
            if ($line == "(\r\n") {
                echo "1aaa";
                $parentheses++;
                //$parentheses
                continue;
            }

            echo "2";
            //close table info
            if ($line == ")\r\n") {
                echo "2aaa";
                $parentheses--;
                continue;
            }

            echo "3";
            //if outside parentheses
            if ($parentheses == 0) {

                echo "4";
                //if there's a period in the line
                echo strpos($line, '.');
                echo (strpos($line, '.') > -1);
                //if (strpos($line, '.') != false) {

                if (strpos($line, '.') > -1) {
                    echo "5";

                    $exploded_line = explode('.', $line);
                    //print_r($exploded_line);

                    //insert into DB array
                    echo "6";
                    if (!in_array(ltrim($exploded_line[0]), $dbs)) {
                        array_push($dbs, ltrim($exploded_line[0]));
                    }

                    echo "7";
                    //insert into Table array
                    if (!in_array($exploded_line[1], $tables)) {
                        array_push($tables,
                                    array(ltrim($exploded_line[0]), str_replace("\r\n", "", $exploded_line[1])));
                    }

                    echo "8";
                    //set parent
                    $parent = str_replace("\r\n", "", $exploded_line[1]);
                }
            } else {
                echo "9";
                //clean left whitespace
                $line = ltrim($line);

                //remove commas
                $line = str_replace(",\r\n", "", $line);

                //get variable name
                $variable_name = substr($line, 0, strpos($line, " "));
                echo $variable_name . "********************";

                echo "10";
                //ignore constraint lines
                if (($variable_name != "CONSTRAINT")
                        && ($variable_name != "REFERENCES")
                        && ($variable_name != "ON"))
                {
                    echo "11";
                    //get variable info
                    $variable_info = ltrim(substr($line, strpos($line, " ")));

                    //insert into Variables array
                    array_push($variables, array($parent,
                                                    $variable_name,
                                                    $variable_info));
                    echo "12";
                }
            }
        }
        echo "</pre>";

        fclose($handle);

        //summary
        echo "DBs: <br /><pre>";
        foreach ($dbs as $key => $val) {
            print "$key = $val\n";

            //open DB
            include dirname(__FILE__) . '/../include/dbconnopen.php';
            $imported_record = mysqli_query($cnnCDD, "Call 0_Import_Database__Create_Database('"
                                                . addslashes($val)
                                                . "','" //. addslashes($description)
                                                . "','" //. addslashes($business_owner)
                                                . "','" //. addslashes($contact_information)
                                                . "','" //. $data_period
                                                . "','" //. addslashes($software_platform)
                                                . "','" //. addslashes($general_accuracy)
                                                . "','" //. addslashes($comments)
                                                . "','" . $_COOKIE['user_id'] . /*addslashes($creator). */ "')");

            if (is_object($imported_record)) { //->num_rows > 0) {
                echo "IMPORTED!\r\n";
            } else {
                echo "NOT IMPORTED... Already exists.\r\n";
            }

            //close DB
            include dirname(__FILE__) . '/../include/dbconnclose.php';
        }
        //print_r($dbs);

        echo "</pre><br />Tables: <br /><pre>";
        foreach ($tables as $key => $val) {
            print "$key\n";
            foreach ($val as $keyy => $vall) {
                print "   $keyy = $vall\n";
            }

            //open DB
            include dirname(__FILE__) . '/../include/dbconnopen.php';
            $imported_record = mysqli_query($cnnCDD, "Call 0_Import_Table__Create_Table('"
                                            . addslashes($val[1])
                                            . "','" //. addslashes($table_description)
                                            . "','" //. addslashes($table_comments)
                                            . "','" . $_COOKIE['user_id'] //. addslashes($creator)
                                            . "','" . addslashes($val[0]) . "')");

            if (is_object($imported_record)) { //->num_rows > 0) {
                echo "IMPORTED!\r\n";
            } else {
                echo "NOT IMPORTED... Already exists.\r\n";
            }

            //close DB
            include dirname(__FILE__) . '/../include/dbconnclose.php';
        }
        //print_r($tables);

        echo "</pre><br />Variables: <br /><pre>";
        foreach ($variables as $key => $val) {
            print "$key\n";
            foreach ($val as $keyy => $vall) {
                print "   $keyy = $vall\n";
            }

            //open DB
            include dirname(__FILE__) . '/../include/dbconnopen.php';
            $imported_record = mysqli_query($cnnCDD, "Call 0_Import_Variable__Create_Variable('"
                                                . addslashes($val[1])
                                                . "','" . addslashes($val[2])
                                                . "','" //. addslashes($variable_length)
                                                . "','" //. addslashes($variable_values)
                                                . "','" //. addslashes($variable_example)
                                                . "','" //. addslashes($variable_comments)
                                                . "','" . $_COOKIE['user_id']//. addslashes($creator)
                                                . "','" . addslashes($val[0]) . "')");

            if (is_object($imported_record)) { //->num_rows > 0) {
                echo "IMPORTED!\r\n";
            } else {
                echo "NOT IMPORTED... Already exists.\r\n";
            }

            //close DB
            include dirname(__FILE__) . '/../include/dbconnclose.php';
        }
        //print_r($variables);
        echo "</pre>";
        
        echo "<a href=\"import.php\">Import Another</a>";

        
    } else if (isset($_FILES['table_descriptions_file'])) {
        if ($_POST['table_descriptions_overwrite_skip'] == 'Overwrite') {
            echo "<b>Overwriting Existing Records...</b><br /><br />";
        } else {
            echo "<b>Skipping Existing Records...</b><br /><br />";
        }
        
        //import table descriptions
        $handle = fopen($_FILES['table_descriptions_file']['tmp_name'], "r");
        
        //scroll through and parse
        while (($data = fgetcsv($handle, ",")) !== false) {
            //test for correct formatting
            if (isset($data[4])) {
                die("This .csv file doesn't seem to be in the correct format. Please go back and try again.");
            }
        /*
        //scroll through and parse
        while((!feof($handle))) {// && ($count > 0)) {
            //$count--;

            //get the line
            $line = fgets($handle);
            echo $line . "<br />";
            
            $pos = strpos($line, ",");
            $table_name = substr($line, 0, $pos);
            $table_description = substr($line, ($pos + 1));
            */
            
            //open DB
            include dirname(__FILE__) . '/../include/dbconnopen.php';
            
            //overwrite / skip existing records
            if ($_POST['table_descriptions_overwrite_skip'] == 'Overwrite') {
                //OVERWRITE EXISTING RECORDS
                $imported_record = mysqli_query($cnnCDD, "Call 0_Import_Table__Table_Descriptions_OVERWRITE('"
                                                    . addslashes($data[0])
                                                    . "','" . addslashes($data[1])
                                                    . "','" . addslashes($data[2])
                                                    . "','" . addslashes(((isset($data[3])) ? $data[3] : ""))
                                                    . "','" . $_COOKIE['user_id'] //. addslashes($creator)
                                                    . "')");
                
            } else if ($_POST['table_descriptions_overwrite_skip'] == 'Skip') {
                //SKIP EXISTING RECORDS
                $imported_record = mysqli_query($cnnCDD, "Call 0_Import_Table__Table_Descriptions_SKIP('"
                                                    . addslashes($data[0])
                                                    . "','" . addslashes($data[1])
                                                    . "','" . addslashes($data[2])
                                                    . "','" . addslashes(((isset($data[3])) ? $data[3] : ""))
                                                    . "','" . $_COOKIE['user_id'] //. addslashes($creator)
                                                    . "')");
            }
            
            echo $data[0] . " -> " . $data[1] . " -> " . $data[2];
            
            if (is_object($imported_record)) { //->num_rows > 0) {
                echo "<br />IMPORTED!<br /><br />";
            } else {
                echo "<br />NOT IMPORTED... Already exists.<br /><br />";
            }
            
            //close DB
            include dirname(__FILE__) . '/../include/dbconnclose.php';
        }
        
        echo "<a href=\"import.php\">Import Another</a>";
        
        
        
    //VARIABLE CSV FILE
    } else if (isset($_FILES['variable_descriptions_file'])) {
        if ($_POST['variable_overwrite_skip'] == 'Overwrite') {
            echo "<b>Overwriting Existing Records...</b><br /><br />";
        } else {
            echo "<b>Skipping Existing Records...</b><br /><br />";
        }
        
        //import variable descriptions
        $handle = fopen($_FILES['variable_descriptions_file']['tmp_name'], "r");
        
        $row = 1;
        
        //scroll through and parse
        while (($data = fgetcsv($handle, ",")) !== false) {
            //test for correct formatting
            if (!isset($data[4])) {
                die("This .csv file doesn't seem to be in the correct format. Please go back and try again.");
            }
            
            echo "Database: " . $data[0] . "<br />";
            echo "Table: " . $data[1] . "<br />";
            echo "Column / Field: " . $data[2] . "<br />";
            echo "Type: " . $data[3] . "<br />";
            echo "Length: " . $data[4] . "<br />";
            echo "Value_Range: " . ((isset($data[5])) ? convert_string($data[5]) : "") . "<br />";
            echo "Description: " . ((isset($data[6])) ? $data[6] : "") . "<br />";
            echo "Examples: " . ((isset($data[7])) ? $data[7] : "") . "<br />";
            echo "Comments: " . ((isset($data[8])) ? $data[8] : "") . "<br /><br />";
            
            //open DB
            include dirname(__FILE__) . '/../include/dbconnopen.php';
            
            //overwrite / skip existing records
            if ($_POST['variable_overwrite_skip'] == 'Overwrite') {
                //OVERWRITE EXISTING RECORDS
                $imported_record = mysqli_query($cnnCDD, "Call 1_Import_Variable__Create_Variable_OVERWRITE('"
                                                    . addslashes($data[0])
                                                    . "','" . addslashes($data[1])
                                                    . "','" . addslashes($data[2])
                                                    . "','" . addslashes($data[3])
                                                    . "','" . addslashes($data[4])
                                                    . "','" . addslashes(((isset($data[5])) ? convert_string($data[5]) : ""))
                                                    . "','" . addslashes(((isset($data[6])) ? $data[6] : ""))
                                                    . "','" . addslashes(((isset($data[7])) ? $data[7] : ""))
                                                    . "','" . addslashes(((isset($data[8])) ? $data[8] : ""))
                                                    . "','" . $_COOKIE['user_id'] /* . addslashes($creator) */ . "')");
                
            } else {
                //SKIP EXISTING RECORDS
                $imported_record = mysqli_query($cnnCDD, "Call 1_Import_Variable__Create_Variable_SKIP('"
                                                    . addslashes($data[0])
                                                    . "','" . addslashes($data[1])
                                                    . "','" . addslashes($data[2])
                                                    . "','" . addslashes($data[3])
                                                    . "','" . addslashes($data[4])
                                                    . "','" . addslashes(((isset($data[5])) ? convert_string($data[5]) : ""))
                                                    . "','" . addslashes(((isset($data[6])) ? $data[6] : ""))
                                                    . "','" . addslashes(((isset($data[7])) ? $data[7] : ""))
                                                    . "','" . addslashes(((isset($data[8])) ? $data[8] : ""))
                                                    . "','" . $_COOKIE['user_id'] /* . addslashes($creator) */ . "')");
            }

            if (is_object($imported_record)) { //->num_rows > 0) {
                echo "<b style=\"color: #0f0;\">IMPORTED!</b><hr />";
            } else {
                echo "<b style=\"color: #f00;\">NOT IMPORTED...<br />May already exist or corresponding table / database doesn't exist.</b><hr />";
            }
            
            //close DB
            include dirname(__FILE__) . '/../include/dbconnclose.php';
        }
        
        echo "<a href=\"import.php\">Import Another</a>";

    }
}
?>

<div style="margin-left: 20px;">
    <?php
    /*
    while ($result_element = mysqli_fetch_assoc($search_results)) {
        //if element is a database
        if ($result_element['Element_Type'] == 'Database') {
            $database = Database::get_database_info($result_element['Element_ID']);
            ?>
            <a href="../database_info.php?database_id=<?php echo $database['Database_ID']; ?>"><i class="icon-th-large"></i> <?php echo $database['Database_Name']; ?></a> (database)<br />
            <?php
        } else if ($result_element['Element_Type'] == 'Table') {
            $table = Table::get_table_info($result_element['Element_ID']);
            ?>
            <a href="../table_info.php?table_id=<?php echo $table['Table_ID']; ?>"><i class="icon-th"></i> <?php echo $table['Table_Name']; ?></a> (table)<br />
            <?php
        } else if ($result_element['Element_Type'] == 'Variable') {
            $variable = Variable::get_variable_info($result_element['Element_ID']);
            ?>
            <a href="../variable_info.php?variable_id=<?php echo $variable['Variable_ID']; ?>"><i class="icon-asterisk"></i> <?php echo $variable['Variable_Name']; ?></a> (variable)<br />
            <?php
        }
    }
     
     */
    ?>
</div>

<?php include 'include/footer.php'; ?>
